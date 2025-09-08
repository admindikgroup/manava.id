<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

$id_client = $_GET['id_client'];
$result_client = mysqli_query($db2,"select * from dg_client where id_dg_client = $id_client");
while($d_client = mysqli_fetch_array($result_client)){
    $nama_client = $d_client['nama_client'];
    $logo_client = $d_client['logo_client'];
}

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Client's Links | DIK Group</title>

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
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">



    

    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Link ini ?<br>
                        Link Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_link.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
                    <input type="hidden" name="id_dg_client_links3" id="id_dg_client_links3" value="">

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


    <div class="modal fade" id="modal-edit-header">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Data Link</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_link.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-group row">
                            <label for="linkName" class="col-sm-12 col-form-label">Link Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="linkName" name="linkName"
                                    placeholder="Ketikan Nama Link" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dg_link" class="col-sm-12 col-form-label">Link</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="dg_link"
                                    name="dg_link" placeholder="Masukan link">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bobot" class="col-sm-12 col-form-label">Bobot</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="bobot" name="bobot"
                                    placeholder="Ketikan bobot" value="">
                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
                        <input type="hidden" name="id_dg_client_links" id="id_dg_client_links" value="">


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

    <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add Data Link</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_link.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-group row">
                            <label for="linkName2" class="col-sm-12 col-form-label">Link Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="linkName2" name="linkName2"
                                    placeholder="Ketikan Nama Link" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dg_link2" class="col-sm-12 col-form-label">Link</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="dg_link2"
                                    name="dg_link2" placeholder="Masukan link">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bobot2" class="col-sm-12 col-form-label">Bobot</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="bobot2" name="bobot2"
                                    placeholder="Ketikan bobot" value="1">
                            </div>
                        </div>

                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client2" value="<?php echo $id_client; ?>">



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
                        <h1 class="m-0">
                                <img class="shadow" style="width: 100px; padding: 10px; margin-right: 10px;"
                                     src="img/client_logo/<?php if($logo_client!=""){echo $logo_client;}else{echo "logo.png";} ?>"
                                     alt="<?php echo $logo_client; ?> logo" /><?php echo $nama_client; ?> Project
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
                                <div class="row" style="height: 30px;">
                                    <div class="col-6 form-group">
                                        <div class="custom-control"
                                            style="margin-top: 10px;">
                                            <a class="btn btn-danger float-sm-left" style="width: 150px;" href="client.php">
                                                Back
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-6 form-group">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 150px; margin-top: 10px; margin-right: 20px;">
                                            + Add Data
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name Link</th>
                                                <th>Link</th>
                                                <th>Bobot</th>
                                                <th>View</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 0;
                                            
                                            $result_head = mysqli_query($db2,"select * from `dg_client_links`
                                            inner join dg_client on dg_client_links.id_dg_client = dg_client.id_dg_client
                                            where dg_client_links.deleted_at is null and dg_client_links.id_dg_client= $id_client
                                            order by bobot_link desc");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                                $no++;
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $d_head['name_link']; ?></td>
                                                <td><?php echo $d_head['dg_link']; ?></td>
                                                <td><?php echo $d_head['bobot_link']; ?></td>
                                                <td><?php echo $d_head['view']; ?></td>
                                                <td style="text-align: center;">
                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                        style="margin-right: 15px;"
                                                        data-a="<?php echo $d_head['id_dg_client_links']; ?>"
                                                        data-b="<?php echo $d_head['name_link']; ?>"
                                                        data-c="<?php echo $d_head['dg_link']; ?>"
                                                        data-d="<?php echo $d_head['bobot_link']; ?>"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-header" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-c="<?php echo $d_head['id_dg_client_links']; ?>"
                                                        data-v="<?php echo $d_head['name_link']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        
                                                    </button>
                                                </td>
                                            </tr>

                                            <?php } ?>


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
        
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                "sorting": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });



        $('#modal-cancel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_links3').val(recipient_c);
            document.getElementById("id_dg_client_links3").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })





        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');


            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_links').val(recipient_a);
            document.getElementById("id_dg_client_links").value = recipient_a;

            modal.find('.linkName').val(recipient_b);
            document.getElementById("linkName").value = recipient_b;

            modal.find('.dg_link').val(recipient_c);
            document.getElementById("dg_link").value = recipient_c;

            modal.find('.bobot').val(recipient_d);
            document.getElementById("bobot").value = recipient_d;


        })


        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })
        
        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });

    </script>
</body>

</html>