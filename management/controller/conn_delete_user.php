<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_user` set deleted_by = ?, deleted_at = ? where id_dg_user = ?");
    $stmt1->bind_param("sss", $craeted_by, $tanggal_now, $id_task);
    

    
    $craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

    $id_task = mysqli_real_escape_string($db2,$_POST['id_task3']);
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    if ($stmt1->execute()) {
      echo "success";
    } else {
        echo "Error updating record: " . $stmt1->error;
    }
    
    $stmt1->close();

    $profile = 0;
    if (isset($_POST['profile'])) {
         $profile = mysqli_real_escape_string($db2,$_POST['profile']);
    }


  
   
   
	



?>