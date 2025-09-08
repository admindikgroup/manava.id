<?php
include '../../controller/conn.php';
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

$data = json_decode(file_get_contents("php://input"), true);

$id_dg_chat_ai_title = $data['id_dg_chat_ai_title'];
$status_chat = $data['status_chat'];
$chat_detail = mysqli_real_escape_string($db2, $data['chat_detail']);

$query = "INSERT INTO dg_chat_ai (id_dg_chat_ai_title, status_chat, chat_detail, date_created)
          VALUES ('$id_dg_chat_ai_title', '$status_chat', '$chat_detail', NOW())";

if (mysqli_query($db2, $query)) {
    echo json_encode(['success' => true, 'message' => 'Chat saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save chat']);
}
?>
