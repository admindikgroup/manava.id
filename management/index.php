
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<?php 
include 'view/common/first_validation.php';

// if (!strpos($current_url, 'dikgroup.id/management') && !strpos($current_url, 'localhost/dggroup2/management/index.php') && !strpos($current_url, 'localhost/dggroup2/management/')) {
//     header('Location: https://dikgroup.id/management');
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        .table td, .table th{
          padding: 0.5rem;
        }
        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
          .taskTableAdd{
            overflow: none;
          }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
          .taskTableAdd{
            overflow: auto;
          }
          .minWidth350{
            min-width: 350px;
          }
          .minWidth250{
            min-width: 250px;
          }
          .minWidth150{
            min-width: 150px;
          }
        }
    </style>
</head>
<?php echo "<a style='position: absolute;' href='controller/conn_logout.php'>Log Out</a>"; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-lg-6"></div><!-- /.col -->
                        <div class="col-lg-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-lg">
                            <p class="text-center" for="" style="font-size:32px; font-weight:semi-bold">
                                Dashboard Management
                            </p>

                            <div class="card card-purple card-info collapsed-card">
                                <div class="card-header" onclick="toggleCard(this)">
                                    <h3 class="card-title"><b>Notes</b></h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group" >

                                        <textarea style="width: 100%;" id="summernote" name="notes_project"></textarea>

                                        <!-- <div class="col-12 col-md-3 mb-2">
                                            <select class="form-control select division" style="width: 100%;" name="division" id="division">
                                                <option selected disabled value="">-Pilih Divisi-</option> 
                                                <option value="-1">Semua Divisi</option>    
                                                <?php 
                                                    $result_division = mysqli_query($db2,"select * from `dg_division`
                                                    where deleted_at is null");
                                                    while($d_division = mysqli_fetch_array($result_division)){
                                                ?>
                                                <option value="<?php echo $d_division['id_dg_division']; ?>"><?php echo $d_division['division_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> -->
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="card card-info">
                                        <div class="card-header" onclick="toggleCard(this)">
                                            <h3 class="card-title"><b>My Meeting Task - </b><b
                                                    class="month-meeting"></b></h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-lg-8 mb-2">
                                                    <div class="row">
                                                        <div class="mb-2 col-lg-4">
                                                            <input class="form-control" type="month" id="month_task"
                                                                value="<?php echo date('Y-m'); ?>" name="month_task">
                                                        </div>
                                                        <div class="mb-2 col-lg-8"></div>
                                                    </div>
                                                    <table id="taskTable" class="table table-bordered table-striped"
                                                        style="width: 100%; font-size: 15px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center; width: 10%;">No
                                                                </th>
                                                                <th class="minWidth350" style="width: 25%;">Task
                                                                </th>
                                                                <th class="minWidth250" style="width: 15%;">
                                                                    Deadline</th>
                                                                <th class="minWidth150" style="width: 15%;">
                                                                    Status</th>
                                                                <th class="minWidth150"
                                                                    style="text-align: center; width: 15%;">
                                                                    Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-4 mb-2">
                                                    <div
                                                        style="background-color: rgba(0, 0, 0, .03); padding-top: 30px; padding-bottom: 50px; position: sticky; top: 20px; z-index: 10;">
                                                        <canvas id="pieChart"
                                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        <div id="pieChartLegend"
                                                            style="text-align: center; margin-top: 15px;"></div>
                                                        <!-- Tempat legend custom -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p
                                                style="text-align: left; font-size: 15px; margin-left: 15px; margin-top: 15px;">
                                                Notes: <br>
                                                1. Task dengan status yang belum Done / Cancel, akan terus
                                                dimunculkan diatas ini meski memilih bulan yang lain.<br>
                                                2. Untuk membuka semua task, klik Calendar dan di pojok kiri
                                                bawah pilih "Clear".
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card card-purple">
                                        <div class="card-header" onclick="toggleCard(this)">
                                            <h3 class="card-title"><b>User Meeting Task - </b><b
                                                    class="month-meeting-user"></b></h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-lg-8 mb-2">
                                                    <div class="row">
                                                        <div class="mb-2 col-lg-4">
                                                            <input class="form-control" type="month"
                                                                id="month_task_user" value="<?php echo date('Y-m'); ?>"
                                                                name="month_task_user">
                                                        </div>
                                                        <div class="mb-2 col-lg-8 select2-purple">
                                                            <select data-placeholder="Select user's"
                                                                style="font-size: 12px; width: 100%;"
                                                                multiple="multiple" class="select2"
                                                                name="select_users[]" id="select_users">
                                                                <?php 
                                                                        $result_head = mysqli_query($db2,"select * from `dg_user`
                                                                        where deleted_at is null and status < 6");
                                                                        while($d_head = mysqli_fetch_array($result_head)){
                                                                    ?>
                                                                <option value="<?php echo $d_head['id_dg_user']; ?>">
                                                                    <?php echo $d_head['nama']; ?></option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <table id="userTaskTable" class="table table-bordered table-striped"
                                                        style="width: 100%; font-size: 15px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center; width: 10%;">No
                                                                </th>
                                                                <th class="minWidth150" style="width: 15%;">Name
                                                                </th>
                                                                <th class="minWidth350" style="width: 25%;">Task
                                                                </th>
                                                                <th class="minWidth250" style="width: 15%;">
                                                                    Deadline</th>
                                                                <th class="minWidth150" style="width: 15%;">
                                                                    Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-4 mb-2">
                                                    <div
                                                        style="background-color: rgba(0, 0, 0, .03); padding-top: 30px; padding-bottom: 50px; position: sticky; top: 20px; z-index: 10;">
                                                        <canvas id="pieChartUser"
                                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        <div id="pieChartUserLegend"
                                                            style="text-align: center; margin-top: 15px;"></div>
                                                        <!-- Tempat legend custom -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p
                                                style="text-align: left; font-size: 15px; margin-left: 15px; margin-top: 15px;">
                                                Notes: <br>
                                                1. Untuk melihat status task per user, bisa select peruser di
                                                bagian filter.<br>
                                                2. Untuk membuka semua task, klik Calendar dan di pojok kiri
                                                bawah pilih "Clear".
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="card card-red">
                                        <div class="card-header" onclick="toggleCard(this)">
                                            <h3 class="card-title"><b>Teamspace Task</b></h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-lg-8 mb-2">
                                                    <div class="row">
                                                        <div class="mb-2 col-lg-6 select2-red">
                                                            <select data-placeholder="Select Teamspace's"
                                                                style="font-size: 12px; width: 100%;"
                                                                multiple="multiple" class="select2"
                                                                name="select_teamspace[]" id="select_teamspace">
                                                                    <?php 
                                                                        $result_head = mysqli_query($db2,"select * from `dg_client_project` dcp
                                                                        inner join `dg_client` dc on dcp.id_dg_client = dc.id_dg_client
                                                                        where dcp.deleted_by is null and dcp.is_active = 1
                                                                        ORDER BY dc.nama_client ASC, dcp.id_dg_client_project DESC");
                                                                        while($d_head = mysqli_fetch_array($result_head)){
                                                                    ?>
                                                                <option value="<?php echo $d_head['id_dg_client_project']; ?>">
                                                                <?php echo $d_head['nama_client']; ?> | <?php echo $d_head['nama_project']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-2 col-lg-6 select2-purple">
                                                            <select data-placeholder="Select Sprint but Select a Teamspace first"
                                                                style="font-size: 12px; width: 100%;"
                                                                multiple="multiple" class="select2"
                                                                name="select_sprint[]" id="select_sprint">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <table id="teamSpaceTaskTable" class="table table-bordered table-striped"
                                                        style="width: 100%; font-size: 15px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center; width: 10%;">No
                                                                </th>
                                                                <th class="minWidth150" style="width: 15%;">PIC
                                                                </th>
                                                                <th class="minWidth350" style="width: 25%;">Task
                                                                </th>
                                                                <th class="minWidth250" style="width: 15%;">
                                                                    Deadline</th>
                                                                <th class="minWidth150" style="width: 15%;">
                                                                    Status</th>
                                                                <th class="minWidth150" style="width: 15%; text-align: center;">
                                                                    Finish</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-4 mb-2">
                                                    <div
                                                        style="background-color: rgba(0, 0, 0, .03); padding-top: 30px; padding-bottom: 50px; position: sticky; top: 20px; z-index: 10;">
                                                        <canvas id="pieChartTeamSpace"
                                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        <div id="pieChartTeamSpaceLegend"
                                                            style="text-align: center; margin-top: 15px;"></div>
                                                        <!-- Tempat legend custom -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p
                                                style="text-align: left; font-size: 15px; margin-left: 15px; margin-top: 15px;">
                                                Notes: <br>
                                                1. Untuk melihat status task per user, bisa select peruser di
                                                bagian filter.<br>
                                                2. Untuk membuka semua task, klik Calendar dan di pojok kiri
                                                bawah pilih "Clear".
                                            </p>
                                        </div>
                                    </div>
                                </div>







                            </div>


                            <!-- BAR CHART -->
                            <div class="card card-success">
                                <div class="card-header" onclick="toggleCard(this)">
                                    <h3 class="card-title">Jumlah Task Selesai</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->


                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            
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

    <?php include "./view/common/foot.php" ?>
    <script>

            function toggleCard(element) {
                // Cari elemen card utama
                const card = element.closest('.card');
                // Aktifkan event collapse dari data-card-widget
                $(card).CardWidget('toggle');
            }


                    // Inisialisasi Summernote
                    $('#summernote').summernote({
                        height: 350,
                        placeholder: 'Ketikan sesuatu disini...',
                        focus: true,
                        codemirror: {
                            theme: 'monokai'
                        },
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'videoUpload']], // Custom videoUpload button
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        maximumImageFileSize: 1540 * 1024
                    });
        



            $(document).ready(function () {
                // Inisialisasi DataTable dengan pagination, search, responsive X, dan custom lengthChange
                let table = $('#taskTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "pageLength": 5,
                    "responsive": false,
                    "scrollX": true,
                    "sort": false,
                    "lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "All"]]
                });


                $('.nav-link[data-widget="pushmenu"]').on('click', function () {
                    setTimeout(() => {
                        table.columns.adjust().responsive.recalc();
                    }, 350); // Delay agar transisi sidebar selesai dulu
                });


                // Inisialisasi variabel interval
                let loadTasksInterval;
                let isFocused = false;

                function loadTasks() {
                    if (!isFocused) {

                        // Tampilkan indikator loading
                        let loadingRow = `<tr><td colspan='5' class='text-center'>Loading...</td></tr>`;
                        $('#taskTable tbody').html(loadingRow);


                        $.ajax({
                            url: 'view/calendar/load_tasks_user.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id_dg_user: <?php echo $id_user; ?>,
                                month_task: $('#month_task').val() ? $('#month_task').val() : 0
                            },
                            success: function(data) {
                                updateChartData();
                                table.clear().draw(); // Bersihkan DataTable

                                let openProgressTasks = [];
                                let doneCancelTasks = [];

                                $.each(data.tasks, function(index, task) {
                                    function formatDate(dateString) {
                                        if (!dateString) return "";
                                        const date = new Date(dateString);
                                        const options = { day: '2-digit', month: 'long', year: 'numeric' };
                                        return date.toLocaleDateString('en-GB', options);
                                    }
                                    
                                    let statusText = task.status_task === 0 ? "Open" 
                                        : task.status_task === 1 ? "On Progress" 
                                        : task.status_task === 2 ? "Cancel" 
                                        : `Done <br><p style='font-size: 12px;'>${formatDate(task.date_done)}</p>`;
                                    
                                    let statusColor = task.status_task === 0 ? "" 
                                        : task.status_task === 1 ? "background-color: #ffc107; color: black;" 
                                        : task.status_task === 2 ? "background-color: #dc3545; color: white;" 
                                        : "background-color: #28a745; color: white;";
                                    
                                    let rowNode = table.row.add([
                                        `<td>${index + 1}</td>`,
                                        `<td><input style='font-size: 15px;' disabled type='text' class='form-control' name='task_${task.id_dg_event_detail_task}' value='${task.isi_task}'></td>`,
                                        `<td>
                                            <div class='input-group date' id='reservationdate_${task.id_dg_event_detail_task}' data-target-input='nearest'>
                                                <input style='font-size: 15px;' disabled type='text' name='deadline_${task.id_dg_event_detail_task}' class='form-control datetimepicker-input' value='${task.deadline_task}'>
                                            </div>
                                        </td>`,
                                        `<td>${statusText}</td>`,
                                        `<td>
                                            <button style='font-size: 15px;' type='button' class='btn btn-${task.status_task === 1 ? "success" : task.status_task === 3 ? "danger" :  "info"} action-row-btn' data-id='${task.id_dg_event_detail_task}' data-status='${task.status_task === 0 ? 1 : task.status_task === 1 ? 3 : 0}'>
                                                ${task.status_task === 1 ? "Done" : task.status_task === 3 ? "Back to Open" :  "On Progress"}
                                            </button>
                                        </td>`
                                    ]).draw(false).node();
                                    
                                    

                                    table.columns.adjust().responsive.recalc();

                                    // Tambahkan styling
                                    $(rowNode).find('td').eq(0).attr('style', "text-align: center; vertical-align: middle;");
                                    $(rowNode).find('td').eq(3).attr('style', `text-align: center; vertical-align: middle; ${statusColor}`);
                                    $(rowNode).find('td').eq(4).attr('style', "text-align: center; vertical-align: middle;");

                                    // Inisialisasi DateTimePicker
                                    const datepickerElement = $(`#reservationdate_${task.id_dg_event_detail_task}`);
                                    if (datepickerElement.length > 0) {
                                        datepickerElement.datetimepicker({
                                            format: 'DD-MMMM-yyyy',
                                            showTodayButton: true,
                                            icons: { today: 'fa fa-calendar-day' },
                                            buttons: { showToday: true }
                                        });

                                        datepickerElement.on('change.datetimepicker', function(e) {
                                            if (e.date) {
                                                const formattedDeadline = e.date.format('YYYY-MM-DD');
                                                updateTaskDeadline(task.id_dg_event_detail_task, formattedDeadline);
                                            }
                                        });
                                    } else {
                                        console.error(`Datetimepicker element not found for task ID: ${task.id_dg_event_detail_task}`);
                                    }
                                });
                                table.columns.adjust().responsive.recalc();
                            },
                            error: function() {
                                toastr.error("Failed to load tasks.");
                            }
                        });
                    }
                }
            
                // Tambahkan event listener untuk perubahan di select_users
                $('#month_task').on('change', function () {
                    loadTasks();
                });

                loadTasks();

                // Fungsi untuk memulai interval pengambilan data
                function startLoadTasks() {
                    loadTasksInterval = setInterval(loadTasks, 300000); // Refresh setiap 300 detik
                }

                // Menghentikan interval loadTasks
                function stopLoadTasks() {
                    clearInterval(loadTasksInterval);
                }

                // Mulai interval saat halaman selesai dimuat
                startLoadTasks();

                
                // Menangani focus dan blur pada elemen input dan select di taskTable
                $('#taskTable').on('focus', 'input, select', function() {
                    isFocused = true;
                    stopLoadTasks(); // Hentikan interval saat input/select mendapatkan fokus
                });

                $('#taskTable').on('blur', 'input, select', function() {
                    isFocused = false;
                    startLoadTasks(); // Mulai ulang interval saat input/select kehilangan fokus
                });


                // Fungsi untuk menghapus task saat tombol action diklik
                $(document).on('click', '.action-row-btn', function() {
                    var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol action
                    var status = $(this).data('status');

                    // Nonaktifkan semua tombol action selama 2 detik setelah diklik
                    $('.action-row-btn').prop('disabled', true);
                    setTimeout(function() {
                        $('.action-row-btn').prop('disabled', false); // Aktifkan kembali semua tombol action setelah 2 detik
                    }, 3000);

                    var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol action
                    $.ajax({
                        url: 'view/calendar/conn_action_task.php', // URL endpoint untuk menghapus task
                        type: 'POST',
                        data: { id: taskId, status: status },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                loadTasks();
                                updateChartData();
                                updateChartDataUser();
                                toastr.success("Task successfully edited.");
                            } else {
                                toastr.error("Failed to edited task.");
                            }
                        },
                        error: function() {
                            toastr.error("Error edited task.");
                        }
                    });
                });




                

                // Inisialisasi DataTable dengan pagination, search, responsive X, dan custom lengthChange
                let table_user = $('#userTaskTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "pageLength": 5,
                    "responsive": false,
                    "scrollX": true,
                    "lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "All"]]
                });

                $('.nav-link[data-widget="pushmenu"]').on('click', function () {
                    setTimeout(() => {
                        table_user.columns.adjust().responsive.recalc();
                    }, 350); // Delay agar transisi sidebar selesai dulu
                });

                let loadUserTasksInterval;
                let isUserTaskFocused = false;

                function userloadTasks() {
                    if (!isUserTaskFocused) {
                        let selectedUsers = $('#select_users').val() || [];
                        
                        // Tampilkan indikator loading
                        let loadingRowUser = `<tr><td colspan='5' class='text-center'>Loading...</td></tr>`;
                        $('#userTaskTable tbody').html(loadingRowUser);

                        $.ajax({
                            url: 'view/calendar/load_tasks_user_select.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id_dg_user: <?php echo $id_user; ?>,
                                month_task: $('#month_task_user').val() ? $('#month_task_user').val() : 0,
                                select_users: selectedUsers
                            },
                            success: function(data) {
                                updateChartDataUser();
                                table_user.clear().draw(); // Bersihkan DataTable
                                
                                $.each(data.tasks, function(index, task) {
                                    function formatDate(dateString) {
                                        if (!dateString) return ""; // Jika tidak ada tanggal, kosongkan
                                        const date = new Date(dateString);
                                        const options = { day: '2-digit', month: 'long', year: 'numeric' };
                                        return date.toLocaleDateString('en-GB', options); // Contoh: 05-February-2025
                                    }
                                    let statusText = task.status_task === 0 ? "Open" : task.status_task === 1 ? "On Progress" : task.status_task === 2 ? "Cancel" : 'Done  <br><p style="font-size: 12px;">'+formatDate(task.date_done)+'</p>';
                                    let statusColor = task.status_task === 0 ? "" : task.status_task === 1 ? "background-color: #ffc107; color: black;" : task.status_task === 2 ? "background-color: #dc3545; color: white;" : "background-color: #28a745; color: white;";
                                    
                                    let rowNode = table_user.row.add([
                                        `<td>${index + 1}</td>`,
                                        `<td>${task.owner_name}</td>`,
                                        `<td><input style="font-size: 15px;" disabled type="text" class="form-control" name="task_${task.id_dg_event_detail_task}" value="${task.isi_task}"></td>`,
                                        `<td><div class="input-group date" id="reservationdate_${task.id_dg_event_detail_task}" data-target-input="nearest">
                                            <input style="font-size: 15px;" disabled type="text" name="deadline_${task.id_dg_event_detail_task}" class="form-control datetimepicker-input"  value="${task.deadline_task}">
                                        </div></td>`,
                                        `<td>${statusText}</td>`
                                    ]).draw(false).node();

                                    $(rowNode).find('td').eq(0).attr('style', "text-align: center; vertical-align: middle;");
                                    $(rowNode).find('td').eq(4).attr('style', "text-align: center; vertical-align: middle; "+statusColor);
                                });
                                table_user.columns.adjust().responsive.recalc();
                            },
                            error: function() {
                                toastr.error("Failed to load tasks.");
                            }
                        });
                    }
                }

                // Tambahkan event listener untuk perubahan di select_users
                $('#select_users, #month_task_user').on('change', function () {
                    userloadTasks();
                });

                userloadTasks();

                // Fungsi untuk memulai interval pengambilan data
                function startUserLoadTasks() {
                    loadUserTasksInterval = setInterval(userloadTasks, 300000); // Refresh setiap 300 detik
                }

                // Menghentikan interval UserloadTasks
                function stopUserLoadTasks() {
                    clearInterval(loadUserTasksInterval);
                }

                // Mulai interval saat halaman selesai dimuat
                startUserLoadTasks();

                // Menangani focus dan blur pada elemen input dan select di userTaskTable
                $('#userTaskTable').on('focus', 'input, select', function() {
                    isUserTaskFocused = true;
                    stopUserLoadTasks(); // Hentikan interval saat input/select mendapatkan fokus
                });

                $('#userTaskTable').on('blur', 'input, select', function() {
                    isUserTaskFocused = false;
                    startUserLoadTasks(); // Mulai ulang interval saat input/select kehilangan fokus
                });







                // Inisialisasi DataTable dengan pagination, search, responsive X, dan custom lengthChange
                let table_teamspace = $('#teamSpaceTaskTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "pageLength": 5,
                    "responsive": false,
                    "scrollX": true,
                    "lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "All"]]
                });

                $('.nav-link[data-widget="pushmenu"]').on('click', function () {
                    setTimeout(() => {
                        table_teamspace.columns.adjust().responsive.recalc();
                    }, 350); // Delay agar transisi sidebar selesai dulu
                });

                let loadTeamSpaceTasksInterval;
                let isTeamSpaceTaskFocused = false;

                function teamSpaceloadTasks() {
                    if (!isTeamSpaceTaskFocused) {
                        let selectedTeamspaces = $('#select_teamspace').val() || [];
                        let selectedSprints = $('#select_sprint').val() || [];

                        // Tampilkan indikator loading
                        let loadingRowTeamSpace = `<tr><td colspan='6' class='text-center'>Loading...</td></tr>`;
                        $('#teamSpaceTaskTable tbody').html(loadingRowTeamSpace);
                        
                        if (selectedTeamspaces.length === 0) {
                            $('#teamSpaceTaskTable tbody').html("<tr><td colspan='6' class='text-center'>Select Teamspace first</td></tr>");
                            return;
                        }



                        $.ajax({
                            url: 'view/calendar/load_tasks_teamspace.php',
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                select_teamspace: selectedTeamspaces,
                                select_sprint: selectedSprints
                            },
                            success: function(data) {
                                table_teamspace.clear().draw(); // Bersihkan DataTable

                                $.each(data.tasks, function(index, task) {
                                    let assignedUsersHTML = "";
                                    if (task.assigned_users.length > 0) {
                                        assignedUsersHTML = task.assigned_users.map(user => 
                                            `<img src="${user.photo}" alt="${user.name}" title="${user.name}" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 5px;">`
                                        ).join('');
                                    } else {
                                        assignedUsersHTML = 'No Assignee';
                                    }

                                    // Menentukan status finish dengan warna latar belakang
                                    let finishStatus = task.is_finish == 1 
                                        ? `<span style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px;">Finish</span>` 
                                        : `<span style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px;">Not Yet</span>`;

                                    // Nama task dengan link ke kanban.php
                                    let taskLink = `<a href="kanban.php?id=${task.id_dg_client_project}" target="_blank" style="text-decoration: none; color: #007bff; font-weight: bold;">${task.nama_task}</a>`;


                                    let rowNode = table_teamspace.row.add([
                                        `<td>${index + 1}</td>`,
                                        `<td>${assignedUsersHTML}</td>`, // Ganti dengan foto user
                                        `<td>${taskLink}</td>`, // Task jadi clickable link,
                                        `<td>${task.deadline_status}</td>`,
                                        `<td>${task.nama_status}</td>`,
                                        `<td>${finishStatus}</td>` // Menampilkan status dengan warna latar belakang
                                    ]).draw(false).node();

                                    $(rowNode).find('td').eq(0).attr('style', "text-align: center; vertical-align: middle;");
                                    $(rowNode).find('td').eq(5).attr('style', "text-align: center; vertical-align: middle;");
                                });

                                table_teamspace.columns.adjust().responsive.recalc();
                            },

                            error: function() {
                                toastr.error("Failed to load tasks.");
                            }
                        });
                    }
                }


                // Tambahkan event listener untuk perubahan di select_users
                $('#select_sprint').on('change', function () {
                    teamSpaceloadTasks();
                    updateChartDataTeamSpace();
                });


                teamSpaceloadTasks();

                // Fungsi untuk memulai interval pengambilan data
                function startTeamSpaceLoadTasks() {
                    loadTeamSpaceTasksInterval = setInterval(teamSpaceloadTasks, 300000); // Refresh setiap 300 detik
                }

                // Menghentikan interval teamSpaceloadTasks
                function stopTeamSpaceLoadTasks() {
                    clearInterval(loadTeamSpaceTasksInterval);
                }

                // Mulai interval saat halaman selesai dimuat
                startTeamSpaceLoadTasks();

                // Menangani focus dan blur pada elemen input dan select di teamSpaceTaskTable
                $('#teamSpaceTaskTable').on('focus', 'input, select', function() {
                    isTeamSpaceTaskFocused = true;
                    stopTeamSpaceLoadTasks(); // Hentikan interval saat input/select mendapatkan fokus
                });

                $('#teamSpaceTaskTable').on('blur', 'input, select', function() {
                    isTeamSpaceTaskFocused = false;
                    startTeamSpaceLoadTasks(); // Mulai ulang interval saat input/select kehilangan fokus
                });








                // Simpan sprint yang dipilih sebelumnya
                let selectedSprints = new Set();

                // Disable dropdown Sprint awalnya
                $("#select_sprint").prop("disabled", true).html('<option value="">Select a Teamspace first</option>');

                // Event saat Teamspace dipilih atau dihapus
                $("#select_teamspace").change(function () {
                    let selectedTeamspaces = $(this).val() || []; // Teamspace yang dipilih

                    if (selectedTeamspaces.length > 0) {
                        $.ajax({
                            url: "view/calendar/load_sprint.php",
                            type: "GET",
                            data: { teamspaces: selectedTeamspaces },
                            dataType: "json",
                            beforeSend: function () {
                                $("#select_sprint").prop("disabled", true);
                            },
                            success: function (response) {

                                if (response.success) {
                                    let options = "";
                                    let sprintTeamspaceMap = {}; // Menyimpan hubungan sprint dan teamspace
                                    let groupedSprints = {}; // Untuk mengelompokkan Sprint berdasarkan project

                                    // Simpan sprint yang masih ada sebelum dropdown direset
                                    let validSprints = new Set();
                                    selectedSprints.forEach(sprintId => {
                                        if ($(`#select_sprint option[value='${sprintId}']`).length > 0) {
                                            validSprints.add(sprintId);
                                        }
                                    });

                                    // Loop untuk menyusun Sprint ke dalam struktur data
                                    $.each(response.sprints, function (index, sprint) {
                                        sprintTeamspaceMap[sprint.id] = sprint.id_dg_client_project;

                                        if (!groupedSprints[sprint.nama_project]) {
                                            groupedSprints[sprint.nama_project] = [];
                                        }
                                        groupedSprints[sprint.nama_project].push(
                                            `<option value="${sprint.id}" data-teamspace="${sprint.id_dg_client_project}">${sprint.nama_sprint}</option>`
                                        );
                                    });

                                    // Susun ulang menjadi optgroup berdasarkan nama_project
                                    $.each(groupedSprints, function (projectName, sprintOptions) {
                                        options += `<optgroup label="${projectName}">${sprintOptions.join('')}</optgroup>`;
                                    });

                                    // Masukkan data ke dropdown Sprint
                                    $("#select_sprint").html(options).prop("disabled", false);

                                    // **Terapkan kembali Sprint yang masih valid**
                                    $("#select_sprint").val([...validSprints]).trigger("change");

                                    // Simpan ulang daftar sprint yang valid
                                    selectedSprints = validSprints;
                                    teamSpaceloadTasks();
                                    updateChartDataTeamSpace();
                                } else {
                                    $("#select_sprint").html('<option value="">No Sprints Available</option>').prop("disabled", true);
                                }
                            },
                            error: function () {
                                $("#select_sprint").html('<option value="">Failed to load Sprints</option>').prop("disabled", true);
                            }
                        });
                    } else {
                        // Jika tidak ada Teamspace dipilih, reset dropdown Sprint
                        $("#select_sprint").html('<option value="">Select a Teamspace first</option>').prop("disabled", true);
                        selectedSprints.clear(); // Reset sprint yang dipilih
                    }
                });

                // Simpan sprint yang dipilih setiap kali user memilih sprint baru
                $("#select_sprint").change(function () {
                    selectedSprints = new Set($(this).val() || []);
                });




            checkConnection();
            setInterval(checkConnection, 3000); // Cek setiap 3 detik
        });








        function updateLegend(labels, data, colors, chart, legendId) {
            let meta = chart.getDatasetMeta(0);
            let totalActive = 0;
            let activeData = new Array(data.length).fill(0);

            data.forEach((value, index) => {
                if (!meta.data[index].hidden) {
                    totalActive += parseInt(value, 10);
                    activeData[index] = value;
                }
            });

            let legendHtml = '<div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px;">';

            labels.forEach((label, index) => {
                let isHidden = meta.data[index].hidden ?? false;
                let percentage = (totalActive > 0 && !isHidden) ? ((activeData[index] / totalActive) * 100).toFixed(1) : 0;

                legendHtml += `
                    <div class="legend-item" data-index="${index}" style="display: flex; align-items: center; gap: 8px; cursor: pointer; opacity: ${isHidden ? 0.5 : 1};">
                        <div style="width: 15px; height: 15px; background-color: ${colors[index]}; border-radius: 3px;"></div>
                        <span style="font-size: 14px; text-decoration: ${isHidden ? 'line-through' : 'none'};">
                            ${label}: ${data[index]} (${percentage}%)
                        </span>
                    </div>
                `;
            });

            legendHtml += '</div>';
            document.getElementById(legendId).innerHTML = legendHtml;

            document.querySelectorAll(`#${legendId} .legend-item`).forEach(item => {
                item.addEventListener('click', function () {
                    let index = this.getAttribute('data-index');
                    meta.data[index].hidden = !meta.data[index].hidden;
                    chart.update();
                    updateLegend(labels, data, colors, chart, legendId);
                });
            });
        }





            var ctx = document.getElementById('pieChart').getContext('2d');

            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Open', 'On Progress', 'Done', 'Cancel'],
                    datasets: [{
                        data: [0, 0, 0, 0], // Nilai awal, akan diperbarui dengan AJAX
                        backgroundColor: ['#E5E5E5', '#f39c12', '#00a65a', '#f56954'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Pie Chart My Meeting Task Status',
                        fontSize: 16
                    }
                }
            });

            function updateChartData() {
                $.ajax({
                    url: 'view/ajax/load_task_user_counts.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id_dg_user: <?php echo $id_user; ?>,
                        month_task: $('#month_task').val() ? $('#month_task').val() : 0
                    },
                    success: function (data) {
                        let newData = [
                            data.open || 0,
                            data.ongoing || 0,
                            data.done || 0,
                            data.canceled || 0
                        ];
                        pieChart.data.datasets[0].data = newData;
                        pieChart.update();
                        updateLegend(pieChart.data.labels, newData, pieChart.data.datasets[0].backgroundColor, pieChart, 'pieChartLegend');

                        const monthTask = $('#month_task').val();
                        if (monthTask) {
                            const date = new Date(monthTask + '-01');
                            const options = { year: 'numeric', month: 'long' };
                            const formattedDate = date.toLocaleDateString('en-US', options);
                            $('.month-meeting').text(`${formattedDate}`);
                        } else {
                            $('.month-meeting').text("All");
                        }
                    },
                    error: function () {
                        console.error('Failed to load task counts.');
                    }
                });
            }

            updateChartData();


            

            var ctxUser = document.getElementById('pieChartUser').getContext('2d');

            var pieChartUser = new Chart(ctxUser, {
                type: 'pie',
                data: {
                    labels: ['Open', 'On Progress', 'Done', 'Cancel'],
                    datasets: [{
                        data: [0, 0, 0, 0], // Data awal, diperbarui lewat AJAX
                        backgroundColor: ['#E5E5E5', '#f39c12', '#00a65a', '#f56954'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false // Sembunyikan legend bawaan
                    },
                    title: {
                        display: true,
                        text: 'Pie Chart Team Meeting Task Status',
                        fontSize: 16
                    }
                    
                }
            });


            // Fungsi untuk memperbarui chart dengan data dari server
            function updateChartDataUser() {
                let selectedUsers = $('#select_users').val() || [];

                $.ajax({
                    url: 'view/ajax/load_task_user_counts_select.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id_dg_user: <?php echo $id_user; ?>,
                        month_task_user: $('#month_task_user').val() ? $('#month_task_user').val() : 0,
                        select_users: selectedUsers
                    },
                    success: function (data) {
                        let newData = [
                            data.open || 0,
                            data.ongoing || 0,
                            data.done || 0,
                            data.canceled || 0
                        ];

                        // Perbarui data chart
                        pieChartUser.data.datasets[0].data = newData;
                        pieChartUser.update();

                        // Perbarui legend di bawah chart dengan persen baru
                        updateLegend(pieChartUser.data.labels, newData, pieChartUser.data.datasets[0].backgroundColor, pieChartUser, 'pieChartUserLegend');

                        // Perbarui judul status meeting
                        const monthTaskUser = $('#month_task_user').val();
                        if (monthTaskUser) {
                            const date = new Date(monthTaskUser + '-01');
                            const options = { year: 'numeric', month: 'long' };
                            const formattedDate = date.toLocaleDateString('en-US', options);
                            $('.month-meeting-user').text(`${formattedDate}`);
                        } else {
                            $('.month-meeting-user').text("All");
                        }
                    },
                    error: function () {
                        console.error('Failed to load task counts.');
                    }
                });
            }

            // Panggil pertama kali saat halaman dimuat
            updateChartDataUser();






            var ctxTeamSpace = document.getElementById('pieChartTeamSpace').getContext('2d');

            var pieChartTeamSpace = new Chart(ctxTeamSpace, {
                type: 'pie',
                data: {
                    labels: ['On Progress', 'Finish'],
                    datasets: [{
                        data: [0, 0], // Data awal, diperbarui lewat AJAX
                        backgroundColor: ['#f56954', '#00a65a'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false // Sembunyikan legend bawaan
                    },
                    title: {
                        display: true,
                        text: 'Pie Chart Teamspace Status',
                        fontSize: 16
                    }
                    
                }
            });


            // Fungsi untuk memperbarui chart dengan data dari server
            function updateChartDataTeamSpace() {
                let selectedTeamspaces = $('#select_teamspace').val() || [];
                let selectedSprints = $('#select_sprint').val() || [];

                $.ajax({
                    url: 'view/ajax/load_task_user_counts_teamspace.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        selectedTeamspaces: selectedTeamspaces,
                        selectedSprints: selectedSprints
                    },
                    success: function (data) {
                        let newData = [
                            data.not_finish || 0,
                            data.finish || 0
                        ];

                        // Perbarui data chart
                        pieChartTeamSpace.data.datasets[0].data = newData;
                        pieChartTeamSpace.update();

                        // Perbarui legend di bawah chart dengan persen baru
                        updateLegend(pieChartTeamSpace.data.labels, newData, pieChartTeamSpace.data.datasets[0].backgroundColor, pieChartTeamSpace, 'pieChartTeamSpaceLegend');

                    },
                    error: function () {
                        console.error('Failed to load task counts.');
                    }
                });
            }

            // Panggil pertama kali saat halaman dimuat
            updateChartDataTeamSpace();




        $(function () {

                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

              


            <?php  
             




            $result_acc1 = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            AND status_detail = 1 and dg_task_detail.deleted_at is null"); 
            $result_acc2 = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            AND status_detail = 2 and dg_task_detail.deleted_at is null"); 
            $result_acc3 = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            AND status_detail = 3 and dg_task_detail.deleted_at is null"); 
            $result_acc4 = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            AND status_detail = 4 and dg_task_detail.deleted_at is null"); 
            $result_acc5 = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            AND status_detail = 5 and dg_task_detail.deleted_at is null"); 


            $total_task_q = mysqli_query($db2,"select * from `dg_task_detail` 
            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
            where dg_user.id_dg_user = $id_userX
            and dg_task_detail.deleted_at is null"); 

            $cek_st = mysqli_num_rows($result_acc1);
            $cek_og = mysqli_num_rows($result_acc2);
            $cek_dn = mysqli_num_rows($result_acc3);
            $cek_pb = mysqli_num_rows($result_acc4);
            $cek_cl = mysqli_num_rows($result_acc5);

            $total_task = mysqli_num_rows($total_task_q);

            
            ?>


            var penjualan = {
                labels: [
                    'Open',
                    'On Progress',
                    'Done',
                    'Problem',
                    'Cancel'
                ],
                datasets: [{
                    data: [<?php echo $cek_st; ?>, <?php echo $cek_og; ?>, <?php echo $cek_dn; ?>, <?php echo $cek_pb; ?>, <?php echo $cek_cl; ?>],
                    backgroundColor: ['#f56954', '#f39c12', '#00a65a', '#88225a'],
                }]
            }





                var areaChartData = {
                labels  : [
                    <?php
                    $result_client = mysqli_query($db2,"select * from `dg_client` 
                    where deleted_at IS NULL ORDER BY created_at ASC");
                    while($d_client= mysqli_fetch_array($result_client)){
                        echo '"'.$d_client['nama_client'].'",';
                    }
                    ?>"..."],
                datasets: [
                    {
                    label               : 'Task Selesai',
                    backgroundColor     : 'rgba(555, 214, 111, 1)',
                    borderColor         : 'rgba(210, 214, 111, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#12AF92',
                    pointHighlightFill  : '#12AF92 ',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [
                        <?php
                    $result_client = mysqli_query($db2,"select * from `dg_client` 
                    where deleted_at IS NULL
                    ORDER BY created_at ASC");
                    while($d_client= mysqli_fetch_array($result_client)){
                        $id_client = $d_client['id_dg_client'];
                        $total_task_q2 = mysqli_query($db2,"select * from `dg_task_detail` 
                        inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
                        inner join dg_task on dg_task_detail.id_dg_task = dg_task.id_dg_task
                        where id_client = $id_client and dg_task_detail.deleted_at is null");
                            $total_q2 = mysqli_num_rows($total_task_q2);
                            echo "'".$total_q2."',";

                    }
                    ?>
                    ]
                    },
                ]
                }

                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)
                var temp0 = areaChartData.datasets[0]

                
                barChartData.datasets[0] = temp0

                var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
                }

                new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
                })

        })


    </script>
</body>

</html>