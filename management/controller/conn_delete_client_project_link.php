<?php 
include 'conn.php';
session_start();
   

    $id_dg_client_project_link = mysqli_real_escape_string($db2,$_POST['id_dg_client_project_link']);


    $query = "DELETE FROM dg_client_project_links WHERE id_dg_client_project_links = $id_dg_client_project_link";
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