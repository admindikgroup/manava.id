<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_job` set deleted_by = ?, deleted_at = ? where id_dg_job = ?");
    $stmt1->bind_param("sss", $id_user, $tanggal_now, $id_dg_job);
    

    
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);


    $id_dg_job = $_POST['id_job_description_jobs3'];;
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../job.php");

	



?>