<?php 
include 'conn.php';
session_start();

$id_dg_user = mysqli_real_escape_string($db2,$_POST['nama_team2']);
$nama_project = mysqli_real_escape_string($db2,$_POST['projectName2']);
$deskripsiProject2 = $_POST['deskripsiProject2'];
$id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
$status_rab = mysqli_real_escape_string($db2,$_POST['status_rab']);


    $result_user = mysqli_query($db2,"SELECT * FROM dg_user where id_dg_user = $id_dg_user");
    while($d_user = mysqli_fetch_array($result_user)){
        $nama_rekening = $d_user['nama'];
        $no_rekening = $d_user['nomor_rekening'];
        $nama_bank = $d_user['bank'];
    }


    
    $stmt2 = $db2->prepare("INSERT INTO `dg_rab_detail` (date_rab, id_dg_division, id_dg_client_project,
    project_name, deskripsi_rab, nama_rekening, no_rekening, nama_bank, amount, status_rab, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt2->bind_param("ssssssssssss", $date_rab, $id_dg_division, $id_dg_client_project,
    $project_name, $deskripsi_rab, $nama_rekening, $no_rekening, $nama_bank, $amount, $status_rab, $id_user, $tanggal_now);

    $id_dg_division = mysqli_real_escape_string($db2,$_POST['nama_divisi2']);
    $id_dg_client_project = 0;
    $deskripsi_rab = $deskripsiProject2;
    $project_name = $nama_project;

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    // Loop through selectBulanTahun[] and hargaFee[]
    $successFlag = true; // Flag untuk menandai apakah semua query berhasil dieksekusi
    foreach ($_POST['selectBulanTahun'] as $index => $selectBulanTahun) {
    // Ambil hargaFee yang sesuai dengan index saat ini
    $hargaFee = $_POST['hargaFee'][$index];
    
    // Escape hargaFee
    $amount = mysqli_real_escape_string($db2, $hargaFee);
    $amount = str_replace(".","",$amount);
    $amount = str_replace(",",".",$amount);
    
    // Format tanggal
    $selectBulanTahun = trim($selectBulanTahun) . '-01';
    $dateObj = DateTime::createFromFormat('Y-m-d', $selectBulanTahun);
    $date_rab = $dateObj->format('Y-m-d');


    // Eksekusi statement untuk dg_rab_detail
    $stmt2->execute();

    // Cek apakah query berhasil dieksekusi atau tidak
    if ($stmt2->affected_rows <= 0) {
        $successFlag = false;
        echo 'Error: ' . $stmt2->error .'<br>';
    } 
}

// Jika semua query dalam loop berhasil dieksekusi, maka echo 'Berhasil'
if ($successFlag) {
    echo 'Berhasil';
}

$stmt2->close();

    



?>