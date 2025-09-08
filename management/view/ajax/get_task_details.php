<?php
session_start();
include '../../controller/conn.php';

// Ambil parameter id_task dari request
$id_task = $_GET['id_task'] ?? null;

if ($id_task) {
    try {
        // Query untuk mengambil data utama tugas
        $queryTask = "SELECT 
                        t.id_dg_client_project_task AS id_task, 
                        t.nama_task, 
                        t.id_status, 
                        t.id_sprint, 
                        t.id_type, 
                        t.priority, 
                        t.detail_project,
                        s.nama_sprint,
                        tp.nama_type,
                        st.nama_status AS status_name
                      FROM dg_client_project_task t
                      LEFT JOIN dg_client_project_sprint s ON t.id_sprint = s.id_dg_client_project_sprint
                      LEFT JOIN dg_client_project_type tp ON t.id_type = tp.id_dg_client_project_type
                      LEFT JOIN dg_client_project_status st ON t.id_status = st.id_dg_client_project_status
                      WHERE t.id_dg_client_project_task = ?";
        $stmtTask = $db2->prepare($queryTask);
        $stmtTask->bind_param("i", $id_task);
        $stmtTask->execute();
        $resultTask = $stmtTask->get_result();

        if ($resultTask->num_rows > 0) {
            $taskDetails = $resultTask->fetch_assoc();

            // Query untuk mengambil data assign (pengguna dan deadline)
            $queryAssign = "SELECT 
                                a.id_dg_client_project_status, 
                                a.id_dg_user_assign, 
                                a.deadline_status, 
                                u.nama
                            FROM dg_client_project_status_assign a
                            LEFT JOIN dg_user u ON a.id_dg_user_assign = u.id_dg_user
                            WHERE a.id_dg_client_project_task = ?";
            $stmtAssign = $db2->prepare($queryAssign);
            $stmtAssign->bind_param("i", $id_task);
            $stmtAssign->execute();
            $resultAssign = $stmtAssign->get_result();

            $assignments = [];
            while ($row = $resultAssign->fetch_assoc()) {
                $assignments[$row['id_dg_client_project_status']][] = [
                    'id_user' => $row['id_dg_user_assign'],
                    'nama_user' => $row['nama'],
                    'deadline' => $row['deadline_status'],
                    'id_status' => $row['id_dg_client_project_status'],
                    'assigned_users' => []
                ];

                $assignments[$row['id_dg_client_project_status']]['assigned_users'][] = [
                    'id_user' => $row['id_dg_user_assign'],
                    'user_name' => $row['nama']
                ];
            }

            // Gabungkan hasil ke dalam array respons
            $taskDetails['assignments'] = array_values($assignments);

            echo json_encode([
                'success' => true,
                'data' => $taskDetails
            ]);

        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Task not found.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error fetching task details: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Task ID is required.'
    ]);
}
?>
