<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

date_default_timezone_set('Asia/Jakarta');

$bulanTahunTerpilih = isset($_GET['month']) ? $_GET['month'] : date('Y-m', strtotime('first day of next month'));

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar | DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="plugins/fullcalendar/main.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
        .padding-print{
            padding: 50px; 
            font-size: 15px;
        }
        @media print {
            .no-print {
                display: none;
            }
            .content-wrapper{
                background-color: #fff;
            }
            .padding-print{
                padding: 20px; 
                font-size: 12px;
            }
            .footer-print {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
            }
            


        }

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .fc .fc-daygrid-day-frame {
                min-height: 150px !important;
            }
            .modal-dialog{
                min-width: 1000px !important;
            }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .fc .fc-daygrid-day-frame {
                min-height: 50px !important;
            }
            .fc .fc-view-harness{
                min-height: 500px !important;
                overflow-x: scroll !important;
            }
            .fc .fc-view-harness-active > .fc-view{
                width: 1000px;
            }
        }

        /* CSS untuk menyembunyikan tombol X pada modal Summernote */
        .note-modal .close {
            display: none !important;
        }
        .fc-event-title {
            white-space: normal; /* Mengizinkan teks membungkus ke baris berikutnya */
            word-wrap: break-word; /* Memastikan kata yang panjang akan dibagi jika terlalu panjang untuk satu baris */
            overflow: hidden; /* Jika terjadi overflow, sembunyikan bagian yang keluar */
        }
        .fc table{
            font-size: 1em;
        }
        
    </style>
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- fullCalendar 6.1.15 -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<!-- Modal HTML -->
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
                                <select class="select2 form-control" id="userGroup" name="userGroup">
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
                            <label for="summernote" class="col-12 col-form-label">Pesan Notes</label>
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
                                    <?php for ($i=1980; $i <=(date('Y')+50) ; $i++) { ?>
                                        <option <?php if($i==date('Y')){echo "selected"; }; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="endYear" name="endYear">
                                    <?php for ($i=2020; $i <=(date('Y')+50) ; $i++) { ?>
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
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts to Show/Hide Options -->
<script>
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

    // Validasi untuk end time, end year, dan end month/year
    document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
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

        // Jika ada validasi yang gagal, cegah form submit
        if (!isValid) {
            event.preventDefault();
        }else{
            saveDataEvent();
        }
    });
});



</script>


   

    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header no-print">
                
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- Main content -->
                                    <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                        <div class="col-md-3">
                                            <div class="sticky-top mb-3 none">
                                            <div class="card">
                                                <div class="card-header">
                                                <h4 class="card-title">Draggable Events</h4>
                                                </div>
                                                <div class="card-body">
                                                <!-- the events -->
                                                <div id="external-events">
                                                    <div class="external-event bg-success">Lunch</div>
                                                    <div class="external-event bg-warning">Go home</div>
                                                    <div class="external-event bg-info">Do homework</div>
                                                    <div class="external-event bg-primary">Work on UI design</div>
                                                    <div class="external-event bg-danger">Sleep tight</div>
                                                    <div class="checkbox">
                                                    <label for="drop-remove">
                                                        <input type="checkbox" id="drop-remove">
                                                        remove after drop
                                                    </label>
                                                    </div>
                                                </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                            <div class="card">
                                                <div class="card-header">
                                                <h3 class="card-title">Create Event</h3>
                                                </div>
                                                <div class="card-body">
                                                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                                    <ul class="fc-color-picker" id="color-chooser">
                                                    <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                                    <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                                    <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                                    <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                                    <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                                    </ul>
                                                </div>
                                                <!-- /btn-group -->
                                                <div class="input-group">
                                                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                                    <div class="input-group-append">
                                                    <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                                                    </div>
                                                    <!-- /btn-group -->
                                                </div>
                                                <!-- /input-group -->
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-12">
                                            <div class="card card-primary">
                                            <div class="card-body p-0">
                                                <!-- THE CALENDAR -->
                                                <div id="calendar"></div>
                                            </div>
                                            <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div><!-- /.container-fluid -->
                                    </section>
                                    <!-- /.content -->


                                    <script>
                                        
                                        $(function () {
                                            // initialize the external events
                                            function ini_events(ele) {
                                                ele.each(function () {
                                                    var eventObject = {
                                                        title: $.trim($(this).text())
                                                    };
                                                    $(this).data('eventObject', eventObject);
                                                    $(this).draggable({
                                                        zIndex: 1070,
                                                        revert: true, 
                                                        revertDuration: 0 
                                                    });
                                                });
                                            }

                                            ini_events($('#external-events div.external-event'));

                                            var date = new Date();
                                            var d = date.getDate(),
                                                m = date.getMonth(),
                                                y = date.getFullYear();

                                            var Calendar = FullCalendar.Calendar;
                                            var Draggable = FullCalendar.Draggable;

                                            var containerEl = document.getElementById('external-events');
                                            var checkbox = document.getElementById('drop-remove');
                                            var calendarEl = document.getElementById('calendar');

                                            function getCurrentTimeForScroll() {
                                                var currentTime = new Date();
                                                var hours = currentTime.getHours();
                                                var minutes = currentTime.getMinutes();
                                                return hours + ':' + minutes + ':00';
                                            }

                                            var calendar = new Calendar(calendarEl, {
                                                headerToolbar: {
                                                    left: 'prev,next today',
                                                    center: 'title',
                                                    right: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay'
                                                },
                                                themeSystem: 'bootstrap',
                                                editable: false,
                                                droppable: false,
                                                views: {
                                                    multiMonthYear: {
                                                        type: 'multiMonth',
                                                        duration: { years: 1 },
                                                        buttonText: 'Year',
                                                        titleFormat: { year: 'numeric' },
                                                        dayHeaderFormat: { weekday: 'short' },
                                                    }
                                                },
                                                scrollTime: getCurrentTimeForScroll(),  // Set initial scroll to current time
                                                windowResize: function(view) {
                                                    if (window.innerWidth < 768) {
                                                        calendar.changeView('timeGridWeek');
                                                        calendar.setOption('scrollTime', getCurrentTimeForScroll());  // Update scroll time when view changes
                                                    }
                                                },
                                                dateClick: function (info) {
                                                    if (calendar.view.type === 'multiMonthYear') {
                                                        calendar.changeView('dayGridMonth', info.date);
                                                    }
                                                },
                                                drop: function (info) {
                                                    if (checkbox.checked) {
                                                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                                                    }
                                                }
                                            });

                                            setTimeout(function () {
                                                $('.fc-toolbar-chunk').eq(2).find('.fc-button-group').append('<button class="btn btn-success" name="add_event" title="Add Event" data-toggle="modal" data-target="#modal-add-event" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Add Event</button>');
                                            }, 100);

                                            calendar.render();

                                            window.calendar = calendar;

                                            if (window.innerWidth < 768) {
                                                calendar.changeView('timeGridWeek');
                                            }
                                        });


                                    </script>

                                <div class="TableCalendar">
                                        
                                </div>   
                                
                            </div>
                        </div>
                    </div>

                    
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Page specific script -->
    <script>

         // Fungsi untuk mengecek modal aktif setiap 1 detik
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
        }, 3000); // Cek setiap 1000 ms (3 detik)

        $(function () {
            // Summernote
            $('#summernote').summernote({
                height: 350, //set editable area's height
                placeholder: 'Ketikan sesuatu disini...',
                codemirror: { // codemirror options
                theme: 'monokai'
                }
            });
        });
  
        $('#modal-add-event').on('hidden.bs.modal', function () {
          
            // Clear input fields
            $(this).find('input[type="text"], input[type="time"], input[type="date"], input[type="color"], select').val('');
            
            // Reset select2 fields
            $(this).find('select.select2').val(null).trigger('change');

            // Clear Summernote content (assuming summernote is applied on textarea)
            $(this).find('#summernote').summernote('code', '');
            
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
                eventData.endMonthYear = document.getElementById("endMonthYear").value || "9999=-12";
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
            updateTanggal();
        }

         $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })



        })
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            // Fungsi untuk mengambil dan memperbarui event dari server
            function updateTanggal() {
                var currentView = window.calendar.view.type;

                // Lewati jika dalam tampilan multiMonthYear
                if (currentView === 'multiMonthYear' || currentView === 'multiMonth') {
                    console.log('Skipping AJAX call in multiMonth view');
                    return;
                }

                var currentStart = window.calendar.view.currentStart;
                var currentEnd = window.calendar.view.currentEnd;

                var currentYear = currentStart.getFullYear();
                var currentMonth = currentStart.getMonth() + 1;

                // Tambahkan nol di depan bulan jika kurang dari 10
                currentMonth = currentMonth < 10 ? '0' + currentMonth : currentMonth;

                $.ajax({
                    url: 'view/calendar/tableCalendar.php',
                    type: 'GET',
                    data: { 
                        currentYear: currentYear,
                        currentMonth: currentMonth
                    },
                    success: function(response) {
                        try {
                            // Dapatkan ID event dari server untuk memeriksa apakah sudah ada
                            var eventIdsFromServer = response.map(event => event.id);

                            // Tambahkan atau perbarui event yang diterima dari server
                            response.forEach(event => {
                                var existingEvent = window.calendar.getEventById(event.id);
                                if (existingEvent) {
                                    existingEvent.setProp('title', event.title);
                                    existingEvent.setStart(event.start);
                                    existingEvent.setEnd(event.end);
                                    existingEvent.setProp('backgroundColor', event.backgroundColor);
                                    existingEvent.setProp('borderColor', event.borderColor);
                                } else {
                                    window.calendar.addEvent(event);
                                }
                            });

                            // Hapus event yang tidak lagi ada di server
                            window.calendar.getEvents().forEach(existingEvent => {
                                if (!eventIdsFromServer.includes(existingEvent.id)) {
                                    existingEvent.remove();
                                }
                            });
                        } catch (e) {
                            console.error('Error processing events:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Inisialisasi kalender dan render
            updateTanggal();
            setInterval(updateTanggal, 10000);
            checkConnection();
            setInterval(checkConnection, 1000);

            // Menambahkan event listener pada tombol previous dan next
            $('.fc-prev-button, .fc-next-button').on('click', function() {
                // Panggil fungsi updateTanggal
                updateTanggal();
            });
        });

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