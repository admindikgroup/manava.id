<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari request
$id_task = $_POST['id_task'] ?? null;
$id_status = $_POST['id_status'] ?? null;
$id_user = $_POST['id_user'] ?? null;
$tasks = $_POST['tasks'] ?? null;

// Inisialisasi respons
$response = [
    'success' => false,
    'messages' => [],
];

// Proses pembaruan status task
if ($id_task && $id_status) {
    $query = "UPDATE dg_client_project_task SET id_status = ? WHERE id_dg_client_project_task = ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param("ii", $id_status, $id_task);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['messages'][] = 'Task status updated successfully.';
    } else {
        $response['messages'][] = 'Failed to update task status.';
    }
}

// Proses pembaruan urutan task
if ($tasks && is_array($tasks)) {
    $id_user = $_SESSION['id_user'] ?? null;

    if ($id_user) {
        $query = "UPDATE dg_client_project_task SET urutan_task = ? WHERE id_dg_client_project_task = ?";
        $stmt = $db2->prepare($query);

        foreach ($tasks as $task) {
            $taskId = $task['id'] ?? null;
            $urutanTask = $task['urutan_task'] ?? null;

            if ($taskId && $urutanTask) {
                $stmt->bind_param("ii", $urutanTask, $taskId);

                if (!$stmt->execute()) {
                    $response['messages'][] = 'Failed to update task order for ID: ' . $taskId;
                    echo json_encode($response);
                    exit;
                }
            }
        }

        $response['success'] = true;
        $response['messages'][] = 'Task order updated successfully.';
    } else {
        $response['messages'][] = 'User not found or not logged in.';
    }
} elseif ($tasks && !is_array($tasks)) {
    $response['messages'][] = 'Invalid tasks data.';
}

// Kirimkan respons JSON
echo json_encode($response);
?>
