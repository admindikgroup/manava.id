<?php
include 'conn.php';
session_start();

// Ambil data yang dikirimkan melalui POST
$id_dg_client_project_links = 0;
if (isset($_POST['id_dg_client_project_link']) && $_POST['id_dg_client_project_link']>0) {
    $id_dg_client_project_links = $_POST['id_dg_client_project_link'];
}

$id_dg_client_project_to_link = $_POST['id_dg_client_project_to_link'];
$linkName = $_POST['linkName'];
$linkProject = $_POST['linkProject'];
$id_client = $_POST['id_client'];

// Periksa apakah ID sudah ada di tabel dg_client_project_status
$check_query = "SELECT id_dg_client_project_links FROM dg_client_project_links WHERE id_dg_client_project_links = $id_dg_client_project_links";
$check_result = mysqli_query($db2, $check_query);

// Jika ID ditemukan, lakukan update
if (mysqli_num_rows($check_result) > 0) {
    $update_query = "
        UPDATE dg_client_project_links
        SET nama_link = '$linkName',
            link_project = '$linkProject'
        WHERE id_dg_client_project_links = $id_dg_client_project_links
    ";
    $result = mysqli_query($db2, $update_query);

    if ($result) {
        echo 'Berhasil';
    } else {
        echo 'Error saat memperbarui data: ' . mysqli_error($db2);
    }
} else {

    // Query untuk menyimpan data ke dalam tabel dg_client_project_links
    $query = "INSERT INTO dg_client_project_links (id_dg_client_project, nama_link, link_project) VALUES ($id_dg_client_project_to_link, '$linkName', '$linkProject')";
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
