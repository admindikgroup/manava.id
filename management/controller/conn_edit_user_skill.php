<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_user_skills` SET skill_name = ?, percent = ? WHERE id_dg_user_skills = ?");
    $stmt1->bind_param("sss", $namaSkill, $precentase, $id_task4);
    

    $precentase = mysqli_real_escape_string($db2,$_POST['precentase2']);
    $namaSkill = mysqli_real_escape_string($db2,$_POST['namaSkill2']);
    $id_task4 = mysqli_real_escape_string($db2,$_POST['id_task4']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php");

	



?>