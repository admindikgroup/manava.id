<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("DELETE FROM dg_rab_detail WHERE id_dg_rab_detail = ?");
    $stmt1->bind_param("s", $id_category3);
    

    
    $id_category3 = mysqli_real_escape_string($db2,$_POST['id_dg_rab_detail']);


    $stmt1->execute();
    $stmt1->close();
    

	



?>