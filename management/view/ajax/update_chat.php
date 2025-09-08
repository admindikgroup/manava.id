<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$id_chat = $_POST['id_dg_chat_ai_title'];
$title_chat = $_POST['title_chat'];

if (!$id_chat || !$title_chat) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$query = "UPDATE dg_chat_ai_title SET title_chat = '$title_chat' WHERE id_dg_chat_ai_title = '$id_chat'";
if (mysqli_query($db2, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update chat title']);
}
?>
