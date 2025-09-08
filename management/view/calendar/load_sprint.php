<?php
include '../../controller/conn.php';

if (isset($_GET['teamspaces'])) {
    $teamspaces = $_GET['teamspaces'];
    $teamspaceIds = implode(',', array_map('intval', $teamspaces)); // Pastikan data aman

    $query = "SELECT dcps.id_dg_client_project_sprint AS id, dcp.nama_project, dcps.nama_sprint 
              FROM dg_client_project_sprint dcps
              INNER JOIN dg_client_project dcp ON dcps.id_dg_client_project = dcp.id_dg_client_project
              WHERE dcps.id_dg_client_project IN ($teamspaceIds)
              ORDER BY dcp.nama_project ASC, dcps.id_dg_client_project_sprint DESC";

    $result = mysqli_query($db2, $query);

    $sprints = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $sprints[] = $row;
    }

    echo json_encode(["success" => true, "sprints" => $sprints]);
} else {
    echo json_encode(["success" => false]);
}
?>
