<?php 
include 'conn.php';

$type = $_POST['type'];
$task_link = mysqli_real_escape_string($db2,$_POST['task_link']);

if ($type=="head") {
    $id_task3 = mysqli_real_escape_string($db2,$_POST['id_task3']);
    $stmt1 = $db2->prepare("update `dg_task` set nama_task = ?, deskripsi = ?, deadline = ?, updated_by = ?, updated_at = ? where id_dg_task = ?");
    $stmt1->bind_param("ssssss",  $nameTask, $deskTask, $deadline, $updated_by, $tanggal_now, $id_task3);


    $nameTask = mysqli_real_escape_string($db2,$_POST['nameTask3']);
    $deskTask = mysqli_real_escape_string($db2,$_POST['deskTask3']);
    $deskTask = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $deskTask);
    $deadline = mysqli_real_escape_string($db2,$_POST['deadline3']);
    $deadline = DateTime::createFromFormat('d-F-Y', $deadline)->format('Y-m-d');
    echo $deadline."<br>";

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $updated_by = mysqli_real_escape_string($db2,$_POST['id_user']);

    $stmt1->execute();
    $stmt1->close();

    header("location:../$task_link.php?");
} else {
    $id_task2 = mysqli_real_escape_string($db2,$_POST['id_task2']);
    $stmt3 = $db2->prepare("update `dg_task_detail` set id_dg_task = ?, nama_task_detail = ?, deskripsi_task_detail = ?,
    deadline = ?, support = ?, status_detail = ?, updated_by = ?, updated_at = ? where id_dg_task_detail = ?");
    $stmt3->bind_param("sssssssss",  $groupTask, $nameTask, $deskTask, $deadline, $support, $status_task, $craeted_by, $tanggal_now, $id_task2);
    
    $nameTask = mysqli_real_escape_string($db2,$_POST['nameTask2']);
    $deskTask = mysqli_real_escape_string($db2,$_POST['deskTask2']);
    $deskTask = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $deskTask);
    $deadline = mysqli_real_escape_string($db2,$_POST['deadline2']);
    $deadline = DateTime::createFromFormat('d-F-Y', $deadline)->format('Y-m-d');
    //echo $deadline."<br>";
    $support = mysqli_real_escape_string($db2,$_POST['support2']);
    $status_task = mysqli_real_escape_string($db2,$_POST['status2']);
    $groupTask = mysqli_real_escape_string($db2,$_POST['groupTask2']);

    $craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt3->execute();
    $stmt3->close();
    header("location:../$task_link.php?");
} 




?>