<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'conn.php';

$token_raw = $_POST['token'] ?? $_GET['token'] ?? null;

if (empty($token_raw)) {
    $_SESSION['error'] = "Token tidak ditemukan.";
    header("Location: ../forgot_password.php");
    exit();
}

$token = mysqli_real_escape_string($db2, trim($token_raw));

// Ambil data dari form
$password = mysqli_real_escape_string($db2, $_POST['password']);
$confirm_password = mysqli_real_escape_string($db2, $_POST['confirm_password']);

// Validasi password sama
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Password tidak sama.";
    header("Location: ../change_password.php?token=$token");
    exit();
}

// Cek token di tabel reset
$sql = "SELECT * FROM dg_password_resets WHERE token = '$token' AND expires_at > NOW() LIMIT 1";
$result = mysqli_query($db2, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    $_SESSION['error'] = "Token tidak valid atau sudah expired.";
    header("Location: ../forgot_password.php");
    exit();
}

$resetData = mysqli_fetch_assoc($result);
$email = $resetData['email'];

// Hash password baru pakai MD5 (sesuai sistem lama kamu)
$hashedPassword = md5($password);

// Update password user
$update = mysqli_query($db2, "UPDATE dg_user SET password_dg = '$hashedPassword' WHERE email = '$email'");

if ($update) {
    // Hapus token setelah digunakan
    mysqli_query($db2, "DELETE FROM dg_password_resets WHERE email = '$email'");

    $_SESSION['success'] = "Password berhasil diubah. Silakan login dengan password baru.";
    header("Location: ../login.php");
    exit();
} else {
    $_SESSION['error'] = "Gagal mengubah password. Silakan coba lagi.";
    header("Location: ../change_password.php?token=$token");
    exit();
}
