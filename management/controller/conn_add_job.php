<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_job` (job_name, job_description, created_by, 
    created_at) value (?,?,?,?)");
    $stmt1->bind_param("ssss", $jobName, $job_description, $id_user, $tanggal_now);
    

    $jobName = mysqli_real_escape_string($db2,$_POST['jobName2']);
    $job_description = mysqli_real_escape_string($db2,$_POST['job_description2']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user2']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    echo  $jobName."<br>".$job_description."<br>".$id_user."<br>".$tanggal_now;

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../job.php");

	



?>