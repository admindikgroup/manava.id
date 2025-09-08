<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 
$id_dg_event = 0;
if(isset($_GET['id'])){
  $id_dg_event = $_GET['id'];
}
$tanggal = 0;
if(isset($_GET['tanggal'])){
  $tanggal = $_GET['tanggal'];
}
$x = 0;
if(isset($_GET['x'])){
  $x = $_GET['x'];
}

// Periksa apakah data sudah ada
$query_check = "SELECT * FROM dg_event_detail 
                WHERE id_dg_event = '$id_dg_event' 
                AND (dg_event_tanggal = '$tanggal' OR dg_event_tanggal_berubah = '$tanggal')";

$result_check = mysqli_query($db2, $query_check);

// Jika data belum ada, lakukan insert
if (mysqli_num_rows($result_check) == 0) {
    // Jika tidak ada data, lakukan insert
    $query_insert = "INSERT INTO dg_event_detail (id_dg_event, dg_event_tanggal) 
                     VALUES ('$id_dg_event', '$tanggal')";

    mysqli_query($db2, $query_insert);
} 


// Set timezone ke wilayah Indonesia
date_default_timezone_set('Asia/Jakarta');

// Array hari dalam bahasa Indonesia
$hari = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
);

// Array bulan dalam bahasa Indonesia
$bulan = array(
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
);


// Mengonversi string tanggal ke objek DateTime
$date = new DateTime($tanggal);

// Mendapatkan hari, tanggal, bulan, dan tahun
$hari_ini = $hari[$date->format('l')];
$tanggal_ini = $date->format('d');
$bulan_ini = $bulan[$date->format('F')];
$bulan_ini_angka = $bulan[$date->format('M')];
$tahun_ini = $date->format('Y');

$tanggal_mom = $date->format('d F Y');

// Menampilkan format: Hari, tanggal bulan tahun
$tanggal_event_raw = $date->format('d-M-Y');
$tanggal_event = $hari_ini . ", " . $tanggal_ini . " " . $bulan_ini . " " . $tahun_ini;


$result_head = mysqli_query($db2,"select * from dg_event
  where id_dg_event = $id_dg_event");
  while($d_head = mysqli_fetch_array($result_head)){
      $nama_event = $d_head['nama_event']; 
      $id_dg_user_group = $d_head['id_dg_user_group']; 
      $type_event = $d_head['isi_article_pembuka']; 
  }

  
$result_head_event = mysqli_query($db2,"Select * from dg_event_detail
where id_dg_event = $id_dg_event and (dg_event_tanggal = '$tanggal' OR dg_event_tanggal_berubah = '$tanggal')");
while($d_head = mysqli_fetch_array($result_head_event)){
    $id_dg_event_detail = $d_head['id_dg_event_detail'];
}
  

 // Ambil daftar murid berdasarkan kurikulum
$result_member = mysqli_query($db2, "SELECT du.id_dg_user, du.nama, IFNULL(da.status_absen, 4) AS status_absen
FROM dg_user_group_detail dd
INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
LEFT JOIN dg_event_detail_attendance da ON du.id_dg_user = da.id_dg_user AND da.id_dg_event_detail = $id_dg_event_detail
WHERE dd.id_dg_user_group = $id_dg_user_group");
 $memberIDs = [];
 while ($row = mysqli_fetch_assoc($result_member)) {
     $memberIDs[] = $row;
 }

$result_rg = mysqli_query($db2, "SELECT * FROM dg_user_group WHERE id_dg_user_group = $id_dg_user_group");
  while ($row_rg = mysqli_fetch_assoc($result_rg)) {   
  $nama_group = $row_rg['nama_group'];
  }


 // Pastikan variabel $memberIDs di-encode dalam format JSON sebelum digunakan di JavaScript
 $memberIDsJSON = json_encode($memberIDs);

?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management Article | DIK Group</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <!-- Prism.js CSS -->
    <link rel="stylesheet" href="plugins/prism/prism.css">
    <style>
        .none {
            display: none;
        }
        /* Hanya warna background dropdown-item saat hover */
        .dropdown-item:hover {
          background-color: #007bff;
          color: white;
        }

        /* Tapi override select supaya tidak berubah warna dan background */
        .dropdown-item select {
          background-color: white !important;
          color: black !important;
          border-color: #ced4da;
        }



        .dtr-data {
            display: block;
        }

        .dtr-data .btn {
            white-space: initial;
        }

        table.dataTable>thead .sorting:after,
        table.dataTable>thead .sorting:before {
            content: "";
        }

        .xx:before {
            display: none !important;
        }



        .select2-container--default .select2-selection--single {
            height: 38px;
        }

        .input-group{
          min-width: 200px;
        }

        .dropdown-menu{
          z-index: 999;
        }

        .bootstrap-datetimepicker-widget {
            position: absolute;
            z-index: 9999 !important;
        }



        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
          .taskTableAdd{
            overflow: none;
          }
          .taskTable{
            overflow: none;
          }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
          .taskTableAdd{
            overflow: scroll;
          }
          .taskTable{
            overflow: scroll;
          }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">




  <div class="wrapper">
    <!-- Navbar -->
    <?php include "./view/common/navbar.php" ?>

    <?php include "./view/common/aside.php" ?>

    <div class="modal fade" id="modal-x">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Maaf, waktu event belum dimulai.</p>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal Konfirmasi Kirim MoM -->
    <div class="modal fade" id="modalConfirmSendMoM" tabindex="-1" role="dialog" aria-labelledby="modalConfirmSendMoMLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="modalConfirmSendMoMLabel">Konfirmasi Kirim MoM</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="modalSendMoMMessage">Yakin ingin mengirim MoM?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-success" id="btnConfirmSendMoM">Kirim</button>
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal-y">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Maaf, anda sudah terlambat.</p>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <div class="modal fade" id="modal-qrcode">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Scan Untuk Absensi Kehadiran Offline !<br>Batas waktu 30
              menit dari meeting dimulai.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php
                            // Mendapatkan URL lengkap dari halaman saat ini
                            $fullUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            
                            // Mengambil path tanpa query string
                            $path = parse_url($fullUrl, PHP_URL_PATH);
                            
                            // Menghilangkan file `.php` dari URL
                            $directoryUrl = dirname($path);
                            
                            // Membuat URL dasar sebelum file `.php`
                            $baseUrl = "https://$_SERVER[HTTP_HOST]$directoryUrl/";



                              // Panggil library PHP QR Code
                              require 'phpqrcode/qrlib.php';

                              // Fungsi untuk membuat QR Code
                              function generateQRCode($link, $filename) {
                                  // Tentukan ukuran dan level ECC dari QR Code
                                  $ecc = 'L'; // Level ECC: L, M, Q, H
                                  $size = 10; // Ukuran QR Code dalam modul
                                  $margin = 2; // Jarak margin di sekitar QR Code

                                  // Generate QR Code
                                  QRcode::png($link, $filename, $ecc, $size, $margin);
                              }

                              // Contoh penggunaan fungsi generateQRCode
                              
                                $link = $baseUrl."view/calendar/absensi_scan.php?id_dg_event_detail=".$id_dg_event_detail."&id_dg_event=".$id_dg_event; // Link yang ingin Anda jadikan QR Code
                                $filename = "qr_code/qr_code_absensi_offline_".$id_dg_event_detail.".png"; // Nama file untuk menyimpan QR Code
                              
                             

                              // Panggil fungsi generateQRCode
                              generateQRCode($link, $filename);

                              echo "<img style='height: 100%;' class='form-control' src='$filename' alt='QR Code'>";
                    ?>
          </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-qrcode-online">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Scan Untuk Absensi Kehadiran Online !<br>Batas waktu 30 menit
              dari meeting dimulai.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php                              

                              // Contoh penggunaan fungsi generateQRCode
                              
                                $link2 = $baseUrl."view/calendar/absensi_scan_online.php?id_dg_event_detail=".$id_dg_event_detail."&id_dg_event=".$id_dg_event; // Link yang ingin Anda jadikan QR Code
                                $filename2 = "qr_code/qr_code_absensi_online_".$id_dg_event_detail.".png"; // Nama file untuk menyimpan QR Code
                              
                             

                              // Panggil fungsi generateQRCode
                              generateQRCode($link2, $filename2);

                              echo "<img style='height: 100%;' class='form-control' src='$filename2' alt='QR Code'>";
                    ?>
          </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
    <input type="hidden" name="id_dg_event_detail" value="<?php echo $id_dg_event_detail; ?>">
    <input type="hidden" name="id_dg_event" value="<?php echo $id_dg_event; ?>">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">

            <div class="card card-outline card-info" style="margin-top: 10px;">
              <div class="card-header">
                <h3 class="card-title">Detail Event</h3>
              </div>

              <div class="card-body">
                <div class="form-group row">
                  <!-- Nama Event (Read-Only) -->
                  <div class="col-12 col-md-6">
                    <label for="nama_event" class="col-sm-12 col-form-label">Event Name</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="nama_event" name="nama_event"
                        value="<?php echo $nama_event; ?>" readonly>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 row">
                    <label for="dg_event_tanggal" class="col-12 col-form-label">Event Date</label>
                    <div class="col-10">
                      <div class="input-group date" id="eventDateGroup" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input"
                              id="dg_event_tanggal"
                              name="dg_event_tanggal"
                              value="<?php echo $tanggal_event_raw; ?>"
                              data-target="#eventDateGroup"
                              readonly />
                        
                      </div>
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn btn-md btn-primary" id="btnEditDate">
                        <i class="fas fa-edit"></i>
                      </button>
                    </div>
                  </div>



                </div>
              </div>

            </div>

            <div class="card card-outline card-info" id="attend">
              <div class="card-header" onclick="toggleCard(this)">
                <h3 class="card-title">Attendance : <?php echo $nama_group; ?></h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">
                <div class="form-group row">


                  <div class="col-12">
                    <div class="col-sm-12">
                      <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative;"
                        data-toggle="modal" data-target="#modal-qrcode" class="btn btn-raised btn-primary">Show QR |
                        Offline</button>
                      <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative;"
                        data-toggle="modal" data-target="#modal-qrcode-online" class="btn btn-raised btn-primary">Show
                        QR | Online</button>
                      <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="text-align: center;">No</th>
                            <th>Full Name</th>
                            <th style="text-align: center;">Expenses</th>
                            <th style="text-align: center;">On-Site</th>
                            <th style="text-align: center;">Remote</th>
                            <th style="text-align: center;">Leave</th>
                            <th style="text-align: center;">Sick</th>
                            <th style="text-align: center;">Unexcused</th>
                          </tr>
                        </thead>
                        <tbody id="absensi-table-body">

                        </tbody>
                      </table>


                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="card card-outline card-info">
              <div class="card-header">
                  <h3 class="card-title">Minute of Meeting</h3>
              </div>

              <div class="card-body">
                <div class="form-group row">

                  <div class="row">
                    <!-- Notes MoM Sblmnya (Summernote) -->
                    <div class="col-md-6 col-12 row">

                      <div class="col-12 col-md-9">
                        <label for="notes_mom_sblm" class="col-sm-12 col-form-label">Notes MoM : <br><b
                            id="tanggal_mom_sblm">xxx</b></label>
                      </div>
                      <div class="col-12 col-md-3 text-right">
                        <!-- Tombol Ke Kiri dan Ke Kanan -->
                        <button type="button" id="btnLeft" class="btn btn-sm btn-primary">&larr;</button>
                        <button type="button" id="btnRight" class="btn btn-sm btn-primary">&rarr;</button>
                      </div>
                      <div class="col-sm-12">
                        <textarea id="summernote_sblm" name="notes_mom_sblm"></textarea>
                      </div>
                    </div>

                    <!-- Notes MoM (Summernote) -->
                    <div class="col-md-6 col-12 row">

                      <div class="col-12 col-md-9">
                        <label for="notes_mom" class="col-sm-12 col-form-label">Notes MoM
                          <br><b><?php echo $nama_event." (".$tanggal_mom.")";?></b></label>
                      </div>
                      <div class="col-12 col-md-3">
                        <div class="form-group" style="text-align: right;">
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="customSwitch3">
                            <label class="custom-control-label" for="customSwitch3">Editor Mode</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <textarea id="summernote" name="notes_mom"></textarea>
                      </div>
                      <div class="col-4">
                        <button type="button" class="btn btn-info" style="width: 100%;" id="tidyUp" title="Tidy Up with AI">
                          Tidy Up with AI ✨
                        </button>
                      </div>
                      
                      <div class="col-8">
                        <div class="dropdown" style="width: 100%;">
                          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownSendMoM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;">
                            <i class="fa fa-solid fa-paper-plane mr-2"></i> Send MoM
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownSendMoM" style="width: 100%;">
                            <a class="dropdown-item" href="#" id="send-announcement">To Announcement</a>
                            <a class="dropdown-item" href="#" id="send-wa-group">To WA Group in <?php echo $nama_group; ?></a>
                            <a class="dropdown-item" href="#" id="send-to-all">To All Individu in <?php echo $nama_group; ?></a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item">
                              <select id="select-individual" class="form-control">
                                <option value="">-- Send to Individual --</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>

                </div>

              </div>
            </div>

            <div class="card card-outline card-info">
              <div class="card-header">
                  <h3 class="card-title">Task Add - <?php echo $nama_group; ?></h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <!-- Tabel No, Task, Owner Task, Delete -->
                  <div class="col-sm-12">
                    <div class="col-sm-12 taskTableAdd">
                      <table id="taskTableAdd" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="min-width: 250px;">Task</th>
                            <th style="min-width: 150px;">Owner Task</th>
                            <th style="min-width: 150px;">Deadline</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><input type="text" name="task_add" style="min-width: 200px;" class="form-control"></td>
                            <td>
                              <select class="form-control owner-select select2" name="owner_add"
                                style="width: 100%;">
                                <option value="">-- Select Owner --</option>
                                <?php
                                  $result_user = mysqli_query($db2, "SELECT * FROM `dg_user_group_detail` dd
                                  INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                                  WHERE dd.id_dg_user_group = $id_dg_user_group");
                                        while ($row = mysqli_fetch_assoc($result_user)) {
                                          echo '<option value="'.$row['id_dg_user'].'">'.$row['nama'].'</option>';
                                        }
                                  ?>
                              </select>
                            </td>
                            <td style="text-align: center; width: 25%;">
                              <div class="input-group date col-sm-12" id="reservationdate_add"
                                data-target-input="nearest">
                                <input type="text" name="deadline_add"
                                  class="form-control datetimepicker-input deadline_add"
                                  data-target="#reservationdate_add" value="">
                                <div class="input-group-append" data-target="#reservationdate_add"
                                  data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-12 col-md-6"></div>
                      <div class="col-12 col-md-6">
                        <button type="button" id="saveTask" class="btn btn-success" style="width: 100%; float: right;">
                        <i class="fa fa-save"></i> Save Task</button>
                      </div>
                    </div>
                  </div>

                  <br><br>

                </div>

              </div>
            </div>



            <div class="card card-outline card-info">
              <div class="card-header">
                  <h3 class="card-title">Task List - <?php echo $nama_group; ?></h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <!-- Tabel No, Task, Owner Task, Delete -->
                  <div class="col-sm-12">
                    <div class="col-sm-12 taskTable">
                      <table id="taskTable" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="text-align: center; width: 10%;">No</th>
                            <th style="min-width: 250px;">Task</th>
                            <th style="min-width: 150px;">Owner Task</th>
                            <th style="min-width: 150px;">Deadline</th>
                            <th style="min-width: 150px;">Status</th>
                            <th style="text-align: center;">Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                      <p style="text-align: left; font-size: 15px; margin-left: 15px; margin-top: 15px;">Notes: <br>
                          1. Task dengan status yang belum Done / Cancel, akan terus dimunculkan diatas.<br>
                          2. Task dengan status Done akan muncul selama 7 hari setelah Done di-klik.<br>
                          3. Task yang di Cancel akan langsung menghilang, namun muncul di Dashboard user nya.<br>
                          4. Mengedit status dapat dilakukan pada halaman Dashboard masing-masing user.
                        </p>

                  </div>

                  <br><br>

                </div>

              </div>
            </div>


          </div>
        </div>

 

  </section>
  <!-- /.content -->

  </div>



    <?php include 'view/common/footer.html'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
    
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>


    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Prism -->
    <script src="plugins/prism/prism.js"></script>
    <script src="plugins/marked/marked.min.js"></script>


  <script>


    $(function () {
      const id_dg_event_detail = "<?php echo $id_dg_event_detail; ?>"; // Sesuaikan

      // Inisialisasi datetimepicker
      $('#eventDateGroup').datetimepicker({
        format: 'DD-MMMM-YYYY',
        useCurrent: false
      });

      // Tombol edit
      $('#btnEditDate').on('click', function () {
        $('#dg_event_tanggal').prop('readonly', false);
        $('#eventDateGroup').datetimepicker('show');
      });

      // Saat datepicker ditutup
      $('#eventDateGroup').on("hide.datetimepicker", function (e) {
        $('#dg_event_tanggal').prop('readonly', true);

        let selectedDate = $('#dg_event_tanggal').val();
        if (!selectedDate) return;

        $.ajax({
          url: 'view/ajax/update_event_date.php',
          type: 'POST',
          data: {
            id_dg_event_detail: id_dg_event_detail,
            tanggal_baru: selectedDate
          },
          success: function (response, status, xhr) {
            if (xhr.status === 204) {
              // Tidak ada perubahan, tidak lakukan apa-apa
              return;
            }

            console.log("Respon server:", response);
            if (response.status === "reset") {
              toastr.info(response.message);
            } else if (response.status === "updated") {
              toastr.success(response.message);
            } else if (response.status === "created") {
              toastr.success(response.message);
            }
          },


          error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            console.error("Status:", status);
            console.error("Response Text:", xhr.responseText);

            toastr.error("Gagal menyimpan perubahan tanggal: " + error);
          }

        });
      });
    });



  $(document).on('click', '.dropdown-menu', function (e) {
    $('#select-individual').val('');
    if ($(e.target).closest('#select-individual').length > 0) {
      e.stopPropagation();
    }
  });

  $(document).ready(function () {
      $("#tidyUp").click(function () {

          // Tampilkan loader atau indikator pemrosesan
          $("#tidyUp").prop("disabled", true).text("Processing...");

          let notes_mom = $("#summernote").summernote('code'); // Ambil isi dari Summernote

          if (!notes_mom.trim()) {
              alert("Notes MoM masih kosong!"); 
              return;
          }

          // Buat prompt untuk AI
          let finalPrompt = `Berikut adalah Minute of Meeting (MoM) yang perlu dirapikan:
          
          ${notes_mom}
          
          Tolong rapihkan dan buat lebih jelas serta terstruktur dengan baik.
          Terkadang di dalam notes ada // yang memberikan permintaan tertentu.
          Langsung berikan hasil yang sudah rapi tanpa contoh atau penjelasan tambahan, 
          namun buatkan dalam format yang rapih dan terstruktur.`;

          // Kirim permintaan ke chat_api.php
          $.ajax({
              url: "view/ajax/chat_api.php",
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify({ prompt: finalPrompt }),

              success: function (response) {
                console.log("finalPrompt:", finalPrompt); // Debugging
                        try {
                            if (typeof response === "string") {
                                response = JSON.parse(response); // Pastikan response diubah menjadi objek jika masih string
                            }

                            console.log("AI Response RAW:", response); // Debugging

                            let aiResponse = response && response.response ? response.response : "";

                           // Decode HTML entities (seperti &lt; menjadi <)
                           function decodeHtml(html) {
                                        const txt = document.createElement("textarea");
                                        txt.innerHTML = html;
                                        return txt.value;
                                    }

                                    aiResponse = decodeHtml(aiResponse);

                                    function normalizeMarkdownTables(text) {
                                        const lines = text.split("\n");
                                        let inTable = false;
                                        const normalizedLines = [];

                                        for (let i = 0; i < lines.length; i++) {
                                            let line = lines[i].trim();

                                            // Cek apakah ini baris tabel: memiliki beberapa `|`
                                            const isLikelyTableRow = (line.match(/\|/g) || []).length >= 2;

                                            // Mulai tabel jika baris punya banyak "|"
                                            if (isLikelyTableRow) {
                                                inTable = true;

                                                // Pastikan ada | di awal dan akhir
                                                if (!line.startsWith("|")) line = "| " + line;
                                                if (!line.endsWith("|")) line = line + " |";

                                                normalizedLines.push(line);
                                            } else {
                                                inTable = false;
                                                normalizedLines.push(line); // baris normal (subheading atau teks biasa)
                                            }
                                        }

                                        return normalizedLines.join("\n");
                                    }


                                    const containsMarkdownTable = /\|(.+?)\|/g.test(aiResponse) && !/<table[\s\S]*?>[\s\S]*?<\/table>/gi.test(aiResponse);

                                    if (containsMarkdownTable) {
                                        aiResponse = normalizeMarkdownTables(aiResponse);
                                    }


                                    console.log("🔍 Normalized Markdown:\n", aiResponse);


                                    // Ganti **bold** dengan <strong>
                                    aiResponse = aiResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                                    
                                    // Jika jawaban kosong, tampilkan error
                                    if (!aiResponse.trim()) {
                                        aiResponse = "<p>AI tidak memberikan jawaban yang valid.</p>";
                                        $("#summernote").summernote("code", aiResponse);
                                        return;
                                    }



                                        console.log("AI Formated:", aiResponse); // Debugging                

                                        aiResponse = aiResponse.replace(
  /((?:\|.+?\|\s*\n)+)/g,
                                            function (tableBlock) {
                                                const lines = tableBlock.trim().split("\n").map(l => l.trim()).filter(Boolean);
                                                if (lines.length < 2) return tableBlock;

                                                const headers = lines[0].split("|").slice(1, -1).map(cell => cell.trim());
                                                const headerCount = headers.length;
                                                const headerHTML = headers.map(cell => `<th>${cell}</th>`).join("");

                                                const bodyHTML = lines.slice(2).map(line => {
                                                const cells = line.split("|").slice(1, -1).map(c => c.trim());

                                                const isSubheading = cells.length < headerCount &&
                                                    (
                                                    cells.length === 1 ||
                                                    cells.filter(c => c !== "").length === 1 ||
                                                    cells.every(c => /^(\d+(\.\d+)?|[A-Z\s]+)$/.test(c))
                                                    );

                                                if (isSubheading) {
                                                    const subText = cells.join(" ").replace(/\*\*/g, "").trim();
                                                    return `<tr><td colspan="${headerCount}"><strong>${subText}</strong></td></tr>`;
                                                }

                                                const rowHTML = headers.map((_, i) => {
                                                    let cell = (cells[i] !== undefined) ? cells[i].trim() : "";

                                                    if (/\*\*/.test(cell)) {
                                                    cell = `<strong>${cell.replace(/\*\*/g, "")}</strong>`;
                                                    }

                                                    return `<td>${cell}</td>`;
                                                }).join("");

                                                return `<tr>${rowHTML}</tr>`;
                                                }).join("");

                                                return `
                                                <div style="overflow-x:auto;">
                                                    <table class="table table-bordered table-striped dataTable no-footer" style="width: 100%; min-width: max-content;">
                                                    <thead><tr>${headerHTML}</tr></thead>
                                                    <tbody>${bodyHTML}</tbody>
                                                    </table>
                                                </div>
                                                `.trim();
                                            }
                                        );


                                        // 🔐 Deteksi dan bungkus blok kode dari AI, baik ```html atau ``` saja
                                        aiResponse = aiResponse.replace(/```(?:([a-zA-Z]+))?\s*([\s\S]*?)\s*```/gi, function (_, lang, codeBlock) {
                                            let language = (lang && lang.trim()) ? lang.toLowerCase() : "markup"; // default ke markup (HTML)
                                            let displayLang = (lang && lang.trim())
                                                ? lang.charAt(0).toUpperCase() + lang.slice(1)
                                                : "Code";

                                            // Encode agar aman untuk ditampilkan
                                            let cleanedCode = codeBlock
                                                .replace(/&/g, "&amp;")
                                                .replace(/</g, "&lt;")
                                                .replace(/>/g, "&gt;");

                                            return `
                                                <div class="code-block-wrapper">
                                                    <div class="code-block-header">
                                                        <div class="code-lang">${displayLang}</div>
                                                        <button class="copy-btn" onclick="copyCode(this)"><i class="fas fa-copy"></i> Copy</button>
                                                    </div>
                                                    <pre class="ai-code-block language-${language}"><code class="language-${language}">${cleanedCode}</code></pre>
                                                </div>
                                            `.trim();
                                        });

                                        let htmlBlocks = [];
                                            aiResponse = aiResponse.replace(/<([a-z][\s\S]*?)<\/\1>/gi, function(match) {
                                                htmlBlocks.push(match);
                                                return `__HTML_BLOCK_${htmlBlocks.length - 1}__`;
                                            });


                                        aiResponse = aiResponse
                                                .replace(/```html\s*<br\s*\/?>/gi, "")       // Hapus ```html<br />
                                                .replace(/<br\s*\/?>\s*```/gi, "")           // Hapus <br>```
                                                .replace(/\s*<br\s*\/?>\s*/gi, "\n")         // Semua <br> jadi \n
                                                .replace(/\n{3,}/g, "\n\n")                  // Maksimal 2 newline
                                                .replace(/(<strong>\n)/g, "<strong>")        // Bersihin newline setelah <strong>
                                                .replace(/(\n<\/strong>)/g, "</strong>")     // Bersihin newline sebelum </strong>
                                                .replace(/(\* )\n/g, "$1")                   // Hapus newline setelah bullet
                                                .replace(/>\s*\n\s*</g, "><")                // ❗❗ Hapus newline antar tag HTML (opsional)
                                                .trim();



                                        aiResponse = aiResponse.replace(/`<\s*\/?\s*([^>]+?)\s*>`/g, (_, tagContent) => {
                                            return tagContent.trim();
                                        });

                                        

                                        // 🔧 Tambahkan class + style + wrap div untuk setiap <table>
                                        aiResponse = aiResponse.replace(/<table([\s\S]*?)<\/table>/gi, function(match) {
                                            let tableWithClassAndStyle = match.replace(
                                                /<table([^>]*)>/i,
                                                function(_, attrs) {
                                                    // Tambahkan atau gabungkan class
                                                    if (/class\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/class=["'](.*?)["']/, 'class="$1 table table-bordered table-striped dataTable no-footer"');
                                                    } else {
                                                        attrs += ' class="table table-bordered table-striped dataTable no-footer"';
                                                    }

                                                    // Tambahkan atau gabungkan style
                                                    if (/style\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/style=["'](.*?)["']/, function(_, styleVal) {
                                                            return `style="${styleVal}; width: 100%; min-width: max-content;"`;
                                                        });
                                                    } else {
                                                        attrs += ' style="width: 100%; min-width: max-content;"';
                                                    }

                                                    return `<table${attrs}>`;
                                                }
                                            );

                                            return `<div style="overflow-x:auto;">${tableWithClassAndStyle}</div>`;
                                        });
                                        
                         
                            console.log("AI Formatted Final:", aiResponse); // Debugging  

                            let htmlOutput = marked.parse(aiResponse);
                            $("#summernote").summernote("code", htmlOutput);
                            $("#summernote").next('.note-editor').find('.note-editable').css('min-height', '500px');

                            
                            Prism.highlightAll();

                            toastr.success("MoM telah dirapihkan oleh AI!");

                            console.log("AI response Akhir:", aiResponse);
                        } catch (e) {
                            toastr.error("Invalid JSON response dari AI.");
                            console.error("Parsing error:", e, response);
                        }
                    


                            // Ambil nilai dari editor setelah berhenti mengetik
                            var notes_mom = encodeURIComponent(document.getElementById("summernote").value);
                            var id_dg_event_detail = '<?php echo $id_dg_event_detail; ?>';

                            // Kirimkan data melalui AJAX ke server
                            $.ajax({
                                url: 'view/calendar/save_notes.php',  // File PHP untuk menyimpan data
                                type: 'POST',
                                data: {
                                    notes_mom: notes_mom,
                                    id_dg_event_detail: id_dg_event_detail
                                },
                                success: function(response) {
                                    console.log("Notes saved");
                                    console.log(document.getElementById("summernote").value);
                                },
                                error: function() {
                                    console.log("Error while saving notes");
                                    console.log(notes_mom);
                                    toastr.error("Error while saving notes");
                                }
                            });
              },

              error: function () {
                  alert("Terjadi kesalahan saat menghubungi AI.");
              },
              complete: function () {
                $("#tidyUp").prop("disabled", false).text("Tidy Up with AI ✨");
              }
          });
      });


      // Inisialisasi variabel interval
      let loadTasksInterval;
      let isFocused = false;

      function loadTasks() {
        if (!isFocused) {
            $.ajax({
                url: 'view/calendar/load_tasks.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_dg_event: <?php echo $id_dg_event; ?>,
                    id_dg_event_detail: <?php echo $id_dg_event_detail; ?>,
                    id_dg_user_group: <?php echo $id_dg_user_group; ?>
                },
                success: function(data) {
                    $('#taskTable tbody').empty();
                    $.each(data.tasks, function(index, task) {
                        $('#taskTable tbody').append(`
                            <tr>
                                <td style="text-align: center;">${index + 1}</td>
                                <td>
                                    <input type="text" class="form-control" name="task_${task.id_dg_event_detail_task}" value="${task.isi_task}">
                                </td>
                                <td>
                                    <select class="form-control owner-select" name="owner_${task.id_dg_event_detail_task}">
                                      <option value="">-- Select Owner --</option>
                                      ${task.owners.map(owner => `
                                          <option value="${owner.id}" ${owner.id === task.owner_id ? 'selected' : ''}>
                                              ${owner.name}${owner.in_group === false ? ' (not in group)' : ''}
                                          </option>
                                      `).join('')}
                                  </select>

                                </td>
                                <td style="text-align: center; width: 25%;">
                                    <div class="input-group date" id="reservationdate_${task.id_dg_event_detail_task}" data-target-input="nearest">
                                        <input type="text" name="deadline_${task.id_dg_event_detail_task}" class="form-control datetimepicker-input deadline_${task.id_dg_event_detail_task}" data-target="#reservationdate_${task.id_dg_event_detail_task}" value="${task.deadline_task}">
                                        <div class="input-group-append" data-target="#reservationdate_${task.id_dg_event_detail_task}" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                     ${task.status_task === 0 ? "Open" : task.status_task === 1 ? "On Progress" : task.status_task === 2 ? "Cancel" : "Done"}
                                </td>
                                <td style="text-align: center;">
                                    <button <?php if($priv !=1 ){echo "disabled"; } ?> type="button" class="btn btn-danger delete-row-btn" data-id="${task.id_dg_event_detail_task}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);

                        // Cari elemen datepicker setelah elemen berhasil ditambahkan ke DOM
                        const datepickerElement = $(`#reservationdate_${task.id_dg_event_detail_task}`);

                        // Trigger datetimepicker saat input text diklik
                        $(`.deadline_${task.id_dg_event_detail_task}`).on('focus click', function() {
                          $(`#reservationdate_${task.id_dg_event_detail_task}`).datetimepicker('show');
                        });
                        
                        // Cek apakah elemen ada
                        if (datepickerElement.length > 0) {
                            // Inisialisasi datetimepicker
                            datepickerElement.datetimepicker({
                                format: 'DD-MMMM-yyyy',
                                showTodayButton: true,
                                icons: {
                                    today: 'fa fa-calendar-day',
                                },
                                buttons: {
                                    showToday: true
                                }
                            });

                            // Event listener untuk perubahan tanggal
                            datepickerElement.on('change.datetimepicker', function(e) {
                                if (e.date) {
                                    const formattedDeadline = e.date.format('YYYY-MM-DD');
                                    updateTaskDeadline(task.id_dg_event_detail_task, formattedDeadline);
                                }
                            });
                        } else {
                            console.error(`Datetimepicker element not found for task ID: ${task.id_dg_event_detail_task}`);
                        }
                    });
                },
                error: function() {
                    toastr.error("Failed to load tasks.");
                }
            });
        }
    }

    // Fungsi AJAX untuk memperbarui deadline task
    function updateTaskDeadline(taskId, deadline) {
        $.ajax({
            url: 'view/calendar/conn_update_task.php',
            type: 'POST',
            data: {
                id_dg_event_detail_task: taskId,
                deadline: deadline,
                change: 1
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    loadTasks();
                    toastr.success("Deadline updated successfully.");
                } else {
                    toastr.error("Failed to update deadline.");
                }
            },
            error: function() {
                toastr.error("An error occurred while updating the deadline.");
            }
        });
    }
    
    loadTasks();

    // Fungsi untuk memulai interval pengambilan data
    function startLoadTasks() {
        loadTasksInterval = setInterval(loadTasks, 5000); // Refresh setiap 5 detik
    }

    // Menghentikan interval loadTasks
    function stopLoadTasks() {
        clearInterval(loadTasksInterval);
    }

    // Mulai interval saat halaman selesai dimuat
    startLoadTasks();

    // Menangani focus dan blur pada elemen input dan select di taskTable
    $('#taskTable').on('focus', 'input, select', function() {
        isFocused = true;
        stopLoadTasks(); // Hentikan interval saat input/select mendapatkan fokus
    });

    $('#taskTable').on('blur', 'input, select', function() {
        isFocused = false;
        startLoadTasks(); // Mulai ulang interval saat input/select kehilangan fokus
    });


        // Fungsi untuk menghapus task saat tombol delete diklik
        $(document).on('click', '.delete-row-btn', function() {
          var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol delete

            // Nonaktifkan semua tombol delete selama 2 detik setelah diklik
            $('.delete-row-btn').prop('disabled', true);
            setTimeout(function() {
                $('.delete-row-btn').prop('disabled', false); // Aktifkan kembali semua tombol delete setelah 2 detik
            }, 3000);

            var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol delete
            $.ajax({
                url: 'view/calendar/conn_delete_task.php', // URL endpoint untuk menghapus task
                type: 'POST',
                data: { id: taskId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        loadTasks();
                        toastr.success("Task successfully deleted.");
                    } else {
                        toastr.error("Failed to delete task.");
                    }
                },
                error: function() {
                    toastr.error("Error deleting task.");
                }
            });
        });

        $('#saveTask').on('click', function() {

            var $this = $(this);

            // Disable tombol dan atur timeout untuk re-enable
            $this.prop('disabled', true); // Menonaktifkan tombol


            var task = $('input[name="task_add"]').val();
            var owner = $('select[name="owner_add"]').val();
            var deadline = $('input[name="deadline_add"]').val();

            if (task && owner && deadline) {
                // Parsing tanggal dari format "DD-MMMM-YYYY" ke "YYYY-MM-DD"
                var parts = deadline.split('-');
                var day = parts[0];
                var month = new Date(Date.parse(parts[1] + " 1, 2023")).getMonth() + 1; // Mengambil bulan dari nama
                var year = parts[2];
                var formattedDeadline = `${year}-${month.toString().padStart(2, '0')}-${day.padStart(2, '0')}`;
                var id_dg_event_detail = <?php echo $id_dg_event_detail; ?>;
                var id_user = <?php echo $id_user; ?>;

                $.ajax({
                    url: 'view/calendar/conn_save_task.php',
                    type: 'POST',
                    data: {
                        id_dg_event_detail: id_dg_event_detail,
                        task: task,
                        owner: owner,
                        deadline: formattedDeadline,
                        id_user: id_user
                    },
                    success: function(response) {
                      if (response.trim() === "") {
                          toastr.error("Empty response from server. Check PHP script for errors.");
                          console.log("Empty response received from PHP.");
                          return;
                      }
                      try {
                          var res = JSON.parse(response);
                          if (res.success) {
                              loadTasks();
                              toastr.success('Task saved successfully.');
                              setTimeout(function() {
                                  $this.prop('disabled', false); // Mengaktifkan kembali tombol setelah 2 detik
                              }, 2000);

                              // Reset input setelah berhasil menyimpan
                              $('input[name="task_add"]').val('');
                              $('select[name="owner_add"]').val('').trigger('change');
                              $('input[name="deadline_add"]').val('');
                              
                          } else {
                              toastr.error('Failed to save task: ' + (res.error || 'Unknown error'));
                          }
                      } catch (e) {
                          toastr.error('Failed to parse JSON response.');
                          console.log("Error parsing JSON:", response);
                      }
                  },
                  error: function(xhr) {
                      toastr.error('AJAX request failed: ' + xhr.responseText);
                      console.log("Error response from PHP:", xhr.responseText);
                  }

                });
            } else {
                toastr.warning('Please fill in all fields before saving.');
            }
        });


         // Event onChange untuk kolom Task, Owner, dan Deadline
          $('#taskTable').on('change', 'input, select', function () {
              const row = $(this).closest('tr');
              const id = row.find('.delete-row-btn').data('id'); // Ambil ID task
              const task = row.find('input[name^="task_"]').val(); // Ambil nilai dari kolom Task
              const owner = row.find('select[name^="owner_"]').val(); // Ambil nilai dari kolom Owner
              
              // Mengambil nilai deadline dari datepicker
              const deadline = row.find('input[name^="deadline_"]').val();
              console.log("deadline: "+deadline);
              var parts = deadline.split('-');
              var day = parts[0];
              var month = new Date(Date.parse(parts[1] + " 1, 2023")).getMonth() + 1; // Mengambil bulan dari nama
              var year = parts[2];
              var formattedDeadline = `${year}-${month.toString().padStart(2, '0')}-${day.padStart(2, '0')}`;

              // Debug: Log data yang akan dikirim
              console.log("Updating task with ID:", id);
              console.log("Task:", task);
              console.log("Owner:", owner);
              console.log("Formatted Deadline:", formattedDeadline);

              // AJAX untuk meng-update data
              $.ajax({
                  url: 'view/calendar/conn_update_task.php', // URL untuk proses update
                  type: 'POST',
                  data: {
                      id_dg_event_detail_task: id,
                      task: task,
                      owner: owner,
                      deadline: formattedDeadline
                  },
                  success: function (response) {
                      const result = JSON.parse(response);
                      if (result.success) {
                          loadTasks();
                          toastr.success("Task updated successfully.");
                      } else {
                          toastr.error("Failed to update task.");
                      }
                  },
                  error: function () {
                      toastr.error("An error occurred while updating the task.");
                  }
              });
          });



    });





    
    function toggleCard(element) {
      // Cari elemen card utama
      const card = element.closest('.card');
      // Aktifkan event collapse dari data-card-widget
      $(card).CardWidget('toggle');
    }

    

    $(document).ready(function () {
      const idEvent = <?php echo $id_dg_event_detail; ?>;
      const idGroup = <?php echo $id_dg_user_group; ?>;
      const namaEvent = '<?php echo $nama_event; ?>';
      const tanggalEvent = '<?php echo $tanggal_event; ?>';

      let selectedTarget = null;
      let selectedNumber = null;
      let selectedName = null;

      // Simpan data user di sini
      let userList = [];

      // Load list nomor dari get_absensi.php
      $.getJSON(`view/calendar/get_absensi.php?id_dg_event_detail=${idEvent}&id_dg_user_group=${idGroup}`, function (data) {
        userList = data; // simpan seluruh data

        data.forEach(user => {
          $('#select-individual').append(`<option value="${user.nomor_hp}">${user.nama} (${user.nomor_hp})</option>`);
        });
      });

      function sendMoM(target, nomor = null) {
        const notesMoM = encodeURIComponent($("#summernote").val());

        $.ajax({
          url: 'controller/conn_send_announcement_mom.php',
          type: 'POST',
          data: {
            target: target,
            nomor: nomor,
            notes_mom: notesMoM,
            id_dg_event_detail: idEvent,
            nama_event: namaEvent,
            hari_tanggal: tanggalEvent,
            id_dg_user_group : idGroup
          },
          success: function (response) {
            try {
              const res = JSON.parse(response);
              if (res.success) {
                toastr.success('MoM berhasil dikirim ke ' + target + '!');
              } else {
                toastr.error('Gagal mengirim MoM.');
              }
            } catch (e) {
              toastr.error('Error saat parsing response.');
              console.error(e);
            }
          },
          error: function (xhr, status, error) {
            toastr.error('Gagal mengirim data. Server error.');
            console.error(error);
            console.log("Request data:", {
              target: target,
              nomor: nomor,
              notes_mom: notesMoM,
              id_dg_event_detail: idEvent,
              nama_event: namaEvent,
              hari_tanggal: tanggalEvent,
              id_dg_user_group : idGroup
            });
            
            
            
            
          }
        });
      }

      function showConfirmModal(target, nomor = null, nama = null) {
        selectedTarget = target;
        selectedNumber = nomor;
        selectedName = nama;

        let message = 'Yakin ingin mengirim MoM?';
        if (target === 'announcement') message = 'Yakin ingin mengirim MoM ke Announcement?';
        else if (target === 'wa_group') message = 'Yakin ingin mengirim MoM ke WA Group?';
        else if (target === 'all') message = 'Yakin ingin mengirim MoM ke semua nomor?';
        else if (target === 'individual') {
          // Gunakan <br> untuk newline, dan .html() untuk render html
          message = `Yakin ingin mengirim MoM ke nomor ini?<br><b>${nama} (${nomor}) </b>`;
        }

        $('#modalSendMoMMessage').html(message);  // pakai .html() agar <br> berfungsi
        $('#modalConfirmSendMoM').modal('show');
      }


      // Button actions
      $('#send-announcement').click(() => showConfirmModal('announcement'));
      $('#send-wa-group').click(() => showConfirmModal('wa_group'));
      $('#send-to-all').click(() => showConfirmModal('all'));

      $('#select-individual').change(function () {
        const nomor = $(this).val();
        if (nomor) {
          // Cari nama berdasarkan nomor dari userList
          const user = userList.find(u => u.nomor_hp === nomor);
          const nama = user ? user.nama : 'Tidak diketahui';
          showConfirmModal('individual', nomor, nama);
        }
      });

      // Kirim saat user klik tombol konfirmasi
      $('#btnConfirmSendMoM').click(function () {
        $('#modalConfirmSendMoM').modal('hide');
        sendMoM(selectedTarget, selectedNumber);
      });
    });




      $(document).ready(function() {

              // Variabel PHP untuk nilai x
              var x = <?php echo $x; ?>;
              
              // Jika x == 1, tampilkan modal
              if (x == 1) {
                  $('#modal-x').modal('show');
              }
              if (x == 2) {
                  $('#modal-y').modal('show');
        }



      let isTyping = false;
      let absensiUpdateTimeout;
      let refreshDelay = 3000; // Delay 3 detik 
      fetchAbsensi();


      // Panggil fetchAbsensi setiap 3 detik
      setInterval(fetchAbsensi, refreshDelay);

      function fetchAbsensi() {
          // Cek apakah sedang mengetik, jika iya hentikan proses refresh
          if (isTyping) return;

          $.ajax({
              url: 'view/calendar/get_absensi.php',
              type: 'GET',
              data: {
                  id_dg_event_detail: <?php echo $id_dg_event_detail; ?>,
                  id_dg_user_group: <?php echo $id_dg_user_group; ?>
              },
              success: function(data) {
                  //console.log(data); // Debug: Tampilkan data di konsol

                  const tableBody = document.getElementById('absensi-table-body');
                  tableBody.innerHTML = '';

                  if (data.length > 0) {
                      data.forEach((item, index) => {
                          const row = document.createElement('tr');
                          const status_absen = item.status_absen !== null ? item.status_absen : 0; // Set default ke 0 (Alpha)
                          row.innerHTML = `
                              <td style="text-align: center;">${index + 1}</td>
                              <td>${item.nama}</td>
                              <td><input <?php if($priv !=1 ){echo "disabled"; } ?> ${status_absen == 1 || 'disabled'} type="text" style="text-align: right;" autocomplete="off" min="0" class="hargaFee form-control" value="${item.pengeluaran}" data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${item.id_dg_user}" value="1" ${status_absen == 1 ? 'checked' : ''} data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${item.id_dg_user}" value="2" ${status_absen == 2 ? 'checked' : ''} data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${item.id_dg_user}" value="3" ${status_absen == 3 ? 'checked' : ''} data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${item.id_dg_user}" value="4" ${status_absen == 4 ? 'checked' : ''} data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${item.id_dg_user}" value="0" ${status_absen == 0 ? 'checked' : ''} data-absensi-id="${item.id_dg_event_detail_attendance || ''}"></td>
                          `;
                          tableBody.appendChild(row);
                      });
                  } else {
                      const memberIDs = <?php echo $memberIDsJSON; ?>;
                      console.log(memberIDs); // Debug: Tampilkan data murid di konsol
                      memberIDs.forEach((member, index) => {
                          const row = document.createElement('tr');
                          row.innerHTML = `
                              <td style="text-align: center;">${index + 1}</td>
                              <td>${member.nama}</td>
                              <td><input disabled type="text" style="text-align: right;" autocomplete="off" min="0" class="hargaFee form-control" value="${member.pengeluaran}" data-absensi-id=""></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${member.id_dg_user}" value="1" data-absensi-id=""></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${member.id_dg_user}" value="2" data-absensi-id=""></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${member.id_dg_user}" value="3" data-absensi-id=""></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${member.id_dg_user}" value="4" data-absensi-id=""></td>
                              <td class="radio-cell" style="text-align: center;"><input <?php if($priv !=1){echo "disabled"; } ?> type="radio" name="kehadiran_${member.id_dg_user}" value="0" checked data-absensi-id=""></td>
                          `;
                          tableBody.appendChild(row);
                      });
                  }



                // Tambahkan event listener untuk klik pada cell dan update absensi
                document.querySelectorAll('.radio-cell').forEach(cell => {
                    cell.addEventListener('click', function() {
                        const radio = this.querySelector('input[type="radio"]');
                        if (radio) {
                          <?php if($priv ==1){?>
                            radio.checked = true; // Pilih radio button saat sel diklik

                            // Ambil data absensi dari atribut radio button
                            const id_dg_event_detail_attendance = radio.getAttribute('data-absensi-id');
                            const id_dg_user = radio.name.split('_').pop();
                            const status_absen = radio.value;
                            
                            // Panggil fungsi update absensi
                            updateAbsensi(id_dg_event_detail_attendance, id_dg_user, status_absen);
                            <?php } ?>
                        }
                    });
                });

                // Ambil semua elemen input dengan kelas hargaFee
                var inputs = document.querySelectorAll('.hargaFee');

                // Iterasi melalui setiap elemen input dan terapkan AutoNumeric
                inputs.forEach(function(input) {
                  new AutoNumeric(input, {
                    currencySymbol: '',
                    digitGroupSeparator: '.',
                    decimalCharacter: ',',  // Masih perlu ditentukan untuk format desimal, walau tidak dipakai
                    minimumValue: '0',
                    decimalPlaces: 0        // Tidak ada angka desimal
                    // Jangan gunakan allowDecimalPadding
                  });


                    // Event ketika mulai mengetik
                    input.addEventListener('focus', function() {
                        isTyping = true;
                    });

                    // Event ketika selesai mengetik, delay 3 detik sebelum refresh
                    input.addEventListener('blur', function() {
                        isTyping = false;
                        clearTimeout(absensiUpdateTimeout);
                        absensiUpdateTimeout = setTimeout(fetchAbsensi, refreshDelay);
                    });
                });

                // Event listener untuk radio button dan delay sebelum refresh
                document.querySelectorAll('.radio-cell input[type="radio"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        clearTimeout(absensiUpdateTimeout);
                        absensiUpdateTimeout = setTimeout(fetchAbsensi, refreshDelay);
                    });
                });



              }
          });
      }

      // Tentukan elemen tabel sebagai tempat event delegation
      const absensiTable = document.getElementById('absensi-table-body');

      // Hapus listener sebelumnya sebelum menambahkan yang baru untuk menghindari pengulangan
      absensiTable.removeEventListener('input', handlePengeluaranChange);
      absensiTable.addEventListener('input', handlePengeluaranChange);

      // Fungsi debounce untuk mencegah pengulangan AJAX
      function debounce(func, delay) {
          let timeout;
          return function (...args) {
              clearTimeout(timeout);
              timeout = setTimeout(() => func.apply(this, args), delay);
          };
      }

      // Event delegation untuk perubahan pada input .hargaFee
      function handlePengeluaranChange(event) {
          const target = event.target;

          // Cek apakah target event adalah elemen dengan kelas 'hargaFee'
          if (target.classList.contains('hargaFee')) {
              const idAbsensi = target.getAttribute('data-absensi-id');
              const pengeluaran = target.value.replace(/\./g, ''); // Menghapus separator ribuan

              if (idAbsensi) {
                  // Panggil fungsi untuk update data pengeluaran di database hanya untuk id yang berubah
                  debounceUpdatePengeluaran(idAbsensi, pengeluaran);
              }
          }
      }

      // Fungsi update pengeluaran dengan debounce
      const debounceUpdatePengeluaran = debounce(function (idAbsensi, pengeluaran) {
          $.ajax({
              url: 'view/calendar/update_pengeluaran.php',
              type: 'POST',
              data: {
                  id_dg_event_detail_attendance: idAbsensi,
                  pengeluaran: pengeluaran
              },
              success: function (response) {
                  toastr.success('Pengeluaran updated successfully.');
              },
              error: function (error) {
                  toastr.error('Error updating pengeluaran:', error);
              }
          });
      }, 1000); // Sesuaikan delay debounce sesuai kebutuhan



      function updateAbsensi(id_dg_event_detail_attendance, id_dg_user, status_absen) {
          $.ajax({
            url: 'view/calendar/update_absensi.php',
            type: 'POST',
            data: {
                id_dg_event_detail_attendance: id_dg_event_detail_attendance,
                id_dg_event_detail: <?php echo $id_dg_event_detail; ?>,
                id_dg_user: id_dg_user,
                status_absen: status_absen,
                updated_by: <?php echo $id_user; ?>
            },
            success: function(response) {
                //console.log(response); // Debug: Tampilkan respon update di konsol
                if (response.success) {
                  toastr.success('Data berhasil disimpan.');
                    fetchAbsensi();
                } else {
                  toastr.error('Data gagal disimpan !<br>' + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Debug: Tampilkan respon kesalahan di konsol
                toastr.error('Data gagal disimpan !<br>' + error);
            }
          });
          
      }


      function save_notes() {
         // Ambil nilai dari editor setelah berhenti mengetik
        var notes_mom = encodeURIComponent(document.getElementById("summernote").value);
        var id_dg_event_detail = '<?php echo $id_dg_event_detail; ?>';

        // Kirimkan data melalui AJAX ke server
        $.ajax({
            url: 'view/calendar/save_notes.php',  // File PHP untuk menyimpan data
            type: 'POST',
            data: {
                notes_mom: notes_mom,
                id_dg_event_detail: id_dg_event_detail
            },
            success: function(response) {
                console.log("Notes saved");
                console.log(document.getElementById("summernote").value);
            },
            error: function() {
                console.log("Error while saving notes");
                console.log(notes_mom);
                toastr.error("Error while saving notes");
            }
        });
      }

      // Event listener untuk menangani sebelum tab atau browser ditutup
      window.addEventListener('beforeunload', function (e) {
          save_notes();
      });

      

    

          // Ubah label ke "Read Mode" awalnya
          $('.custom-control-label').text('Read Mode');

          // Event handler untuk switch editor mode
          $('#customSwitch3').on('change', function() {
              if ($(this).is(':checked')) {
                  // Jika switch dalam keadaan aktif (true), Summernote bisa di edit
                  $('#summernote').summernote('enable');
                  // Ubah label menjadi "Editor Mode"
                  $('.custom-control-label').text('Editor Mode');
              } else {
                  // Jika switch dalam keadaan nonaktif (false), Summernote di-disable
                  $('#summernote').summernote('disable');
                  // Ubah label menjadi "Read Mode"
                  $('.custom-control-label').text('Read Mode');
              }
          });


      });



      // Menambahkan event listener ke semua sel dengan class 'radio-cell'
      document.querySelectorAll('.radio-cell').forEach(cell => {
        cell.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          if (radio) {
            radio.checked = true; // Pilih radio button saat sel diklik
          }
        });
      });

          $(function () {
            var isTyping = false;
            var typingTimer;  // Timer untuk menghitung waktu setelah berhenti mengetik
            var typingInterval = 5000;  // Waktu tunggu setelah onBlur (5 detik)

            var debounceTimer;  // Timer untuk debounce
            var debounceInterval = 3000;  // Waktu tunggu setelah onKeyup (3 detik)

            // Summernote
            $('#summernote').summernote({
                height: 350, //set editable area's height
                placeholder: 'Ketikan sesuatu disini...',
                focus: true,
                codemirror: { // codemirror options
                theme: 'monokai'
                },
                maximumImageFileSize: 500*1024,
                callbacks: {
                  onKeyup: function(contents, $editable) {
                        clearTimeout(debounceTimer);  // Hapus timer sebelumnya jika ada
                        debounceTimer = setTimeout(function() {
                            // Ambil nilai dari editor setelah berhenti mengetik
                            var notes_mom = encodeURIComponent(document.getElementById("summernote").value);
                            var id_dg_event_detail = '<?php echo $id_dg_event_detail; ?>';

                            // Kirimkan data melalui AJAX ke server
                            $.ajax({
                                url: 'view/calendar/save_notes.php',  // File PHP untuk menyimpan data
                                type: 'POST',
                                data: {
                                    notes_mom: notes_mom,
                                    id_dg_event_detail: id_dg_event_detail
                                },
                                success: function(response) {
                                    console.log("Notes saved");
                                    console.log(document.getElementById("summernote").value);
                                },
                                error: function() {
                                    console.log("Error while saving notes");
                                    console.log(notes_mom);
                                    toastr.error("Error while saving notes");
                                }
                            });
                        }, debounceInterval);  // Eksekusi AJAX setelah 1 detik (atau sesuai interval)
                    },
                    onBlur: function() {                       
                        // Mulai timer 10 detik untuk menunda checkForUpdates()
                        typingTimer = setTimeout(function() {
                            isTyping = false;  // Pastikan isTyping sudah false setelah 10 detik
                        }, typingInterval);
                    },
                    onFocus: function() {
                        // Set flag bahwa pengguna sedang mengetik
                        isTyping = true;

                        // Batalkan timer jika pengguna kembali mengetik sebelum 10 detik
                        clearTimeout(typingTimer);
                    },
                    onImageUploadError: function() {
                        toastr.error('Ukuran file gambar tidak boleh lebih dari 500KB!');
                    }
                }
            });

            // Atur Summernote menjadi disabled pada awalnya
            $('#summernote').summernote('disable');

            function checkForUpdates() {
              if (!isTyping) { 
                var id_dg_event_detail = '<?php echo $id_dg_event_detail; ?>';

                $.ajax({
                  url: 'view/calendar/get_notes.php',  // File PHP untuk mengambil data terbaru
                  type: 'GET',
                  data: {
                    id_dg_event_detail: id_dg_event_detail
                  },
                  success: function(response) {
                    try {
                      // Parsing response menjadi object
                      var jsonResponse = JSON.parse(response);
                      var latestNotes = decodeURIComponent(jsonResponse.notes_mom); // Decode data
                      var currentNotes = $('#summernote').val();

                      // Jika data di server berbeda dengan yang ada di editor
                      if (latestNotes!='null') {
                        $('#summernote').summernote('code', latestNotes);  // Update konten editor
                        //console.log("Notes updated");
                        //console.log(latestNotes);
                      }
                    } catch (error) {
                      console.log("Error parsing JSON response:", error);
                    }
                  },
                  error: function() {
                    console.log("Error while fetching notes");
                    console.log(id_dg_event_detail);
                  }
                });
              }
            }

            function firstUpdates() {
                var id_dg_event_detail = '<?php echo $id_dg_event_detail; ?>';

                $.ajax({
                  url: 'view/calendar/get_notes.php',  // File PHP untuk mengambil data terbaru
                  type: 'GET',
                  data: {
                    id_dg_event_detail: id_dg_event_detail
                  },
                  success: function(response) {
                    try {
                      // Parsing response menjadi object
                      var jsonResponse = JSON.parse(response);
                      var latestNotes = decodeURIComponent(jsonResponse.notes_mom); // Decode data
                      var currentNotes = $('#summernote').val();

                      // Jika data di server berbeda dengan yang ada di editor
                      if (latestNotes!='null') {
                        $('#summernote').summernote('code', latestNotes);  // Update konten editor
                        //console.log("Notes updated");
                        //console.log(latestNotes);
                      }
                    } catch (error) {
                      console.log("Error parsing JSON response:", error);
                    }
                  },
                  error: function() {
                    console.log("Error while fetching notes");
                    console.log(id_dg_event_detail);
                  }
                });
              
            }

            firstUpdates();
            // Cek pembaruan setiap 10 detik
            setInterval(checkForUpdates, 10000);
            


            // Summernote
            $('#summernote_sblm').summernote({
                height: 350, //set editable area's height
                placeholder: 'Ketikan sesuatu disini...',
                codemirror: { // codemirror options
                theme: 'monokai'
                },
                maximumImageFileSize: 500*1024,
                callbacks: {
                    onImageUploadError: function() {
                        toastr.error('Ukuran file gambar tidak boleh lebih dari 500KB!');
                    }
                }
            });
            $('#summernote_sblm').summernote('disable');
        });


    $(function () {
      $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": true,
        "paging": true,
        "sorting": false,
        "buttons": false,
        "pageLength": 15,
        "searching": false,
        "scrollX": true
      });

      
      var element = document.getElementById("attend");
        element.classList.add("collapsed-card");

      $("#taskTable").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "sorting": false,
        "buttons": false,
        "pageLength": false,
        "bInfo" : false,
        "searching": false
      });

      $("#taskTableAdd").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "sorting": false,
        "buttons": false,
        "pageLength": false,
        "bInfo" : false,
        "searching": false
      });
      

      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
          'placeholder': 'dd/mm/yyyy'
      })

      //Money Euro
      $('[data-mask]').inputmask()

      $('#reservationdate_add').datetimepicker({
          format: 'DD-MMMM-yyyy',
          showTodayButton: true, // Menampilkan tombol 'Today'
          icons: {
              today: 'fa fa-calendar-day', // Ikon untuk tombol 'Today'
          },
          buttons: {
              showToday: true
          }
      });
      
      // Trigger datetimepicker saat input text diklik
      $('.deadline_add').on('focus click', function() {
        $('#reservationdate_add').datetimepicker('show');
      });


      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
              format: 'DD/MM/YYYY'
          }
      })

      //Timepicker
      $('#timepicker').datetimepicker({
          format: 'DD/MM/YYYY'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()
    });

   

    $('#modal-add').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var modal = $(this)
    })

        $('#modal-add-category').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })


        
        $('#modal-add-tags').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });


        $('#modal-qrcode').on('show.bs.modal', function (event) {

})

let currentNumber = 0;  // Angka default untuk ID event saat ini
let isProcessing = false;  // Flag untuk memblokir klik saat sedang memproses

// Fungsi untuk mengupdate tampilan Notes MoM berdasarkan nomor event
function updateNotesMoM(number) {
  if (isProcessing) {
    return;  // Jika sedang memproses, abaikan klik baru
  }

  isProcessing = true;  // Set flag menjadi true untuk memblokir klik baru

  $.ajax({
    url: 'view/calendar/get_notes_sblm.php',  // Ganti dengan path ke file PHP yang menangani query
    type: 'GET',
    data: {
      number: number,
      currentDate: '<?php echo $tanggal; ?>', // Kirim tanggal dalam format YYYY-MM-DD
      id_dg_event_detail: <?php echo $id_dg_event_detail; ?>,
      id_dg_event: <?php echo $id_dg_event; ?> 
    },
    success: function(response) {
      const jsonResponse = JSON.parse(response);

      // Cek apakah ada notes_mom untuk event tersebut
      if (jsonResponse.success) {
        $('#summernote_sblm').summernote('code', decodeURIComponent(jsonResponse.notes_mom));
        $('#tanggal_mom_sblm').text(jsonResponse.tanggal);  // Update tanggal MoM

        // Atur status tombol kiri/kanan
        $('#btnLeft').prop('disabled', !jsonResponse.has_previous);
        $('#btnRight').prop('disabled', !jsonResponse.has_next);
      } else {
        $('#summernote_sblm').summernote('code', decodeURIComponent(jsonResponse.notes_mom));
        $('#tanggal_mom_sblm').text(jsonResponse.tanggal);  // Update tanggal MoM

        // Atur status tombol kiri/kanan
        $('#btnLeft').prop('disabled', !jsonResponse.has_previous);
        $('#btnRight').prop('disabled', !jsonResponse.has_next);
        alert("Tidak ada data untuk MOM sebelum ini.");
      }
    },
    error: function(xhr, status, error) {
      console.log("Error: ", error);
    },
    complete: function() {
      // Setelah AJAX selesai, berikan delay 2 detik sebelum memperbolehkan klik lagi
      setTimeout(function() {
        isProcessing = false;  // Setelah 2 detik, perbolehkan klik lagi
      }, 1000);
    }
  });
}

// Ketika tombol "Ke Kiri" ditekan
$('#btnLeft').on('click', function() {
  if (!isProcessing) {  // Hanya proses jika tidak sedang memproses
    currentNumber = currentNumber - 1;  // Mundur 1 event
    updateNotesMoM(currentNumber);
  }
});

// Ketika tombol "Ke Kanan" ditekan
$('#btnRight').on('click', function() {
  if (!isProcessing) {  // Hanya proses jika tidak sedang memproses
    currentNumber = currentNumber + 1;  // Maju 1 event
    updateNotesMoM(currentNumber);
  }
});

// Pada awal load, tampilkan data MoM untuk event saat ini
updateNotesMoM(currentNumber);

  </script>
</body>

</html>