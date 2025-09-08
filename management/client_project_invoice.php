<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

$id_client = $_GET['id_client'];
$result_client = mysqli_query($db2,"select * from dg_client where id_dg_client = $id_client");
while($d_client = mysqli_fetch_array($result_client)){
    $nama_client = $d_client['nama_client'];
    $logo_client = $d_client['logo_client'];
}

$id_dg_project = $_GET['id_dg_project'];
$result_head_p = mysqli_query($db2,"select * from `dg_client_project` where id_dg_client_project = $id_dg_project
and deleted_by is null");
while($d_head_p = mysqli_fetch_array($result_head_p)){
    $nama_project = $d_head_p['nama_project'];
    $id_division = $d_head_p['division'];
    $id_marketing = $d_head_p['id_marketing'];
    $tanggal_mulai = $d_head_p['tanggal_mulai'];
    $tanggal_selesai = $d_head_p['tanggal_selesai'];
    $notes_project = $d_head_p['notes_project'];
}
$result_division_r = mysqli_query($db2,"select * from dg_division where id_dg_division = $id_division");
while($d_division_r = mysqli_fetch_array($result_division_r)){
    $division_name_r = $d_division_r['division_name'];
}
$result_marketing_r = mysqli_query($db2,"select * from dg_user where id_dg_user = $id_marketing");
while($d_marketing_r = mysqli_fetch_array($result_marketing_r)){
    $marketing_name = $d_marketing_r['nama'];
}

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAB & Invoice Project | DIK Group</title>

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
                                <button onclick="addteamToProject()" class="btn btn-success" title="Add team">+</button>
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


                        <div class="col-sm-1">
                            <button onclick="addLinkToProject()" class="btn btn-success" title="Add Link">+</button>
                        </div>
                        
                    </div>

                </div>
            </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-cancel-breakdown">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Breakdown ini ?<br>
                        Breakdown &nbsp; : <b id="Jenis_warna3"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_breakdown" id="id_dg_client_project_breakdown" value="">
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
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">

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
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">

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

                        </div>
                        <div class="col-6" style="padding-left: 20px;">

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
                            <div class="form-group row">
                                <label for="notes" class="col-sm-12 col-form-label">Notes Project</label>
                                <div class="col-sm-12">
                                    <textarea rows="5" type="text" class="form-control" id="notes" name="notes"
                                        placeholder="Masukan detail notes"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                        
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
                        <input type="hidden" name="id_dg_client_project" id="id_dg_client_project" value="">
                        <input type="hidden" name="invoice" value="1">


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

    <div class="modal fade" id="modal-add-breakdown">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add RAB Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                    <div class="modal-body">


                    <div class="row">
                        <div class="col-12" style="padding-right: 20px;">
                            <div class="form-group row">
                                <label for="nama_team2" class="col-sm-12 col-form-label">Nama Team</label>
                                <div class="col-sm-12">
                                    <select class="form-control select nama_team2" style="width: 100%;" name="nama_team2" id="nama_team2" onchange="selectJabatanAjax(<?php echo $id_dg_project; ?>)">
                                        <option selected disabled value="">-Pilih Nama Team-</option>    
                                        <?php 
                                            $result_team = mysqli_query($db2,"SELECT cpt.id_dg_user, u.nama
                                            FROM dg_client_project_team cpt 
                                            JOIN dg_user u ON cpt.id_dg_user = u.id_dg_user 
                                            WHERE cpt.id_dg_client_project = $id_dg_project
                                            GROUP BY cpt.id_dg_user, u.nama
                                            ORDER BY cpt.id_dg_user");
                                            while($d_team = mysqli_fetch_array($result_team)){
                                        ?>
                                        <option value="<?php echo $d_team['id_dg_user']; ?>"><?php echo $d_team['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                            <div class="select-jabatan col-12" id="select-jabatan"></div>
                    </div>
                        

                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client2" value="<?php echo $id_client; ?>">



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

    <div class="modal fade" id="modal-add-breakdown-memo">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add Memo Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                    <div class="modal-body">


                    <div class="row">
                        <div class="col-12" style="padding-right: 20px;">
                            <div class="form-group row">
                                <label for="nama_team5" class="col-sm-12 col-form-label">Nama Team</label>
                                <div class="col-sm-12">
                                    <select class="form-control select nama_team5" style="width: 100%;" name="nama_team5" id="nama_team5" onchange="selectJabatanAjaxMemo(<?php echo $id_dg_project; ?>)">
                                        <option selected disabled value="">-Pilih Nama Team-</option>    
                                        <?php 
                                            $result_team = mysqli_query($db2,"SELECT cpt.id_dg_user, u.nama
                                            FROM dg_client_project_team cpt 
                                            JOIN dg_user u ON cpt.id_dg_user = u.id_dg_user 
                                            WHERE cpt.id_dg_client_project = $id_dg_project
                                            GROUP BY cpt.id_dg_user, u.nama
                                            ORDER BY cpt.id_dg_user");
                                            while($d_team = mysqli_fetch_array($result_team)){
                                        ?>
                                        <option value="<?php echo $d_team['id_dg_user']; ?>"><?php echo $d_team['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                            <div class="select-jabatan-memo col-12" id="select-jabatan-memo"></div>
                    </div>
                        

                        <input type="hidden" name="id_user5" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client5" value="<?php echo $id_client; ?>">



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" onclick="saveDataBreakDownMemo()" class="btn btn-primary">Save</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-edit-breakdown">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit RAB Project</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                    <div class="modal-body">


                    <div class="row">
                        <div class="col-12" style="padding-right: 20px;">
                            <div class="form-group row">
                                <label for="nama_team3" class="col-sm-12 col-form-label">Nama Team</label>
                                <div class="col-sm-12">
                                    <select disabled class="form-control select nama_team3" style="width: 100%;" name="nama_team3" id="nama_team3" onchange="selectJabatanAjaxEdit(<?php echo $id_dg_project; ?>)">
                                        <option selected disabled value="">-Pilih Nama Team-</option>    
                                        <?php 
                                            $result_team = mysqli_query($db2,"SELECT cpt.id_dg_user, u.nama
                                            FROM dg_client_project_team cpt 
                                            JOIN dg_user u ON cpt.id_dg_user = u.id_dg_user 
                                            WHERE cpt.id_dg_client_project = $id_dg_project
                                            GROUP BY cpt.id_dg_user, u.nama
                                            ORDER BY cpt.id_dg_user");
                                            while($d_team = mysqli_fetch_array($result_team)){
                                        ?>
                                        <option value="<?php echo $d_team['id_dg_user']; ?>"><?php echo $d_team['nama']; ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                            <div class="select-jabatan-edit col-12" id="select-jabatan-edit"></div>
                    </div>
                        
                        <input type="hidden" name="id_dg_client_project_breakdown2" id="id_dg_client_project_breakdown2" value="">
                        <input type="hidden" name="id_user2" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_client2" value="<?php echo $id_client; ?>">
                        <input type="hidden" name="id_dg_user_team_edit" id="id_dg_user_team_edit" value="">
                        <input type="hidden" name="status_breakdown" id="status_breakdown" value="">
                        <input type="hidden" name="status_rab" id="status_rab" value="">



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" onclick="saveDataBreakDownEdit()" class="btn btn-primary">Save</button>
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
                        <div class="col-sm-12">
                            <h1 class="m-0">
                                <img class="shadow" style="width: 100px; padding: 10px; margin-right: 10px;"
                                     src="img/client_logo/<?php if($logo_client!=""){echo $logo_client;}else{echo "logo.png";} ?>"
                                     alt="<?php echo $logo_client; ?> logo" /><?php echo $nama_client; ?> - Project <?php echo $nama_project; ?>
                            </h1>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="modal-title" id="exampleModalLabel">RAB Project</h4>
                                    <button class="btn btn-info" name="id_ev"
                                        title="Edit this Project Data"
                                        data-a="<?php echo $id_dg_project; ?>"
                                        data-b="<?php echo $nama_project; ?>"
                                        data-c="<?php echo $id_division; ?>"
                                        data-d="<?php echo $id_marketing; ?>"
                                        data-f="<?php echo $tanggal_mulai; ?>"
                                        data-g="<?php echo $tanggal_selesai; ?>"
                                        data-h="<?php echo $notes_project; ?>"
                                        data-toggle="modal"
                                        data-target="#modal-edit-header" data-backdrop="static"
                                        data-keyboard="false"
                                        style="margin-left: auto; width: 150px;">
                                        Edit <i class="fas fa-pencil-alt pl-2"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <div class="row">

                                            <div class="form-group col-4">
                                                <label for="projectName_RAB" class="col-sm-12 col-form-label">Project Name</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="projectName_RAB" name="projectName_RAB"
                                                        placeholder="Ketikan Nama project" value="<?php echo $nama_project; ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group col-4">
                                                <label for="division_RAB" class="col-sm-12 col-form-label">Division</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="division_RAB" name="division_RAB"
                                                        placeholder="Ketikan Nama project" value="<?php echo $division_name_r; ?>" disabled>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-4">
                                                <label for="marketing_RAB" class="col-sm-12 col-form-label">Nama Marketing</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="marketing_RAB" name="marketing_RAB"
                                                        placeholder="Ketikan Nama project" value="<?php echo $marketing_name; ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group col-4">
                                                <label for="tanggal_mulai_RAB" class="col-sm-12 col-form-label">Tanggal Mulai</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="tanggal_mulai_RAB" name="tanggal_mulai_RAB"
                                                        placeholder="Ketikan Nama project" value="<?php echo date_format(date_create($tanggal_mulai),"d F Y"); ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group col-4">
                                                <label for="tanggal_selesai_RAB" class="col-sm-12 col-form-label">Tanggal Selesai</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="tanggal_selesai_RAB" name="tanggal_selesai_RAB"
                                                        placeholder="Ketikan Nama project" value="<?php echo date_format(date_create($tanggal_selesai),"d F Y"); ?>" disabled>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-content-table-breakdown">

                    </div>

                    <div class="modal-content-table-breakdown-memo">

                    </div>

                    


                    
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

    <!-- Page specific script -->
    <script>
 
        // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
        function selectJabatanAjax(id_dg_project) {
            var id_user = <?php echo $id_user; ?>;
            var id_user_team = document.getElementById("nama_team2").value; 
            var id_division = <?php echo $id_division; ?>;
            // Kirim permintaan AJAX untuk mengambil data dari database
            $.ajax({
                url: 'view/select/selectJabatan.php',
                type: 'GET',
                data: { 
                    id_dg_project: id_dg_project, 
                    id_user_team : id_user_team, 
                    id_user : id_user,
                    id_division : id_division
                },
                success: function(response) {
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#select-jabatan').html(response);
                    $('#select-jabatan').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            
        }

         // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
         function selectJabatanAjaxMemo(id_dg_project) {
            var id_user = <?php echo $id_user; ?>;
            var id_user_team = document.getElementById("nama_team5").value; 
            var id_division = <?php echo $id_division; ?>;
            // Kirim permintaan AJAX untuk mengambil data dari database
            $.ajax({
                url: 'view/select/selectJabatanMemo.php',
                type: 'GET',
                data: { 
                    id_dg_project: id_dg_project, 
                    id_user_team : id_user_team, 
                    id_user : id_user,
                    id_division : id_division
                },
                success: function(response) {
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#select-jabatan-memo').html(response);
                    $('#select-jabatan-memo').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            
        }

        // Fungsi untuk memuat ulang data modal dari get_modal_project_link.php
        function selectJabatanAjaxEdit(id_dg_client_project_breakdown, id_user_team) {
            var id_user = <?php echo $id_user; ?>;
            var id_user_team = document.getElementById("id_dg_user_team_edit").value; 
            var status_breakdown = document.getElementById("status_breakdown").value; 
            var status_rab = document.getElementById("status_rab").value; 
            
            var id_division = <?php echo $id_division; ?>;
            // Kirim permintaan AJAX untuk mengambil data dari database
            $.ajax({
                url: 'view/select/selectJabatanEdit.php',
                type: 'GET',
                data: { 
                    id_dg_client_project_breakdown: id_dg_client_project_breakdown, 
                    id_user_team : id_user_team, 
                    id_user : id_user,
                    status_breakdown : status_breakdown,
                    status_rab : status_rab,
                    id_division : id_division
                },
                success: function(response) {
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#select-jabatan-edit').html(response);
                    $('#select-jabatan-edit').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
            
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
        

        $('#modal-cancel-breakdown').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_client_project_breakdown').val(recipient_c);
            document.getElementById("id_dg_client_project_breakdown").value = recipient_c;


            document.getElementById("Jenis_warna3").innerHTML = recipient_v;
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

            modal.find('.notes').val(recipient_h);
            document.getElementById("notes").innerHTML = recipient_h;

        })


        $('#modal-add-breakdown').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            $('#select-jabatan').hide();
        })

        $('#modal-add-breakdown-memo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            $('#select-jabatan-memo').hide();
        })

        $('#modal-edit-breakdown').on('show.bs.modal', function (event) {
           
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');


            var modal = $(this);
            modal.find('.id_dg_client_project_breakdown2').val(recipient_a);
            document.getElementById("id_dg_client_project_breakdown2").value = recipient_a;

            modal.find('.nama_team3').val(recipient_b);
            document.getElementById("nama_team3").value = recipient_b;

            modal.find('.id_dg_user_team_edit').val(recipient_b);
            document.getElementById("id_dg_user_team_edit").value = recipient_b;

            modal.find('.status_breakdown').val(recipient_c);
            document.getElementById("status_breakdown").value = recipient_c;

            modal.find('.status_rab').val(recipient_d);
            document.getElementById("status_rab").value = recipient_d;
            
            selectJabatanAjaxEdit(recipient_a, recipient_b);
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

        $(document).ready(function() {
            // Fungsi untuk memuat isi tabel setiap 3 detik
            function loadTable() {
                var id_dg_project = <?php echo $id_dg_project; ?>; // Mendapatkan nilai dari PHP
                $.ajax({
                    url: 'view/table/table_break_down_harga.php',
                    type: 'GET',
                    data: { id_dg_project: id_dg_project }, // Mengirimkan id_dg_client_project sebagai data
                    success: function(response) {
                        // Mengganti isi div dengan hasil dari ajax
                        $('.modal-content-table-breakdown').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Memanggil fungsi loadTable setiap 3 detik
            setInterval(loadTable, 7000);


            // Fungsi untuk memuat isi tabel setiap 3 detik
            function loadTableMemo() {
                var id_dg_project = <?php echo $id_dg_project; ?>; // Mendapatkan nilai dari PHP
                $.ajax({
                    url: 'view/table/table_break_down_harga_memo.php',
                    type: 'GET',
                    data: { id_dg_project: id_dg_project }, // Mengirimkan id_dg_client_project sebagai data
                    success: function(response) {
                        // Mengganti isi div dengan hasil dari ajax
                        $('.modal-content-table-breakdown-memo').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Memanggil fungsi loadTableMemo setiap 3 detik
            setInterval(loadTableMemo, 5000);

            loadTable();
            loadTableMemo();
        });

  


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

            // Tangani event ketika modal ditutup
            $('#modal-add-breakdown').on('hidden.bs.modal', function (e) {
                // Sembunyikan modal-content-table-breakdown
                $('#select-jabatan').hide();
                // Bersihkan select dengan id teamUser
                $('#nama_team2').val('').trigger('change');
            });

            // Tangani event ketika modal ditutup
            $('#modal-add-breakdown-memo').on('hidden.bs.modal', function (e) {
                // Sembunyikan modal-content-table-breakdown
                $('#select-jabatan-memo').hide();
                // Bersihkan select dengan id teamUser
                $('#nama_team5').val('').trigger('change');
            });

            // Tangani event ketika modal ditutup
            $('#modal-edit-breakdown').on('hidden.bs.modal', function (e) {
                // Sembunyikan modal-content-table-breakdown
                $('#select-jabatan-edit').hide();
                // Bersihkan select dengan id teamUser
                $('#nama_team3').val('').trigger('change');
            });


           
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 1 detik
       

        });


    function deleteBreakDown() {
        // Ambil nilai dari input text dengan id "linkProject" dan "linkName"
        var id_user = $('#id_user').val();
        var id_dg_client_project_breakdown = $('#id_dg_client_project_breakdown').val();
        var id_client = $('#id_client').val();
        

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            url: 'controller/conn_delete_client_project_breakdown.php',
            type: 'POST',
            data: { id_dg_client_project_breakdown: id_dg_client_project_breakdown },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server
                if (!response.includes('Error')) {
                    // Lakukan tindakan sesuai dengan penghapusan berhasil
                    toastr.success('Breakdown berhasil dihapus.');
                } else {
                    // Lakukan tindakan sesuai dengan penghapusan gagal
                    toastr.error('Gagal menghapus Breakdown!<br>'+response);
                }
                $('#modal-cancel-breakdown').modal('hide');
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }




    </script>
</body>

</html>