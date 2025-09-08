<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_user_group` (id_dg_division, nama_group, deskripsi_group, created_at, created_by) value (?,?,?,?,?)");
    $stmt1->bind_param("sssss", $id_dg_division, $namaGroup_add, $deslripsiGroup_add, $created_at, $created_by);
    
    $id_dg_division = mysqli_real_escape_string($db2,$_POST['select_division_add']);
    $namaGroup_add = mysqli_real_escape_string($db2,$_POST['namaGroup_add']);
    $deslripsiGroup_add = mysqli_real_escape_string($db2,$_POST['deslripsiGroup_add']);

    $created_by = mysqli_real_escape_string($db2,$_POST['id_user']);

    $division = 0;
    if (isset($_POST['division'])) {
        $division = mysqli_real_escape_string($db2,$_POST['division']);
    }
    


    date_default_timezone_set('Asia/Jakarta');
    $created_at = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();

    if ($division == 1) {
        header("location:../division.php");
    }else{
        header("location:../user.php");
    }
    
    

	



?>