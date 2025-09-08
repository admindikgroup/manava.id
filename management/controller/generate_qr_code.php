<?php
// Panggil library PHP QR Code
require '../phpqrcode/qrlib.php';

// Ambil nilai input link_team dari parameter URL
$linkTeam = isset($_GET['link_team']) ? $_GET['link_team'] : '';
$linkTeam = "https://fabriku.com/";
// Tentukan ukuran dan level ECC dari QR Code
$ecc = 'L'; // Level ECC: L, M, Q, H
$size = 10; // Ukuran QR Code dalam modul
$margin = 2; // Jarak margin di sekitar QR Code

// Tentukan alamat file untuk menyimpan QR Code
$folderPath = 'qr_code/'; // Ganti dengan alamat folder yang sesuai
$filename = $folderPath . 'qr_code.png'; // Nama file untuk menyimpan QR Code

// Buat QR Code dengan nilai link_team sebagai isi
QRcode::png($linkTeam, $filename, $ecc, $size, $margin);


// Keluarkan file gambar QR Code sebagai respons
header('Content-Type: image/png');
readfile($filename);

// Hapus file gambar QR Code dari direktori sementara
unlink($filename);
?>
