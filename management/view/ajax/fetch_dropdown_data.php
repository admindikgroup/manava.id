<?php
session_start();
include '../../controller/conn.php';

$id_project = $_GET['id_project'];

// Fetch Sprints
$sprints = [];
$query =  mysqli_query($db2, "SELECT * FROM dg_client_project_sprint WHERE id_dg_client_project = $id_project
ORDER BY id_dg_client_project_sprint DESC");
while ($row = mysqli_fetch_assoc($query)) {
    $sprints[] = $row;
}

// Fetch Types
$types = [];
$query = mysqli_query($db2, "SELECT * FROM dg_client_project_type WHERE id_dg_client_project = $id_project
AND deleted_at IS NULL");
while ($row = mysqli_fetch_assoc($query)) {
    $types[] = $row;
}

// Fetch Statuses
$statuses = [];
$status_query = mysqli_query($db2, "SELECT id_dg_client_project_status AS id, nama_status AS name 
    FROM dg_client_project_status 
    WHERE id_dg_client_project = $id_project 
    AND deleted_at IS NULL
    ORDER BY urutan_status ASC");
while ($row = mysqli_fetch_assoc($status_query)) {
    $statuses[] = $row;
}

// Return as JSON
echo json_encode([
    'sprints' => $sprints,
    'types' => $types,
    'statuses' => $statuses
]);
?>
