<?php
include '../../controller/conn.php';

header('Content-Type: application/json'); // Set header untuk JSON

$id_dg_user = $_GET['id_dg_user'];

if ($_GET['month_task']!=0) {
    $month_task_awal = $_GET['month_task'] . "-1"; // Misalnya: "2024-10-1"
    $date = new DateTime($month_task_awal);

    // Mengubah tanggal menjadi hari terakhir di bulan yang sama
    $date->modify('last day of this month');
    $month_task_akhir = $date->format('Y-m-d'); // Mendapatkan tanggal akhir dalam format "Y-m-d"


    // Query untuk mengambil data task beserta nama owner berdasarkan id_dg_user_group
    $sql = "
        SELECT t.id_dg_event_detail_task, t.isi_task, t.deadline_task, t.date_done, t.status_task, du.nama AS owner_name, du.id_dg_user 
        FROM dg_event_detail_task t
        INNER JOIN dg_user du ON t.id_dg_user = du.id_dg_user
        WHERE du.id_dg_user = ? AND ((t.deadline_task BETWEEN '$month_task_awal' AND '$month_task_akhir') OR (t.date_done is null AND t.status_task != 2))
        Group By t.id_dg_event_detail_task
        ORDER BY 
            FIELD(t.status_task, 1, 0, 3, 2),  -- Urutan status_task sesuai keinginan
            t.deadline_task ASC,  -- Urutkan deadline naik (ASC)
            t.id_dg_event_detail_task DESC; -- Urutkan ID secara turun (DESC)
        ";
}else{
    // Query untuk mengambil data task beserta nama owner berdasarkan id_dg_user_group
    $sql = "
        SELECT t.id_dg_event_detail_task, t.isi_task, t.deadline_task, t.date_done, t.status_task, du.nama AS owner_name, du.id_dg_user 
        FROM dg_event_detail_task t
        INNER JOIN dg_user du ON t.id_dg_user = du.id_dg_user
        WHERE du.id_dg_user = ? 
        Group By t.id_dg_event_detail_task
        ORDER BY 
            FIELD(t.status_task, 1, 0, 3, 2),  -- Urutan status_task sesuai keinginan
            t.deadline_task ASC,  -- Urutkan deadline naik (ASC)
            t.id_dg_event_detail_task DESC; -- Urutkan ID secara turun (DESC)
        ";
}


$stmt = $db2->prepare($sql);
$stmt->bind_param('i', $id_dg_user); // Bind parameter untuk mencegah SQL Injection
$stmt->execute();
$result = $stmt->get_result();

$tasks = []; // Array untuk menyimpan task
while ($row = $result->fetch_assoc()) {
    $tasks[] = [
        'id_dg_event_detail_task' => $row['id_dg_event_detail_task'],
        'isi_task' => htmlspecialchars($row['isi_task'], ENT_QUOTES, 'UTF-8'),
        'deadline_task' => date("d-F-Y", strtotime($row['deadline_task'])),
        'status_task' => $row['status_task'],
        'date_done' => $row['date_done'],
        'owner_id' => $row['id_dg_user'], // Pastikan ini ada
        'owners' => [] // Siapkan untuk pemilik jika ada
    ];
}


// Jika Anda ingin menambahkan data owner
foreach ($tasks as &$task) {
    // Query untuk mendapatkan owners
    $owner_sql = "SELECT *
                  FROM dg_user
                  WHERE id_dg_user = ?";
    
    $owner_stmt = $db2->prepare($owner_sql);
    $owner_stmt->bind_param('i', $id_dg_user);
    $owner_stmt->execute();
    $owner_result = $owner_stmt->get_result();
    
    $owners = [];
    while ($owner_row = $owner_result->fetch_assoc()) {
        $owners[] = [
            'id' => $owner_row['id_dg_user'],
            'name' => htmlspecialchars($owner_row['nama'], ENT_QUOTES, 'UTF-8')
        ];
    }
    $task['owners'] = $owners; // Menyimpan data owner ke task
}

echo json_encode(['tasks' => $tasks]); // Kirim data dalam format JSON

$stmt->close();
$db2->close();
?>
