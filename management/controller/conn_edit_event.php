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
    $id_dg_event = trim($_POST['id_dg_event']);
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
        $finish_date = isset($eventData['endDate']) ? trim($eventData['endDate']) : "9999-12-31";
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
  

 
    $sql = "UPDATE dg_event SET ";
    $params = [];
    $types = "";

    // Tentukan update berdasarkan type_event
    if ($type_event === 'yearly') {
        $sql .= "tanggal = ?, bulan = ?, start_year = ?, finish_year = ?, start_time = ?, finish_time = ?, ";
        $types .= "ssssss";
        array_push($params, $tanggal, $bulan, $start_year, $finish_year, $start_time, $finish_time);
    } elseif ($type_event === 'monthly') {
        $sql .= "tanggal = ?, start_year = ?, finish_year = ?, start_month = ?, finish_month = ?, start_time = ?, finish_time = ?, ";
        $types .= "sssssss";
        array_push($params, $tanggal, $start_year, $finish_year, $start_month, $finish_month, $start_time, $finish_time);
    } elseif ($type_event === 'weekly') {
        $sql .= "weekly_dow = ?, start_date = ?, finish_date = ?, start_time = ?, finish_time = ?, ";
        $types .= "sssss";
        array_push($params, $weekly_dow, $start_date, $finish_date, $start_time, $finish_time);
    } elseif ($type_event === 'pick_date') {
        $sql .= "start_date = ?, finish_date = ?, start_time = ?, finish_time = ?, ";
        $types .= "ssss";
        array_push($params, $start_date, $finish_date, $start_time, $finish_time);
    }

    // Kolom-kolom umum yang selalu di-update
    $sql .= "nama_event = ?, pesan_default = ?, type_event = ?, id_dg_user_group = ?, background_color = ?, created_at = ?, created_by = ? ";
    $types .= "sssssss";
    array_push($params, $nama_event, $summernote, $type_event, $userGroup, $background_color, $created_at, $created_by);

    // Tambahkan klausa WHERE
    $sql .= "WHERE id_dg_event = ?";
    $types .= "s";
    array_push($params, $id_dg_event);

        // Siapkan pernyataan
        $stmt2 = $db2->prepare($sql);

        if (!$stmt2) {
            $response = array("error" => true, "message" => "Error preparing statement: " . $db2->error);
            echo json_encode($response);
            exit;
        }
        

        // Bind parameter
        $stmt2->bind_param($types, ...$params);
    
        // Eksekusi pernyataan
        if (!$stmt2->execute()) {
            $response = array("error" => true, "message" => "Error executing statement finish_date : $finish_date: " . $stmt2->error);
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
