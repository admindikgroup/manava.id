<?php 
include 'conn.php';
session_start();


    $stmt1 = $db2->prepare("INSERT INTO `jawaban` (nama_user, no_rek, nama_bank, waktu_jawab) value (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $nama_user, $no_rek, $nama_bank, $waktu_jawab);
    
  
    $nama_user = mysqli_real_escape_string($db2,$_POST['namaUser']);
    $no_rek = mysqli_real_escape_string($db2,$_POST['NoRekening']);
    $nama_bank = mysqli_real_escape_string($db2,$_POST['namaBank']);

    echo $nama_user."<br>";
    echo $no_rek."<br>";
    echo $nama_bank."<br>";


    date_default_timezone_set('Asia/Jakarta');
    $waktu_jawab = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();


    $result_head = mysqli_query($db2,"SELECT * FROM jawaban Where nama_user = '$nama_user' AND no_rek = '$no_rek'");
                                            while($d_head = mysqli_fetch_array($result_head)){ 
                                                $_SESSION['id_jawaban'] = $d_head['id_jawaban'];
                                            }


    
    header("location:../ranking.php");

	



?>