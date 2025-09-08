<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_division` (division_name, division_notes, created_by, 
    created_at) value (?,?,?,?)");
    $stmt1->bind_param("ssss", $divisionName, $division_notes, $id_user, $tanggal_now);
    

    $divisionName = mysqli_real_escape_string($db2,$_POST['divisionName2']);
    $division_notes = mysqli_real_escape_string($db2,$_POST['division_notes2']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user2']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../division.php");

	



?>