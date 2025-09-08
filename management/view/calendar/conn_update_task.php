<?php
    include '../../controller/conn.php';

    $id_dg_event_detail_task = $_POST['id_dg_event_detail_task'];
    $deadline = $_POST['deadline'];
    $status_update = 0;
    $done = null;

    if(!isset($_POST['change'])){
        $task = $_POST['task'];
        $owner = $_POST['owner'];
       

        $sql = "UPDATE dg_event_detail_task SET isi_task = ?, id_dg_user = ?, deadline_task = ?, status_task = ?, date_done=? WHERE id_dg_event_detail_task = ?";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("sisssi", $task, $owner, $deadline, $status_update, $done, $id_dg_event_detail_task);
    
        $response = [];
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
    }else{
        $sql = "UPDATE dg_event_detail_task SET deadline_task = ?, status_task = ?, date_done=? WHERE id_dg_event_detail_task = ?";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("sssi", $deadline, $status_update, $done, $id_dg_event_detail_task);
    
        $response = [];
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

    }


    
    



    echo json_encode($response);

    $stmt->close();
    $db2->close();
?>
