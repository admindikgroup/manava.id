<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_user_job` (id_dg_user, id_dg_job) value (?,?)");
    $stmt1->bind_param("ss", $id_user, $userJob);
    

    $userJob = mysqli_real_escape_string($db2,$_POST['userJob']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php?id_user=$id_user");

	



?>