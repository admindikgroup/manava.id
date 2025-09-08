<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_client_links` set name_link = ?, dg_link = ?, bobot_link = ?, edited_by = ?, 
    edited_at = ? where id_dg_client_links = ?");
    $stmt1->bind_param("ssssss", $linkName, $dg_link, $bobot, $id_user, $tanggal_now, $id_dg_client_links);
    

    $linkName = mysqli_real_escape_string($db2,$_POST['linkName']);
    $dg_link = mysqli_real_escape_string($db2,$_POST['dg_link']);
    $bobot = mysqli_real_escape_string($db2,$_POST['bobot']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_dg_client_links = mysqli_real_escape_string($db2,$_POST['id_dg_client_links']);

    $id_client = mysqli_real_escape_string($db2,$_POST['id_client']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../client_links.php?id_client=$id_client");

	



?>