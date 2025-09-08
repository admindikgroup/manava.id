<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_client_project_jenis` (nama_jenis_project, created_at, created_by) value (?,?,?)");
    $stmt1->bind_param("sss", $add_jenis_name, $tanggal_now, $id_user);
    
    
    $add_jenis_name = mysqli_real_escape_string($db2,$_POST['add_jenis_name']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);

    // echo  $add_jenis_name."<br>";
    // echo  $id_user."<br>";


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    

    header("location:../jenis_type.php");


?>