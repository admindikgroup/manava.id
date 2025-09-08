
<?php
include 'conn.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Ambil dan bersihkan input
$username = mysqli_real_escape_string($db2, trim($_POST['username']));
$email = mysqli_real_escape_string($db2, trim($_POST['email']));
$password = mysqli_real_escape_string($db2, trim($_POST['password']));
$confirm_password = mysqli_real_escape_string($db2, trim($_POST['confirm_password']));

// Validasi input
if (empty($username)) {
  echo json_encode(["status" => "error", "message" => "Username tidak boleh kosong."]); exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(["status" => "error", "message" => "Format email tidak valid."]); exit();
}

if ($password !== $confirm_password) {
  echo json_encode(["status" => "error", "message" => "Konfirmasi password tidak cocok."]); exit();
}

// Cek apakah email atau username sudah ada
$check = mysqli_query($db2, "SELECT id_dg_user FROM dg_user WHERE email = '$email' OR username = '$username'");
if (mysqli_num_rows($check) > 0) {
  echo json_encode(["status" => "error", "message" => "Email atau Username sudah terdaftar."]); exit();
}

// Hash password (lebih baik gunakan password_hash di produksi)
$hashed_password = md5($password);

// Generate OTP
$otp = rand(100000, 999999);
$expired = date("Y-m-d H:i:s", strtotime("+10 minutes"));
$tanggal_now = date("Y-m-d H:i:s");

// Simpan ke database
$query = mysqli_query($db2, "
  INSERT INTO dg_user (
    username, email, password_dg, otp_code, otp_expired, is_verified, status_login, created_at
  ) VALUES (
    '$username', '$email', '$hashed_password', '$otp', '$expired', 0, 1, '$tanggal_now'
  )
");

if (!$query) {
  echo json_encode([
    "status" => "error",
    "message" => "Gagal menyimpan data pengguna.",
    "debug" => mysqli_error($db2)
  ]);
  exit();
}

// Kirim OTP ke email
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'yeremiasagung14@gmail.com'; // ganti dengan emailmu
  $mail->Password = 'jhsj vrxh gdli lkvs';       // app password (bukan password biasa)
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('yeremiasagung14@gmail.com', 'DIK Registration');
  $mail->addAddress($email);
  $mail->isHTML(false);
  $mail->Subject = 'Kode OTP Verifikasi Email Anda';
  $mail->Body = "Halo $username,\n\nKode OTP Anda adalah: $otp\n\nKode ini hanya berlaku selama 10 menit.";

  $mail->send();

  echo json_encode(["status" => "success", "message" => "Akun berhasil dibuat. OTP telah dikirim ke email."]);
} catch (Exception $e) {
  echo json_encode([
    "status" => "error",
    "message" => "Gagal mengirim OTP.",
    "debug" => $mail->ErrorInfo
  ]);
}
?>
