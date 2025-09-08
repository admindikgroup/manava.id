<?php
session_start();
include '../../controller/conn.php';

$tasks = $_POST['tasks'] ?? null;

if ($tasks && is_array($tasks)) {
    // Ambil data pengguna dari sesi (pastikan sudah login)
    $id_user = $_SESSION['id_user'] ?? null;

    if ($id_user) {
        // Persiapkan query untuk memperbarui urutan task
        $query = "UPDATE dg_client_project_task SET urutan_task = ? WHERE id_dg_client_project_task = ?";
        $stmt = $db2->prepare($query);

        // Loop melalui task untuk memperbarui urutan_task
        foreach ($tasks as $task) {
            $taskId = $task['id'] ?? null;
            $urutanTask = $task['urutan_task'] ?? null;

            if ($taskId && $urutanTask) {
                $stmt->bind_param("ii", $urutanTask, $taskId);

                if (!$stmt->execute()) {
                    echo json_encode(['success' => false, 'message' => 'Failed to update task ID: ' . $taskId]);
                    exit;
                }
            }
        }

        // Jika semua task berhasil diperbarui
        echo json_encode(['success' => true, 'message' => 'Task order updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found or not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid tasks data.']);
}
?>
