<?php 
include 'conn.php';
session_start();
   

    $id_dg_client_project_sprint = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_sprint']);


    $query = "DELETE FROM dg_client_project_sprint WHERE id_dg_client_project_sprint = $id_dg_client_project_sprint";
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