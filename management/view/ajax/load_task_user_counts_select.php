<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header untuk JSON

$id_dg_users = isset($_GET['select_users']) ? $_GET['select_users'] : [];
$month_task_user = isset($_GET['month_task_user']) ? $_GET['month_task_user'] : 0;
$xx = 0;

// Cek apakah select_users kosong
$select_all_users = empty($id_dg_users);

// Jika select_users kosong, ambil semua user yang aktif
if ($select_all_users) {
    $user_query = "SELECT id_dg_user FROM dg_user WHERE deleted_at IS NULL AND status < 6";
    $user_result = $db2->query($user_query);
    
    while ($user_row = $user_result->fetch_assoc()) {
        $id_dg_users[] = $user_row['id_dg_user'];
    }
    $xx = 4;
}

$data = [
    'open' => getTaskCount($db2, 0, $id_dg_users, $month_task_user),
    'ongoing' => getTaskCount($db2, 1, $id_dg_users, $month_task_user),
    'canceled' => getTaskCount($db2, 2, $id_dg_users, $month_task_user),
    'done' => getTaskCount($db2, 3, $id_dg_users, $month_task_user),
    'test' => $xx
];

function getTaskCount($db, $status, $id_dg_users_x, $month_task_x) {
    $result = implode(",", $id_dg_users_x);

    $xx = 3;

    if ($month_task_x != 0) {
        $month_task_awal = $month_task_x . "-1";
        $date = new DateTime($month_task_awal);
        $date->modify('last day of this month');
        $month_task_akhir = $date->format('Y-m-d');
        $xx = 1;
        $query = "
            SELECT COUNT(t.id_dg_event_detail_task) as task_count
            FROM dg_event_detail_task t
            INNER JOIN dg_user dg ON dg.id_dg_user = t.id_dg_user
            WHERE dg.id_dg_user IN ($result) AND t.status_task = $status
            AND (t.deadline_task BETWEEN '$month_task_awal' AND '$month_task_akhir')";
            

    }else{
        $xx = 2;
        $query = "
            SELECT COUNT(t.id_dg_event_detail_task) as task_count
            FROM dg_event_detail_task t
            INNER JOIN dg_user dg ON dg.id_dg_user = t.id_dg_user
            WHERE dg.id_dg_user IN ($result) AND t.status_task = $status";


    }   
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['task_count'];
}


echo json_encode($data);

?>
