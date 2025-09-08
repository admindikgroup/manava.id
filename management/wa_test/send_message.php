<?php
$token = "Bearer EAANoyCD3Jo8BO9byCsNzpxZCDUwLIp1zFIZCiwSYUiyX1SxlzYzbsUCputPdKslUwcEyQ73n4b9n4ZB69uJvvBeGpaSZCW8NI2ocpTt98Ittp1Qj0B0EkhJrZCOlEtEJ2W1fi5maz9iZCN1NFLeqeZAmMHdBgokYKM4YW5NOozZAjMiNS3iDbXyrGnD3BU09eygPjAZDZD"; // Ganti dengan token asli kamu
$phone_number_id = "626499337217094"; // Ganti dengan Phone Number ID kamu

$phone = $_POST['phone'];
$message = $_POST['message'];

$url = "https://graph.facebook.com/v22.0/$phone_number_id/messages";

$data = [
    "messaging_product" => "whatsapp",
    "to" => $phone,
    "type" => "text",
    "text" => [ "body" => $message ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: $token",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo "Respons dari API:<br>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";
?>
