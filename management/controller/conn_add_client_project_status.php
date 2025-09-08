<?php
include 'conn.php';
session_start();

// Ambil data yang dikirimkan melalui POST
$id_dg_client_project_status = isset($_POST['id_dg_client_project_status']) ? intval($_POST['id_dg_client_project_status']) : 0;
$statusName = $_POST['statusName'];
$backgroundColor = $_POST['backgroundColor'];
$id_dg_client_project_jenis = $_POST['id_dg_client_project_jenis'];
$urutan_status = $_POST['urutan_status'];
$is_finish = $_POST['is_finish'];
$id_user = $_POST['id_user'];

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

// Periksa apakah ID sudah ada di tabel dg_client_project_status
$check_query = "SELECT id_dg_client_project_status, is_finish FROM dg_client_project_status WHERE id_dg_client_project_status = $id_dg_client_project_status";
$check_result = mysqli_query($db2, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    $row = mysqli_fetch_assoc($check_result);
    $current_is_finish = $row['is_finish'];

    // Jika is_finish berubah dari 0 ke 1, ubah semua status lain dalam jenis ini menjadi 0
    if ($current_is_finish == 0 && $is_finish == 1) {
        $reset_finish_query = "
            UPDATE dg_client_project_status 
            SET is_finish = 0 
            WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis
        ";
        mysqli_query($db2, $reset_finish_query);
    }

    // Lakukan update status
    $update_query = "
        UPDATE dg_client_project_status
        SET nama_status = '$statusName',
            warna_status = '$backgroundColor',
            urutan_status = '$urutan_status',
            is_finish = $is_finish,
            edited_at = '$tanggal_now',
            edited_by = $id_user
        WHERE id_dg_client_project_status = $id_dg_client_project_status
    ";
    $result = mysqli_query($db2, $update_query);

    echo $result ? 'Berhasil' : 'Error saat memperbarui data: ' . mysqli_error($db2);
} else {
    // Jika ID tidak ditemukan, simpan data baru
    if ($is_finish == 1) {
        // Set semua status dalam jenis ini menjadi 0 sebelum menyimpan status baru
        $reset_finish_query = "
            UPDATE dg_client_project_status 
            SET is_finish = 0 
            WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis
        ";
        mysqli_query($db2, $reset_finish_query);
    }

    $insert_query = "
        INSERT INTO dg_client_project_status (id_dg_client_project_jenis, nama_status, warna_status, urutan_status, is_finish, created_at, created_by)
        VALUES ($id_dg_client_project_jenis, '$statusName', '$backgroundColor', '$urutan_status', '$is_finish', '$tanggal_now', $id_user)
    ";
    $result = mysqli_query($db2, $insert_query);

    echo $result ? 'Berhasil' : 'Error saat menyimpan data: ' . mysqli_error($db2);
}

// Tutup koneksi ke database
mysqli_close($db2);
?>
