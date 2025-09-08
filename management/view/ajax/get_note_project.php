<?php
session_start();

include '../../controller/conn.php';

    $id_dg_client_project = $_GET['id_dg_client_project'];

    // Ambil data notes_project terbaru dari database
    $stmt = $db2->prepare("SELECT * FROM dg_client_project 
    WHERE id_dg_client_project = ?");
    $stmt->bind_param("i", $id_dg_client_project);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Pastikan data yang dikembalikan di-encode dengan benar
        echo json_encode([
          "notes_project" => $row['notes_project'] // Encode untuk menghindari masalah karakter khusus
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();

    
    //echo json_encode($response);

?>
