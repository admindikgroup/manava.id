<?php
session_start();
include '../../controller/conn.php';

// Pastikan bahwa data dikirimkan melalui POST
    $id_dg_client_project = $_POST['id_dg_client_project'];
    $notes_project = $_POST['notes_project'];

    // Update data di database
    $query = "UPDATE dg_client_project SET notes_project = ? WHERE id_dg_client_project = ?";
    if ($stmt = $db2->prepare($query)) {

        // Cari semua gambar di catatan baru
        preg_match_all('/<img[^>]+src="([^">]+)"/', urldecode($notes_project), $matchesNew);
        $newImages = $matchesNew[1]; // Semua URL gambar di catatan baru

        // Dapatkan semua gambar di folder
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            $uploadsDir = 'C:/laragon/www/dggroup2/management/storage/kanban/img/';
        } else {
            $uploadsDir = __DIR__ . '/../../storage/kanban/img/';
        }
        $filesInFolder = array_diff(scandir($uploadsDir), ['.', '..']); // Semua file di folder (kecuali `.` dan `..`)

        // Filter gambar terkait project (berdasarkan prefiks ID project)
        $projectImages = array_filter($filesInFolder, function ($file) use ($id_dg_client_project) {
            return strpos($file, $id_dg_client_project . '-') === 0;
        });

        // Hapus gambar yang tidak ada di catatan baru
        foreach ($projectImages as $image) {
            $filePath = $uploadsDir . $image;
            $imageUrl = 'storage/kanban/img/' . $image;

            if (!in_array($imageUrl, $newImages) && file_exists($filePath)) {
                unlink($filePath); // Hapus file
            }
        }

        // Cari semua video di catatan baru
        preg_match_all('/<video[^>]+src="([^">]+)"/', urldecode($notes_project), $matchesNewV);
        $newVideos = $matchesNewV[1]; // Semua URL video di catatan baru

        // Dapatkan semua video di folder
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            $uploadsDirVideo = 'C:/laragon/www/dggroup2/management/storage/kanban/video/';
        } else {
            $uploadsDirVideo = __DIR__ . '/../../storage/kanban/video/';
        }
        
        
        $filesInFolderVideo = array_diff(scandir($uploadsDirVideo), ['.', '..']); // Semua file di folder (kecuali `.` dan `..`)

        // Filter video terkait project (berdasarkan prefiks ID project)
        $projectVideos = array_filter($filesInFolderVideo, function ($file) use ($id_dg_client_project) {
            return strpos($file, $id_dg_client_project . '-') === 0;
        });

        // Hapus video yang tidak ada di catatan baru
        foreach ($projectVideos as $video) {
            $filePath = $uploadsDirVideo . $video;
            $videoUrl = 'storage/kanban/video/' . $video;            

            if (!in_array($videoUrl, $newVideos) && file_exists($filePath)) {
                unlink($filePath); // Hapus file
            }
        }

        $stmt->bind_param('ss', $notes_project, $id_dg_client_project);
        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }
        $stmt->close();
        
    }
    

header('Content-Type: application/json');
echo json_encode("notes_project = ".urldecode($notes_project)." || filePath = ".$filePath." || newImages =".$newImages[0]);

?>
