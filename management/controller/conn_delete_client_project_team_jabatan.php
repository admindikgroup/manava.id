<?php
include 'conn.php';
session_start();

// Terima nilai id_dg_client_project_team dari permintaan AJAX
$id_dg_client_project_team = $_POST['id_dg_client_project_team'];

// Query untuk menghapus tim dari tabel dg_client_project_team
$query = "DELETE FROM dg_client_project_team WHERE id_dg_client_project_team = $id_dg_client_project_team";
$result = mysqli_query($db2, $query);

// Periksa apakah penghapusan berhasil atau tidak
if ($result) {
    // Jika berhasil, kirim respons 'Berhasil' kembali ke JavaScript
    echo 'Berhasil';
} else {
    // Jika gagal, kirim respons 'Gagal' kembali ke JavaScript
    echo 'Gagal';
}

// Tutup koneksi ke database
mysqli_close($db2);
?>
