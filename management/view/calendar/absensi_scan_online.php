<?php 
session_start();
include '../../controller/conn.php';

// Tambahkan skema dan simpan URL saat ini di dalam session
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$_SESSION['previous_url'] = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if(isset($_COOKIE['cookie_status'])) {
    $_SESSION['status'] = $_COOKIE['cookie_status'];
    $_SESSION['priv'] = $_COOKIE['priv'];
    $_SESSION['daftar'] = $_COOKIE['daftar'];
    $_SESSION['id_user'] = $_COOKIE['id_user'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['statusX'] = $_COOKIE['statusX'];
    $_SESSION['email'] = $_COOKIE['email'];
} 

$id_dg_event_detail = $_GET['id_dg_event_detail'];
$id_dg_event = $_GET['id_dg_event'];




// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:../../login.php");
}
if(isset($_SESSION['id_user'])){
    $id_dg_user = $_SESSION['id_user'];
}

$login = mysqli_query($db2,"SELECT * FROM dg_event_detail_attendance WHERE id_dg_event_detail = $id_dg_event_detail AND $id_dg_user = id_dg_user");
while($d_login = mysqli_fetch_array($login)){
    $id_dg_event_detail_attendance = $d_login['id_dg_event_detail_attendance'];
}

// Ambil data jadwal dari database
$jadwal = mysqli_query($db2, "SELECT * FROM dg_event_detail  ded
INNER JOIN dg_event de ON ded.id_dg_event = de.id_dg_event 
WHERE ded.id_dg_event_detail = $id_dg_event_detail");
while($d_jadwal = mysqli_fetch_array($jadwal)){
    $start_time = date('H:i', strtotime($d_jadwal['start_time'] . ' -30 minutes'));
    $finish_time = date('H:i', strtotime($d_jadwal['start_time'] . ' +30 minutes'));
    $dg_event_tanggal = $d_jadwal['dg_event_tanggal']; // Asumsikan tanggal juga ada di database
}

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

// Gabungkan tanggal dan waktu selesai menjadi satu string
$jadwal_mulai_datetime = $dg_event_tanggal . ' ' . $start_time; 
$jadwal_selesai_datetime = $dg_event_tanggal . ' ' . $finish_time; 

// Ambil waktu saat ini
$current_datetime = date('Y-m-d H:i:s'); // Format tanggal: YYYY-MM-DD dan waktu: jam:menit:detik
$current_date = date('Y-m-d'); // Format tanggal: YYYY-MM-DD dan waktu: jam:menit:detik

// Konversi waktu ke timestamp untuk perbandingan
$jadwal_mulai_timestamp = strtotime($jadwal_mulai_datetime);
$jadwal_selesai_timestamp = strtotime($jadwal_selesai_datetime);
$current_time_timestamp = strtotime($current_datetime);

// Bandingkan waktu saat ini dengan jadwal jam selesai
if ($current_time_timestamp < $jadwal_mulai_timestamp) {
    echo "belum di mulai<br>";
    header("location:../../calendar_event_detail.php?id=$id_dg_event&tanggal=$dg_event_tanggal&x=1");
}else if($current_time_timestamp > $jadwal_selesai_timestamp){
    echo "terlambat<br>";
    header("location:../../calendar_event_detail.php?id=$id_dg_event&tanggal=$dg_event_tanggal&x=2");
}else{
    echo "Ok<br>";

$response = array();
$status_absen = 2;

$updated_by = $id_sa_users;

if (empty($id_dg_event_detail_attendance) || $id_dg_event_detail_attendance == "") {
    // Insert new record
    $query = "INSERT INTO dg_event_detail_attendance (id_dg_event_detail, id_dg_user, status_absen, updated_at, updated_by) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $db2->prepare($query)) {
        $stmt->bind_param("sssss", $id_dg_event_detail, $id_dg_user, $status_absen, $tanggal_now, $updated_by);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = $db2->error;
    }
} else {
    // Update existing record
    $query = "UPDATE dg_event_detail_attendance SET status_absen = ?, updated_by = ? WHERE id_dg_event_detail_attendance = ?";
    if ($stmt = $db2->prepare($query)) {
        $stmt->bind_param("iii", $status_absen, $updated_by, $id_dg_event_detail_attendance);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = $db2->error;
    }
}


header("location:../../calendar_event_detail.php?id=$id_dg_event&tanggal=$dg_event_tanggal");
}
?>