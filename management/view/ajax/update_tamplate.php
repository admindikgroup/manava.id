<?php
session_start();
include '../../controller/conn.php';

// Ambil data dari request
$id_type = $_POST['id_type'] ?? null;
$id_user = $_POST['id_user'] ?? null;
$notes_project_task = $_POST['notes_project_task'] ?? null;

if ($id_type && $notes_project_task) {
    // Query untuk memperbarui detail_project_tamplate
    $query = "UPDATE dg_client_project_type 
              SET detail_project_tamplate = ?, edited_by = ?, edited_at = NOW() 
              WHERE id_dg_client_project_type = ?";
    
    $stmt = $db2->prepare($query);
    $stmt->bind_param("sii", $notes_project_task, $id_user, $id_type);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Template updated successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update the template.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid data received.'
    ]);
}
?>
