<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_article_category WHERE id_dg_article_category = ?");
    $stmt1->bind_param("s", $id_category3);
    

    
    $id_category3 = mysqli_real_escape_string($db2,$_POST['id_category3']);


    $stmt1->execute();
    $stmt1->close();
    
    header("location:../article_category.php");

	



?>