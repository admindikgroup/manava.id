<?php
include '../../controller/conn.php';
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $color = $_POST['color'] ?? null;
    $urutan_status = $_POST['urutan_status'] ?? null;
    $hasDeadline = $_POST['hasDeadline'] ?? 0;
    $isFinish = $_POST['isFinish'] ?? 0;

    if ($id && $name && $color) {
        try {
            // Dapatkan id_dg_client_project berdasarkan id status yang sedang diupdate
            $stmt = $db2->prepare("SELECT id_dg_client_project FROM dg_client_project_status WHERE id_dg_client_project_status = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id_dg_client_project);
            $stmt->fetch();
            $stmt->close();

            if ($isFinish == 1 && $id_dg_client_project) {
                // Jika status yang sedang diupdate menjadi is_finish = 1, reset status lainnya ke 0 dalam jenis yang sama
                $stmt = $db2->prepare("UPDATE dg_client_project_status SET is_finish = 0 WHERE id_dg_client_project = ? AND id_dg_client_project_status != ?");
                $stmt->bind_param('ii', $id_dg_client_project, $id);
                $stmt->execute();
                $stmt->close();
            }

            // Update status yang sedang diedit
            $stmt = $db2->prepare("UPDATE dg_client_project_status 
                SET nama_status = ?, warna_status = ?, urutan_status = ?, is_deadline_active = ?, is_finish = ? 
                WHERE id_dg_client_project_status = ?");
            $stmt->bind_param('sssssi', $name, $color, $urutan_status, $hasDeadline, $isFinish, $id);
            $stmt->execute();
            $stmt->close();

            $response['success'] = true;
            $response['message'] = 'Status updated successfully!';
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['message'] = 'All fields are required.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
