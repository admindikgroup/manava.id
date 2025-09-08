<?php 
include 'conn.php';
session_start();
session_unset();
session_destroy();

setcookie("cookie_status", "", time() - 3600, "/");
setcookie("priv", "", time() - 3600, "/");
setcookie("daftar", "", time() - 3600, "/");
setcookie("id_user", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");
setcookie("statusX", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");

$_SESSION['status'] = "logout";


header("location:../login.php?");


?>