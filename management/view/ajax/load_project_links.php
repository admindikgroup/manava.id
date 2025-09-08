<?php
include '../../controller/conn.php';
header('Content-Type: application/json'); // Set header untuk JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dg_client_project = $_POST['id_dg_client_project'];

    $result = mysqli_query($db2, "SELECT * FROM dg_client_project_links WHERE id_dg_client_project = '$id_dg_client_project'");
    $data = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch data from database.'
        ]);
    }
}
?>
