<?php
include 'conn.php';
session_start();

// Koneksi ke database dan query untuk memeriksa ketersediaan ID
$link_team = $_POST['link_team'];
$id_user = $_POST['id_user'];
$query = "SELECT * FROM dg_user WHERE link_team = '$link_team' and id_dg_user != $id_user";
$result = mysqli_query($db2, $query);

// Cek apakah ID tersedia atau tidak
if (mysqli_num_rows($result) > 0) {
    echo 'unavailable';
} else {
    echo 'available';
}
?>