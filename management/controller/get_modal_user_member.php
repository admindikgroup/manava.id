<?php
include 'conn.php';
session_start();
// Ambil id dari parameter GET
$id = $_GET['id'];
$nama_project = $_GET['nama_project'];


// Query untuk mengambil data dari tabel dg_client_project_links
$query = "SELECT *
          FROM dg_user_group_detail cpt 
          JOIN dg_user u ON cpt.id_dg_user = u.id_dg_user 
          WHERE cpt.id_dg_user_group = $id
          ORDER BY cpt.id_dg_user";



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
    echo '<h4 class="modal-title" id="teamProject_tittle">Group Member - '.$nama_project.'</h4>';
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
    echo '<th style="width: 25%;">Nama Team</th>';
    echo '<th style="width: 15%; text-align: center;">Action</th>';
    echo '</tr>';
    echo '</thead>';
    $no_temp =0;
    $id_temp = 0;
    $id_project = 0;
    $id_user = 0;
    foreach ($data as $row) {
        $no_temp ++;
        
        echo '<tr>';
        echo '<td style="text-align: center;">' . $no_temp . '</td>';
        echo '<td>' . $row['nama'] . '</td>';

        echo '<td style="text-align: center;">';
        echo '<button class="btn btn-danger btn-sm" data-backdrop="static"';
        echo 'data-keyboard="false" title="Delete this Team"';
        echo 'data-c="'.$row['id_dg_user_group_detail'].'"';
        echo 'data-v="'.$row['nama'].'"';
        echo 'data-toggle="modal" data-target="#modal-cancel-group-detail">';
        echo '<i class="fas fa-trash">';
        echo '</i>';
        echo '</button>';
        echo '</td>';
        echo '</tr>';
        
        $id_temp = $row['id_dg_user'];
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';

echo '<input type="hidden" name="id_dg_user_group_to_team" id="id_dg_user_group_to_team" value="'.$id.'">';


    //echo '<form action="controller/conn_add_client_project_link.php" method="post" enctype="multipart/form-data">';

  
    //echo '</form>';


} else {
    // Jika query gagal, tampilkan pesan error
    echo 'Error: ' . mysqli_error($db2);
}

// Tutup koneksi ke database
mysqli_close($db2);
?>