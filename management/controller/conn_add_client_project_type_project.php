<?php
include 'conn.php';
session_start();

// Ambil data yang dikirimkan melalui POST
$id_dg_client_project_type = 0;
if (isset($_POST['id_dg_client_project_type']) && $_POST['id_dg_client_project_type']>0) {
    $id_dg_client_project_type = $_POST['id_dg_client_project_type'];
}

$typeName = $_POST['typeName'];
$detail_project_tamplate = $_POST['detail_project_tamplate'];
$id_dg_client_project_to_type = $_POST['id_dg_client_project_to_type'];
$id_user = $_POST['id_user'];

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");


// Periksa apakah ID sudah ada di tabel dg_client_project_type
$check_query = "SELECT id_dg_client_project_type FROM dg_client_project_type WHERE id_dg_client_project_type = $id_dg_client_project_type";
$check_result = mysqli_query($db2, $check_query);

// Jika ID ditemukan, lakukan update
if (mysqli_num_rows($check_result) > 0) {
    $update_query = "
        UPDATE dg_client_project_type
        SET nama_type = '$typeName',
            detail_project_tamplate = '$detail_project_tamplate',
            edited_at = '$tanggal_now',
            edited_by = $id_user
        WHERE id_dg_client_project_type = $id_dg_client_project_type
    ";
    $result = mysqli_query($db2, $update_query);

    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error saat memperbarui data: ' . mysqli_error($db2);
    }
} else {
    // Jika ID tidak ditemukan, simpan data baru
    $insert_query = "
        INSERT INTO dg_client_project_type (id_dg_client_project, nama_type, detail_project_tamplate, created_at, created_by)
        VALUES ($id_dg_client_project_to_type, '$typeName', '$detail_project_tamplate', '$tanggal_now', $id_user)
    ";
    $result = mysqli_query($db2, $insert_query);

    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error saat menyimpan data: ' . mysqli_error($db2);
    }
}

// Tutup koneksi ke database
mysqli_close($db2);
?>
