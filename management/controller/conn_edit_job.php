<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_job` set job_name = ?, job_description = ?, edited_by = ?, 
    edited_at = ? where id_dg_job = ?");
    $stmt1->bind_param("sssss", $jobName, $job_description, $id_user, $tanggal_now, $id_dg_job);
    

    $jobName = mysqli_real_escape_string($db2,$_POST['jobName']);
    $job_description = mysqli_real_escape_string($db2,$_POST['job_description']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_dg_job = mysqli_real_escape_string($db2,$_POST['id_dg_job']);

    $id_client = mysqli_real_escape_string($db2,$_POST['id_client']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../job.php");

	



?>