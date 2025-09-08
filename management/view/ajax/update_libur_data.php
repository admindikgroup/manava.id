<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

// Ambil data dari request
$nama_libur = $_POST['nama_libur'] ?? null;
$edit_startDate = $_POST['edit_startDate'] ?? null;
$edit_finishDate = $_POST['edit_finishDate'] ?? null;
$keterangan_libur = $_POST['keterangan_libur'] ?? null;
$id_dg_event_hari_libur = $_POST['id_dg_event_hari_libur'] ?? null;
$id_user = $_POST['id_user'];

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");


$update = mysqli_query($db2, "UPDATE dg_event_hari_libur SET 
    nama_hari_libur = '$nama_libur',
    awal_tanggal_libur = '$edit_startDate',
    akhir_tanggal_libur = '$edit_finishDate',
    keterangan = '$keterangan_libur',
    created_by = '$id_user',
    created_at = '$tanggal_now'
    WHERE id_dg_event_hari_libur = '$id_dg_event_hari_libur'");

if ($update) {
    echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update data.']);
}
