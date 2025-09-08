<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_client_project` (nama_project, id_dg_client, id_dg_client_project_jenis, division, id_marketing, notes_project, 
    tanggal_mulai, tanggal_selesai, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?)");
    $stmt1->bind_param("ssssssssss", $projectName2, $id_client2, $jenisProject2, $division2, $marketing2, $notes2, $start_project2, $finish_project2, $id_user, $tanggal_now);
    

    $projectName2 = mysqli_real_escape_string($db2,$_POST['projectName2']);
    $division2 = mysqli_real_escape_string($db2,$_POST['division2']);
    $marketing2 = mysqli_real_escape_string($db2,$_POST['marketing2']);

    $jenisProject2 = mysqli_real_escape_string($db2,$_POST['jenisProject2']);
    
    $notes2 = $_POST['notes2'];
    $notes2 = rawurlencode($notes2);

    $start_project2 = mysqli_real_escape_string($db2,$_POST['start_project2']);
    $start_project2 = DateTime::createFromFormat('d-F-Y', $start_project2)->format('Y-m-d');

    $finish_project2 = mysqli_real_escape_string($db2,$_POST['finish_project2']);
    $finish_project2 = DateTime::createFromFormat('d-F-Y', $finish_project2)->format('Y-m-d');

    $id_user = mysqli_real_escape_string($db2,$_POST['id_user2']);
    $id_client2 = mysqli_real_escape_string($db2,$_POST['id_client2']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    //echo $projectName2."<br>".$id_client2."<br>".$division2."<br>".$marketing2."<br>".$notes2."<br>".$start_project2."<br>".$finish_project2."<br>".$id_user."<br>".$tanggal_now;

    $stmt1->execute();
    $stmt1->close();
    
    if(isset($_POST['list_project'])){
        header("location:../list_project.php");
    }else{
        header("location:../client_project.php?id_client=$id_client2");
    }
	



?>