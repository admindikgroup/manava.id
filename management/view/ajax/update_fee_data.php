<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$id = $_POST['id'];
$id_user = $_POST['id_user'];
$id_event = $_POST['id_event'];
$offline = $_POST['tambahan_fee_offline'];
$online = $_POST['tambahan_fee_online'];

// Cek apakah kombinasi id_user dan id_event sudah ada
$queryCheck = "SELECT 1 FROM dg_event_user_tambahan WHERE id_dg_user = ? AND id_dg_event = ? AND id_dg_event_user_tambahan != ?";
$stmtCheck = $db2->prepare($queryCheck);
$stmtCheck->bind_param('iii', $id_user, $id_event, $id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Data with the same user and event already exists.']);
    exit;
}

$update = mysqli_query($db2, "UPDATE dg_event_user_tambahan SET 
    id_dg_user = '$id_user',
    id_dg_event = '$id_event',
    tambahan_fee_offline = '$offline',
    tambahan_fee_online = '$online'
    WHERE id_dg_event_user_tambahan = '$id'");

if ($update) {
    echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update data.']);
}
