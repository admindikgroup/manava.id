<?php
include '../../controller/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_event = $_POST['id_event'] ?? [];
    $periode = $_POST['periode'] ?? '';
    $data = $_POST['data'] ?? [];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $id_user = $_POST['id_user'];

    foreach ($data as $item) {
        $id_dg_user = $item['id_dg_user'] ?? '';
        $total_fee = $item['total_fee'] ?? 0;

            $result_user = mysqli_query($db2,"SELECT * FROM dg_user where id_dg_user = $id_dg_user");
            while($d_user = mysqli_fetch_array($result_user)){
                $nama_rekening = $d_user['nama'];
                $no_rekening = $d_user['nomor_rekening'];
                $nama_bank = $d_user['bank'];
            }
        
        
            
            $stmt2 = $db2->prepare("INSERT INTO `dg_rab_detail` (date_rab, id_dg_division, id_dg_client_project,
            project_name, deskripsi_rab, nama_rekening, no_rekening, nama_bank, amount, status_rab, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt2->bind_param("ssssssssssss", $date_rab, $id_dg_division, $id_dg_client_project,
            $project_name, $deskripsi_rab, $nama_rekening, $no_rekening, $nama_bank, $total_fee, $status_rab, $id_user, $tanggal_now);
        
            $id_dg_division = 5;
            $id_dg_client_project = 0;
            $deskripsi_rab ="Absensi Bulanan (".$startDate."-".$endDate.")";
            $project_name = "Absensi Bulanan";
            $status_rab = 1;
        
            date_default_timezone_set('Asia/Jakarta');
            $tanggal_now = date("Y-m-d H:i:s");
        
        
            // Loop through selectBulanTahun[] and hargaFee[]
            $successFlag = true; // Flag untuk menandai apakah semua query berhasil dieksekusi


            
            // Format tanggal
            $selectBulanTahun = trim($periode) . '-01';
            $dateObj = DateTime::createFromFormat('Y-m-d', $selectBulanTahun);
            $date_rab = $dateObj->format('Y-m-d');
        
        
            // Eksekusi statement untuk dg_rab_detail
            $stmt2->execute();
        
            // Cek apakah query berhasil dieksekusi atau tidak
            if ($stmt2->affected_rows <= 0) {
                $successFlag = false;
                echo 'Error: ' . $stmt2->error .'<br>';
            } 
        
        // Jika semua query dalam loop berhasil dieksekusi, maka echo 'Berhasil'
        if ($successFlag) {
            echo 'Berhasil';
        }
        
        $stmt2->close();
    }
}
?>
