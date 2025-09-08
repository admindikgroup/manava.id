<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_division` set deleted_by = ?, deleted_at = ? where id_dg_division = ?");
    $stmt1->bind_param("sss", $id_user, $tanggal_now, $id_dg_division);
    

    
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);


    $id_dg_division = $_POST['id_division_notes_divisions3'];;
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../division.php");

	



?>