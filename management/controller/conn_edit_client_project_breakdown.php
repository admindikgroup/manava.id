<?php 
include 'conn.php';
session_start();

$id_dg_client_project_breakdown = mysqli_real_escape_string($db2, $_POST['id_dg_client_project_breakdown2']);
$id_dg_client_project = mysqli_real_escape_string($db2,$_POST['id_dg_client_project']);
$id_dg_user_job = mysqli_real_escape_string($db2, $_POST['jabatan']);
$id_dg_user = mysqli_real_escape_string($db2, $_POST['id_user_team']);
$nama_komponen = mysqli_real_escape_string($db2, $_POST['komponen']);
$jumlah_komponen = mysqli_real_escape_string($db2, $_POST['jumlahKomponen2']);
$harga_modal = mysqli_real_escape_string($db2, $_POST['hargaModal2']);
$harga_modal = str_replace(".", "", $harga_modal);
$harga_modal = str_replace(",", ".", $harga_modal);
$harga_jual = mysqli_real_escape_string($db2, $_POST['hargaJual2']);
$harga_jual = str_replace(".", "", $harga_jual);
$harga_jual = str_replace(",", ".", $harga_jual);
$discount = mysqli_real_escape_string($db2, $_POST['hargaDiscount2']);
$discount = str_replace(".", "", $discount);
$discount = str_replace(",", ".", $discount);
$id_user = mysqli_real_escape_string($db2, $_POST['id_user']);
$status_breakdown = mysqli_real_escape_string($db2,$_POST['status_breakdown']);

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

// echo 'id_dg_client_project_breakdown = '.$id_dg_client_project_breakdown."<br>";
// echo 'id_dg_client_project = '.$id_dg_client_project."<br>";
// echo 'id_dg_user_job = '.$id_dg_user_job."<br>";
// echo 'id_dg_user = '.$id_dg_user."<br>";
// echo 'nama_komponen = '.$nama_komponen."<br>";
// echo 'jumlah_komponen = '.$jumlah_komponen."<br>";
// echo 'harga_modal = '.$harga_modal."<br>";
// echo 'harga_jual = '.$harga_jual."<br>";
// echo 'discount = '.$discount."<br>";
// echo 'id_user = '.$id_user."<br>";

// Query UPDATE untuk dg_client_project_breakdown
$stmt1 = $db2->prepare("UPDATE `dg_client_project_breakdown` 
                       SET id_dg_user_job=?, id_dg_user=?, nama_komponen=?, jumlah_komponen=?, 
                           harga_modal=?, harga_jual=?, discount=?, status_breakdown=?, edited_by=?, edited_at=? 
                       WHERE id_dg_client_project_breakdown=?");

$stmt1->bind_param("sssssssssss", $id_dg_user_job, $id_dg_user, $nama_komponen, $jumlah_komponen, 
                   $harga_modal, $harga_jual, $discount, $status_breakdown, $id_user, $tanggal_now, $id_dg_client_project_breakdown);

$stmt1->execute();

// Periksa apakah query UPDATE berhasil dieksekusi atau tidak
if ($stmt1->affected_rows > 0) {
    echo 'Berhasil';
} else {
    echo 'Error: ' . $stmt1->error;
}

$stmt1->close();

    $result_user = mysqli_query($db2,"SELECT * FROM dg_user where id_dg_user = $id_dg_user");
    while($d_user = mysqli_fetch_array($result_user)){
        $nama_rekening = $d_user['nama'];
        $no_rekening = $d_user['nomor_rekening'];
        $nama_bank = $d_user['bank'];
        $deleted_at = $d_user['deleted_at'];
    }

    if ($deleted_at!=null) {
        $nama_rekening =  $nama_rekening." (DELETED) ";
    }


    // Mendapatkan bulan sekarang
    $currentMonth = date('m');
    $currentYear = date('Y');

    $currentMY = "$currentYear-$currentMonth";

    $result_rab = mysqli_query($db2,"SELECT *, dcpbr.id_dg_rab_detail as id_dg_rab_detail_d 
    FROM dg_client_project_breakdown_rab dcpbr
    INNER JOIN dg_rab_detail drb
    ON dcpbr.id_dg_rab_detail = drb.id_dg_rab_detail
    where dcpbr.id_dg_client_project_breakdown = $id_dg_client_project_breakdown
    AND DATE_FORMAT(drb.date_rab, '%Y-%m') >= '$currentMY'");
    while($d_rab = mysqli_fetch_array($result_rab)){
        $id_dg_rab_detail_d = $d_rab['id_dg_rab_detail_d'];

            // Menghapus data dg_client_project_breakdown_rab yang memenuhi kriteria date_rab
            $stmt4 = $db2->prepare("DELETE dcpbr FROM dg_client_project_breakdown_rab dcpbr
            INNER JOIN dg_rab_detail drb ON dcpbr.id_dg_rab_detail = drb.id_dg_rab_detail
            WHERE dcpbr.id_dg_client_project_breakdown = ? 
            AND DATE_FORMAT(drb.date_rab, '%Y-%m') >= '$currentMY'");
            $stmt4->bind_param("s", $id_dg_client_project_breakdown);

            $stmt4->execute();
            $stmt4->close();

            // Menghapus data kecuali yang memiliki date_rab pada bulan sebelum bulan saat ini
            $stmt3 = $db2->prepare("DELETE FROM dg_rab_detail WHERE id_dg_rab_detail = ?");
            $stmt3->bind_param("s", $id_dg_rab_detail_d);

            $stmt3->execute();
            $stmt3->close();


    }



    $result_cp = mysqli_query($db2,"SELECT * FROM dg_client_project where id_dg_client_project = $id_dg_client_project");
    while($d_cp = mysqli_fetch_array($result_cp)){
        $nama_project = $d_cp['nama_project'];
   
    }


    $stmt2 = $db2->prepare("INSERT INTO `dg_rab_detail` (date_rab, id_dg_division, id_dg_client_project,
    project_name, deskripsi_rab, nama_rekening, no_rekening, nama_bank, amount, status_rab, created_by, created_at) value (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt2->bind_param("ssssssssssss", $date_rab, $id_dg_division, $id_dg_client_project,
    $project_name, $deskripsi_rab, $nama_rekening, $no_rekening, $nama_bank, $amount, $status_rab, $id_user, $tanggal_now);


    $id_dg_division = mysqli_real_escape_string($db2,$_POST['id_division']);
    $status_rab = mysqli_real_escape_string($db2,$_POST['status_rab']);
    $deskripsi_rab = $nama_komponen;
    $project_name = $nama_project;




    // Loop through selectBulanTahun[] and hargaFee[]
    $successFlag = true; // Flag untuk menandai apakah semua query berhasil dieksekusi
    foreach ($_POST['selectBulanTahun2'] as $index => $selectBulanTahun) {
        // Ambil hargaFee yang sesuai dengan index saat ini
        $hargaFee = $_POST['hargaFee2'][$index];
        
        // Escape hargaFee
        $amount = mysqli_real_escape_string($db2, $hargaFee);
        $amount = str_replace(".","",$amount);
        $amount = str_replace(",",".",$amount);
        
        // Format tanggal
        $selectBulanTahun = trim($selectBulanTahun) . '-01';
        $dateObj = DateTime::createFromFormat('Y-m-d', $selectBulanTahun);
        $date_rab = $dateObj->format('Y-m-d');


        // Mendapatkan bulan sebelumnya
        $previousMonth = date('m', strtotime('-1 month'));

        // Mendapatkan tahun sebelumnya
        $previousYear = date('Y', strtotime('-1 month'));

        // Mendapatkan bulan dari $date_rab
        $date_rab_month = date('m', strtotime($date_rab));

        // Mendapatkan tahun dari $date_rab
        $date_rab_year = date('Y', strtotime($date_rab));

        // Mendapatkan bulan dan tahun dari $date_rab dalam format YYYY-MM
        $date_rab_format = date('Y-m', strtotime($date_rab));

        // Memeriksa apakah $date_rab tidak lebih kecil dari bulan-tahun saat ini
        if ($date_rab_format >= $currentMY) {
            // Eksekusi statement untuk dg_rab_detail
            $stmt2->execute();

            // Cek apakah query berhasil dieksekusi atau tidak
            if ($stmt2->affected_rows <= 0) {
                $successFlag = false;
                echo 'Error stmt2: ' . $stmt2->error .'<br>';
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
                    echo 'Error stmt3: ' . $stmt3->error;
                } else {
                    echo 'Berhasil';
                }
                $stmt3->close();
            }

        }
        
    }

// Jika semua query dalam loop berhasil dieksekusi, maka echo 'Berhasil'
if ($successFlag) {
    echo 'Berhasil';
}

$stmt2->close();

?>
