<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Client's | DIK Group</title>

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



    <div class="modal fade" id="modal-update">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="textGlobal">Apakah anda yakin MENAIKAN semua BPTL Celup - Putih + Obat harga ini ?</p><br>
                    <p id="kenaikanText"></p><br>
                </div>
                <form action="controller/conn_update_bptl_celup_allharga.php" method="post">

                    <input class="aktif4" type="hidden" name="aktif4" value="<?php echo $aktif;?>">
                    <input class="kenaikan" type="hidden" name="kenaikan" value="<?php echo $aktif;?>">
                    <input class="penurunan" type="hidden" name="penurunan" value="<?php echo $aktif;?>">
                    <input type="hidden" name="username" value="<?php echo $username;?>">

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
                    <p>Apakah anda yakin menghapus Client ini ?<br>
                        Nama Client &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_client.php" method="post">
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


    <div class="modal fade" id="modal-edit-header">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Data Client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_client.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-group">
                            <label for="logo_client">Logo</label>
                            <input class="form-control" type="file" id="logo_client" name="logo_client">
                            <label for="logo_client"><img id="blah"
                                    style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                    src="img/client_logo/logo.png" alt="your image" /></label>
                        </div>
                        <div class="form-group row">
                            <label for="namaClient" class="col-sm-12 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="namaClient" name="namaClient"
                                    placeholder="Ketikan Nama Perusahaan" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamatClient" class="col-sm-12 col-form-label">Alamat Perusahaan</label>
                            <div class="col-sm-12">
                                <textarea rows="5" type="text" class="form-control" id="alamatClient"
                                    name="alamatClient" placeholder="Masukan alamat client"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aboutClient" class="col-sm-12 col-form-label">About Client</label>
                            <div class="col-sm-12">
                                <textarea rows="5" type="text" class="form-control" id="aboutClient"
                                    name="aboutClient" placeholder="Masukan tentang perusahaan"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="emailPic" class="col-sm-12 col-form-label">Email Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="emailPic" name="emailPic"
                                    placeholder="Ketikan email perusahaan" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomorPic" class="col-sm-12 col-form-label">Nomor Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomorPic" name="nomorPic"
                                    placeholder="Ketikan nomor perusahaan" value="">
                            </div>
                        </div>

                        

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task" id="id_task" value="">
                        <input type="hidden" class="form-group" id="bannerLama" name="bannerLama">

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
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_client.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="logo_client2">Logo</label>
                            <input class="form-control" type="file" id="logo_client2" name="logo_client2">
                            <label for="logo_client2"><img id="blah2"
                                    style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                    src="img/client_logo/logo.png" alt="your image" /></label>
                        </div>
                        <div class="form-group row">
                            <label for="namaClient2" class="col-sm-12 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="namaClient2" name="namaClient2"
                                    placeholder="Ketikan Nama Perusahaan" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamatClient2" class="col-sm-12 col-form-label">Alamat Perusahaan</label>
                            <div class="col-sm-12">
                                <textarea rows="5" type="text" class="form-control" id="alamatClient2"
                                    name="alamatClient2" placeholder="Masukan alamat perusahaan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aboutClient2" class="col-sm-12 col-form-label">About Client</label>
                            <div class="col-sm-12">
                                <textarea rows="5" type="text" class="form-control" id="aboutClient2"
                                    name="aboutClient2" placeholder="Masukan tentang perusahaan"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="emailPic2" class="col-sm-12 col-form-label">Email Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="emailPic2" name="emailPic2"
                                    placeholder="Ketikan Email Perusahaan" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomorPic2" class="col-sm-12 col-form-label">Nomor Kontak Perusahaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomorPic2" name="nomorPic2"
                                    placeholder="Ketikan Nomor Perusahaan" value="">
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
                            <h1 class="m-0">Data Client's DG Group
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
                                            <!-- <input type="checkbox" class="custom-control-input" onChange="changeCheck()"
                                                id="customSwitch3" value="1" <?php if($aktif==1){echo "checked";}?>>
                                            <label class="custom-control-label"
                                                for="customSwitch3"><?php if($aktif==1){echo "Aktif";}else{echo "Tidak Aktif";}?></label> -->
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
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Detail</th>
                                                <th class="none">Logo</th>
                                                <th style="width: 15%;">Nama Client</th>
                                                <th style="width: 20%;">About Client</th>

                                                <th class="none">Email Perusahaan</th>
                                                <th class="none">Kontak Perusahaan</th>
                                                <th style="width: 20%;">Alamat Client</th>
                                                

                                                <th style="width: 5%;">Status</th>
                                                <th class="none">Tanggal Buat</th>
                                                <th style="width: 20%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            if ($aktif==1) {
                                                $temp_aktif = "Aktif =1";
                                            }else{
                                                $temp_aktif = "Aktif =0";
                                            }
                                            $result_head = mysqli_query($db2,"select * from dg_client where deleted_at is null order by id_dg_client desc");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td style="text-align: center;"><img class="shadow" style="width: 100px; border: 1px solid black;"
                                                        src="img/client_logo/<?php if($d_head['logo_client']!=""){echo $d_head['logo_client'];}else{echo "logo.png";} ?>"
                                                        alt="<?php echo $d_head['nama_client']; ?> logo" /></td></td>
                                                <!-- <td style="text-transform: uppercase;">CL-<?php $words = explode(" ", $d_head['nama_client']); $acronym = "";
                                                    foreach ($words as $w) {
                                                    $acronym .= $w[0];
                                                    }
                                                    echo $acronym; ?>-<?php echo $d_head['id_dg_client']; ?>
                                                </td> -->

                                                <td><?php echo $d_head['nama_client']; ?></td>
                                                <td><?php echo $d_head['about_client']; ?></td>
                                                <td><?php echo $d_head['email']; ?></td>
                                                <td><?php echo $d_head['no_client']; ?></td>
                                                <td><?php echo $d_head['alamat_client']; ?></td>
                                                <td  style="text-align: right;"><?php 
                                                        $id_header = $d_head['id_dg_client'];  
                                                        $result_acc1 = mysqli_query($db2,"select * from `dg_task` 
                                                        inner join dg_task_detail on dg_task.id_dg_task = dg_task_detail.id_dg_task
                                                        where dg_task.id_client = $id_header AND dg_task_detail.status_detail = 3 and dg_task_detail.deleted_at is null"); 
                                                        $result_acc2 = mysqli_query($db2,"select * from `dg_task` 
                                                        inner join dg_task_detail on dg_task.id_dg_task = dg_task_detail.id_dg_task
                                                        where dg_task.id_client = $id_header AND dg_task_detail.deleted_at is null"); 
                                                        $cek1 = mysqli_num_rows($result_acc1);
                                                        $cek2 = mysqli_num_rows($result_acc2);
                                                        if ($cek1==0) {
                                                            $hasil_cek = 0;
                                                        }else{
                                                            $hasil_cek = $cek1*100/$cek2;
                                                        }
                                                        echo number_format($hasil_cek, 2, ',', '.');
                                                
                                                ?>%</td>
                                                <td><?php echo $d_head['created_at']; ?></td>

                                                <td style="text-align: center;">
                                                    
                                                    
                                                    <a class="btn btn-primary btn-sm" style="margin-right: 15px;" title="Go To Project Management"
                                                    href="client_project.php?id_client=<?php echo $d_head['id_dg_client']; ?>">
                                                        <i class="fas fa-project-diagram">
                                                        </i>
                                                    </a>
                                                    <a class="btn btn-success btn-sm" style="margin-right: 15px;" title="Go To Linktree Client"
                                                    href="client_links.php?id_client=<?php echo $d_head['id_dg_client']; ?>">
                                                        <i class="fas fa-link">
                                                        </i>
                                                    </a>
                                                    <a class="btn btn-warning btn-sm" style="margin-right: 15px;" title="Go To User for Client"
                                                    href="client_user.php?id_client=<?php echo $d_head['id_dg_client']; ?>">
                                                        <i class="fas fa-users">
                                                        </i>
                                                    </a>

                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                    style="margin-right: 15px;" title="Edit this Client"
                                                        data-a="<?php echo $d_head['id_dg_client']; ?>"
                                                        data-b="<?php echo $d_head['nama_client']; ?>"
                                                        data-c="<?php echo $d_head['alamat_client']; ?>"
                                                        data-d="<?php echo $d_head['nama_pic']; ?>"
                                                        data-e="<?php echo $d_head['email']; ?>"
                                                        data-f="<?php echo $d_head['no_client']; ?>"
                                                        data-g="<?php echo $d_head['status']; ?>"
                                                        data-h="<?php echo $d_head['id_dg_user']; ?>"
                                                        data-i="<?php echo $d_head['logo_client']; ?>"
                                                        data-j="<?php echo $d_head['about_client']; ?>" data-toggle="modal"
                                                        data-target="#modal-edit-header" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </button>
                                                    
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        <?php 
                                                        $cek2=0;
                                                        $id_dg_client = $d_head['id_dg_client'];
                                                        $client_row = mysqli_query($db2,"SELECT * FROM dg_client_project
                                                        WHERE id_dg_client = $id_dg_client");
                                                        $cek2 = mysqli_num_rows($client_row);
                                                        if($cek2!=0){ echo "disabled";}
                                                        ?>
                                                        data-keyboard="false" title="Delete this Client"
                                                        data-c="<?php echo $d_head['id_dg_client']; ?>"
                                                        data-v="<?php echo $d_head['nama_client']; ?>"
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#logo_client").change(function () {
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

        $("#logo_client2").change(function () {
            readURL1(this);
        });

        function changeCheck() {
            var checkBox = document.getElementById("customSwitch3");
            if (checkBox.checked) {
                window.location.replace("client.php?aktif=1");
            } else {
                window.location.replace("client.php?aktif=0");
            }
        };

        function changeCheck() {
            var checkBox = document.getElementById("customSwitch3");
            if (checkBox.checked) {
                window.location.replace("client.php?aktif=1");
            } else {
                window.location.replace("client.php?aktif=0");
            }
        };

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





        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            var recipient_e = button.data('e');
            var recipient_f = button.data('f');
            var recipient_h = button.data('h');
            var recipient_i = button.data('i');
            var recipient_j = button.data('j');

            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task').val(recipient_a);
            document.getElementById("id_task").value = recipient_a;

            modal.find('.namaClient').val(recipient_b);
            document.getElementById("namaClient").value = recipient_b;

            modal.find('.alamatClient').val(recipient_c);
            document.getElementById("alamatClient").innerHTML = recipient_c;

            modal.find('.emailPic').val(recipient_e);
            document.getElementById("emailPic").value = recipient_e;

            modal.find('.nomorPic').val(recipient_f);
            document.getElementById("nomorPic").value = recipient_f;

            modal.find('.support').val(recipient_h);
            //document.getElementById("support").value = recipient_h;

            modal.find('.aboutClient').val(recipient_j);
            document.getElementById("aboutClient").innerHTML = recipient_j;

            
            modal.find('.bannerLama').val(recipient_i);
            document.getElementById("bannerLama").value = recipient_i;
            if (recipient_i=="") {
                document.getElementById("blah").src = "img/client_logo/logo.png"
            }else{
            document.getElementById("blah").src = "img/client_logo/"+recipient_i;
            }



        })


        $('#modal-add').on('show.bs.modal', function (event) {
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

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });
    </script>
</body>

</html>