<?php 
session_start();
include 'conn.php';


$username = mysqli_real_escape_string($db2, $_POST['username']);
$password = mysqli_real_escape_string($db2, $_POST['password']);
$password = md5($password); 


$login = mysqli_query($db2, "
    SELECT * FROM dg_user 
    WHERE (username = '$username' OR email = '$username') 
    AND password_dg = '$password' 
    LIMIT 1
");

$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $d_acc = mysqli_fetch_assoc($login); 

    $id_user   = $d_acc['id_dg_user'];
    $status    = $d_acc['status_login'];
    $priv      = $d_acc['status'];
    $email     = $d_acc['email'];
    $otpStatus = $d_acc['is_verified']; 

    if ($otpStatus == 1) {
        
        $_SESSION['status']     = "login";
        $_SESSION['id_dg_user'] = $id_user;
        $_SESSION['username']   = $d_acc['username'];
        $_SESSION['statusX']    = $status;
        $_SESSION['priv']       = $priv;
        $_SESSION['email']      = $email;

        
        $_SESSION['tidak_lengkap'] = (
            empty($d_acc['photo']) ||
            empty($d_acc['nama']) ||
            empty($d_acc['jenis_kelamin']) ||
            empty($d_acc['ulang_tahun']) ||
            empty($d_acc['email']) ||
            empty($d_acc['nomor_hp']) ||
            empty($d_acc['jabatan']) ||
            empty($d_acc['nomor_rekening']) ||
            empty($d_acc['bank']) ||
            empty($d_acc['alamat']) ||
            empty($d_acc['status']) ||
            empty($d_acc['username']) ||
            empty($d_acc['nama_panggilan']) ||
            empty($d_acc['mbti']) ||
            empty($d_acc['quotes'])
        ) ? 1 : 0;

        
        if (isset($_SESSION['previous_url'])) {
            header("Location: " . $_SESSION['previous_url']);
            exit();
        } else {
            header("Location: ../index.php");
            exit();
        }

    } else {
        
        $_SESSION['status']      = "otp_required";
        $_SESSION['otp_pending'] = $id_user;
        $_SESSION['email']       = $email;

        header("Location: ../login.php?pesan=otp");
        exit();
    }

} else {
    // Login gagal
    $_SESSION['status'] = "xx";
    header("Location: ../login.php?pesan=error");
    exit();
}
?>
