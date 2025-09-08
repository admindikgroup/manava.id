<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_article_tags WHERE id_dg_article_tags = ?");
    $stmt1->bind_param("s", $id_tags3);
    

    
    $id_tags3 = mysqli_real_escape_string($db2,$_POST['id_tags3']);


    $stmt1->execute();
    $stmt1->close();
    
    header("location:../article_category.php");

	



?>