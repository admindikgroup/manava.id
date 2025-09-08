<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dggroup';

$db2 = mysqli_connect($host, $user, $password, $database);
if (!$db2) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal koneksi database']);
    exit();
}


if (!isset($_SESSION['id_user'])) {
    // Backup: cek cookie
    if (isset($_COOKIE['id_user'])) {
        $_SESSION['id_user'] = $_COOKIE['id_user'];
        $_SESSION['id_dg_user_organization'] = $_COOKIE['id_dg_user_organization'] ?? null;
    } else {
        die("User belum login. Session dan Cookie tidak ada.");
    }
}

$userId    = $_SESSION['id_user'];
$userOrgId = $_SESSION['id_dg_user_organization'] ?? null;
$slug      = trim($_POST['organization_slug'] ?? $_POST['slug'] ?? '');

if ($slug === '') {
    die("Slug tidak boleh kosong.");
}

$stmt = $db2->prepare("SELECT id_dg_user_organization FROM dg_user_organization WHERE organization_slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$stmt->bind_result($orgzId);
$stmt->fetch();
$stmt->close();

if (!$orgzId) {
    die("Slug tidak ditemukan.");
}


$stmt = $db2->prepare("
    SELECT id FROM dg_user_orgz_request
    WHERE id_dg_user = ? AND id_dg_user_organization = ? AND status = 'pending'
");
$stmt->bind_param("ii", $userId, $orgzId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    die("Anda sudah mengajukan request ke organisasi ini.");
}
$stmt->close();

$stmt = $db2->prepare("
    INSERT INTO dg_user_orgz_request (id_dg_user, id_dg_user_organization, status)
    VALUES (?, ?, 'pending')
");
$stmt->bind_param("ii", $userId, $orgzId);

if ($stmt->execute()) {
    echo "Request join berhasil dikirim. Menunggu persetujuan admin.";
} else {
    echo "Gagal mengirim request.";
}

$stmt->close();
$db2->close();
