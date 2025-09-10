<?php
header("Content-Type: application/json");

$replicateToken = getenv('REPLICATE_API_TOKEN');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $predictionId = $input['prediction_id'] ?? null;

    if (!$predictionId) {
        echo json_encode(["error" => "Missing prediction_id"]);
        exit;
    }

    $url = "https://api.replicate.com/v1/predictions/" . $predictionId;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $replicateToken"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    $status = $result['status'] ?? 'unknown';

    if ($status === 'succeeded') {
        echo json_encode([
            "status" => "succeeded",
            "output" => $result['output'] ?? null
        ]);
    } elseif ($status === 'failed') {
        echo json_encode([
            "status" => "failed",
            "error" => $result['error'] ?? 'Unknown error'
        ]);
    } else {
        echo json_encode([
            "status" => $status
        ]);
    }
} else {
    echo json_encode(["error" => "Invalid method"]);
}
?>
