<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_user_skills WHERE id_dg_user_skills = ?");
    $stmt1->bind_param("s", $id_task2);
    

    
    $id_task2 = mysqli_real_escape_string($db2,$_POST['id_task2']);


    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php");

	



?>