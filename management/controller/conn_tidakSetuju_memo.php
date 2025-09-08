<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_rab_detail` SET status_rab = ? WHERE id_dg_rab_detail = ?");
    $stmt1->bind_param("ss", $status_rab, $id_category3);
    
    $status_rab = 4;
    
    $id_category3 = mysqli_real_escape_string($db2,$_POST['id_dg_rab_detail']);


    $stmt1->execute();
    $stmt1->close();
    

	



?>