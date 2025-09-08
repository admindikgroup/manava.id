<?php 
include 'conn.php';
session_start();
$id_dg_rab_detail = mysqli_real_escape_string($db2, $_POST['id_dg_rab_detail']);
$isChecked = mysqli_real_escape_string($db2, $_POST['isChecked']);

    
    $stmt1 = $db2->prepare("UPDATE `dg_rab_detail` set check_rab = ? where id_dg_rab_detail = ?");
    $stmt1->bind_param("ss", $isChecked, $id_dg_rab_detail);
    
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    if ($stmt1->affected_rows <= 0) {
        $successFlag = false;
        echo 'Error stmt1: ' . $stmt1->error . "<br>isChecked =".$isChecked. "<br>id_dg_rab_detail =".$id_dg_rab_detail;
    } else if($isChecked==1){
        echo 'Terchecklist';
    }else if($isChecked==0){
        echo 'Unchecklist';
    }
    $stmt1->close();



?>