<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management User's</title>

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
                    <p>Are you sure you want to delete this user?<br>
                        User Name &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form id="formDeleteUserProfile"  action="controller/conn_delete_user.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task3" id="id_task3" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button id="btnDeleteUserProfile" type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-reset">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">ATTENTION !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reset this User's password? ?<br>
                        User Name &nbsp; : <b id="Jenis_warna3"></b><br>
                </div>
                <form id="formResetUserProfile" action="controller/conn_reset_user.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task4" id="id_task4" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button id="btnResetUserProfile" type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->




    <div class="modal fade" id="modal-edit-header">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit User Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUserProfile" action="controller/conn_edit_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                    <div class="row">
                        <div class="col-6" style="padding-right: 20px;">
                                    <div class="form-group">
                                        <label for="foto_user">User Photos</label>
                                        <input class="form-control" type="file" id="foto_user" name="foto_user">
                                        <label for="foto_user"><img id="blah"
                                                style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                                src="img/profile/t0.jpg" alt="your image" /></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="namaUser" class="col-sm-12 col-form-label">User Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaUser" name="namaUser"
                                                placeholder="Type your name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="namaPanggilan" class="col-sm-12 col-form-label">Nickname</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaPanggilan" name="namaPanggilan"
                                                placeholder="Type your nickname" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="JenisKelamin" class="col-sm-12 col-form-label">Gender</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 JenisKelamin" style="width: 100%;" name="JenisKelamin" id="JenisKelamin">
                                                <option value="">-Select Gender-</option>    
                                                <option value="L">Man</option>
                                                <option value="P">Woman</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-12 col-form-label">Username</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Type your Username" value="" required>
                                            <small id="username-feedback-edit" class="text-danger" style="display:none;">*Username already in use</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="reservationdate" class="col-sm-12 col-form-label">Birthday Date</label>
                                        <div class="input-group date col-sm-12" id="reservationdate" data-target-input="nearest"
                                            required>
                                            <input type="text" name="ulangtahun" class="form-control datetimepicker-input ulangtahun"
                                                data-target="#reservationdate" value="" required>
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamatUser" class="col-sm-12 col-form-label">User Address</label>
                                        <div class="col-sm-12">
                                            <textarea rows="5" type="text" class="form-control" id="alamatUser"
                                                name="alamatUser" placeholder="Type your user address"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6" style="padding-left: 20px;">

                                    <div class="form-group row">
                                        <label for="emailUser" class="col-sm-12 col-form-label">User Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailUser" name="emailUser"
                                                placeholder="Type your email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailPerusahaan" class="col-sm-12 col-form-label">Company Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailPerusahaan" name="emailPerusahaan"
                                                placeholder="Type your company email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomorUser" class="col-sm-12 col-form-label">Mobile Phone number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nomorUser" name="nomorUser"
                                                placeholder="Type your mobile phone number" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Jabatan" class="col-sm-12 col-form-label">Position</label>
                                        <div class="col-sm-12">
                                            
                                            
                                            <select class="form-control select2 Jabatan" style="width: 100%;" name="Jabatan" id="Jabatan">
                                                <option value="" selected disabled>- Select Position -</option>   
                                                <?php 
                                                $result_dujs = mysqli_query($db2,"SELECT dj.*
                                                FROM dg_job dj
                                                WHERE dj.deleted_by is null");
                                                while($d_dujs = mysqli_fetch_array($result_dujs)){
                                                ?>
                                                <option <?php if ($d_dujs['job_name']==$jabatan){echo "selected";} ?> value="<?php echo $d_dujs['job_name']; ?>"><?php echo $d_dujs['job_name']; ?></option>    
                                                <?php } ?>
                                            </select>



                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mbti" class="col-sm-12 col-form-label">MBTI</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 mbti" style="width: 100%;" name="mbti" id="mbti">
                                                <option value="">-Select MBTI-</option>
                                                <option value="-">-Not Yet Test-</option>
                                                <option value="ISTJ">ISTJ</option>
                                                <option value="ISFJ">ISFJ</option>
                                                <option value="INFJ">INFJ</option>
                                                <option value="INTJ">INTJ</option>
                                                <option value="ISTP">ISTP</option>
                                                <option value="ISFP">ISFP</option>
                                                <option value="INFP">INFP</option>
                                                <option value="INTP">INTP</option>
                                                <option value="ESTP">ESTP</option>
                                                <option value="ESFP">ESFP</option>
                                                <option value="ENFP">ENFP</option>
                                                <option value="ENTP">ENTP</option>
                                                <option value="ESTJ">ESTJ</option>
                                                <option value="ESFJ">ESFJ</option>
                                                <option value="ENFJ">ENFJ</option>
                                                <option value="ENTJ">ENTJ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="quotes" class="col-sm-12 col-form-label">Quotes</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="quotes" name="quotes"
                                                placeholder="Type your quotes" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="noRek" class="col-sm-12 col-form-label">Account Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="noRek" name="noRek"
                                                placeholder="Type yout account number" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank" class="col-sm-12 col-form-label">Bank Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="bank" name="bank"
                                                placeholder="Type your bank name" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-sm-12 col-form-label">User Status</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 status" style="width: 100%;" name="status">
                                                <option value="4">Staff (Read Task)</option>
                                                <option value="3">Project Manager (Task Management)</option>
                                                <option value="2">Head of Division (Task & Client Management)</option>
                                                
                                                <option value="1">Super Admin (All Management)</option>
                                                <option value="5">Pasive / Ex-Staff</option>
                                            </select>
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task" id="id_task" value="">
                        <input type="hidden" class="form-group" id="bannerLama" name="bannerLama">
                        <input type="hidden" name="profile" value="1">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveEditUserProfile">Save</button>
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
                    <h4 class="modal-title" id="exampleModalLabel2">Add User & Profile Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddUserProfile" action="controller/conn_add_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6" style="padding-right: 20px;">
                                    <div class="form-group">
                                        <label for="foto_user2">User Photo</label>
                                        <input class="form-control" type="file" id="foto_user2" name="foto_user2">
                                        <label for="foto_user2"><img id="blah2"
                                                style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                                src="img/profile/t0.jpg" alt="your image" /></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="namaUser2" class="col-sm-12 col-form-label">Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaUser2" name="namaUser2"
                                                placeholder="Type your name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="NamaPanggilan2" class="col-sm-12 col-form-label">Nickname</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="NamaPanggilan2" name="NamaPanggilan2"
                                                placeholder="Type your nickname" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="JenisKelamin2" class="col-sm-12 col-form-label">Gender</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 JenisKelamin2" style="width: 100%;" name="JenisKelamin2" id="JenisKelamin2">
                                                <option value="">-Select Gender-</option>    
                                                <option value="L">Man</option>
                                                <option value="P">Woman</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="username2" class="col-sm-12 col-form-label">Username</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="username2" name="username2"
                                                placeholder="Type your username" value="" required>
                                            <small id="username-feedback-profile" class="text-danger" style="display:none;">*Username already in use</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="reservationdate2" class="col-sm-12 col-form-label">Birthday Date</label>
                                        <div class="input-group date col-sm-12" id="reservationdate2" data-target-input="nearest"
                                            required>
                                            <input type="text" name="ulangtahun2" id="ulangtahun2" class="form-control datetimepicker-input"
                                                data-target="#reservationdate2" value="" required>
                                            <div class="input-group-append" data-target="#reservationdate2"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="alamatUser2" class="col-sm-12 col-form-label">User Address</label>
                                        <div class="col-sm-12">
                                            <textarea rows="5" type="text" class="form-control" id="alamatUser2"
                                                name="alamatUser2" placeholder="Type your address" required></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6" style="padding-left: 20px;">


                                    <div class="form-group row">
                                        <label for="emailUser2" class="col-sm-12 col-form-label">User Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailUser2" name="emailUser2"
                                                placeholder="Type your email" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailPerusahaan2" class="col-sm-12 col-form-label">Company Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailPerusahaan2" name="emailPerusahaan2"
                                                placeholder="Type your email perusahaan" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomorUser2" class="col-sm-12 col-form-label">Mobile Phone number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nomorUser2" name="nomorUser2"
                                                placeholder="Type your Mobile Phone number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Jabatan2" class="col-sm-12 col-form-label">Position</label>
                                        <div class="col-sm-12">
                                           

                                            <select class="form-control select2 Jabatan2" style="width: 100%;" name="Jabatan2" required>
                                                <option value="" selected disabled>- Select Position -</option>   
                                                <?php 
                                                $result_dujs = mysqli_query($db2,"SELECT dj.*
                                                FROM dg_job dj
                                                WHERE dj.deleted_by is null");
                                                while($d_dujs = mysqli_fetch_array($result_dujs)){
                                                ?>
                                                <option <?php if ($d_dujs['job_name']==$jabatan){echo "selected";} ?> value="<?php echo $d_dujs['job_name']; ?>"><?php echo $d_dujs['job_name']; ?></option>    
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="mbti2" class="col-sm-12 col-form-label">MBTI</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 mbti2" style="width: 100%;" name="mbti2" id="mbti2">
                                                <option value="">-Pilih MBTI-</option>    
                                                <option value="-">-Belum Test-</option>
                                                <option value="ISTJ">ISTJ</option>
                                                <option value="ISFJ">ISFJ</option>
                                                <option value="INFJ">INFJ</option>
                                                <option value="INTJ">INTJ</option>
                                                <option value="ISTP">ISTP</option>
                                                <option value="ISFP">ISFP</option>
                                                <option value="INFP">INFP</option>
                                                <option value="INTP">INTP</option>
                                                <option value="ESTP">ESTP</option>
                                                <option value="ESFP">ESFP</option>
                                                <option value="ENFP">ENFP</option>
                                                <option value="ENTP">ENTP</option>
                                                <option value="ESTJ">ESTJ</option>
                                                <option value="ESFJ">ESFJ</option>
                                                <option value="ENFJ">ENFJ</option>
                                                <option value="ENTJ">ENTJ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="quotes2" class="col-sm-12 col-form-label">Quotes</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="quotes2" name="quotes2"
                                                placeholder="Type your Quotes" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="noRek2" class="col-sm-12 col-form-label">Account Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="noRek2" name="noRek2"
                                                placeholder="Type your account number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank2" class="col-sm-12 col-form-label">Bank Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="bank2" name="bank2"
                                                placeholder="Type your bank name" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status2" class="col-sm-12 col-form-label">Status User</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2" style="width: 100%;" name="status2">
                                                <option value="4">Staff (Read Task)</option>
                                                <option value="3">Project Manager (Task Management)</option>
                                                <option value="2">Head of Division (Task & Client Management)</option>
                                                
                                                <option value="1">Super Admin (All Management)</option>
                                                <option value="5">Pasive / Ex-Staff</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="profile" value="1">
                        <input type="hidden" name="id_dg_user_organization" value="<?php echo $id_dg_user_organization; ?>">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveUserProfile" disabled>Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-add-user">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add User Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddUser" action="controller/conn_add_user.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-6" style="padding-right: 20px;">
                                    <div class="form-group">
                                        <label for="foto_user3">User Photo</label>
                                        <input class="form-control" type="file" id="foto_user3" name="foto_user3">
                                        <label for="foto_user3"><img id="blah3"
                                                style="width: 200px; border: 1px solid black; margin-top: 30px; padding: 10px;"
                                                src="img/profile/t0.jpg" alt="your image" /></label>
                                    </div>
                                    <div class="form-group row">
                                        <label for="namaUser2" class="col-sm-12 col-form-label">User Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="namaUser2" name="namaUser2"
                                                placeholder="Type your name" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="username3" class="col-sm-12 col-form-label">Username</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="username3" name="username3"
                                                placeholder="Type your Username" value="" required>
                                            <small id="username-feedback" class="text-danger" style="display:none;">*Username already in use</small>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-6" style="padding-left: 20px;">


                                    <div class="form-group row">
                                        <label for="noRek2" class="col-sm-12 col-form-label">Account Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="noRek2" name="noRek2"
                                                placeholder="Type your account number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank2" class="col-sm-12 col-form-label">Bank Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="bank2" name="bank2"
                                                placeholder="Type your bank name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomorUser2" class="col-sm-12 col-form-label">Mobile Phone Number</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nomorUser2" name="nomorUser2"
                                                placeholder="Type your mobile phone number" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailUser2" class="col-sm-12 col-form-label">User Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control" id="emailUser2" name="emailUser2"
                                                placeholder="Type your email" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Jabatan2" class="col-sm-12 col-form-label">Position</label>
                                        <div class="col-sm-12">
                                           

                                            <select class="form-control select2 Jabatan2" style="width: 100%;" name="Jabatan2" id="Jabatan2" required>
                                                <option value="" selected disabled>- Select Position -</option>   
                                                <?php 
                                                $result_dujs = mysqli_query($db2,"SELECT dj.*
                                                FROM dg_job dj
                                                WHERE dj.deleted_by is null");
                                                while($d_dujs = mysqli_fetch_array($result_dujs)){
                                                ?>
                                                <option <?php if ($d_dujs['job_name']==$jabatan){echo "selected";} ?> value="<?php echo $d_dujs['job_name']; ?>"><?php echo $d_dujs['job_name']; ?></option>    
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>                                 

                                    <div class="form-group row">
                                        <label for="status2" class="col-sm-12 col-form-label">Status User</label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2" style="width: 100%;" name="status2">
                                                <option value="4">Staff (Read Task)</option>
                                                <option value="3">Project Manager (Task Management)</option>
                                                <option value="2">Head of Division (Task & Client Management)</option>
                                                
                                                <option value="1">Super Admin (All Management)</option>
                                                <option value="5">Pasive / Ex-Staff</option>
                                            </select>
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_dg_user_organization" value="<?php echo $id_dg_user_organization; ?>">
                        <input type="hidden" name="profile" value="0">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveUser" disabled>Save</button>

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
                            <h1 class="m-0">User's Data
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
                                            style="margin-top: 10px; margin-left: 20px;">
                                            <!-- <input type="checkbox" class="custom-control-input" onChange="changeCheck()"
                                                id="customSwitch3" value="1" <?php if($aktif==1){echo "checked";}?>>
                                            <label class="custom-control-label"
                                                for="customSwitch3"><?php if($aktif==1){echo "Aktif";}else{echo "Tidak Aktif";}?></label> -->
                                        </div>
                                    </div>
                                    <div class="col-6 form-group" style="z-index: 99; height:10px;">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-user" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 150px; margin-top: 60px; margin-right: 20px;">
                                            + Add User
                                        </button>
                                        <button class="btn btn-info float-sm-right" data-toggle="modal"
                                            data-target="#modal-add" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 250px; margin-top: 60px; margin-right: 20px;">
                                            + Add User & Profile
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th>Detail</th>
                                                <th class="none">Photo</th>
                                                <th>User ID</th>
                                                <th>Full Name</th>
                                                <th>Gender</th>
                                                <th class="none">Nickname</th>
                                                <th class="none">Username</th>
                                                <th>Birthday</th>
                                                <th class="none">Email</th>
                                                <th class="none">Company Email</th>
                                                <th class="none">Phone Number</th>
                                                <th>Position</th>
                                                <th class="none">MBTI</th>
                                                <th class="none">Bank Account Number</th>
                                                <th class="none">Bank Name</th>
                                                <th class="none">Address</th>
                                                <th class="none">Quotes</th>
                                                <th>Access Rights</th>
                                                <th>User Status</th>
                                                <th>Password Status</th>
                                                <th style="width: 20%;">Actions</th>

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



            $('#username3').on('change', function() {
                var username = $(this).val().trim();
                console.log('Checking username:', username);
                

                if (username.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'controller/check_username.php',
                        data: { username: username },
                        success: function(response) {
                            
                            
                            if (response == 'exists') {
                                $('#username-feedback').show();
                                $('#username3').addClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', true);
                                
                            } else {
                                $('#username-feedback').hide();
                                $('#username3').removeClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', false);
                                
                            }
                        }
                    });
                } else {
                    $('#username-feedback').hide();
                    $('#username3').removeClass('is-invalid');
                    $('button[type="submit"]').prop('disabled', true);
                }
            });

            $('#username2').on('change', function() {
                var username = $(this).val().trim();
                console.log('Checking username:', username);
                

                if (username.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'controller/check_username.php',
                        data: { username: username },
                        success: function(response) {
                            
                            
                            if (response == 'exists') {
                                $('#username-feedback-profile').show();
                                $('#username2').addClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', true);
                                
                            } else {
                                $('#username-feedback-profile').hide();
                                $('#username2').removeClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', false);
                                
                            }
                        }
                    });
                } else {
                    $('#username-feedback-profile').hide();
                    $('#username2').removeClass('is-invalid');
                    $('button[type="submit"]').prop('disabled', true);
                }
            });


            $('#username').on('change', function() {
                var username = $(this).val().trim();
                console.log('Checking username:', username);
                var id_task = document.getElementById("id_task").value;

                if (username.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: 'controller/check_username.php',
                        data: { username: username, id_task: id_task },
                        success: function(response) {
                            
                            
                            if (response == 'exists') {
                                $('#username-feedback-edit').show();
                                $('#username').addClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', true);
                                
                            } else {
                                $('#username-feedback-edit').hide();
                                $('#username').removeClass('is-invalid');
                                $('button[type="submit"]').prop('disabled', false);
                                
                            }
                        }
                    });
                } else {
                    $('#username-feedback-edit').hide();
                    $('#username').removeClass('is-invalid');
                    $('button[type="submit"]').prop('disabled', true);
                }
            });

            
            // Form submit with AJAX
            $('#formAddUser').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnSaveUser').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('User berhasil ditambahkan!');
                            $('#modal-add-user').modal('hide');
                            $('#formAddUser')[0].reset();
                            $('#btnSaveUser').prop('disabled', true).text('Save');
                        } else {
                            
                            
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnSaveUser').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnSaveUser').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });

            // Form submit with AJAX
            $('#formAddUserProfile').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnSaveUserProfile').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('User berhasil ditambahkan!');
                            $('#modal-add').modal('hide');
                            $('#formAddUserProfile')[0].reset();
                            $('#btnSaveUserProfile').prop('disabled', true).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnSaveUserProfile').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnSaveUserProfile').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });


            // Form submit with AJAX
            $('#formEditUserProfile').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnSaveEditUserProfile').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('User berhasil ditambahkan!');
                            $('#modal-edit-header').modal('hide');
                            $('#formEditUserProfile')[0].reset();
                            $('#btnSaveEditUserProfile').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnSaveEditUserProfile').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnSaveEditUserProfile').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });

            // Form submit with AJAX
            $('#formDeleteUserProfile').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnDeleteUserProfile').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('User berhasil ditambahkan!');
                            $('#modal-cancel').modal('hide');
                            $('#formDeleteUserProfile')[0].reset();
                            $('#btnDeleteUserProfile').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnDeleteUserProfile').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnDeleteUserProfile').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });

            // Form submit with AJAX
            $('#formResetUserProfile').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#btnResetUserProfile').prop('disabled', true).text('Saving...');
                    },
                    success: function (response) {
                        // Anggap response "success" berarti sukses
                        if (response.trim() === 'success') {
                            toastr.success('User berhasil ditambahkan!');
                            $('#modal-reset').modal('hide');
                            $('#formResetUserProfile')[0].reset();
                            $('#btnResetUserProfile').prop('disabled', false).text('Save');
                        } else {
                            toastr.error('Gagal menyimpan: ' + response);
                            $('#btnResetUserProfile').prop('disabled', false).text('Save');
                        }
                        loadUserTable();
                    },
                    error: function (xhr) {
                        toastr.error('A network error occurred.');
                        $('#btnResetUserProfile').prop('disabled', false).text('Save');
                        loadUserTable();
                    }
                });
            });



        });

        

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
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

            var table = $('#example1').DataTable(tableOptions);
            table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            function loadUserTable() {
                // Simpan halaman aktif saat ini
                var currentPage = table.page();

                $.ajax({
                    url: 'view/ajax/load_user_table.php',
                    method: 'GET',
                    success: function(data) {
                        table.clear().destroy(); // hancurkan DataTable

                        $('#userTableBody').html(data); // isi ulang tbody

                        // Re-inisialisasi DataTable
                        table = $('#example1').DataTable(tableOptions);

                        // Kembalikan ke halaman sebelumnya
                        table.page(currentPage).draw('page');

                        // Re-attach tombol export
                        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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




        $('#modal-reset').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task4').val(recipient_c);
            document.getElementById("id_task4").value = recipient_c;


            document.getElementById("Jenis_warna3").innerHTML = recipient_v;
        })





        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            var recipient_e = button.data('e');
            var recipient_f = button.data('f');
            var recipient_g = button.data('g');
            var recipient_h = button.data('h');
            var recipient_i = button.data('i');
            var recipient_j = button.data('j');
            var recipient_l = button.data('l');
            var recipient_k = button.data('k');

            var recipient_m = button.data('m');
            var recipient_n = button.data('n');
            var recipient_o = button.data('o');
            var recipient_p = button.data('p');
            var recipient_q = button.data('q');

            
       

            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task').val(recipient_a);
            document.getElementById("id_task").value = recipient_a;

            modal.find('.bannerLama').val(recipient_b);
            document.getElementById("bannerLama").value = recipient_b;
            if (recipient_b=="") {
                document.getElementById("blah").src = "img/profile/t0.jpg"
            }else{
            document.getElementById("blah").src = "img/profile/"+recipient_b;
            }
            modal.find('.namaUser').val(recipient_c);
            document.getElementById("namaUser").value = recipient_c;

            modal.find('.username').val(recipient_l);
            document.getElementById("username").value = recipient_l;

            var dateX = new Date(recipient_d);
            const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
            dayX = dateX.getDate();
            monthX = monthNames[dateX.getMonth()];
            yearX = dateX.getFullYear();


            modal.find('.ulangtahun').val(dayX+'-'+monthX+'-'+yearX);

            modal.find('.emailUser').val(recipient_e);
            document.getElementById("emailUser").value = recipient_e;

            modal.find('.nomorUser').val(recipient_f);
            document.getElementById("nomorUser").value = recipient_f;

            modal.find('.Jabatan').val(recipient_g);
            document.getElementById("Jabatan").value = recipient_g;
            $('.Jabatan').val(recipient_g).trigger('change');

            modal.find('.noRek').val(recipient_h);
            document.getElementById("noRek").value = recipient_h;

            modal.find('.bank').val(recipient_i);
            document.getElementById("bank").value = recipient_i;

            modal.find('.status').val(recipient_k);
            $('.status').val(recipient_k).trigger('change');
            //document.getElementById("status").value = recipient_k;

            modal.find('.alamatUser').val(recipient_j);
            document.getElementById("alamatUser").innerHTML = recipient_j;



            modal.find('.namaPanggilan').val(recipient_m);
            document.getElementById("namaPanggilan").value = recipient_m;

            modal.find('.mbti').val(recipient_n);
            $('.mbti').val(recipient_n).trigger('change');
            //document.getElementById("mbti").innerHTML = recipient_n;

            modal.find('.quotes').val(recipient_o);
            document.getElementById("quotes").value = recipient_o;

            modal.find('.JenisKelamin').val(recipient_p);
            document.getElementById("JenisKelamin").value = recipient_p;
            $('.JenisKelamin').val(recipient_p).trigger('change');

            modal.find('.emailPerusahaan').val(recipient_q);
            document.getElementById("emailPerusahaan").value = recipient_q;
            
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
                    useCurrent: false
                });

                $('#ulangtahun2').on('focus', function() {
                    if (!$(this).val()) {
                        $('#reservationdate2').datetimepicker('date', moment().subtract(25, 'years'));
                    }
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