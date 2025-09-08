<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conn.php';
session_start();

header('Content-Type: application/json'); // ✅ Important

// Tangkap data dari form
$email = trim($_POST['email']);
$otp = trim($_POST['otp']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode([
    'status' => 'error',
    'message' => 'Format email tidak valid.'
  ]);
  exit();
}

$email = mysqli_real_escape_string($db2, $email);
$otp = mysqli_real_escape_string($db2, $otp);

// Ambil data user
$result = mysqli_query($db2, "SELECT * FROM dg_user WHERE email = '$email'");

if (mysqli_num_rows($result) === 1) {
  $user = mysqli_fetch_assoc($result);

  if ($user['otp_code'] == $otp) {
    $expired = strtotime($user['otp_expired']);
    $now = time();

    if ($now <= $expired) {
      // OTP valid, update akun menjadi verified
      $update = mysqli_query($db2, "UPDATE dg_user SET is_verified = 1, otp_code = NULL, otp_expired = NULL WHERE email = '$email'");

      if ($update) {
        echo json_encode([
          'status' => 'success',
          'message' => 'Verifikasi berhasil. Silakan login.'
        ]);
      } else {
        http_response_code(500);
        echo json_encode([
          'status' => 'error',
          'message' => 'Gagal memperbarui data pengguna.',
          'debug' => mysqli_error($db2)
        ]);
      }
    } else {
      http_response_code(400);
      echo json_encode([
        'status' => 'error',
        'message' => 'Kode OTP sudah kedaluwarsa.'
      ]);
    }
  } else {
    http_response_code(400);
    echo json_encode([
      'status' => 'error',
      'message' => 'Kode OTP salah.'
    ]);
  }
} else {
  http_response_code(400);
  echo json_encode([
    'status' => 'error',
    'message' => 'Email tidak ditemukan.'
  ]);
}
?>
