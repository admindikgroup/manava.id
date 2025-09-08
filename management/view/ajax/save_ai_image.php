<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$imageUrl = $data['url'] ?? '';

if (!$imageUrl) {
    echo json_encode(["error" => "No URL provided"]);
    exit;
}

$folder = "../../ai_images/";
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

// Ambil nomor file terakhir
$existingFiles = array_filter(scandir($folder), function($file) {
    return preg_match('/^\d+\.(jpg|jpeg|png|gif)$/i', $file);
});
$numbers = array_map(function($file) {
    return (int) preg_replace('/\D/', '', $file);
}, $existingFiles);
$nextNumber = $numbers ? max($numbers) + 1 : 1;

$ext = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
if (!$ext) $ext = 'jpg'; // fallback
$saveAs = $nextNumber . '.' . $ext;
$savePath = $folder . $saveAs;

// Async save, don't block
file_put_contents($savePath, file_get_contents($imageUrl));

// Return file name only
echo json_encode(["file_name" => $saveAs]);
exit;
