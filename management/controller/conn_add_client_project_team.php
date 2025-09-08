<?php
include 'conn.php';
session_start();

// Ambil data yang dikirimkan melalui POST

$id_dg_client_project_to_team = $_POST['id_dg_client_project_to_team'];
$teamUser = $_POST['teamUser'];
$teamJabatan = $_POST['teamJabatan'];
$id_client = $_POST['id_client'];

foreach ($teamJabatan as $jabatan) {
    // Query untuk menyimpan data ke dalam tabel dg_client_project_team
    $query = "INSERT INTO dg_client_project_team (id_dg_client_project, id_dg_user, id_dg_job) 
    SELECT * FROM (
        SELECT $id_dg_client_project_to_team AS id_dg_client_project, 
               $teamUser AS id_dg_user, 
               $jabatan AS id_dg_job
    ) AS tmp
    WHERE NOT EXISTS (
        SELECT 1 FROM dg_client_project_team 
        WHERE id_dg_client_project = $id_dg_client_project_to_team 
        AND id_dg_user = $teamUser 
        AND id_dg_job = $jabatan
    ) LIMIT 1";


    $result = mysqli_query($db2, $query);
}
// Cek apakah ID tersedia atau tidak
if ($result) {
    echo 'Berhasil';
} else {
    echo 'Error: ' . mysqli_error($db2);
}

// Tutup koneksi ke database
mysqli_close($db2);
?>
