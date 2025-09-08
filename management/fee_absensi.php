<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fee Absensi | DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            white-space: pre;
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
        /* CSS untuk menyembunyikan tombol X pada modal Summernote */
        .note-modal .close {
            display: none !important;
        }

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .modal-dialog{
                min-width: 1000px !important;
            }
            .btn-success {
                right: 0px; 
                width: 150px; 
                margin-top: 10px; 
                margin-right: 20px;
            }
            .row-hg{
                height: 30px;
            }
            .date-awal{
                margin: 10px; 
                margin-left: 20px;
            }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .btn-success { 
                width: 100%;
            }
            .pd-bt{
                padding-left: 30px;
                padding-right: 30px;
            }
            .date-awal{
                margin: 10px; 
                margin-left: 10px;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">



    <!-- Modal Add Data -->
<div class="modal fade" id="modal-add-fee" tabindex="-1" role="dialog" aria-labelledby="modalAddFeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddFeeLabel">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addFeeForm">
                <div class="modal-body">
                    <!-- Nama User -->
                    <div class="form-group row">
                        <label for="nama_user" class="col-12 col-form-label">Nama User</label>
                        <div class="col-12">
                            <select class="form-control select2" style="width: 100%;" name="nama_user" id="nama_user" required>
                                <option selected disabled value="">-Pilih Nama User-</option>
                                <?php 
                                $result_user = mysqli_query($db2, "SELECT id_dg_user, nama FROM dg_user WHERE deleted_at IS NULL AND status <= 4 ORDER BY id_dg_user");
                                while ($user = mysqli_fetch_array($result_user)) {
                                    echo "<option value='{$user['id_dg_user']}'>{$user['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Event -->
                    <div class="form-group row">
                        <label for="nama_event" class="col-12 col-form-label">Nama Event</label>
                        <div class="col-12">
                            <select class="form-control select2" style="width: 100%;" name="nama_event" id="nama_event" required>
                                <option selected disabled value="">-Pilih Nama Event-</option>
                                <?php 
                                $result_event = mysqli_query($db2, "SELECT id_dg_event, nama_event FROM dg_event ORDER BY id_dg_event");
                                while ($event = mysqli_fetch_array($result_event)) {
                                    echo "<option value='{$event['id_dg_event']}'>{$event['nama_event']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tambahan Fee Offline -->
                    <div class="form-group row">
                        <label for="tambahan_fee_offline" class="col-12 col-form-label">Tambahan Fee Offline</label>
                        <div class="col-12">
                            <input type="text" name="tambahan_fee_offline" id="tambahan_fee_offline" 
                                   class="form-control" placeholder="Tambahan Fee Offline" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Tambahan Fee Online -->
                    <div class="form-group row">
                        <label for="tambahan_fee_online" class="col-12 col-form-label">Tambahan Fee Online</label>
                        <div class="col-12">
                            <input type="text" name="tambahan_fee_online" id="tambahan_fee_online" 
                                   class="form-control" placeholder="Tambahan Fee Online" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="modal-edit-fee" tabindex="-1" role="dialog" aria-labelledby="modalEditFeeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditFeeLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editFeeForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="edit_id">
                    
                    <!-- Nama User -->
                    <div class="form-group row">
                        <label for="edit_nama_user" class="col-12 col-form-label">Nama User</label>
                        <div class="col-12">
                            <select class="form-control select2" style="width: 100%;" name="edit_nama_user" id="edit_nama_user" required>
                                <option selected disabled value="">-Pilih Nama User-</option>
                                <?php 
                                $result_user = mysqli_query($db2, "SELECT id_dg_user, nama FROM dg_user WHERE deleted_at IS NULL AND status <= 4 ORDER BY id_dg_user");
                                while ($user = mysqli_fetch_array($result_user)) {
                                    echo "<option value='{$user['id_dg_user']}'>{$user['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Nama Event -->
                    <div class="form-group row">
                        <label for="edit_nama_event" class="col-12 col-form-label">Nama Event</label>
                        <div class="col-12">
                            <select class="form-control select2" style="width: 100%;" name="edit_nama_event" id="edit_nama_event" required>
                                <option selected disabled value="">-Pilih Nama Event-</option>
                                <?php 
                                $result_event = mysqli_query($db2, "SELECT id_dg_event, nama_event FROM dg_event ORDER BY id_dg_event");
                                while ($event = mysqli_fetch_array($result_event)) {
                                    echo "<option value='{$event['id_dg_event']}'>{$event['nama_event']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tambahan Fee Offline -->
                    <div class="form-group row">
                        <label for="edit_tambahan_fee_offline" class="col-12 col-form-label">Tambahan Fee Offline</label>
                        <div class="col-12">
                            <input type="text" name="edit_tambahan_fee_offline" id="edit_tambahan_fee_offline" 
                                   class="form-control" placeholder="Tambahan Fee Offline" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Tambahan Fee Online -->
                    <div class="form-group row">
                        <label for="edit_tambahan_fee_online" class="col-12 col-form-label">Tambahan Fee Online</label>
                        <div class="col-12">
                            <input type="text" name="edit_tambahan_fee_online" id="edit_tambahan_fee_online" 
                                   class="form-control" placeholder="Tambahan Fee Online" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>





    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="m-0">Fee Absensi Tambahan</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row row-hg">
                                    <div class="col-6 form-group"></div>
                                    <div class="col-md-6 col-12 form-group pd-bt">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-fee" data-backdrop="static" data-keyboard="false">
                                            + Add Data
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="" style="overflow: auto;">
                                        <table id="example1" class="table table-bordered table-striped" style="width: 100%; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama User</th>
                                                    <th>Nama Event</th>
                                                    <th style="text-align: right;">Tambahan Offline</th>
                                                    <th style="text-align: right;">Tambahan Online</th>
                                                    <th style="text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableFee">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include 'view/common/footer.html'; ?>

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
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>

    <!-- Page specific script -->
    <script>

        // Handle edit button click
        $('#tableFee').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: 'view/ajax/get_fee_data.php', // Endpoint untuk mendapatkan data berdasarkan ID
                method: 'POST',
                data: { id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#edit_id').val(response.data.id_dg_event_user_tambahan);
                        $('#edit_nama_user').val(response.data.id_dg_user).trigger('change');
                        $('#edit_nama_event').val(response.data.id_dg_event).trigger('change');
                        AutoNumeric.getAutoNumericElement('#edit_tambahan_fee_offline').set(response.data.tambahan_fee_offline);
                        AutoNumeric.getAutoNumericElement('#edit_tambahan_fee_online').set(response.data.tambahan_fee_online);

                        $('#modal-edit-fee').modal('show');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function () {
                    toastr.error('Failed to fetch data.', 'Error');
                }
            });
        });

        // Handle edit form submission
        $('#editFeeForm').on('submit', function (e) {
            e.preventDefault();

            const formData = {
                id: $('#edit_id').val(),
                id_user: $('#edit_nama_user').val(),
                id_event: $('#edit_nama_event').val(),
                tambahan_fee_offline: AutoNumeric.getAutoNumericElement('#edit_tambahan_fee_offline').getNumericString(),
                tambahan_fee_online: AutoNumeric.getAutoNumericElement('#edit_tambahan_fee_online').getNumericString()
            };

            $.ajax({
                url: 'view/ajax/update_fee_data.php', // Endpoint untuk update data
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadFeeData();
                        toastr.success(response.message, 'Success');
                        $('#modal-edit-fee').modal('hide');
                        
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function () {
                    toastr.error('An error occurred while updating data.', 'Error');
                }
            });
        });
     
        // Handle delete button click
        $('#tableFee').on('click', '.btn-delete', function () {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this data?')) {
                $.ajax({
                    url: 'view/ajax/delete_fee_data.php', // Endpoint untuk hapus data
                    method: 'POST',
                    data: { id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            loadFeeData();
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function () {
                        toastr.error('An error occurred while deleting data.', 'Error');
                    }
                });
            }
        });

    
            // Fungsi untuk memuat data dari database
            function loadFeeData() {
                $.ajax({
                    url: 'view/ajax/load_fee_data.php', // Ganti dengan lokasi PHP handler Anda
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let tableRows = '';
                            response.data.forEach((item, index) => {
                                tableRows += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.nama_user}</td>
                                        <td>${item.nama_event}</td>
                                        <td style="text-align: right;">${formatRupiah(item.tambahan_fee_offline)}</td>
                                        <td style="text-align: right;">${formatRupiah(item.tambahan_fee_online)}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">Edit</button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">Delete</button>
                                        </td>
                                    </tr>`;
                            });
                            $('#tableFee').html(tableRows);
                        } else {
                            $('#tableFee').html('<tr><td colspan="6">No data available.</td></tr>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        let errorMessage = 'Error loading data.';
                        
                        // Cek apakah respons memiliki properti responseJSON dan error
                        if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                            errorMessage = jqXHR.responseJSON.error;
                        } else if (jqXHR.responseText) {
                            errorMessage = `Error: ${jqXHR.responseText}`;
                        } else if (errorThrown) {
                            errorMessage = `Error: ${errorThrown}`;
                        }

                        $('#tableFee').html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                        console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                        console.error(`Server Response: ${jqXHR.responseText}`);
                    },

                });
            }

             // Handle form submission
             $('#addFeeForm').on('submit', function (e) {
                e.preventDefault(); // Mencegah reload halaman

                const formData = {
                    id_user: $('#nama_user').val(),
                    id_event: $('#nama_event').val(),
                    tambahan_fee_offline: AutoNumeric.getAutoNumericElement('#tambahan_fee_offline').getNumericString(),
                    tambahan_fee_online: AutoNumeric.getAutoNumericElement('#tambahan_fee_online').getNumericString()
                };

                $.ajax({
                    url: 'view/ajax/save_fee_data.php', // Endpoint PHP untuk menyimpan data
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            $('#modal-add-fee').modal('hide'); // Tutup modal
                            $('#addFeeForm')[0].reset(); // Reset form
                            loadFeeData(); // Reload tabel data
                        } else {
                            toastr.error(response.message, 'Error'); // Tampilkan pesan error
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr.error('An error occurred while saving data.', 'Error');
                        console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                    }
                });
            });



            // Format angka ke dalam format Rupiah
            function formatRupiah(value) {
                return parseInt(value).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            }

        $(document).ready(function () {
            
            // Initialize Select2
            $('.select2').select2();

            // Initialize AutoNumeric for numeric inputs
            new AutoNumeric('#tambahan_fee_offline', { 
                decimalPlaces: 0, // Tidak ada desimal
                digitGroupSeparator: '.', // Pemisah ribuan
                decimalCharacter: ',', // Pemisah desimal
                minimumValue: '0' 
            });

            new AutoNumeric('#tambahan_fee_online', { 
                decimalPlaces: 0, // Tidak ada desimal
                digitGroupSeparator: '.', // Pemisah ribuan
                decimalCharacter: ',', // Pemisah desimal
                minimumValue: '0' 
            });


            // Initialize AutoNumeric for numeric inputs
            new AutoNumeric('#edit_tambahan_fee_offline', { 
                decimalPlaces: 0, // Tidak ada desimal
                digitGroupSeparator: '.', // Pemisah ribuan
                decimalCharacter: ',', // Pemisah desimal
                minimumValue: '0' 
            });

            new AutoNumeric('#edit_tambahan_fee_online', { 
                decimalPlaces: 0, // Tidak ada desimal
                digitGroupSeparator: '.', // Pemisah ribuan
                decimalCharacter: ',', // Pemisah desimal
                minimumValue: '0' 
            });

           

            // Panggil fungsi saat halaman selesai dimuat
            loadFeeData();
            // Panggil fungsi loadFeeData saat halaman pertama kali dimuat
            setInterval(loadFeeData, 3000); // Cek setiap 3 detik


            // Cek koneksi
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik
        });


     






    </script>
</body>

</html>