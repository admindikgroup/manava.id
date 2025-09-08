<?php
include '../../controller/conn.php';
header('Content-Type: application/json');

$id_dg_event = $_POST['id_dg_event'];
$id_dg_event_detail = $_POST['id_dg_event_detail'];
$tanggal_baru = $_POST['tanggal_baru']; // format: DD-MMMM-YYYY

// Konversi ke format SQL
$tanggal_baru_sql = date('Y-m-d', strtotime($tanggal_baru));

// Ambil data lama
$q = mysqli_query($db2, "SELECT * FROM dg_event_detail WHERE id_dg_event_detail = '$id_dg_event_detail'");
$data = mysqli_fetch_assoc($q);

if ($data) {
  $tanggal_awal_sql = $data['dg_event_tanggal'];
  $tanggal_ubah_sql = $data['dg_event_tanggal_berubah'];

  // 🛑 Jika tidak ada perubahan (tetap sama dengan awal dan perubahan juga null), stop
  if ($tanggal_baru_sql === $tanggal_awal_sql && is_null($tanggal_ubah_sql)) {
    // Tidak perlu respons apapun
    http_response_code(204); // No Content
    exit;
  }

  // 🛑 Jika memilih ulang tanggal yang sudah pernah diubah, juga tidak lakukan apapun
  if ($tanggal_baru_sql === $tanggal_ubah_sql) {
    http_response_code(204); // No Content
    exit;
  }

  // 🔁 Jika kembali ke tanggal awal, reset perubahan
  if ($tanggal_baru_sql === $tanggal_awal_sql) {
    $query = "UPDATE dg_event_detail 
              SET dg_event_tanggal_berubah = NULL 
              WHERE id_dg_event_detail = '$id_dg_event_detail'";
    mysqli_query($db2, $query);
    echo json_encode(["status" => "reset", "message" => "Tanggal dikembalikan ke semula."]);
  } else {
    // 🔁 Update perubahan tanggal
    $query = "UPDATE dg_event_detail 
              SET dg_event_tanggal_berubah = '$tanggal_baru_sql' 
              WHERE id_dg_event_detail = '$id_dg_event_detail'";
    mysqli_query($db2, $query);
    echo json_encode(["status" => "updated", "message" => "Tanggal event diubah."]);
  }
} else {
  // 🔁 Insert data baru
  $query = "INSERT INTO dg_event_detail 
            (id_dg_event, dg_event_tanggal, dg_event_tanggal_berubah) 
            VALUES ('$id_dg_event', '$tanggal_baru_sql', NULL)";
  mysqli_query($db2, $query);
  echo json_encode(["status" => "created", "message" => "Data event baru dibuat. $id_dg_event_detail"]);
}
?>
