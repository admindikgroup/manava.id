<?php
include '../../controller/conn.php';
header('Content-Type: application/json');
date_default_timezone_set('Asia/Jakarta');

$data = json_decode(file_get_contents("php://input"), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON input: ' . json_last_error_msg()
    ]);
    exit;
}


$id_dg_chat_ai       = isset($data['id_dg_chat_ai']) ? (int)$data['id_dg_chat_ai'] : 0;
$id_dg_chat_ai_title = mysqli_real_escape_string($db2, $data['id_dg_chat_ai_title']);
$status_chat         = mysqli_real_escape_string($db2, $data['status_chat']);
$chat_detail         = mysqli_real_escape_string($db2, $data['chat_detail']);

if ($id_dg_chat_ai > 0) {
    // 🔹 UPDATE data
    $query = "
        UPDATE dg_chat_ai 
        SET id_dg_chat_ai_title = '$id_dg_chat_ai_title',
            status_chat = '$status_chat',
            chat_detail = '$chat_detail'
        WHERE id_dg_chat_ai = '$id_dg_chat_ai'
    ";
} else {
    // 🔹 INSERT baru
    $query = "
        INSERT INTO dg_chat_ai (id_dg_chat_ai_title, status_chat, chat_detail, date_created)
        VALUES ('$id_dg_chat_ai_title', '$status_chat', '$chat_detail', NOW())
    ";
}

if (mysqli_query($db2, $query)) {
    echo json_encode([
        'success' => true,
        'message' => ($id_dg_chat_ai > 0 ? 'Chat updated successfully' : 'Chat saved successfully'),
        'id_dg_chat_ai' => ($id_dg_chat_ai > 0 ? $id_dg_chat_ai : mysqli_insert_id($db2))
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . mysqli_error($db2)
    ]);
}
?>
