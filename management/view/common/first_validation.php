<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php 
// Mengaktifkan session
session_start();

include "controller/conn.php";



$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[3];
if ($components[1] == "dggroup2") {
    $first_part = $components[3];
}


$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
if (isset($_SESSION['id_dg_user'])) {
    $id_userX = $_SESSION['id_dg_user'];
} elseif (isset($_COOKIE['id_dg_user'])) {
    $id_userX = $_COOKIE['id_dg_user'];
} else {
    $id_userX = 0;
}

if (isset($_SESSION['status_up'])) {
    if ($_SESSION['status_up'] == "xx1") {
        echo '<script>alert("Password Lama Tidak Sesuai !");</script>';
    }
    if ($_SESSION['status_up'] == "xx2") {
        echo '<script>alert("Password Baru dan Konfirmasi Password tidak sesuai!");</script>';
    }
    if ($_SESSION['status_up'] == "xx3") {
        echo '<script>alert("Password telah berhasil di ubah!");</script>';
    }
    $_SESSION['status_up'] = "";
}


if (isset($_SESSION['google_login']) && $_SESSION['google_login'] == true) {
    
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $id_user = $_SESSION['id_user'];
    $priv = "user"; 

    setcookie("cookie_status", "login", time() + (86400 * 3), "/");
    setcookie("email", $email, time() + (86400 * 3), "/");
    setcookie("username", $username, time() + (86400 * 3), "/");
    setcookie("id_user", $id_user, time() + (86400 * 3), "/");

    $_SESSION['status'] = "login";
    $_SESSION['id_user'] = $id_user;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

} elseif ($id_userX > 0) {
    
    $result_head = mysqli_query($db2, "SELECT * FROM `dg_user` WHERE id_dg_user = $id_userX AND deleted_at IS NULL");
    if ($d_head = mysqli_fetch_array($result_head)) {
        $photo_user = $d_head['photo'];
        $status_user = $d_head['status'];
    }

    $login = mysqli_query($db2, "SELECT * FROM dg_user du
        LEFT JOIN dg_user_organization duo ON du.id_dg_user_organization = duo.id_dg_user_organization
        WHERE du.id_dg_user = $id_userX");

    if ($d_acc = mysqli_fetch_array($login)) {
        $nama_user = $d_acc['nama'];
        $id_user = $d_acc['id_dg_user'];
        $username = $d_acc['username'];
        $status = $d_acc['status_login'];
        $priv = $d_acc['status'];
        $email = $d_acc['email'];
        $id_dg_user_organization = $d_acc['id_dg_user_organization'];
        $organization_name = !empty($d_acc['organization_name']) ? $d_acc['organization_name'] : 'General User';
        $organization_logo = !empty($d_acc['organization_logo']) ? $d_acc['organization_logo'] : 't0.jpg';
                
        setcookie("priv", $priv ?? "", time() + (86400 * 3), "/");
        setcookie("id_user", $id_user ?? "", time() + (86400 * 3), "/");
        setcookie("username", $username ?? "", time() + (86400 * 3), "/");
        setcookie("statusX", $status ?? "", time() + (86400 * 3), "/");
        setcookie("email", $email ?? "", time() + (86400 * 3), "/");
        setcookie("id_dg_user_organization", $id_dg_user_organization ?? "", time() + (86400 * 3), "/");
        setcookie("organization_name", $organization_name ?? "", time() + (86400 * 3), "/");

       
        $_SESSION['status'] = "login";
        $_SESSION['daftar'] = "xx";
        $_SESSION['id_user'] = $id_user;
        $_SESSION['username'] = $username;
        $_SESSION['statusX'] = $status;
        $_SESSION['priv'] = $priv;
        $_SESSION['email'] = $email;
        $_SESSION['id_dg_user_organization'] = $id_dg_user_organization;
        $_SESSION['organization_name'] = $organization_name;
    }
    else {
        
         header("location:controller/conn_logout.php");
        exit();
    }
} else {
    
    header("location:controller/conn_logout.php");
    exit();
}


if (!isset($_SESSION['priv'])) {
    header("location:controller/conn_logout.php");
    exit();
}



$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$_SESSION['previous_url'] = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Get User Agent
$useragent_device = $_SERVER['HTTP_USER_AGENT'];
?>
