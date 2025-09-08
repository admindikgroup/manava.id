<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management List's Project | DIK Group</title>

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
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
        /* CSS untuk menyembunyikan tombol X pada modal Summernote */
        .note-modal .close {
            display: none !important;
        }
        
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">



    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-team">
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
                        
                            <label for="teamJabatan" class="col-sm-1 col-form-label">Jabatan</label>
                                <div class="col-sm-5 select2-blue">
                                    <select class="form-control select2 teamJabatan" multiple="multiple" 
                                    data-dropdown-css-class="select2-blue" data-placeholder="Pilih Jabatan"
                                    style="width: 100%;" name="teamJabatan" id="teamJabatan" required>  
                                        <?php 
                                        $result_dujs = mysqli_query($db2,"SELECT dj.*
                                        FROM dg_job dj
                                        WHERE dj.deleted_by is null 
                                        Order by dj.id_dg_job desc");
                                        while($d_dujs = mysqli_fetch_array($result_dujs)){
                                        ?>
                                        <option value="<?php echo $d_dujs['id_dg_job']; ?>"><?php echo $d_dujs['job_name']; ?></option>    
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



    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-link">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-link">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">
                            <label for="linkName" class="col-sm-2 col-form-label">Link Name</label>
                        <div class="col-sm-3" style="padding-bottom: 10px;">
                            <input type="text" class="form-control" id="linkName" name="linkName"
                            placeholder="Ketikan nama link" value="" required>
                        </div>
                        
                        <label for="linkProject" class="col-sm-1 col-form-label">Link</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="linkProject" name="linkProject"
                                placeholder="Ketikan link project" value="" required>
                        </div>


                        <input type="hidden" name="id_dg_client_project_link" id="id_dg_client_project_link" value="">


                        <div class="col-12" style="margin-top: 10px;">
                            <button style="width:95%;" onclick="addLinkToProject()" class="btn btn-info" title="Save Edited Link"><i class="fas fa-save"></i> Save</button>
                            <button onclick="clearLinkToProject()" class="btn btn-warning" title="Clear Edited Link"><i class="fas fa-sync-alt"></i></button>
                        </div>
                        
                    </div>

                </div>
            </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-cancel-link">
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
                        Link Name &nbsp; : <b id="Jenis_warna3"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_link" id="id_dg_client_project_link" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_dg_client; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteLinkToProject()"  class="btn btn-danger">Yes</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-cancel-team">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Team ini ?<br>
                        Team Name &nbsp; : <b id="Jenis_warna4"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_team" id="id_dg_client_project_team" value="">
                    <input type="hidden" name="id_dg_user_delete" id="id_dg_user_delete" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_dg_client; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteTeamToProject()"  class="btn btn-danger">Yes</button>
                    </div>
                
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
                    <p>Apakah anda yakin menghapus Project ini ?<br>
                        Project Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_client_project.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project3" id="id_dg_client_project3" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_dg_client; ?>">
                    <input type="hidden" name="list_project" value="1">

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


   

    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-header">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit Data Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_client_project.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">


                    <div class="row">
                        <div class="col-6" style="padding-right: 20px;">
                            <div class="form-group row">
                                <label for="projectName" class="col-sm-12 col-form-label">Project Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="projectName" name="projectName"
                                        placeholder="Ketikan Nama project" value="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division" class="col-sm-12 col-form-label">Division</label>
                                <div class="col-sm-12">
                                    <select class="form-control select division" style="width: 100%;" name="division" id="division">
                                        <option selected disabled value="">-Pilih Divisi-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_division`
                                            where deleted_at is null");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_division']; ?>"><?php echo $d_division['division_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_client" class="col-sm-12 col-form-label">Client</label>
                                <div class="col-sm-12">
                                    <select class="form-control select id_client" style="width: 100%;" name="id_client" id="id_client">
                                        <option selected disabled value="">-Pilih Client-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_client`
                                            where deleted_at is null");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_client']; ?>"><?php echo $d_division['nama_client']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marketing" class="col-sm-12 col-form-label">Marketing</label>
                                <div class="col-sm-12">
                                    <select class="form-control select marketing" style="width: 100%;" name="marketing" id="marketing">
                                        <option selected disabled value="">-Pilih Marketing-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_user`
                                            where deleted_at is null order by nama asc");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_user']; ?>"><?php echo $d_division['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenisProject" class="col-sm-12 col-form-label">Jenis Project</label>
                                <div class="col-sm-12">
                                    <select class="form-control select jenisProject" style="width: 100%;" name="jenisProject" id="jenisProject">
                                        <option selected disabled value="">-Pilih Jenis Project-</option>    
                                        <?php 
                                            $result_cp = mysqli_query($db2,"select * from `dg_client_project_jenis`
                                            where deleted_at is null");
                                            while($d_cp = mysqli_fetch_array($result_cp)){
                                        ?>
                                        <option value="<?php echo $d_cp['id_dg_client_project_jenis']; ?>"><?php echo $d_cp['nama_jenis_project']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reservationdate3" class="col-sm-12 col-form-label">Start Project</label>
                                <div class="input-group date col-sm-12" id="reservationdate3" data-target-input="nearest"
                                    required>
                                    <input type="text" name="start_project" class="form-control datetimepicker-input start_project"
                                        data-target="#reservationdate3" value="" required>
                                    <div class="input-group-append" data-target="#reservationdate3"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reservationdate4" class="col-sm-12 col-form-label">Finish Project</label>
                                <div class="input-group date col-sm-12" id="reservationdate4" data-target-input="nearest"
                                    required>
                                    <input type="text" name="finish_project" class="form-control datetimepicker-input finish_project"
                                        data-target="#reservationdate4" value="" required>
                                    <div class="input-group-append" data-target="#reservationdate4"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-6" style="padding-left: 20px;">

                            <div class="form-group row">
                                <label for="notes" class="col-sm-12 col-form-label">Notes Project</label>
                                <p style="font-size: 12px; padding-left: 10px;">*Notes Project hanya bisa di edit di dalam teamspace. <br>(agar tidak ada konflik media gambar/video)</p>
                                <div class="col-sm-12">
                                    <textarea rows="5" type="text" class="form-control" id="notes" name="notes"
                                        placeholder="Masukan detail notes"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_active" class="col-sm-12 col-form-label">Teamspace Status</label>
                                <div class="col-sm-12">
                                    <select class="form-control select is_active" style="width: 100%;" name="is_active" id="is_active">
                                        <option selected disabled value="">-Pilih Status-</option>    
                                        <option value="1">Active</option> 
                                        <option value="0">Non Active</option>         
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                        
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_dg_client_project" id="id_dg_client_project" value="">
                        <input type="hidden" name="list_project" value="1">



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
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add Data Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_client_project.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">


                    <div class="row">
                        <div class="col-6" style="padding-right: 20px;">
                            <div class="form-group row">
                                <label for="projectName2" class="col-sm-12 col-form-label">Project Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="projectName2" name="projectName2"
                                        placeholder="Ketikan Nama project" value="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="division2" class="col-sm-12 col-form-label">Division</label>
                                <div class="col-sm-12">
                                    <select class="form-control select division2" style="width: 100%;" name="division2" id="division2">
                                        <option selected disabled value="">-Pilih Divisi-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_division`
                                            where deleted_at is null");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_division']; ?>"><?php echo $d_division['division_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_client2" class="col-sm-12 col-form-label">Client</label>
                                <div class="col-sm-12">
                                    <select class="form-control select id_client2" style="width: 100%;" name="id_client2" id="id_client2">
                                        <option selected disabled value="">-Pilih Client-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_client`
                                            where deleted_at is null");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_client']; ?>"><?php echo $d_division['nama_client']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marketing2" class="col-sm-12 col-form-label">Marketing</label>
                                <div class="col-sm-12">
                                    <select class="form-control select marketing2" style="width: 100%;" name="marketing2" id="marketing2">
                                        <option selected disabled value="">-Pilih Marketing-</option>    
                                        <?php 
                                            $result_division = mysqli_query($db2,"select * from `dg_user`
                                            where deleted_at is null order by nama asc");
                                            while($d_division = mysqli_fetch_array($result_division)){
                                        ?>
                                        <option value="<?php echo $d_division['id_dg_user']; ?>"><?php echo $d_division['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenisProject2" class="col-sm-12 col-form-label">Jenis Project</label>
                                <div class="col-sm-12">
                                    <select class="form-control select jenisProject2" style="width: 100%;" name="jenisProject2" id="jenisProject2">
                                        <option selected disabled value="">-Pilih Jenis Project-</option>    
                                        <?php 
                                            $result_cp = mysqli_query($db2,"select * from `dg_client_project_jenis`
                                            where deleted_at is null");
                                            while($d_cp = mysqli_fetch_array($result_cp)){
                                        ?>
                                        <option value="<?php echo $d_cp['id_dg_client_project_jenis']; ?>"><?php echo $d_cp['nama_jenis_project']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reservationdate" class="col-sm-12 col-form-label">Start Project</label>
                                <div class="input-group date col-sm-12" id="reservationdate" data-target-input="nearest"
                                    required>
                                    <input type="text" name="start_project2" class="form-control datetimepicker-input start_project2"
                                        data-target="#reservationdate" value="" required>
                                    <div class="input-group-append" data-target="#reservationdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reservationdate2" class="col-sm-12 col-form-label">Finish Project</label>
                                <div class="input-group date col-sm-12" id="reservationdate2" data-target-input="nearest"
                                    required>
                                    <input type="text" name="finish_project2" class="form-control datetimepicker-input finish_project2"
                                        data-target="#reservationdate2" value="" required>
                                    <div class="input-group-append" data-target="#reservationdate2"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-6" style="padding-left: 20px;">


                            <div class="form-group row">
                                <label for="notes2" class="col-sm-12 col-form-label">Notes Project</label>
                                <div class="col-sm-12">
                                    <textarea rows="5" type="text" class="form-control" id="notes2" name="notes2"
                                        placeholder="Masukan detail notes"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                        

                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="list_project" value="1">


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
                   <h1>List Project</h1>
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
                                                <th>Nama Project</th>
                                                <th>Division</th>
                                                <th>Client</th>
                                                <th>Marketing</th>
                                                <th>Start Project</th>
                                                <th>Teamspace Status</th>
                                                <th class="none">Notes</th>
                                                <th style="width: 25%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($_SESSION['priv'] == 1 || $_SESSION['priv'] == 2){
                                                $result_head = mysqli_query($db2,"SELECT * from `dg_client_project` 
                                                where deleted_by is null 
                                                order by is_active desc, id_dg_client_project desc");
                                            }else{
                                                $result_head = mysqli_query($db2,"SELECT dcp.*, dcp.id_dg_client_project, dcp.nama_project
                                                FROM dg_client_project dcp
                                                INNER JOIN dg_client_project_team dcpt
                                                    ON dcp.id_dg_client_project = dcpt.id_dg_client_project
                                                WHERE dcpt.id_dg_user = $id_user
                                                GROUP BY dcp.id_dg_client_project, dcp.nama_project
                                                order by  dcp.is_active desc, dcp.id_dg_client_project desc;
                                                ");
                                            }

                                            while($d_head = mysqli_fetch_array($result_head)){
                                                $id_dg_client_project =  $d_head['id_dg_client_project'];
                                                $id_marketing = $d_head['id_marketing'];
                                                $id_division = $d_head['division'];
                                                $id_dg_client = $d_head['id_dg_client'];
                                                
                                                $result_marketing = mysqli_query($db2,"select * from `dg_user` where id_dg_user = $id_marketing");
                                                while($d_marketing = mysqli_fetch_array($result_marketing)){
                                                    $nama_marketing = $d_marketing['nama'];
                                                }

                                                $result_division = mysqli_query($db2,"select * from `dg_division` where id_dg_division = $id_division");
                                                while($d_division = mysqli_fetch_array($result_division)){
                                                    $division_name = $d_division['division_name'];
                                                }

                                                $result_client = mysqli_query($db2,"select * from `dg_client` where id_dg_client = $id_dg_client");
                                                while($d_client = mysqli_fetch_array($result_client)){
                                                    $nama_client = $d_client['nama_client'];
                                                }
                                                
                                                $active = "Active";
                                                if ($d_head['is_active']==1) {
                                                    $active = "<b style='color: green;'>Active</b>";
                                                }else{
                                                    $active = "<b style='color: red;'>Non Active</b>";
                                                }
                                               
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo $d_head['nama_project']; ?></td>
                                                <td><?php echo $division_name; ?></td>
                                                <td><?php echo $nama_client; ?></td>
                                                <td><?php echo $nama_marketing; ?></td>
                                                <td><?php echo date_format(date_create($d_head['tanggal_mulai']),"d F Y"); ?></td>
                                                <td><?php echo $active; ?></td>
                                                <td><?php echo rawurldecode($d_head['notes_project']); ?></td>
                                                
                                                <td style="text-align: center;">
                                                    <button class="btn btn-warning btn-sm" name="id_ev"
                                                        style="margin-right: 15px;"
                                                        data-toggle="modal" title="Go To Teams Project"
                                                        onclick="loadModalProjectTeam(<?php echo $d_head['id_dg_client_project']; ?>, '<?php echo $d_head['nama_project']; ?>', <?php echo $id_dg_client; ?>)"
                                                        data-keyboard="false">
                                                        <i class="fas fa-users">
                                                        </i>
                                                    </button>
                                                    <a class="btn btn-success btn-sm" name="id_ev"
                                                        style="margin-right: 15px;" href="client_project_invoice.php?id_client=<?php echo $id_dg_client; ?>&id_dg_project=<?php echo $d_head['id_dg_client_project']; ?>"
                                                        title="Go To Invoice Project" target="_blank">
                                                        <i class="fas fa-file-invoice">
                                                        </i>
                                                    </a>
                                                    <button class="btn btn-primary btn-sm" name="id_ev"
                                                        style="margin-right: 15px;"
                                                        type="button" title="Go To Links Project"
                                                        onclick="loadModalProjectLink(<?php echo $d_head['id_dg_client_project']; ?>, '<?php echo $d_head['nama_project']; ?>', '<?php echo $id_dg_client; ?>')">
                                                        <i class="fas fa-link">
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                        style="margin-right: 15px;" title="Edit this Project Data"
                                                        data-a="<?php echo $d_head['id_dg_client_project']; ?>"
                                                        data-b="<?php echo $d_head['nama_project']; ?>"
                                                        data-c="<?php echo $d_head['division']; ?>"
                                                        data-d="<?php echo $d_head['id_marketing']; ?>"
                                                        data-f="<?php echo $d_head['tanggal_mulai']; ?>"
                                                        data-g="<?php echo $d_head['tanggal_selesai']; ?>"
                                                        data-h="<?php echo $d_head['notes_project']; ?>"
                                                        data-i="<?php echo $d_head['id_dg_client_project_jenis']; ?>"
                                                        data-k="<?php echo $d_head['is_active']; ?>"
                                                        data-j="<?php echo $id_dg_client; ?>"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-header" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false" title="Delete this Project"
                                                        data-c="<?php echo $d_head['id_dg_client_project']; ?>"
                                                        data-v="<?php echo $d_head['nama_project']; ?>"
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
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
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

            function clearLinkToProject() {
                // Kosongkan nilai input
                $('#linkName').val('');
                $('#linkProject').val('');
                $('#id_dg_client_project_link').val('');
            }

            function editLinkToProject(id, nama_link, link_project) {
                // Set value pada input Nama Status
                document.getElementById('linkName').value = nama_link;
                document.getElementById('linkProject').value = link_project;
                

                // Set value pada hidden input ID
                document.getElementById('id_dg_client_project_link').value = id;

                // Tambahkan log untuk memastikan data sudah di-set
                console.log("Edit Link to Project:", {
                    id: id,
                    nama_link: nama_link,
                    link_project: link_project
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


        // Summernote
        $('#notes').summernote({
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

        // Summernote
        $('#notes2').summernote({
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


        $('#notes').summernote('disable');
 

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
        

        $('#modal-cancel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project3').val(recipient_c);
            document.getElementById("id_dg_client_project3").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })


        $('#modal-cancel-link').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project_link').val(recipient_c);
            document.getElementById("id_dg_client_project_link").value = recipient_c;


            document.getElementById("Jenis_warna3").innerHTML = recipient_v;
        })

        $('#modal-cancel-team').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');

            var recipient_v = button.data('v');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project_team').val(recipient_c);
            document.getElementById("id_dg_client_project_team").value = recipient_c;

            modal.find('.id_dg_user_delete').val(recipient_d);
            document.getElementById("id_dg_user_delete").value = recipient_d;


            document.getElementById("Jenis_warna4").innerHTML = recipient_v;
        })



        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            var recipient_f = button.data('f');
            var recipient_g = button.data('g');
            var recipient_h = button.data('h');
            var recipient_i = button.data('i');
            var recipient_j = button.data('j');
            var recipient_k = button.data('k');


            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project').val(recipient_a);
            document.getElementById("id_dg_client_project").value = recipient_a;

            modal.find('.projectName').val(recipient_b);
            document.getElementById("projectName").value = recipient_b;

            modal.find('.division').val(recipient_c);
            document.getElementById("division").value = recipient_c;

            modal.find('.marketing').val(recipient_d);
            document.getElementById("marketing").value = recipient_d;

            modal.find('.jenisProject').val(recipient_i);
            document.getElementById("jenisProject").value = recipient_i;

            modal.find('.id_client').val(recipient_j);
            document.getElementById("id_client").value = recipient_j;

            modal.find('.is_active').val(recipient_k);
            document.getElementById("is_active").value = recipient_k;


            const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];

            var dateX = new Date(recipient_f);
            
            dayX = dateX.getDate();
            monthX = monthNames[dateX.getMonth()];
            yearX = dateX.getFullYear();
            modal.find('.start_project').val(dayX+'-'+monthX+'-'+yearX);


            var dateY = new Date(recipient_g);

            dayY = dateY.getDate();
            monthY = monthNames[dateY.getMonth()];
            yearY = dateY.getFullYear();
            modal.find('.finish_project').val(dayY+'-'+monthY+'-'+yearY);

            var notes_project = decodeURIComponent(recipient_h);
            $('#notes').summernote('code', notes_project);

        })


        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
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
            //Date range picker
            $('#reservationdate2').datetimepicker({
                format: 'DD-MMMM-yyyy'
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
            $('#reservationdate3').datetimepicker({
                format: 'DD-MMMM-yyyy'
            });
            //Date range picker
            $('#reservation3').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime3').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            })

            //Date range picker
            $('#reservationdate4').datetimepicker({
                format: 'DD-MMMM-yyyy'
            });
            //Date range picker
            $('#reservation4').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime4').daterangepicker({
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


    function loadModalProjectLink(id, nama_project, id_client) {
        // Tampilkan modal
        $('#modal-edit-link').modal({
            backdrop: 'static',
            keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
        });

        // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
        function refreshModalLink() {
            // Kirim permintaan AJAX untuk mengambil data dari database
            $.ajax({
                url: 'controller/get_modal_project_link.php',
                type: 'GET',
                data: { id: id, nama_project: nama_project, id_client: id_client},
                success: function(response) {
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#modal-edit-link .modal-content-table-link').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Panggil refreshModalLink pertama kali saat modal ditampilkan
        refreshModalLink();

        // Panggil refreshModalLink setiap 1 detik setelah modal ditampilkan
        var intervalId = setInterval(refreshModalLink, 1000);

        // Hentikan pembaruan saat modal disembunyikan
        $('#modal-edit-link').on('hidden.bs.modal', function () {
            clearInterval(intervalId);
        });
    }


    function loadModalProjectTeam(id, nama_project, id_client) {
        // Tampilkan modal
        $('#modal-edit-team').modal({
            backdrop: 'static',
            keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
        });

        // Fungsi untuk memuat ulang data modal dari get_modal_project_team.php
        function refreshModalTeam() {
            // Kirim permintaan AJAX untuk mengambil data dari database
            $.ajax({
                url: 'controller/get_modal_project_team.php',
                type: 'GET',
                data: { id: id, nama_project: nama_project, id_client: id_client},
                success: function(response) {
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#modal-edit-team .modal-content-table-team').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Panggil refreshModalTeam pertama kali saat modal ditampilkan
        refreshModalTeam();

        // Panggil refreshModalTeam setiap 1 detik setelah modal ditampilkan
        var intervalId = setInterval(refreshModalTeam, 1000);

        // Hentikan pembaruan saat modal disembunyikan
        $('#modal-edit-team').on('hidden.bs.modal', function () {
            clearInterval(intervalId);
        });
    }


    
    function addteamToProject() {
        var teamUser = $('#teamUser').val();
        var teamJabatan = $('#teamJabatan').val();
        var id_dg_client_project_to_team = $('#id_dg_client_project_to_team').val();
        var id_client = $('#id_client').val();

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            url: 'controller/conn_add_client_project_team.php',
            type: 'POST',
            data: {
                teamUser: teamUser,
                teamJabatan: teamJabatan,
                id_dg_client_project_to_team: id_dg_client_project_to_team,
                id_client: id_client
            },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                if (response == 'Berhasil') {
                        toastr.success('Data berhasil disimpan.');
                        } else {
                        toastr.error('Data gagal disimpan !<br>'+response);
                        }
                        // Kosongkan nilai input
                        $('#teamUser').val('').trigger('change');
                        $('#teamJabatan').val([]).trigger('change');
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }


                function addLinkToProject() {
                    // Ambil nilai dari input text dengan id "linkProject" dan "linkName"
                    var linkProject = $('#linkProject').val();
                    var linkName = $('#linkName').val();
                    var id_dg_client_project_to_link = $('#id_dg_client_project_to_link').val();
                    var id_client = $('#id_client').val();
                    var id_dg_client_project_link = $('#id_dg_client_project_link').val();
                    var nama_project_link = $('#nama_project_link').val();
                    

                    // Kirim data form ke server menggunakan AJAX
                    $.ajax({
                        url: 'controller/conn_add_client_project_link.php',
                        type: 'POST',
                        data: {
                            linkProject: linkProject,
                            linkName: linkName,
                            id_dg_client_project_to_link: id_dg_client_project_to_link,
                            id_dg_client_project_link: id_dg_client_project_link,
                            id_client: id_client
                        },
                        dataType: 'html',
                        success: function(response) {
                            loadModalProjectLink(id_dg_client_project_to_link, nama_project_link);
                            // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                            if (response == 'Berhasil') {
                                    toastr.success('Data berhasil disimpan.');
                                    } else {
                                    toastr.error('Data gagal disimpan !<br>'+response);
                                    }
                                    // Kosongkan nilai input
                                    clearLinkToProject();


                        },
                        error: function(xhr, status, error) {
                            // Tangani kesalahan saat mengirim permintaan AJAX
                            console.error('Error:', error);
                        }
                    });
                }


    function deleteTeamToProject() {
        // Ambil nilai dari input text dengan id "linkProject" dan "linkName"
        var id_user = $('#id_user').val();
        var id_dg_client_project_team = $('#id_dg_client_project_team').val();
        var id_dg_user_delete = $('#id_dg_user_delete').val();
        
        var id_client = $('#id_client').val();

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            url: 'controller/conn_delete_client_project_team.php',
            type: 'POST',
            data: {
                id_user: id_user,
                id_dg_client_project_team: id_dg_client_project_team,
                id_client: id_client,
                id_dg_user_delete: id_dg_user_delete
            },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                if (response == 'Berhasil') {
                        toastr.warning('Data berhasil terhapus !');
                        } else {
                        toastr.error('Data gagal disimpan !<br>'+response);
                        }
                        $('#modal-cancel-team').modal('hide');

            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }

            function deleteLinkToProject() {
                // Ambil nilai dari input text dengan id "linkProject" dan "linkName"
                var id_user = $('#id_user').val();
                var id_dg_client_project_link = $('#id_dg_client_project_link').val();
                var id_dg_client_project_to_link = $('#id_dg_client_project_to_link').val();
                var id_client = $('#id_client').val();
                var nama_project_link = $('#nama_project_link').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_delete_client_project_link.php',
                    type: 'POST',
                    data: {
                        id_user: id_user,
                        id_dg_client_project_link: id_dg_client_project_link,
                        id_client: id_client
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadModalProjectLink(id_dg_client_project_to_link, nama_project_link);
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.warning('Data berhasil terhapus !');
                                } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                                }
                                $('#modal-cancel-link').modal('hide');

                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan saat mengirim permintaan AJAX
                        console.error('Error:', error);
                    }
                });
            }

    function deleteTeam(id) {
        // Kirim permintaan AJAX ke file PHP untuk menghapus tim
        $.ajax({
            url: 'controller/conn_delete_client_project_team_jabatan.php',
            type: 'POST',
            data: { id_dg_client_project_team: id },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server
                if (response == 'Berhasil') {
                    // Lakukan tindakan sesuai dengan penghapusan berhasil
                    toastr.success('Jabatan berhasil dihapus.');
                } else {
                    // Lakukan tindakan sesuai dengan penghapusan gagal
                    toastr.error('Gagal menghapus Jabatan!<br>'+response);
                }
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }


    $(document).ready(function() {
        // Event handler untuk menangkap saat modal tertutup
        $('#modal-edit-link').on('hidden.bs.modal', function (e) {
            // Kosongkan nilai input
            $('#linkName').val('');
            $('#linkProject').val('');
        });
        $('#modal-edit-team').on('hidden.bs.modal', function (e) {
            // Kosongkan nilai input
            $('#teamUser').val('').trigger('change');
            $('#teamJabatan').val([]).trigger('change');
        });

        
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
       
        
    });

    </script>
</body>

</html>