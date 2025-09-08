<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

// Ambil data dari request
$id_user = $_POST['id_user'] ?? null;
$id_event = $_POST['id_event'] ?? null;
$tambahan_fee_offline = $_POST['tambahan_fee_offline'] ?? 0;
$tambahan_fee_online = $_POST['tambahan_fee_online'] ?? 0;

if (!$id_user || !$id_event) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Cek apakah kombinasi id_user dan id_event sudah ada
$queryCheck = "SELECT 1 FROM dg_event_user_tambahan WHERE id_dg_user = ? AND id_dg_event = ?";
$stmtCheck = $db2->prepare($queryCheck);
$stmtCheck->bind_param('ii', $id_user, $id_event);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Data with the same user and event already exists.']);
    exit;
}

// Jika tidak ada, masukkan data baru
$queryInsert = "
    INSERT INTO dg_event_user_tambahan (id_dg_user, id_dg_event, tambahan_fee_offline, tambahan_fee_online)
    VALUES (?, ?, ?, ?)
";
$stmtInsert = $db2->prepare($queryInsert);
$stmtInsert->bind_param('iiii', $id_user, $id_event, $tambahan_fee_offline, $tambahan_fee_online);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Data successfully added.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add data.']);
}
?>