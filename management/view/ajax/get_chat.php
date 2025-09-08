<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$id_dg_chat_ai_title = $_POST['id_dg_chat_ai_title'];

$query = "SELECT * FROM dg_chat_ai WHERE id_dg_chat_ai_title = '$id_dg_chat_ai_title' ORDER BY date_created ASC";
$result = mysqli_query($db2, $query);

$chats = [];
while ($row = mysqli_fetch_assoc($result)) {
    $chats[] = $row;
}

echo json_encode(['success' => true, 'data' => $chats]);
?>
