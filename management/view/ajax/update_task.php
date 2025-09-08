<?php
session_start();
include '../../controller/conn.php';

$id_task = $_POST['id_task'] ?? null;
$id_status = $_POST['id_status'] ?? null;
$id_sprint = $_POST['id_sprint'] ?? null;
$id_type = $_POST['id_type'] ?? null;
$priority = $_POST['priority'] ?? null;
$nama_task = $_POST['nama_task'] ?? null;
$detail_project = $_POST['detail_project'] ?? ''; // Decode detail_project jika dikirim ter-encode
$assigned_data = $_POST['assign'] ?? null;
$id_user_edited = $_POST['id_user'] ?? null;

if ($id_task) {
    $db2->begin_transaction();

    try {
        // Update task utama
        $query = "UPDATE dg_client_project_task 
                  SET id_status = ?, id_sprint = ?, id_type = ?, priority = ?, detail_project = ?, nama_task = ?
                  WHERE id_dg_client_project_task = ?";
        $stmt = $db2->prepare($query);
        $stmt->bind_param("iiisssi", $id_status, $id_sprint, $id_type, $priority, $detail_project, $nama_task, $id_task);

        if (!$stmt->execute()) {
            throw new Exception('Failed to update task.');
        }




        // Cari semua gambar di catatan baru
        preg_match_all('/<img[^>]+src="([^">]+)"/', urldecode($detail_project), $matchesNew);
        $newImages = $matchesNew[1]; // Semua URL gambar di catatan baru

        // Dapatkan semua gambar di folder
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            $uploadsDir = 'C:/laragon/www/dggroup2/management/storage/task/img/';
        } else {
            $uploadsDir = __DIR__ . '/../../storage/task/img/';
        }
        $filesInFolder = array_diff(scandir($uploadsDir), ['.', '..']); // Semua file di folder (kecuali `.` dan `..`)

        // Filter gambar terkait project (berdasarkan prefiks ID project)
        $projectImages = array_filter($filesInFolder, function ($file) use ($id_task) {
            return strpos($file, $id_task . '-') === 0;
        });

        // Hapus gambar yang tidak ada di catatan baru
        foreach ($projectImages as $image) {
            $filePath = $uploadsDir . $image;
            $imageUrl = 'storage/task/img/' . $image;

            if (!in_array($imageUrl, $newImages) && file_exists($filePath)) {
                unlink($filePath); // Hapus file
            }
        }



        // Cari semua video di catatan baru
        preg_match_all('/<video[^>]+src="([^">]+)"/', urldecode($detail_project), $matchesNewV);
        $newVideos = $matchesNewV[1]; // Semua URL video di catatan baru

        // Dapatkan semua video di folder
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            $uploadsDirVideo = 'C:/laragon/www/dggroup2/management/storage/task/video/';
        } else {
            $uploadsDirVideo = __DIR__ . '/../../storage/task/video/';
        }
        
        $filesInFolderVideo = array_diff(scandir($uploadsDirVideo), ['.', '..']); // Semua file di folder (kecuali `.` dan `..`)

        // Filter video terkait project (berdasarkan prefiks ID project)
        $projectVideos = array_filter($filesInFolderVideo, function ($file) use ($id_task) {
            return strpos($file, $id_task . '-') === 0;
        });

        // Hapus video yang tidak ada di catatan baru
        foreach ($projectVideos as $video) {
            $filePath = $uploadsDirVideo . $video;
            $videoUrl = 'storage/task/video/' . $video;

            if (!in_array($videoUrl, $newVideos) && file_exists($filePath)) {
                unlink($filePath); // Hapus file
            }
        }

        



        // Hapus tugas sebelumnya terkait deadline dan pengguna
        $queryDeleteAssign = "DELETE FROM dg_client_project_status_assign WHERE id_dg_client_project_task = ?";
        $stmtDelete = $db2->prepare($queryDeleteAssign);
        $stmtDelete->bind_param("i", $id_task);
        if (!$stmtDelete->execute()) {
            throw new Exception('Failed to clear existing assignments.');
        }

        date_default_timezone_set('Asia/Jakarta');
        $tanggal_now = date("Y-m-d H:i:s");

        // Tambahkan data tugas baru jika ada
        if ($assigned_data && is_array($assigned_data)) {
            $queryInsertAssign = "INSERT INTO dg_client_project_status_assign 
                                  (id_dg_client_project_task, id_dg_client_project_status, id_dg_user_assign, deadline_status,
                                  edited_at, edited_by) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $db2->prepare($queryInsertAssign);

            foreach ($assigned_data as $statusId => $users) {
                foreach ($users as $user) {
                    $userDecoded = json_decode($user, true);
                    $id_user = $userDecoded['id_user'] ?? null;
                    $deadline = $userDecoded['deadline'] ?? null;

                    if ($id_user && $deadline) {
                        $stmtInsert->bind_param("iiisss", $id_task, $statusId, $id_user, $deadline, $tanggal_now, $id_user_edited);
                        if (!$stmtInsert->execute()) {
                            throw new Exception('Failed to insert task assignment.');
                        }
                    }
                }
            }
        }

        // Commit transaksi
        $db2->commit();
        echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
    } catch (Exception $e) {
        $db2->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received.']);
}

?>
