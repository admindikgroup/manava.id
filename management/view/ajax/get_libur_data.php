<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$id = $_POST['id'];
$result = mysqli_query($db2, "SELECT * FROM dg_event_hari_libur WHERE id_dg_event_hari_libur = '$id'");
$data = mysqli_fetch_assoc($result);

if ($data) {
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Data not found.']);
}
?>