<?php
include 'conn.php';
session_start();

// Ambil data yang dikirimkan melalui POST
$id_dg_client_project_sprint = 0;
if (isset($_POST['id_dg_client_project_sprint']) && $_POST['id_dg_client_project_sprint']>0) {
    $id_dg_client_project_sprint = $_POST['id_dg_client_project_sprint'];
}

$id_dg_client_project_to_sprint = $_POST['id_dg_client_project_to_sprint'];
$sprintName = $_POST['sprintName'];
$id_client = $_POST['id_client'];

// Periksa apakah ID sudah ada di tabel dg_client_project_status
$check_query = "SELECT id_dg_client_project_sprint FROM dg_client_project_sprint WHERE id_dg_client_project_sprint = $id_dg_client_project_sprint";
$check_result = mysqli_query($db2, $check_query);

// Jika ID ditemukan, lakukan update
if (mysqli_num_rows($check_result) > 0) {
    $update_query = "
        UPDATE dg_client_project_sprint
        SET nama_sprint = '$sprintName'
        WHERE id_dg_client_project_sprint = $id_dg_client_project_sprint
    ";
    $result = mysqli_query($db2, $update_query);

    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error saat memperbarui data: ' . mysqli_error($db2);
    }
} else {

    // Query untuk menyimpan data ke dalam tabel dg_client_project_sprint
    $query = "INSERT INTO dg_client_project_sprint (id_dg_client_project, nama_sprint) VALUES ($id_dg_client_project_to_sprint, '$sprintName')";
    $result = mysqli_query($db2, $query);

    // Cek apakah ID tersedia atau tidak
    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error: ' . mysqli_error($db2);
    }
}

// Tutup koneksi ke database
mysqli_close($db2);
?>
