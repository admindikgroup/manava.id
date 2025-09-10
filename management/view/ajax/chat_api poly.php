<?php
header("Content-Type: application/json");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = "AIzaSyBgQCp2jJ45oWWMhMmcM6JQMfr0ivwdvPs";

    // Ambil prompt dari request AJAX
    $inputData = json_decode(file_get_contents("php://input"), true);
    $prompt = $inputData['prompt'] ?? '';

    if (empty($prompt)) {
        echo json_encode(["error" => "Prompt is empty"]);
        exit;
    }

    // Cek apakah prompt mengandung kata kunci visual/gambar
    $promptLower = strtolower($prompt);
    $isImageRequest = preg_match('/
        gambar|foto|ilustrasi|lukisan|sketsa|visualkan|buat visual|
        draw|drawing|paint|picture|image|generate image|create illustration|visualize|sketch|artwork|make a picture|
        图像|画|照片|绘图|插图|生成图像|视觉化|
        画像|写真|描く|イラスト|ビジュアル|スケッチ|
        그림|사진|그리다|스케치|이미지|시각화|
        gambarkeun|lukisan|gambar|potret|skétch
    /iux', $promptLower);

    if ($isImageRequest) {
        // Gunakan Pollinations.AI untuk generate gambar
        $encodedPrompt = urlencode($prompt);
        $imageUrl = "https://image.pollinations.ai/prompt/$encodedPrompt";

        echo json_encode(["image_url" => $imageUrl]);
        exit;
    }

    // Jika bukan permintaan gambar, lanjutkan ke Gemini
    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

    // Persiapkan data untuk dikirim ke API Gemini
    $data = json_encode([
        "contents" => [["parts" => [["text" => $prompt]]]]
    ]);

    // Kirim permintaan ke API menggunakan cURL
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

        echo json_encode(["response" => $reply]);
    } else {
        echo json_encode(["error" => "Failed to fetch response from AI. HTTP Code: $httpCode"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
