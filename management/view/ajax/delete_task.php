<?php
session_start();
include '../../controller/conn.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskIds = $_POST['id_task'] ?? null;

    // Pastikan $taskIds dalam bentuk array
    if (!is_array($taskIds)) {
        $taskIds = [$taskIds]; // Ubah menjadi array jika hanya satu ID
    }

    if (empty($taskIds)) {
        $response['message'] = 'No tasks selected for deletion.';
    } else {
        try {
            $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
            $types = str_repeat('i', count($taskIds));

            // Hapus task dari database
            $stmt = $db2->prepare("DELETE FROM dg_client_project_task WHERE id_dg_client_project_task IN ($placeholders)");
            $stmt->bind_param($types, ...$taskIds);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = 'Tasks deleted successfully!';
            } else {
                $response['message'] = 'Failed to delete tasks or tasks not found.';
            }

            $stmt->close();
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
