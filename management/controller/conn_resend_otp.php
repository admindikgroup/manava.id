<?php
include 'conn.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

header('Content-Type: application/json');

// Ambil email: prioritas POST, lalu SESSION
$email = $_POST['email'] ?? ($_SESSION['email'] ?? '');
$username = $_SESSION['username'] ?? 'User';

if (empty($email)) {
  echo json_encode(["status" => "error", "message" => "Email tidak ditemukan."]);
  exit();
}

// Generate OTP baru
$otp = rand(100000, 999999);
$expired = date("Y-m-d H:i:s", strtotime("+10 minutes"));

// Update OTP di database
$query = mysqli_query($db2, "
  UPDATE dg_user 
  SET otp_code = '$otp', otp_expired = '$expired', is_verified = 0
  WHERE email = '" . mysqli_real_escape_string($db2, $email) . "'
");

if (!$query) {
  echo json_encode(["status" => "error", "message" => "Gagal update OTP.", "debug" => mysqli_error($db2)]);
  exit();
}

// Kirim ulang OTP ke email
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'yeremiasagung14@gmail.com';
  $mail->Password = 'jhsj vrxh gdli lkvs'; // ✅ pakai app password Gmail
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('yeremiasagung14@gmail.com', 'DIK Resend OTP');
  $mail->addAddress($email);
  $mail->isHTML(false);
  $mail->Subject = 'Kode OTP Baru Anda';
  $mail->Body = "Halo $username,\n\nKode OTP terbaru Anda adalah: $otp\n\nKode ini berlaku selama 10 menit.";

  $mail->send();

  echo json_encode(["status" => "success", "message" => "Kode OTP baru berhasil dikirim ke $email."]);
} catch (Exception $e) {
  echo json_encode(["status" => "error", "message" => "Gagal mengirim ulang OTP.", "debug" => $mail->ErrorInfo]);
}
