<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "../../storage/kanban/img/"; // Folder tujuan untuk menyimpan gambar
    $file = $_FILES['file'];
    $id_dg_client_project = $_POST['id_dg_client_project']; // Ambil ID project dari POST


    // Validasi dan pindahkan file
    $fileName = $id_dg_client_project. '-' .time() . '-' . basename($file['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Kembalikan URL file
        echo json_encode(['success' => true, 'imageUrl' => "storage/kanban/img/".$fileName]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupload gambar.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
}
?>
