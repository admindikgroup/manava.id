<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Division | DIK Group</title>

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
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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

    <div class="modal fade" id="modal-edit-group">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Edit Data Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_group_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                        <div class="row">
                                
                                <div class="col-12" style="padding-left: 20px;">


                                    <div class="form-group row">
                                        <label for="select_division_edit" class="col-sm-12 col-form-label">Division</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2" name="select_division_edit" id="select_division_edit" style="width: 100%;">
                                                <option value="0">-- Select Division --</option>
                                                <?php
                                                    $result_user = mysqli_query($db2, "SELECT * FROM dg_division where deleted_at is null");
                                                            while ($row = mysqli_fetch_assoc($result_user)) {
                                                            echo '<option value="'.$row['id_dg_division'].'">'.$row['division_name'].'</option>';
                                                            }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="namaGroup_edit" class="col-sm-12 col-form-label">Nama Group</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaGroup_edit" name="namaGroup_edit"
                                                placeholder="Ketikan Nama Group" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="deskripsiGroup_edit" class="col-sm-12 col-form-label">Deskripsi Group</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="deskripsiGroup_edit" name="deskripsiGroup_edit"
                                                placeholder="Ketikan Deskripsi Group" value="" required>
                                        </div>
                                    </div>  

                                </div>

                        </div>
                        <input type="hidden" name="division" value="1">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_dg_user_group_edit" id="id_dg_user_group_edit" value="">


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

   <!-- /.modal -->
   <div class="modal fade" id="modal-edit-team">
        <input type="hidden" name="edit_id_project" value="">
        <input type="hidden" name="edit_nama_project" value="">

        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-team">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">
                            <label for="teamUser" class="col-sm-2 col-form-label">Nama Team</label>
                                <div class="col-sm-3">
                                    <select class="form-control select2 teamUser" style="width: 100%;" name="teamUser" id="teamUser" required>
                                        <option value="" selected disabled>- Pilih Team -</option>   
                                        <?php 
                                        $result_dgu = mysqli_query($db2,"SELECT dj.*
                                        FROM dg_user dj
                                        WHERE dj.deleted_by is null");
                                        while($d_dgu = mysqli_fetch_array($result_dgu)){
                                        ?>
                                        <option  value="<?php echo $d_dgu['id_dg_user']; ?>"><?php echo $d_dgu['nama']; ?></option>    
                                        <?php } ?>
                                    </select>
                                </div>
                        


                            <div class="col-sm-1">
                                <div class="row">
                                    
                                    <button onclick="addteamToProject()" class="btn btn-success" title="Add team">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-cancel-group">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Group ini ?<br>
                        Nama Group User &nbsp; : <b id="user_group_del"></b><br>
                </div>
                <form action="controller/conn_delete_group_user.php" method="post">
                    <input type="hidden" name="division" value="1">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_user_group_delete" id="id_user_group_delete" value="">

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
    
    <div class="modal fade" id="modal-cancel-group-detail">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus User dari Group ini ?<br>
                        Nama User &nbsp; : <b id="user_group_detail_del"></b><br>
                </div>
                <form method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="division" value="1">
                    <input type="hidden" name="id_user_group_detail_delete" id="id_user_group_detail_delete" value="">

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
                    <p>Apakah anda yakin menghapus Division ini ?<br>
                        Division Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_division.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_division_notes_divisions3" id="id_division_notes_divisions3" value="">

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
                    <h4 class="modal-title" id="exampleModalLabel">Edit Data Division</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_division.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-group row">
                            <label for="divisionName" class="col-sm-12 col-form-label">Division Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="divisionName" name="divisionName"
                                    placeholder="Ketikan nama division" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="division_notes" class="col-sm-12 col-form-label">Division Notes</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="division_notes"
                                    name="division_notes" placeholder="Masukan notes division">
                            </div>
                        </div>
          

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_dg_division" id="id_dg_division" value="">


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
                    <h4 class="modal-title" id="exampleModalLabel">Add Data Division</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_division.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <div class="form-group row">
                            <label for="divisionName2" class="col-sm-12 col-form-label">Division Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="divisionName2" name="divisionName2"
                                    placeholder="Ketikan nama division" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="division_notes2" class="col-sm-12 col-form-label">Division Notes</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="division_notes2"
                                    name="division_notes2" placeholder="Masukan notes division">
                            </div>
                        </div>
                 

                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">


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

    <div class="modal fade" id="modal-add-group">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_group_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="row">
                                
                                <div class="col-12" style="padding-left: 20px;">

                                    <div class="form-group row">
                                        <label for="select_division_add" class="col-sm-12 col-form-label">Division</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2" name="select_division_add" style="width: 100%;">
                                                <option value="0">-- Select Division --</option>
                                                <?php
                                                    $result_user = mysqli_query($db2, "SELECT * FROM dg_division where deleted_at is null");
                                                            while ($row = mysqli_fetch_assoc($result_user)) {
                                                            echo '<option value="'.$row['id_dg_division'].'">'.$row['division_name'].'</option>';
                                                            }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="namaGroup_add" class="col-sm-12 col-form-label">Nama Group</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaGroup_add" name="namaGroup_add"
                                                placeholder="Ketikan Nama Group" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="deslripsiGroup_add" class="col-sm-12 col-form-label">Deskripsi Group</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="deslripsiGroup_add" name="deslripsiGroup_add"
                                                placeholder="Ketikan Deskripsi Group" value="" required>
                                        </div>
                                    </div>  

                                </div>

                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="division" value="1">


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
                            <h1 class="m-0">Management Divisions
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
                                        <!-- <div class="custom-control"
                                            style="margin-top: 10px;">
                                            <a class="btn btn-danger float-sm-left" style="width: 150px;" href="division.php">
                                                Back
                                            </a>
                                        </div> -->
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
                                                <th style="width: 5%;">No</th>
                                                <th style="width: 15%;">Division Name</th>
                                                <th style="width: 25%;">
                                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                                        <span>Group List</span>
                                                        <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative; font-size: 12px;"
                                                            data-target="#modal-add-group" data-toggle="modal"
                                                            class="btn btn-raised btn-success"><i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </th>
                                                <th>Description</th>
                                                <th style="width: 15%; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 0;
                                            $result_head = mysqli_query($db2, 
                                                "SELECT dd.id_dg_division, dd.division_name, dd.division_notes, 
                                                        GROUP_CONCAT(dug.id_dg_user_group SEPARATOR '||') AS group_ids,
                                                        GROUP_CONCAT(dug.nama_group SEPARATOR '||') AS group_list,
                                                        GROUP_CONCAT(dug.deskripsi_group SEPARATOR '||') AS group_desc
                                                FROM `dg_division` dd
                                                LEFT JOIN `dg_user_group` dug ON dd.id_dg_division = dug.id_dg_division
                                                WHERE dd.deleted_by IS NULL
                                                GROUP BY dd.id_dg_division"
                                            );

                                            while ($d_head = mysqli_fetch_array($result_head)) {
                                                $no++;
                                                $group_ids = $d_head['group_ids'] ? explode('||', $d_head['group_ids']) : [];
                                                $group_list = $d_head['group_list'] ? explode('||', $d_head['group_list']) : [];
                                                $group_descriptions = $d_head['group_desc'] ? explode('||', $d_head['group_desc']) : [];
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $d_head['division_name']; ?></td>
                                                <td>
                                                    <?php if (!empty($group_list)) { ?>
                                                        <ul style="padding-left: 20px; margin: 0;">
                                                            <?php foreach ($group_list as $index => $group) { ?>
                                                                <li>
                                                                    <?php echo htmlspecialchars($group); ?>
                                                                    <div class="dropdown" style="display: inline-block; margin-left: 10px;">
                                                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $index; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $index; ?>">
                                                                            <a class="dropdown-item"
                                                                                href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#modal-edit-group"
                                                                                data-c="<?php echo htmlspecialchars($group_ids[$index]); ?>"              
                                                                                data-d="<?php echo htmlspecialchars($d_head['id_dg_division']); ?>"                     
                                                                                data-e="<?php echo htmlspecialchars($group); ?>"                         
                                                                                data-v="<?php echo htmlspecialchars($group_descriptions[$index]); ?>"     
                                                                                >
                                                                                Edit Detail Group
                                                                            </a>
                                                                            <a class="dropdown-item" href="#"
                                                                                onclick="loadModalProjectTeam(<?php echo htmlspecialchars($group_ids[$index]); ?>, '<?php echo htmlspecialchars($group); ?>')">
                                                                                Edit Group Member
                                                                            </a>
                                                                            <hr>
                                                                            <a class="dropdown-item"
                                                                                href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#modal-cancel-group"
                                                                                data-c="<?php echo htmlspecialchars($group_ids[$index]); ?>"                         
                                                                                data-v="<?php echo htmlspecialchars($group); ?>"     
                                                                                >
                                                                                Delete Group
                                                                            </a>
                                                                            <!-- Tambahkan menu lain di sini kalau dibutuhkan -->
                                                                        </div>
                                                                    </div>

                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } else { ?>
                                                        <i>No Group</i>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $d_head['division_notes']; ?></td>
                                                <td style="text-align: center;">
                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                        style="margin-right: 15px;"
                                                        data-a="<?php echo $d_head['id_dg_division']; ?>"
                                                        data-b="<?php echo $d_head['division_name']; ?>"
                                                        data-c="<?php echo $d_head['division_notes']; ?>"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-header" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-c="<?php echo $d_head['id_dg_division']; ?>"
                                                        data-v="<?php echo $d_head['division_name']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel">
                                                        <i class="fas fa-trash"></i>
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
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>

    <!-- Page specific script -->
    <script>
        
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "sorting": false
            });

        });

   
            // Saat modal ditampilkan, ambil data dari tombol yang men-trigger modal
            $('#modal-cancel-group-detail').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang diklik
                var userId = button.data('userid'); // Ambil ID user dari atribut data
                var userName = button.data('username'); // Ambil Nama user dari atribut data

                // Set nilai pada modal
                $('#user_group_detail_del').text(userName);
            });

            // Proses submit dengan AJAX
            $('#modal-cancel-group-detail form').submit(function(event) {
                event.preventDefault(); // Mencegah reload halaman

                var id_user_group_detail_delete = $('#id_user_group_detail_delete').val(); // Ambil ID dari modal

                $.ajax({
                    url: 'controller/conn_delete_group_user_detail.php',
                    type: 'POST',
                    data: { id_user_group_detail_delete: id_user_group_detail_delete }, // Kirim sebagai object
                    success: function(response) {
                        // Tutup modal setelah berhasil
                        $('#modal-cancel-group-detail').modal('hide');
                        toastr.success('Data berhasil dihapus.');
                        // Panggil function untuk reload data
                        refreshModalTeam();
                        
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus user.');
                    }
                });
            });
 

        
        $('#modal-cancel-group-detail').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_user_group_detail_delete').val(recipient_c);
            document.getElementById("id_user_group_detail_delete").value = recipient_c;


            document.getElementById("user_group_detail_del").innerHTML = recipient_v;
            console.log(recipient_c);
        })


        function addteamToProject() {
            var teamUser = $('#teamUser').val();
            var id_dg_user_group_to_team = $('#id_dg_user_group_to_team').val();

            // Kirim data form ke server menggunakan AJAX
            $.ajax({
                url: 'controller/conn_add_group_user_member.php',
                type: 'POST',
                data: {
                    teamUser: teamUser,
                    id_dg_user_group_to_team: id_dg_user_group_to_team
                },
                dataType: 'html',
                success: function(response) {
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (response == 'Berhasil') {
                        toastr.success('Data berhasil disimpan.');
                    }else if (response == 'Data sudah ada') {
                        toastr.warning('Data sudah ada.');
                    } else {
                        toastr.error('Data gagal disimpan !<br>'+response);
                    }
                    // Kosongkan nilai input
                    $('#teamUser').val('').trigger('change');

                    refreshModalTeam();

                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan saat mengirim permintaan AJAX
                    console.error('Error:', error);
                }
            });
        }


        function loadGroups() {
                $.ajax({
                    url: 'controller/get_groups.php', // File PHP untuk mengambil data
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        let tableBody = '';
                        data.forEach(function (group, index) {
                            let members = group.members.length > 0 ? group.members.join('<br>') : 'No members';

                            tableBody += `
                                <tr>
                                    <td>${group.division_name}</td>
                                    <td>${group.nama_group}</td>
                                    <td>${group.deskripsi_group}</td>
                                    <td>${members}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary btn-sm" style="margin-right: 15px;"
                                            data-c="${group.id_dg_user_group}"
                                            data-d="${group.dug_id_dg_division}"
                                            data-e="${group.nama_group}"
                                            data-v="${group.deskripsi_group}"
                                            data-toggle="modal" data-target="#modal-edit-group"
                                            data-keyboard="false" title="Edit Detail Group">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>

                                        <button class="btn btn-warning btn-sm" style="margin-right: 15px;"
                                            data-toggle="modal" title="Edit Anggota Team"
                                            onclick="loadModalProjectTeam(${group.id_dg_user_group}, '${group.nama_group}')"
                                            data-keyboard="false">
                                            <i class="fas fa-users"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm"
                                            data-keyboard="false" title="Delete User"
                                            data-c="${group.id_dg_user_group}"
                                            data-v="${group.nama_group}"
                                            data-toggle="modal" data-target="#modal-cancel-group">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });

                        $('#groupTableBody').html(tableBody);
                    },
                    error: function () {
                        alert("Failed to load groups.");
                    }
                });
            }

        function refreshModalTeam() {
            const id = $('input[name="edit_id_project"]').val();
            const nama_project = $('input[name="edit_nama_project"]').val();

            $.ajax({
                url: 'controller/get_modal_user_member.php',
                type: 'GET',
                data: { id: id, nama_project: nama_project },
                success: function(response) {
                    $('#modal-edit-team .modal-content-table-team').html(response);
                    loadGroups();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function loadModalProjectTeam(id, nama_project) {
            // Set nilai ke hidden input
            $('input[name="edit_id_project"]').val(id);
            $('input[name="edit_nama_project"]').val(nama_project);

            // Tampilkan modal
            $('#modal-edit-team').modal({
                backdrop: 'static',
                keyboard: false
            });

            // Jalankan pertama kali saat modal tampil
            refreshModalTeam();

            // Jalankan interval refresh
            var intervalId = setInterval(refreshModalTeam, 30000);

            // Hentikan interval saat modal ditutup
            $('#modal-edit-team').on('hidden.bs.modal', function () {
                clearInterval(intervalId);
            });
        }




        $('#modal-cancel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_division_notes_divisions3').val(recipient_c);
            document.getElementById("id_division_notes_divisions3").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })


        $('#modal-edit-group').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal

            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            var recipient_e = button.data('e');
            var recipient_v = button.data('v');
       

            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_user_group_edit').val(recipient_c);
            document.getElementById("id_dg_user_group_edit").value = recipient_c;

            modal.find('.select_division_edit').val(recipient_d);
            document.getElementById("select_division_edit").value = recipient_d;
            $('#select_division_edit').val(recipient_d).trigger('change.select2');


            modal.find('.namaGroup_edit').val(recipient_e);
            document.getElementById("namaGroup_edit").value = recipient_e;

            modal.find('.deskripsiGroup_edit').val(recipient_v);
            document.getElementById("deskripsiGroup_edit").value = recipient_v;

        })



        $('#modal-cancel-group').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_user_group_delete').val(recipient_c);
            document.getElementById("id_user_group_delete").value = recipient_c;


            document.getElementById("user_group_del").innerHTML = recipient_v;
        })

        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');


            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_division').val(recipient_a);
            document.getElementById("id_dg_division").value = recipient_a;

            modal.find('.divisionName').val(recipient_b);
            document.getElementById("divisionName").value = recipient_b;

            modal.find('.division_notes').val(recipient_c);
            document.getElementById("division_notes").value = recipient_c;



        })


        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik

            $('#modal-edit-team').on('hidden.bs.modal', function (e) {
                // Kosongkan nilai input
                $('#teamUser').val('').trigger('change');
            });
        });
    
    </script>
</body>

</html>