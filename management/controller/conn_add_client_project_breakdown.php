<?php 
include 'conn.php';
session_start();

    $stmt1 = $db2->prepare("INSERT INTO `dg_client_project_breakdown` (id_dg_client_project, id_dg_user_job, id_dg_user,
    nama_komponen, jumlah_komponen, harga_modal, harga_jual, discount, status_breakdown, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt1->bind_param("sssssssssss", $id_dg_client_project, $id_dg_user_job, $id_dg_user,
    $nama_komponen, $jumlah_komponen, $harga_modal, $harga_jual, $discount, $status_breakdown, $id_user, $tanggal_now);
    

    $id_dg_client_project = mysqli_real_escape_string($db2,$_POST['id_dg_client_project']);
    $id_dg_user_job = mysqli_real_escape_string($db2,$_POST['jabatan']);
    $id_dg_user = mysqli_real_escape_string($db2,$_POST['id_user_team']);

    $nama_komponen = mysqli_real_escape_string($db2,$_POST['komponen']);
    $jumlah_komponen = mysqli_real_escape_string($db2,$_POST['jumlahKomponen']);

    $harga_modal = mysqli_real_escape_string($db2,$_POST['hargaModal']);
    $harga_modal = str_replace(".","",$harga_modal);
    $harga_modal = str_replace(",",".",$harga_modal);

    $harga_jual = mysqli_real_escape_string($db2,$_POST['hargaJual']);
    $harga_jual = str_replace(".","",$harga_jual);
    $harga_jual = str_replace(",",".",$harga_jual);

    $discount = mysqli_real_escape_string($db2,$_POST['hargaDiscount']);
    $discount = str_replace(".","",$discount);
    $discount = str_replace(",",".",$discount);    

    
    $status_breakdown = mysqli_real_escape_string($db2,$_POST['status_breakdown2']);

    $id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
    

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    $stmt1->execute();

    // Cek apakah query berhasil dieksekusi atau tidak
    if ($stmt1->affected_rows > 0) {
        echo 'Berhasil';
    } else {
        echo '<br>Error: ' . $stmt1->error;
    }

    $stmt1->close();



    $result_user = mysqli_query($db2,"SELECT * FROM dg_user where id_dg_user = $id_dg_user");
    while($d_user = mysqli_fetch_array($result_user)){
        $nama_rekening = $d_user['nama'];
        $no_rekening = $d_user['nomor_rekening'];
        $nama_bank = $d_user['bank'];
    }

    $result_cp = mysqli_query($db2,"SELECT * FROM dg_client_project where id_dg_client_project = $id_dg_client_project");
    while($d_cp = mysqli_fetch_array($result_cp)){
        $nama_project = $d_cp['nama_project'];
   
    }


    $result_project_breakdown = mysqli_query($db2,"SELECT id_dg_client_project_breakdown FROM dg_client_project_breakdown order by id_dg_client_project_breakdown desc limit 1");
    while($d_project_breakdown = mysqli_fetch_array($result_project_breakdown)){
        $id_dg_client_project_breakdown = $d_project_breakdown['id_dg_client_project_breakdown'];
    }

    
    $stmt2 = $db2->prepare("INSERT INTO `dg_rab_detail` (date_rab, id_dg_division, id_dg_client_project,
    project_name, deskripsi_rab, nama_rekening, no_rekening, nama_bank, amount, status_rab, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt2->bind_param("ssssssssssss", $date_rab, $id_dg_division, $id_dg_client_project,
    $project_name, $deskripsi_rab, $nama_rekening, $no_rekening, $nama_bank, $amount, $status_rab, $id_user, $tanggal_now);


    $id_dg_division = mysqli_real_escape_string($db2,$_POST['id_division']);
    $id_dg_client_project = mysqli_real_escape_string($db2,$_POST['id_dg_client_project']);
    $status_rab = mysqli_real_escape_string($db2,$_POST['status_rab']);
    $deskripsi_rab = $nama_komponen;
    $project_name = $nama_project;


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
        echo '<br>Error: ' . $stmt2->error .'<br>';
    } else {
        // Eksekusi statement untuk dg_client_project_breakdown_rab hanya jika query sebelumnya berhasil
        $result_dg_rab_detail = mysqli_query($db2,"SELECT id_dg_rab_detail FROM dg_rab_detail order by id_dg_rab_detail desc limit 1");
        while($d_dg_rab_detail = mysqli_fetch_array($result_dg_rab_detail)){
            $id_dg_rab_detail = $d_dg_rab_detail['id_dg_rab_detail'];
        }

        $stmt3 = $db2->prepare("INSERT INTO `dg_client_project_breakdown_rab` (id_dg_client_project_breakdown, id_dg_rab_detail) value (?,?)");
        $stmt3->bind_param("ss", $id_dg_client_project_breakdown, $id_dg_rab_detail);

        $stmt3->execute();
        // Cek apakah query berhasil dieksekusi atau tidak
        if ($stmt3->affected_rows <= 0) {
            $successFlag = false;
            echo '<br>Error: ' . $stmt3->error;
        } else {
            echo 'Berhasil';
        }
        $stmt3->close();
    }
}

// Jika semua query dalam loop berhasil dieksekusi, maka echo 'Berhasil'
if ($successFlag) {
    echo 'Berhasil';
}

$stmt2->close();

    



?>