<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jenis & Type | DIK Group</title>

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

        /* CSS untuk menyembunyikan tombol X pada modal Summernote */
        .note-modal .close {
            display: none !important;
        }

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .taskTable{
                overflow: none;
            }
            .modal-dialog{
                min-width: 70% !important;
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
            
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .taskTable{
                overflow: scroll;
            }
            .btn-success { 
                width: 100%;
            }
            .row-hg{
                height: 60px;
            }
            .pd-bt{
                padding-left: 30px;
                padding-right: 30px;
            }
            .modal-open .modal{
                overflow: auto;
            }
            .modal-dialog-centered{
                min-height: 0;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="modal fade" id="modal-delete-jenis">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 500px; margin: auto;">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Jenis Project ini ?<br>
                        Nama Jenis Project &nbsp; : <b id="nama_jenis_delete"></b><br>
                </div>
                <form action="controller/conn_delete_jenis.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_jenis_delete" id="id_dg_client_project_jenis_delete" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <div class="modal fade" id="modal-edit-jenis">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 500px; margin: auto;">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Jenis Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_jenis.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="edit_jenis_name" class="col-sm-12 col-form-label">Nama Jenis Project</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="edit_jenis_name" name="edit_jenis_name"
                                    placeholder="Ketikan Nama Jenis Project" value="" required>
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_dg_client_project_jenis" id="id_dg_client_project_jenis" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-add-jenis">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="max-width: 500px; margin: auto;">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add jenis Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_jenis.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="add_jenis_name" class="col-sm-12 col-form-label">Nama Jenis Project</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="add_jenis_name" name="add_jenis_name"
                                    placeholder="Ketikan Nama Jenis Project" value="" required>
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-type">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-type">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">

                            <label for="typeName" class="col-sm-12 col-form-label">Nama Type</label>
                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                <input type="text" class="form-control" id="typeName" name="typeName"
                                placeholder="Ketikan nama type" value="" required>
                            </div>
                        
                            <label for="detail_project_tamplate" class="col-sm-12 col-form-label">Project Tamplate</label>
                            <div class="col-sm-12">
                                <textarea id="summernote" name="detail_project_tamplate"></textarea>
                            </div>

                            <input type="hidden" name="id_dg_client_project_type" id="id_dg_client_project_type" value="">
                            <input type="hidden" name="type_id_dg_client_project_jenis" id="type_id_dg_client_project_jenis" value="">

                            <div class="col-12">
                                <button style="width:95%;" onclick="addtypeToProject()" class="btn btn-info" title="Save Edited type"><i class="fas fa-save"></i> Save</button>
                                <button onclick="clearTypeToProject()" class="btn btn-warning" title="Clear Edited Status"><i class="fas fa-sync-alt"></i></button>
                            </div> 

                        </div>

                    </div>
             </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    
    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-status">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-status">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">

                            <label for="statusName" class="col-2 col-form-label">Nama Status</label>
                            <div class="col-4" style="padding-bottom: 10px;">
                                <input type="text" class="form-control" id="statusName" name="statusName"
                                placeholder="Ketikan nama status" value="" required>
                            </div>
                        
                            <label for="backgroundColor" class="col-2 col-form-label">Background Color</label>
                            <div class="col-4">
                                <input type="color" class="form-control colorpicker" id="backgroundColor" name="backgroundColor" placeholder="Select Background Color" required>
                            </div>

                            <label for="urutan_status" class="col-2 col-form-label">Urutan Status</label>
                            <div class="col-4">
                                <input type="number" class="form-control colorpicker" id="urutan_status" name="urutan_status" required>
                            </div>

                            <label for="is_finish" class="col-2 col-form-label">Status Finsih</label>
                            <div class="col-4">
                                <select class="form-control" id="is_finish" name="is_finish">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <input type="hidden" name="id_dg_client_project_status" id="id_dg_client_project_status" value="">
                            <input type="hidden" name="status_id_dg_client_project_jenis" id="status_id_dg_client_project_jenis" value="">


                            <div class="col-12" style="margin-top: 10px;">
                                <button style="width:95%;" onclick="addStatusToProject()" class="btn btn-info" title="Save Edited Status"><i class="fas fa-save"></i> Save</button>
                                <button onclick="clearStatusToProject()" class="btn btn-warning" title="Clear Edited Status"><i class="fas fa-sync-alt"></i></button>
                            </div>
                        
                    </div>

                </div>
            </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-cancel-status">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Status ini ?<br>
                        Nama Status &nbsp; : <b id="status_name_del"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="del_id_dg_client_project_status" id="del_id_dg_client_project_status" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteStatusToProject()"  class="btn btn-danger">Yes</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-cancel-type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus type ini ?<br>
                        Nama type &nbsp; : <b id="type_name_del"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="del_id_dg_client_project_type" id="del_id_dg_client_project_type" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteTypeToProject()"  class="btn btn-danger">Yes</button>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Management Project
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
                                <div class="row row-hg">
                                    <div class="col-6 form-group"></div>
                                    <div class="col-md-6 col-12 form-group pd-bt">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-jenis" data-backdrop="static" data-keyboard="false">
                                            + Add Data
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12 taskTable">
                                            <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">No</th>
                                                        <th style="min-width: 250px;">Jenis Project</th>
                                                        <th style="min-width: 250px;">Status</th>
                                                        <th style="min-width: 250px;">Type Task</th>
                                                        <th style="text-align: center;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   

                                                </tbody>
                                            </table>
                                        </div>
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
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>

    <!-- Page specific script -->
    <script>

    function loadTableBody() {
        $.ajax({
            url: 'controller/get_modal_body_jenis.php', // Ganti dengan path file PHP backend
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const tableBody = $('#example1 tbody');
                tableBody.empty(); // Kosongkan table body sebelum diisi ulang

                response.data.forEach((row, index) => {
                    let statusHtml = row.statuses.map(status => `
                        <div style="padding: 10px; display: flex; align-items: center; gap: 10px;">
                            ${status.order}. 
                            <div style="width: 16px; height: 16px; background-color: ${status.color}; border: 1px solid #ccc; border-radius: 3px;"></div>
                            ${status.name} ${status.is_finish == 1 ? '<i class="fas fa-flag-checkered"></i>' : ''}
                        </div>
                    `).join('');

                    let typeHtml = row.types.map(type => `
                        ${type.order}. ${type.name}
                        <br><br>
                    `).join('');

                    const actionsHtml = `
                        <button class="btn btn-warning btn-sm" data-backdrop="static" data-keyboard="false" title="Edit Jenis Project"
                            data-a="${row.id_jenis_project}" data-b="${row.jenis_project}" data-toggle="modal" data-target="#modal-edit-jenis">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" data-backdrop="static" data-keyboard="false" title="Delete Jenis Project"
                            data-a="${row.id_jenis_project}" data-b="${row.jenis_project}" data-toggle="modal" data-target="#modal-delete-jenis">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;

                   

                    const rowHtml = `
                        <tr>
                            <td style="text-align: center;">${row.no}</td>
                            <td>${row.jenis_project}</td>
                            <td>
                                <button class="btn btn-success float-sm-right" data-toggle="modal" data-target="#modal-edit-status"
                                    data-backdrop="static" data-keyboard="false"
                                    onclick="loadModalProjectStatus(${row.id_jenis_project}, '${row.jenis_project}')"
                                    title="Setting Status Project" style="width: 30px; height: 30px; padding: 0px;">
                                    <i class="fas fa-cog"></i>
                                </button><br>
                                ${statusHtml}
                            </td>
                            <td>
                                <button class="btn btn-success float-sm-right" data-toggle="modal" data-target="#modal-setting-type"
                                    data-backdrop="static" data-keyboard="false"
                                    onclick="loadModalProjectType(${row.id_jenis_project}, '${row.jenis_project}')"
                                    title="Setting Type Task" style="width: 30px; height: 30px; padding: 0px;">
                                    <i class="fas fa-cog"></i>
                                </button><br>
                                ${typeHtml}
                            </td>
                            <td style="text-align: center;">${actionsHtml}</td>
                        </tr>
                    `;
                    tableBody.append(rowHtml);
                });
            },
            error: function(error) {
                console.error('Error fetching table data:', error);
            }
        });
    }

    // Panggil saat halaman pertama kali dimuat
    $(document).ready(function() {
        loadTableBody();
    });


         // Fungsi untuk mengecek modal aktif setiap 3 detik
        setInterval(function() {
            // Mengecek apakah ada modal yang terlihat/aktif
            if ($('.modal:visible').length) {
                // Jika ada modal yang aktif, tambahkan class 'modal-open' ke body
                if (!$('body').hasClass('modal-open')) {
                    $('body').addClass('modal-open');
                }
            } else {
                // Jika tidak ada modal yang aktif, hapus class 'modal-open' (opsional)
                $('body').removeClass('modal-open');
            }
        }, 3000); // Cek setiap 3000 ms (1 detik)

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik

            // Event handler untuk menangkap saat modal tertutup
            $('#modal-edit-status').on('hidden.bs.modal', function (e) {
                if (e.target.id === 'modal-edit-status') {
                    // Kosongkan nilai input
                    $('#statusName').val('');
                    $('#backgroundColor').val('');
                    $('#id_dg_client_project_status').val('');
                    $('#urutan_status').val('');
                    $('#status_id_dg_client_project_jenis').val('');
                    $('#is_finish').val('');
                }
                
            });

            // Event handler untuk menangkap saat modal tertutup
            $('#modal-edit-type').on('hidden.bs.modal', function (e) {
                if (e.target.id === 'modal-edit-type') {
                    // Kosongkan nilai input
                    $('#typeName').val('');
                    $('#summernote').summernote('code', '');
                    $('#id_dg_client_project_type').val('');
                    $('#type_id_dg_client_project_jenis').val('');
                }
                
            });
        });
        
        $(function () {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "sorting": false,
                "buttons": false,
                "pageLength": 15,
                "bInfo" : false,
                "searching": false
            });

        });

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
                    onImageUploadError: function() {
                        toastr.error('Ukuran file gambar tidak boleh lebih dari 500KB!');
                    }
                }
            });



        $('#modal-delete-jenis').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project_jenis_delete').val(recipient_a);
            document.getElementById("id_dg_client_project_jenis_delete").value = recipient_a;


            document.getElementById("nama_jenis_delete").innerHTML = recipient_b;
        })





        $('#modal-edit-jenis').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');


            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project_jenis').val(recipient_a);
            document.getElementById("id_dg_client_project_jenis").value = recipient_a;

            modal.find('.edit_jenis_name').val(recipient_b);
            document.getElementById("edit_jenis_name").value = recipient_b;



        })


        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })


        function editStatusToProject(id, nama_status, warna_status, urutan_status, is_finish) {
            // Set value pada input Nama Status
            document.getElementById('statusName').value = nama_status;

            // Set value pada input Background Color
            document.getElementById('backgroundColor').value = warna_status;

            // Set value pada hidden input ID
            document.getElementById('id_dg_client_project_status').value = id;

            document.getElementById('urutan_status').value = urutan_status;

            document.getElementById('is_finish').value = is_finish;

            // Tambahkan log untuk memastikan data sudah di-set
            console.log("Edit Status to Project:", {
                id: id,
                nama_status: nama_status,
                warna_status: warna_status,
                urutan_status: urutan_status,
                is_finish: is_finish
            });
        }

        function editTypeToProject(id, nama_status, detail_project_tamplate) {
            // Set value pada input Nama Status
            document.getElementById('typeName').value = nama_status;

            var notes_project = decodeURIComponent(detail_project_tamplate);
            
            // Set value pada input Background Color
            $('#summernote').summernote('code', notes_project);

            // Set value pada hidden input ID
            document.getElementById('id_dg_client_project_type').value = id;

            // Tambahkan log untuk memastikan data sudah di-set
            console.log("Edit Status to Project:", {
                id: id,
                nama_status: nama_status
            });
        }

        



            function loadModalProjectType(id, nama_project) {
                // Tampilkan modal
                $('#modal-edit-type').modal({
                    backdrop: 'static',
                    keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
                });

                

                // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
                function refreshModalType() {
                    // Kirim permintaan AJAX untuk mengambil data dari database
                    $.ajax({
                        url: 'controller/get_modal_project_type.php',
                        type: 'GET',
                        data: { id: id, nama_project: nama_project},
                        success: function(response) {
                            // Perbarui isi modal dengan data yang diambil dari database
                            $('#modal-edit-type .modal-content-table-type').html(response);
                            document.getElementById("type_id_dg_client_project_jenis").value = id;
                        },
                        error: function(xhr, type, error) {
                            console.error('Error:', error);
                        }
                    });
                }

                // Panggil refreshModalType pertama kali saat modal ditampilkan
                refreshModalType();

                // Panggil refreshModalType setiap 10 detik setelah modal ditampilkan
                var intervalIdType = setInterval(refreshModalType, 10000);

                // Hentikan pembaruan saat modal disembunyikan
                $('#modal-edit-type').on('hidden.bs.modal', function () {
                    clearInterval(intervalIdType);
                });
            }



            function loadModalProjectStatus(id, nama_project) {
                // Tampilkan modal
                $('#modal-edit-status').modal({
                    backdrop: 'static',
                    keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
                });

                

                // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
                function refreshModalStatus() {
                    // Kirim permintaan AJAX untuk mengambil data dari database
                    $.ajax({
                        url: 'controller/get_modal_project_status.php',
                        type: 'GET',
                        data: { id: id, nama_project: nama_project},
                        success: function(response) {
                            // Perbarui isi modal dengan data yang diambil dari database
                            $('#modal-edit-status .modal-content-table-status').html(response);
                            document.getElementById("status_id_dg_client_project_jenis").value = id;
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }

                // Panggil refreshModalStatus pertama kali saat modal ditampilkan
                refreshModalStatus();

                // Panggil refreshModalStatus setiap 10 detik setelah modal ditampilkan
                var intervalId = setInterval(refreshModalStatus, 1000000);

                // Hentikan pembaruan saat modal disembunyikan
                $('#modal-edit-status').on('hidden.bs.modal', function () {
                    clearInterval(intervalId);
                });
            }

            $('#modal-cancel-status').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recipient_c = button.data('c');
                var recipient_v = button.data('v');

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.del_id_dg_client_project_status').val(recipient_c);
                document.getElementById("del_id_dg_client_project_status").value = recipient_c;


                document.getElementById("status_name_del").innerHTML = recipient_v;
            })

            $('#modal-cancel-type').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recipient_c = button.data('c');
                var recipient_v = button.data('v');

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.del_id_dg_client_project_type').val(recipient_c);
                document.getElementById("del_id_dg_client_project_type").value = recipient_c;


                document.getElementById("type_name_del").innerHTML = recipient_v;
            })

            function deleteStatusToProject() {
                // Ambil nilai dari input text dengan id "backgroundColor" dan "statusName"
                var id_user = <?php echo $id_user; ?>;
                var del_id_dg_client_project_status = $('#del_id_dg_client_project_status').val();
                var status_id_dg_client_project_jenis = $('#status_id_dg_client_project_jenis').val();
                var nama_project_status = $('#nama_project_status').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_delete_client_project_status.php',
                    type: 'POST',
                    data: {
                        id_user: id_user,
                        del_id_dg_client_project_status: del_id_dg_client_project_status
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadTableBody();
                        loadModalProjectStatus(status_id_dg_client_project_jenis, nama_project_status);
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.success('Data berhasil terhapus !');
                                $('#id_dg_client_project_status').val('');
                        } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                        }
                                $('#modal-cancel-status').modal('hide');

                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan saat mengirim permintaan AJAX
                        console.error('Error:', error);
                    }
                });
            }

            function deleteTypeToProject() {
                // Ambil nilai dari input text dengan id "backgroundColor" dan "statusName"
                var id_user = <?php echo $id_user; ?>;
                var del_id_dg_client_project_type = $('#del_id_dg_client_project_type').val();
                var type_id_dg_client_project_jenis = $('#type_id_dg_client_project_jenis').val();
                var nama_project_type = $('#nama_project_type').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_delete_client_project_type.php',
                    type: 'POST',
                    data: {
                        id_user: id_user,
                        del_id_dg_client_project_type: del_id_dg_client_project_type
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadTableBody();
                        loadModalProjectType(type_id_dg_client_project_jenis, nama_project_type);
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.success('Data berhasil terhapus !');
                                $('#id_dg_client_project_type').val('');
                        } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                        }
                                $('#modal-cancel-type').modal('hide');

                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan saat mengirim permintaan AJAX
                        console.error('Error:', error);
                    }
                });
            }

            function clearStatusToProject() {
                // Kosongkan nilai input
                $('#statusName').val('');
                $('#backgroundColor').val('');
                $('#id_dg_client_project_status').val('');
                $('#urutan_status').val('');
                $('#is_finish').val('');
            }
            
            function clearTypeToProject() {
                // Kosongkan nilai input
                $('#typeName').val('');
                $('#summernote').summernote('code', '');
                $('#id_dg_client_project_type').val('');
            }

            function addStatusToProject() {
                // Ambil nilai dari input text dengan id "backgroundColor" dan "statusName"
                var backgroundColor = $('#backgroundColor').val();
                var statusName = $('#statusName').val();
                var id_dg_client_project_status = $('#id_dg_client_project_status').val();
                var id_dg_client_project_jenis = $('#status_id_dg_client_project_jenis').val();
                var is_finish = $('#is_finish').val();
                var id_user = <?php echo $id_user; ?>;
                var nama_project_status = $('#nama_project_status').val();
                var urutan_status = $('#urutan_status').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_add_client_project_status.php',
                    type: 'POST',
                    data: {
                        backgroundColor: backgroundColor,
                        statusName: statusName,
                        id_dg_client_project_status: id_dg_client_project_status,
                        id_dg_client_project_jenis: id_dg_client_project_jenis,
                        urutan_status: urutan_status,
                        is_finish: is_finish,
                        id_user: id_user
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadModalProjectStatus(id_dg_client_project_jenis, nama_project_status);
                        loadTableBody();
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.success('Data berhasil disimpan.');
                                } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                            }
                                // Kosongkan nilai input
                                $('#statusName').val('');
                                $('#backgroundColor').val('');
                                $('#id_dg_client_project_status').val('');
                                $('#urutan_status').val('');
                                $('#is_finish').val('');

                    },
                    error: function(xhr, status, error, response) {
                        // Tangani kesalahan saat mengirim permintaan AJAX
                        console.error('Error:', error);
                        console.error('Error:', response);
                        console.log("backgroundColor = " + backgroundColor);
                        console.log("statusName = " + statusName);
                        console.log("id_dg_client_project_status = " + id_dg_client_project_status);
                        console.log("id_dg_client_project_jenis = " + id_dg_client_project_jenis);
                        console.log("id_user = " + id_user);
                    }
                });
            }

            function addtypeToProject() {
                // Ambil nilai dari input text dengan id "backgroundColor" dan "typeName"
                var detail_project_tamplate = encodeURIComponent($('#summernote').val());
                var typeName = $('#typeName').val();
                var id_dg_client_project_type = $('#id_dg_client_project_type').val();
                var id_dg_client_project_jenis = $('#type_id_dg_client_project_jenis').val();
                var id_user = <?php echo $id_user; ?>;
                var nama_project_type = $('#nama_project_type').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_add_client_project_type.php',
                    type: 'POST',
                    data: {
                        detail_project_tamplate: detail_project_tamplate,
                        typeName: typeName,
                        id_dg_client_project_type: id_dg_client_project_type,
                        id_dg_client_project_jenis: id_dg_client_project_jenis,
                        id_user: id_user
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadTableBody();
                        loadModalProjectType(id_dg_client_project_jenis, nama_project_type);
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.success('Data berhasil disimpan.');
                                } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                            }
                                // Kosongkan nilai input
                                $('#typeName').val(''); // Kosongkan input text
                                $('#summernote').summernote('code', ''); // Kosongkan Summernote editor
                                $('#id_dg_client_project_type').val('');

                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan saat mengirim permintaan AJAX
                        console.error('Error:', error);
                    }
                });
            }

            // Event listener untuk menambahkan tombol "Close" ke modal Summernote saat modal ditampilkan
            $(document).on('shown.bs.modal', '.note-modal', function() {
                var modal = $(this);
                
                // Periksa apakah tombol "Close" sudah ada untuk menghindari penambahan ganda
                if (modal.find('.custom-close').length === 0) {
                    // Tambahkan tombol "Close" di footer modal
                    modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary custom-close">Close</button>');
                    
                    // Event handler untuk tombol "Close"
                    modal.find('.custom-close').on('click', function() {
                        modal.modal('hide'); // Menutup modal Summernote
                    });
                }
            });
    </script>
</body>

</html>