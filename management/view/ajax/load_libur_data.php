<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$response = ['success' => false, 'data' => []];

$sql = "SELECT * 
FROM dg_event_hari_libur
WHERE akhir_tanggal_libur >= CURDATE()
ORDER BY awal_tanggal_libur ASC;";

$stmt = $db2->prepare($sql);

if (!$stmt) {
    $response = [
        'success' => false,
        'error' => $db2->error // Menangkap error dari koneksi
    ];
    echo json_encode($response);
    exit;
}

if (!$stmt->execute()) {
    $response = [
        'success' => false,
        'error' => $stmt->error // Menangkap error dari query
    ];
    echo json_encode($response);
    exit;
}


$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id_dg_event_hari_libur'],
        'nama_hari_libur' => $row['nama_hari_libur'],
        'awal_tanggal_libur' => $row['awal_tanggal_libur'],
        'akhir_tanggal_libur' => $row['akhir_tanggal_libur'],
        'keterangan' => $row['keterangan']
    ];
}

if (!empty($data)) {
    $response['success'] = true;
    $response['data'] = $data;
}

echo json_encode($response);
?>
