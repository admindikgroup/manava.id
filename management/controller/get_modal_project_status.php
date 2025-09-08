<?php
include 'conn.php';
session_start();
// Ambil id dari parameter GET
$id = $_GET['id'];
$nama_project = $_GET['nama_project'];


// Query untuk mengambil data dari tabel dg_client_project_status
$query = "SELECT * FROM dg_client_project_status 
WHERE id_dg_client_project_jenis = $id
AND deleted_at is null
ORDER BY urutan_status is NULL, urutan_status ASC";
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
    echo '<h4 class="modal-title" id="statusProject_tittle">Status Project - '.$nama_project.'</h4>';
    echo '<input type="hidden" name="nama_project_status" id="nama_project_status" value="'.$nama_project.'">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    
    echo '<div class="modal-body">';

    echo '<div class="card-body">';
    echo '<table id="example2" class="table table-bordered table-striped" style="font-size: 15px;">';
    echo '<thead>';
    echo '</tr>';
    echo '<th style="width: 5%; text-align: center;">No</th>';
    echo '<th style="width: 40%;">Nama status</th>';
    echo '<th>Background Color</th>';
    echo '<th style="text-align: center;">Urutan</th>';
    echo '<th style="width: 15%; text-align: center;">Action</th>';
    echo '</tr>';
    echo '</thead>';
    $no_temp =0;
    foreach ($data as $row) {
        $no_temp ++;
        $id_dg_client_project_status = $row['id_dg_client_project_status'];
        $nama_status = $row['nama_status'];
        $warna_status = $row['warna_status'];
        $urutan_status = $row['urutan_status'];
        $is_finish = $row['is_finish'];

        echo '<tr>';
        echo '<td style="text-align: center;">' . $no_temp . '</td>';
        echo '<td>' . $row['nama_status'];
        if ($row['is_finish']==1) {
            echo ' (<i class="fas fa-flag-checkered"></i>)';
        } 
        echo '</td>';
        echo "<td><div style='width: 100%; height: 30px; background-color: ".$row['warna_status']."; border: 1px solid #ccc; border-radius: 3px;'></div></td>";
        echo '<td style="text-align: center;">' . $row['urutan_status'] . '</td>';
        
        echo '<td style="text-align: center;">';

        echo '<button class="btn btn-warning btn-sm" data-backdrop="static"';
        echo 'data-keyboard="false" title="Copy & Edit this status"';
        echo 'onclick="editStatusToProject('.$id_dg_client_project_status.', \''.$nama_status.'\', \''.$warna_status.'\', \''.$urutan_status.'\', \''.$is_finish.'\')"';
        echo 'data-c="'.$row['id_dg_client_project_status'].'"';
        echo 'data-v="'.$row['nama_status'].'"';
        echo 'data-x="'.$row['urutan_status'].'">';
        echo '<i class="fas fa-copy"></i>';
        echo '</i>';
        echo '</button>';

        echo '<button class="btn btn-danger btn-sm" data-backdrop="static"';
        echo 'style="margin-left: 10px;"';
        echo 'data-keyboard="false" title="Delete this status"';
        echo 'data-c="'.$row['id_dg_client_project_status'].'"';
        echo 'data-v="'.$row['nama_status'].'"';
        echo 'data-toggle="modal" data-target="#modal-cancel-status">';
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