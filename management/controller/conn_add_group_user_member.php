<?php 
include 'conn.php';
session_start();

    $teamUser = $_POST['teamUser'];
    $id_dg_user_group_to_team = $_POST['id_dg_user_group_to_team'];

    // Cek apakah kombinasi group-user sudah ada
    $cek = $db2->prepare("SELECT COUNT(*) FROM dg_user_group_detail WHERE id_dg_user_group = ? AND id_dg_user = ?");
    $cek->bind_param("ss", $id_dg_user_group_to_team, $teamUser);
    $cek->execute();
    $cek->bind_result($jumlah);
    $cek->fetch();
    $cek->close();

    if ($jumlah > 0) {
        echo 'Data sudah ada';
    } else {

        $stmt1 = $db2->prepare("INSERT INTO `dg_user_group_detail` (id_dg_user_group, id_dg_user) value (?,?)");
        $stmt1->bind_param("ss", $id_dg_user_group_to_team, $teamUser);
        
    }
        
    

    // Cek apakah ID tersedia atau tidak
    if ($stmt1) {
        $stmt1->execute();
        echo 'Berhasil';
    } else if($jumlah == 0){
        echo 'Error: ' . mysqli_error($db2);
    }
    $stmt1->close();

// Tutup koneksi ke database
mysqli_close($db2);
    


?>