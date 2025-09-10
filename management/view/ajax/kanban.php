<!DOCTYPE html>
<?php 
// mengaktifkan session
session_start();
include 'controller/conn.php';

// Tambahkan skema dan simpan URL saat ini di dalam session
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$_SESSION['previous_url'] = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:login.php");
}
if($_SESSION['priv'] > 4){
	header("location:index.php");
}
if(isset($_GET['id'])){
    $id_dg_client_project = $_GET['id'];
}
if(isset($_COOKIE['cookie_status'])) {
    $_SESSION['status'] = $_COOKIE['cookie_status'];
    $_SESSION['priv'] = $_COOKIE['priv'];
    $_SESSION['daftar'] = $_COOKIE['daftar'];
    $_SESSION['id_user'] = $_COOKIE['id_user'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['statusX'] = $_COOKIE['statusX'];
    $_SESSION['email'] = $_COOKIE['email'];
} 

if(!isset($_SESSION['priv'])) {
    header("location:controller/conn_logout.php");
} 
// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:login.php");
}
if($_SESSION['tidak_lengkap'] ==1){
	header("location:profile.php");
}
// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login"){
	header("location:login.php");
}
if(isset($_SESSION['id_user'])){
  $id_user = $_SESSION['id_user'];
}

$result_project_team = mysqli_query($db2,"SELECT dcp.id_dg_client_project, dcp.nama_project
FROM dg_client_project dcp
INNER JOIN dg_client_project_team dcpt
    ON dcp.id_dg_client_project = dcpt.id_dg_client_project
WHERE dcpt.id_dg_user = $id_user and dcp.id_dg_client_project = $id_dg_client_project
GROUP BY dcp.id_dg_client_project, dcp.nama_project;
");

// Periksa apakah hasilnya kosong
if (mysqli_num_rows($result_project_team) === 0 && $_SESSION['priv'] != 1) {
    // Redirect ke index.php jika tidak ada data
    header("Location: index.php");
    exit; // Pastikan tidak ada kode yang dieksekusi setelah redirect
}

date_default_timezone_set('Asia/Jakarta');
$tanggal_now = date("Y-m-d H:i:s");

$result_project_name = mysqli_query($db2, "
    SELECT * FROM 
        dg_client_project dcp
    INNER JOIN 
        dg_client dc ON dcp.id_dg_client = dc.id_dg_client
    INNER JOIN 
        dg_division dd ON dcp.division = dd.id_dg_division
    WHERE 
        dcp.id_dg_client_project = $id_dg_client_project
");

// Variabel untuk menyimpan data dari database
$id_dg_client_project_jenis = 0;
while ($d_project = mysqli_fetch_array($result_project_name)) {
    $nama_project = $d_project['nama_project'];
    $notes_project = $d_project['notes_project'];
    $nama_client = $d_project['nama_client'];
    $nama_division = $d_project['division_name'];
    $id_dg_client_project_jenis = $d_project['id_dg_client_project_jenis'];
    
}

if ($id_dg_client_project_jenis!=0) {
    // Query untuk memeriksa apakah id_dg_client_project ada di tabel dg_client_project_status
    $checkQuery = "SELECT COUNT(*) as count FROM dg_client_project_status WHERE id_dg_client_project = ?";
    $stmt = $db2->prepare($checkQuery);
    $stmt->bind_param("i", $id_dg_client_project);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $nama_status = "";
    $warna_status = "";
    $urutan_status = "";

    // Jika tidak ada, lakukan insert
    if ($row['count'] == 0) {

        $stmt1 = $db2->prepare("INSERT INTO dg_client_project_status (id_dg_client_project, nama_status, warna_status, 
        urutan_status, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("ssssss", $id_dg_client_project, $nama_status, $warna_status, $urutan_status, $tanggal_now, $id_user);
        
        
        $result_cek_status = mysqli_query($db2,"SELECT * from `dg_client_project_status` where
        deleted_by is null and id_dg_client_project_jenis = $id_dg_client_project_jenis");

        while($d_cek_status = mysqli_fetch_array($result_cek_status)){
            // Variabel input
            $nama_status = $d_cek_status['nama_status']; // Nama status
            $warna_status = $d_cek_status['warna_status']; // Warna status
            $urutan_status = $d_cek_status['urutan_status']; // Urutan status


            $stmt1->execute();
        }

        $stmt1->close();

    
    }




    $checkQueryType = "SELECT COUNT(*) as count FROM 
        dg_client_project_type 
    WHERE 
        id_dg_client_project = ?
    AND
        deleted_at IS NULL";

    $stmt3 = $db2->prepare($checkQueryType);
    $stmt3->bind_param("i", $id_dg_client_project);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $row3 = $result3->fetch_assoc();

    if ($row3['count'] == 0) {

        $stmt2 = $db2->prepare("INSERT INTO dg_client_project_type (id_dg_client_project, nama_type, 
        detail_project_tamplate, created_at, created_by) VALUES (?, ?, ?, ?, ?)");

        $stmt2->bind_param("sssss", $id_dg_client_project, $nama_type_in, $detail_project_tamplate_in, 
        $tanggal_now, $id_user);


        $result_type_cek = mysqli_query($db2, "SELECT * FROM 
                dg_client_project_type 
            WHERE 
                id_dg_client_project_jenis = $id_dg_client_project_jenis
            AND
                deleted_at IS NULL
        ");

        while($d_type_insert = mysqli_fetch_array($result_type_cek)) {
            $nama_type_in = $d_type_insert['nama_type'];
            $detail_project_tamplate_in = $d_type_insert['detail_project_tamplate'];
        
            $stmt2->execute();    
        
        }

        $stmt2->close();

    }

}


// Ambil semua id_dg_client_project_status dari tabel dg_client_project_status yang sesuai dengan id_dg_client_project
$queryStatus = "SELECT id_dg_client_project_status, urutan_status 
                FROM dg_client_project_status 
                WHERE id_dg_client_project = ? 
                AND deleted_at IS NULL";
$stmtStatus = $db2->prepare($queryStatus);
$stmtStatus->bind_param("i", $id_dg_client_project);
$stmtStatus->execute();
$resultStatus = $stmtStatus->get_result();

// Simpan hasil query dalam array
$statuses = [];
while ($row = $resultStatus->fetch_assoc()) {
    $statuses[] = $row;
}
$stmtStatus->close();

// Ambil semua id_dg_client_project_status_user yang sesuai dengan id_dg_user dan id_dg_client_project
$queryUserStatus = "SELECT id_dg_client_project_status 
                    FROM dg_client_project_status_user 
                    WHERE id_dg_user = ?";
$stmtUserStatus = $db2->prepare($queryUserStatus);
$stmtUserStatus->bind_param("i", $id_user);
$stmtUserStatus->execute();
$resultUserStatus = $stmtUserStatus->get_result();

// Simpan id_dg_client_project_status_user dalam array
$userStatuses = [];
while ($row = $resultUserStatus->fetch_assoc()) {
    $userStatuses[] = $row['id_dg_client_project_status'];
}
$stmtUserStatus->close();

// Array untuk tracking IDs yang harus ditambahkan dan dihapus
$toInsert = [];
$validStatuses = [];

// Loop melalui status dan cek apakah sudah ada di dg_client_project_status_user
foreach ($statuses as $status) {
    if (!in_array($status['id_dg_client_project_status'], $userStatuses)) {
        $toInsert[] = $status; // Tambahkan ke daftar untuk diinsert
    }
    $validStatuses[] = $status['id_dg_client_project_status']; // Simpan sebagai status valid
}
$is_active_temp = 1;
// Insert status baru ke dg_client_project_status_user
if (!empty($toInsert)) {
    $insertQuery = "INSERT INTO dg_client_project_status_user (id_dg_client_project_status, id_dg_user, urutan_view, is_active) 
                    VALUES (?, ?, ?, ?)";
    $stmtInsert = $db2->prepare($insertQuery);
    foreach ($toInsert as $status) {
        $stmtInsert->bind_param("iiii", $status['id_dg_client_project_status'], $id_user, $status['urutan_status'], $is_active_temp);
        $stmtInsert->execute();
    }
    $stmtInsert->close();
}

// Hapus status yang tidak valid dari dg_client_project_status_user
$toDelete = array_diff($userStatuses, $validStatuses);
if (!empty($toDelete)) {
    $deleteQuery = " DELETE cpsu
                    FROM dg_client_project_status_user AS cpsu
                    INNER JOIN dg_client_project_status AS cps
                    ON cpsu.id_dg_client_project_status = cps.id_dg_client_project_status
                    WHERE cps.id_dg_client_project_status  = ?
                    AND cps.id_dg_client_project = ?
                    AND cpsu.id_dg_user = ?";
    $stmtDelete = $db2->prepare($deleteQuery);
    foreach ($toDelete as $statusId) {
        $stmtDelete->bind_param("iii", $statusId, $id_dg_client_project, $id_user);
        $stmtDelete->execute();
    }
    $stmtDelete->close();
}








?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $nama_project; ?> | DIK Group</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">



    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <style>
        /* Custom progress bar style */
        .toast-progress {
            background-color: #007bff;
            height: 5px; /* Tinggi progress bar */
        }

        .content-wrapper.kanban {
            height: 100%;
        }

        .content-wrapper.kanban .content {
            height: 100%;
            overflow-x: auto;
        }

        .content-wrapper.kanban .content .container,
        .content-wrapper.kanban .content .container-fluid {
            width: max-content;
            display: flex;
            align-items: stretch;
        }

        .content-wrapper.kanban .content-header+.content {
            height: 100%;
        }

        .content-wrapper.kanban .card .card-body {
            padding: 0.5rem;
        }

        .content-wrapper.kanban .card.card-row {
            width: 280px;
            display: inline-block;
            margin: 0 0.5rem;
        }

        .content-wrapper.kanban .card.card-row:first-child {
            margin-left: 0;
        }

        .content-wrapper.kanban .card.card-row .card-body {
            height: 100%;
        }

        .content-wrapper.kanban .card.card-row .card:last-child {
            margin-bottom: 0;
            border-bottom-width: 1px;
        }

        .content-wrapper.kanban .card.card-row .card .card-header {
            padding: 0.5rem 0.75rem;
        }

        .content-wrapper.kanban .card.card-row .card .card-body {
            padding: 0.75rem;
        }

        .content-wrapper.kanban .btn-tool.btn-link {
            text-decoration: underline;
            padding-left: 0;
            padding-right: 0;
        }
        .sortable-ghost {
            opacity: 0.6;
            background-color: #d1ecf1;
            border: 1px dashed #007bff;
        }
        .content-wrapper.kanban .content .container, .content-wrapper.kanban .content .container-fluid{
            min-height: 550px;
            padding-bottom: 25px;
        }
        .content-wrapper.kanban .card.card-row{
            font-size: 12px;
        }

        .content-header{
            padding: 0px 15px;
        }
        .container-fluid{
            margin-left: 0px;
        }
        .info-sprint{
            background-color: #007bff; color: white; padding: 10px; border-radius: 5px;
            margin-bottom: 10px;
        }
        .info-priority{
            background-color:rgb(208, 32, 5); color: white; padding: 10px; border-radius: 5px;
            margin-bottom: 10px; width: 36%; margin-left: 3%;
        }
        .info-type{
            background-color:rgb(102, 110, 121); color: white; padding: 10px; border-radius: 5px;
            margin-bottom: 10px; width: 54%;
        }
        .info-date{
            padding: 0px 10px;
            font-size: 17px;
            margin-bottom: 10px;
        }
        .info-img{
            margin: auto;
            width: 40px;
            height: 40px;
            padding: 1px;
            margin-bottom: 10px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 3px 6px rgba(0, 0, 0, .23) !important;
        }
        .card-task .card-body .fas{
            margin-right: 5px;
        }
        .status-head{
            background-color: #f4f6f9 !important;
            min-height: 55px;
        }
        .kanban .card-row {
            background-color: #f4f6f9 !important;
            box-shadow: none !important;
        }
        .status-head h3{
            padding: 5px;
            border-radius: 3px;
        }
        .card-title{
            font-size: 15px;
        }
        .status-body .card-header{
            border-bottom: 0px;
        }
        .judul-task{
            max-width: 80%; /* Batas panjang maksimal */
            overflow-x: auto; /* Tambahkan scroll horizontal jika melebihi */
            overflow-y: hidden; 
            white-space: nowrap; /* Jangan pecah ke baris baru */
            font-size: 20px;
        }
        @media (max-width: 1024px) {
            .content-wrapper{
                padding-top: 50px;
            }
            .status-head{
                margin-top: 25px;
            }
        }

        .content::-webkit-scrollbar {
            position: fixed !important;
            bottom: 0;
            height: 5px;
        }

        .content::-webkit-scrollbar-track {
            background-color:rgb(100, 100, 100);
        }

        .content::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .content::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
        .kanban-board{
            height: 100%;
            overflow: auto;
        }
        .card-row{
            height: 100%;
        }


        .status-body {
            min-height: 500px;
            transition: padding-top 0.3s ease, margin-top 0.3s ease; /* Transisi halus */
        }
        /* Tambahkan padding-top saat header menjadi sticky */
        .sticky + .status-body {
            margin-top: 80px; /* Sesuaikan dengan tinggi .status-head */
        }
        .sidebar{
            margin-top: 75px !important;
        }

        .card-task {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .card-task:hover {
            cursor: pointer; /* Mengubah kursor menjadi tangan */
            background-color: rgb(255, 255, 227); /* Memberikan efek mengkilat/putih */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan efek bayangan */
        }

        .status-head{
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .status-head:hover{
            cursor: pointer; /* Mengubah kursor menjadi tangan */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan efek bayangan */
        }

        
        .select2-selection{
            height: 100% !important;
        }




        .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 50%;
            height: 100%;
            right: 0;
            top: 0;
            bottom: 0;
            transition: transform 0.3s ease-out;
        }

        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
        }

        .modal.right.fade .modal-dialog {
            transform: translateX(100%);
        }

        .modal.right.fade.show .modal-dialog {
            transform: translateX(0);
        }

        .loading {
            position: relative;
        }

        .loading:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .modal.in {
            z-index: 1050; /* Modal Add Task */
        }
        .modal.summernote-modal.in {
            z-index: 1060; /* Modal Summernote */
        }
        .modal-backdrop.in {
            z-index: 1040; /* Backdrop default */
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1051; /* Pastikan lebih tinggi dari konten modal */
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }




    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <!-- Modal Add Task -->
    <div id="addTaskModal" class="modal right fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            
                <div class="modal-content">
                    <!-- Overlay untuk loading -->
                    <div class="loading-overlay" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <form id="addTaskForm">
                        <input type="hidden" id="id_task" name="id_task" value="">
                        <input type="hidden" name="id_project" value="<?php echo $id_dg_client_project; ?>">
                        <input type="hidden" name="created_by" value="<?php echo $id_user; ?>"> <!-- Menambahkan created_by -->

                        <div class="modal-header">
                            <input 
                                type="text" 
                                class="form-control border-0" 
                                id="nama_task" 
                                name="nama_task" 
                                placeholder="Enter Task Name" 
                                autocomplete="off"
                                style="font-size: 1.5rem; font-weight: bold; padding: 0; box-shadow: none;"
                                required>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                                <div class="form-group">
                                    <label for="id_sprint">Sprint</label>
                                    <select class="form-control" id="id_sprint" name="id_sprint" required>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_type">Type</label>
                                    <select class="form-control select2-with-actions" id="id_type" name="id_type" required>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_status">Status</label>
                                    <select class="form-control select2" id="id_status" name="id_status" required>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select class="form-control" id="priority" name="priority">
                                        <option value="2">Standard</option>
                                        <option value="1">Urgent</option>
                                    </select>
                                </div>

                                <div id="deadlineContainer"></div>

                                <div class="form-group pb-5">
                                    <label for="detail_project">Task Details</label>
                                    <textarea id="detail_project" name="detail_project" class="form-control detail_project"></textarea>
                                    <button type="button" class="btn btn-info btn-sm float-right" id="saveAsTamplate" title="Save">
                                        <i class="fas fa-file-download"></i> Save as Tamplate
                                    </button>
                                </div>

                                <br>
                           
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-sm float-right mt-5 mb-3" id="deleteTaskButton" title="Delete Task">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            
                        </div>
                    </form>
                </div>
            
        </div>
    </div>



    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editStatusForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusLabel">Edit Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editStatusId">
                        <div class="form-group">
                            <label for="editStatusName">Status Name</label>
                            <input type="text" id="editStatusName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatusColor">Status Color</label>
                            <input type="color" id="editStatusColor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatusOrder">Order</label>
                            <input type="number" id="editStatusOrder" name="editStatusOrder" class="form-control" placeholder="Enter order number" required>
                        </div>
                        <div class="form-group">
                            <label for="editHasDeadline">Apakah ada deadline?</label>
                            <select id="editHasDeadline" name="editHasDeadline" class="form-control">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-labelledby="addStatusModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addStatusForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStatusModalLabel">Add New Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="statusName">Status Name</label>
                            <input type="text" id="statusName" name="statusName" class="form-control" placeholder="Enter status name" required>
                        </div>
                        <div class="form-group">
                            <label for="statusColor">Status Color</label>
                            <input type="color" id="statusColor" name="statusColor" class="form-control" value="#007bff" required>
                        </div>
                        <div class="form-group">
                            <label for="statusOrder">Order</label>
                            <input type="number" id="statusOrder" name="statusOrder" class="form-control" placeholder="Enter order number" required>
                        </div>
                        <div class="form-group">
                            <label for="hasDeadline">Apakah ada deadline?</label>
                            <select id="hasDeadline" name="hasDeadline" class="form-control">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id_dg_user_status" id="id_dg_user_status" value="<?php echo $id_user; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal untuk memilih upload video atau memasukkan URL -->
    <div class="modal fade" id="modal-video-upload" tabindex="-1" aria-labelledby="modal-video-uploadLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-video-uploadLabel">Insert Video</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <!-- Pilihan Upload Video dari File -->
                    <div class="form-group note-form-group note-group-select-from-files">
                        <label for="note-dialog-video-file" class="note-form-label">Select from Files</label>
                        <input id="note-dialog-video-file" class="note-video-input form-control-file note-form-control note-input" type="file" name="files" accept="video/*">
                        <small>Maximum file size: 50 MB</small>
                    </div>
                    <!-- Pilihan Memasukkan URL Video -->
                    <div class="form-group note-group-video-url">
                        <label for="note-dialog-video-url" class="note-form-label">Video URL</label>
                        <input id="note-dialog-video-url" class="note-video-url form-control note-form-control note-input" type="text" placeholder="Enter video URL (e.g. YouTube, Vimeo)">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" id="insertVideoBtn" class="btn btn-primary note-btn note-btn-primary" value="Insert Video" disabled>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal -->
    <div class="modal fade" id="modal-edit-link">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-link">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">
                            <label for="linkName" class="col-sm-2 col-form-label">Link Name</label>
                        <div class="col-sm-4" style="padding-bottom: 10px;">
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
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Link ini ?<br>
                        Link Name &nbsp; : <b id="link_name"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_link" id="id_dg_client_project_link" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">

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


    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper kanban">
            <div class="wrapper-kanban">

                    <section class="content-header">

                        <div class="card" id="attend" style="background-color: #f4f6f9; box-shadow: none; border-bottom: 1px solid rgba(0, 0, 0, .125);">
                            <div class="card-header" onclick="toggleCard(this)">
                                <h2 class="card-title" style="font-size: 30px;"><b><?php echo $nama_client; ?> | <?php echo $nama_project; ?></b></h2>
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-sm-12" style="text-align: left; padding-left: 20px;">
                                        <h5><b>Description Project :</b></h5>
                                    </div>
                                    <div class="col-12" style="padding: 0px 20px;">
                                        <textarea id="summernote" name="notes_project"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" style="margin-bottom: 20px;">
                                    <div class="col-12" style="padding: 10px;">
                                        <div class="col-sm-12" style="text-align: left; padding-left: 10px;">
                                            <h5><b>Link Project :</b></h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <table id="example1" class="table table-bordered table-striped" style="width: 100%; font-size: 12px; background-color: white;">
                                                <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 10%;">No</th>
                                                    <th>Nama Link</th>
                                                    <th>    
                                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                                            <span>Link</span>
                                                            <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative; font-size: 12px;"
                                                                data-toggle="modal" onclick="loadModalProjectLink(<?php echo $id_dg_client_project; ?>, '<?php echo $nama_project; ?>', '<?php echo $id_client; ?>')"
                                                                class="btn btn-raised btn-success">+
                                                            </button>
                                                        </div>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="daftar-link">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </section>

                    <section class="content-header">
                        <div class="card card-outline" id="filter" style="background-color: #f4f6f9; box-shadow: none; border-bottom: 1px solid rgba(0, 0, 0, .125);">
                            <div class="card-header" onclick="toggleCard(this)">
                                <h5 class="card-title judul-task" style="font-size: 15px; color: red;"><b style="color: black;"><i class="fas fa-filter"></i> Filter</b> (TOLONG DI PERHATIKAN FILTER APA SAJA YANG DI SETTING !!!)</h5>
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 20px;">
                                <div class="row">
                                    <div class="col-6 select2-purple" style="font-size: 15px;">
                                        <p style="margin: 0px;"><b>Sprint: </b></p>
                                        <select data-placeholder="Select a Sprint" style="font-size: 12px; width: 100%;" multiple="multiple" 
                                            class="select2" name="filter_sprint[]" id="filter_sprint" required>
                        
                                        </select>
                                    </div>

                                    <div class="col-6 select2-blue" style="font-size: 15px;">
                                        <p style="margin: 0px;"><b>Status: </b></p>
                                        <select data-placeholder="Select a Status" style="font-size: 12px; width: 100%;" multiple="multiple" 
                                            class="select2" name="filter_status[]" id="filter_status" required>
                                           
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="content">
                        <div id="workspace-overlay" class="loading-overlay" style="display: none;">
                            <div class="spinner"></div>
                        </div>

                        <div id="kanban-board" class="container-fluid h-100">

                      </div>
                    </section>
                </div>
            </div>

            <?php include 'view/common/footer.html'; ?>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"
            type="text/javascript">
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
        <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
        <!-- Ekko Lightbox -->
        <script src="plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

        <!-- Filterizr-->
        <script src="plugins/filterizr/jquery.filterizr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

        <!-- Page specific script -->
        <script>

        toastr.options = {
            closeButton: true, // Menampilkan tombol close (X)
            progressBar: true, // Menampilkan progress bar
            positionClass: 'toast-top-right', // Posisi notifikasi
            timeOut: 5000, // Waktu otomatis hilang (dalam milidetik)
            extendedTimeOut: 2000, // Waktu tambahan jika di-hover
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };



        
        // Saat membuka modal
        $(document).on('show.bs.modal', '#addTaskModal', function () {
            const projectId = '<?php echo $id_dg_client_project; ?>';

            // Fetch statuses with deadline requirement and users
            $.ajax({
                url: 'view/ajax/get_statuses_with_deadline.php',
                type: 'GET',
                data: { id_project: projectId },
                dataType: 'json',
                success: function (response) {
                    //console.log('Fetched statuses with deadlines and users:', response);

                    if (response.success) {
                        const deadlineContainer = $('#deadlineContainer');
                        deadlineContainer.empty();

                        // Iterasi status dengan deadline aktif
                        response.statuses.forEach(status => {
                            if (status.is_deadline_active == 1) {
                                // Tambahkan field deadline
                                const deadlineField = `
                                    <div class="form-group">
                                        <label for="deadline_${status.id_dg_client_project_status}">Deadline ${status.nama_status}</label>
                                        <input type="date" 
                                            class="form-control" 
                                            id="deadline_${status.id_dg_client_project_status}" 
                                            name="deadlines[${status.id_dg_client_project_status}]" 
                                            required>
                                    </div>
                                    <div class="form-group select2-purple">
                                        <label for="assign_users_${status.id_dg_client_project_status}">Assign Users for ${status.nama_status}</label>
                                        <select 
                                            class="form-control select2" 
                                            id="assign_users_${status.id_dg_client_project_status}" 
                                            name="assigned_users[${status.id_dg_client_project_status}][]" 
                                            multiple 
                                            required>
                                            <!-- Options akan diisi di bawah -->
                                        </select>
                                    </div>`;
                                deadlineContainer.append(deadlineField);

                                // Isi dropdown assign users
                                const assignUsersSelect = $(`#assign_users_${status.id_dg_client_project_status}`);
                                response.users.forEach(user => {
                                    assignUsersSelect.append(`<option value="${user.id_dg_user}">${user.nama}</option>`);
                                });

                                // Inisialisasi Select2
                                assignUsersSelect.select2();
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Failed to fetch statuses with deadlines and users:', error);
                }
            });
        });



    //LINK TO PROJECT

        function clearLinkToProject() {
            //Kosongkan nilai input
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
                        loadProjectLinks();
                        loadKanban();
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
                    loadProjectLinks();
                    loadKanban();
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

            // Panggil refreshModalLink setiap 30 detik setelah modal ditampilkan
            var intervalId = setInterval(refreshModalLink, 3000000);

            // Hentikan pembaruan saat modal disembunyikan
            $('#modal-edit-link').on('hidden.bs.modal', function () {
                clearInterval(intervalId);
            });
        }


        function loadProjectLinks() {
            const id_dg_client_project = <?php echo $id_dg_client_project; ?>; // Pastikan variabel ini telah didefinisikan di PHP

            $.ajax({
                url: 'view/ajax/load_project_links.php', // Endpoint untuk memuat data
                type: 'POST',
                data: { id_dg_client_project: id_dg_client_project },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const links = response.data; // Ambil data dari respons
                        let rows = '';

                        if (links.length > 0) {
                            links.forEach((link, index) => {
                                rows += `
                                    <tr>
                                        <td style="text-align: center;">${index + 1}</td>
                                        <td>${link.nama_link}</td>
                                        <td><a href="https://${link.link_project}" target="_blank">${link.link_project}</a></td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `
                                <tr>
                                    <td colspan="3" style="text-align: center;">No links found.</td>
                                </tr>
                            `;
                        }

                        $('#daftar-link').html(rows); // Update tabel dengan data
                    } else {
                        toastr.error('Failed to load project links.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('An error occurred while loading project links.');
                }
            });
        }

        // Panggil fungsi untuk memuat data saat halaman selesai dimuat
        $(document).ready(function() {
            loadProjectLinks();
        });

    

    //Filter Status    
    
        $('#filter_status').on('change', function () {
            const selectedOptions = $(this).val() || []; // Ambil nilai yang dipilih, default array kosong jika tidak ada yang dipilih
            const allOptions = [];

            // Ambil semua id_dg_client_project_status dari dropdown
            $('#filter_status option').each(function () {
                allOptions.push($(this).val());
            });

            // Data yang perlu dihapus (tidak terpilih lagi)
            const toRemove = allOptions.filter(option => !selectedOptions.includes(option));

            // Kirim data ke server melalui AJAX
            $.ajax({
                url: 'view/ajax/save_status_filter.php', // URL file PHP yang menangani penyimpanan/pengecekan
                type: 'POST',
                data: {
                    selected: selectedOptions, // Data yang dipilih
                    removed: toRemove, // Data yang dihapus
                    id_dg_user: '<?php echo $id_user; ?>', // Kirim id_dg_user
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadKanban();
                        //toastr.success('Filter updated successfully!', 'Success');
                    } else {
                        loadKanban();
                        toastr.error('Failed to update filter.', 'Error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadKanban();
                    toastr.error('An error occurred while updating the filter.', 'Error');
                    console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                }
            });
        });
 

    //Filter Sprint    

    $('#filter_sprint').on('change', function () {
            const selectedOptions = $(this).val() || []; // Ambil nilai yang dipilih, default array kosong jika tidak ada yang dipilih
            const allOptions = [];

            // Ambil semua id_dg_client_project_status dari dropdown
            $('#filter_sprint option').each(function () {
                allOptions.push($(this).val());
            });

            // Data yang perlu dihapus (tidak terpilih lagi)
            const toRemove = allOptions.filter(option => !selectedOptions.includes(option));

            // Kirim data ke server melalui AJAX
            $.ajax({
                url: 'view/ajax/save_status_sprint.php', // URL file PHP yang menangani penyimpanan/pengecekan
                type: 'POST',
                data: {
                    selected: selectedOptions, // Data yang dipilih
                    removed: toRemove, // Data yang dihapus
                    id_dg_user: '<?php echo $id_user; ?>', // Kirim id_dg_user
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        loadKanban();
                        //toastr.success('Filter updated successfully!', 'Success');
                    } else {
                        loadKanban();
                        toastr.error('Failed to update filter.', 'Error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadKanban();
                    toastr.error('An error occurred while updating the filter.', 'Error');
                    console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                }
            });
        });

   
    //KANBAN
    function loadKanban() {
    $.ajax({
        url: 'view/ajax/fetch_kanban.php',
        type: 'GET',
        data: {
            id_project: '<?php echo $id_dg_client_project; ?>',
            id_user: '<?php echo $id_user; ?>'
        },
        dataType: 'json',
        success: function (data) {
            const kanbanContainer = $('#kanban-board');
            kanbanContainer.empty(); // Bersihkan kontainer

            // Render status dan task
            data.forEach(status => {
                // Filter status yang bukan "No Status"
                if (status.id_dg_client_project_status !== null) {
                let statusCard = `
                <div class="card card-row" data-id-status="${status.id_dg_client_project_status}" data-nama-status="${status.nama_status}" 
                data-order-status="${status.urutan_status}" data-deadline-status="${status.is_deadline_active}">
                    <div class="card-header status-head">
                        <h3 class="card-title" style="background-color: ${status.warna_status} !important;">
                            ${status.nama_status}
                        </h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool" title="Setting Status"
                                    data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item edit-status" href="#"><i class="fas fa-pencil-alt"></i> Edit Status</a>
                                    <a class="dropdown-item delete-status" href="#"><i class="fas fa-trash-alt"></i> Delete Status</a>
                                </div>
                            </div>
                            <button href="#" class="btn btn-tool" title="Add Task">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body status-body">`;

                // Tambahkan task ke status tertentu
                status.tasks.forEach(task => {
                    let deadlineHtml = ''; // Awalnya kosong

                    // Cek apakah deadline aktif untuk status ini
                    if (status.is_deadline_active && task.deadline_status) {
                        const deadlineDate = new Date(task.deadline_status);
                        if (!isNaN(deadlineDate)) { // Pastikan nilai valid
                            const formattedDeadline = deadlineDate.toLocaleDateString('id-ID', {
                                weekday: 'long',
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                            deadlineHtml = `<p class="info-date"><i class="fas fa-calendar-alt"></i> ${formattedDeadline}</p>`;
                        }
                    }

                    const userImages = task.users.map(user => `
                        <img class="img-circle info-img" src="img/profile/${user.photo || 't0.jpg'}" alt="User">
                    `).join('');

                    statusCard += `
                    <div class="card card-outline card-task" data-id-task="${task.id_dg_client_project_task}">
                        <div class="card-header">
                            <h5 class="card-title judul-task"><b>${task.nama_task}</b></h5>
                            <div class="card-tools">
                                <button href="#" class="btn btn-tool" title="Edit Task">
                                    <i class="far fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            ${deadlineHtml} <!-- Tampilkan deadline jika ada -->
                            <div class="row" style="padding: 0px 8px;">
                                <p class="info-type"><i class="fas fa-thumbtack"></i> ${task.nama_type}</p>
                                ${
                                    task.priority == 1 ? '<p class="info-priority"><i class="fas fa-fire"></i> Urgent</p>' : 
                                    task.priority == 2 ? '<p class="info-priority" style="background-color: #FFA500;"><i class="fas fa-minus-circle"></i> Standard</p>' :
                                    '<p class="info-priority" style="background-color: #666E79;"><i class="fas fa-question-circle"></i> Not Set</p>'
                                }
                            </div>
                            <p class="info-sprint"><i class="fas fa-running"></i> ${task.nama_sprint}</p>
                            <div class="info-users">${userImages}</div>
                        </div>
                    </div>`;
                });


                statusCard += `</div></div>`;
                kanbanContainer.append(statusCard);
            }
        });


            // Tambahkan kolom "No Status"
            let noStatusCard = `
                <div class="card card-row no-status" data-id-status="null">
                    <div class="card-header status-head" style="cursor: pointer;">
                        <h4 class="card-title" style="text-align: center;">
                            <i class="fas fa-archive"></i> No Status
                        </h4>
                    </div>
                    <div class="card-body status-body">`;

            let noStatusTasks = data.find(status => status.id_dg_client_project_status === null)?.tasks || [];
            //console.log(noStatusTasks);

            noStatusTasks.forEach(task => {
                const deadlineDate = new Date(task.deadline_status);
                const formattedDeadline = deadlineDate.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                const userImages = task.users.map(user => `
                    <img class="img-circle info-img" src="img/profile/${user.photo || 't0.jpg'}" alt="User">
                `).join('');

                noStatusCard += `
                <div class="card card-outline card-task" data-id-task="${task.id_dg_client_project_task}">
                    <div class="card-header">
                        <h5 class="card-title judul-task"><b>${task.nama_task}</b></h5>
                        <div class="card-tools">
                            <button href="#" class="btn btn-tool" title="Edit Task">
                                <i class="far fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="info-date"><i class="fas fa-calendar-alt"></i> ${formattedDeadline}</p>
                        <div class="row" style="padding: 0px 10px;">
                            <p class="info-type"><i class="fas fa-thumbtack"></i> ${task.nama_type}</p>
                            
                                ${
                                    task.priority == 1 ? '<p class="info-priority"><i class="fas fa-fire"></i> Urgent</p>' : 
                                    task.priority == 2 ? '<p class="info-priority" style="background-color: #FFA500;"><i class="fas fa-minus-circle"></i> Standard</p>' :
                                    '<p class="info-priority" style="background-color: #666E79;"><i class="fas fa-question-circle"></i> Not Set</p>'
                                }
                            
                        </div>
                        <p class="info-sprint"><i class="fas fa-running"></i> ${task.nama_sprint}</p>
                        <div class="info-users">${userImages}</div>
                    </div>
                </div>`;
            });

            noStatusCard += `</div></div>`; // Tutup elemen
            kanbanContainer.append(noStatusCard);



            // Tambahkan kolom "Add Status"
            const addStatusCard = `
                <div class="card card-row add-status" style="width: 150px;">
                    <div class="card-header status-head" style="cursor: pointer;" title="Add New Status" onclick="openAddStatusModal()">
                        <h4 class="card-title" style="text-align: center;">
                            <i class="fas fa-plus-circle"></i> Add Status
                        </h4>
                    </div>
                </div>`;
            kanbanContainer.append(addStatusCard);

                // Reinitialize Sortable for tasks after AJAX load
                initSortable();

                // Reinitialize sticky headers
                initializeStickyHeaders();

                const headings = document.querySelectorAll('.status-head h3');

                headings.forEach((heading) => {
                    setTextColorBasedOnBackground(heading); // Mengacu pada background parent-nya (status-head)
                });
            },
            error: function (xhr, status, error) {
                console.error('Failed to load Kanban:', error);
            }
        });
    }


    


            // Fungsi untuk menghitung luminance
            function getLuminance(r, g, b) {
                const a = [r, g, b].map((v) => {
                    v /= 255;
                    return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
                });
                return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
            }

            // Fungsi untuk mendapatkan warna RGB dari background elemen
            function getBackgroundColor(element) {
                let bg = window.getComputedStyle(element).backgroundColor;
                if (bg.startsWith('rgb')) {
                    const match = bg.match(/\d+/g);
                    return match ? match.slice(0, 3).map(Number) : [255, 255, 255]; // Default putih
                }
                return [255, 255, 255]; // Default putih jika tidak ditemukan
            }

            // Fungsi untuk menentukan warna teks berdasarkan background
            function setTextColorBasedOnBackground(element) {
                const [r, g, b] = getBackgroundColor(element);
                const luminance = getLuminance(r, g, b);

                // Jika luminance rendah (gelap), gunakan warna putih; jika tinggi (cerah), gunakan hitam
                const textColor = luminance < 0.5 ? 'white' : 'black';
                element.style.color = textColor;
            }

            // Penerapan pada semua .status-head h3
            document.addEventListener('DOMContentLoaded', function () {
                const headings = document.querySelectorAll('.status-head h3');

                headings.forEach((heading) => {
                    setTextColorBasedOnBackground(heading); // Mengacu pada background parent-nya (status-head)
                });
            });


    //STICKY HEADER
    function initializeStickyHeaders() {
        const statusHeads = document.querySelectorAll('.status-head');

        function updateStatusHeadPosition() {
            statusHeads.forEach((statusHead) => {
                // Pastikan elemen statusHead tidak null
                if (!statusHead) return;

                const parent = statusHead.parentElement; // Parent container
                // Pastikan parent ada
                if (!parent) return;

                const statusBody = parent.querySelector('.status-body'); // Body di bawah header
                // Jika tidak ada statusBody (contoh: add-status), gunakan parent width
                const widthSource = statusBody || parent;

                const parentRect = parent.getBoundingClientRect(); // Posisi parent terhadap viewport

                const offsetTop = 50; // Jarak dari atas layar

                if (parentRect.top <= offsetTop) {
                    // Menjadi fixed
                    statusHead.style.position = 'fixed';
                    statusHead.style.top = offsetTop + 'px';
                    statusHead.style.zIndex = '999';
                    statusHead.style.width = `${widthSource.scrollWidth}px`; // Lebar mengikuti konten body atau parent
                    statusHead.style.left = `${-widthSource.scrollLeft + parentRect.left}px`; // Sinkron dengan scroll-x
                    statusHead.classList.add('sticky');
                } else {
                    // Kembali ke posisi normal
                    statusHead.style.position = 'static';
                    statusHead.style.width = '';
                    statusHead.style.left = '';
                    statusHead.classList.remove('sticky');
                }
            });
        }

        // Update posisi saat scroll vertikal dan horizontal
        document.addEventListener('scroll', updateStatusHeadPosition);

        // Update posisi saat container di-scroll secara horizontal
        document.querySelectorAll('.status-body').forEach((statusBody) => {
            // Pastikan statusBody ada sebelum menambahkan event listener
            if (!statusBody) return;

            statusBody.addEventListener('scroll', updateStatusHeadPosition);
        });

        // Memeriksa posisi secara berkala untuk menghindari delay
        function checkPositionWithAnimationFrame() {
            updateStatusHeadPosition();
            requestAnimationFrame(checkPositionWithAnimationFrame); // Periksa posisi terus-menerus
        }

        // Mulai animasi
        requestAnimationFrame(checkPositionWithAnimationFrame);
    }




    //LOAD FILTER DATA
    const idProject = <?= $id_dg_client_project; ?>; // Pastikan ID project tersedia
    const userId = <?= $id_user; ?>; // Pastikan ID user tersedia

    // Fungsi untuk memuat data filter melalui AJAX
    function loadFilterData() {
        $.ajax({
            url: 'view/ajax/get_filter_data.php', // Endpoint PHP
            method: 'GET',
            data: { id_dg_client_project: idProject }, // Kirim ID project
            dataType: 'json',
            success: function (response) {
                // Sprint
                const sprintSelect = $('#filter_sprint');
                sprintSelect.empty(); // Kosongkan isi select sebelumnya
                response.sprints.forEach(sprint => {
                    const isSelected = response.selected_sprints.includes(sprint.id) ? 'selected' : '';
                    sprintSelect.append(`<option value="${sprint.id}" ${isSelected}>${sprint.name}</option>`);
                });

                // Status
                const statusSelect = $('#filter_status');
                statusSelect.empty(); // Kosongkan isi select sebelumnya
                response.statuses.forEach(status => {
                    const isSelected = response.selected_statuses.includes(status.id) ? 'selected' : '';
                    statusSelect.append(`<option value="${status.id}" ${isSelected}>${status.name}</option>`);
                });

                // Refresh Select2
                sprintSelect.trigger('change');
                statusSelect.trigger('change');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error loading filter data:', textStatus, errorThrown);
            }
        });
    }

    // Panggil fungsi saat halaman dimuat
    loadFilterData();
    




    //ADD STATUS
    function openAddStatusModal() {
        $('#addStatusModal').modal('show');
    }

    $('#addStatusForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const formData = {
            id_dg_client_project: <?php echo $_GET['id']; ?>, // Replace with dynamic project ID
            nama_status: $('#statusName').val(),
            warna_status: $('#statusColor').val(),
            urutan_status: $('#statusOrder').val(),
            hasDeadline: $('#hasDeadline').val(),
            id_dg_user: $('#id_dg_user_status').val() // Sertakan ID user jika diperlukan
        };

        $.ajax({
            url: 'view/ajax/add_status.php', // PHP endpoint for adding status
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    loadKanban(); // Reload the Kanban board
                    loadFilterData(); // Reload filter data
                    toastr.success(response.message, 'Success');
                    $('#addStatusModal').modal('hide'); // Close modal
                    $('#addStatusForm')[0].reset(); // Reset form
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('An error occurred while adding status.', 'Error');
                console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
            }
        });
    });

    //EDIT STATUS
    $(document).ready(function () {
        // Handle Edit button click
        $(document).on('click', '.dropdown-item.edit-status', function () {
            const statusId = $(this).closest('.card-row').data('id-status');
            const statusName = $(this).closest('.card-row').data('nama-status');
            const statusOrder = $(this).closest('.card-row').data('order-status');
            const statusDeadline = $(this).closest('.card-row').data('deadline-status');
            const statusColor = $(this).closest('.card-row').find('.card-title').css('background-color');

            // Fill modal fields
            $('#editStatusId').val(statusId);
            $('#editStatusName').val(statusName);
            $('#editStatusOrder').val(statusOrder);
            $('#editHasDeadline').val(statusDeadline);
            $('#editStatusColor').val(rgbToHex(statusColor)); // Convert RGB to HEX

            // Open modal
            $('#editStatusModal').modal('show');
        });

        // Handle form submission for editing status
        $('#editStatusForm').on('submit', function (e) {
            e.preventDefault();

            const formData = {
                id: $('#editStatusId').val(),
                name: $('#editStatusName').val(),
                urutan_status: $('#editStatusOrder').val(),
                hasDeadline: $('#editHasDeadline').val(),
                color: $('#editStatusColor').val(),
            };

            $.ajax({
                url: 'view/ajax/edit_status.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        //console.log('Status edited:', response);
                        $('#editStatusModal').modal('hide');
                        loadKanban(); // Reload Kanban board
                        loadFilterData(); // Reload filter data
                        toastr.success("Status Edited !", 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while editing the status.', 'Error');
                    console.error(error);
                }
            });
        });

        // Handle Delete button click
        $(document).on('click', '.dropdown-item.delete-status', function () {
            const statusId = $(this).closest('.card-row').data('id-status');

            if (confirm('Are you sure you want to delete this status?')) {
                $.ajax({
                    url: 'view/ajax/delete_status.php',
                    method: 'POST',
                    data: { id: statusId, id_dg_user: <?php echo $id_user; ?> },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            loadKanban(); // Reload Kanban board
                            loadFilterData(); // Reload filter data
                            toastr.success(response.message, 'Success');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred while deleting the status.', 'Error');
                        console.error(error);
                    }
                });
            }
        });
    });

    // Helper: Convert RGB to HEX
    function rgbToHex(rgb) {
        const rgbArray = rgb.match(/\d+/g).map(Number);
        return `#${rgbArray.map(x => x.toString(16).padStart(2, '0')).join('')}`;
    }





    // Trigger modal dan langsung simpan data saat tombol + ditekan
    $(document).on('click', '.btn-tool[title="Add Task"]', function () {
        // Dapatkan id_status dari kolom tempat tombol di-klik
        const idStatus = $(this).closest('.card-row').data('id-status');
        $('#id_status').val(idStatus).trigger('change'); // Set id_status di modal dan trigger Select2

        $('#nama_task').val("New Task");

        // Muat data untuk dropdown Sprint, Type, dan Status
        $.ajax({
            url: 'view/ajax/fetch_dropdown_data.php',
            type: 'GET',
            data: {
                id_project: '<?php echo $id_dg_client_project; ?>'
            },
            dataType: 'json',
            success: function (response) {
                // ** Populate Sprint Dropdown **
                const sprintDropdown = $('#id_sprint');
                sprintDropdown.empty(); // Kosongkan opsi sebelumnya
                console.log(response.sprints);
                if (response.sprints && response.sprints.length > 0) {
                    response.sprints.forEach(sprint => {
                        sprintDropdown.append(
                            `<option value="${sprint.id_dg_client_project_sprint}">${sprint.nama_sprint}</option>`
                        );
                    });
                }

                // ** Populate Type Dropdown **
                const typeDropdown = $('#id_type');
                typeDropdown.empty(); // Kosongkan opsi sebelumnya

                if (response.types && response.types.length > 0) {
                    response.types.forEach(type => {
                        typeDropdown.append(
                            `<option value="${type.id_dg_client_project_type}">${type.nama_type}</option>`
                        );
                    });
                }

                // Ambil ID Sprint pertama dari response
                const firstSprintId = response.sprints && response.sprints[0]
                    ? response.sprints[0].id_dg_client_project_sprint
                    : null;

                // Ambil ID Type pertama dari response
                const firstTypeId = response.types && response.types[0]
                    ? response.types[0].id_dg_client_project_type
                    : null;

                let firstTypeDetail = response.types && response.types[0]
                    ? response.types[0].detail_project_tamplate
                    : null;

                
                console.log(firstSprintId, firstTypeId, firstTypeDetail);

                // ** Populate Status Dropdown **
                const statusDropdown = $('#id_status');
                statusDropdown.empty(); // Kosongkan opsi sebelumnya

                if (response.statuses && response.statuses.length > 0) {
                    response.statuses.forEach(status => {
                        statusDropdown.append(
                            `<option value="${status.id}">${status.name}</option>`
                        );
                    });

                    // Pastikan nilai id_status tetap seperti sebelumnya
                    statusDropdown.val(idStatus).trigger('change');
                }


                $('#addTaskModal').modal('show');
                $('#modal-video-upload').addClass('summernote-modal');

                const idProject = <?php echo $id_dg_client_project; ?>;
                const createdBy = <?php echo $id_user; ?>;

                // Data awal yang akan dikirim
                const initialData = {
                    id_project: idProject,
                    id_sprint: firstSprintId ?? 0, // Ambil nilai yang telah disetel
                    id_type: firstTypeId, // Ambil nilai yang telah disetel
                    id_status: idStatus,
                    nama_task: 'New Task', // Nama default
                    priority: $('#priority').val(), // Nilai priority awal
                    detail_project: firstTypeDetail, // Kosongkan detail project di awal
                    created_by: createdBy
                };
                

                // Tampilkan loader di modal
                $('#addTaskModal .modal-body').addClass('loading');
                firstTypeDetail = decodeURIComponent(firstTypeDetail);
                $('#detail_project').summernote('code', firstTypeDetail || "");


                // Kirim data awal ke server untuk disimpan
                $.ajax({
                    url: 'view/ajax/add_task.php',
                    type: 'POST',
                    data: initialData,
                    dataType: 'json',
                    success: function (response) {
                        console.log('Initial Data:', initialData);
                        // Sembunyikan loader
                        $('#addTaskModal .modal-body').removeClass('loading');
                        loadKanban();
                        if (response.success) {
                            // Tampilkan modal setelah berhasil menyimpan
                            $('#id_task').val(response.taskId); // Simpan id_task yang baru dibuat
                            console.log('Task created:', response.taskId);
                            toastr.success('Task created successfully!');
                        } else {
                            toastr.error(`Failed to create task: ${response.message || 'Unknown error'}`);
                            console.error('Failed to create task:', response);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#addTaskModal .modal-body').removeClass('loading');
                        toastr.error(`Failed to create task: ${xhr.responseText || error}`);
                        console.error('Failed to create task:', error);
                    }
                });



            },
            error: function (xhr, status, error) {
                console.error('Failed to load dropdown data:', error);
            }
        });


    });





    let initialDataLoaded = false;

    // Event untuk tombol Edit Task
    $(document).on('click', '.btn-tool[title="Edit Task"]', function () {
        const taskId = $(this).closest('.card-task').data('id-task');

        // Tampilkan modal dan overlay
        $('#addTaskModal').modal('show');
        $('#addTaskModal .loading-overlay').show();
        $('#modal-video-upload').addClass('summernote-modal');

        // Tampilkan loader di modal
        $('#addTaskModal .modal-body').addClass('loading');

        function loadDropdowns() {
            return $.ajax({
                url: 'view/ajax/fetch_dropdown_data.php',
                type: 'GET',
                data: { id_project: '<?php echo $id_dg_client_project; ?>' },
                dataType: 'json'
            }).done(function (response) {
                const sprintDropdown = $('#id_sprint');
                sprintDropdown.empty();
                if (response.sprints && response.sprints.length > 0) {
                    response.sprints.forEach(sprint => {
                        sprintDropdown.append(
                            `<option value="${sprint.id_dg_client_project_sprint}">${sprint.nama_sprint}</option>`
                        );
                    });
                }

                const typeDropdown = $('#id_type');
                typeDropdown.empty();
                if (response.types && response.types.length > 0) {
                    response.types.forEach(type => {
                        typeDropdown.append(
                            `<option value="${type.id_dg_client_project_type}">${type.nama_type}</option>`
                        );
                    });
                }

                const statusDropdown = $('#id_status');
                statusDropdown.empty();
                if (response.statuses && response.statuses.length > 0) {
                    response.statuses.forEach(status => {
                        statusDropdown.append(
                            `<option value="${status.id}">${status.name}</option>`
                        );
                    });
                }
            }).fail(function (xhr, status, error) {
                console.error('Failed to load dropdown data:', error);
            });
        }

        function loadTaskDetails(taskId) {
            return $.ajax({
                url: 'view/ajax/get_task_details.php',
                type: 'GET',
                data: { id_task: taskId },
                dataType: 'json'
            }).done(function (response) {
                $('#addTaskModal .modal-body').removeClass('loading');
                if (response.success) {
                    const latestNotes = decodeURIComponent(response.data.detail_project);
                    if (latestNotes !== 'null') {
                        $('#detail_project').summernote('code', latestNotes || "");
                    }

                    $('#nama_task').val(response.data.nama_task);
                    $('#id_task').val(response.data.id_task);

                    $('#id_status').val(response.data.id_status).trigger('change');
                    $('#id_sprint').val(response.data.id_sprint).trigger('change');
                    $('#id_type').val(response.data.id_type).trigger('change');
                    $('#priority').val(response.data.priority).trigger('change');

                    if (response.data.assignments) {
                        Object.keys(response.data.assignments).forEach(statusId => {
                            const assignmentData = response.data.assignments[statusId];
                            $(`#deadline_${assignmentData[0].id_status}`).val(assignmentData[0].deadline);
                            const selectedUsers = assignmentData.assigned_users ? assignmentData.assigned_users.map(item => item.id_user) : [];
                            const assignUsersSelect = $(`#assign_users_${assignmentData[0].id_status}`);
                            if (assignUsersSelect.length) {
                                assignUsersSelect.val(selectedUsers).trigger('change');
                            } else {
                                console.warn(`Assignment select for status ${assignmentData[0].id_status} not found.`);
                            }
                        });
                    }
                } else {
                    toastr.error(`Failed to load task details: ${response.message || 'Unknown error'}`);
                }
                initialDataLoaded = true;
            }).fail(function (xhr, status, error) {
                $('#addTaskModal .modal-body').removeClass('loading');
                toastr.error(`Failed to load task details: ${xhr.responseText || error}`);
            });
        }

        loadDropdowns()
            .then(() => loadTaskDetails(taskId))
            .always(() => {
                $('#addTaskModal .loading-overlay').hide(); // Sembunyikan overlay setelah loading selesai
            });

    });








    let typingTimer; // Timer untuk delay
    const typingDelay = 2000; // Delay dalam milidetik (2 detik)

    function saveTaskData() {
        var id_task = $('#id_task').val(); // Ganti 'your_hidden_input_id' dengan ID sebenarnya
        if (!id_task) {
            return;
        }
        // Ambil data dari Summernote dan input lainnya
        const detailProject = encodeURIComponent($('#detail_project').summernote('code'));
        const formData = $('#addTaskForm').serializeArray();

        formData.push({ name: 'detail_project', value: detailProject });

        // Tambahkan data deadlines dan users ke formData
        $('#deadlineContainer .form-group').each(function () {
            const deadlineInput = $(this).find('input[type="date"]');
            if (deadlineInput.length > 0) {
                const idAttr = deadlineInput.attr('id');
                if (idAttr) {
                    const statusId = idAttr.split('_')[1]; // Ambil ID status
                    const deadline = $(`#deadline_${statusId}`).val(); // Ambil nilai deadline
                    const assignedUsers = $(`#assign_users_${statusId}`).val(); // Ambil nilai assign users (array)
                    if (assignedUsers && assignedUsers.length > 0) {
                        assignedUsers.forEach(userId => {
                            formData.push({
                                name: `assign[${statusId}][]`,
                                value: JSON.stringify({ id_user: userId, deadline: deadline })
                            });
                        });
                    }
                }
            }
        });

        console.log("Data yang dikirim:", formData);

        // Tampilkan loader
        $('#addTaskModal .modal-body').addClass('loading');

        $.ajax({
            url: 'view/ajax/update_task.php',
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function (response) {
                loadKanban();
                $('#addTaskModal .modal-body').removeClass('loading');
                if (response.success) {
                    toastr.success('Task updated successfully!');
                } else {
                    toastr.error(`Failed to update task: ${response.message || 'Unknown error'}`);
                    console.error('Failed to update task:', response);
                }
            },
            error: function (xhr, status, error) {
                $('#addTaskModal .modal-body').removeClass('loading');
                toastr.error(`Failed to update task: ${xhr.responseText || error}`);
                console.error('Failed to update task:', error);
            }
        });
    }

    // Fungsi untuk menunda penyimpanan saat mengetik
    function debounceSaveTaskData() {
        console.log('Debouncing...');
        if (!initialDataLoaded) {
            return; // Lewati penyimpanan jika data awal sedang dimuat
        }
        clearTimeout(typingTimer); // Hentikan timer sebelumnya
        typingTimer = setTimeout(saveTaskData, typingDelay); // Mulai timer baru
    }


    let previousTypeId = null; // Variabel untuk menyimpan ID type sebelumnya
    let previousTemplate = null; // Variabel untuk menyimpan template type sebelumnya

    // Simpan nilai sebelum perubahan saat Select2 dibuka
    $('#id_type').on('select2:opening', function () {
        previousTypeId = $(this).val(); // Simpan ID type yang dipilih sebelum perubahan
        console.log("Previous id_type (before change): " + previousTypeId);
    });

    // Event listener untuk perubahan pada Select2
    $('#id_type').on('select2:select', function (e) {
        const newTypeId = e.params.data.id; // ID type yang baru dipilih
        console.log("Previous id_type: " + previousTypeId);
        console.log("New id_type: " + newTypeId);

        if (previousTypeId && newTypeId !== previousTypeId) {
            // Jika ID type berubah, cek dan update detail_project
            checkAndUpdateDetailProject(previousTypeId, newTypeId);
        }

        // Perbarui previousTypeId ke nilai baru setelah perubahan selesai
        previousTypeId = newTypeId;
    });

    

    // Fungsi untuk mengecek dan memperbarui detail_project
    function checkAndUpdateDetailProject(typeId, newTypeId) {
        fetchTemplateByTypeId(typeId).then((response) => {
            if (response.success) {
                const currentDetailProject = decodeURIComponent($('#detail_project').summernote('code'));
                const typeTemplate = decodeURIComponent(response.template);

                console.log("previousTemplate: "+previousTemplate);
                console.log("currentDetailProject: "+currentDetailProject);
                console.log("typeTemplate: "+typeTemplate);
                

                // Cek apakah detail_project belum diubah atau masih null
                if (!currentDetailProject || currentDetailProject.trim() == '' || currentDetailProject == typeTemplate) {
                    // Perbarui detail_project dengan template baru
                    fetchNewTemplateByTypeId(newTypeId).then((response) => {
                        if (response.success) {
                            const newtypeTemplate = decodeURIComponent(response.template);
                            $('#detail_project').summernote('code', newtypeTemplate);
                            console.log("newtypeTemplate: "+newtypeTemplate);
                        } else {
                            toastr.warning('Failed to fetch the new template for the selected type.');
                        }
                    }).catch((error) => {
                        console.error('Error fetching new template:', error);
                        toastr.error('An error occurred while fetching the new template.');
                    });
                    
                    toastr.info('Detail project updated with the new type template.');
                } else {
                    toastr.warning('Detail project was modified and will not be updated.');
                }

                // Simpan template sebelumnya
                previousTemplate = typeTemplate;
            } else {
                toastr.error('Failed to fetch the template for the selected type.');
            }
        }).catch((error) => {
            console.error('Error fetching template:', error);
            toastr.error('An error occurred while fetching the template.');
        });
    }

    // Fungsi untuk mengambil template berdasarkan ID type
    function fetchTemplateByTypeId(typeId) {
        return $.ajax({
            url: 'view/ajax/get_type_template.php', // Endpoint untuk mengambil template
            type: 'GET',
            data: { id_type: typeId },
            dataType: 'json'
        });
    }

    function fetchNewTemplateByTypeId(typeId) {
        return $.ajax({
            url: 'view/ajax/get_type_template.php', // Endpoint untuk mengambil template
            type: 'GET',
            data: { id_type: typeId },
            dataType: 'json'
        });
    }

  


    // Event untuk perubahan lainnya pada form
    $('#addTaskForm').on('change', function () {
        console.log('Change...');
        if (!initialDataLoaded) {
            return; // Lewati penyimpanan jika data awal sedang dimuat
        }
        saveTaskData();
    });




        $('#addTaskModal').on('hidden.bs.modal', function (e) {
            console.log('Hiden...');
            saveTaskData(); // Simpan data saat modal ditutup
            initialDataLoaded = false;

             // Reset form dengan jQuery
            $('#addTaskForm')[0].reset();
            $('#id_task').val(null);
            
            // Reset Select2
            $('#id_status').val(null).trigger('change'); // Penting: trigger change untuk Select2
            $('#id_sprint').val(null).trigger('change');
            $('#id_type').val(null).trigger('change');
            if (typeof firstOptionValue !== 'undefined' && firstOptionValue !== null ) { // Memeriksa undefined DAN null
                $('#priority').val(firstOptionValue).trigger('change');
            }
            $('#assign_users_22').val(null).trigger('change'); // contoh jika ada assign users
            $('#assign_users_23').val(null).trigger('change'); // contoh jika ada assign users

            // Reset Summernote
            $('#detail_project').summernote('code', ''); // Set konten Summernote menjadi kosong

            // Hapus input date yang di generate
            $('#deadlineContainer .form-group:not(:first)').remove();

            // Reset input date pertama
            $('#deadlineContainer .form-group:first input[type="date"]').val('');
        });




    $(document).on('hide.bs.modal', '#addTaskModal', function () {
        $('.dropdown-menu').removeClass('show');
    });

    // Handle klik tombol dropdown menggunakan event delegation
    $(document).on('click', '.dropdown-toggle', function (e) {
        e.stopPropagation(); // Hindari dropdown tertutup langsung
        const menu = $(this).siblings('.dropdown-menu');
        menu.toggleClass('show');
    });
    

    $('#saveAsTamplate').on('click', function () {
        const id_type = $('#id_type').val();
        const notes_project_task = encodeURIComponent($('#detail_project').summernote('code')); // Ambil data Summernote

        if (!id_type) {
            toastr.error('No Template to save.');
            return;
        }

        if (confirm('Are you sure you want to save this template? The previous template will be replaced for this project.')) {
            $.ajax({
                url: 'view/ajax/update_tamplate.php', // Endpoint untuk menyimpan template
                type: 'POST',
                data: { 
                    id_type: id_type, 
                    id_user: <?php echo $id_user; ?>, 
                    notes_project_task: notes_project_task 
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success('Template saved successfully!');
                    } else {
                        toastr.error(response.message || 'Failed to save template.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error(`Error saving template: ${xhr.responseText || error}`);
                }
            });
        }
    });


    $('#deleteTaskButton').on('click', function () {
        const taskId = $('#id_task').val();
        if (!taskId) {
            toastr.error('No task to delete.');
            return;
        }

        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            $.ajax({
                url: 'view/ajax/delete_task.php', // Endpoint untuk menghapus task
                type: 'POST',
                data: { id_task: taskId, id_user : <?php echo $id_user; ?>},
                success: function (response) {
                    if (response.success) {
                        toastr.success('Task deleted successfully!');
                        $('#addTaskModal').modal('hide');
                        loadKanban(); // Memperbarui kanban setelah penghapusan
                    } else {
                        toastr.error(response.message || 'Failed to delete task.');
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error(`Error deleting task: ${xhr.responseText || error}`);
                }
            });
        }
    });









            // Variabel untuk melacak status drag
            let isDragging = false;

            // Function to initialize Sortable
            function initSortable() {
                const kanbanColumns = document.querySelectorAll('.card-row .status-body');

                // Menampilkan overlay sebelum proses
                function showOverlay() {
                    $('#workspace-overlay').show();
                }

                // Menyembunyikan overlay setelah proses
                function hideOverlay() {
                    setTimeout(() => {
                        loadKanban();
                        $('#workspace-overlay').hide();
                    }, 500); // Delay 0.5 detik
                }

                kanbanColumns.forEach(column => {
                    new Sortable(column, {
                        group: {
                            name: 'kanban',
                            put: function (to, from, dragged) {
                                const toColumn = to.el.closest('.card-row');
                                if (toColumn && toColumn.classList.contains('no-status')) {
                                    return false;
                                }
                                return true;
                            },
                            pull: function (to, from, dragged) {
                                const fromColumn = from.el.closest('.card-row');
                                if (fromColumn && fromColumn.classList.contains('no-status')) {
                                    return true;
                                }
                                return true;
                            }
                        },
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        handle: '.card-task',
                        draggable: '.card-task',
                        filter: '.custom-control',
                        preventOnFilter: true,
                        onStart: function () {
                            isDragging = true;
                        },
                        onEnd: function (evt) {
                            isDragging = false;
                            showOverlay();

                            const taskElement = evt.item;
                            const taskId = taskElement.dataset.idTask;
                            const newStatusElement = evt.to.closest('.card-row');
                            const newStatusId = newStatusElement.dataset.idStatus;

                            const taskElements = Array.from(evt.to.children);
                            const newOrder = taskElements.map((task, index) => ({
                                id: task.dataset.idTask,
                                urutan_task: index + 1
                            }));

                            // Jalankan AJAX secara paralel dengan Promise.all
                            const updateStatusPromise = $.ajax({
                                url: 'view/ajax/update_task_status.php',
                                type: 'POST',
                                data: {
                                    id_task: taskId,
                                    id_status: newStatusId,
                                    id_user: '<?php echo $id_user; ?>',
                                    tasks: newOrder
                                },
                                dataType: 'json'
                            });



                            Promise.all([updateStatusPromise])
                                .then(([statusResponse]) => {
                                    if (statusResponse.success) {
                                        toastr.success('Task status updated successfully!', 'Success');
                                    } else {
                                        toastr.error('Failed to update task status.', 'Error');
                                    }

                                    // Reload Kanban hanya setelah semua proses selesai
                                    return loadKanban();
                                })
                                .catch(error => {
                                    console.error('An error occurred:', error);
                                    toastr.error('An error occurred while updating tasks.', 'Error');
                                })
                                .finally(() => {
                                    // Overlay hanya di-hide setelah semua proses selesai
                                    setTimeout(() => {
                                        hideOverlay();
                                    }, 500); // Tambahkan delay kecil untuk memastikan stabilitas
                                });
                        }
                    });
                });


                // Sortable for status columns
                new Sortable(document.getElementById('kanban-board'), {
                    group: 'columns',
                    animation: 100,
                    handle: '.status-head',
                    filter: '.add-status',
                    preventOnFilter: true, // Mencegah elemen yang difilter untuk di-drag
                    ghostClass: 'sortable-ghost',
                    onMove: function (evt) {
                        // Cegah pemindahan elemen ke belakang Add Status
                        const draggedElement = evt.dragged;
                        const targetElement = evt.related;

                        if (targetElement.classList.contains('add-status')) {
                            return false; // Batalkan jika target adalah Add Status
                        }
                    },
                    onStart: function () {
                        isDragging = true; // Set isDragging to true saat mulai drag
                    },
                    onEnd: function (evt) {
                        isDragging = false; // Set kembali ke false saat drag selesai
                        showOverlay(); // Tampilkan overlay saat pengiriman data dimulai

                        const statusElements = document.querySelectorAll('.card-row');
                        const newOrder = Array.from(statusElements).map((statusElement, index) => ({
                            id: statusElement.dataset.idStatus,
                            order: index + 1
                        }));

                        // Kirim urutan baru ke server
                        $.ajax({
                            url: 'view/ajax/update_status_order.php',
                            type: 'POST',
                            data: {
                                statuses: newOrder,
                                id_dg_user: <?php echo $id_user; ?>
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    toastr.success('Status order updated successfully!', 'Success');
                                } else {
                                    toastr.error('Failed to update status order.', 'Error');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Failed to update status order:', error);
                                toastr.error('An error occurred while updating status order.', 'Error');
                            },
                            complete: function () {
                                hideOverlay();
                            }
                        });
                    }
                });
            }


           



            // Load Kanban initially and conditionally refresh every 10 seconds
            function conditionalLoadKanban() {
                if (!isDragging) {
                    loadKanban();
                    console.log("conditionalLoadKanban");
                }
            }

            // Load Kanban pertama kali
            loadKanban();

            // Reinitialize Kanban setiap 10 detik jika tidak sedang drag
            //setInterval(conditionalLoadKanban, 20000);





























            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                // Initialize Select2 for Sprint and Type dropdowns
                $('.select2_task').select2({
                    tags: true, // Enable tagging (allows adding new options)
                    placeholder: "Select or type to add",
                    allowClear: true,
                    createTag: function (params) {
                        // Customize the new option text
                        return {
                            id: params.term,
                            text: params.term,
                            newOption: true
                        };
                    },
                    templateResult: function (data) {
                        // Highlight new options
                        var $result = $("<span></span>");
                        $result.text(data.text);
                        if (data.newOption) {
                            $result.append(" <em>(new)</em>");
                        }
                        return $result;
                    }
                });


                // Inisialisasi Select2 pada Sprint Dropdown
                $('#id_sprint').select2({
                    tags: true, // Izinkan input baru
                    placeholder: "Select or type to add a sprint",
                    allowClear: true,
                    createTag: function (params) {
                        const term = $.trim(params.term);
                        if (term === '') {
                            return null; // Abaikan input kosong
                        }
                        return {
                            id: term,
                            text: term,
                            newOption: true // Tandai sebagai opsi baru
                        };
                    },
                    escapeMarkup: function (markup) {
                        return markup; // Izinkan HTML dalam opsi
                    },
                    templateResult: function (data) {
                        if (!data.id) {
                            return data.text; // Default rendering untuk placeholder
                        }

                        if (data.newOption) {
                            return `<span>Add new sprint: <strong>${data.text}</strong></span>`;
                        }

                        // Render dengan format kustom
                        return `<span>${data.text}</span>`;
                    },
                    templateSelection: function (data) {
                        return data.text; // Default rendering untuk opsi yang dipilih
                    }
                });

                // Event listener untuk opsi baru
                $('#id_sprint').on('select2:select', function (e) {
                    const selectedData = e.params.data;

                    // Periksa apakah opsi baru
                    if (selectedData.newOption) {
                        const idProject = '<?php echo $id_dg_client_project; ?>'; // ID project dari PHP
                        const namaSprint = selectedData.text;

                        $.ajax({
                            url: 'view/ajax/insert_sprint.php', // Endpoint untuk menyimpan data baru
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id_project: idProject,
                                nama_sprint: namaSprint
                            },
                            success: function (response) {
                                if (response.success) {
                                    loadFilterData();
                                    toastr.success('Sprint added successfully!');
                                    // Tambahkan opsi baru dengan format yang diinginkan
                                    const sprintText = `${namaSprint}`;
                                    const newOption = new Option(sprintText, response.data.id, true, true);
                                    $('#id_sprint').append(newOption).trigger('change');
                                } else {
                                    toastr.error(response.message || 'Failed to add sprint.');
                                }
                            },
                            error: function (xhr, status, error) {
                                toastr.error(`Error adding sprint: ${xhr.responseText || error}`);
                            }
                        });
                    }
                });
                


                // Initialize Select2 with custom actions
                $('.select2-with-actions').select2({
                    tags: true, // Enable tagging
                    placeholder: "Select or type to add",
                    allowClear: true,
                    escapeMarkup: function (markup) {
                        return markup; // Allow custom HTML
                    },
                    templateResult: function (data) {
                        if (!data.id) {
                            return data.text; // Default rendering for placeholder
                        }

                        // Create option with action buttons
                        const optionTemplate = `
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>${data.text}</span>
                                <button class="btn btn-sm btn-secondary action-btn"
                                    data-id="${data.id}" style="padding: 0 5px;">
                                    ...
                                </button>
                            </div>
                        `;
                        return optionTemplate;
                    },
                    templateSelection: function (data) {
                        return data.text; // Default selection behavior
                    }
                });

                // Handle clicks on action buttons
                $(document).on('click', '.action-btn', function (e) {
                    e.stopPropagation(); // Prevent dropdown from closing

                    const selectedOptionId = $(this).data('id');
                    const dropdownMenu = `
                        <div class="dropdown-menu-x" style="display: block; position: absolute; z-index: 1000;">
                            <a href="#" class="dropdown-item edit-option" data-id="${selectedOptionId}">Edit</a>
                            <a href="#" class="dropdown-item delete-option" data-id="${selectedOptionId}">Delete</a>
                        </div>
                    `;

                    // Remove existing menus and show the current one
                    $('.dropdown-menu-x').remove();
                    $(this).after(dropdownMenu);
                });

                // Handle clicks on dropdown menu items
                $(document).on('click', '.edit-option', function (e) {
                    e.preventDefault();
                    const optionId = $(this).data('id');
                    alert(`Edit option with ID: ${optionId}`);
                    $('.dropdown-menu-x').remove();
                });

                $(document).on('click', '.delete-option', function (e) {
                    e.preventDefault();
                    const optionId = $(this).data('id');
                    alert(`Delete option with ID: ${optionId}`);
                    $('.dropdown-menu-x').remove();
                });

                // Hide dropdown menu when clicking elsewhere
                $(document).on('click', function () {
                    $('.dropdown-menu-x').remove();
                });





                //Datemask dd/mm/yyyy
                $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

                //Money Euro
                $('[data-mask]').inputmask()

    
                //Date range picker
                $('#reservation').daterangepicker()


                //Timepicker
                $('#timepicker').datetimepicker({
                format: 'LT'
                })

                //Bootstrap Duallistbox
                $('.duallistbox').bootstrapDualListbox()


                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });

            })








            function toggleCard(element) {
                // Cari elemen card utama
                const card = element.closest('.card');
                // Aktifkan event collapse dari data-card-widget
                $(card).CardWidget('toggle');
            }
            
            var element = document.getElementById("attend");
            element.classList.add("collapsed-card");

            var element2 = document.getElementById("filter");
            element2.classList.add("collapsed-card");
            






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


                document.getElementById("link_name").innerHTML = recipient_v;
            })




            $(document).ready(function() {


                // Event handler untuk menangkap saat modal tertutup
                $('#modal-edit-link').on('hidden.bs.modal', function (e) {
                    // Kosongkan nilai input
                    $('#linkName').val('');
                    $('#linkProject').val('');
                });
                
                checkConnection();
                setInterval(checkConnection, 3000); // Cek setiap 1 detik
            });



            $(function () {
                    var isTyping = false;
                    var typingTimer;

                    var isTypingTask = false;
                    var typingTimerTask;

                    var isVideoPlaying = false;
                    var typingInterval = 5000;

                    var debounceTimer;
                    var debounceInterval = 3000;

                    var ajaxInterval;

                    
                    // Tambahkan plugin custom ke Summernote terlebih dahulu
                    $.extend($.summernote.plugins, {
                        'videoUpload': function (context) {
                            const ui = $.summernote.ui;

                            // Tambahkan tombol ke toolbar untuk upload video atau memasukkan URL video
                            context.memo('button.videoUpload', function () {
                                return ui.button({
                                    contents: '<i class="fa fa-video"></i>', // Ikon FontAwesome
                                    tooltip: 'Upload Video / Insert Video URL',
                                    click: function () {
                                        // Tampilkan modal ketika tombol ditekan
                                        $('#modal-video-upload').modal('show');
                                    }
                                }).render();
                            });
                        }
                    });

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
                        maximumImageFileSize: 1540 * 1024,
                        callbacks: {
                            // Mendukung memasukkan video melalui URL
                            onLinkInsert: function(url) {
                                if (url.includes("youtube") || url.includes("vimeo")) {
                                    // Deteksi link video YouTube atau Vimeo dan masukkan embed code
                                    var embedCode = generateEmbedCode(url);
                                    $('#summernote').summernote('insertNode', $(embedCode)[0]);
                                } else {
                                    // Jika bukan video URL, gunakan URL biasa
                                    $('#summernote').summernote('insertLink', url);
                                }
                            },
                            onMediaUpload: function(files) {
                                for (var i = 0; i < files.length; i++) {
                                    var fileType = files[i].type.split('/')[0];
                                    if (fileType === "video") {
                                        uploadMedia(files[i], "video");
                                    } else {
                                        toastr.error("Unsupported file type. Only videos are allowed.");
                                    }
                                }
                            },
                            onMediaUploadError: function() {
                                toastr.error('Error during media upload.');
                            },
                            onKeyup: function(contents, $editable) {
                                debounceSaveNotes();
                            },
                            onBlur: function() {
                                //saveNotes("onBlur");
                                typingTimer = setTimeout(function() {
                                    isTyping = false;
                                }, typingInterval);
                            },
                            onFocus: function() {
                                isTyping = true;
                                clearTimeout(typingTimer);
                            },
                            onImageUpload: function(files, editor, welEditable) {
                                for(var i = files.length - 1; i >= 0; i--) {
                                    uploadImage(files[i], this);
                                }
                            },
                            onImageUploadError: function() {
                                toastr.error('Error !');
                            }
                           
                        }
                    });

                    $('.detail_project').summernote({
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
                                maximumImageFileSize: 1540 * 1024,
                                callbacks: {
                                    // Mendukung memasukkan video melalui URL
                                    onLinkInsert: function(url) {
                                        if (url.includes("youtube") || url.includes("vimeo")) {
                                            // Deteksi link video YouTube atau Vimeo dan masukkan embed code
                                            var embedCode = generateEmbedCode(url);
                                            $('#detail_project').summernote('insertNode', $(embedCode)[0]);
                                        } else {
                                            // Jika bukan video URL, gunakan URL biasa
                                            $('#detail_project').summernote('insertLink', url);
                                        }
                                    },
                                    onMediaUpload: function(files) {
                                        for (var i = 0; i < files.length; i++) {
                                            var fileType = files[i].type.split('/')[0];
                                            if (fileType === "video") {
                                                uploadMediaTask(files[i], "video");
                                            } else if (fileType === "image") {
                                                uploadMediaTask(files[i], "image");
                                            } else {
                                                toastr.error("Unsupported file type. Only videos and images are allowed.");
                                            }
                                        }
                                    },
                                    onImageUpload: function(files) {
                                        for (var i = 0; i < files.length; i++) {
                                            uploadImageTask(files[i], this);
                                        }
                                    },
                                    onImageUploadError: function() {
                                        toastr.error('Error during image upload.');
                                    },
                                    onMediaUploadError: function() {
                                        toastr.error('Error during media upload.');
                                    },
                                    onKeyup: function(contents, $editable) {
                                        debounceSaveTaskData();
                                    },
                                    onBlur: function() {
                                        typingTimerTask = setTimeout(function() {
                                            isTypingTask = false;
                                        }, typingInterval);
                                    },
                                    onFocus: function() {
                                        isTypingTask = true;
                                        clearTimeout(typingTimerTask);
                                    },
                                },
                                dialogsInBody: true, // Menambahkan dialog Summernote ke body
                                dialogsFade: true // Animasi fade modal
                    });


                    // Event listener untuk menangani sebelum tab atau browser ditutup
                    window.addEventListener('beforeunload', function (e) {
                        // Jalankan fungsi saveNotes("closed") sebelum tab atau browser ditutup
                        saveNotes("closed");
                        saveTaskData();
                    });

                    

                    // Ketika memilih video dari file
                    $('#note-dialog-video-file').on('change', function () {
                        const file = this.files[0];
                        if (file) {
                            uploadMedia(file, 'video');
                            $('#insertVideoBtn').prop('disabled', false); // Enable the insert button
                        }
                        checkForUpdates();
                    });

                    // Ketika memasukkan URL video
                    $('#note-dialog-video-url').on('input', function () {
                        var videoUrl = $(this).val();
                        if (videoUrl.trim()) {
                            $('#insertVideoBtn').prop('disabled', false); // Enable the insert button
                        } else {
                            $('#insertVideoBtn').prop('disabled', true); // Disable if URL is empty
                        }
                    });

                    // Aksi ketika tombol "Insert Video" ditekan
                    $('#insertVideoBtn').on('click', function () {
                        var videoUrl = $('#note-dialog-video-url').val();
                        if (videoUrl) {
                            insertVideoUrl(videoUrl);
                        } else {
                            var file = $('#note-dialog-video-file')[0].files[0];
                            if (file) {
                                uploadMedia(file, 'video');
                            }
                        }
                        $('#modal-video-upload').modal('hide'); // Menutup modal setelah video dimasukkan
                    });
    



                    // Fungsi untuk generate embed code dari video URL (misal YouTube, Vimeo, Google Drive)
                    function generateEmbedCode(url) {
                        var embedCode = '';

                        // Mendukung YouTube
                        if (url.includes("youtube.com")) {
                            var videoId = url.split('v=')[1].split('&')[0];
                            embedCode = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe>';
                        
                        // Mendukung Vimeo
                        } else if (url.includes("vimeo.com")) {
                            var videoId = url.split('/').pop();
                            embedCode = '<iframe src="https://player.vimeo.com/video/' + videoId + '" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';

                        // Mendukung Google Drive
                        } else if (url.includes("drive.google.com")) {
                            var fileId = url.split('/d/')[1].split('/')[0];
                            embedCode = '<iframe src="https://drive.google.com/file/d/' + fileId + '/preview" width="640" height="480" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';

                        // Mendukung video lainnya (misalnya, link direct video MP4, atau format lainnya)
                        } else if (url.match(/\.(mp4|webm|ogg)$/)) {
                            embedCode = '<video width="640" height="360" controls><source src="' + url + '" type="video/' + url.split('.').pop() + '">Your browser does not support the video tag.</video>';
                        }

                        // Menyisipkan kode embed ke dalam Summernote setelah perubahan konten
                        $('#summernote').one('summernote.change', function() {
                            var notes_project = encodeURIComponent($('#summernote').val());
                            console.log("depan = " + $('#summernote').val());
                            saveNotes("uploadVideoLink"); // Pastikan saveNotes dipanggil setelah video link dimasukkan
                        });

                        return embedCode;
                    }


                // Fungsi untuk memasukkan URL video ke Summernote
                function insertVideoUrl(url) {
                    if (url) {
                        var embedCode = generateEmbedCode(url);
                        var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            $('#summernote').summernote('insertNode', $(embedCode)[0]);
                        } else {
                            $('#detail_project').summernote('insertNode', $(embedCode)[0]);
                        }
                        
                    } else {
                        toastr.error('URL video tidak valid.');
                    }
                }






                function insertContentAtCursor(content) {
                    var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            var range = $('#summernote').summernote('createRange');
                        } else {
                            var range = $('#detail_project').summernote('createRange');
                        }

                    if (range) {
                        // Ambil elemen editor dan kontennya
                        var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            var editorElement = $('#summernote').next('.note-editor').find('.note-editable')[0];
                        }else{
                            var editorElement = $('#detail_project').next('.note-editor').find('.note-editable')[0];
                        }
                        
                        var editorContent = editorElement.innerHTML;

                        // Posisi awal dan akhir kursor
                        var startNode = range.sc; // Start container (node)
                        var startOffset = range.so; // Start offset (index dalam node)
                        var endNode = range.ec; // End container (node)
                        var endOffset = range.eo; // End offset (index dalam node)

                        // Ambil konten sebelum kursor
                        var beforeCursor = editorContent.substring(0, editorContent.indexOf(startNode.textContent) + startOffset);

                        // Gunakan execCommand untuk menyisipkan konten
                        document.execCommand('insertHTML', false, content);

                        // Ambil kembali konten setelah kursor (update DOM setelah execCommand)
                        var updatedContent = editorElement.innerHTML;
                        var afterCursor = updatedContent.substring(updatedContent.indexOf(endNode.textContent) + endOffset);

                        // Gabungkan konten baru dengan beforeCursor dan afterCursor
                        var newContent = beforeCursor + afterCursor;

                        var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            // Update konten editor secara manual
                            $('#summernote').summernote('code', newContent);

                            // Fokus kembali ke editor
                            $('#summernote').summernote('focus');
                        } else {
                            // Update konten editor secara manual
                            $('#detail_project').summernote('code', newContent);

                            // Fokus kembali ke editor
                            $('#detail_project').summernote('focus');
                        }
                    } else {
                        toastr.error('Unable to determine cursor position.');
                    }
                }









                // Fungsi untuk upload gambar dengan progress bar di toastr
                function uploadImage(file) {
                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('id_dg_client_project', '<?php echo $id_dg_client_project; ?>');

                    var toast = toastr.info('Uploading image...', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeout to 0 to prevent auto-close
                        extendedTimeOut: 0, // Prevent closing after time
                        tapToDismiss: false,
                    });

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'view/ajax/upload_image.php', true);

                    // Mengupdate progress bar
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = (e.loaded / e.total) * 100;
                            toastr.options.progressBar = true;
                            toast.find('.toast-progress').css('width', percent + '%');
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    $('#summernote').summernote('insertImage', response.imageUrl);
                                    toastr.success('Image uploaded successfully!');
                                    $('#summernote').one('summernote.change', function() {
                                        // Callback dijalankan setelah gambar dimasukkan ke editor
                                        var notes_project = encodeURIComponent($('#summernote').val());
                                        console.log("deapan = "+$('#summernote').val());
                                        saveNotes("uploadImage"); // Pastikan saveNotes dipanggil setelah gambar masuk ke Summernote
                                    });
                                } else {
                                    toastr.error(response.message || 'Failed to upload image.');
                                }
                                toast.remove(); // Close the toast after upload
                            } else {
                                toastr.error('Error during upload');
                                toast.remove();
                            }
                        }
                    };

                    xhr.send(formData);
                }


                // Fungsi untuk upload gambar dengan progress bar di toastr
                function uploadImageTask(file) {
                    var formData = new FormData();
                    var id_task = $('#id_task').val(); // Ganti 'your_hidden_input_id' dengan ID sebenarnya
                    formData.append('file', file);
                    formData.append('id_task', id_task);
                    

                    var toast = toastr.info('Uploading image...', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeout to 0 to prevent auto-close
                        extendedTimeOut: 0, // Prevent closing after time
                        tapToDismiss: false,
                    });

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'view/ajax/upload_image_task.php', true);

                    // Mengupdate progress bar
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = (e.loaded / e.total) * 100;
                            toastr.options.progressBar = true;
                            toast.find('.toast-progress').css('width', percent + '%');
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    $('#detail_project').summernote('insertImage', response.imageUrl);
                                    toastr.success('Image uploaded successfully!');
                                    console.log("deapan = "+$('#detail_project').val());
                                    $('#detail_project').one('summernote.change', function() {
                                        // Callback dijalankan setelah gambar dimasukkan ke editor
                                        var notes_project_task = encodeURIComponent($('#detail_project').val());
                                        console.log("deapan = "+$('#detail_project').val());
                                        //saveNotes("uploadImage"); // Pastikan saveNotes dipanggil setelah gambar masuk ke Summernote
                                    });
                                } else {
                                    toastr.error(response.message || 'Failed to upload image.');
                                }
                                toast.remove(); // Close the toast after upload
                            } else {
                                toastr.error('Error during upload');
                                toast.remove();
                            }
                        }
                    };

                    xhr.send(formData);
                }











                // Variabel global untuk menyimpan range
                var savedRange = null;

                // Simpan posisi kursor sebelum modal muncul
                $('#modal-video-upload').on('show.bs.modal', function () {
                    var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            savedRange = $('#summernote').summernote('createRange');
                        } else {
                            savedRange = $('#detail_project').summernote('createRange');
                        }
                });

                // Fungsi untuk upload media video dengan progress bar di toastr
                function uploadMedia(file, type) {
                    var formData = new FormData();
                    var id_task = $('#id_task').val(); 
                    formData.append('file', file);
                    formData.append('type', type);
                    formData.append('id_task', id_task);
                    formData.append('id_dg_client_project', '<?php echo $id_dg_client_project; ?>');

                    var toast = toastr.info('Uploading video...', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeout to 0 to prevent auto-close
                        extendedTimeOut: 0, // Prevent closing after time
                        tapToDismiss: false,
                    });

                    var xhr = new XMLHttpRequest();
                    
                        if (!id_task) {
                            xhr.open('POST', 'view/ajax/upload_media.php', true);
                        } else {
                            xhr.open('POST', 'view/ajax/upload_media_task.php', true);
                        }

                    // Mengupdate progress bar
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = (e.loaded / e.total) * 100;
                            toastr.options.progressBar = true;
                            toast.find('.toast-progress').css('width', percent + '%');
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    console.log(response);
                                    var videoUrl = response.videoUrl;
                                    console.log(videoUrl);


                                    // Membuat elemen video
                                    var videoCode = `<br><video height="210" controls src="${videoUrl}"></video><br><br>`;

                                    insertContentAtCursor(videoCode);

                                    toastr.success('Video uploaded successfully!');
                                    var id_task = $('#id_task').val(); 
                                    if (!id_task) {
                                        saveNotes("uploadVideo"); 
                                    } else {
                                        saveTaskData();
                                    }
                                    // Menutup modal dan membersihkan isinya
                                    $('#modal-video-upload').modal('hide'); // Ganti dengan ID modal sesuai dengan modal video upload Anda
                                    $('#modal-video-upload').find('input[type="file"]').val(''); // Bersihkan input file
                                    $('#modal-video-upload').find('textarea').val(''); // Bersihkan textarea atau elemen lain di modal jika ada

                                    // Fokus kembali ke Summernote setelah modal ditutup
                                    setTimeout(function() {
                                        var id_task = $('#id_task').val(); 
                                        if (!id_task) {
                                            checkForUpdates();
                                            $('#summernote').focus(); // Fokus ke Summernote
                                        } else {
                                            $('#detail_project').focus(); // Fokus ke Summernote
                                        }
                                    }, 500); // Memberikan sedikit jeda agar modal benar-benar tertutup sebelum fokus ke Summernote

                                } else {
                                    toastr.error(response.message || 'Failed to upload video.');
                                }
                                toast.remove(); // Close the toast after upload
                            } else {
                                toastr.error('Error during upload');
                                toast.remove();
                            }
                        }
                    };

                    xhr.send(formData);
                }




                    // Fungsi untuk menambahkan event listener pada elemen video
                    function setupVideoListeners() {
                        var id_task = $('#id_task').val(); 
                        if (!id_task) {
                            $('#summernote').next('.note-editor').find('video').each(function () {
                                var videoElement = this;

                                if (!$(videoElement).data('hasEventListeners')) {
                                    $(videoElement).data('hasEventListeners', true);

                                    videoElement.addEventListener('play', function () {
                                        isVideoPlaying = true;
                                        clearInterval(ajaxInterval);
                                        console.log("Video is playing, AJAX refresh stopped.");
                                    });

                                    videoElement.addEventListener('pause', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        console.log("Video is paused, AJAX refresh resumed.");
                                    });

                                    videoElement.addEventListener('ended', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        console.log("Video ended, AJAX refresh resumed.");
                                    });
                                }
                            });
                        } else {
                            $('#detail_project').next('.note-editor').find('video').each(function () {
                                var videoElement = this;

                                if (!$(videoElement).data('hasEventListeners')) {
                                    $(videoElement).data('hasEventListeners', true);

                                    videoElement.addEventListener('play', function () {
                                        isVideoPlaying = true;
                                        clearInterval(ajaxInterval);
                                        console.log("Video is playing, AJAX refresh stopped.");
                                    });

                                    videoElement.addEventListener('pause', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        console.log("Video is paused, AJAX refresh resumed.");
                                    });

                                    videoElement.addEventListener('ended', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        console.log("Video ended, AJAX refresh resumed.");
                                    });
                                }
                            });
                        }
                    }

                    // Fungsi debounce untuk menyimpan catatan
                    function debounceSaveNotes() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(function() {
                            saveNotes("debounceSaveNotes");
                            toastr.success('Note updated successfully!', 'Success');
                        }, debounceInterval);
                        checkForUpdates();
                    }

                    // Fungsi menyimpan catatan
                    function saveNotes(factor) {
                        var notes_project = encodeURIComponent($('#summernote').val());
                        var id_dg_client_project = '<?php echo $id_dg_client_project; ?>';

                        $.ajax({
                            url: 'view/ajax/save_note_project.php', // File PHP untuk menyimpan data
                            type: 'POST',
                            data: {
                                notes_project: notes_project,
                                id_dg_client_project: id_dg_client_project
                            },
                            success: function(response) {
                                console.log(factor);
                                console.log(document.getElementById("summernote").value);
                                console.log(notes_project);
                                console.log(response);
                                console.log("Notes saved successfully.");
                            },
                            error: function() {
                                console.error("Error while saving notes.");
                                toastr.error("Error while saving notes.");
                            }
                        });
                    }

                    // Fungsi untuk mengecek pembaruan
                    function checkForUpdates() {
                        if (!isTyping) {
                            var id_dg_client_project = '<?php echo $id_dg_client_project; ?>';

                            $.ajax({
                                url: 'view/ajax/get_note_project.php',
                                type: 'GET',
                                data: { id_dg_client_project: id_dg_client_project },
                                success: function(response) {
                                    try {
                                        var jsonResponse = JSON.parse(response);
                                        var latestNotes = decodeURIComponent(jsonResponse.notes_project);
                                        var currentNotes = $('#summernote').summernote('code');

                                        if (latestNotes !== currentNotes) {
                                            $('#summernote').summernote('code', latestNotes);
                                        }
                                    } catch (error) {
                                        console.log("Error parsing JSON response:", error);
                                    }
                                },
                                error: function() {
                                    console.log("Error while fetching notes");
                                }
                            });
                        }
                    }

                    // Ambil catatan pertama kali saat halaman dimuat
                    function firstUpdates() {
                        var id_dg_client_project = '<?php echo $id_dg_client_project; ?>';

                        $.ajax({
                            url: 'view/ajax/get_note_project.php',
                            type: 'GET',
                            data: { id_dg_client_project: id_dg_client_project },
                            success: function(response) {
                                try {
                                    var jsonResponse = JSON.parse(response);
                                    var latestNotes = decodeURIComponent(jsonResponse.notes_project);
                                    if (latestNotes !== 'null') {
                                        $('#summernote').summernote('code', latestNotes);
                                    }
                                } catch (error) {
                                    console.log("Error parsing JSON response:", error);
                                }
                            },
                            error: function() {
                                console.log("Error while fetching notes");
                            }
                        });
                    }

                    firstUpdates();
                    setInterval(checkForUpdates, 30000);
                });




            
            
        </script>

</body>

</html>