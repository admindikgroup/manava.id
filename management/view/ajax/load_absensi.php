<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

$id_event = $_POST['id_event'] ?? []; // Ambil sebagai array
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;

if (empty($id_event) || !$start_date || !$end_date) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Buat string daftar ID event untuk query
$id_event_list = implode(',', array_map('intval', $id_event));

// Ambil semua tanggal absensi dalam rentang
$queryDates = "
    SELECT DISTINCT dg_event_tanggal 
    FROM dg_event_detail 
    WHERE id_dg_event IN ($id_event_list) AND dg_event_tanggal BETWEEN ? AND ? 
    ORDER BY dg_event_tanggal ASC
";
$stmtDates = $db2->prepare($queryDates);
$stmtDates->bind_param('ss', $start_date, $end_date);
$stmtDates->execute();
$resultDates = $stmtDates->get_result();

$dates = [];
while ($row = $resultDates->fetch_assoc()) {
    $dates[] = $row['dg_event_tanggal'];
}

// Ambil user, status absensi, pengeluaran, dan tambahan fee
$queryUsers = "
    SELECT u.id_dg_user, u.nama, d.dg_event_tanggal, a.status_absen, a.pengeluaran, 
           t.tambahan_fee_offline, t.tambahan_fee_online
    FROM dg_event_detail d
    JOIN dg_event_detail_attendance a ON d.id_dg_event_detail = a.id_dg_event_detail
    JOIN dg_user u ON a.id_dg_user = u.id_dg_user
    LEFT JOIN dg_event_user_tambahan t ON u.id_dg_user = t.id_dg_user AND d.id_dg_event = t.id_dg_event
    WHERE d.id_dg_event IN ($id_event_list) AND d.dg_event_tanggal BETWEEN ? AND ?
";
$stmtUsers = $db2->prepare($queryUsers);
$stmtUsers->bind_param('ss', $start_date, $end_date);
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

// Format data seperti biasa


$users = [];
while ($row = $resultUsers->fetch_assoc()) {
    $userId = $row['id_dg_user'];
    if (!isset($users[$userId])) {
        $users[$userId] = [
            'id' => $row['id_dg_user'],
            'name' => $row['nama'],
            'attendance' => [],
            'pengeluaran' => [],
            'tambahan_fee_offline' => [], // Inisialisasi dengan nilai default 0
            'tambahan_fee_online' => [] // Inisialisasi dengan nilai default 0
        ];
    }

    // Menambahkan data absensi dan pengeluaran
    $users[$userId]['attendance'][$row['dg_event_tanggal']] = $row['status_absen'];
    $users[$userId]['pengeluaran'][$row['dg_event_tanggal']] = $row['pengeluaran'];

    // Menambahkan fee tambahan jika tersedia
    if ($row['tambahan_fee_offline'] !== null) {
        $users[$userId]['tambahan_fee_offline'][$row['dg_event_tanggal']] = $row['tambahan_fee_offline'];
    }
    if ($row['tambahan_fee_online'] !== null) {
        $users[$userId]['tambahan_fee_online'][$row['dg_event_tanggal']] = $row['tambahan_fee_online'];
    }
}

// Format response
$response = [
    'success' => true,
    'dates' => $dates,
    'users' => array_values($users),
];
echo json_encode($response);
?>
