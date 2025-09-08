<?php 
include 'conn.php';
session_start();

$typeTicket = mysqli_real_escape_string($db2,$_POST['typeTicket']);
$task_link = mysqli_real_escape_string($db2,$_POST['task_link']);

if ($typeTicket==1) {
    
    $stmt1 = $db2->prepare("INSERT INTO `dg_task` (id_client, nama_task, deskripsi, deadline, owner_task, status_task,
    craeted_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssssss", $client, $nameTask, $deskTask, $deadline, $owner_task, $status_task, $craeted_by, $tanggal_now);
    
    $client = mysqli_real_escape_string($db2,$_POST['client']);
    $nameTask = mysqli_real_escape_string($db2,$_POST['nameTask']);
    $deskTask = mysqli_real_escape_string($db2,$_POST['deskTask']);
    $deskTask = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $deskTask);    
    $deadline = mysqli_real_escape_string($db2,$_POST['deadline']);
    $deadline = DateTime::createFromFormat('d-F-Y', $deadline)->format('Y-m-d');
    echo $deadline."<br>";
    $owner_task = mysqli_real_escape_string($db2,$_POST['id_user']);
    $status_task = 1;
    
    $craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../$task_link.php");
}else if ($typeTicket==0) {
    
    $stmt2 = $db2->prepare("INSERT INTO `dg_task_detail` (id_dg_task, nama_task_detail, deskripsi_task_detail,
    deadline, support, status_detail, craeted_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssssss",$groupTask, $nameTask, $deskTask, $deadline, $support, $status_task, $craeted_by, $tanggal_now);

    
    
    $nameTask = mysqli_real_escape_string($db2,$_POST['nameTask']);
    $deskTask = mysqli_real_escape_string($db2,$_POST['deskTask']);
    $deskTask = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $deskTask);
    $deadline = mysqli_real_escape_string($db2,$_POST['deadline']);
    $deadline = DateTime::createFromFormat('d-F-Y', $deadline)->format('Y-m-d');
    echo $deadline."<br>";
    $support = mysqli_real_escape_string($db2,$_POST['support']);
    $status_task = 1;
    $groupTask = mysqli_real_escape_string($db2,$_POST['groupTask']);

    $craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt2->execute();
    $stmt2->close();
    
    header("location:../$task_link.php");
}


	



?>