<?php 

    include '../../controller/conn.php';

    $id = $_POST['id'];
    $status = $_POST['status'];

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    if ($status==3) {

        $sql = "UPDATE dg_event_detail_task SET status_task = ?, date_done=? WHERE id_dg_event_detail_task = ?";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("isi", $status, $tanggal_now, $id);
    
    }else if($status==0){
        $null = null;
        $sql = "UPDATE dg_event_detail_task SET status_task = ?, date_done=?, date_ongoing=? WHERE id_dg_event_detail_task = ?";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("issi", $status, $null, $null, $id);

    }else{

        $sql = "UPDATE dg_event_detail_task SET status_task = ?, date_ongoing=? WHERE id_dg_event_detail_task = ?";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("isi", $status, $tanggal_now, $id);

    }

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
