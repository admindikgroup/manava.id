<?php
session_start();
include '../../controller/conn.php';

// Pastikan bahwa data dikirimkan melalui POST
    $id_dg_event_detail = $_POST['id_dg_event_detail'];
    $notes_mom = $_POST['notes_mom'];

    // Update data di database
    $query = "UPDATE dg_event_detail SET notes_mom = ? WHERE id_dg_event_detail = ?";
    if ($stmt = $db2->prepare($query)) {
        $stmt->bind_param('ss', $notes_mom, $id_dg_event_detail);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    }
    

header('Content-Type: application/json');
echo json_encode($response);

?>
