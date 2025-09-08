<?php
session_start();
include '../../controller/conn.php';

$id_dg_user = $_POST['id_dg_user'];
$selected = $_POST['selected']; // Data sprint yang dipilih
$removed = $_POST['removed']; // Data sprint yang tidak dipilih lagi

$response = ['success' => false];

// Proses tambah data baru (sprint yang dipilih)
if (!empty($selected)) {
    foreach ($selected as $sprintId) {
        // Cek apakah data sudah ada sebelum menambahkan
        $checkQuery = "
            SELECT 1 FROM dg_client_project_filter_user_sprint
            WHERE id_dg_client_project_sprint = '$sprintId'
            AND id_dg_user = '$id_dg_user'
            LIMIT 1";
        $checkResult = mysqli_query($db2, $checkQuery);

        if (mysqli_num_rows($checkResult) == 0) {
            $insertQuery = "
                INSERT INTO dg_client_project_filter_user_sprint (id_dg_client_project_sprint, id_dg_user)
                VALUES ('$sprintId', '$id_dg_user')";
            if (!mysqli_query($db2, $insertQuery)) {
                $response['message'] = 'Error inserting sprint data: ' . mysqli_error($db2);
                echo json_encode($response);
                exit;
            }
        }
    }
}

// Proses hapus data sprint yang tidak lagi dipilih
if (!empty($removed)) {
    $removedIds = implode(',', array_map('intval', $removed));
    $deleteQuery = "
        DELETE FROM dg_client_project_filter_user_sprint
        WHERE id_dg_user = '$id_dg_user' 
        AND id_dg_client_project_sprint IN ($removedIds)";
    if (!mysqli_query($db2, $deleteQuery)) {
        $response['message'] = 'Error deleting sprint data: ' . mysqli_error($db2);
        echo json_encode($response);
        exit;
    }
}

$response['success'] = true;
echo json_encode($response);
?>
