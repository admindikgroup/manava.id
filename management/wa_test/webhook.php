<?php
// Token verifikasi yang Anda tentukan sendiri di Facebook Developer
$verify_token = "dikgroup123!"; 

// Jika ada permintaan GET untuk verifikasi webhook
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_mode']) && $_GET['hub_mode'] === 'subscribe') {
    if ($_GET['hub_verify_token'] === $verify_token) {
        echo $_GET['hub_challenge']; // Kirim kembali challenge untuk verifikasi
        exit;
    } else {
        http_response_code(403);
        echo "Invalid verification token";
        exit;
    }
}

// Ambil data JSON dari WhatsApp API
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Simpan log untuk debugging (Opsional)
file_put_contents("log.txt", print_r($data, true), FILE_APPEND);

// Cek apakah ada pesan masuk
if (isset($data['entry'][0]['changes'][0]['value']['messages'])) {
    $message = $data['entry'][0]['changes'][0]['value']['messages'][0];
    $from = $message['from']; // Nomor pengirim
    $text = $message['text']['body']; // Isi pesan

    // Kirim respons otomatis (Opsional)
    $response = [
        "messaging_product" => "whatsapp",
        "to" => $from,
        "type" => "text",
        "text" => ["body" => "Pesan Anda: " . $text]
    ];

    $token = "Bearer EAANoyCD3Jo8BO9byCsNzpxZCDUwLIp1zFIZCiwSYUiyX1SxlzYzbsUCputPdKslUwcEyQ73n4b9n4ZB69uJvvBeGpaSZCW8NI2ocpTt98Ittp1Qj0B0EkhJrZCOlEtEJ2W1fi5maz9iZCN1NFLeqeZAmMHdBgokYKM4YW5NOozZAjMiNS3iDbXyrGnD3BU09eygPjAZDZD"; // Ganti dengan token API WhatsApp Anda
    $phone_number_id = "626499337217094"; // ID Nomor WhatsApp Anda
    $url = "https://graph.facebook.com/v22.0/{$phone_number_id}/messages";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

$response = curl_exec($ch);
file_put_contents("log_curl_response.txt", $response, FILE_APPEND);

// WhatsApp memerlukan respons 200 agar webhook tidak dianggap error
http_response_code(200);
?>
