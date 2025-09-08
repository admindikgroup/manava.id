<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_user_job WHERE id_dg_user_job = ?");
    $stmt1->bind_param("s", $id_task3);
    

    
    $id_task3 = mysqli_real_escape_string($db2,$_POST['id_task3']);


    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php");

	



?>