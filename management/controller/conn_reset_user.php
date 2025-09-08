<?php 
include 'conn.php';
session_start();

    
    $stmt1 = $db2->prepare("UPDATE `dg_user` set password_dg = ? where id_dg_user = ?");
    $stmt1->bind_param("ss", $password_dg, $id_task);
    
    $password_dg = "f213094f59b8ef4da15817086ca6e6c2";
    
    $id_task = mysqli_real_escape_string($db2,$_POST['id_task4']);
        

    if ($stmt1->execute()) {
      echo "success";
    } else {
        echo "Error updating record: " . $stmt1->error;
    }
    $stmt1->close();
    


	



?>