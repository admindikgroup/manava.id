<?php 
include 'conn.php';
session_start();
   

    $del_id_dg_client_project_type = mysqli_real_escape_string($db2,$_POST['del_id_dg_client_project_type']);
    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);


    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $update = mysqli_query($db2, "UPDATE dg_client_project_type SET 
    deleted_at = '$tanggal_now',
    deleted_by = $id_user
    WHERE id_dg_client_project_type = $del_id_dg_client_project_type");

    if ($update) {
        echo 'Berhasil';
    } else {
        echo 'Error: ' . mysqli_error($db2);
    }

    // Tutup koneksi ke database
    mysqli_close($db2);

	



?>