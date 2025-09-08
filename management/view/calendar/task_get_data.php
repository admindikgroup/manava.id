<?php
session_start();
include '../../controller/conn.php';

$id_event_detail = $_GET['id_event_detail'];
$query = "SELECT * FROM dg_event_detail_task WHERE id_dg_event_detail = $id_event_detail";
$result = mysqli_query($db2, $query);
$tasks = [];

while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = [
        'id_dg_event_detail_task' => $row['id_dg_event_detail_task'],
        'isi_task' => $row['isi_task'],
        'owner_task' => $row['owner_task'],
        'deadline_task' => $row['deadline_task'],
        'owners' => [] // Lakukan query owner atau ambil data di sini
    ];
}

echo json_encode($tasks);
?>
