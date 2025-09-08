<?php
session_start();
include '../../controller/conn.php';

$id_project = $_GET['id_project'] ?? null;

$response = ['success' => false, 'statuses' => [], 'users' => []];

if ($id_project) {
    // Ambil status dengan is_deadline_active = 1
    $queryStatus = "
        SELECT id_dg_client_project_status, nama_status, is_deadline_active 
        FROM dg_client_project_status 
        WHERE id_dg_client_project = ?
        AND deleted_by is null
        ORDER BY urutan_status ASC
    ";
    $stmtStatus = $db2->prepare($queryStatus);
    $stmtStatus->bind_param('i', $id_project);
    $stmtStatus->execute();
    $resultStatus = $stmtStatus->get_result();

    while ($row = $resultStatus->fetch_assoc()) {
        $response['statuses'][] = $row;
    }

    // Ambil daftar pengguna dari dg_client_project_team berdasarkan id_project
    $queryUsers = "
        SELECT u.id_dg_user, u.nama 
        FROM dg_client_project_team t
        JOIN dg_user u ON t.id_dg_user = u.id_dg_user
        WHERE t.id_dg_client_project = ?
        GROUP BY u.id_dg_user
    ";
    $stmtUsers = $db2->prepare($queryUsers);
    $stmtUsers->bind_param('i', $id_project);
    $stmtUsers->execute();
    $resultUsers = $stmtUsers->get_result();

    while ($row = $resultUsers->fetch_assoc()) {
        $response['users'][] = $row;
    }

    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
