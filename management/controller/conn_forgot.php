<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conn.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$identifier = mysqli_real_escape_string($db2, trim($_POST['identifier']));

// Cari user berdasarkan email/username
$sql = "SELECT * FROM dg_user WHERE email = '$identifier' OR username = '$identifier' LIMIT 1";
$result = mysqli_query($db2, $sql);

if (mysqli_num_rows($result) === 0) {
    $_SESSION['error'] = "Email/Username tidak ditemukan.";
    header("Location: ../forgot_password.php");
    exit();
}

$user = mysqli_fetch_assoc($result);
$email = $user['email'];

// Buat token unik
$token = bin2hex(random_bytes(32));

$created_at = date("Y-m-d H:i:s");
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Simpan token ke tabel khusus reset password
mysqli_query($db2, "INSERT INTO dg_password_resets (email, token, created_at, expires_at) VALUES ('$email', '$token', '$created_at', '$expires')");

// Kirim email reset password
$resetLink = "http://mng_dik-main.test:8080/management/change_password.php?token=" . $token;



$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yeremiasagung14@gmail.com'; // emailmu
    $mail->Password = 'jhsj vrxh gdli lkvs'; // app password gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('yeremiasagung14@gmail.com', 'DIK Reset Password');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Reset Password Akun Anda';
    $mail->Body = "
        <p>Halo,</p>
        <p>Kami menerima permintaan reset password untuk akun Anda.</p>
        <p>Silakan klik link berikut untuk membuat password baru:</p>
        <p><a href='$resetLink'>$resetLink</a></p>
        <p>Link ini hanya berlaku selama 1 jam.</p>
    ";

    $mail->send();
    $_SESSION['success'] = "Link reset password sudah dikirim ke email.";
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengirim email. Error: " . $mail->ErrorInfo;
}

header("Location: ../forgot_password.php");
exit();
?>
