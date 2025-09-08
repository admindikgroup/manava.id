<?php
session_start();

include '../../controller/conn.php';

    $id_dg_event_detail = $_GET['id_dg_event_detail'];

    // Ambil data notes_mom terbaru dari database
    $stmt = $db2->prepare("SELECT notes_mom FROM dg_event_detail WHERE id_dg_event_detail = ?");
    $stmt->bind_param("i", $id_dg_event_detail);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Pastikan data yang dikembalikan di-encode dengan benar
        echo json_encode([
          "notes_mom" => $row['notes_mom'] // Encode untuk menghindari masalah karakter khusus
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();

    
    //echo json_encode($response);

?>
