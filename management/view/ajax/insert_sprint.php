<?php
include '../../controller/conn.php';

// Ambil data dari request
$id_project = $_POST['id_project'] ?? null;
$nama_sprint = $_POST['nama_sprint'] ?? '';

if ($id_project && $nama_sprint) {
    $query = "INSERT INTO dg_client_project_sprint (id_dg_client_project, nama_sprint) VALUES (?, ?)";
    $stmt = $db2->prepare($query);
    $stmt->bind_param('is', $id_project, $nama_sprint);

    if ($stmt->execute()) {
        $newSprintId = $stmt->insert_id;
        echo json_encode(['success' => true, 'data' => ['id' => $newSprintId, 'text' => $nama_sprint]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert sprint.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
}
?>
