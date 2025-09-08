<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_client_links` set deleted_by = ?, deleted_at = ? where id_dg_client_links = ?");
    $stmt1->bind_param("sss", $id_user, $tanggal_now, $id_dg_client_links);
    

    
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_client = mysqli_real_escape_string($db2,$_POST['id_client']);


    $id_dg_client_links = $_POST['id_dg_client_links3'];;
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../client_links.php?id_client=$id_client");

	



?>