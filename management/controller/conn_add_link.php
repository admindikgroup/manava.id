<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_client_links` (id_dg_client, name_link, dg_link, bobot_link, created_by, 
    created_at) value (?,?,?,?,?,?)");
    $stmt1->bind_param("ssssss", $id_client, $linkName, $dg_link, $bobot, $id_user, $tanggal_now);
    

    $linkName = mysqli_real_escape_string($db2,$_POST['linkName2']);
    $dg_link = mysqli_real_escape_string($db2,$_POST['dg_link2']);
    $bobot = mysqli_real_escape_string($db2,$_POST['bobot2']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user2']);

    $id_client = mysqli_real_escape_string($db2,$_POST['id_client2']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../client_links.php?id_client=$id_client");

	



?>