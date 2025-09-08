<?php
session_start();
include '../../controller/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Inisialisasi variabel untuk mendeteksi apakah ada event sebelum/berikutnya
  $has_previous = false;
  $has_next = false;

  $left = 0;
  $currentDate = $_GET['currentDate'];
  $number = $_GET['number'];
  $id_dg_event_detail = $_GET['id_dg_event_detail'];
  $id_dg_event = $_GET['id_dg_event'];

  if ($number<1) {
    $left = 1;
  }
  if ($number<0) {
    $number = sqrt($number*$number);
  }
// Query untuk mengambil data berdasarkan nomor, termasuk join ke dg_event untuk mendapatkan nama_event
if ($left == 1) {
    // Jika nomor negatif, ambil event sebelumnya
    $query = "
    SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
    FROM dg_event_detail 
    JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
    WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal < ? AND dg_event_detail.notes_mom IS NOT NULL
    ORDER BY dg_event_detail.dg_event_tanggal DESC 
    LIMIT 1 OFFSET ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param("isi", $id_dg_event, $currentDate, $number);
} else {
    $number =  $number - 1;
    // Jika nomor positif atau 0, ambil event berikutnya
    $query = "
    SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
    FROM dg_event_detail 
    JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
    WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal > ? AND dg_event_detail.notes_mom IS NOT NULL
    ORDER BY dg_event_detail.dg_event_tanggal ASC 
    LIMIT 1 OFFSET ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param("isi", $id_dg_event, $currentDate, $number);
}


  $stmt->execute();
  $result = $stmt->get_result();


    if ($left == 1) {
        $number = $number+1;
        // Cek apakah ada event sebelum event yang ditemukan
        $prevQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
        FROM dg_event_detail 
        JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
        WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal < ? AND dg_event_detail.notes_mom IS NOT NULL
        ORDER BY dg_event_detail.dg_event_tanggal DESC 
        LIMIT 1 OFFSET ?";
        $prevStmt = $db2->prepare($prevQuery);
        $prevStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
        $prevStmt->execute();
        $prevStmt->store_result();

        if ($prevStmt->num_rows > 0) {
            $has_previous = true;
        }

        $number = $number-1;

        if ($number<1) {

            if ($number<0) {
                $number = sqrt($number*$number);
            }

            // Cek apakah ada event setelah event yang ditemukan
            $nextQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
            FROM dg_event_detail 
            JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
            WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal > ? AND dg_event_detail.notes_mom IS NOT NULL 
            ORDER BY dg_event_detail.dg_event_tanggal ASC 
            LIMIT 1 OFFSET ?";
            $nextStmt = $db2->prepare($nextQuery);
            $nextStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
            $nextStmt->execute();
            $nextStmt->store_result();

            if ($nextStmt->num_rows > 0) {
                $has_next = true;
            }

        }else{
            
            // Cek apakah ada event sebelum event yang ditemukan
            $prevQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
            FROM dg_event_detail 
            JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
            WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal < ? AND dg_event_detail.notes_mom IS NOT NULL
            ORDER BY dg_event_detail.dg_event_tanggal DESC 
            LIMIT 1 OFFSET ?";
            $prevStmt = $db2->prepare($prevQuery);
            $prevStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
            $prevStmt->execute();
            $prevStmt->store_result();

            if ($prevStmt->num_rows > 0) {
                $has_next = true;
            }

        }
    }else{
        $number = $number+1;
        // Cek apakah ada event setelah event yang ditemukan
        $nextQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
        FROM dg_event_detail 
        JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
        WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal > ? AND dg_event_detail.notes_mom IS NOT NULL 
        ORDER BY dg_event_detail.dg_event_tanggal DESC 
        LIMIT 1 OFFSET ?";
        $nextStmt = $db2->prepare($nextQuery);
        $nextStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
        $nextStmt->execute();
        $nextStmt->store_result();

        if ($nextStmt->num_rows > 0) {
            $has_next = true;
        }

        $number = $number-1;

        if ($number<1) {

            $number = $number - 1;
            if ($number<0) {
                $number = sqrt($number*$number);
              }

            // Cek apakah ada event sebelum event yang ditemukan
            $prevQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
            FROM dg_event_detail 
            JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
            WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal < ? AND dg_event_detail.notes_mom IS NOT NULL
            ORDER BY dg_event_detail.dg_event_tanggal DESC 
            LIMIT 1 OFFSET ?";
            $prevStmt = $db2->prepare($prevQuery);
            $prevStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
            $prevStmt->execute();
            $prevStmt->store_result();

            if ($prevStmt->num_rows > 0) {
                $has_previous = true;
            }

        }else{
            
            // Cek apakah ada event setelah event yang ditemukan
            $nextQuery = "SELECT dg_event_detail.id_dg_event, dg_event_detail.id_dg_event_detail, dg_event_detail.notes_mom, dg_event_detail.dg_event_tanggal, dg_event.nama_event 
            FROM dg_event_detail 
            JOIN dg_event ON dg_event_detail.id_dg_event = dg_event.id_dg_event 
            WHERE dg_event_detail.id_dg_event = ? AND dg_event_detail.dg_event_tanggal > ? AND dg_event_detail.notes_mom IS NOT NULL 
            ORDER BY dg_event_detail.dg_event_tanggal DESC 
            LIMIT 1 OFFSET ?";
            $nextStmt = $db2->prepare($nextQuery);
            $nextStmt->bind_param("isi", $id_dg_event, $currentDate, $number);
            $nextStmt->execute();
            $nextStmt->store_result();

            if ($nextStmt->num_rows > 0) {
                $has_previous = true;
            }

        }

    }
    


if ($row = $result->fetch_assoc()) {


    if ($row['notes_mom']==null) {
        $row['notes_mom'] = "-";
    }

    // Format tanggal menjadi "tanggal, nama bulan tahun"
    $formattedDate = date('d F Y', strtotime($row['dg_event_tanggal']));

    
    // Kirim data event yang ditemukan, termasuk nama event dan tanggal
    echo json_encode([
        'success' => true,
        'notes_mom' => $row['notes_mom'],
        'tanggal' => $row['nama_event'] . ' (' . $formattedDate . ')',  // Format baru: nama event (tanggal event)
        'has_previous' => $has_previous,
        'has_next' => $has_next
    ]);
  } else {
    // Jika tidak ada data event ditemukan
    echo json_encode([
        'success' => false,
        'notes_mom' => "-",
        'tanggal' => "-",
        'has_previous' => false,
        'has_next' => $has_next
    ]);

  }

  $stmt->close();
}
?>
