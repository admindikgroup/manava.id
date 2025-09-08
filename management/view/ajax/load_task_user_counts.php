<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header untuk JSON

$id_user = $_GET['id_dg_user'];

function getTaskCount($db, $status, $id_user) {

if ($_GET['month_task']!=0) {
    $month_task_awal = $_GET['month_task'] . "-1"; // Misalnya: "2024-10-1"
    $date = new DateTime($month_task_awal);

    // Mengubah tanggal menjadi hari terakhir di bulan yang sama
    $date->modify('last day of this month');
    $month_task_akhir = $date->format('Y-m-d'); // Mendapatkan tanggal akhir dalam format "Y-m-d"

    $query = "
        SELECT COUNT(t.id_dg_event_detail_task) as task_count
        FROM dg_event_detail_task t
        INNER JOIN dg_user_group_detail dg ON dg.id_dg_user = t.id_dg_user
        WHERE dg.id_dg_user = $id_user AND t.status_task = $status
        AND (t.deadline_task BETWEEN '$month_task_awal' AND '$month_task_akhir')";

}else{

    $query = "
        SELECT COUNT(t.id_dg_event_detail_task) as task_count
        FROM dg_event_detail_task t
        INNER JOIN dg_user_group_detail dg ON dg.id_dg_user = t.id_dg_user
        WHERE dg.id_dg_user = $id_user AND t.status_task = $status";


}   
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['task_count'];
}

$data = [
    'open' => getTaskCount($db2, 0, $id_user),
    'ongoing' => getTaskCount($db2, 1, $id_user),
    'canceled' => getTaskCount($db2, 2, $id_user),
    'done' => getTaskCount($db2, 3, $id_user),
];

echo json_encode($data);
?>
