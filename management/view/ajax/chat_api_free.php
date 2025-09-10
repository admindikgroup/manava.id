<?php
header("Content-Type: application/json");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = "AIzaSyBgQCp2jJ45oWWMhMmcM6JQMfr0ivwdvPs";
    $inputData = json_decode(file_get_contents("php://input"), true);
    $prompt = $inputData['prompt'] ?? '';

    if (empty($prompt)) {
        echo json_encode(["error" => "Prompt is empty"]);
        exit;
    }

    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

    // Kirim prompt langsung ke Gemini
    $data = json_encode([
        "contents" => [["parts" => [["text" => $prompt]]]]
    ]);

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

        // Cek apakah ada tag ![IMG][...]
        preg_match_all('/!\[IMG]\[([^\]]+)]/', $reply, $matches);
        $imagePrompts = $matches[1] ?? [];
        $placeholders = $matches[0] ?? [];

        // Ganti setiap ![IMG][prompt] dengan gambar dari Pollinations
        foreach ($imagePrompts as $index => $imgPrompt) {
            $urlEncodedPrompt = urlencode($imgPrompt);
            $imageUrl = "https://image.pollinations.ai/prompt/$urlEncodedPrompt";

            // Replace placeholder dengan gambar Markdown
            $reply = str_replace($placeholders[$index], "\n![Alt Image]($imageUrl)\n", $reply);
        }

        echo json_encode(["response" => $reply]);
    } else {
        echo json_encode(["error" => "Failed to fetch response from AI. HTTP Code: $httpCode"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
