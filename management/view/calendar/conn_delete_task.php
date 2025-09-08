<?php
    include '../../controller/conn.php';

    $id = $_POST['id'];
    $null = null;
    $status = 2;

    $sql = "UPDATE dg_event_detail_task SET status_task = ?, date_done=?, date_ongoing=? WHERE id_dg_event_detail_task = ?";
    $stmt = $db2->prepare($sql);
    $stmt->bind_param("issi", $status, $null, $null, $id);


    $response = [];
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    echo json_encode($response);

    $stmt->close();
    $db2->close();
?>
