<?php
session_start();
include '../../controller/conn.php';

$id_dg_client_project = $_GET['id_dg_client_project'];
$id_user = $_SESSION['id_user']; // Sesuaikan dengan sesi user Anda

$response = [];

// Mengambil opsi Sprint
$sprint_query = "
    SELECT * 
    FROM dg_client_project_sprint 
    WHERE id_dg_client_project = $id_dg_client_project
    ORDER BY id_dg_client_project_sprint DESC
";
$sprint_result = mysqli_query($db2, $sprint_query);

$sprints = [];
while ($row = mysqli_fetch_assoc($sprint_result)) {
    $sprints[] = [
        'id' => $row['id_dg_client_project_sprint'],
        'name' => $row['nama_sprint']
    ];
}

// Mengambil Sprint yang dipilih user
$selected_sprints_query = "
    SELECT id_dg_client_project_sprint 
    FROM dg_client_project_filter_user_sprint 
    WHERE id_dg_user = $id_user
";
$selected_sprints_result = mysqli_query($db2, $selected_sprints_query);

$selected_sprints = [];
while ($row = mysqli_fetch_assoc($selected_sprints_result)) {
    $selected_sprints[] = $row['id_dg_client_project_sprint'];
}

// Mengambil opsi Status
$status_query = "
    SELECT cps.id_dg_client_project_status, cps.nama_status 
    FROM dg_client_project_status cps
    WHERE cps.id_dg_client_project = $id_dg_client_project
    AND deleted_at is null
    ORDER BY cps.urutan_status ASC, cps.id_dg_client_project_status ASC
";
$status_result = mysqli_query($db2, $status_query);

$statuses = [];
while ($row = mysqli_fetch_assoc($status_result)) {
    $statuses[] = [
        'id' => $row['id_dg_client_project_status'],
        'name' => $row['nama_status']
    ];
}

// // Mengambil Status yang dipilih user
// $selected_status_query = "
//     SELECT id_dg_client_project_status 
//     FROM dg_client_project_status_user 
//     WHERE id_dg_user = $id_user AND is_active = 1
// ";
// $selected_status_result = mysqli_query($db2, $selected_status_query);

// $selected_statuses = [];
// while ($row = mysqli_fetch_assoc($selected_status_result)) {
//     $selected_statuses[] = $row['id_dg_client_project_status'];
// }

// Cek apakah ada minimal satu status is_active = 0
$check_zero_query = "
    SELECT COUNT(*) as total 
    FROM dg_client_project_status_user 
    WHERE id_dg_user = $id_user AND is_active = 0
";
$check_zero_result = mysqli_query($db2, $check_zero_query);
$check_zero = mysqli_fetch_assoc($check_zero_result);

$selected_statuses = [];

if ($check_zero['total'] > 0) {
    // Jika ada minimal satu yang is_active = 0, ambil yang is_active = 1
    $selected_status_query = "
        SELECT id_dg_client_project_status 
        FROM dg_client_project_status_user 
        WHERE id_dg_user = $id_user AND is_active = 1
    ";
    $selected_status_result = mysqli_query($db2, $selected_status_query);

    while ($row = mysqli_fetch_assoc($selected_status_result)) {
        $selected_statuses[] = $row['id_dg_client_project_status'];
    }
}


// Merangkai respons JSON
$response = [
    'sprints' => $sprints,
    'selected_sprints' => $selected_sprints,
    'statuses' => $statuses,
    'selected_statuses' => $selected_statuses,
];

header('Content-Type: application/json');
echo json_encode($response);
