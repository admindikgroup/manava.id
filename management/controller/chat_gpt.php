<?php
// Replace with your OpenAI API key
$apiKey = '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';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prompt = $_POST['prompt'] ?? '';

    if (empty($prompt)) {
        echo json_encode(['success' => false, 'message' => 'Prompt is empty.']);
        exit;
    }

    // Prepare the OpenAI API request
    $url = "https://api.openai.com/v1/completions";
    $data = [
        'model' => 'text-davinci-003', // or other model
        'prompt' => $prompt,
        'max_tokens' => 150,
        'temperature' => 0.7,
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $apiKey\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch AI response.']);
        exit;
    }

    $response = json_decode($result, true);
    echo json_encode(['success' => true, 'message' => $response['choices'][0]['text']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
