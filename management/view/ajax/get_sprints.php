<?php
include '../../controller/conn.php';

$id_project = $_GET['id_project'] ?? null;
$search = $_GET['search'] ?? '';

if ($id_project) {
    $query = "SELECT id_dg_client_project_sprint AS id, nama_sprint AS name 
              FROM dg_client_project_sprint 
              WHERE id_dg_client_project = ? AND nama_sprint LIKE ?";
    $stmt = $db2->prepare($query);
    $likeSearch = "%$search%";
    $stmt->bind_param("is", $id_project, $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();

    $sprints = [];
    while ($row = $result->fetch_assoc()) {
        $sprints[] = $row;
    }

    echo json_encode($sprints);
}
?>
