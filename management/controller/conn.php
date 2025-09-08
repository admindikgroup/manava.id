<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);


$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'dggroup';


$db2 = new mysqli($host, $user, $pass, $dbname);


if ($db2->connect_error) {
    die("Connection failed: " . $db2->connect_error);
}
date_default_timezone_set('Asia/Jakarta');
mysqli_query($db2, "SET time_zone = '+07:00'");
?>
