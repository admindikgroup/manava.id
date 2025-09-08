<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Article</title>

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

        input[type="text"i] {
            width: 100%;
        }

        .dtr-data{
            white-space: normal;
            padding-left: 50px;
            padding-right: 50px;
            display: block;
            width: 100%;
            height: 300px;
            overflow-y: scroll;
        }
        .dtr-details{
            width: 100%;
        }
        .table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td.dtr-control:before{
            left: 43%;
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
                    <p>Are you sure you want to delete this article?<br>
                        Article Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_article.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task3" id="id_task3" value="">

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
                            <h1 class="m-0">Article's Management
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
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                                            style="margin-top: 10px; margin-left: 20px;">
                                        </div>
                                    </div>
                                    <div class="col-6 form-group">
                                        <a class="btn btn-success float-sm-right" href="article_add.php"
                                            style="right: 0px; width: 150px; margin-top: 10px; margin-right: 20px;">
                                            + Add Data
                                        </a>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px; word-wrap:break-word; verflow-wrap: break-word; table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">Detail</th>
                                                <th style="width: 15%;">Banner</th>
                                                <th style="width: 25%;">Article Title</th>
                                                <th style="width: 15%;">Author Name</th>
                                                <th style="width: 10%;">Category</th>
                                                <th style="width: 15%;">Tags</th>
                                                <th style="width: 15%;">Date Created</th>
                                                <th style="width: 5%;" class="none">Article Content</th>
                                                <th style="width: 15%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $result_head = mysqli_query($db2,"select *, da.created_at as tanggal_buat from dg_article da
                                            inner join dg_user du on da.id_author = du.id_dg_user
                                            where da.deleted_at is null
                                            order by da.id_dg_article DESC");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                                $id_dg_article = $d_head['id_dg_article'];
                                                $id_author = $d_head['id_author'];  
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"><img class="shadow" style="width: 100px; border: 1px solid black;"
                                                        src="img/article/<?php if($d_head['banner_utama']!=""){echo $d_head['banner_utama'];}else{echo "b1.jpg";} ?>"
                                                        alt="<?php echo $d_head['judul_article']; ?> logo" /></td></td>


                                                <td>
                                                    <a target="_blank" href="../blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>">
                                                        <?php echo $d_head['judul_article']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $d_head['nama']; ?></td>
                                                <td><?php 
                                                        $result_category = mysqli_query($db2,"select * from dg_article_category_m dacm inner join dg_article_category dac
                                                        on dacm.id_dg_article_category = dac.id_dg_article_category where dacm.id_dg_article = $id_dg_article");
                                                        while($d_category = mysqli_fetch_array($result_category)){
                                                            echo $d_category['nama_category']."</br>"; 
                                                        }

                                                ?></td>
                                                <td><?php 
                                                        $result_tags = mysqli_query($db2,"select * from dg_article_tags_m dacm inner join dg_article_tags dac
                                                        on dacm.id_dg_article_tags = dac.id_dg_article_tags where dacm.id_dg_article = $id_dg_article");
                                                        while($d_tags = mysqli_fetch_array($result_tags)){
                                                            echo $d_tags['nama_tags']."</br>"; 
                                                        }

                                                ?></td>
                                                <td><?php  echo date_format(date_create($d_head['tanggal_buat']),"d F Y H:i:s"); ?></td>
                                                <td style="width: 100%;"><?php echo $d_head['isi_article_pembuka']; ?></td>

                                                <td style="text-align: left;">
                                                    <?php 
                                                    if($_SESSION['priv']==1 || $id_user==$id_author){
                                                    ?>
                                                    <a class="btn btn-info btn-sm" name="id_ev" href="article_edit.php?id=<?php echo $d_head['id_dg_article']; ?>">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-c="<?php echo $d_head['id_dg_article']; ?>"
                                                        data-v="<?php echo $d_head['judul_article']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button>
                                                    <?php } ?>

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
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                pagingType: 'full_numbers',
                "sorting": true,
                order: [[8, 'desc']],
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
            modal.find('.id_task3').val(recipient_c);
            document.getElementById("id_task3").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })

      
        $("#accountHead").removeClass("none");
        $("#selectid").on("change", function () {
            $("#accountHead").addClass("none");
            if (this.value == "0") {
                $("#accountHead").removeClass("none");
            }
        });

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });
    </script>
</body>

</html>