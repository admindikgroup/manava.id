<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_client_project` set deleted_by = ?, deleted_at = ? where id_dg_client_project = ?");
    $stmt1->bind_param("sss", $craeted_by, $tanggal_now, $id_task);
    

    
    $craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_task = mysqli_real_escape_string($db2,$_POST['id_dg_client_project3']);

    $id_client2 = mysqli_real_escape_string($db2,$_POST['id_client']);
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    if(isset($_POST['list_project'])){
        header("location:../list_project.php");
    }else{
        header("location:../client_project.php?id_client=$id_client2");
    }
	



?>