<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hari Libur | DIK Group</title>

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
    <div class="modal fade" id="modal-add-libur" tabindex="-1" role="dialog" aria-labelledby="modalAddliburLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddliburLabel">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addliburForm">
                    <div class="modal-body">
                        
                        <!-- Nama Hari -->
                        <div class="form-group row">
                            <label for="nama_libur" class="col-12 col-form-label">Nama Hari Libur</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="nama_libur" name="nama_libur"
                                placeholder="Ketikan Nama Hari Libur" value="" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="add_startDate" class="col-12 col-form-label">Start Date</label>
                            <div class="col-12">
                                <input type="date" class="form-control" id="add_startDate" name="add_startDate" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="add_finishDate" class="col-12 col-form-label">Finish Date</label>
                            <div class="col-12">
                                <input type="date" class="form-control" id="add_finishDate" name="add_finishDate" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan_libur" class="col-12 col-form-label">Keterangan</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="keterangan_libur" name="keterangan_libur"
                                placeholder="Ketikan Keterangan" value="">
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
    <div class="modal fade" id="modal-edit-libur" tabindex="-1" role="dialog" aria-labelledby="modalEditliburLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditliburLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editliburForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        
                        <!-- Nama Hari -->
                        <div class="form-group row">
                            <label for="edit_nama_libur" class="col-12 col-form-label">Nama Hari Libur</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="edit_nama_libur" name="edit_nama_libur"
                                placeholder="Ketikan Nama Hari Libur" value="" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="edit_startDate" class="col-12 col-form-label">Start Date</label>
                            <div class="col-12">
                                <input type="date" class="form-control" id="edit_startDate" name="edit_startDate" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="edit_finishDate" class="col-12 col-form-label">Finish Date</label>
                            <div class="col-12">
                                <input type="date" class="form-control" id="edit_finishDate" name="edit_finishDate" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="edit_keterangan_libur" class="col-12 col-form-label">Keterangan</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="edit_keterangan_libur" name="edit_keterangan_libur"
                                placeholder="Ketikan Keterangan" value="">
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="id_dg_event_hari_libur" name="id_dg_event_hari_libur">


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
                            <h1 class="m-0">Hari Libur</h1>
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
                                            data-target="#modal-add-libur" data-backdrop="static" data-keyboard="false">
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
                                                    <th style="text-align: center;">No</th>
                                                    <th>Nama Hari Libur</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Selesai</th>
                                                    <th>Keterangan</th>
                                                    <th style="text-align: center;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableLibur">
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
        $('#tableLibur').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: 'view/ajax/get_libur_data.php', // Endpoint untuk mendapatkan data berdasarkan ID
                method: 'POST',
                data: { id },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#id_dg_event_hari_libur').val(response.data.id_dg_event_hari_libur);
                        $('#edit_nama_libur').val(response.data.nama_hari_libur);
                        $('#edit_startDate').val(response.data.awal_tanggal_libur);
                        $('#edit_finishDate').val(response.data.akhir_tanggal_libur);
                        $('#edit_keterangan_libur').val(response.data.keterangan);

                        $('#modal-edit-libur').modal('show');
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
        $('#editliburForm').on('submit', function (e) {
            e.preventDefault();

            const formData = {
                nama_libur: $('#edit_nama_libur').val(),
                edit_startDate: $('#edit_startDate').val(),
                edit_finishDate: $('#edit_finishDate').val(),
                keterangan_libur: $('#edit_keterangan_libur').val(),
                id_dg_event_hari_libur: $('#id_dg_event_hari_libur').val(),
                id_user: <?php echo $id_user; ?>
            };

            $.ajax({
                url: 'view/ajax/update_libur_data.php', // Endpoint untuk update data
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadliburData();
                        toastr.success(response.message, 'Success');
                        $('#modal-edit-libur').modal('hide');
                        
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
        $('#tableLibur').on('click', '.btn-delete', function () {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this data?')) {
                $.ajax({
                    url: 'view/ajax/delete_libur_data.php', // Endpoint untuk hapus data
                    method: 'POST',
                    data: { id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            loadliburData();
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
            function loadliburData() {
                $.ajax({
                    url: 'view/ajax/load_libur_data.php', // Ganti dengan lokasi PHP handler Anda
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let tableRows = '';
                            response.data.forEach((item, index) => {
                                tableRows += `
                                    <tr>
                                        <td style="text-align: center;">${index + 1}</td>
                                        <td>${item.nama_hari_libur}</td>
                                        <td>${formatTanggal(item.awal_tanggal_libur)}</td>
                                        <td>${formatTanggal(item.akhir_tanggal_libur)}</td>
                                        <td>${item.keterangan}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">Edit</button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">Delete</button>
                                        </td>
                                    </tr>`;
                            });
                            $('#tableLibur').html(tableRows);
                        } else {
                            $('#tableLibur').html('<tr><td colspan="6" style="text-align: center;">No data available.</td></tr>');
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

                        $('#tableLibur').html(`<tr><td colspan="6">${errorMessage}</td></tr>`);
                        console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                        console.error(`Server Response: ${jqXHR.responseText}`);
                    },

                });
            }

            // Format tanggal menjadi 'Wednesday, 25 December 2024'
            function formatTanggal(dateString) {
                const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                const date = new Date(dateString); // Konversi string ke objek Date
                return date.toLocaleDateString('id-ID', options); // Gunakan lokal 'en-US' untuk format bahasa Inggris
            }


             // Handle form submission
             $('#addliburForm').on('submit', function (e) {
                e.preventDefault(); // Mencegah reload halaman

                const formData = {
                    nama_libur: $('#nama_libur').val(),
                    add_startDate: $('#add_startDate').val(),
                    add_finishDate: $('#add_finishDate').val(),
                    keterangan_libur: $('#keterangan_libur').val(),
                    id_user: <?php echo $id_user; ?>
                };

                $.ajax({
                    url: 'view/ajax/save_libur_data.php', // Endpoint PHP untuk menyimpan data
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            $('#modal-add-libur').modal('hide'); // Tutup modal
                            $('#addliburForm')[0].reset(); // Reset form
                            loadliburData(); // Reload tabel data
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


           

            // Panggil fungsi saat halaman selesai dimuat
            loadliburData();
            // Panggil fungsi loadliburData saat halaman pertama kali dimuat
            setInterval(loadliburData, 3000); // Cek setiap 3 detik


            // Cek koneksi
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik
        });


     






    </script>
</body>

</html>