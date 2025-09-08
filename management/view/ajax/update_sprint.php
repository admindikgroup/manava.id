<?php
include '../../controller/conn.php';

$id_sprint = $_POST['id_sprint'] ?? null;
$nama_sprint = $_POST['nama_sprint'] ?? '';

if ($id_sprint && $nama_sprint) {
    $query = "UPDATE dg_client_project_sprint SET nama_sprint = ? WHERE id_dg_client_project_sprint = ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param('si', $nama_sprint, $id_sprint);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update sprint.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
}
?>
