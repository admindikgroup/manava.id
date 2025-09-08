<?php
session_start();
include '../../controller/conn.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $deletedBy = $_POST['id_dg_user'] ?? null; // Ambil user ID dari session (ganti sesuai struktur session Anda)
    $deletedAt = date('Y-m-d H:i:s'); // Waktu penghapusan

    if ($id && $deletedBy) {
        try {
            $stmt = $db2->prepare("
                UPDATE dg_client_project_status 
                SET deleted_at = ?, deleted_by = ? 
                WHERE id_dg_client_project_status = ?
            ");
            $stmt->bind_param('sii', $deletedAt, $deletedBy, $id);
            $stmt->execute();
            $stmt->close();

            $response['success'] = true;
            $response['message'] = 'Status soft deleted successfully!';
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['message'] = 'Status ID and deleted_by are required.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
