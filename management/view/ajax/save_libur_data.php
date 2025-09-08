<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

// Ambil data dari request
$nama_libur = $_POST['nama_libur'] ?? null;
$add_startDate = $_POST['add_startDate'] ?? null;
$add_finishDate = $_POST['add_finishDate'] ?? null;
$keterangan_libur = $_POST['keterangan_libur'] ?? null;
$id_user = $_POST['id_user'];

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

// Jika tidak ada, masukkan data baru
$queryInsert = "
    INSERT INTO dg_event_hari_libur (nama_hari_libur, awal_tanggal_libur, akhir_tanggal_libur, keterangan, created_by, created_at)
    VALUES (?, ?, ?, ?, ?, ?)
";
$stmtInsert = $db2->prepare($queryInsert);
$stmtInsert->bind_param('ssssss', $nama_libur, $add_startDate, $add_finishDate, $keterangan_libur, $id_user, $tanggal_now);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Data successfully added.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add data.']);
}
?>