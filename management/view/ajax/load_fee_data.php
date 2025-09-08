<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$response = ['success' => false, 'data' => []];

$sql = "SELECT 
            det.id_dg_event_user_tambahan AS id,
            u.nama AS nama_user,
            e.nama_event,
            det.tambahan_fee_offline,
            det.tambahan_fee_online
        FROM dg_event_user_tambahan det
        JOIN dg_user u ON det.id_dg_user = u.id_dg_user
        JOIN dg_event e ON det.id_dg_event = e.id_dg_event";

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
        'id' => $row['id'],
        'nama_user' => $row['nama_user'],
        'nama_event' => $row['nama_event'],
        'tambahan_fee_offline' => $row['tambahan_fee_offline'],
        'tambahan_fee_online' => $row['tambahan_fee_online'],
    ];
}

if (!empty($data)) {
    $response['success'] = true;
    $response['data'] = $data;
}

echo json_encode($response);
?>
