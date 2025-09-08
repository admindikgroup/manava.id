<?php
include '../../controller/conn.php';

$id_sprint = $_POST['id_sprint'] ?? null;

if ($id_sprint) {
    $query = "DELETE FROM dg_client_project_sprint WHERE id_dg_client_project_sprint = ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param('i', $id_sprint);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete sprint.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
}
?>
