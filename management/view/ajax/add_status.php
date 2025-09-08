<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari POST
$idProject = $_POST['id_dg_client_project'] ?? null;
$statusName = $_POST['nama_status'] ?? null;
$statusColor = $_POST['warna_status'] ?? null;
$statusOrder = $_POST['urutan_status'] ?? null;
$id_dg_user = $_POST['id_dg_user'] ?? null;
$hasDeadline = $_POST['hasDeadline'] ?? null;

// Validasi data
if ($idProject && $statusName && $statusColor && $statusOrder && $id_dg_user) {
    // Query untuk menambahkan status baru
    $query1 = "INSERT INTO dg_client_project_status (id_dg_client_project, nama_status, warna_status, urutan_status, is_deadline_active) 
               VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $db2->prepare($query1);

    // Bind parameter dan eksekusi query pertama
    $stmt1->bind_param("issii", $idProject, $statusName, $statusColor, $statusOrder, $hasDeadline);

    if (!$stmt1->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to add status: ' . $stmt1->error]);
        exit;
    }

    // Ambil ID status terakhir yang dimasukkan
    $lastIdQuery = "SELECT id_dg_client_project_status 
                    FROM dg_client_project_status 
                    ORDER BY id_dg_client_project_status DESC 
                    LIMIT 1";
    $result = $db2->query($lastIdQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $id_dg_client_project_status = $row['id_dg_client_project_status'];

        // Query untuk menambahkan data ke dg_client_project_status_user
        $is_active = 1;
        $query2 = "INSERT INTO dg_client_project_status_user (id_dg_client_project_status, id_dg_user, urutan_view, is_active) 
                   VALUES (?, ?, ?, ?)";
        $stmt2 = $db2->prepare($query2);

        // Bind parameter dan eksekusi query kedua
        $stmt2->bind_param("iiii", $id_dg_client_project_status, $id_dg_user, $statusOrder, $is_active);

        if (!$stmt2->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to add status user link: ' . $stmt2->error]);
            exit;
        }

        // Semua berhasil
        echo json_encode(['success' => true, 'message' => 'Status added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch the last inserted status ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
}
?>
