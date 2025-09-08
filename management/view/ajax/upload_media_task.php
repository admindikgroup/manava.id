<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "../../storage/task/video/"; // Folder tujuan untuk menyimpan media
    $file = $_FILES['file'];
    $id_task = $_POST['id_task']; // Ambil ID project dari POST
    $type = $_POST['type']; // Jenis media (image/video)

    // Validasi ukuran file
    if ($file['size'] > 50000 * 1024) { // Maksimum ukuran file 50MB
        echo json_encode(['success' => false, 'message' => 'Ukuran file melebihi 50MB.']);
        exit;
    }

    // Validasi tipe file
    $allowedTypes = $type === 'image' ? ['image/jpeg', 'image/png'] : ['video/mp4', 'video/webm'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Tipe file tidak didukung.']);
        exit;
    }

    // Pindahkan file ke folder tujuan
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Dapatkan ekstensi file
    $fileName = $id_task . '-' . time() . '.' . $extension;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Kembalikan URL file
        echo json_encode([
            'success' => true,
            'videoUrl' => "storage/task/video/".$fileName
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupload media.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
}
?>
