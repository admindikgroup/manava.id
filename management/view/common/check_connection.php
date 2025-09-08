<?php
header('Content-Type: application/json');

// Anda bisa mengganti logika ini dengan pemeriksaan koneksi sebenarnya
$response = ['connected' => true]; // atau false jika tidak terhubung

echo json_encode($response);
?>