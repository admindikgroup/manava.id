<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "../../storage/task/img/"; // Folder tujuan untuk menyimpan gambar
    $file = $_FILES['file'];
    $id_task = $_POST['id_task'];


    // Validasi dan pindahkan file
    $fileName = $id_task . '-' .time() . '-' . basename($file['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Kembalikan URL file
        echo json_encode(['success' => true, 'imageUrl' => "storage/task/img/".$fileName]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupload gambar.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
}
?>
