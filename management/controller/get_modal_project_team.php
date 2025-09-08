<?php
include 'conn.php';
session_start();
// Ambil id dari parameter GET
$id = $_GET['id'];
$nama_project = $_GET['nama_project'];
$id_client = $_GET['id_client'];


// Query untuk mengambil data dari tabel dg_client_project_links
$query = "SELECT cpt.id_dg_user, u.nama
          FROM dg_client_project_team cpt 
          JOIN dg_user u ON cpt.id_dg_user = u.id_dg_user 
          WHERE cpt.id_dg_client_project = $id
          GROUP BY cpt.id_dg_user, u.nama
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
    echo '<h4 class="modal-title" id="teamProject_tittle">Team Project - '.$nama_project.'</h4>';
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
    echo '<th>Jabatan</th>';
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
        echo '<td>';
        $id_user = $row['id_dg_user'];
        $query2 = "SELECT * 
          FROM dg_client_project_team cpt 
          JOIN dg_job j ON cpt.id_dg_job = j.id_dg_job
          WHERE id_dg_client_project = $id and id_dg_user = $id_user";
        $result2 = mysqli_query($db2, $query2);
        while ($row2 = mysqli_fetch_assoc($result2)) {
        echo '<div class="card card-primary" style="display: inline-block; margin: 0px;">
                    <div class="card-header" style="padding: 2px 15px !important;">
                        <p class="card-title">' . $row2['job_name'] . '</p>
                            <div class="card-tools">
                                <button type="button" data-keyboard="false" title="Delete this Team" id="delete-team-btn" 
                                onclick="deleteTeam('. $row2['id_dg_client_project_team'] .')"
                                class="btn btn-tool delete-team-btn" value="'. $row2['id_dg_client_project_team'] .'"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>';
        }
        echo '</td>';
        echo '<td style="text-align: center;">';
        echo '<button class="btn btn-danger btn-sm" data-backdrop="static"';
        echo 'data-keyboard="false" title="Delete this Team"';
        echo 'data-c="'.$id.'"';
        echo 'data-d="'.$id_user.'"';
        echo 'data-v="'.$row['nama'].'"';
        echo 'data-toggle="modal" data-target="#modal-cancel-team">';
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

echo '<input type="hidden" name="id_dg_client_project_to_team" id="id_dg_client_project_to_team" value="'.$id.'">';
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