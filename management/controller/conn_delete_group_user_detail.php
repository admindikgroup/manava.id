<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_user_group_detail WHERE id_dg_user_group_detail = ?");
    $stmt1->bind_param("s", $id_user_group_detail_delete);
    

    
    $id_user_group_detail_delete = mysqli_real_escape_string($db2,$_POST['id_user_group_detail_delete']);


    $stmt1->execute();
    $stmt1->close();

    $division = 0;
    if (isset($_POST['division'])) {
        $division = mysqli_real_escape_string($db2,$_POST['division']);
    }
    
    
    if ($division == 1) {
        //header("location:../division.php");
    }else{
        header("location:../user.php");
    }

	



?>