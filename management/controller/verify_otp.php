<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conn.php';
session_start();

header('Content-Type: application/json'); // biar semua respon JSON

// Tangkap data dari form
$email = isset($_POST['email']) ? urldecode(trim($_POST['email'])) : '';
$otp   = isset($_POST['otp']) ? trim($_POST['otp']) : '';

// Validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Format email tidak valid.'
    ]);
    exit();
}

// Validasi OTP kosong
if (empty($otp)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Kode OTP wajib diisi.'
    ]);
    exit();
}

$email = mysqli_real_escape_string($db2, $email);
$otp   = mysqli_real_escape_string($db2, $otp);

// Ambil data user berdasarkan email
$result = mysqli_query($db2, "SELECT * FROM dg_user WHERE email = '$email'");

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Cek OTP sama?
    if ($user['otp_code'] === $otp) {
        $expired = strtotime($user['otp_expired']);
        $now = time();

        // Cek expired
        if ($now <= $expired) {
            // OTP valid, update jadi verified
            $update = mysqli_query($db2, "
                UPDATE dg_user 
                SET is_verified = 1, otp_code = NULL, otp_expired = NULL 
                WHERE email = '$email'
            ");

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
                    'debug'   => mysqli_error($db2)
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
