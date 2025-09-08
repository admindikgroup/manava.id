<?php
session_start();
include '../../controller/conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

    $id_dg_event_detail = $_POST['id_dg_event_detail'];
    $task = $_POST['task'];
    $owner = $_POST['owner'];
    $deadline = $_POST['deadline'];
    $id_user = $_POST['id_user'];
    

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    // Query untuk menyimpan data
    $sql = "INSERT INTO dg_event_detail_task (id_dg_event_detail, id_dg_user, isi_task, deadline_task, created_at, created_by)
    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db2->prepare($sql);
    $stmt->bind_param("ssssss", $id_dg_event_detail, $owner, $task, $deadline, $tanggal_now, $id_user);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    
    $stmt->close();
    $db2->close();

?>