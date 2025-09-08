<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_client_project_jenis` set nama_jenis_project = ?, edited_at = ?, edited_by = ? where id_dg_client_project_jenis = ?");
    $stmt1->bind_param("ssss", $nama_jenis_project, $tanggal_now, $id_created, $id_dg_client_project_jenis);
    

    $nama_jenis_project = mysqli_real_escape_string($db2,$_POST['edit_jenis_name']);
    $id_dg_client_project_jenis = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_jenis']);

    $id_created = mysqli_real_escape_string($db2,$_POST['id_user']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../jenis_type.php");

	



?>