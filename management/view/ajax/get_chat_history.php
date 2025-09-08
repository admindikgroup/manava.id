<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id_dg_chat_ai_title = $data['id_dg_chat_ai_title'] ?? null;

if (!$id_dg_chat_ai_title) {
    echo json_encode(['success' => false, 'message' => 'Invalid chat title ID']);
    exit;
}

$query = "SELECT status_chat, chat_detail FROM dg_chat_ai WHERE id_dg_chat_ai_title = ?";
$stmt = $db2->prepare($query);
$stmt->bind_param("i", $id_dg_chat_ai_title);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = [
        'status' => $row['status_chat'], // 1 = user, 2 = AI
        'message' => $row['chat_detail']
    ];
}

echo json_encode(['success' => true, 'history' => $history]);
?>
