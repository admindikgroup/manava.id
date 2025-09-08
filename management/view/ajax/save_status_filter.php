<?php
session_start();
include '../../controller/conn.php';

$id_dg_user = $_POST['id_dg_user'];
$selected = $_POST['selected']; // Data yang dipilih
$removed = $_POST['removed']; // Data yang tidak dipilih lagi

$response = ['success' => false];

// Debug: Log data yang diterima
error_log("ID User: $id_dg_user");
error_log("Selected: " . json_encode($selected));
error_log("Removed: " . json_encode($removed));

// Jika tidak ada yang dipilih, set semua is_active menjadi 1
if (empty($selected)) {
    $updateAllActiveQuery = "
        UPDATE dg_client_project_status_user
        SET is_active = 1
        WHERE id_dg_user = '$id_dg_user'";
    if (!mysqli_query($db2, $updateAllActiveQuery)) {
        error_log('Error setting all active: ' . mysqli_error($db2));
        $response['message'] = 'Error setting all active';
        echo json_encode($response);
        exit;
    } else {
        error_log("Successfully set all is_active = 1 for User ID: $id_dg_user");
        $response['success'] = true;
        echo json_encode($response);
        exit;
    }
}

// Update is_active = 0 untuk data yang tidak dipilih
if (!empty($removed)) {
    $removedIds = implode(',', array_map('intval', $removed));
    $updateInactiveQuery = "
        UPDATE dg_client_project_status_user
        SET is_active = 0
        WHERE id_dg_user = '$id_dg_user'
        AND id_dg_client_project_status IN ($removedIds)";
    if (!mysqli_query($db2, $updateInactiveQuery)) {
        error_log('Error updating inactive data: ' . mysqli_error($db2));
        $response['message'] = 'Error updating inactive data';
        echo json_encode($response);
        exit;
    } else {
        error_log("Successfully updated is_active = 0 for IDs: $removedIds");
    }
}

// Proses data yang dipilih
if (!empty($selected)) {
    foreach ($selected as $statusId) {
        // Cek apakah data sudah ada
        $checkQuery = "
            SELECT * 
            FROM dg_client_project_status_user
            WHERE id_dg_client_project_status = '$statusId'
            AND id_dg_user = '$id_dg_user'
            LIMIT 1";
        $checkResult = mysqli_query($db2, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Jika sudah ada, update is_active = 1
            $updateActiveQuery = "
                UPDATE dg_client_project_status_user
                SET is_active = 1
                WHERE id_dg_client_project_status = '$statusId'
                AND id_dg_user = '$id_dg_user'";
            if (!mysqli_query($db2, $updateActiveQuery)) {
                error_log('Error updating active data: ' . mysqli_error($db2));
                $response['message'] = 'Error updating active data';
                echo json_encode($response);
                exit;
            } else {
                error_log("Successfully updated is_active = 1 for Status ID: $statusId");
            }
        } else {
            // Jika belum ada, insert data baru dengan is_active = 1
            $insertQuery = "
                INSERT INTO dg_client_project_status_user (id_dg_client_project_status, id_dg_user, is_active)
                VALUES ('$statusId', '$id_dg_user', 1)";
            if (!mysqli_query($db2, $insertQuery)) {
                error_log('Error inserting data: ' . mysqli_error($db2));
                $response['message'] = 'Error inserting data';
                echo json_encode($response);
                exit;
            } else {
                error_log("Successfully inserted new data with Status ID: $statusId and is_active = 1");
            }
        }
    }
}

$response['success'] = true;
echo json_encode($response);
?>
