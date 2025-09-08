<?php 
include 'conn.php';
session_start();
   

    $id_dg_client_project = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_team']);
    $id_dg_user_delete = mysqli_real_escape_string($db2,$_POST['id_dg_user_delete']);


    $query = "DELETE FROM dg_client_project_team WHERE id_dg_client_project = $id_dg_client_project and id_dg_user = $id_dg_user_delete";
    $result = mysqli_query($db2, $query);


    // Cek apakah ID tersedia atau tidak
    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error: ' . mysqli_error($db2);
    }

    // Tutup koneksi ke database
    mysqli_close($db2);

	



?>