<?php
include 'conn.php';
session_start();
// Ambil id dari parameter GET
$id = $_GET['id'];
$nama_project = $_GET['nama_project'];


// Query untuk mengambil data dari tabel dg_client_project_type
$query = "SELECT * FROM dg_client_project_type WHERE id_dg_client_project_jenis = $id
AND deleted_at is null";
$result = mysqli_query($db2, $query);

// Cek apakah query berhasil dieksekusi
if ($result) {
    // Buat variabel untuk menyimpan hasil query
    $data = [];

    // Loop melalui hasil query dan tambahkan ke dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Tampilkan data dalam format HTML
    echo '<div class="modal-header">';
    echo '<h4 class="modal-title" id="typeProject_tittle">Type Project - '.$nama_project.'</h4>';
    echo '<input type="hidden" name="nama_project_type" id="nama_project_type" value="'.$nama_project.'">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span>&times;</span>';
    echo '</button>';
    echo '</div>';
    
    echo '<div class="modal-body">';

    echo '<div class="card-body">';
    echo '<table id="example2" class="table table-bordered table-striped" style="font-size: 15px;">';
    echo '<thead>';
    echo '</tr>';
    echo '<th style="width: 5%; text-align: center;">No</th>';
    echo '<th>Nama Type</th>';
    echo '<th style="width: 35%; text-align: center;">Action</th>';
    echo '</tr>';
    echo '</thead>';
    $no_temp =0;
    foreach ($data as $row) {
        $no_temp ++;
        $id_dg_client_project_type = $row['id_dg_client_project_type'];
        $nama_type = $row['nama_type'];
        $detail_project_tamplate = $row['detail_project_tamplate'];

        echo '<tr>';
        echo '<td style="text-align: center;">' . $no_temp . '</td>';
        echo '<td>' . $row['nama_type'] . '</td>';
        echo '<td style="text-align: center;">';

        echo '<button class="btn btn-warning btn-sm" data-backdrop="static"';
        echo 'data-keyboard="false" title="Copy & Edit this type"';
        echo 'onclick="editTypeToProject('.$id_dg_client_project_type.', \''.$nama_type.'\', \''.$detail_project_tamplate.'\')"';
        echo 'data-c="'.$row['id_dg_client_project_type'].'"';
        echo 'data-v="'.$row['nama_type'].'">';
        echo '<i class="fas fa-copy"></i>';
        echo '</i>';
        echo '</button>';

        echo '<button class="btn btn-danger btn-sm" data-backdrop="static"';
        echo 'style="margin-left: 10px;"';
        echo 'data-keyboard="false" title="Delete this type"';
        echo 'data-c="'.$row['id_dg_client_project_type'].'"';
        echo 'data-v="'.$row['nama_type'].'"';
        echo 'data-toggle="modal" data-target="#modal-cancel-type">';
        echo '<i class="fas fa-trash">';
        echo '</i>';
        echo '</button>';


        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';


} else {
    // Jika query gagal, tampilkan pesan error
    echo 'Error: ' . mysqli_error($db2);
}

// Tutup koneksi ke database
mysqli_close($db2);
?>