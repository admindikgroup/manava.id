<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$title_chat = $_POST['title_chat'];
$id_user = $_POST['id_user'];

// Validasi input
if (!$title_chat || !$id_user) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Simpan ke database
$query = "INSERT INTO dg_chat_ai_title (title_chat, id_dg_user) VALUES (?, ?)";
$stmt = mysqli_prepare($db2, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $title_chat, $id_user);
    if (mysqli_stmt_execute($stmt)) {
        $newChatId = mysqli_insert_id($db2);

        // Ambil kembali data chat yang baru saja dibuat
        $querySelect = "SELECT * FROM dg_chat_ai_title WHERE id_dg_chat_ai_title = ?";
        $stmtSelect = mysqli_prepare($db2, $querySelect);

        if ($stmtSelect) {
            mysqli_stmt_bind_param($stmtSelect, "i", $newChatId);
            mysqli_stmt_execute($stmtSelect);
            $result = mysqli_stmt_get_result($stmtSelect);
            $chatData = mysqli_fetch_assoc($result);

            echo json_encode([
                'success' => true,
                'id_dg_chat_ai_title' => $newChatId,
                'chat_data' => $chatData // Mengembalikan data lengkap chat baru
            ]);
            exit;
        }
    }
}

// Jika gagal
echo json_encode(['success' => false, 'message' => 'Failed to insert data']);
exit;
?>
