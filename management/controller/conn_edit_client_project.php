<?php 
include 'conn.php';
session_start();



    $projectName2 = mysqli_real_escape_string($db2,$_POST['projectName']);
    $division2 = mysqli_real_escape_string($db2,$_POST['division']);
    $marketing2 = mysqli_real_escape_string($db2,$_POST['marketing']);

    $jenisProject2 = mysqli_real_escape_string($db2,$_POST['jenisProject']);

    $notes2 = $_POST['notes'];
    $notes2 = rawurlencode($notes2);
    
    $start_project2 = mysqli_real_escape_string($db2,$_POST['start_project']);
    $start_project2 = DateTime::createFromFormat('d-F-Y', $start_project2)->format('Y-m-d');

    $finish_project2 = mysqli_real_escape_string($db2,$_POST['finish_project']);
    $finish_project2 = DateTime::createFromFormat('d-F-Y', $finish_project2)->format('Y-m-d');

    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    $id_client2 = mysqli_real_escape_string($db2,$_POST['id_client']);

    $id_dg_client_project = mysqli_real_escape_string($db2,$_POST['id_dg_client_project']);

    $is_active = mysqli_real_escape_string($db2,$_POST['is_active']);



    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    //echo $projectName2."<br>".$id_client2."<br>".$division2."<br>".$marketing2."<br>".$notes2."<br>".$start_project2."<br>".$finish_project2."<br>".$id_user."<br>".$tanggal_now;




    $stmt1 = $db2->prepare("UPDATE `dg_client_project` set nama_project = ?, id_dg_client = ?, id_dg_client_project_jenis = ?, division = ?, id_marketing = ?, notes_project = ?, 
    tanggal_mulai = ?, tanggal_selesai = ?, is_active = ?, edited_by = ?, edited_at = ? where id_dg_client_project = ?");
    $stmt1->bind_param("ssssssssssss", $projectName2, $id_client2, $jenisProject2, $division2, $marketing2, $notes2, 
    $start_project2, $finish_project2, $is_active, $id_user, $tanggal_now, $id_dg_client_project);
    

    $stmt1->execute();
    $stmt1->close();




    
    $stmt2 = $db2->prepare("UPDATE `dg_rab_detail` set id_dg_division = ? where id_dg_client_project = ?");
    $stmt2->bind_param("ss", $division2, $id_dg_client_project);
    

    $stmt2->execute();
    $stmt2->close();

    
    $invoice = 0;
    $invoice = mysqli_real_escape_string($db2,$_POST['invoice']);

    if($invoice==1){
        header("location:../client_project_invoice.php?id_client=$id_client2&id_dg_project=$id_dg_client_project");
    }else if(isset($_POST['list_project'])){
        header("location:../list_project.php");
    }else{
        header("location:../client_project.php?id_client=$id_client2");
    }
   

	



?>