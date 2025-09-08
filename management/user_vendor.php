<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor</title>

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
    <style>
        .none {
            display: none;
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
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">




    <div class="modal fade" id="modal-add-vendor">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Vendor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddUserVendor" action="controller/conn_add_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-6" style="padding-right: 20px;">
                                    <div class="form-group">
                                        <label for="foto_user4">Vendor Photo</label>
                                        <input class="form-control" type="file" id="foto_user4" name="foto_user4">
                                        <label for="foto_user4"><img id="blah4"
                                                style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                                src="img/profile/t0.jpg" alt="vendor image" /></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamatUser2" class="col-sm-12 col-form-label">Vendor Address</label>
                                        <div class="col-sm-12">
                                            <textarea rows="5" type="text" class="form-control" id="alamatUser2"
                                                name="alamatUser2" placeholder="Enter vendor address"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6" style="padding-left: 20px;">

                                    <div class="form-group row">
                                        <label for="namaUser2" class="col-sm-12 col-form-label">Vendor Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaUser2" name="namaUser2"
                                                placeholder="Enter vendor name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="noRek2" class="col-sm-12 col-form-label">Account Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="noRek2" name="noRek2"
                                                placeholder="Enter account number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank2" class="col-sm-12 col-form-label">Bank Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="bank2" name="bank2"
                                                placeholder="Enter bank name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailUser2" class="col-sm-12 col-form-label">Email Vendor</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailUser2" name="emailUser2"
                                                placeholder="Enter vendor email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomorUser2" class="col-sm-12 col-form-label">Phone Number (WhatsApp)</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nomorUser2" name="nomorUser2"
                                                placeholder="Enter phone number" value="">
                                        </div>
                                    </div>


                                    

                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="status2" value="6">
                        <input type="hidden" name="profile" value="3">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnAddUserVendor">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->



    <div class="modal fade" id="modal-edit-vendor">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Edit Data Vendor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUserVendor" action="controller/conn_edit_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-6" style="padding-right: 20px;">
                                    <div class="form-group">
                                        <label for="foto_user5">Vendor Photo</label>
                                        <input class="form-control" type="file" id="foto_user5" name="foto_user">
                                        <label for="foto_user5"><img id="blah5"
                                                style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                                src="img/profile/t0.jpg" alt="vendor image" /></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamatUser4" class="col-sm-12 col-form-label">Vendor Address</label>
                                        <div class="col-sm-12">
                                            <textarea rows="5" type="text" class="form-control" id="alamatUser4"
                                                name="alamatUser" placeholder="Enter vendor address"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6" style="padding-left: 20px;">

                                    <div class="form-group row">
                                        <label for="namaUser4" class="col-sm-12 col-form-label">Vendor Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaUser4" name="namaUser"
                                                placeholder="Enter vendor name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="noRek4" class="col-sm-12 col-form-label">Account Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="noRek4" name="noRek"
                                                placeholder="Enter account number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank4" class="col-sm-12 col-form-label">Bank Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="bank4" name="bank"
                                                placeholder="Enter bank name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailUser4" class="col-sm-12 col-form-label">Email Vendor</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailUser4" name="emailUser"
                                                placeholder="Enter vendor email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomorUser4" class="col-sm-12 col-form-label">Phone Number (WhatsApp)</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nomorUser4" name="nomorUser"
                                                placeholder="Enter phone number" value="">
                                        </div>
                                    </div>


                                    

                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="status" value="6">
                        <input type="hidden" name="profile" value="3">
                        <input type="hidden" name="id_task" id="id_task5" value="">
                        <input type="hidden" class="form-group" id="bannerLama4" name="bannerLama">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button id="btnEditUserVendor" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">ATTENTION !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this vendor?<br>
                        Vendor Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form id="formDeleteUserVendor"  action="controller/conn_delete_user.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task3" id="id_task3" value="">
                    <input type="hidden" name="profile" value="3">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button id="btnDeleteUserVendor" type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
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

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Data Vendor
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">

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
                                <div class="row" style="height: 0px;">
                                    <div class="col-6 form-group">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                                            style="height: 0px;">
                                        </div>
                                    </div>
                                    <div class="col-6 form-group" style="z-index: 99; height:10px;">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-vendor" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 150px; margin-top: 60px; margin-right: 20px;">
                                            + Add Vendor
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th>Detail</th>
                                                <th class="none">Photo</th>
                                                <th>ID Vendor</th>
                                                <th>Vendor Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                
                                                <th>Account Number</th>
                                                <th>Bank</th>
                                                <th class="none">Address</th>
                                                <th style="width: 15%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTableBody">
                                            <!-- will be filled by ajax -->
                                        </tbody>
                                        
                                    </table>
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

    <!-- Page specific script -->
    <script>

            $(document).ready(function() {
                checkConnection();
                setInterval(checkConnection, 1000); // Cek setiap 1 detik
            });

            
             const tableOptions = {
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "pagingType": 'full_numbers',
                "sorting": true,
                "order": [[1, 'desc']],
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            };

            var table = $('#example2').DataTable(tableOptions);
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


            function loadUserTable() {
                // Simpan halaman aktif saat ini
                var currentPage = table.page();

                $.ajax({
                    url: 'view/ajax/load_vendor_table.php',
                    method: 'GET',
                    success: function(data) {
                        table.clear().destroy(); // hancurkan DataTable

                        $('#userTableBody').html(data); // isi ulang tbody

                        // Re-inisialisasi DataTable
                        table = $('#example2').DataTable(tableOptions);

                        // Kembalikan ke halaman sebelumnya
                        table.page(currentPage).draw('page');

                        // Re-attach tombol export
                        table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
                    },
                    error: function () {
                        toastr.error('Gagal memuat data user!');
                    }
                });
            }


            // Inisialisasi pertama kali
            loadUserTable();

            // Refresh setiap 10 detik
            setInterval(loadUserTable, 10000); // 10000 ms = 10 detik



            // Form submit with AJAX
            $('#formAddUserVendor').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnAddUserVendor').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('Vendor successfully added!');
                            $('#modal-add-vendor').modal('hide');
                            $('#formAddUserVendor')[0].reset();
                            $('#btnAddUserVendor').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnAddUserVendor').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnAddUserVendor').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });

            // Form submit with AJAX
            $('#formEditUserVendor').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnEditUserVendor').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('Vendor successfully edited!');
                            $('#modal-edit-vendor').modal('hide');
                            $('#formEditUserVendor')[0].reset();
                            $('#btnEditUserVendor').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnEditUserVendor').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnEditUserVendor').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });

            // Form submit with AJAX
            $('#formDeleteUserVendor').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnDeleteUserVendor').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('Vendor successfully deleted!');
                            $('#modal-cancel').modal('hide');
                            $('#formDeleteUserVendor')[0].reset();
                            $('#btnDeleteUserVendor').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnDeleteUserVendor').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnDeleteUserVendor').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });




        function redirectToProfile(userId) {
            window.location.href = "profile.php?id_user=" + userId;
        }



        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#foto_user").change(function () {
            readURL(this);
        });

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#foto_user2").change(function () {
            readURL1(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah3').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#foto_user3").change(function () {
            readURL2(this);
        });

        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah4').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#foto_user4").change(function () {
            readURL3(this);
        });

        function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah5').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#foto_user5").change(function () {
            readURL4(this);
        });

        function changeCheck() {
            var checkBox = document.getElementById("customSwitch3");
            if (checkBox.checked) {
                window.location.replace("client.php?aktif=1");
            } else {
                window.location.replace("client.php?aktif=0");
            }
        };






        $('#modal-edit-vendor').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');

            var recipient_e = button.data('e');

            var recipient_f = button.data('f');

            var recipient_h = button.data('h');
            var recipient_i = button.data('i');
            var recipient_j = button.data('j');

            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task5').val(recipient_a);
            document.getElementById("id_task5").value = recipient_a;

            modal.find('.bannerLama4').val(recipient_b);
            document.getElementById("bannerLama4").value = recipient_b;
            if (recipient_b=="") {
                document.getElementById("blah5").src = "img/profile/t0.jpg"
            }else{
            document.getElementById("blah5").src = "img/profile/"+recipient_b;
            }

            modal.find('.namaUser4').val(recipient_c);
            document.getElementById("namaUser4").value = recipient_c;



            modal.find('.emailUser4').val(recipient_e);
            document.getElementById("emailUser4").value = recipient_e;

            modal.find('.nomorUser4').val(recipient_f);
            document.getElementById("nomorUser4").value = recipient_f;

            modal.find('.noRek4').val(recipient_h);
            document.getElementById("noRek4").value = recipient_h;

            modal.find('.bank4').val(recipient_i);
            document.getElementById("bank4").value = recipient_i;

            modal.find('.alamatUser4').val(recipient_j);
            document.getElementById("alamatUser4").innerHTML = recipient_j;           
       

        })
        

        $('#modal-cancel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task3').val(recipient_c);
            document.getElementById("id_task3").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })


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
                
                //Date range picker
                $('#reservationdate2').datetimepicker({
                    format: 'DD-MMMM-yyyy',
                    maxDate: moment(),  // Tanggal maksimal adalah hari ini
                    useCurrent: false,  // Tidak menggunakan tanggal hari ini sebagai tanggal default
                    defaultDate: moment().subtract(25, 'years')  // Tanggal default adalah 25 tahun yang lalu
                });


                
                //Date range picker
                $('#reservation2').daterangepicker()
                //Date range picker with time picker
                $('#reservationtime2').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                })

                //Date range picker
                $('#reservationdate').datetimepicker({
                    format: 'DD-MMMM-yyyy'
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
            })  

        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })
        
        $('#modal-add-user').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $("#accountHead").removeClass("none");
        $("#selectid").on("change", function () {
            $("#accountHead").addClass("none");
            if (this.value == "0") {
                $("#accountHead").removeClass("none");
            }
        });

    </script>
</body>

</html>