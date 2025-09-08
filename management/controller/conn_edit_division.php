<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_division` set division_name = ?, division_notes = ?, edited_by = ?, 
    edited_at = ? where id_dg_division = ?");
    $stmt1->bind_param("sssss", $divisionName, $division_notes, $id_user, $tanggal_now, $id_dg_division);
    

    $divisionName = mysqli_real_escape_string($db2,$_POST['divisionName']);
    $division_notes = mysqli_real_escape_string($db2,$_POST['division_notes']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_dg_division = mysqli_real_escape_string($db2,$_POST['id_dg_division']);

    $id_client = mysqli_real_escape_string($db2,$_POST['id_client']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../division.php");

	



?>