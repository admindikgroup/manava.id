<?php
session_start();
include '../../controller/conn.php';

$id_dg_event_detail = $_GET['id_dg_event_detail'];
$id_dg_user_group = $_GET['id_dg_user_group'];

$result_user = mysqli_query($db2, "SELECT *, du.id_dg_user, du.nama, du.nomor_hp, IFNULL(da.status_absen, 0) AS status_absen, IFNULL(da.pengeluaran, 0) AS pengeluaran
FROM dg_user_group_detail dd
INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
LEFT JOIN dg_event_detail_attendance da ON du.id_dg_user = da.id_dg_user AND da.id_dg_event_detail = $id_dg_event_detail
WHERE dd.id_dg_user_group = $id_dg_user_group and du.status < 6");


$data = array();
while ($row = mysqli_fetch_assoc($result_user)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>

