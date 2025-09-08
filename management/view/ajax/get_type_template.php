<?php
session_start();
include '../../controller/conn.php';

$id_type = $_GET['id_type'] ?? null;

if ($id_type) {
    $query = "SELECT detail_project_tamplate FROM dg_client_project_type WHERE id_dg_client_project_type = ?";
    $stmt = $db2->prepare($query);
    $stmt->bind_param("i", $id_type);

    if ($stmt->execute()) {
        $stmt->bind_result($template);
        $stmt->fetch();

        echo json_encode([
            'success' => true,
            'template' => $template
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch template.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid type ID.'
    ]);
}
?>
