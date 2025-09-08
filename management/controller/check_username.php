<?php
include 'conn.php';
session_start();

if (isset($_POST['username']) && isset($_POST['id_task'])) {
    $username = mysqli_real_escape_string($db2, $_POST['username']);
    $id_dg_user = mysqli_real_escape_string($db2, $_POST['id_task']);

    $query = "SELECT id_dg_user FROM dg_user WHERE username = '$username' AND deleted_by IS NULL AND NOT id_dg_user = '$id_dg_user'";
    $result = mysqli_query($db2, $query);

    echo (mysqli_num_rows($result) > 0) ? 'exists' : 'available';
} else if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($db2, $_POST['username']);

    $query = "SELECT id_dg_user FROM dg_user WHERE username = '$username' AND deleted_by IS NULL";
    $result = mysqli_query($db2, $query);

    echo (mysqli_num_rows($result) > 0) ? 'exists' : 'available';
} else {
    echo 'error';
}
?>
