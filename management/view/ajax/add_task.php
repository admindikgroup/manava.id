<?php
session_start();
include '../../controller/conn.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST
    $idProject = $_POST['id_project'] ?? null;
    $idSprint = $_POST['id_sprint'] ?? null;
    $idType = $_POST['id_type'] ?? null;
    $idStatus = $_POST['id_status'] ?? null;
    $taskName = $_POST['nama_task'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $taskDetails = $_POST['detail_project'] ?? null;
    $createdBy = $_POST['created_by'] ?? null;

    // Validasi input
   
        try {
            // Query untuk menambahkan task
            $stmt = $db2->prepare("
                INSERT INTO dg_client_project_task 
                (id_dg_client_project, id_sprint, id_type, id_status, nama_task, priority, detail_project, created_at, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)
            ");
            $stmt->bind_param(
                'iiissssi', 
                $idProject, 
                $idSprint, 
                $idType, 
                $idStatus, 
                $taskName, 
                $priority, 
                $taskDetails, 
                $createdBy
            );
            $stmt->execute();

            // Dapatkan ID terakhir dari tabel dg_client_project_task
            $taskIdStmt = $db2->prepare("
            SELECT id_dg_client_project_task 
            FROM dg_client_project_task 
            ORDER BY id_dg_client_project_task DESC 
            LIMIT 1
            ");
            $taskIdStmt->execute();
            $taskIdResult = $taskIdStmt->get_result();

            if ($taskIdResult && $taskIdResult->num_rows > 0) {
            $taskIdRow = $taskIdResult->fetch_assoc();
            $taskId = $taskIdRow['id_dg_client_project_task'];
            } else {
            throw new Exception("Failed to retrieve the last inserted task ID.");
            }

            // Simpan data assign
            if (!empty($_POST['assign'])) {
            $assignData = $_POST['assign'];

            // Siapkan query untuk menambahkan assign
            $assignStmt = $db2->prepare("
                INSERT INTO dg_client_project_status_assign 
                (id_dg_client_project_task, id_dg_client_project_status, id_dg_user_assign, deadline_status) 
                VALUES (?, ?, ?, ?)
            ");

            // Iterasi data assign
            foreach ($assignData as $statusId => $assignments) {
                foreach ($assignments as $assignment) {
                    $assignment = json_decode($assignment, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($assignment['id_user'], $assignment['deadline'])) {
                        $assignStmt->bind_param(
                            'iiis', 
                            $taskId,                // ID Task
                            $statusId,              // ID Status
                            $assignment['id_user'], // ID User Assign
                            $assignment['deadline'] // Deadline Status
                        );
                        $assignStmt->execute();
                    } else {
                        throw new Exception("Invalid JSON format or missing keys in assignment data.");
                    }
                }
            }
            }


            // Periksa apakah data berhasil dimasukkan
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = 'Task added successfully!';
                $response['taskId'] = $taskId; // Tambahkan taskId ke response
            } else {
                $response['message'] = 'Failed to add task. Please try again.'.$idProject.'-'.$idSprint.'-'.$idType.'-'.$idStatus.'-'.$taskName.'-'.$priority.'-'.$taskDetails.'-'.$createdBy;
            }

            $stmt->close();
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }

} else {
    $response['message'] = 'Invalid request method.';
}

// Mengembalikan response sebagai JSON
header('Content-Type: application/json');
echo json_encode($response);
