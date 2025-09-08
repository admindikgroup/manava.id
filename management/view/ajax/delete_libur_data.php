<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$id = $_POST['id'];

$delete = mysqli_query($db2, "DELETE FROM dg_event_hari_libur WHERE id_dg_event_hari_libur = '$id'");

if ($delete) {
    echo json_encode(['success' => true, 'message' => 'Data deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete data.']);
}
