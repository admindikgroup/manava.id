<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dggroup';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal koneksi database']);
    exit();
}

session_start();
$userId = $_SESSION['id_dg_user']; // dari login

// Ambil organisasi user
$query = "
    SELECT o.id_dg_user_organization, o.organization_name
    FROM dg_user u
    LEFT JOIN dg_user_organization o 
        ON u.id_dg_user_organization = o.id_dg_user_organization
    WHERE u.id_dg_user = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];

if ($row = mysqli_fetch_assoc($result)) {
    if ($row['id_dg_user_organization']) {
        // User sudah join organisasi
        $data[] = $row;
    } else {
        // User belum join organisasi
        $data[] = [
            "id_dg_user_organization" => null,
            "organization_name" => "Belum join organisasi"
        ];
    }
}

echo json_encode($data);