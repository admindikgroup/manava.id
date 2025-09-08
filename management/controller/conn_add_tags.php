<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_article_tags` (nama_tags, date_created, id_created) value (?,?,?)");
    $stmt1->bind_param("sss", $nama_tags, $tanggal_now, $id_user);
    
    
    $nama_tags = mysqli_real_escape_string($db2,$_POST['nama_tags2']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);

    // echo  $nama_tags."<br>";
    // echo  $id_user."<br>";


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();

    $add = mysqli_real_escape_string($db2,$_POST['add']);
    
    if ($add==1) {
        header("location:../article_add.php");
    }else{
        header("location:../article_category.php");
    }

	



?>