<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("UPDATE `dg_user_group` set id_dg_division = ?, nama_group = ?, deskripsi_group = ?, edited_at = ?, edited_by = ? where id_dg_user_group = ?");
    $stmt1->bind_param("ssssss", $id_dg_division, $namaGroup_edit, $deskripsiGroup_edit, $tanggal_now, $id_created, $id_dg_user_group_edit);
    
    $id_dg_division = mysqli_real_escape_string($db2,$_POST['select_division_edit']);
    $namaGroup_edit = mysqli_real_escape_string($db2,$_POST['namaGroup_edit']);
    $deskripsiGroup_edit = mysqli_real_escape_string($db2,$_POST['deskripsiGroup_edit']);
    
    $id_created = mysqli_real_escape_string($db2,$_POST['id_user']);

    $id_dg_user_group_edit = mysqli_real_escape_string($db2,$_POST['id_dg_user_group_edit']);

    


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
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