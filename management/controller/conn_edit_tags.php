<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_article_tags` set nama_tags = ?, date_created = ?, id_created = ? where id_dg_article_tags = ?");
    $stmt1->bind_param("ssss", $nama_tags, $tanggal_now, $id_created, $id_dg_article_tags);
    

    $nama_tags = mysqli_real_escape_string($db2,$_POST['nama_tags']);
    $id_dg_article_tags = mysqli_real_escape_string($db2,$_POST['id_tags']);

    $id_created = mysqli_real_escape_string($db2,$_POST['id_user']);
    


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../article_category.php");

	



?>