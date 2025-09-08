<?php 
include 'conn.php';


$typeC = $_POST['type4'];
$task_link = mysqli_real_escape_string($db2,$_POST['task_link']);



if ($typeC==1) {
    $stmt1 = $db2->prepare("update `dg_task_detail` set id_dg_task= ?, updated_by = ?, updated_at = ? where id_dg_task = ?");
    $stmt1->bind_param("ssss", $nn, $owner_task, $tanggal_now, $id_task);

    $stmt2 = $db2->prepare("update `dg_task` set deleted_by = ?, deleted_at = ? where id_dg_task= ?");
    $stmt2->bind_param("sss",   $owner_task, $tanggal_now, $id_task);

    $nn= 0;
    $owner_task = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_task = mysqli_real_escape_string($db2,$_POST['id_task4']);
    
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    $stmt1->execute();
    $stmt1->close();
    $stmt2->execute();
    $stmt2->close();
    header("location:../$task_link.php?");
} else if ($typeC==0) {

    $stmt3 = $db2->prepare("update `dg_task_detail` set deleted_by = ?, deleted_at = ? where id_dg_task_detail = ?");
    $stmt3->bind_param("sss", $owner_task, $tanggal_now, $id_task);
    
    $owner_task = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_task = mysqli_real_escape_string($db2,$_POST['id_task4']);
    
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    $stmt3->execute();
    $stmt3->close();
    header("location:../$task_link.php?");
}




?>