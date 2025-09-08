<?php 
include 'conn.php';
session_start();


    $id_user_group_delete = mysqli_real_escape_string($db2,$_POST['id_user_group_delete']);

    $stmt1 = $db2->prepare("DELETE FROM dg_user_group_detail WHERE id_dg_user_group = ?");
    $stmt1->bind_param("s", $id_user_group_delete);


    $stmt1->execute();
    $stmt1->close();

    
    $stmt2 = $db2->prepare("DELETE FROM dg_user_group WHERE id_dg_user_group = ?");
    $stmt2->bind_param("s", $id_user_group_delete);


    $stmt2->execute();
    $stmt2->close();
    
    $division = 0;
    if (isset($_POST['division'])) {
        $division = mysqli_real_escape_string($db2,$_POST['division']);
    }
    
    
    if ($division == 1) {
        header("location:../division.php");
    }else{
        header("location:../user.php");
    }



?>