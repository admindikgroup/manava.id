<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

date_default_timezone_set('Asia/Jakarta');

$bulanTahunTerpilih = isset($_GET['month']) ? $_GET['month'] : date('Y-m', strtotime('first day of next month'));

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAB & Invoice | DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <style>
        .none {
            display: none;
        }

        .dtr-data {
            white-space: normal;
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
        .padding-print{
            padding: 50px; 
            font-size: 15px;
        }
        @media print {
            .no-print {
                display: none;
            }
            .content-wrapper{
                background-color: #fff;
            }
            .padding-print{
                padding: 20px; 
                font-size: 12px;
            }
            .footer-print {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
            }
            .rab-month {
                width: 200px !important;
            }
            .img-logo{
                width: 150px; 
            }
            .pc-none{
                display: none;
            }
            .modal-dialog{
                min-width: 1000px !important;
            }
            


        }
        .btn{
            font-size: 0.8rem !important;
        }

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .rab-month {
                width: 200px !important;
            }
            .img-logo{
                width: 150px; 
            }
            .pc-none{
                display: none;
            }
            .modal-dialog{
                min-width: 1000px !important;
            }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .rab-month {
                width: 100% !important;
            }
            .modal-title{
                font-size: 15px;
            }
            .img-logo{
                width: 100px; 
            }
            .mobile-none{
                display: none;
            }
        }
        
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <div class="modal fade" id="modal-add-rab">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add RAB</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">


                        <div class="row">
                            <div class="col-12" style="padding-right: 20px;">
                                <div class="form-group row">
                                    <label for="nama_team2" class="col-12 col-form-label">Nama User</label>
                                    <div class="col-12">
                                        <select class="form-control select2 nama_team2" style="width: 100%;" name="nama_team2" id="nama_team2">
                                            <option selected disabled value="">-Pilih Nama User-</option>    
                                            <?php 
                                                $result_team = mysqli_query($db2,"SELECT *
                                                FROM dg_user
                                                WHERE deleted_at is null
                                                ORDER BY id_dg_user");
                                                while($d_team = mysqli_fetch_array($result_team)){
                                            ?>
                                            <option value="<?php echo $d_team['id_dg_user']; ?>"><?php echo $d_team['nama']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama_divisi2" class="col-12 col-form-label">Nama Divisi</label>
                                    <div class="col-12">
                                        <select class="form-control select2 nama_divisi2" style="width: 100%;" name="nama_divisi2" id="nama_divisi2">
                                            <option selected disabled value="">-Pilih Nama Divisi-</option>    
                                            <?php 
                                                $result_divisi = mysqli_query($db2,"SELECT *
                                                FROM dg_division WHERE deleted_by is null
                                                ORDER BY id_dg_division");
                                                while($d_divisi = mysqli_fetch_array($result_divisi)){
                                            ?>
                                            <option value="<?php echo $d_divisi['id_dg_division']; ?>"><?php echo $d_divisi['division_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label for="projectName2" class="col-12 col-form-label">Project Name</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="projectName2" name="projectName2"
                                            placeholder="Ketikan Nama Project" value="" required>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group row">
                                    <label for="deskripsiProject2" class="col-12 col-form-label">Deskripsi Project</label>
                                    <div class="col-12">
                                        <textarea rows="5" type="text" class="form-control" id="deskripsiProject2" name="deskripsiProject2"
                                            placeholder="Masukan detail Project"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                        
               
                        <div class="row">
                            
                            <table id="table-rab" class="table table-bordered table-striped" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Bulan</th>
                                        <th style="width: 20%; text-align: right;">Harga Fee</th>
                                        <th style="width: 5%; text-align: center;">Clear</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-rab">
                                    <tr>
                                        <td>
                                            <input type="month" class="form-control selectBulanTahun" name="selectBulanTahun[]" id="selectBulanTahun">
                                        </td>
                                        <td style="text-align: right;">
                                            <input type="text" data-a-sign="" data-a-sep="." onchange="updateSelisihFee()"
                                            style="text-align: right;" name="hargaFee[]" class="hargaFee form-control"
                                            placeholder="Rp. Harga Fee" autocomplete="off" value="0" min="0" required>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger removeRowBtn" style="width: 30px;">x</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="row">
                                                <hr style="width: 80%;"><button  id="addRowBtn" style="width: 15%;" type="button" class="btn btn-success">+</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Fee</b></td>
                                        <td style="text-align: right;"><b id="totalFee">Rp 0</b></td> 
                                        <td></td>
                                    </tr>
                                   
                                </tbody>
                            </table>


                        </div>
                        

                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client2" value="<?php echo $id_client; ?>">
                        <input type="hidden" name="selectBulanTahun2" id="selectBulanTahun2" value="<?php echo $bulanTahunTerpilih; ?>">
                        <input type="hidden" name="status_rab" value="1">



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" onclick="saveDataBreakDown()" class="btn btn-primary">Save</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-edit-rab-header">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Header RAB</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">


                        <div class="row">
                            <div class="col-12" style="padding-right: 20px;">

                                <div class="form-group row">
                                    <label for="nama_team4" class="col-12 col-form-label">Nama User</label>
                                    <div class="col-12">
                                        <select class="form-control select2 nama_team4" style="width: 100%;" name="nama_team4" id="nama_team4">
                                            <option selected disabled value="">-Pilih Nama User-</option>    
                                            <?php 
                                                $result_team = mysqli_query($db2,"SELECT *
                                                FROM dg_user
                                                ORDER BY id_dg_user");
                                                while($d_team = mysqli_fetch_array($result_team)){
                                            ?>
                                            <option value="<?php echo $d_team['id_dg_user']; ?>"><?php echo $d_team['nama']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_divisi4" class="col-12 col-form-label">Nama Divisi</label>
                                    <div class="col-12">
                                        <select class="form-control select2 nama_divisi4" style="width: 100%;" name="nama_divisi4" id="nama_divisi4">
                                            <option selected disabled value="">-Pilih Nama Divisi-</option>    
                                            <?php 
                                                $result_divisi = mysqli_query($db2,"SELECT *
                                                FROM dg_division WHERE deleted_by is null
                                                ORDER BY id_dg_division");
                                                while($d_divisi = mysqli_fetch_array($result_divisi)){
                                            ?>
                                            <option value="<?php echo $d_divisi['id_dg_division']; ?>"><?php echo $d_divisi['division_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label for="projectName4" class="col-12 col-form-label">Project Name</label>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="projectName4" name="projectName4"
                                            placeholder="Ketikan Nama Project" value="" required>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group row">
                                    <label for="deskripsiProject4" class="col-12 col-form-label">Deskripsi Project</label>
                                    <div class="col-12">
                                        <textarea rows="5" type="text" class="form-control" id="deskripsiProject4" name="deskripsiProject4"
                                            placeholder="Masukan detail Project"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                        
               
                        

                        <input type="hidden" name="id_user3" value="<?php echo $id_user; ?>">




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" onclick="editDataHeader()" class="btn btn-primary">Save</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <div class="modal fade" id="modal-cancel-rab">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus RAB ini ?<br>
                        RAB &nbsp; : <b id="Jenis_warna3"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_rab_detail" id="id_dg_rab_detail" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteBreakDown()"  class="btn btn-danger">Yes</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
   

    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header no-print">
                <div class="container-fluid">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6 col-12">

                                <div style="margin: 10px;">
                                    <input class="form-control rab-month" type="month" id="bdaymonth" name="bdaymonth" value="<?php echo $bulanTahunTerpilih; ?>" onchange="updateTanggalRAB()">
                                </div>

                            </div>

                            <div class="col-md-6 col-12 no-print">
                                <div class="d-flex justify-content-end" style="margin: 10px;">
                                    <button style="width: 150px; margin-right: 10px;" class="btn btn-info" onclick="printWithTitle('RANCANGAN ANGGARAN BIAYA')">
                                        Print RAB <i class="fas fa-print pl-2"></i>
                                    </button>

                                    <?php if($_SESSION['priv']==1){?>
                                    <button style="width: 150px; margin-right: 10px;" class="btn btn-info" onclick="printWithTitle('INVOICE')">
                                        Print Invoice <i class="fas fa-print pl-2"></i>
                                    </button>
                                    
                                    <button class="btn btn-warning" name="id_ev" title="Edit this RAB Info"
                                        data-toggle="modal"
                                        data-target="#modal-edit-rab-header" data-backdrop="static"
                                        data-keyboard="false"
                                        style="width: 150px;  margin-right: 10px;">
                                        Edit <i class="fas fa-pencil-alt pl-2"></i>
                                    </button>
                                    
                                    <button class="btn btn-success" name="add_rab" title="Add RAB"
                                        data-toggle="modal"
                                        data-target="#modal-add-rab" data-backdrop="static"
                                        data-keyboard="false"
                                        style="width: 150px;">
                                        Add <i class="fas fa-plus"></i>
                                    </button>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div><!-- /.container-fluid -->
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="rabTableContainer">
                                        
                                </div>   
                            </div>
                        </div>
                    </div>

                    
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js" type="text/javascript">
    </script>
    <script src="plugins/autoNumeric/src/main.js" type="text/javascript"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
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
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
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

    <!-- Page specific script -->
    <script>


        $('#modal-add-rab').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $('#modal-edit-rab-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })


    function printWithTitle(title) {
        document.getElementById("labelRAB").innerHTML = "<b>" + title + "</b>";
        window.print();
        // Setelah pencetakan selesai, kembalikan teks ke semula
        setTimeout(function() {
            document.getElementById("labelRAB").innerHTML = "<b>RANCANGAN ANGGARAN BIAYA</b>";
        }, 100);
    }


      

        $(function () {


            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
            theme: 'bootstrap4'
            })


            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                "sorting": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
        

        $(function () {
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
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            
            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'DD/MM/YYYY'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()


        })

 


            var selectedDate = $('#bdaymonth').val();
            document.getElementById("selectBulanTahun").value = selectedDate;
            document.getElementById("selectBulanTahun2").value = selectedDate;

            var intervalID;
            var isTouching = false;  // Menandai apakah pengguna sedang menggulir atau tidak
            var touchEndTimer;  // Timer untuk penundaan setelah touchend

            // Fungsi untuk memperbarui RAB
            function updateTanggalRAB() {
                if (!isTouching) {  // Hanya melakukan update jika tidak sedang menggulir
                    // Mendapatkan nilai bulan dan tahun dari input
                    var selectedDate = $('#bdaymonth').val();

                    // Kirim permintaan AJAX untuk mengambil data dari database
                    $.ajax({
                        url: 'view/table/tableRAB.php',
                        type: 'GET',
                        data: { 
                            selectedDate: selectedDate
                        },
                        success: function(response) {
                            // Perbarui isi div dengan data yang diambil dari database
                            $('.rabTableContainer').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            }

            // Fungsi untuk menghentikan interval sementara
            function stopInterval() {
                clearInterval(intervalID);
            }

            // Fungsi untuk memulai interval kembali setelah delay
            function startIntervalAfterDelay() {
                touchEndTimer = setTimeout(function() {
                    intervalID = setInterval(updateTanggalRAB, 3000);  // Restart interval setelah 5 detik
                    updateTanggalRAB();  // Jalankan update setelah penundaan
                }, 5000);  // 5000 ms = 5 detik
            }

            // Panggil fungsi updateTanggalRAB() saat halaman pertama kali dimuat
            updateTanggalRAB();

            // Atur interval untuk memanggil updateTanggalRAB() setiap 3 detik
            intervalID = setInterval(updateTanggalRAB, 3000);

            // Event listener untuk mendeteksi sentuhan (touch) pada tabel di perangkat mobile
            $('.rabTableContainer').on('touchstart', function() {
                isTouching = true;  // Menandai bahwa pengguna sedang menyentuh tabel
                stopInterval();  // Hentikan interval saat sentuhan dimulai

                // Batalkan timer penundaan jika pengguna mulai menyentuh lagi
                if (touchEndTimer) {
                    clearTimeout(touchEndTimer);
                }
            });

            $('.rabTableContainer').on('touchend', function() {
                isTouching = false;  // Menandai bahwa pengguna telah selesai menyentuh tabel
                startIntervalAfterDelay();  // Mulai ulang interval setelah 5 detik
            });
        
        $(document).ready(function() {
            // Cek koneksi
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });






// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn");
// Ambil semua elemen input dengan kelas hargaFee
var inputs = document.querySelectorAll('.hargaFee');

// Iterasi melalui setiap elemen input dan terapkan AutoNumeric
inputs.forEach(function(input) {
    new AutoNumeric(input, {
        allowDecimalPadding: false,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        minimumValue: "0",
        decimalPlaces: 6
    });
});

$(document).ready(function() {
    // Ambil elemen input selectBulanTahun
    var selectBulanTahun = $('.selectBulanTahun');

    // Buat objek Date untuk bulan saat ini
    var currentDate = new Date();
    var currentDay = currentDate.getDate(); // Ambil tanggal saat ini

    // Jika tanggal >= 5, tambahkan satu bulan, jika tidak, tetap di bulan ini
    if (currentDay < 5 && <?php echo $status_user; ?> == 1) {
        currentDate.setMonth(currentDate.getMonth());
    }else{
        currentDate.setMonth(currentDate.getMonth() + 1);
    }


    // Dapatkan tahun dan bulan baru
    var newYear = currentDate.getFullYear();

    
    var newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Gabungkan tahun dan bulan baru menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Atur nilai input selectBulanTahun menjadi bulan berikutnya dari sekarang
    selectBulanTahun.val(nextMonth);

    // Set nilai minimum untuk input month
    var minDate = newYear + '-' + newMonth;
    selectBulanTahun.attr('min', minDate);


    // Tambahkan event listener ke tombol "x" untuk menghapus baris
    $('.removeRowBtn').click(function() {
        $(this).closest('tr').remove(); // Hapus baris <tr> terdekat saat tombol "x" ditekan
        // Perbarui nilai di tabel
        updateSelisihFee();
    });
});





// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn");

// Tambahkan event listener ke tombol "+" untuk menambahkan baris baru ke tabel
addButton.addEventListener("click", function() {
    // Dapatkan semua input bulan
    var monthInputs = document.querySelectorAll('.selectBulanTahun');

    // Dapatkan nilai bulan terakhir
    var lastMonthInput = monthInputs[monthInputs.length - 1];
    
    // Periksa jika lastMonth tidak memiliki nilai
    if (typeof lastMonthInput === 'undefined' || !lastMonthInput.value) {
        // Buat objek Date untuk bulan saat ini
        var currentDate = new Date();
        currentDate.setDate(1);

        // Dapatkan tahun dan bulan baru
        var newYear = currentDate.getFullYear();
        var newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

        // Atur lastMonthDate ke bulan saat ini
        lastMonthDate = new Date(newYear + '-' + newMonth);
    }else{

        var lastMonth = lastMonthInput.value;

        // Ubah nilai bulan terakhir menjadi objek Date
        var lastMonthDate = new Date(lastMonth);
    }



    

    // Tambahkan satu bulan ke nilai bulan terakhir
    lastMonthDate.setMonth(lastMonthDate.getMonth() + 1);

    // Dapatkan tahun dan bulan baru
    var newYear = lastMonthDate.getFullYear();
    var newMonth = (lastMonthDate.getMonth() + 1).toString().padStart(2, '0');

    // Gabungkan tahun dan bulan menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Buat elemen input untuk bulan
    var monthInput = document.createElement('input');
    monthInput.type = 'month';
    monthInput.className = 'form-control selectBulanTahun';
    monthInput.name = 'selectBulanTahun[]';
    monthInput.value = nextMonth;

    // Buat elemen input untuk harga fee
    var hargaFeeInput = document.createElement('input');
    hargaFeeInput.type = 'text';
    hargaFeeInput.className = 'hargaFee form-control';
    hargaFeeInput.setAttribute('data-a-sign', '');
    hargaFeeInput.setAttribute('data-a-sep', '.');
    hargaFeeInput.setAttribute('onchange', 'updateSelisihFee()');
    hargaFeeInput.style.textAlign = 'right';
    hargaFeeInput.name = 'hargaFee[]';
    hargaFeeInput.placeholder = 'Rp. Harga Fee';
    hargaFeeInput.value = '0';
    hargaFeeInput.min = '0';
    hargaFeeInput.required = true;

    // Buat tombol hapus baris
    var removeRowBtn = document.createElement('button');
    removeRowBtn.className = 'btn btn-danger removeRowBtn';
    removeRowBtn.style.width = '30px';
    removeRowBtn.textContent = 'x';
    removeRowBtn.addEventListener('click', function() {
        newRow.remove(); // Menghapus baris saat tombol x ditekan
        updateSelisihFee();
    });

    // Buat elemen td untuk baris baru
    var newRow = document.createElement('tr');
    
    // Buat elemen td untuk input bulan
    var monthCell = document.createElement('td');
    monthCell.appendChild(monthInput);
    newRow.appendChild(monthCell);

    // Buat elemen td untuk input harga fee
    var hargaFeeCell = document.createElement('td');
    hargaFeeCell.style.textAlign = 'right';
    hargaFeeCell.appendChild(hargaFeeInput);
    newRow.appendChild(hargaFeeCell);
    
    // Buat elemen td untuk tombol hapus baris
    var removeRowCell = document.createElement('td');
    removeRowCell.style.textAlign = 'center';
    removeRowCell.appendChild(removeRowBtn);
    newRow.appendChild(removeRowCell);
    
    // Sisipkan baris baru sebelum parent dari parent tombol "+"
    addButton.closest('tr').insertAdjacentElement('beforebegin', newRow);

    // Inisialisasi AutoNumeric untuk input harga fee baru
    new AutoNumeric(hargaFeeInput, {
        allowDecimalPadding: false,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        minimumValue: "0",
        decimalPlaces: 6
    });

    // Buat objek Date untuk bulan saat ini
    var currentDate = new Date();
    currentDate.setDate(1);

    // Tambahkan satu bulan ke bulan saat ini
    currentDate.setMonth(currentDate.getMonth() + 1);


    // Dapatkan tahun dan bulan baru
    var newYearX = currentDate.getFullYear();
    var newMonthX = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Ambil elemen input selectBulanTahun
    var selectBulanTahun = $('.selectBulanTahun');
    // Set nilai minimum untuk input month
    var minDate = newYearX + '-' + newMonthX;
    selectBulanTahun.attr('min', minDate);
});




// Fungsi untuk menampilkan atau menyembunyikan baris selisih
function toggleRowSelisih(isVisible) {
    var rowSelisih = document.getElementById("rowSelisih");
    rowSelisih.style.display = isVisible ? "table-row" : "none";
}


function updateSelisihFee() {
    // Ambil nilai total harga fee dari semua input harga fee
    var totalHargaFee = 0;
    var hargaFeeInputs = document.querySelectorAll('.hargaFee');
    hargaFeeInputs.forEach(function(input) {
        totalHargaFee += parseFloat(input.value.replace(/\./g, '').replace(/,/g, '.'));
    });


    // Hitung selisih fee
    var totalFee = totalHargaFee;

    // Update tampilan selisih fee
    var totalFeeElement = document.getElementById("totalFee");
    totalFeeElement.textContent = 'Rp ' + totalFee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    

}



// Panggil fungsi updateSelisihFee saat ada perubahan pada input harga fee atau input jumlah komponen
var hargaFeeInputs = document.querySelectorAll('.hargaFee');
hargaFeeInputs.forEach(function(input) {
    input.addEventListener('input', updateSelisihFee);
});

// var jumlahKomponenInput = document.getElementById("jumlahKomponen");
// jumlahKomponenInput.addEventListener('input', updateSelisihFee);


// Fungsi untuk memformat angka menjadi format mata uang (misalnya: Rp 1.000.000)
function formatCurrency(amount) {
    return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}






function saveDataBreakDown() {
    // Ambil nilai dari input
    var nama_team2 = document.getElementById("nama_team2").value;
    var nama_divisi2 = document.getElementById("nama_divisi2").value;
    var projectName2 = document.getElementById("projectName2").value;
    var deskripsiProject2 = document.getElementById("deskripsiProject2").value;
    var id_user = <?php echo $id_user;?>;
    var status_rab = "1";

    
    // Mendapatkan nilai dari input selectBulanTahun[]
    var selectBulanTahun = [];
    var inputs = document.querySelectorAll('.selectBulanTahun');
    inputs.forEach(function(input) {
        selectBulanTahun.push(input.value);
    });

    // Mendapatkan nilai dari input hargaFee[]
    var hargaFee = [];
    var inputs = document.querySelectorAll('.hargaFee');
    inputs.forEach(function(input) {
        var value = input.value.trim(); // Menghapus spasi di awal dan akhir
        hargaFee.push(value);
    });
    

    // Cek apakah ada hargaFee yang kosong atau bernilai 0
    if (hargaFee.some(val => val === '' || parseFloat(val) === 0)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat harga fee yang kosong atau bernilai 0.');
        return; // Keluar dari fungsi jika ada hargaFee yang kosong atau bernilai 0
    }

    // Cek apakah ada nilai yang sama di dalam array selectBulanTahun
    if (hasDuplicates(selectBulanTahun)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat bulan dan tahun yang sama.');
        return; // Keluar dari fungsi jika ada nilai yang sama di dalam array selectBulanTahun
    }

    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: 'controller/conn_add_rab_detail.php',
        type: 'POST',
        data: {
            nama_team2: nama_team2,
            nama_divisi2 : nama_divisi2,
            projectName2 : projectName2,
            deskripsiProject2 : deskripsiProject2,
            selectBulanTahun : selectBulanTahun,
            hargaFee : hargaFee,
            id_user : id_user,
            status_rab : status_rab

        },
        dataType: 'html',
        success: function(response) {
            // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
            if (!response.includes('Error')) {
                toastr.success('Data berhasil disimpan.');
            } else {
                toastr.error('Data gagal disimpan !<br>' + response);
            }
            // Kosongkan nilai input
            $('#modal-add-rab').modal('hide');
        },
        error: function(xhr, status, error) {
            // Tangani kesalahan saat mengirim permintaan AJAX
            console.error('Error:', error);
        }
    });
   
}

$('#modal-add-rab').on('hidden.bs.modal', function () {
    // Kosongkan semua input text, textarea, dan select
    $(this).find('input:text, input:password, input:file, select, textarea').val('');
    
    // Kosongkan semua input checkbox dan radio
    $(this).find('input:checkbox, input:radio').prop('checked', false);

    // Kosongkan input dengan tipe file
    $(this).find('input:file').val('');
});


function editDataHeader() {
    // Ambil nilai dari input
    var nama_team2 = document.getElementById("nama_team2").value;
    var nama_divisi2 = document.getElementById("nama_divisi2").value;
    var projectName2 = document.getElementById("projectName2").value;
    var deskripsiProject2 = document.getElementById("deskripsiProject2").value;
    var id_user = <?php echo $id_user;?>;


    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: 'controller/conn_edit_rab.php',
        type: 'POST',
        data: {
            nama_team2: nama_team2,
            nama_divisi2 : nama_divisi2,
            projectName2 : projectName2,
            deskripsiProject2 : deskripsiProject2,
            selectBulanTahun : selectBulanTahun,
            hargaFee : hargaFee,
            id_user : id_user

        },
        dataType: 'html',
        success: function(response) {
            // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
            if (!response.includes('Error')) {
                toastr.success('Data berhasil disimpan.');
            } else {
                toastr.error('Data gagal disimpan !<br>' + response);
            }
            // Kosongkan nilai input
            $('#modal-edit-rab-header').modal('hide');
        },
        error: function(xhr, status, error) {
            // Tangani kesalahan saat mengirim permintaan AJAX
            console.error('Error:', error);
        }
    });
   
}


function deleteBreakDown() {
        // Ambil nilai dari input text dengan id "linkProject" dan "linkName"
        var id_user = $('#id_user').val();
        var id_dg_rab_detail = $('#id_dg_rab_detail').val();
        var id_client = $('#id_client').val();
        

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            url: 'controller/conn_delete_rab.php',
            type: 'POST',
            data: { id_dg_rab_detail: id_dg_rab_detail },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server
                if (!response.includes('Error')) {
                    // Lakukan tindakan sesuai dengan penghapusan berhasil
                    toastr.success('RAB berhasil dihapus.');
                } else {
                    // Lakukan tindakan sesuai dengan penghapusan gagal
                    toastr.error('Gagal menghapus RAB!<br>'+response);
                }
                $('#modal-cancel-rab').modal('hide');
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }



// Fungsi untuk memeriksa apakah ada nilai yang sama di dalam array
function hasDuplicates(array) {
    return (new Set(array)).size !== array.length;
}



    </script>
</body>

</html>