<?php
session_start();
include '../../controller/conn.php';

header('Content-Type: application/json'); // Pastikan ini di atas sebelum output apapun

$response = ['success' => false]; // Default response
$id_dg_user = $_POST['id_dg_user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['statuses'])) {
    $statuses = $_POST['statuses'];

    $db2->begin_transaction();

    try {
        foreach ($statuses as $status) {
            $idStatus = $status['id'];
            $order = $status['order'];

            $stmt = $db2->prepare("UPDATE dg_client_project_status_user SET urutan_view = ? WHERE id_dg_client_project_status = ? AND id_dg_user = ?");
            $stmt->bind_param('iii', $order, $idStatus, $id_dg_user);
            $stmt->execute();
            $stmt->close();
        }

        $db2->commit();
        $response = ['success' => true, 'message' => 'Status order updated successfully!'];
    } catch (Exception $e) {
        $db2->rollback(); // Rollback transaksi jika terjadi error
        $response = ['success' => false, 'message' => $e->getMessage()];
    }
}

// Pastikan hanya satu kali echo di akhir
echo json_encode($response);
