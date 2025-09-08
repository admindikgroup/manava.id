<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_article_category` set nama_category = ?, date_created = ?, id_created = ? where id_dg_article_category = ?");
    $stmt1->bind_param("ssss", $nama_category, $tanggal_now, $id_created, $id_dg_article_category);
    

    $nama_category = mysqli_real_escape_string($db2,$_POST['nama_category']);
    $id_dg_article_category = mysqli_real_escape_string($db2,$_POST['id_category']);

    $id_created = mysqli_real_escape_string($db2,$_POST['id_user']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../article_category.php");

	



?>