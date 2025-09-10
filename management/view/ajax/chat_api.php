<?php
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

header("Content-Type: application/json");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = $_ENV['API_KEY'];
    $replicateToken = $_ENV['REPLICATE_API_TOKEN'];

    $inputData = json_decode(file_get_contents("php://input"), true);
    $prompt = $inputData['prompt'] ?? '';
    $aiType = $inputData['ai_type'] ?? 'free';
    $upscale = $inputData['upscale'] ?? 'default';
    $aspectRatio = $inputData['aspect_ratio'] ?? '1:1';
    $id_chat = $inputData['id_dg_chat_ai_title'] ?? null;
    $id_user = $inputData['id_user'] ?? null;
    $type_data = $inputData['type_data'] ?? null;
    

    if (empty($prompt)) {
        echo json_encode(["error" => "Prompt is empty"]);
        exit;
    }


    $startImage = null;

    // Cek apakah ada image lokal di prompt
    if (preg_match('/storage\/upload\/img\/[^\s"]+\.(jpg|jpeg|png|gif|webp)/i', $prompt, $matches)) {
        $startImage = "https://dikgroup.id/management/" . $matches[0]; // Tambahkan domain
    }
    
    // Cek juga jika image sudah berupa URL absolut
    if (preg_match('/https?:\/\/[^\s"]+\.(jpg|jpeg|png|gif|webp)/i', $prompt, $matches)) {
        $startImage = $matches[0]; // Override jika user sudah kasih full URL
    }


    
    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
    $data = json_encode(["contents" => [["parts" => [["text" => $prompt]]]]]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $result = json_decode($response, true);
        $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response available';

        preg_match_all('/!\[MEDIA]\[([^\]]+)]/', $reply, $matches);
        $imagePrompts = $matches[1] ?? [];
        $placeholders = $matches[0] ?? [];

        foreach ($imagePrompts as $index => $imgPrompt) {
            $imageUrl = null;

            if ($aiType === 'diffusion') {
                // Hitung width dan height berdasarkan aspect ratio
                list($w, $h) = explode(':', $aspectRatio);
                $ratio = 1024 / max($w, $h);
                $width = intval($w * $ratio);
                $height = intval($h * $ratio);

                $postData = json_encode([
                    "version" => "ac732df83cea7fff18b8472768c88ad041fa750ff7682a21affe81863cbe77e4",
                    "input" => [
                        "prompt" => $imgPrompt,
                        "scheduler" => "K_EULER",
                        "width" => $width,
                        "height" => $height
                    ]
                ]);
            } elseif ($aiType === 'free') {
                $urlEncodedPrompt = urlencode($imgPrompt);
                $imageUrl = "https://image.pollinations.ai/prompt/$urlEncodedPrompt";
                if ($imageUrl) {
                    $saveDir = __DIR__ . '/../../storage/ai/img/';
                    $publicPath = 'storage/ai/img/';
                    $ext = 'jpg';

                    $filename = "free-" . uniqid() . '.' . $ext;
                    $savePath = $saveDir . $filename;

                    $imageData = file_get_contents($imageUrl);
                    if ($imageData !== false) {
                        file_put_contents($savePath, $imageData);
                        $localUrl = $publicPath . $filename;
                        $reply = str_replace($placeholders[$index], '<img style="max-width: 200px;" src="' . $localUrl . '" alt="' . htmlspecialchars($imgPrompt) . '" />', $reply);
                    } else {
                        $reply = str_replace($placeholders[$index], "[Failed to download image for '$imgPrompt']", $reply);
                    }
                }

            } elseif ($aiType === 'black-forest') {
                // black-forest
                $postData = json_encode([
                    "version" => "black-forest-labs/flux-schnell",
                    "input" => [
                        "prompt" => $imgPrompt,
                        "aspect_ratio" => $aspectRatio,
                        "output_format" => "jpg"
                    ]
                ]);
            } elseif ($aiType === 'kling') {
                $inputDataKling = [
                    "prompt" => $imgPrompt,
                    "duration" => 5,
                    "cfg_scale" => 0.5,
                    "aspect_ratio" => $aspectRatio,
                    "negative_prompt" => ""
                ];

                // Tambahkan start_image hanya jika tidak null
                if (!empty($startImage)) {
                    $inputDataKling["start_image"] = $startImage;
                }

                $postData = json_encode([
                    "version" => "kwaivgi/kling-v1.6-standard",
                    "input" => $inputDataKling
                ]);
            }

            if ($aiType !== 'free') {
                $ch = curl_init("https://api.replicate.com/v1/predictions");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer $replicateToken",
                    "Content-Type: application/json",
                    "Prefer: wait"
                ]);
                $response = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($response, true);

                if ($aiType === 'diffusion') {
                    $imageUrl = $result['output'][0] ?? null;
                } elseif ($aiType === 'black-forest') {
                    $pollUrl = $result['urls']['get'] ?? null;
                    if ($pollUrl) {
                        $maxTries = 15;
                        $try = 0;
                        do {
                            sleep(2);
                            $ch = curl_init($pollUrl);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                "Authorization: Bearer $replicateToken"
                            ]);
                            $pollResponse = curl_exec($ch);
                            curl_close($ch);
                            $pollResult = json_decode($pollResponse, true);

                            if (($pollResult['status'] ?? '') === 'succeeded') {
                                $imageUrl = $pollResult['output'][0] ?? null;
                                break;
                            } elseif (($pollResult['status'] ?? '') === 'failed') {
                                break;
                            }
                            $try++;
                        } while ($try < $maxTries);
                    }
                } elseif ($aiType === 'kling') {
                    $predictionId = $result['id'] ?? null;
                    echo json_encode([
                        "status" => "starting",
                        "prediction_id" => $predictionId,
                        "poll_url" => $result['urls']['get'] ?? null,
                        "response" => $reply  // ✅ Kembalikan juga teks AI
                    ]);
                    exit;

                }

            }

            if ($imageUrl) {
                // Upscale jika bukan free dan upscale != default
                if ($aiType !== 'free' && $upscale !== 'default') {
                    $scale = intval($upscale);
                    $upscaleData = json_encode([
                        "version" => "4f7eb3da655b5182e559d50a0437440f242992d47e5e20bd82829a79dee61ff3",
                        "input" => [
                            "image" => $imageUrl,
                            "scale" => $scale
                        ]
                    ]);

                    $ch = curl_init("https://api.replicate.com/v1/predictions");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $upscaleData);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Authorization: Bearer $replicateToken",
                        "Content-Type: application/json",
                        "Prefer: wait"
                    ]);

                    $upscaleResponse = curl_exec($ch);
                    curl_close($ch);

                    $upscaleResult = json_decode($upscaleResponse, true);
                    $imageUrl = $upscaleResult['output'] ?? $imageUrl;
                }

                if ($aiType === 'kling') {
                    $saveDir = __DIR__ . '/../../storage/ai/video/';
                    $publicPath = 'storage/ai/video/';
                    $ext = 'mp4';
                } else {
                    $saveDir = __DIR__ . '/../../storage/ai/img/';
                    $publicPath = 'storage/ai/img/';
                    $ext = 'jpg';
                }
                


                $filename = '';
                
                // Cek kondisi type_data
                if ($type_data == 'mng_ai' && $id_user && $id_chat) {
                    $filename = "mng_ai-{$id_user}-{$id_chat}-" . uniqid() . '.' . $ext;
                } else {
                    // fallback ke penamaan numerik
                    $existingFiles = glob($saveDir . '*.jpg');
                    $numbers = array_map(fn($file) => (int)basename($file, '.jpg'), $existingFiles);
                    $nextNumber = $numbers ? max($numbers) + 1 : 1;
                
                    $filename = $nextNumber . '.' . $ext;
                }
                
                $savePath = $saveDir . $filename;
                
                $imageData = file_get_contents($imageUrl);

                
                if ($imageData !== false) {
                    file_put_contents($savePath, $imageData);
                    $localUrl = $publicPath . $filename;

                    if ($aiType == 'kling') {
                        $reply = str_replace($placeholders[$index], '<video style="max-width: 200px;" controls><source src="' . $localUrl . '" type="video/mp4">Your browser does not support the video tag.</video>', $reply);
                    } else {
                        $reply = str_replace($placeholders[$index], '<img style="max-width: 200px;" src="' . $localUrl . '" alt="' . htmlspecialchars($imgPrompt) . '" />', $reply);
                    }
                    
                } else {
                    $reply = str_replace($placeholders[$index], "[Failed to download image for '$imgPrompt']", $reply);
                }
            } else {
                $print = isset($result) ? print_r($result, true) : 'No result';
                if ($aiType === 'kling') {
                    $reply = str_replace($placeholders[$index], "[Failed to generate video for '$imgPrompt'] \nResponse: $print", $reply);
                } else{
                    $reply = str_replace($placeholders[$index], "[Failed to generate image for '$imgPrompt'] \nResponse: $print", $reply);
                }
                
            }
        }

        echo json_encode(["response" => $reply]);
    } else {
        echo json_encode(["error" => "Failed to fetch response from AI. HTTP Code: $httpCode"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
