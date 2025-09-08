<?php
// Include your database connection file
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dg_event_delete = trim($_POST['id_dg_event_delete']);

       
    $stmt1 = $db2->prepare("DELETE FROM dg_event WHERE id_dg_event = ?");
    $stmt1->bind_param("s", $id_dg_event_delete);
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

        // Eksekusi pernyataan
        if (!$stmt1->execute()) {
            $response = array("error" => true, "message" => "Error executing statement: " . $stmt1->error);
            echo json_encode($response);
            exit;
        }
    
        // Cek apakah update berhasil
        if ($stmt1->affected_rows > 0) {
            $response = array("success" => true, "message" => "Event berhasil diperbarui!");
        } else {
            $response = array("error" => true, "message" => "No rows updated.");
        }
    
        // Tutup pernyataan dan koneksi
        $stmt1->close();
        $db2->close();
    
        // Kembalikan respons sebagai JSON
        echo json_encode($response);
}

?>
