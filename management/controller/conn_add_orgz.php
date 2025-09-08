<?php
// header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dggroup'; // sesuaikan

$db2 = mysqli_connect($host, $user, $password, $database);

if (!$db2) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal koneksi database']);
    exit();
}

// Ambil data dari form
$name = $_POST['inputName'];
$slug = $_POST['slugName'];
$jenis_usaha = $_POST['organization_jenis_usaha'];
$tanggal_beridri = $_POST['deadline3'] ? date('Y-m-d', strtotime($_POST['deadline3'])) : null;

$email = $_POST['inputorganization_email'];
$telp = $_POST['inputNo'];
$norek = $_POST['inputRe'];
$namabank = $_POST['bankName'];
$npwp = $_POST['npwp'];
$nib = $_POST['nib'];

$country = $_POST['country'];
$province = $_POST['province'];
$city = $_POST['city'];
$district = $_POST['district'];
$village = $_POST['village'];
$alamat = $_POST['address'];
$zipcode = $_POST['zipCode'];

session_start();
$id_user = $_SESSION['id_user'];

$id_user_organization = $_POST['id_dg_user_organization'];

// Upload gambar jika ada
$gambar = $_FILES['lampiran']['name'];
$tmp = $_FILES['lampiran']['tmp_name'];
$upload_dir = "img/organization/";

if ($gambar) {
    $nama_file = time() . '_' . basename($gambar);
    move_uploaded_file($tmp, $upload_dir . $nama_file);
} else {
    $nama_file = $_POST['bannerLama'] ?? ''; // fallback kalau kosong
}

// Simpan ke database
$sql = "INSERT INTO dg_user_organization (
    organization_name, organization_slug, organization_jenis_usaha, organization_tanggal_beridri,
    organization_email, organization_telp, organization_nomor_rekening, organization_nama_bank,
    organization_npwp, organization_nib, organization_country, organization_province, 
    organization_city, organization_district, organization_village, organization_alamat,
    organization_zip_code, organization_logo, created_by
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $db2->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $db2->error);
}
$stmt->bind_param(
    "sssssssssssssssssss",
    $name, $slug, $jenis_usaha, $tanggal_beridri    ,
    $email, $telp, $norek, $namabank, $npwp, $nib,
    $country, $province, $city, $district, $village,
    $alamat, $zipcode, $nama_file, $id_user
);


if ($stmt->execute()) {
    echo "<script>alert('Organization berhasil ditambahkan!'); window.location='../index.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan!'); history.back();</script>";
}
?>
