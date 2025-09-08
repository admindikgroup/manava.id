<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_user_skills` (id_dg_user, skill_name, percent) value (?,?,?)");
    $stmt1->bind_param("sss", $id_user, $namaSkill, $precentase);
    

    $precentase = mysqli_real_escape_string($db2,$_POST['precentase']);
    $namaSkill = mysqli_real_escape_string($db2,$_POST['namaSkill']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php?id_user=$id_user");

	



?>