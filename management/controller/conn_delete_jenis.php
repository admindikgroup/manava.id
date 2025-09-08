<?php 
include 'conn.php';
session_start();

    $id_dg_client_project_jenis = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_jenis_delete']);
    $id_created = mysqli_real_escape_string($db2,$_POST['id_user']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    $update2 = mysqli_query($db2, "UPDATE dg_client_project_type SET 
    deleted_at = '$tanggal_now',
    deleted_by = $id_created
    WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis");


    $update = mysqli_query($db2, "UPDATE dg_client_project_status SET 
    deleted_at = '$tanggal_now',
    deleted_by = $id_created
    WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis");

    if ($update2) {};
    if ($update) {};



    $stmt1 = $db2->prepare("UPDATE `dg_client_project_jenis` set deleted_at = ?, deleted_by = ? where id_dg_client_project_jenis = ?");
    $stmt1->bind_param("sss", $tanggal_now, $id_created, $id_dg_client_project_jenis);

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../jenis_type.php");

	



?>