<?php
// Include your database connection file
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $nama_event = trim($_POST['eventTitle']);
    $type_event = trim($_POST['eventType']);
    $background_color = trim($_POST['backgroundColor']);
    $userGroup = trim($_POST['userGroup']);
    $created_by = isset($_POST['created_by']) ? intval($_POST['created_by']) : null;
    $summernote = $_POST['summernote'];

    // Ambil data dari eventData
    $eventData = $_POST['eventData'];

    if ($type_event === 'yearly') {
        $tanggal = isset($eventData['yearlyDate']) ? intval($eventData['yearlyDate']) : null;
        $bulan = isset($eventData['yearlyMonth']) ? intval($eventData['yearlyMonth']) : null;
        $start_year = isset($eventData['startYear']) ? intval($eventData['startYear']) : null;
        $finish_year = isset($eventData['endYear']) ? intval($eventData['endYear']) : null;
        $start_time = isset($eventData['startTime']) ? trim($eventData['startTime']) : null;
        $finish_time = isset($eventData['endTime']) ? trim($eventData['endTime']) : null;
    } elseif ($type_event === 'monthly') {
        $tanggal = isset($eventData['monthlyDate']) ? intval($eventData['monthlyDate']) : null;
        $startBulanTahun = isset($eventData['startMonthYear']) && !empty($eventData['startMonthYear']) ? $eventData['startMonthYear'] : null;
        $finishBulanTahun = isset($eventData['endMonthYear']) && !empty($eventData['endMonthYear']) ? $eventData['endMonthYear'] : null;
    
        $start_year = $start_month = $finish_year = $finish_month = null;
    
        if ($startBulanTahun) {
            list($start_year, $start_month) = explode('-', $startBulanTahun);
        }
    
        if ($finishBulanTahun) {
            list($finish_year, $finish_month) = explode('-', $finishBulanTahun);
        }
    
        $start_time = isset($eventData['startTime']) ? trim($eventData['startTime']) : null;
        $finish_time = isset($eventData['endTime']) ? trim($eventData['endTime']) : null;
    
        echo $startBulanTahun . "yy";
    } elseif ($type_event === 'weekly') {
        $weekly_dow = isset($eventData['dow']) ? $eventData['dow'] : [];
        $weekly_dow = implode(',', $weekly_dow);
        $start_date = isset($eventData['startDate']) ? trim($eventData['startDate']) : null;
        $finish_date = isset($eventData['endDate']) ? trim($eventData['endDate']) : null;
        $start_time = isset($eventData['startTime']) ? trim($eventData['startTime']) : null;
        $finish_time = isset($eventData['endTime']) ? trim($eventData['endTime']) : null;
    } elseif ($type_event === 'pick_date') {
        $start_date = isset($eventData['startDate']) ? trim($eventData['startDate']) : null;
        $finish_date = isset($eventData['endDate']) ? trim($eventData['endDate']) : null;
        $start_time = isset($eventData['startTime']) ? trim($eventData['startTime']) : null;
        $finish_time = isset($eventData['endTime']) ? trim($eventData['endTime']) : null;
    }


    

    // Validate mandatory fields
    if (empty($nama_event) || empty($type_event) || empty($created_by)) {
        $response = array("error" => false, "message" => "Error : Nama event = $nama_event, type event = $type_event, dan created by = $created_by harus diisi.");
        echo json_encode($response);
        exit;
    }
    
    // Get current timestamp for created_at
    date_default_timezone_set('Asia/Jakarta');
    $created_at = date("Y-m-d H:i:s");
  

 
    $stmt2 = $db2->prepare("INSERT INTO dg_event (nama_event, type_event, pesan_default, id_dg_user_group, background_color, tanggal, bulan, start_year, finish_year, start_month, 
    finish_month, start_date, finish_date, weekly_dow, start_time, finish_time, created_at, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssssssssssssssss", $nama_event, $type_event, $summernote, $userGroup, $background_color, 
    $tanggal, $bulan, $start_year, $finish_year, 
    $start_month, $finish_month, $start_date, $finish_date, $weekly_dow,
    $start_time, $finish_time, $created_at, $created_by);

        // Eksekusi pernyataan
        if (!$stmt2->execute()) {
            $response = array("error" => true, "message" => "Error executing statement: " . $stmt2->error);
            echo json_encode($response);
            exit;
        }
    
        // Cek apakah update berhasil
        if ($stmt2->affected_rows > 0) {
            $response = array("success" => true, "message" => "Event berhasil diperbarui!");
        } else {
            $response = array("error" => true, "message" => "No rows updated.");
        }
    
        // Tutup pernyataan dan koneksi
        $stmt2->close();
        $db2->close();
    
        // Kembalikan respons sebagai JSON
        echo json_encode($response);
    
}

?>
