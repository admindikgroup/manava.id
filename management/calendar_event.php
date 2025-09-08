<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Calendar | DIK Group</title>

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
        }



    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">



    

    <div class="modal fade" id="modal-delete-event">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Event ini ?<br>
                        Event Name &nbsp; : <b id="nama_event_delete"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_event_delete" id="id_dg_event_delete" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" onClick="deleteDataEvent()" class="btn btn-danger">Yes</button>
                    </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


<!-- Modal Edit Event-->
<div class="modal fade" id="modal-edit-event">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="edit_exampleModalLabel">Edit Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                <input type="hidden" class="form-control" id="id_dg_event" name="id_dg_event">
                    <!-- Title and Background Color -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="eventTitle" class="col-12 col-form-label">Title</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="edit_eventTitle" name="eventTitle" placeholder="Event Title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="backgroundColor" class="col-12 col-form-label">Background Color</label>
                            <div class="col-12">
                                <input type="color" class="form-control colorpicker" id="edit_backgroundColor" name="backgroundColor" placeholder="Select Background Color">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <label for="userGroup" class="col-12 col-form-label">User Group</label>
                            <div class="col-12">
                                <select class="select2 form-control" id="userGroup_edit" name="userGroup" required>
                                    <option value="" disabled selected>-- Pilih User Group --</option>

                                        <?php 
                                            $result_head = mysqli_query($db2,"select * from `dg_user_group`");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                                $id_dg_user_group = $d_head['id_dg_user_group'];
                                        ?>
                                            
                                            <option value="<?php echo $d_head['id_dg_user_group']; ?>"><?php echo $d_head['nama_group']; ?></option>
                                                
                                        <?php } ?>
                                    

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <label for="summernote2" class="col-12 col-form-label">Detail Notes</label>
                            <div class="col-12">
                                <textarea id="summernote2" name="summernote2"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Event Type Selection -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="eventType" class="col-12 col-form-label">Event Type</label>
                            <div class="col-12">
                                <select class="select2 form-control" id="edit_eventType" name="eventType">
                                    <option value="" disabled selected>-- Pilih Tipe Event --</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="pick_date">Pick Date</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Options -->
                    <div id="edit_yearlyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="yearlyDate" class="col-6 col-form-label">Date</label>
                            <label for="yearlyMonth" class="col-6 col-form-label">Month</label>
                            <div class="col-6">
                                <select class="form-control select2" id="edit_yearlyDate" name="yearlyDate">
                                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="edit_yearlyMonth" name="yearlyMonth">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startYear" class="col-6 col-form-label">Start Year</label>
                            <label for="endYear" class="col-6 col-form-label">End Year</label>
                            <div class="col-6">
                                <select class="form-control select2" id="edit_startYear" name="startYear">
                                    <option value="">-</option>
                                    <?php for ($i=2020; $i <=(date('Y')+10) ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="edit_endYear" name="endYear">
                                    <option value="9999">-</option>
                                    <?php for ($i=2020; $i <=(date('Y')+10) ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTime" class="col-6 col-form-label">Start Time</label>
                            <label for="endTime" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_startTime" name="startTime">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_endTime" name="endTime">
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Options -->
                    <div id="edit_monthlyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="monthlyDate" class="col-12 col-form-label">Date</label>
                            <div class="col-12">
                                <select class="form-control select2" id="edit_monthlyDate" name="monthlyDate">
                                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startMonthYear" class="col-6 col-form-label">Start Month/Year</label>
                            <label for="endMonthYear" class="col-6 col-form-label">End Month/Year</label>
                            <div class="col-6">
                                <input type="month" class="form-control" id="edit_startMonthYear" name="startMonthYear">
                            </div>
                            <div class="col-6">
                                <input type="month" class="form-control" id="edit_endMonthYear" name="endMonthYear">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeMonthly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeMonthly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_startTimeMonthly" name="startTimeMonthly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_endTimeMonthly" name="endTimeMonthly">
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Options -->
                    <div id="edit_weeklyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label class="col-12 col-form-label">Days of the Week</label>
                            <div class="col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_monday" name="dow_edit[]" value="2">
                                    <label class="form-check-label" for="edit_monday">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_tuesday" name="dow_edit[]" value="3">
                                    <label class="form-check-label" for="edit_tuesday">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_wednesday" name="dow_edit[]" value="4">
                                    <label class="form-check-label" for="edit_wednesday">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_thursday" name="dow_edit[]" value="5">
                                    <label class="form-check-label" for="edit_thursday">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_friday" name="dow_edit[]" value="6">
                                    <label class="form-check-label" for="edit_friday">Friday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_saturday" name="dow_edit[]" value="7">
                                    <label class="form-check-label" for="edit_saturday">Saturday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="edit_sunday" name="dow_edit[]" value="1">
                                    <label class="form-check-label" for="edit_sunday">Sunday</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startDateWeekly" class="col-6 col-form-label">Start Date</label>
                            <label for="endDateWeekly" class="col-6 col-form-label">End Date</label>
                            <div class="col-6">
                                <input type="date" class="form-control" id="edit_startDateWeekly" name="startDateWeekly">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="edit_endDateWeekly" name="endDateWeekly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeWeekly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeWeekly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_startTimeWeekly" name="startTimeWeekly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_endTimeWeekly" name="endTimeWeekly">
                            </div>
                        </div>
                    </div>

                    <!-- Pick Date Options -->
                    <div id="edit_pickDateOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="startDate" class="col-6 col-form-label">Start Date</label>
                            <label for="endDate" class="col-6 col-form-label">End Date</label>
                            <div class="col-6">
                                <input type="date" class="form-control" id="edit_startDate" name="startDate">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="edit_endDate" name="endDate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeDayly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeDayly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_startTimeDayly" name="startTimeDayly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="edit_endTimeDayly" name="endTimeDayly">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="editEventButton" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


    
<!-- Modal -->
<div class="modal fade" id="modal-add-event">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Add Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Title and Background Color -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="eventTitle" class="col-12 col-form-label">Title</label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Event Title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="backgroundColor" class="col-12 col-form-label">Background Color</label>
                            <div class="col-12">
                                <input type="color" class="form-control colorpicker" id="backgroundColor" name="backgroundColor" placeholder="Select Background Color">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <label for="userGroup" class="col-12 col-form-label">User Group</label>
                            <div class="col-12">
                                <select class="select2 form-control" id="userGroup" name="userGroup" required>
                                    <option value="" disabled selected>-- Pilih User Group --</option>

                                        <?php 
                                            $result_head = mysqli_query($db2,"select * from `dg_user_group`");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                                $id_dg_user_group = $d_head['id_dg_user_group'];
                                        ?>
                                            
                                            <option value="<?php echo $d_head['id_dg_user_group']; ?>"><?php echo $d_head['nama_group']; ?></option>
                                                
                                        <?php } ?>
                                    

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group row">
                            <label for="summernote" class="col-12 col-form-label">Detail Notes</label>
                            <div class="col-12">
                                <textarea id="summernote" name="summernote"></textarea>
                            </div>
                        </div>
                    </div>

                   
                    

                    <!-- Event Type Selection -->
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="eventType" class="col-12 col-form-label">Event Type</label>
                            <div class="col-12">
                                <select class="select2 form-control" id="eventType" name="eventType">
                                    <option value="" disabled selected>-- Pilih Tipe Event --</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="pick_date">Pick Date</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Options -->
                    <div id="yearlyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="yearlyDate" class="col-6 col-form-label">Date</label>
                            <label for="yearlyMonth" class="col-6 col-form-label">Month</label>
                            <div class="col-6">
                                <select class="form-control select2" id="yearlyDate" name="yearlyDate">
                                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="yearlyMonth" name="yearlyMonth">
                                    <option value="1" selected>January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startYear" class="col-6 col-form-label">Start Year</label>
                            <label for="endYear" class="col-6 col-form-label">End Year</label>
                            <div class="col-6">
                                <select class="form-control select2" id="startYear" name="startYear">
                                    <option value="">-</option>
                                    <?php for ($i=2020; $i <=(date('Y')+10) ; $i++) { ?>
                                        <option <?php if($i==date('Y')){echo "selected"; }; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="endYear" name="endYear">
                                    <option value="">-</option>
                                    <?php for ($i=2020; $i <=(date('Y')+10) ; $i++) { ?>
                                        <option <?php if($i==date('Y')){echo "selected"; }; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTime" class="col-6 col-form-label">Start Time</label>
                            <label for="endTime" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="startTime" name="startTime">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="endTime" name="endTime">
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Options -->
                    <div id="monthlyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="monthlyDate" class="col-12 col-form-label">Date</label>
                            <div class="col-12">
                                <select class="form-control select2" id="monthlyDate" name="monthlyDate">
                                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startMonthYear" class="col-6 col-form-label">Start Month/Year</label>
                            <label for="endMonthYear" class="col-6 col-form-label">End Month/Year</label>
                            <div class="col-6">
                                <input type="month" class="form-control" id="startMonthYear" name="startMonthYear">
                            </div>
                            <div class="col-6">
                                <input type="month" class="form-control" id="endMonthYear" name="endMonthYear">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeMonthly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeMonthly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="startTimeMonthly" name="startTimeMonthly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="endTimeMonthly" name="endTimeMonthly">
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Options -->
                    <div id="weeklyOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label class="col-12 col-form-label">Days of the Week</label>
                            <div class="col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="monday" name="dow[]" value="2">
                                    <label class="form-check-label" for="monday">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tuesday" name="dow[]" value="3">
                                    <label class="form-check-label" for="tuesday">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="wednesday" name="dow[]" value="4">
                                    <label class="form-check-label" for="wednesday">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="thursday" name="dow[]" value="5">
                                    <label class="form-check-label" for="thursday">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="friday" name="dow[]" value="6">
                                    <label class="form-check-label" for="friday">Friday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="saturday" name="dow[]" value="7">
                                    <label class="form-check-label" for="saturday">Saturday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="sunday" name="dow[]" value="1">
                                    <label class="form-check-label" for="sunday">Sunday</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startDateWeekly" class="col-6 col-form-label">Start Date</label>
                            <label for="endDateWeekly" class="col-6 col-form-label">End Date</label>
                            <div class="col-6">
                                <input type="date" class="form-control" id="startDateWeekly" name="startDateWeekly">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="endDateWeekly" name="endDateWeekly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeWeekly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeWeekly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="startTimeWeekly" name="startTimeWeekly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="endTimeWeekly" name="endTimeWeekly">
                            </div>
                        </div>
                    </div>

                    <!-- Pick Date Options -->
                    <div id="pickDateOptions" class="col-12" style="display: none;">
                        <div class="form-group row">
                            <label for="startDate" class="col-6 col-form-label">Start Date</label>
                            <label for="endDate" class="col-6 col-form-label">End Date</label>
                            <div class="col-6">
                                <input type="date" class="form-control" id="startDate" name="startDate">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control" id="endDate" name="endDate">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="startTimeDayly" class="col-6 col-form-label">Start Time</label>
                            <label for="endTimeDayly" class="col-6 col-form-label">End Time</label>
                            <div class="col-6">
                                <input type="time" class="form-control" id="startTimeDayly" name="startTimeDayly">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control" id="endTimeDayly" name="endTimeDayly">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit"  id="addEventButton" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts to Show/Hide Options -->
<script>
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

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi select2
        $('#eventType').select2();

        // Event listener untuk select2
        $('#eventType').on('change', function() {
            var value = $(this).val();
            document.getElementById('yearlyOptions').style.display = value === 'yearly' ? 'block' : 'none';
            document.getElementById('monthlyOptions').style.display = value === 'monthly' ? 'block' : 'none';
            document.getElementById('weeklyOptions').style.display = value === 'weekly' ? 'block' : 'none';
            document.getElementById('pickDateOptions').style.display = value === 'pick_date' ? 'block' : 'none';
        });

        // Inisialisasi tampilan opsi berdasarkan nilai awal #eventType saat halaman dimuat
        function updateOptionsDisplay() {
            var value = $('#edit_eventType').val();
            document.getElementById('edit_yearlyOptions').style.display = value === 'yearly' ? 'block' : 'none';
            document.getElementById('edit_monthlyOptions').style.display = value === 'monthly' ? 'block' : 'none';
            document.getElementById('edit_weeklyOptions').style.display = value === 'weekly' ? 'block' : 'none';
            document.getElementById('edit_pickDateOptions').style.display = value === 'pick_date' ? 'block' : 'none';
        }

        function clearEditEventModal(eventType) {
          // Kosongkan semua field dalam option yang dipilih
            if (eventType === 'yearly') {
                $('#edit_yearlyDate').val('').trigger('change');
                $('#edit_yearlyMonth').val('').trigger('change');
                $('#edit_startYear').val('').trigger('change');
                $('#edit_endYear').val('').trigger('change');
                $('#edit_startTime').val('');
                $('#edit_endTime').val('');
            } else if (eventType === 'monthly') {
                $('#edit_monthlyDate').val('').trigger('change');
                $('#edit_startMonthYear').val('').trigger('change');
                $('#edit_endMonthYear').val('').trigger('change');
                $('#edit_startTimeMonthly').val('');
                $('#edit_endTimeMonthly').val('');
            } else if (eventType === 'weekly') {
                $('#edit_monday').prop('checked', false);
                $('#edit_tuesday').prop('checked', false);
                $('#edit_wednesday').prop('checked', false);
                $('#edit_thursday').prop('checked', false);
                $('#edit_friday').prop('checked', false);
                $('#edit_saturday').prop('checked', false);
                $('#edit_sunday').prop('checked', false);
                $('#edit_startDateWeekly').val('');
                $('#edit_endDateWeekly').val('');
                $('#edit_startTimeWeekly').val('');
                $('#edit_endTimeWeekly').val('');
            } else if (eventType === 'pick_date') {
                $('#edit_startDate').val('');
                $('#edit_endDate').val('');
                $('#edit_startTimeDayly').val('');
                $('#edit_endTimeDayly').val('');
            }

        }


        // Event listener untuk select2
        $('#edit_eventType').change(function() {
            var selectedType = $(this).val();
            updateOptionsDisplay();
            clearEditEventModal(selectedType);
            
        });
        

        
    });




    // Fungsi untuk set default menit ke 00 saat diklik
    function setDefaultMinutesToZero(inputId) {
        document.getElementById(inputId).addEventListener('click', function() {
            if (!this.value) {
                this.value = "12:00"; // Set default ke 00:00 jika tidak ada nilai yang diinputkan sebelumnya
            } 
        });
    }

    // Set default menit ke 00 untuk semua input waktu
    setDefaultMinutesToZero('startTime');
    setDefaultMinutesToZero('endTime');
    setDefaultMinutesToZero('startTimeMonthly');
    setDefaultMinutesToZero('endTimeMonthly');
    setDefaultMinutesToZero('startTimeWeekly');
    setDefaultMinutesToZero('endTimeWeekly');
    setDefaultMinutesToZero('startTimeDayly');
    setDefaultMinutesToZero('endTimeDayly');


    setDefaultMinutesToZero('edit_startTime');
    setDefaultMinutesToZero('edit_endTime');
    setDefaultMinutesToZero('edit_startTimeMonthly');
    setDefaultMinutesToZero('edit_endTimeMonthly');
    setDefaultMinutesToZero('edit_startTimeWeekly');
    setDefaultMinutesToZero('edit_endTimeWeekly');
    setDefaultMinutesToZero('edit_startTimeDayly');
    setDefaultMinutesToZero('edit_endTimeDayly');

    document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi select2
    $('#eventType').select2();

    // Event listener untuk select2
    $('#eventType').on('change', function() {
        var value = $(this).val();
        document.getElementById('yearlyOptions').style.display = value === 'yearly' ? 'block' : 'none';
        document.getElementById('monthlyOptions').style.display = value === 'monthly' ? 'block' : 'none';
        document.getElementById('weeklyOptions').style.display = value === 'weekly' ? 'block' : 'none';
        document.getElementById('pickDateOptions').style.display = value === 'pick_date' ? 'block' : 'none';
    });


        // Inisialisasi select2
        $('#edit_eventType').select2();

        // Event listener untuk select2
        $('#edit_eventType').on('change', function() {
            var value = $(this).val();
            document.getElementById('edit_yearlyOptions').style.display = value === 'yearly' ? 'block' : 'none';
            document.getElementById('edit_monthlyOptions').style.display = value === 'monthly' ? 'block' : 'none';
            document.getElementById('edit_weeklyOptions').style.display = value === 'weekly' ? 'block' : 'none';
            document.getElementById('edit_pickDateOptions').style.display = value === 'pick_date' ? 'block' : 'none';
        });

            
    // Validasi untuk end time, end year, dan end month/year
    document.getElementById('addEventButton').addEventListener('click', function(event) {
        var isValid = true;

        // Validasi untuk Yearly: end time harus lebih besar dari start time
        var startTimeYearly = document.getElementById('startTime').value;
        var endTimeYearly = document.getElementById('endTime').value;
        if (startTimeYearly && endTimeYearly && startTimeYearly > endTimeYearly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Yearly Options.');
        }

        // Validasi untuk Monthly: end time harus lebih besar dari start time
        var startTimeMonthly = document.getElementById('startTimeMonthly').value;
        var endTimeMonthly = document.getElementById('endTimeMonthly').value;
        if (startTimeMonthly && endTimeMonthly && startTimeMonthly > endTimeMonthly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Monthly Options.');
        }

        // Validasi untuk Weekly: end time harus lebih besar dari start time
        var startTimeWeekly = document.getElementById('startTimeWeekly').value;
        var endTimeWeekly = document.getElementById('endTimeWeekly').value;
        if (startTimeWeekly && endTimeWeekly && startTimeWeekly > endTimeWeekly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Weekly Options.');
        }

        // Validasi untuk Pick Date: end time harus lebih besar dari start time
        var startTimeDayly = document.getElementById('startTimeDayly').value;
        var endTimeDayly = document.getElementById('endTimeDayly').value;
        if (startTimeDayly && endTimeDayly && startTimeDayly > endTimeDayly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Pick Date Options.');
        }

        // Validasi untuk Yearly: end year harus lebih besar dari start year
        var startYear = document.getElementById('startYear').value;
        var endYear = document.getElementById('endYear').value;
        if (startYear && endYear && startYear > endYear) {
            isValid = false;
            toastr.error('End Year should be greater than Start Year in Yearly Options.');
        }

        // Validasi untuk Monthly: end month/year harus lebih besar dari start month/year
        var startMonthYear = document.getElementById('startMonthYear').value;
        var endMonthYear = document.getElementById('endMonthYear').value;
        if (startMonthYear && endMonthYear && startMonthYear > endMonthYear) {
            isValid = false;
            toastr.error('End Month/Year should be greater than Start Month/Year in Monthly Options.');
        }
        
        // === VALIDASI TAMBAHAN ===

        // Title tidak boleh kosong
        var title = document.getElementById('eventTitle').value.trim();
        if (!title) {
            isValid = false;
            toastr.error('Title cannot be empty.');
        }

        // Background Color tidak boleh kosong
        var backgroundColor = document.getElementById('backgroundColor').value;
        if (!backgroundColor) {
            isValid = false;
            toastr.error('Background Color cannot be empty.');
        }

        // User Group tidak boleh kosong
        var userGroup = document.getElementById('userGroup').value;
        if (!userGroup) {
            isValid = false;
            toastr.error('User Group must be selected.');
        }

        // Summernote (pesan) tidak boleh kosong
        var message = $('#summernote').summernote('isEmpty') ? '' : $('#summernote').summernote('code');
        if (!message || message === '<p><br></p>') {
            isValid = false;
            toastr.error('Detail Notes cannot be empty.');
        }

        // Jika ada validasi yang gagal, cegah form submit
        if (!isValid) {
            event.preventDefault();
        }else{
            saveDataEvent();
        }
    });

    // Validasi untuk end time, end year, dan end month/year
    document.getElementById('editEventButton').addEventListener('click', function(event) {
        var isValid = true;

        // Validasi untuk Yearly: end time harus lebih besar dari start time
        var startTimeYearly = document.getElementById('edit_startTime').value;
        var endTimeYearly = document.getElementById('edit_endTime').value;
        if (startTimeYearly && endTimeYearly && startTimeYearly > endTimeYearly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Yearly Options.');
        }

        // Validasi untuk Monthly: end time harus lebih besar dari start time
        var startTimeMonthly = document.getElementById('edit_startTimeMonthly').value;
        var endTimeMonthly = document.getElementById('edit_endTimeMonthly').value;
        if (startTimeMonthly && endTimeMonthly && startTimeMonthly > endTimeMonthly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Monthly Options.');
        }

        // Validasi untuk Weekly: end time harus lebih besar dari start time
        var startTimeWeekly = document.getElementById('edit_startTimeWeekly').value;
        var endTimeWeekly = document.getElementById('edit_endTimeWeekly').value;
        if (startTimeWeekly && endTimeWeekly && startTimeWeekly > endTimeWeekly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Weekly Options.');
        }

        // Validasi untuk Pick Date: end time harus lebih besar dari start time
        var startTimeDayly = document.getElementById('edit_startTimeDayly').value;
        var endTimeDayly = document.getElementById('edit_endTimeDayly').value;
        if (startTimeDayly && endTimeDayly && startTimeDayly > endTimeDayly) {
            isValid = false;
            toastr.error('End Time should be greater than Start Time in Pick Date Options.');
        }

        // Validasi untuk Yearly: end year harus lebih besar dari start year
        var startYear = document.getElementById('edit_startYear').value;
        var endYear = document.getElementById('edit_endYear').value;
        if (startYear && endYear && startYear > endYear) {
            isValid = false;
            toastr.error('End Year should be greater than Start Year in Yearly Options.');
        }

        // Validasi untuk Monthly: end month/year harus lebih besar dari start month/year
        var startMonthYear = document.getElementById('edit_startMonthYear').value;
        var endMonthYear = document.getElementById('edit_endMonthYear').value;
        if (startMonthYear && endMonthYear && startMonthYear > endMonthYear) {
            isValid = false;
            toastr.error('End Month/Year should be greater than Start Month/Year in Monthly Options.');
        }

        // Jika ada validasi yang gagal, cegah form submit
        if (!isValid) {
            event.preventDefault();
        }else{
            saveEditDataEvent();
        }
    });
});



</script>


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
                            <h1 class="m-0">Management Events</h1>
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
                                            data-target="#modal-add-event" data-backdrop="static" data-keyboard="false">
                                            + Add Data
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th style="width: 15%;">Event Name</th>
                                                <th>Event Type</th>
                                                <th style="width: 20%;">Repetition</th>
                                                <th>Start-End Time</th>
                                                <th style="width: 10%;">Time</th>
                                                <th>Background Color</th>
                                                <th style="width: 15%; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableCalendarBody">
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
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>

    <!-- Page specific script -->
    <script>

        $(function () {
            // Summernote
            $('#summernote').summernote({
                height: 350, //set editable area's height
                placeholder: 'Ketikan sesuatu disini...',
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
            $('#summernote2').summernote({
                height: 350, //set editable area's height
                placeholder: 'Ketikan sesuatu disini...',
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
        });



        $(document).ready(function() {

            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "paging": true,
                "sorting": false,
                "buttons": false,
                "pageLength": 15,
                "searching": true,
                "scrollX": true
            });

            function loadCalendarEvents() {
                $.ajax({
                    url: 'view/table/table_calendar_event.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Buat array untuk menyimpan data tabel
                        let tableData = [];

                        // Loop untuk memformat data
                        data.forEach(function(event) {
                            tableData.push([
                                event.no,
                                event.nama_event,
                                event.type_event,
                                event.pengulangan,
                                event.waktu_mulai_akhir,
                                event.pukul,
                                `<div style="width: 20px; height: 20px; background-color: ${event.background_color}; border: 1px solid #000; display: inline-block;"></div> ${event.background_color}`,
                                `<button class="btn btn-info btn-sm" ${event.actions.edit.show}
                                            data-a="${event.actions.edit.id}"
                                            data-b="${event.actions.edit.nama_event}"
                                            data-c="${event.actions.edit.type_event}"
                                            data-d="${event.actions.edit.background_color}"
                                            data-e="${event.actions.edit.tanggal}"
                                            data-f="${event.actions.edit.bulan}"
                                            data-g="${event.actions.edit.start_year}"
                                            data-h="${event.actions.edit.finish_year}"
                                            data-i="${event.actions.edit.start_month}"
                                            data-j="${event.actions.edit.finish_month}"
                                            data-k="${event.actions.edit.start_date}"
                                            data-l="${event.actions.edit.finish_date}"
                                            data-m="${event.actions.edit.start_time}"
                                            data-n="${event.actions.edit.finish_time}"
                                            data-o="${event.actions.edit.weekly_dow}"
                                            data-p="${event.actions.edit.id_dg_user_group}"
                                            data-q="${event.actions.edit.summernote}"
                                data-backdrop="static" data-keyboard="false"
                                data-toggle="modal" data-target="#modal-edit-event"><i class="fas fa-pencil-alt"></i> Edit</button>
                                <button class="btn btn-danger btn-sm" ${event.actions.edit.show}
                                            data-c="${event.actions.delete.id}"
                                            data-v="${event.actions.delete.nama_event}"
                                data-toggle="modal" data-target="#modal-delete-event"><i class="fas fa-trash"></i></button>`
                            ]);
                        });

                        // Memuat data ke DataTable
                        let table = $('#example1').DataTable();
                        table.clear();
                        table.rows.add(tableData);
                        table.draw();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Panggil fungsi loadCalendarEvents saat halaman pertama kali dimuat
            loadCalendarEvents();
            setInterval(loadCalendarEvents, 3000); // Cek setiap 3 detik


            // Cek koneksi
            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik
        });


     
        $('#modal-add-event').on('hidden.bs.modal', function (event) {
                // Clear input fields
                $(this).find('input[type="text"], input[type="time"], input[type="date"], input[type="color"], select').val('');
                
                // Clear Summernote content (assuming summernote is applied on textarea)
                $(this).find('#summernote').summernote('code', '');

                // Reset select2 fields
                $(this).find('select.select2').val(null).trigger('change');
                
                // Clear checkboxes
                $(this).find('input[type="checkbox"]').prop('checked', false);
                
                // Hide all conditional fields
                $('#yearlyOptions').hide();
                $('#monthlyOptions').hide();
                $('#weeklyOptions').hide();
                $('#pickDateOptions').hide();
                
                // Reset to the default event type option
                $('#eventType').val('').trigger('change');
        });



       function saveDataEvent() {
            // Ambil nilai dari input umum
            var eventTitle = document.getElementById("eventTitle").value;
            var backgroundColor = document.getElementById("backgroundColor").value;
            var userGroup = document.getElementById("userGroup").value;
            var summernote = encodeURIComponent(document.getElementById("summernote").value);
            var eventType = document.getElementById("eventType").value;
            var created_by = <?php echo $id_user;?>;

            // Variabel untuk menyimpan data spesifik berdasarkan eventType
            var eventData = {};

            // Ambil data berdasarkan tipe event
            if (eventType === 'yearly') {
                eventData.yearlyDate = document.getElementById("yearlyDate").value;
                eventData.yearlyMonth = document.getElementById("yearlyMonth").value;
                eventData.startYear = document.getElementById("startYear").value;
                eventData.endYear = document.getElementById("endYear").value || 9999;
                eventData.startTime = document.getElementById("startTime").value;
                eventData.endTime = document.getElementById("endTime").value;
            } else if (eventType === 'monthly') {
                eventData.monthlyDate = document.getElementById("monthlyDate").value;
                eventData.startMonthYear = document.getElementById("startMonthYear").value;
                eventData.endMonthYear = document.getElementById("endMonthYear").value || "9999-12";
                eventData.startTime = document.getElementById("startTimeMonthly").value;
                eventData.endTime = document.getElementById("endTimeMonthly").value;
            } else if (eventType === 'weekly') {
                eventData.dow = [];
                document.querySelectorAll('input[name="dow[]"]:checked').forEach(function(checkbox) {
                    eventData.dow.push(checkbox.value);
                });
                eventData.startDate = document.getElementById("startDateWeekly").value;
                eventData.endDate = document.getElementById("endDateWeekly").value || "9999-12-31";
                eventData.startTime = document.getElementById("startTimeWeekly").value;
                eventData.endTime = document.getElementById("endTimeWeekly").value;
            } else if (eventType === 'pick_date') {
                eventData.startDate = document.getElementById("startDate").value;
                eventData.endDate = document.getElementById("endDate").value || "9999-12-31";
                eventData.startTime = document.getElementById("startTimeDayly").value;
                eventData.endTime = document.getElementById("endTimeDayly").value;
            }

            // Validasi input - contoh validasi sederhana
            if (!eventTitle || !eventType) {
                toastr.error('Please fill out all required fields.');
                return;
            }

            // Kirim data menggunakan AJAX
            $.ajax({
                url: 'controller/conn_add_event.php', // URL ke file PHP yang memproses data
                method: 'POST',
                data: {
                    eventTitle: eventTitle,
                    backgroundColor: backgroundColor,
                    eventType: eventType,
                    summernote: summernote,
                    userGroup: userGroup,
                    eventData: eventData,
                    created_by : created_by
                },
                dataType: 'html',
                success: function(response) {
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (!response.includes('Error')) {
                        toastr.success('Event berhasil disimpan.');
                    } else {
                        toastr.error('Event gagal disimpan !<br>' + response);
                    }
                    $('#modal-add-event').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan
                    toastr.error('Event gagal disimpan !<br>' + error);
                }
            });
        }

        function saveEditDataEvent() {
            // Ambil nilai dari input umum
            var eventTitle = document.getElementById("edit_eventTitle").value;
            var backgroundColor = document.getElementById("edit_backgroundColor").value;
            var userGroup = document.getElementById("userGroup_edit").value;
            var summernote = encodeURIComponent(document.getElementById("summernote2").value);
            var eventType = document.getElementById("edit_eventType").value;
            var created_by = <?php echo $id_user;?>;
            var id_dg_event = document.getElementById("id_dg_event").value;
            

            // Variabel untuk menyimpan data spesifik berdasarkan eventType
            var eventData = {};

            // Ambil data berdasarkan tipe event
            if (eventType === 'yearly') {
                eventData.yearlyDate = document.getElementById("edit_yearlyDate").value;
                eventData.yearlyMonth = document.getElementById("edit_yearlyMonth").value;
                eventData.startYear = document.getElementById("edit_startYear").value;
                eventData.endYear = document.getElementById("edit_endYear").value || 9999;
                eventData.startTime = document.getElementById("edit_startTime").value;
                eventData.endTime = document.getElementById("edit_endTime").value;
            } else if (eventType === 'monthly') {
                eventData.monthlyDate = document.getElementById("edit_monthlyDate").value;
                eventData.startMonthYear = document.getElementById("edit_startMonthYear").value;
                eventData.endMonthYear = document.getElementById("edit_endMonthYear").value || "9999-12";
                eventData.startTime = document.getElementById("edit_startTimeMonthly").value;
                eventData.endTime = document.getElementById("edit_endTimeMonthly").value;
            } else if (eventType === 'weekly') {
                eventData.dow = [];
                document.querySelectorAll('input[name="dow_edit[]"]:checked').forEach(function(checkbox) {
                    eventData.dow.push(checkbox.value);
                });
                eventData.startDate = document.getElementById("edit_startDateWeekly").value;
                eventData.endDate = document.getElementById("edit_endDateWeekly").value || "9999-12-31";

                
                eventData.startTime = document.getElementById("edit_startTimeWeekly").value;
                eventData.endTime = document.getElementById("edit_endTimeWeekly").value;
            } else if (eventType === 'pick_date') {
                eventData.startDate = document.getElementById("edit_startDate").value;
                eventData.endDate = document.getElementById("edit_endDate").value  || "9999-12-31";
                eventData.startTime = document.getElementById("edit_startTimeDayly").value;
                eventData.endTime = document.getElementById("edit_endTimeDayly").value;
            }

            // Validasi input - contoh validasi sederhana
            if (!eventTitle || !eventType) {
                toastr.error('Please fill out all required fields.');
                return;
            }

            // Kirim data menggunakan AJAX
            $.ajax({
                url: 'controller/conn_edit_event.php', // URL ke file PHP yang memproses data
                method: 'POST',
                data: {
                    eventTitle: eventTitle,
                    backgroundColor: backgroundColor,
                    eventType: eventType,
                    userGroup: userGroup,
                    summernote: summernote,
                    eventData: eventData,
                    created_by : created_by,
                    id_dg_event : id_dg_event
                },
                dataType: 'html',
                success: function(response) {
                    //console.log("eventData.endDate :", eventData.endDate);
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (!response.includes('Error')) {
                        toastr.success('Event berhasil diedit.');
                    } else {
                        toastr.error('Event gagal diedit db !<br>' + response);
                    }
                    $('#modal-edit-event').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan
                    toastr.error('Event gagal diedit controller !<br>' + error);
                }
            });
        }

        function deleteDataEvent() {
            // Ambil nilai dari input umum
            var id_dg_event_delete = document.getElementById("id_dg_event_delete").value;
            

            // Kirim data menggunakan AJAX
            $.ajax({
                url: 'controller/conn_delete_event.php', // URL ke file PHP yang memproses data
                method: 'POST',
                data: {
                    id_dg_event_delete : id_dg_event_delete
                },
                dataType: 'html',
                success: function(response) {
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (!response.includes('Error')) {
                        toastr.success('Event berhasil dihapus.');
                    } else {
                        toastr.error('Event gagal dihapus !<br>' + response);
                    }
                    $('#modal-delete-event').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan
                    toastr.error('Event gagal dihapus !<br>' + error);
                }
            });
        }



        $('#modal-delete-event').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');
            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_event_delete').val(recipient_c);
            document.getElementById("id_dg_event_delete").value = recipient_c;
            document.getElementById("nama_event_delete").innerHTML = recipient_v;
        })





        $('#modal-edit-event').on('show.bs.modal', function (event) {
            if ($(event.target).is('#modal-edit-event')) {
                var changeCount = 0;
                var button = $(event.relatedTarget); // Button that triggered the modal

                // Mengambil data dari atribut data-*
                var recipient_a = button.data('a'); // ID event
                var recipient_b = button.data('b'); // Nama event
                var recipient_c = button.data('c'); // Tipe event
                var recipient_d = button.data('d'); // Warna background
                var recipient_e = button.data('e'); // tanggal
                var recipient_f = button.data('f'); // bulan
                var recipient_g = button.data('g'); // start_year
                var recipient_h = button.data('h'); // finish_year
                var recipient_i = button.data('i'); // start_month
                var recipient_j = button.data('j'); // finish_month
                var recipient_k = button.data('k'); // start_date
                var recipient_l = button.data('l'); // finish_date
                var recipient_m = button.data('m'); // start_time
                var recipient_n = button.data('n'); // finish_time
                var recipient_o = button.data('o'); // finish_time
                var recipient_p = button.data('p'); // finish_time
                var recipient_q = button.data('q'); // finish_time

                if (recipient_i<10) {
                    recipient_i = '0' + recipient_i;
                }
                if (recipient_j<10) {
                    recipient_j = '0' + recipient_j;
                }

                // Memperbarui isi modal
                var modal = $(this);

                // Update ID event
                modal.find('#id_dg_event').val(recipient_a);
                modal.find('#edit_eventTitle').val(recipient_b);
                modal.find('#edit_eventType').val(recipient_c).trigger('change');
                modal.find('#edit_backgroundColor').val(recipient_d);
                modal.find('#summernote2').summernote('code', decodeURIComponent(recipient_q));
                modal.find('#userGroup_edit').val(recipient_p);

                // Sesuaikan tampilan berdasarkan tipe event yang dipilih
                switch (recipient_c) {
                    case 'yearly':

                        document.getElementById('edit_yearlyOptions').style.display = recipient_c === 'yearly' ? 'block' : 'none';
                        document.getElementById('edit_monthlyOptions').style.display = recipient_c === 'monthly' ? 'block' : 'none';
                        document.getElementById('edit_weeklyOptions').style.display = recipient_c === 'weekly' ? 'block' : 'none';
                        document.getElementById('edit_pickDateOptions').style.display = recipient_c === 'pick_date' ? 'block' : 'none';
                        
                        modal.find('#edit_yearlyDate').val(recipient_e).trigger('change');
                        modal.find('#edit_yearlyMonth').val(recipient_f).trigger('change');
                        modal.find('#edit_startYear').val(recipient_g).trigger('change');
                        modal.find('#edit_endYear').val(recipient_h === '9999' ? '' : recipient_h).trigger('change');

                        modal.find('#edit_startTime').val(recipient_m);
                        modal.find('#edit_endTime').val(recipient_n);
                        break;
                    case 'monthly':

                        document.getElementById('edit_yearlyOptions').style.display = recipient_c === 'yearly' ? 'block' : 'none';
                        document.getElementById('edit_monthlyOptions').style.display = recipient_c === 'monthly' ? 'block' : 'none';
                        document.getElementById('edit_weeklyOptions').style.display = recipient_c === 'weekly' ? 'block' : 'none';
                        document.getElementById('edit_pickDateOptions').style.display = recipient_c === 'pick_date' ? 'block' : 'none';
                        

                        modal.find('#edit_monthlyDate').val(recipient_e).trigger('change');
                        modal.find('#edit_startMonthYear').val(recipient_g+'-'+recipient_i).trigger('change');

                        let endMonthYear = recipient_h == '9999' ? '' : recipient_h + '-' + recipient_j;
                        modal.find('#edit_endMonthYear').val(endMonthYear).trigger('change');

                        modal.find('#edit_startTimeMonthly').val(recipient_m);
                        modal.find('#edit_endTimeMonthly').val(recipient_n);
                        break;
                    case 'weekly':

                        document.getElementById('edit_yearlyOptions').style.display = recipient_c === 'yearly' ? 'block' : 'none';
                        document.getElementById('edit_monthlyOptions').style.display = recipient_c === 'monthly' ? 'block' : 'none';
                        document.getElementById('edit_weeklyOptions').style.display = recipient_c === 'weekly' ? 'block' : 'none';
                        document.getElementById('edit_pickDateOptions').style.display = recipient_c === 'pick_date' ? 'block' : 'none';
                        
                        recipient_o = recipient_o+",0";
                        
                        // Mengonversi string "1,2,4" menjadi array
                        var dowArray = recipient_o.split(','); // Menghasilkan ["1", "2", "4"]

                        // Mengatur checkbox untuk hari-hari dalam minggu
                        $('input[name="dow_edit[]"]').each(function() {
                            // Memeriksa apakah nilai checkbox saat ini ada di dalam array
                            $(this).prop('checked', dowArray.includes($(this).val()));
                        });

                        modal.find('#edit_startDateWeekly').val(recipient_k).trigger('change');
                        modal.find('#edit_endDateWeekly').val(recipient_l.includes('9999') ? '' : recipient_l).trigger('change');

                        modal.find('#edit_startTimeWeekly').val(recipient_m);
                        modal.find('#edit_endTimeWeekly').val(recipient_n);
                        break;
                    case 'pick_date':

                        document.getElementById('edit_yearlyOptions').style.display = recipient_c === 'yearly' ? 'block' : 'none';
                        document.getElementById('edit_monthlyOptions').style.display = recipient_c === 'monthly' ? 'block' : 'none';
                        document.getElementById('edit_weeklyOptions').style.display = recipient_c === 'weekly' ? 'block' : 'none';
                        document.getElementById('edit_pickDateOptions').style.display = recipient_c === 'pick_date' ? 'block' : 'none';
                        

                        modal.find('#edit_startDate').val(recipient_k);
                        modal.find('#edit_endDate').val(recipient_l.includes('9999') ? '' : recipient_l);

                        modal.find('#edit_startTimeDayly').val(recipient_m);
                        modal.find('#edit_endTimeDayly').val(recipient_n);
                        break;
                    default:
                        $('#edit_yearlyOptions, #edit_monthlyOptions, #edit_weeklyOptions, #edit_pickDateOptions').hide();
                        break;
                }
                // Menghentikan AJAX sementara modal edit terbuka
                $('#modal-edit-event').on('show.bs.modal', function() {

                        $.ajaxSetup({ async: false });
                    
                });

                // Melanjutkan AJAX ketika modal ditutup
                $('#modal-edit-event').on('hidden.bs.modal', function() {

                        $.ajaxSetup({ async: true });
                        //clearEditEventModal(); // Clear the modal inputs when the modal is hidden
                        //$('#modal-edit-event select').off('change'); // Unbind the change event when modal is hidden
                    
                });
            }


            

  
        });       


        $('#modal-add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
            
        })

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