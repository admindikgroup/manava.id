<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$id_user = $_POST['id_user']; 
$search = isset($_POST['search']) ? trim($_POST['search']) : ''; // Ambil teks pencarian

if (!$id_user) {
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

// Query untuk mengambil chat list berdasarkan last chat dan search (jika ada)
$query = "
    SELECT t.id_dg_chat_ai_title, t.title_chat, MAX(c.date_created) AS last_activity
    FROM dg_chat_ai_title t
    LEFT JOIN dg_chat_ai c ON t.id_dg_chat_ai_title = c.id_dg_chat_ai_title
    WHERE t.id_dg_user = $id_user 
";

// Jika ada teks pencarian, tambahkan filter
if (!empty($search)) {
    $search = mysqli_real_escape_string($db2, $search);
    $query .= " AND t.title_chat LIKE '%$search%'";
}

$query .= " GROUP BY t.id_dg_chat_ai_title, t.title_chat
            ORDER BY CASE WHEN MAX(c.date_created) IS NULL THEN 0 ELSE 1 END,
            MAX(c.date_created) DESC";

$result = mysqli_query($db2, $query);

$chats = [];
while ($row = mysqli_fetch_assoc($result)) {
    $chats[] = $row;
}

if ($chats) {
    echo json_encode(['success' => true, 'data' => $chats]);
} else {
    echo json_encode(['success' => false, 'message' => 'No chats found.']);
}
?>
