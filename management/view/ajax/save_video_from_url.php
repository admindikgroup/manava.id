<?php
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$videoUrl = $input['video_url'] ?? null;
$id_user = $input['id_user'] ?? null;
$id_chat = $input['id_dg_chat_ai_title'] ?? null;

if (!$videoUrl || !$id_user || !$id_chat) {
    echo json_encode(["error" => "Missing data"]);
    exit;
}

$ext = 'mp4';
$saveDir = __DIR__ . '/../../storage/ai/video/';
$publicPath = 'storage/ai/video/';

// Pastikan folder ada
if (!is_dir($saveDir)) {
    mkdir($saveDir, 0755, true);
}

// Buat nama file
$filename = "mng_ai-{$id_user}-{$id_chat}-" . uniqid() . '.' . $ext;
$savePath = $saveDir . $filename;

// Ambil data video
$videoData = file_get_contents($videoUrl);

if ($videoData !== false) {
    file_put_contents($savePath, $videoData);
    $localUrl = $publicPath . $filename;

    echo json_encode([
        "status" => "saved",
        "local_url" => $localUrl
    ]);
} else {
    echo json_encode(["error" => "Failed to download video"]);
}
