<?php
include 'conn.php';
session_start();
// Ambil id dari parameter GET
$id = $_GET['id'];
$nama_project = $_GET['nama_project'];
$id_client = $_GET['id_client'];


// Query untuk mengambil data dari tabel dg_client_project_links
$query = "SELECT * FROM dg_client_project_links WHERE id_dg_client_project = $id";
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
    echo '<input type="hidden" name="nama_project_link" id="nama_project_link" value="'.$nama_project.'">';
    echo '<h4 class="modal-title" id="linkProject_tittle">Link Project - '.$nama_project.'</h4>';
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
    echo '<th style="width: 20%;">Nama Link</th>';
    echo '<th>Link</th>';
    echo '<th style="width: 15%; text-align: center;">Action</th>';
    echo '</tr>';
    echo '</thead>';
    $no_temp =0;
    foreach ($data as $row) {
        $id_dg_client_project_links = $row['id_dg_client_project_links'];
        $nama_link = $row['nama_link'];
        $link_project = $row['link_project'];

        $no_temp ++;
        echo '<tr>';
        echo '<td style="text-align: center;">' . $no_temp . '</td>';
        echo '<td>' . $row['nama_link'] . '</td>';
        echo '<td><a href="https://'. $row['link_project'] .'" target="_blank">' . $row['link_project'] . '</a></td>';
       
        echo '<td style="text-align: center;">';

        echo '<button class="btn btn-warning btn-sm" data-backdrop="static"';
        echo 'data-keyboard="false" title="Copy & Edit this Link"';
        echo 'onclick="editLinkToProject('.$id_dg_client_project_links.', \''.$nama_link.'\', \''.$link_project.'\')"';
        echo 'data-c="'.$row['id_dg_client_project_links'].'"';
        echo 'data-v="'.$row['nama_link'].'">';
        echo '<i class="fas fa-copy"></i>';
        echo '</i>';
        echo '</button>';

        echo '<button class="btn btn-danger btn-sm" data-backdrop="static"';
        echo 'style="margin-left: 10px;"';
        echo 'data-keyboard="false" title="Delete this Link"';
        echo 'data-c="'.$row['id_dg_client_project_links'].'"';
        echo 'data-v="'.$row['nama_link'].'"';
        echo 'data-toggle="modal" data-target="#modal-cancel-link">';
        echo '<i class="fas fa-trash">';
        echo '</i>';
        echo '</button>';

        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

echo '<input type="hidden" name="id_dg_client_project_to_link" id="id_dg_client_project_to_link" value="'.$id.'">';
echo '<input type="hidden" name="id_client" id="id_client" value="'.$id_client.'">';


    //echo '<form action="controller/conn_add_client_project_link.php" method="post" enctype="multipart/form-data">';

  
    //echo '</form>';


} else {
    // Jika query gagal, tampilkan pesan error
    echo 'Error: ' . mysqli_error($db2);
}

// Tutup koneksi ke database
mysqli_close($db2);
?>