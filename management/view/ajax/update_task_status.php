<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari request
$id_task = $_POST['id_task'] ?? null;
$id_status = $_POST['id_status'] ?? null;
$id_user = $_POST['id_user'] ?? null;
$tasks = $_POST['tasks'] ?? null;

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

// Inisialisasi respons
$response = [
    'success' => false,
    'messages' => [],
];

// Cek status lama dari task sebelum mengubahnya
$old_status_query = "SELECT id_status FROM dg_client_project_task WHERE id_dg_client_project_task = ?";
$old_status_stmt = $db2->prepare($old_status_query);
$old_status_stmt->bind_param("i", $id_task);
$old_status_stmt->execute();
$old_status_result = $old_status_stmt->get_result();
$old_status_data = $old_status_result->fetch_assoc();
$old_status = $old_status_data['id_status'] ?? null;

// **Proses pembaruan status task**
if ($id_task && $id_status && $old_status != $id_status) { // Cek jika status berubah
    $query = "UPDATE dg_client_project_task SET id_status = ? WHERE id_dg_client_project_task = ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param("ii", $id_status, $id_task);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['messages'][] = 'Task status updated successfully.';

        // **CEK DATA DI HISTORY**
        $check_query = "SELECT * FROM dg_client_project_task_status_history 
                        WHERE id_dg_client_project_task = ? AND id_dg_client_project_status = ?";
        $check_stmt = $db2->prepare($check_query);
        $check_stmt->bind_param("ii", $id_task, $id_status);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // **UPDATE jika sudah ada**
            $update_query = "UPDATE dg_client_project_task_status_history 
                            SET edited_at = ?, edited_by = ? 
                            WHERE id_dg_client_project_task = ? AND id_dg_client_project_status = ?";
            $update_stmt = $db2->prepare($update_query);
            $update_stmt->bind_param("siii", $tanggal_now, $id_user, $id_task, $id_status);
            $update_stmt->execute();
        } else {
            // **INSERT jika belum ada**
            $insert_query = "INSERT INTO dg_client_project_task_status_history 
                            (id_dg_client_project_task, id_dg_client_project_status, edited_at, edited_by) 
                            VALUES (?, ?, ?, ?)";
            $insert_stmt = $db2->prepare($insert_query);
            $insert_stmt->bind_param("iisi", $id_task, $id_status, $tanggal_now, $id_user);
            $insert_stmt->execute();
        }
    } else {
        $response['messages'][] = 'Failed to update task status.';
    }
}

// **Proses pembaruan urutan task**
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
