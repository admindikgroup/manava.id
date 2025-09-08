<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header JSON

$id_dg_users = isset($_GET['select_users']) ? $_GET['select_users'] : [];
$month_task = isset($_GET['month_task']) ? $_GET['month_task'] : 0;

// Cek apakah select_users kosong
$select_all_users = empty($id_dg_users);

// Jika select_users kosong, ambil semua user yang aktif
if ($select_all_users) {
    $user_query = "SELECT id_dg_user FROM dg_user WHERE deleted_at IS NULL AND status < 6";
    $user_result = $db2->query($user_query);
    
    while ($user_row = $user_result->fetch_assoc()) {
        $id_dg_users[] = $user_row['id_dg_user'];
    }
}

// Konversi array user menjadi format untuk query
$placeholders = implode(',', array_fill(0, count($id_dg_users), '?'));

// Jika bulan dipilih, tentukan rentang tanggal
if ($month_task != 0) {
    $month_task_awal = $month_task . "-1";
    $date = new DateTime($month_task_awal);
    $date->modify('last day of this month');
    $month_task_akhir = $date->format('Y-m-d');

    $sql = "
        SELECT t.id_dg_event_detail_task, t.isi_task, t.deadline_task, t.date_done, t.status_task, 
               du.nama AS owner_name, du.id_dg_user 
        FROM dg_event_detail_task t
        INNER JOIN dg_user du ON t.id_dg_user = du.id_dg_user
        WHERE du.id_dg_user IN ($placeholders) 
        AND t.deadline_task BETWEEN ? AND ?
        GROUP BY t.id_dg_event_detail_task
        ORDER BY 
            FIELD(t.status_task, 1, 0, 3, 2), 
            t.deadline_task ASC, 
            t.id_dg_event_detail_task DESC;
    ";
    $params = array_merge($id_dg_users, [$month_task_awal, $month_task_akhir]);
} else {
    $sql = "
        SELECT t.id_dg_event_detail_task, t.isi_task, t.deadline_task, t.date_done, t.status_task, 
               du.nama AS owner_name, du.id_dg_user 
        FROM dg_event_detail_task t
        INNER JOIN dg_user du ON t.id_dg_user = du.id_dg_user
        WHERE du.id_dg_user IN ($placeholders) 
        GROUP BY t.id_dg_event_detail_task
        ORDER BY 
            FIELD(t.status_task, 1, 0, 3, 2),  
            t.deadline_task ASC,  
            t.id_dg_event_detail_task DESC;
    ";
    $params = $id_dg_users;
}

$stmt = $db2->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$xxx = str_repeat('s', count($params));
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'id_dg_event_detail_task' => $row['id_dg_event_detail_task'],
        'isi_task' => htmlspecialchars($row['isi_task'], ENT_QUOTES, 'UTF-8'),
        'deadline_task' => date("d-F-Y", strtotime($row['deadline_task'])),
        'status_task' => $row['status_task'],
        'date_done' => $row['date_done'],
        'owner_id' => $row['id_dg_user'],
        'owner_name' => $row['owner_name'],
        'owners' => [] 
    ];
}

// Mengambil informasi semua owner yang terlibat
$owners_query = "SELECT id_dg_user, nama FROM dg_user WHERE id_dg_user IN ($placeholders)";
$owners_stmt = $db2->prepare($owners_query);
$owners_stmt->bind_param(str_repeat('i', count($id_dg_users)), ...$id_dg_users);
$owners_stmt->execute();
$owners_result = $owners_stmt->get_result();

$owners = [];
while ($owner_row = $owners_result->fetch_assoc()) {
    $owners[$owner_row['id_dg_user']] = [
        'id' => $owner_row['id_dg_user'],
        'name' => htmlspecialchars($owner_row['nama'], ENT_QUOTES, 'UTF-8')
    ];
}

// Tambahkan owner ke setiap task berdasarkan `owner_id`
foreach ($tasks as &$task) {
    if (isset($owners[$task['owner_id']])) {
        $task['owners'][] = $owners[$task['owner_id']];
    }
}

echo json_encode(['tasks' => $tasks]);

$stmt->close();
$owners_stmt->close();
$db2->close();
?>
