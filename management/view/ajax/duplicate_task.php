<?php
session_start();
include '../../controller/conn.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_task'])) {
    $idTasks = $_POST['id_task']; // Array ID task yang akan diduplikasi
    $createdBy = $_POST['id_user'] ?? null;

    if (!is_array($idTasks)) {
        $idTasks = [$idTasks];
    }
    if (empty($idTasks)) {
        $response['message'] = 'No tasks selected for copy.';
    }

    try {
        $newTaskIds = []; // Menyimpan ID task baru yang berhasil dibuat

        foreach ($idTasks as $taskId) {
            // Ambil data task yang akan diduplikasi
            $stmt = $db2->prepare("SELECT * FROM dg_client_project_task WHERE id_dg_client_project_task = ?");
            $stmt->bind_param('i', $taskId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                continue; // Lewati jika task tidak ditemukan
            }

            $task = $result->fetch_assoc();

            // Buat duplikat task dengan nama baru
            $taskName = $task['nama_task'] . ' (Copy)';
            $idProject = $task['id_dg_client_project'];
            $idSprint = $task['id_sprint'];
            $idType = $task['id_type'];
            $idStatus = $task['id_status'];
            $priority = $task['priority'];
            $taskDetails = $task['detail_project'];
            $urutanTask = $task['urutan_task'];

            // Geser semua urutan_task di bawahnya ke bawah (increment +1)
            $updateUrutan = $db2->prepare("
                UPDATE dg_client_project_task 
                SET urutan_task = urutan_task + 1 
                WHERE id_dg_client_project = ? 
                AND id_status = ? 
                AND urutan_task >= ?
            ");
            $updateUrutan->bind_param('iii', $idProject, $idStatus, $urutanTask);
            $updateUrutan->execute();
            $updateUrutan->close();


            // Query untuk menambahkan task baru
            $insertStmt = $db2->prepare("
                INSERT INTO dg_client_project_task 
                (id_dg_client_project, id_sprint, id_type, id_status, nama_task, priority, detail_project, urutan_task, created_at, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ");
            $insertStmt->bind_param(
                'iiissssii', 
                $idProject, 
                $idSprint, 
                $idType, 
                $idStatus, 
                $taskName, 
                $priority, 
                $taskDetails, 
                $urutanTask, // posisi yang sama dengan task aslinya
                $createdBy
            );

            $insertStmt->execute();

            if ($insertStmt->affected_rows > 0) {
                // Dapatkan ID task yang baru dibuat
                $newTaskId = $insertStmt->insert_id;
                $newTaskIds[] = $newTaskId;

                // Ambil dan duplikasi data assign jika ada
                $assignStmt = $db2->prepare("
                    SELECT id_dg_client_project_status, id_dg_user_assign, deadline_status 
                    FROM dg_client_project_status_assign 
                    WHERE id_dg_client_project_task = ?
                ");
                $assignStmt->bind_param('i', $taskId);
                $assignStmt->execute();
                $assignResult = $assignStmt->get_result();

                if ($assignResult->num_rows > 0) {
                    $insertAssignStmt = $db2->prepare("
                        INSERT INTO dg_client_project_status_assign 
                        (id_dg_client_project_task, id_dg_client_project_status, id_dg_user_assign, deadline_status) 
                        VALUES (?, ?, ?, ?)
                    ");

                    while ($assign = $assignResult->fetch_assoc()) {
                        $insertAssignStmt->bind_param(
                            'iiis', 
                            $newTaskId, 
                            $assign['id_dg_client_project_status'], 
                            $assign['id_dg_user_assign'], 
                            $assign['deadline_status']
                        );
                        $insertAssignStmt->execute();
                    }
                }
            }

            $insertStmt->close();
        }

        if (!empty($newTaskIds)) {
            $response['success'] = true;
            $response['message'] = count($newTaskIds) . ' tasks duplicated successfully!';
            $response['taskIds'] = $newTaskIds;
        } else {
            $response['message'] = 'No tasks were duplicated.';
        }

    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method or no tasks selected.';
}

// Mengembalikan response sebagai JSON
header('Content-Type: application/json');
echo json_encode($response);
