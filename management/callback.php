<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'controller/conn.php';
session_start();

$client = new Google_Client();
$googleClientId = getenv('GOOGLE_CLIENT_ID');
$googleClientSecret = getenv('GOOGLE_CLIENT_SECRET');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host     = $_SERVER['HTTP_HOST'];
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

$redirectUri = $protocol . $host . $basePath . '/callback.php';

$client->setRedirectUri($redirectUri);

$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);

        // Ambil data user dari Google
        $google_service = new Google_Service_Oauth2($client);
        $data = $google_service->userinfo->get();

        $email = mysqli_real_escape_string($db2, $data->email);
        $nama = mysqli_real_escape_string($db2, $data->name);

        // Cek apakah user sudah ada
        $cek = mysqli_query($db2, "SELECT * FROM dg_user WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            
            $user = mysqli_fetch_assoc($cek);

            $_SESSION['status'] = "login";
            $_SESSION['id_dg_user'] = $user['id_dg_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['priv'] = $user['status'];
            $_SESSION['email'] = $email;

            header("Location: index.php");
            exit();
        } else {
            // Buat user baru
            $username = explode('@', $email)[0]; // ambil username dari email
            $status_login = '2';
            $status = 1; // user aktif
            $is_verified = 1; // diverifikasi oleh Google
            $created_at = date('Y-m-d H:i:s');

            $insert = mysqli_query($db2, "INSERT INTO dg_user (
                username, email, nama, status_login, status, is_verified, created_at
            ) VALUES (
                '$username', '$email', '$nama', '$status_login', $status, $is_verified, '$created_at'
            )");

            if ($insert) {
                $id_user = mysqli_insert_id($db2);
                $_SESSION['status'] = "login";
                $_SESSION['id_dg_user'] = $id_user;
                $_SESSION['username'] = $username;
                $_SESSION['priv'] = $status;
                $_SESSION['email'] = $email;

                header("Location: index.php");
                exit();
            } else {
                echo "❌ Gagal membuat akun baru: " . mysqli_error($db2);
            }
        }
    } else {
        echo "❌ Error mengambil token dari Google.";
    }
} else {
    echo "❌ Kode otorisasi tidak ditemukan.";
}
