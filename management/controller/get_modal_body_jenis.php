<?php
include 'conn.php';
session_start();

$result = mysqli_query($db2, "SELECT * FROM `dg_client_project_jenis` WHERE deleted_by IS NULL");
$data = [];
$no = 1;

while ($d_head = mysqli_fetch_array($result)) {
    $id_dg_client_project_jenis = $d_head['id_dg_client_project_jenis'];

    // Fetch Project Status
    $statuses = [];
    $result_ps = mysqli_query($db2, "SELECT * FROM `dg_client_project_status` 
        WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis AND deleted_at IS NULL
        ORDER BY urutan_status is NULL, urutan_status ASC");
    $sub_s = 0;
    while ($d_ps = mysqli_fetch_array($result_ps)) {
        $sub_s++;
        $statuses[] = [
            'order' => $sub_s,
            'color' => $d_ps['warna_status'],
            'name' => $d_ps['nama_status'],
            'is_finish' => $d_ps['is_finish']
        ];
    }

    // Fetch Project Type
    $types = [];
    $result_pt = mysqli_query($db2, "SELECT * FROM `dg_client_project_type` 
        WHERE id_dg_client_project_jenis = $id_dg_client_project_jenis AND deleted_at IS NULL");
    $sub_t = 0;
    while ($d_pt = mysqli_fetch_array($result_pt)) {
        $sub_t++;
        $types[] = [
            'order' => $sub_t,
            'name' => $d_pt['nama_type']
        ];
    }

    // Add data row
    $data[] = [
        'no' => $no++,
        'jenis_project' => $d_head['nama_jenis_project'],
        'id_jenis_project' => $id_dg_client_project_jenis,
        'statuses' => $statuses,
        'types' => $types
    ];
}

// Return JSON
header('Content-Type: application/json');
echo json_encode(['data' => $data]);
