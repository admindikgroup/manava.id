<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

if(isset($_GET['id'])){
    $id_dg_client_project = $_GET['id'];
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
    $is_finish = 0;

    // Jika tidak ada, lakukan insert
    if ($row['count'] == 0) {

        $stmt1 = $db2->prepare("INSERT INTO dg_client_project_status (id_dg_client_project, nama_status, warna_status, 
        urutan_status, is_finish, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssssss", $id_dg_client_project, $nama_status, $warna_status, $urutan_status, $is_finish, $tanggal_now, $id_user);
        
        
        $result_cek_status = mysqli_query($db2,"SELECT * from `dg_client_project_status` where
        deleted_by is null and id_dg_client_project_jenis = $id_dg_client_project_jenis");

        while($d_cek_status = mysqli_fetch_array($result_cek_status)){
            // Variabel input
            $nama_status = $d_cek_status['nama_status']; // Nama status
            $warna_status = $d_cek_status['warna_status']; // Warna status
            $urutan_status = $d_cek_status['urutan_status']; // Urutan status
            $is_finish = $d_cek_status['is_finish']; // Finish status


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
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

    <!-- fullCalendar -->
    <link rel="stylesheet" href="plugins/fullcalendar/main.css">

    <!-- Prism.js CSS -->
    <link rel="stylesheet" href="plugins/prism/prism.css">


    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <style>

        pre[class*="language-"] {
            background: #1e1e1e !important;
            color: #ffffff !important;
            border-radius: 8px;
            padding: 16px;
            font-size: 14px;
            overflow-x: auto;
        }

        .ratio-box {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .ratio-1-1 {
            padding-top: 100%; /* 1:1 */
        }
        .ratio-4-5 {
            padding-top: 125%; /* 4:5 */
        }
        .ratio-16-9 {
            padding-top: 56.25%; /* 16:9 */
        }



        .ratio-box img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: 0.3s ease;
        }

        .tooltip-overlay img{
            position: relative;
            width: 50px;
            height: 50px;
            transition: 0.3s ease;
            object-fit: cover;
        }

        .tooltip-overlay {
            position: absolute;
            top: 0;
            left: 0;
            max-height: 100%;
            background: rgba(0, 0, 0, 0.88);
            color: white;
            padding: 60px 50px;
            font-size: 15px;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: 0.2s ease;
            pointer-events: none;
            overflow-y: auto;
            overscroll-behavior: contain; /* mencegah scroll keluar */
            scrollbar-width: thin; /* Firefox */
            pointer-events: auto;
        }

        .tooltip-overlay::-webkit-scrollbar {
            width: 6px;
        }
        .tooltip-overlay::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 4px;
        }

        .ratio-box:hover .tooltip-overlay {
            opacity: 1;
        }

        .gallery-hover-box {
            position: relative;
        }

        .gallery-hover-box:hover .zip-download-btn {
            display: block !important;
        }

        .download-btn {
            display: none;
        }

        .gallery-hover-box:hover .download-btn {
            display: block;
        }




        .fc-daygrid-block-event .fc-event-time, .fc-daygrid-block-event .fc-event-title{
            padding : 10px !important;
            overflow: auto;
        }
        
        @media (min-width: 1025px) {
            .dataTables_length{
                margin-top: -40px;
            }
            
        }
        @media (max-width: 768px) {
            #downloadAll, #toggleSortOrder {
                width: 100%;
                margin-top: 0.5rem;
            }
        }



        #taskCalendar {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }


        
        tr.group,
        tr.group:hover {
            background-color: rgba(0, 0, 0, 0.1) !important;
        }
        
        :root.dark tr.group,
        :root.dark tr.group:hover {
            background-color: rgba(0, 0, 0, 0.75) !important;
        }

        .copy-btn {
            margin-left: auto;
        }
        .code-block-wrapper {
            border: 1px solid #333;
            border-radius: 6px;
            overflow: hidden;
            margin: 1em 0;
            background: #1e1e1e;
            display: flex;
            flex-direction: column;
        }

        .code-block-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 12px;
            background: #2d2d2d;
            font-family: monospace;
            font-size: 0.85em;
            color: #d4d4d4;
            border-bottom: 1px solid #444;
        }


        .copy-btn {
            background: none;
            color: #ccc;
            border: none;
            font-size: 0.8em;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
        }

        .copy-btn:hover {
            color: white;
        }

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
            max-width: 75%; /* Batas panjang maksimal */
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
            user-select: none; /* Mencegah teks terseleksi */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        .card-task:hover {
            cursor: pointer; /* Mengubah kursor menjadi tangan */
            background-color: rgb(255, 255, 227); /* Memberikan efek mengkilat/putih */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan efek bayangan */
        }

        .card-task.sortable-selected {
            cursor: pointer; /* Mengubah kursor menjadi tangan */
            background-color: rgb(255, 255, 200); /* Memberikan efek mengkilat/putih */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Menambahkan efek bayangan */
        }

        .selection-area {
            position: absolute;
            background: rgba(100, 100, 255, 0.2); /* Warna transparan biru */
            border: 1px dashed blue; /* Garis putus-putus */
            z-index: 1000;
            display: none; /* Awalnya tidak terlihat */
        }


        .status-head{
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            user-select: none; /* Mencegah teks terseleksi */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
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
        .modal-backdrop {
            display: none;
        }

        .loading-overlay {
            position: fixed;
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

        .loading-overlay .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        .loading-overlay-abs {
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

        .loading-overlay-abs .spinner {
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
        .fullscreen {
            width: 100vw !important;
            height: 100vh !important;
            max-width: none !important;
            margin: 0;
        }

        .addTaskModal{
            right: 0 !important;
            left: auto !important;
            width: 50% !important;
        }
        .modal-open{
            overflow: auto !important;
        }

        .sticky-header{
            position: sticky;
            top: 50px;
            z-index: 123;
            background: #F4F6F9;
        }
        #teamSpaceTaskTable tbody tr:hover {
            background-color: rgb(240, 240, 195);
            cursor: pointer;
        }
        .fc-daygrid-event-harness{
            cursor: pointer;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <!-- Modal Add Task -->
    <div id="addTaskModal" class="addTaskModal modal right fade" tabindex="-1" role="dialog">
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
                            <!-- Tombol Fullscreen -->
                            <button type="button" id="fullscreenToggle" class="btn btn-light mr-2">
                                <i class="fas fa-expand"></i>
                            </button>
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
                                    <select class="form-control select2-with-actions" id="id_status" name="id_status" required>
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
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-info btn-sm" id="tidyUp" title="Tidy Up with AI">
                                            Tidy Up with AI ✨
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" id="undoTidyUp" title="Undo" disabled>
                                            <i class="fas fa-undo"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" id="redoTidyUp" title="Redo" disabled>
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>


                                <br>
                           
                                <div class="form-group float-right  mt-5">
                                    <!-- <button type="button" class="btn btn-info btn-sm" id="saveAsTamplate" title="Save">
                                        <i class="fas fa-file-download"></i> Save as Tamplate
                                    </button> -->
                                    <button type="button" class="btn btn-danger btn-sm" id="deleteTaskButton" title="Delete Task">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <div class="row" style="margin: 95px 0px;">
                                    <div class="col-12">
                                        <hr>
                                    </div>
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
                            <label for="editStatusName">Nama status</label>
                            <input type="text" id="editStatusName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatusColor">Warna status</label>
                            <input type="color" id="editStatusColor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatusOrder">Urutan status</label>
                            <input type="number" id="editStatusOrder" name="editStatusOrder" class="form-control" placeholder="Enter order number" required>
                        </div>
                        <div class="form-group">
                            <label for="editHasDeadline">Apakah status ini ada deadline?</label>
                            <select id="editHasDeadline" name="editHasDeadline" class="form-control">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editIsFinish">Apakah ini adalah status selesai / terakhir?</label>
                            <select id="editIsFinish" name="editIsFinish" class="form-control">
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

     <!-- /.modal -->
     <div class="modal fade" id="modal-edit-sprint">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-sprint">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">
                            <label for="sprintName" class="col-sm-4 col-form-label">Sprint Name</label>
                        <div class="col-sm-8" style="padding-bottom: 10px;">
                            <input type="text" class="form-control" id="sprintName" name="sprintName"
                            placeholder="Ketikan nama sprint" value="" required>
                        </div>
                        

                        <input type="hidden" name="id_dg_client_project_sprint" id="id_dg_client_project_sprint" value="">


                        <div class="col-12" style="margin-top: 10px;">
                            <button style="width:95%;" onclick="addSprintToProject()" class="btn btn-info" title="Save Edited sprint"><i class="fas fa-save"></i> Save</button>
                            <button onclick="clearSprintToProject()" class="btn btn-warning" title="Clear Edited sprint"><i class="fas fa-sync-alt"></i></button>
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
     <div class="modal fade" id="modal-edit-sprint">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-sprint">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">
                            <label for="sprintName" class="col-sm-4 col-form-label">Sprint Name</label>
                        <div class="col-sm-8" style="padding-bottom: 10px;">
                            <input type="text" class="form-control" id="sprintName" name="sprintName"
                            placeholder="Ketikan nama sprint" value="" required>
                        </div>
                        

                        <input type="hidden" name="id_dg_client_project_sprint" id="id_dg_client_project_sprint" value="">


                        <div class="col-12" style="margin-top: 10px;">
                            <button style="width:95%;" onclick="addSprintToProject()" class="btn btn-info" title="Save Edited sprint"><i class="fas fa-save"></i> Save</button>
                            <button onclick="clearSprintToProject()" class="btn btn-warning" title="Clear Edited sprint"><i class="fas fa-sync-alt"></i></button>
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
    <div class="modal fade" id="modal-edit-type">
        <div class="modal-dialog modal-dialog-centered" style="min-width: 1000px !important;">
                <div class="modal-content">

                    <div class="modal-content-table-type">

                    </div>
                
                    <div class="modal-footer" style="display: block !important;">

                        <div class="form-group row" style="padding: 20px;">

                            <label for="typeName" class="col-sm-12 col-form-label">Nama Type</label>
                            <div class="col-sm-12" style="padding-bottom: 10px;">
                                <input type="text" class="form-control" id="typeName" name="typeName"
                                placeholder="Ketikan nama type" value="" required>
                            </div>
                        
                            <label for="detail_project_tamplate_type" class="col-sm-12 col-form-label">Project Tamplate</label>
                            <div class="col-sm-12">
                                <textarea id="detail_project_tamplate_type" name="detail_project_tamplate_type"></textarea>
                            </div>

                            <input type="hidden" name="id_dg_client_project_type" id="id_dg_client_project_type" value="">
                            <input type="hidden" name="type_id_dg_client_project_jenis" id="type_id_dg_client_project_jenis" value="">

                            <div class="col-12">
                                <button style="width:95%;" onclick="addTypeToProject()" class="btn btn-info" title="Save Edited type"><i class="fas fa-save"></i> Save</button>
                                <button onclick="clearTypeToProject()" class="btn btn-warning" title="Clear Edited Status"><i class="fas fa-sync-alt"></i></button>
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
                    <input type="hidden" name="type_id_dg_client_project_jenis_del" id="type_id_dg_client_project_jenis_del" value="">

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

    <div class="modal fade" id="modal-cancel-sprint">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Sprint ini ?<br>
                        Sprint Name &nbsp; : <b id="sprint_name"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_client_project_sprint" id="id_dg_client_project_sprint" value="">
                    <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteSprintToProject()"  class="btn btn-danger">Yes</button>
                    </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.modal -->
    <div class="modal fade" id="modal-cancel-type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus type ini ?<br>
                        Nama type &nbsp; : <b id="type_name_del"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="del_id_dg_client_project_type" id="del_id_dg_client_project_type" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button onclick="deleteTypeToProject()"  class="btn btn-danger">Yes</button>
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
                            <div class="card-header sticky-header" onclick="toggleCard(this)">
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
                            </div>
                        </div>
                    </section>

                    <section class="content-header">
                        <div class="card-body" style="padding: 0px 20px;">
                            <div class="row">
                                <div class="col-4 select2-purple" style="font-size: 15px;">
                                    <p style="margin: 0px;"><b>Sprint: </b></p>
                                    <select data-placeholder="Filter a Sprint" style="font-size: 12px; width: 100%;" multiple="multiple" 
                                        class="select2" name="filter_sprint[]" id="filter_sprint" required>
                                    </select>
                                </div>
                                <div class="col-4 select2-blue" style="font-size: 15px;">
                                    <p style="margin: 0px;"><b>Status: </b></p>
                                    <select data-placeholder="Filter a Status" style="font-size: 12px; width: 100%;" multiple="multiple" 
                                        class="select2" name="filter_status[]" id="filter_status" required>   
                                    </select>
                                </div>    
                            </div>
                        </div>
                    </section>
                    
                    <section class="content">
                        <div class="card" style="background: transparent; padding: 20px; box-shadow: none;">

                            <div class="card-header p-0 border-bottom-0" style="overflow: hidden;">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="board-view-tab" 
                                    data-toggle="pill" href="#board-view" role="tab" 
                                    aria-controls="board-view" aria-selected="true">Board View</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table-view-tab" 
                                    data-toggle="pill" href="#table-view" role="tab" 
                                    aria-controls="table-view" aria-selected="false">Table View</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="calendar-view-tab" 
                                    data-toggle="pill" href="#calendar-view" role="tab" 
                                    aria-controls="calendar-view" aria-selected="false">Calendar View</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="gallery-view-tab" 
                                    data-toggle="pill" href="#gallery-view" role="tab" 
                                    aria-controls="gallery-view" aria-selected="false">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dashboard-view-tab" 
                                    data-toggle="pill" href="#dashboard-view" role="tab" 
                                    aria-controls="dashboard-view" aria-selected="false">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="setting-view-tab" 
                                    data-toggle="pill" href="#setting-view" role="tab" 
                                    aria-controls="setting-view" aria-selected="false">Settings</a>
                                </li>
                                </ul>
                            </div>

                            <div class="card-body" style="overflow-x: auto;">
                                <div class="tab-content" id="custom-tabs-four-tabContent">

                                    <div class="tab-pane fade show active" id="board-view" role="tabpanel" aria-labelledby="board-view-tab">
                                        <div id="workspace-overlay" class="loading-overlay" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                        <div class="selection-area"></div>
                                        <div id="kanban-board" class="container-fluid h-100"> </div>
                                    </div>

                                    <div class="tab-pane fade" id="table-view" role="tabpanel" aria-labelledby="table-view-tab">



                                        <div class="row justify-content-end">
                                            <div class="mb-2 col-lg-3 select2-red">
                                                <select data-placeholder="Select Group By"
                                                    style="font-size: 12px; width: 100%; float: right;" class="select2"
                                                    name="select_group_table" id="select_group_table">
                                                    <option value="">Select Group By</option>
                                                    <option value="1">User</option>
                                                    <option value="2">Status</option>
                                                    <option value="3">Sprint</option>
                                                    <option value="4">Type</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        
                                        <table id="teamSpaceTaskTable" class="table table-bordered table-striped"
                                            style="width: 100%; font-size: 15px;">
                                            <thead>
                                                <tr>
                                                    <th style="display:none;"></th> 
                                                    <th class="minWidth250" style="width: 15%;">Deadline</th>
                                                    <th class="minWidth250" style="width: 15%;">Task Name</th>
                                                    <th class="minWidth150" style="width: 10%;">Sprint</th>
                                                    <th class="minWidth150" style="width: 10%;">Type</th>
                                                    <th class="minWidth150" style="width: 10%;">Status</th>
                                                    <th class="minWidth350" style="width: 25%;">Assign</th>
                                                    <th class="minWidth150" style="width: 10%;">Priority</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>

                                    <div class="tab-pane fade" id="calendar-view" role="tabpanel" aria-labelledby="calendar-view-tab">
                                        <div id="calendarLoadingOverlay" class="loading-overlay-abs" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>

                                        <div id="taskCalendar" style="width: 100%; min-height: 600px;"></div>

                                    
                                    </div>

                                    <div class="tab-pane fade" id="gallery-view" role="tabpanel" aria-labelledby="gallery-view-tab">

                                        <div id="galleryLoadingOverlay" class="loading-overlay-abs" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                        
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-lg-8 col-md-12">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <!-- Ratio Selector -->
                                                    <div class="flex-fill" style="min-width: 120px;">
                                                        <label for="ratioSelector" class="form-label mb-1">View Ratio</label>
                                                        <select id="ratioSelector" class="form-control">
                                                            <option value="1:1">Ratio 1:1</option>
                                                            <option value="4:5" selected>Ratio 4:5</option>
                                                            <option value="16:9">Ratio 16:9</option>
                                                        </select>
                                                    </div>

                                                    <!-- Sort By Selector -->
                                                    <div class="flex-fill" style="min-width: 180px;">
                                                        <label for="sortGalleryBy" class="form-label mb-1">Sort By</label>
                                                        <select id="sortGalleryBy" class="form-control">
                                                            <option value="urutan_task">Default (Date Created)</option>
                                                            <option value="deadline">Deadline</option>
                                                            <option value="nama_task">Task Name (A-Z)</option>
                                                        </select>
                                                    </div>

                                                    <!-- Sort Order Button -->
                                                    <div>
                                                        <label class="form-label mb-1 d-block invisible">Sort</label>
                                                        <button id="toggleSortOrder" class="btn btn-outline-primary w-100">
                                                            <span id="sortOrderLabel">Ascending ↑</span>
                                                        </button>
                                                    </div>

                                                    <!-- Download All Button -->
                                                    <div>
                                                        <label class="form-label mb-1 d-block invisible">Download</label>
                                                        <button id="downloadAll" class="btn btn-outline-info w-100">
                                                            <i class="fas fa-download me-1"></i> Download All
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" id="galleryGrid"></div>


                                    </div>

                                    <div class="tab-pane fade" id="dashboard-view" role="tabpanel" aria-labelledby="dashboard-view-tab">
                                        Yes, its too. Comming Soon !
                                    </div>

                                    <div class="tab-pane fade" id="setting-view" role="tabpanel" aria-labelledby="setting-view-tab">
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
                                                                        class="btn btn-raised btn-success"><i class="fas fa-cog"></i>
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
                                        <div class="form-group row" style="margin-bottom: 20px;">
                                            <div class="col-6 col-md-6 col-sm-12" style="padding: 10px;">
                                                <div class="col-sm-12" style="text-align: left; padding-left: 10px;">
                                                    <h5><b>Sprint Task :</b></h5>
                                                </div>
                                                <div class="col-sm-12">
                                                    <table id="example2" class="table table-bordered table-striped" style="width: 100%; font-size: 12px; background-color: white;">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align: center; width: 10%;">No</th>
                                                            <th>    
                                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                                    <span>Nama Sprint</span>
                                                                    <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative; font-size: 12px;"
                                                                        data-toggle="modal" onclick="loadModalProjectSprint(<?php echo $id_dg_client_project; ?>, '<?php echo $nama_project; ?>', '<?php echo $id_client; ?>')"
                                                                        class="btn btn-raised btn-success"><i class="fas fa-cog"></i>
                                                                    </button>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="daftar-sprint">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6 col-sm-12" style="padding: 10px;">
                                                <div class="col-sm-12" style="text-align: left; padding-left: 10px;">
                                                    <h5><b>Type Task :</b></h5>
                                                </div>
                                                <div class="col-sm-12">
                                                    <table id="example2" class="table table-bordered table-striped" style="width: 100%; font-size: 12px; background-color: white;">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align: center; width: 10%;">No</th>
                                                            <th>    
                                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                                    <span>Nama Type</span>
                                                                    <button data-backdrop="static" data-keyboard="false" style="z-index: 99; position: relative; font-size: 12px;"
                                                                        data-toggle="modal" onclick="loadModalProjectType(<?php echo $id_dg_client_project; ?>, '<?php echo $nama_project; ?>', '<?php echo $id_client; ?>')"
                                                                        class="btn btn-raised btn-success"><i class="fas fa-cog"></i>
                                                                    </button>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="daftar-type">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <!-- /.card -->
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


        <!-- Filterizr-->
        <script src="plugins/filterizr/jquery.filterizr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

        <!-- Prism -->
        <script src="plugins/prism/prism.js"></script>
        <script src="plugins/marked/marked.min.js"></script>

        <!-- fullCalendar 2.2.5 -->
        <script src="plugins/moment/moment.min.js"></script>
        <script src="plugins/fullcalendar/main.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


  
        
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>

        

        <script src="plugins/selection/selection.min.js"></script>

        <!-- Page specific script -->
        <script>
      


      $(document).ready(function () {   
        
        


            $('#fullscreenToggle').on('click', function () {
                const modalDialog = $('#addTaskModal .modal-dialog');

                if (modalDialog.hasClass('fullscreen')) {
                    // Kembali ke ukuran awal
                    modalDialog.removeClass('fullscreen');
                    $('#fullscreenToggle i').removeClass('fa-compress').addClass('fa-expand');
                } else {
                    // Jadikan fullscreen
                    modalDialog.addClass('fullscreen');
                    $('#fullscreenToggle i').removeClass('fa-expand').addClass('fa-compress');
                }
            });







            let currentTaskId = null;



            
            $("#tidyUp").click(function () {
                let judul_task = $("#nama_task").val().trim();
                let tipe = $("#id_type option:selected").text().trim();
                let task_detail = $("#detail_project").val().trim();
                let notes_project = $("#summernote").summernote('code'); // Ambil isi dari Summernote

                var id_task = $('#id_task').val(); // Ganti 'your_hidden_input_id' dengan ID sebenarnya

                currentTaskId = id_task;

                console.log("currentTaskId", currentTaskId);
                
                

                if (!judul_task || !tipe || !task_detail) {
                    toastr.error("Pastikan semua field terisi sebelum menggunakan AI!");
                    return;
                }

                let finalPrompt = `Saya sedang membuat task detail, dengan rincian sebagai berikut ini:
                Nama Project: <?php echo $nama_project; ?>
                Detail Project: ${notes_project}
                Judul: ${judul_task}
                Tipe Task: ${tipe}
                Task Detail: ${task_detail}

                Input:
                Task Detail awalnya berformat HTML karena diambil dari summernote, kamu bersihkan dulu tag html nya sebelum memproses.
                Task detail adalah format isian yang diminta user untuk kamu lengkapi atau rapihkan.
                Kadang user akan mengetikan // pada taks detail untuk memberikan intruksi lanjutan.

                Role:
                Kamu adalah pemberi tugas ke user.
                Kamu perhatikan detail projectnya, lalu tentukan kamu ini diminta sebagai apa.
                Jika kamu adalah konten planner maka kamu bertanggung jawab memberikan keyword, konten, dan ide-ide yang relevan untuk membantu designer dalam membuat task detail.
                Dimana designer tersebut harus kamu dikte semua tulisan pada designnya agar menjadi bagus hasilnya, karena itu jangan memberikan pemisalan tapi kamu
                sendiri yang menentukan tulisan, judul, point-point dalam designya jangan memberikan dia yang berfikir tapi langsung semuanya dari kamu.
                Jika kamu adalah bisnis analyst yang bertugas untuk memberikan task detail yang lengkap dan siap pakai oleh developer.
                Dimana programer tersebut juga harus kamu dikte semua kebutuhannya jangan diberikan pilihan atau misalnya, tentukan semua kebutuhan developer oleh analisa kamu.
                Atau mungkin kamu menjadi role lain, analisa kembali role yang tepat untuk diri kamu dari detail yang kamu dapatkan.

                PERATURAN:
                Jangan memberikan misal, tapi langsung jawaban yang di kerjakan oleh user tanpa harus bertanya detail-detailnya.
                Jangan memberikan contoh, tapi langsung jawaban detail untuk dikerjakan.
                Jangan menyertakan penjelasan, template, atau instruksi tambahan.
                Jangan mengulang kembali struktur input saya.
                Jangan menanyakan kembali ke user.
                Langsung buat dan tampilkan isi task final, lengkap, dan siap dipakai.
                Semua bagian harus diasumsikan dan dilengkapi oleh kamu, seolah-olah kamu sudah tahu semua detailnya.

                Output:
                Tidak perlu dituliskan "task detail", langsung lengkapi dan jabarkan sesuai isi task details saja.
                Ikuti bahasa yang di pakai pada taks detail, tidak selalu bahasa indonesia.
                Hanya berupa isi Task Detail sesuai role kamu kepada user yang akan mengerjakan tugas.
                Kamu kadang bisa langsung menambahkan code atau table jika dibutuhkan untuk membantu user.
                Berikan keterangan dulu sebelum code / table di buat.
                Tidak perlu memberikan penjelasan tambahan tentang role kamu, cukup lakukan pengisian dan perapihan task detail.
                
                IMG :
                Jika ada permintaan gambar / video maka gunakan format ini untuk semua gambar / video nya ![MEDIA][promt dalam bahasa inggris]. Jika tidak, tidak perlu dibuat.
                Sisipkan spasi / enter setelah dan sebelum ![MEDIA][prompt].
                Contoh: <spasi> ![MEDIA][a cat with a hat] <spasi>.
                Jumlahnya gambar / video sesuai yang diminta, jika diminta 1 buatkan 1. Jika tidak ada jumlahnya kamu atur sendiri jumlahnya gambar / videonya.
                Tapi untuk video usahakan 1 saja, karena cukup berat.
                Jangan lupa memberikan penjelasan tambahan tentang gambar tersebut.
                Berikan jawaban menggunakan bahasa yang kamu cek dari permintaan atau percakapan user terakhir.
                Jika sudah ada tag img di dalam task detail jangan di hilangkan, pakai lagi tag img tersebut sampai ke src nya jangan kamu ganti image nya.
                Jika sudah ada tag img, jangan menggantinya dengan ![MEDIA][prompt] tapi tetap pakai tag image tersebut copy paste saja.`;


                // Tampilkan loader atau indikator pemrosesan
                $("#tidyUp").prop("disabled", true).text("Processing...");
                $('#addTaskModal .loading-overlay').show();

                // Kirim permintaan ke chat_api.php
                $.ajax({
                    url: "view/ajax/chat_api.php",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ 
                        prompt: finalPrompt,
                        kanban: 1
                    }),

                    success: function (response) {
                        console.log("finalPrompt:", finalPrompt); // Debugging
                        try {
                            if (typeof response === "string") {
                                response = JSON.parse(response); // Pastikan response diubah menjadi objek jika masih string
                            }

                            console.log("AI Response RAW:", response); // Debugging

                            let aiResponse = response && response.response ? response.response : "";

                           // Decode HTML entities (seperti &lt; menjadi <)
                           function decodeHtml(html) {
                                        const txt = document.createElement("textarea");
                                        txt.innerHTML = html;
                                        return txt.value;
                                    }

                                    aiResponse = decodeHtml(aiResponse);

                                    function normalizeMarkdownTables(text) {
                                        const lines = text.split("\n");
                                        let inTable = false;
                                        const normalizedLines = [];

                                        for (let i = 0; i < lines.length; i++) {
                                            let line = lines[i].trim();

                                            // Cek apakah ini baris tabel: memiliki beberapa `|`
                                            const isLikelyTableRow = (line.match(/\|/g) || []).length >= 2;

                                            // Mulai tabel jika baris punya banyak "|"
                                            if (isLikelyTableRow) {
                                                inTable = true;

                                                // Pastikan ada | di awal dan akhir
                                                if (!line.startsWith("|")) line = "| " + line;
                                                if (!line.endsWith("|")) line = line + " |";

                                                normalizedLines.push(line);
                                            } else {
                                                inTable = false;
                                                normalizedLines.push(line); // baris normal (subheading atau teks biasa)
                                            }
                                        }

                                        return normalizedLines.join("\n");
                                    }


                                    const containsMarkdownTable = /\|(.+?)\|/g.test(aiResponse) && !/<table[\s\S]*?>[\s\S]*?<\/table>/gi.test(aiResponse);

                                    if (containsMarkdownTable) {
                                        aiResponse = normalizeMarkdownTables(aiResponse);
                                    }


                                    //console.log("🔍 Normalized Markdown:\n", aiResponse);


                                    // Ganti **bold** dengan <strong>
                                    aiResponse = aiResponse.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                                    
                                    // Jika jawaban kosong, tampilkan error
                                    if (!aiResponse.trim()) {
                                        aiResponse = "<p>AI tidak memberikan jawaban yang valid.</p>";
                                        $(".detail_project").summernote("code", aiResponse);
                                        return;
                                    }



                                        //console.log("AI Formated:", aiResponse); // Debugging                

                                        aiResponse = aiResponse.replace(
  /((?:\|.+?\|\s*\n)+)/g,
                                            function (tableBlock) {
                                                const lines = tableBlock.trim().split("\n").map(l => l.trim()).filter(Boolean);
                                                if (lines.length < 2) return tableBlock;

                                                const headers = lines[0].split("|").slice(1, -1).map(cell => cell.trim());
                                                const headerCount = headers.length;
                                                const headerHTML = headers.map(cell => `<th>${cell}</th>`).join("");

                                                const bodyHTML = lines.slice(2).map(line => {
                                                const cells = line.split("|").slice(1, -1).map(c => c.trim());

                                                const isSubheading = cells.length < headerCount &&
                                                    (
                                                    cells.length === 1 ||
                                                    cells.filter(c => c !== "").length === 1 ||
                                                    cells.every(c => /^(\d+(\.\d+)?|[A-Z\s]+)$/.test(c))
                                                    );

                                                if (isSubheading) {
                                                    const subText = cells.join(" ").replace(/\*\*/g, "").trim();
                                                    return `<tr><td colspan="${headerCount}"><strong>${subText}</strong></td></tr>`;
                                                }

                                                const rowHTML = headers.map((_, i) => {
                                                    let cell = (cells[i] !== undefined) ? cells[i].trim() : "";

                                                    if (/\*\*/.test(cell)) {
                                                    cell = `<strong>${cell.replace(/\*\*/g, "")}</strong>`;
                                                    }

                                                    return `<td>${cell}</td>`;
                                                }).join("");

                                                return `<tr>${rowHTML}</tr>`;
                                                }).join("");

                                                return `
                                                <div style="overflow-x:auto;">
                                                    <table class="table table-bordered table-striped dataTable no-footer" style="width: 100%; min-width: max-content;">
                                                    <thead><tr>${headerHTML}</tr></thead>
                                                    <tbody>${bodyHTML}</tbody>
                                                    </table>
                                                </div>
                                                `.trim();
                                            }
                                        );


                                        // 🔐 Deteksi dan bungkus blok kode dari AI, baik ```html atau ``` saja
                                        aiResponse = aiResponse.replace(/```(?:([a-zA-Z]+))?\s*([\s\S]*?)\s*```/gi, function (_, lang, codeBlock) {
                                            let language = (lang && lang.trim()) ? lang.toLowerCase() : "markup"; // default ke markup (HTML)
                                            let displayLang = (lang && lang.trim())
                                                ? lang.charAt(0).toUpperCase() + lang.slice(1)
                                                : "Code";

                                            // Encode agar aman untuk ditampilkan
                                            let cleanedCode = codeBlock
                                                .replace(/&/g, "&amp;")
                                                .replace(/</g, "&lt;")
                                                .replace(/>/g, "&gt;");

                                            return `
                                                <div class="code-block-wrapper">
                                                    <div class="code-block-header">
                                                        <div class="code-lang">${displayLang}</div>
                                                        <button class="copy-btn" onclick="copyCode(this)"><i class="fas fa-copy"></i> Copy</button>
                                                    </div>
                                                    <pre class="ai-code-block language-${language}"><code class="language-${language}">${cleanedCode}</code></pre>
                                                </div>
                                            `.trim();
                                        });

                                        let htmlBlocks = [];
                                            aiResponse = aiResponse.replace(/<([a-z][\s\S]*?)<\/\1>/gi, function(match) {
                                                htmlBlocks.push(match);
                                                return `__HTML_BLOCK_${htmlBlocks.length - 1}__`;
                                            });


                                        aiResponse = aiResponse
                                                .replace(/```html\s*<br\s*\/?>/gi, "")       // Hapus ```html<br />
                                                .replace(/<br\s*\/?>\s*```/gi, "")           // Hapus <br>```
                                                .replace(/\s*<br\s*\/?>\s*/gi, "\n")         // Semua <br> jadi \n
                                                .replace(/\n{3,}/g, "\n\n")                  // Maksimal 2 newline
                                                .replace(/(<strong>\n)/g, "<strong>")        // Bersihin newline setelah <strong>
                                                .replace(/(\n<\/strong>)/g, "</strong>")     // Bersihin newline sebelum </strong>
                                                .replace(/(\* )\n/g, "$1")                   // Hapus newline setelah bullet
                                                .replace(/>\s*\n\s*</g, "><")                // ❗❗ Hapus newline antar tag HTML (opsional)
                                                .trim();



                                        aiResponse = aiResponse.replace(/`<\s*\/?\s*([^>]+?)\s*>`/g, (_, tagContent) => {
                                            return tagContent.trim();
                                        });


                                        // Ganti image markdown ![alt](link) jadi <img ...>
                                        // aiResponse = aiResponse.replace(/!\[(.*?)\]\((https?:\/\/[^\s]+)\)/g, function (match, alt, url) {
                                        //     return `<br><img src="${url}" alt="${alt}" style="width: 50%;"  />`;
                                        // });

                                        aiResponse = aiResponse.replace(/<img\s+[^>]*src="([^"]+)"[^>]*>/gi, function (match, src) {
                                            const loadingImage = "img/loading.gif";

                                            // Hapus atribut onload jika sudah ada
                                            match = match.replace(/\s*onload="[^"]*"/gi, '');

                                            // Ambil alt jika ada
                                            const altMatch = match.match(/alt="([^"]*)"/);
                                            const alt = altMatch ? altMatch[1] : '';
                                            const safeAlt = alt.replace(/"/g, '&quot;');

                                            const loadingImg = `<br><img src="${loadingImage}" alt="Loading..." style="width: 200px; opacity: 1; transition: opacity 0.5s ease;" />`;

                                            const mainImg = `<img src="${src}" alt="${safeAlt}" style="width: 50%; border-radius: 8px; opacity: 0; transition: opacity 0.5s ease;" onload="this.style.opacity='1'; if(this.previousElementSibling && this.previousElementSibling.tagName === 'IMG'){ this.previousElementSibling.style.opacity='0'; setTimeout(function() { this.previousElementSibling.remove(); }.bind(this), 500); }" /><br>`;

                                            return loadingImg + mainImg;
                                        });



                                        aiResponse = aiResponse.replace(/!\[(.*?)\]\((https?:\/\/[^\s]+)\)/g, function (match, alt, url) {
                                            const loadingImage = "img/loading.gif";
                                            const safeAlt = alt.replace(/"/g, '&quot;');

                                            return `<img src="${loadingImage}" alt="Loading..." style="width: 200px; opacity: 1; transition: opacity 0.5s ease;" /><img src="${url}" alt="${safeAlt}" style="width: 50%; border-radius: 8px; opacity: 0; transition: opacity 0.5s ease;" onload="this.style.opacity='1'; if(this.previousElementSibling && this.previousElementSibling.tagName === 'IMG') { this.previousElementSibling.style.opacity='0'; setTimeout(() => this.previousElementSibling.remove(), 500); }" />`;
                                        });





                                        

                                        // 🔧 Tambahkan class + style + wrap div untuk setiap <table>
                                        aiResponse = aiResponse.replace(/<table([\s\S]*?)<\/table>/gi, function(match) {
                                            let tableWithClassAndStyle = match.replace(
                                                /<table([^>]*)>/i,
                                                function(_, attrs) {
                                                    // Tambahkan atau gabungkan class
                                                    if (/class\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/class=["'](.*?)["']/, 'class="$1 table table-bordered table-striped dataTable no-footer"');
                                                    } else {
                                                        attrs += ' class="table table-bordered table-striped dataTable no-footer"';
                                                    }

                                                    // Tambahkan atau gabungkan style
                                                    if (/style\s*=/.test(attrs)) {
                                                        attrs = attrs.replace(/style=["'](.*?)["']/, function(_, styleVal) {
                                                            return `style="${styleVal}; width: 100%; min-width: max-content;"`;
                                                        });
                                                    } else {
                                                        attrs += ' style="width: 100%; min-width: max-content;"';
                                                    }

                                                    return `<table${attrs}>`;
                                                }
                                            );

                                            return `<div style="overflow-x:auto;">${tableWithClassAndStyle}</div>`;
                                        });
                                        
                         
                                        //console.log("AI Formatted Final:", aiResponse); // Debugging  

                                        let htmlOutput = marked.parse(aiResponse);
                                        


                                        console.log("currentTaskId 2 : ", currentTaskId);



                                        $(".detail_project").summernote("code", htmlOutput);
                                        $(".detail_project").next('.note-editor').find('.note-editable').css('min-height', '500px');

                                        
                                        
                                        Prism.highlightAll();

                                        toastr.success("Task detail telah dirapihkan oleh AI!");
                                        saveTaskData("Ai tidy up");

                                        //console.log("AI response Akhir:", aiResponse);
                                    } catch (e) {
                                        toastr.error("Invalid JSON response dari AI.");
                                        console.error("Parsing error:", e, response);
                                    }
                                },


                                error: function (xhr, status, error) {
                                    toastr.error("Terjadi kesalahan saat meminta AI: " + error);
                                },
                                complete: function () {
                                    $("#tidyUp").prop("disabled", false).text("Tidy Up with AI ✨");
                                    $('#addTaskModal .loading-overlay').hide();
                                }
                            });
                        });
                    });
                    


                    // Simpan daftar pesan sukses yang sedang aktif
                    var activeSuccessToasts = new Set();
                    var toastTimeouts = new Map();

                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 5000,
                        extendedTimeOut: 2000,
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut',
                        onHidden: function () {
                            activeSuccessToasts.delete(this.innerText);
                            clearTimeout(toastTimeouts.get(this.innerText)); // Hapus timeout saat toast disembunyikan
                            toastTimeouts.delete(this.innerText);
                        }
                    };

                    // Fungsi untuk menampilkan toastr sukses dengan anti-duplikasi
                    function showSuccessToast(message) {
                        if (!activeSuccessToasts.has(message)) {
                            activeSuccessToasts.add(message);
                            toastr.success(message);

                            // Hapus dari daftar setelah waktu tertentu jika tidak di-hover
                            setTimeout(() => {
                                activeSuccessToasts.delete(message);
                            }, 5000);
                        }
                    }


                    var isNoteModalOpen = false; // Variabel untuk menandai apakah Summernote modal terbuka

                    // Ketika modal Summernote muncul, tandai sebagai terbuka
                    $(document).on('shown.bs.modal', '.note-modal', function () {
                        isNoteModalOpen = true;
                        //console.log('Summernote modal opened');
                    });

                    // Ketika modal Summernote ditutup, tandai sebagai tertutup
                    $(document).on('hidden.bs.modal', '.note-modal', function () {
                        isNoteModalOpen = false;
                        //console.log('Summernote modal closed');
                    });


                    let isMouseDownInsideModal = false;

                    $(document).on('mousedown', function (event) {
                        var modal = $('#addTaskModal .modal-content');
                        var editTaskButton = $('.btn-tool[title="Edit Task"]');
                        var galleryGrid = $('.carousel-inner');
                        var taskRow = $('#teamSpaceTaskTable tbody tr');
                        var imagePopup = $('.modal');
                        var calendarEvent = $(event.target).closest('.fc-event'); // tambahkan pengecekan event calendar

                        if (
                            modal.is(event.target) || modal.has(event.target).length > 0 ||
                            editTaskButton.is(event.target) || editTaskButton.has(event.target).length > 0 ||
                            galleryGrid.is(event.target) || galleryGrid.has(event.target).length > 0 ||
                            taskRow.is(event.target) || taskRow.has(event.target).length > 0 ||
                            imagePopup.is(event.target) || imagePopup.has(event.target).length > 0 ||
                            calendarEvent.length > 0
                        ) {
                            isMouseDownInsideModal = true;
                        } else {
                            isMouseDownInsideModal = false;
                        }
                    });

                    $(document).on('mouseup', function (event) {
                        var modal = $('#addTaskModal .modal-content');
                        var editTaskButton = $('.btn-tool[title="Edit Task"]');
                        var galleryGrid = $('.carousel-inner');
                        var taskRow = $('#teamSpaceTaskTable tbody tr');
                        var imagePopup = $('.modal');
                        var calendarEvent = $(event.target).closest('.fc-event'); // tambahkan pengecekan event calendar

                        if (
                            !modal.is(event.target) && modal.has(event.target).length === 0 &&
                            !editTaskButton.is(event.target) && editTaskButton.has(event.target).length === 0 &&
                            !galleryGrid.is(event.target) && galleryGrid.has(event.target).length === 0 &&
                            !taskRow.is(event.target) && taskRow.has(event.target).length === 0 &&
                            !imagePopup.is(event.target) && imagePopup.has(event.target).length === 0 &&
                            calendarEvent.length === 0 &&
                            !isMouseDownInsideModal
                        ) {
                            hiddenModal();
                        }
                    });








        
        // Saat membuka modal
        function get_statuses_with_deadline() {
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
                                            style="width: 100%;"
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


                                // Mencegah modal tertutup saat menghapus item di Select2
                                $(document).on('click', '.select2-selection__choice__remove', function(event) {
                                    event.stopPropagation(); // Mencegah event bubbling ke modal
                                });
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Failed to fetch statuses with deadlines and users:', error);
                }
            });
        };



    //LINK TO PROJECT

        function clearLinkToProject() {
            //Kosongkan nilai input
            $('#linkName').val('');
            $('#linkProject').val('');
            $('#id_dg_client_project_link').val('');
        }

        function clearSprintToProject() {
            //Kosongkan nilai input
            $('#sprintName').val('');
            $('#sprintProject').val('');
            $('#id_dg_client_project_sprint').val('');
        }

        function clearTypeToProject() {
            // Kosongkan nilai input
            $('#typeName').val('');
            $('#detail_project_tamplate_type').summernote('code', '');
            $('#id_dg_client_project_type').val('');
        }

        function editLinkToProject(id, nama_link, link_project) {
            // Set value pada input Nama Status
            document.getElementById('linkName').value = nama_link;
            document.getElementById('linkProject').value = link_project;
                

            // Set value pada hidden input ID
            document.getElementById('id_dg_client_project_link').value = id;

            // Tambahkan log untuk memastikan data sudah di-set
            //console.log("Edit Link to Project:", {
            //    id: id,
            //     nama_link: nama_link,
            //     link_project: link_project
            // });
        }

        
        function editSprintToProject(id, nama_sprint) {
            // Set value pada input Nama Status
            document.getElementById('sprintName').value = nama_sprint;
                

            // Set value pada hidden input ID
            document.getElementById('id_dg_client_project_sprint').value = id;

            // Tambahkan log untuk memastikan data sudah di-set
            //console.log("Edit Sprint to Project:", {
            //    id: id,
            //     nama_sprint: nama_sprint
            // });
        }

        function editTypeToProject(id, nama_type, detail_project_tamplate) {
            // Set value pada input Nama Status
            document.getElementById('typeName').value = nama_type;

            var notes_project = decodeURIComponent(detail_project_tamplate);
            
            // Set value pada input Background Color
            $('#detail_project_tamplate_type').summernote('code', notes_project);

            // Set value pada hidden input ID
            document.getElementById('id_dg_client_project_type').value = id;

            // Tambahkan log untuk memastikan data sudah di-set
            //console.log("Edit Status to Project:", {
            //     id: id,
            //     nama_type: nama_type
            // });
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
                        loadEverything();
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

        function deleteSprintToProject() {
            // Ambil nilai dari input text dengan id "SprintProject" dan "SprintName"
            var id_user = $('#id_user').val();
            var id_dg_client_project_sprint = $('#id_dg_client_project_sprint').val();
            var id_dg_client_project_to_sprint = $('#id_dg_client_project_to_sprint').val();
            var id_client = $('#id_client').val();
            var nama_project_sprint = $('#nama_project_sprint').val();

            // Kirim data form ke server menggunakan AJAX
            $.ajax({
                url: 'controller/conn_delete_client_project_sprint.php',
                type: 'POST',
                data: {
                    id_user: id_user,
                    id_dg_client_project_sprint: id_dg_client_project_sprint,
                    id_client: id_client
                },
                    dataType: 'html',
                    success: function(response) {
                        loadModalProjectSprint(id_dg_client_project_to_sprint, nama_project_sprint);
                        loadProjectSprint();
                        loadEverything();
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (response == 'Berhasil') {
                            toastr.warning('Data berhasil terhapus !');
                        } else {
                            toastr.error('Data gagal disimpan !<br>'+response);
                        }
                            $('#modal-cancel-sprint').modal('hide');

                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan saat mengirim permintaan AJAX
                    console.error('Error:', error);
                }
            });
        }

        function deleteTypeToProject() {
                // Ambil nilai dari input text dengan id "backgroundColor" dan "statusName"
                var id_user = <?php echo $id_user; ?>;
                var del_id_dg_client_project_type = $('#del_id_dg_client_project_type').val();
                var type_id_dg_client_project_jenis_del = $('#type_id_dg_client_project_jenis_del').val();
                var nama_project_type = $('#nama_project_type').val();
                var id_client = $('#id_client').val();

                // Kirim data form ke server menggunakan AJAX
                $.ajax({
                    url: 'controller/conn_delete_client_project_type.php',
                    type: 'POST',
                    data: {
                        id_user: id_user,
                        del_id_dg_client_project_type: del_id_dg_client_project_type
                    },
                    dataType: 'html',
                    success: function(response) {
                        loadModalProjectType(type_id_dg_client_project_jenis_del, nama_project_type, id_client);
                        loadProjectType();
                        loadEverything();
                        
                        // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                        if (response == 'Berhasil') {
                                toastr.success('Data berhasil terhapus !');
                                $('#id_dg_client_project_type').val('');
                        } else {
                                toastr.error('Data gagal disimpan !<br>'+response);
                        }
                                $('#modal-cancel-type').modal('hide');

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
                    loadEverything();
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

        function addSprintToProject() {
            // Ambil nilai dari input text dengan "sprintName"
            var sprintName = $('#sprintName').val();
            var id_dg_client_project_to_sprint = $('#id_dg_client_project_to_sprint').val();
            var id_client = $('#id_client').val();
            var id_dg_client_project_sprint = $('#id_dg_client_project_sprint').val();
            var nama_project_sprint = $('#nama_project_sprint').val();


            // Kirim data form ke server menggunakan AJAX
            $.ajax({
                url: 'controller/conn_add_client_project_sprint.php',
                type: 'POST',
                data: {
                    sprintName: sprintName,
                    id_dg_client_project_to_sprint: id_dg_client_project_to_sprint,
                    id_dg_client_project_sprint: id_dg_client_project_sprint,
                    id_client: id_client
                },
                dataType: 'html',
                success: function(response) {
                    loadModalProjectSprint(id_dg_client_project_to_sprint, nama_project_sprint);
                    loadProjectSprint();
                    loadEverything();
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (response == 'Berhasil') {
                        toastr.success('Data berhasil disimpan.');
                    } else {
                        toastr.error('Data gagal disimpan !<br>'+response);
                    }
                    // Kosongkan nilai input
                    clearSprintToProject();


                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan saat mengirim permintaan AJAX
                    console.error('Error:', error);
                }
            });
        }

        function addTypeToProject() {
            // Ambil nilai dari input text dengan "typeName"
            var typeName = $('#typeName').val();
            var id_dg_client_project_to_type = $('#id_dg_client_project_to_type').val();
            var id_user = <?php echo $id_user; ?>;
            var id_dg_client_project_type = $('#id_dg_client_project_type').val();
            var nama_project_type = $('#nama_project_type').val();
            var detail_project_tamplate = encodeURIComponent($('#detail_project_tamplate_type').val());


            // Kirim data form ke server menggunakan AJAX
            $.ajax({
                url: 'controller/conn_add_client_project_type_project.php',
                type: 'POST',
                data: {
                    typeName: typeName,
                    id_dg_client_project_to_type: id_dg_client_project_to_type,
                    id_dg_client_project_type: id_dg_client_project_type,
                    id_user: id_user,
                    detail_project_tamplate : detail_project_tamplate
                },
                dataType: 'html',
                success: function(response) {
                    loadModalProjectType(id_dg_client_project_to_type, nama_project_type);
                    loadProjectType();
                    loadEverything();
                    // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
                    if (response == 'Berhasil') {
                        toastr.success('Data berhasil disimpan.');
                    } else {
                        toastr.error('Data gagal disimpan !<br>'+response);
                    }
                    // Kosongkan nilai input
                    clearTypeToProject();


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
            var intervalIdLink = setInterval(refreshModalLink, 3000000);

            // Hentikan pembaruan saat modal disembunyikan
            $('#modal-edit-link').on('hidden.bs.modal', function () {
                clearInterval(intervalIdLink);
            });
        }

        function loadModalProjectSprint(id, nama_project, id_client) {
            // Tampilkan modal
            $('#modal-edit-sprint').modal({
                backdrop: 'static',
                keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
            });

            // Fungsi untuk memuat ulang data modal dari get_modal_project_sprint.php
            function refreshModalSprint() {
                // Kirim permintaan AJAX untuk mengambil data dari database
                $.ajax({
                url: 'controller/get_modal_project_sprint.php',
                type: 'GET',
                data: { id: id, nama_project: nama_project, id_client: id_client},
                success: function(response) {
                    //console.log(response);
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#modal-edit-sprint .modal-content-table-sprint').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
                });
            }

            // Panggil refreshModalLink pertama kali saat modal ditampilkan
            refreshModalSprint();

            // Panggil refreshModalLink setiap 30 detik setelah modal ditampilkan
            var intervalIdSprint = setInterval(refreshModalSprint, 3000000);

            $('#modal-edit-sprint').on('hidden.bs.modal', function () {
                clearInterval(intervalIdSprint);
            });
        }

        function loadModalProjectType(id, nama_project, id_client) {
            // Tampilkan modal
            $('#modal-edit-type').modal({
                backdrop: 'static',
                keyboard: false // Untuk mencegah modal ditutup dengan menekan tombol Escape
            });

            // Fungsi untuk memuat ulang data modal dari get_modal_project_type.php
            function refreshModalType() {
                // Kirim permintaan AJAX untuk mengambil data dari database
                $.ajax({
                url: 'controller/get_modal_project_type_project.php',
                type: 'GET',
                data: { id: id, nama_project: nama_project, id_client: id_client},
                success: function(response) {
                    //console.log(id, nama_project, id_client);
                    //console.log(response);
                    // Perbarui isi modal dengan data yang diambil dari database
                    $('#modal-edit-type .modal-content-table-type').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
                });
            }

            // Panggil refreshModalLink pertama kali saat modal ditampilkan
            refreshModalType();

            // Panggil refreshModalLink setiap 30 detik setelah modal ditampilkan
            var intervalIdType = setInterval(refreshModalType, 3000000);

            $('#modal-edit-type').on('hidden.bs.modal', function () {
                clearInterval(intervalIdType);
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

        function loadProjectSprint() {
            const id_dg_client_project = <?php echo $id_dg_client_project; ?>; // Pastikan variabel ini telah didefinisikan di PHP

            $.ajax({
                url: 'view/ajax/load_project_sprint.php', // Endpoint untuk memuat data
                type: 'POST',
                data: { id_dg_client_project: id_dg_client_project },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const sprint = response.data; // Ambil data dari respons
                        let rows = '';

                        if (sprint.length > 0) {
                            sprint.forEach((link, index) => {
                                rows += `
                                    <tr>
                                        <td style="text-align: center;">${index + 1}</td>
                                        <td>${link.nama_sprint}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `
                                <tr>
                                    <td colspan="2" style="text-align: center;">No sprint found.</td>
                                </tr>
                            `;
                        }

                        $('#daftar-sprint').html(rows); // Update tabel dengan data
                    } else {
                        toastr.error('Failed to load project sprint.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('An error occurred while loading project sprint.');
                }
            });
        }

        function loadProjectType() {
            const id_dg_client_project = <?php echo $id_dg_client_project; ?>; // Pastikan variabel ini telah didefinisikan di PHP

            $.ajax({
                url: 'view/ajax/load_project_type.php', // Endpoint untuk memuat data
                type: 'POST',
                data: { id_dg_client_project: id_dg_client_project },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const type = response.data; // Ambil data dari respons
                        let rows = '';

                        if (type.length > 0) {
                            type.forEach((link, index) => {
                                rows += `
                                    <tr>
                                        <td style="text-align: center;">${index + 1}</td>
                                        <td>${link.nama_type}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `
                                <tr>
                                    <td colspan="2" style="text-align: center;">No type found.</td>
                                </tr>
                            `;
                        }

                        $('#daftar-type').html(rows); // Update tabel dengan data
                    } else {
                        toastr.error('Failed to load project type.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('An error occurred while loading project type.');
                }
            });
        }

        // Panggil fungsi untuk memuat data saat halaman selesai dimuat
        $(document).ready(function() {
            loadProjectLinks();
            loadProjectSprint();
            loadProjectType();
        });

        function loadEverything() {
                refreshTeamSpaceTaskTable();
                loadCalendar();
                loadKanban();
                loadGalleryView();
            };

    

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
                        loadEverything();
                        //toastr.success('Filter updated successfully!', 'Success');
                    } else {
                        loadEverything();
                        toastr.error('Failed to update filter.', 'Error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadEverything();
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
                        loadEverything();
                        //toastr.success('Filter updated successfully!', 'Success');
                    } else {
                        loadEverything();
                        toastr.error('Failed to update filter.', 'Error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    loadEverything();
                    toastr.error('An error occurred while updating the filter.', 'Error');
                    console.error(`AJAX Error: ${textStatus} - ${errorThrown}`);
                }
            });
        });


        $('#sortGalleryBy').on('change', function() {
            const sortBy = $('#sortGalleryBy').val();
            localStorage.setItem('gallery_sort_by', sortBy);

            loadGalleryView();
        });

        $('#toggleSortOrder').on('click', function () {
            const label = $('#sortOrderLabel');
            const isAsc = label.text() === 'Ascending ↑';
            label.text(isAsc ? 'Descending ↓' : 'Ascending ↑');

            let labelOrder = "";
            if (isAsc==true) {
                labelOrder = "Descending ↓";
            }else{
                labelOrder = "Ascending ↑";
            }

            console.log("isAsc", isAsc);
            console.log("labelOrder", labelOrder);
            

            localStorage.setItem('gallery_sort_order', labelOrder);
            loadGalleryView();
        });


        document.getElementById('ratioSelector').addEventListener('change', function () {
            const selectedRatio = this.value;
            const ratioBoxes = document.querySelectorAll('.ratio-box');

            localStorage.setItem('gallery_select_ratio', selectedRatio); // simpan ke cache
            applyRatio(selectedRatio, ratioBoxes);
        });

        function applyRatio(ratio, boxes) {
            boxes.forEach(box => {
                box.classList.remove('ratio-1-1', 'ratio-4-5', 'ratio-16-9');
                if (ratio === '1:1') {
                    box.classList.add('ratio-1-1');
                } else if (ratio === '4:5') {
                    box.classList.add('ratio-4-5');
                } else if (ratio === '16:9') {
                    box.classList.add('ratio-16-9');
                }
            });
        }


        function loadGalleryView() {
            console.log("loadGalleryView");
            
            document.getElementById('galleryLoadingOverlay').style.display = 'flex'; // Show loading

            const sortBy = localStorage.getItem('gallery_sort_by') || 'deadline';
            const sortOrder = localStorage.getItem('gallery_sort_order') || 'Ascending ↑';
            const label = $('#sortOrderLabel');

            label.text(sortOrder);


            const projectId = '<?php echo $id_dg_client_project; ?>';
            const userId = '<?php echo $id_user; ?>';
            

            $('#sortGalleryBy').val(sortBy);       // Set default dropdown
            $('#toggleSortOrder').val(sortOrder);

            $.ajax({
                url: 'view/ajax/fetch_kanban.php',
                data: { id_project: projectId, id_user: userId },
                dataType: 'json',
                success: function(data) {
                    const galleryGrid = $('#galleryGrid');
                    galleryGrid.empty();

                    // Gabungkan semua task dari group
                    let allTasks = [];
                    data.forEach(group => {
                        allTasks = allTasks.concat(group.tasks);
                    });

                    // Buat peta status berdasarkan id_status
                    const statusMap = {};
                    data.forEach(statusGroup => {
                        if (statusGroup.tasks && statusGroup.tasks.length > 0) {
                            const statusNameX = statusGroup.nama_status;
                            const statusId = statusGroup.id_dg_client_project_status;

                            if (statusId && statusNameX) {
                                statusMap[statusId] = statusNameX;
                            }
                        }
                    });


                    // Ambil calendar data jika ada
                    const calendarData = data.find(group => group.task_calendar_data)?.task_calendar_data || [];

                    // Proses calendarData ke dalam map berdasarkan id_task
                    const calendarMap = {};
                    calendarData.forEach(item => {
                        const taskId = item.id_task;
                        if (!calendarMap[taskId]) {
                            calendarMap[taskId] = {
                                nama_status_now: item.nama_status,
                                nama_sprint: item.nama_sprint || '-',
                                assigned_users: item.assigned_users || [],
                                timelineMap: new Map(),
                                detail_project: item.detail_project
                            };
                        }

                        if (item.deadline_status) {
                            const key = `${item.deadline_status}_${item.nama_status}`;
                            calendarMap[taskId].timelineMap.set(key, {
                                status: item.nama_status,
                                assigned_users: item.assigned_users || [],
                                warna_status: item.warna_status || '#007bff',
                                deadline: new Date(item.deadline_status)
                            });
                        }
                    });

                    // Proses sorting sebelum looping
                    allTasks.sort((a, b) => {
                    let comparison = 0;

                    if (sortBy === 'deadline') {
                        const taskA = calendarMap[a.id_dg_client_project_task];
                        const taskB = calendarMap[b.id_dg_client_project_task];

                        const lastDeadlineA = taskA && taskA.timelineMap
                            ? Array.from(taskA.timelineMap.values()).reduce((latest, item) => {
                                return (!latest || (item.deadline && item.deadline > latest)) ? item.deadline : latest;
                            }, null)
                            : null;

                        const lastDeadlineB = taskB && taskB.timelineMap
                            ? Array.from(taskB.timelineMap.values()).reduce((latest, item) => {
                                return (!latest || (item.deadline && item.deadline > latest)) ? item.deadline : latest;
                            }, null)
                            : null;

                        if (!lastDeadlineA && !lastDeadlineB) return 0;
                        if (!lastDeadlineA) return 1;
                        if (!lastDeadlineB) return -1;
                        comparison = lastDeadlineA - lastDeadlineB;

                    } else if (sortBy === 'nama_task') {
                        const nameA = a.nama_task?.toLowerCase() || '';
                        const nameB = b.nama_task?.toLowerCase() || '';
                        comparison = nameA.localeCompare(nameB);

                    } else {
                        comparison = a.id_dg_client_project_task - b.id_dg_client_project_task;
                    }

                    return sortOrder === 'Ascending ↑' ? comparison : -comparison;

                });



                    // Loop ke setiap task untuk ditampilkan
                    allTasks.forEach(task => {
                        let images = [];

                        // Ambil gambar
                        if (task.detail_project) {
                            try {
                                const decoded = decodeURIComponent(task.detail_project);
                                const imgMatches = [...decoded.matchAll(/<img[^>]+src="([^">]+)"/g)];
                                images = imgMatches.map(m => m[1]);
                            } catch (e) {
                                console.warn("Image parsing error:", e);
                            }
                        }

                        if (images.length === 0) return;

                        let taskData = calendarMap[task.id_dg_client_project_task] || {};
                        taskData.nama_status_now = taskData.nama_status_now 
                            || task.nama_status_now 
                            || task.nama_status 
                            || statusMap[task.id_status] 
                            || '-';

                        
                        taskData.nama_sprint = taskData.nama_sprint || task.nama_sprint || '-';
                        taskData.assigned_users = taskData.assigned_users || task.assigned_users || [];
                        taskData.detail_project = taskData.detail_project || task.detail_project;
                        taskData.timelineMap = taskData.timelineMap || new Map();


                        // Jika tidak ada deadline sama sekali, tambahkan dummy
                        if (taskData.timelineMap.size === 0) {
                            taskData.timelineMap.set('no_deadline', {
                                status: task.nama_status,
                                assigned_users: taskData.assigned_users || [],
                                warna_status: '#cccccc',
                                deadline: null
                            });
                        }

                        const sortedTimeline = Array.from(taskData.timelineMap.values()).sort((a, b) => {
                            return a.deadline && b.deadline ? a.deadline - b.deadline : 0;
                        });

                        function formatDateLong(dateString) {
                            const date = new Date(dateString);
                            return date.toLocaleDateString('en-US', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                        }


                        const deadlineInfo = sortedTimeline.map(item => {
                            const users = (item.assigned_users || []).map(user => `
                                <img class="img-circle info-img" src="img/profile/${user.photo}" title="${user.nama}" >
                            `).join('');
                            return item.deadline ? `
                                <div style="margin-bottom:4px;">
                                    <strong>${item.status}</strong> — ${formatDateLong(item.deadline)}<br>
                                    Assigned to: ${users}
                                </div>
                            ` : '';
                        }).join('');

                        const tooltipText = `
                            <strong>${task.nama_task}</strong><br>
                            Sprint: ${taskData.nama_sprint}<br>
                            Status: ${taskData.nama_status_now}<br>
                            ${deadlineInfo ? '<hr style="background-color: white;">' + deadlineInfo : ''}
                        `;

                        const carouselId = `carousel-${task.id_dg_client_project_task}`;
                        const carouselInner = images.map((img, i) => `
                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                <div class="ratio-box ratio-4-5 position-relative gallery-hover-box">
                                    <img src="${img}" class="d-block w-100 h-100" style="object-fit: contain;">
                                    <div class="tooltip-overlay">${tooltipText}</div>
                                    <a href="${img}" download class="btn btn-sm btn-light position-absolute download-btn" style="top: 10px; right: 10px; z-index: 10;" title="Download this image">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        `).join('');

                        const galleryItem = `
                            <div class="col-md-4 mb-4" id="galleryGridItem" data-id-task="${task.id_dg_client_project_task}">
                                <div class="position-relative gallery-hover-box">
                                    <button class="btn btn-sm btn-dark position-absolute zip-download-btn" 
                                            style="top: 10px; left: 10px; z-index: 11; display: none;" 
                                            data-images='${JSON.stringify(images)}' 
                                            data-task-name="${task.nama_task.replace(/[^\w\s-]/g, '')}" 
                                            title="Download All Images as ZIP">
                                        <i class="fas fa-file-archive"></i> ZIP
                                    </button>
                                    <div id="${carouselId}" class="carousel slide" data-ride="carousel" data-interval="false">
                                        <div class="carousel-inner">${carouselInner}</div>
                                        ${images.length > 1 ? `
                                            <a class="carousel-control-prev" href="#${carouselId}" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </a>
                                            <a class="carousel-control-next" href="#${carouselId}" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </a>` : ''}
                                    </div>
                                </div>
                            </div>
                        `;

                        galleryGrid.append(galleryItem);
                        
                    });

                    document.getElementById('galleryLoadingOverlay').style.display = 'none';
                    $('.carousel').carousel();
                    
                    const selectRatio = localStorage.getItem('gallery_select_ratio') || '4:5';
                    const ratioBoxes = document.querySelectorAll('.ratio-box');
                    
                    // ✅ Atur value dropdown dari cache
                    const ratioSelector = document.getElementById('ratioSelector');
                    if (ratioSelector) {
                        ratioSelector.value = selectRatio;
                    }

                    applyRatio(selectRatio, ratioBoxes);

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
                
            });
        }

        // Tangani klik feed galeri (gambar dalam carousel)
        $('#galleryGrid').on('click', '.carousel-item', function () {
            // Cek jika yang diklik adalah tombol download atau elemen di dalamnya
            if ($(e.target).closest('.download-btn').length > 0) {
                return; // Jangan lanjutkan kalau klik download
            }

            const taskId = $(this).closest('[data-id-task]').data('id-task');
            editTask(taskId).always(() => {
                setTimeout(() => {
                    updateUndoRedoState(taskId);
                }, 500);
            });
        });

       document.getElementById('downloadAll').addEventListener('click', function () {
            const zip = new JSZip();
            const buttons = document.querySelectorAll('.zip-download-btn');

            const promises = [];

            buttons.forEach(button => {
                const images = JSON.parse(button.getAttribute('data-images'));
                const taskName = button.getAttribute('data-task-name').replace(/[^\w\s-]/g, '').trim() || 'Untitled_Task';
                const folder = zip.folder(taskName); // folder khusus untuk task ini

                images.forEach((imageUrl, index) => {
                    const filename = `image_${index + 1}${getExtension(imageUrl)}`;
                    const promise = fetch(imageUrl)
                        .then(response => response.blob())
                        .then(blob => {
                            folder.file(filename, blob);
                        })
                        .catch(err => console.warn(`Error downloading ${imageUrl}:`, err));
                    promises.push(promise);
                });
            });

            Promise.all(promises).then(() => {
                zip.generateAsync({ type: 'blob' })
                    .then(content => {
                        const now = new Date();
                        const pad = n => n.toString().padStart(2, '0');
                        const timestamp = `${now.getFullYear()}${pad(now.getMonth() + 1)}${pad(now.getDate())}_${pad(now.getHours())}${pad(now.getMinutes())}${pad(now.getSeconds())}`;

                        saveAs(content, "<?php echo $nama_client; ?>_<?php echo $nama_project; ?>_"+timestamp);
                    });
            });
        });

        function getExtension(url) {
            const match = url.match(/\.\w+(?=$|\?)/);
            return match ? match[0] : '.jpg';
        }






        $(document).on('click', '.zip-download-btn', function () {
            const images = JSON.parse($(this).attr('data-images'));
            const taskName = $(this).attr('data-task-name') || 'gallery_images';
            const zip = new JSZip();
            const imgFolder = zip.folder(taskName);

            let count = 0;

            images.forEach((url, index) => {
                fetch(url)
                    .then(res => res.blob())
                    .then(blob => {
                        const ext = url.split('.').pop().split(/\#|\?/)[0];
                        imgFolder.file(`image-${index + 1}.${ext}`, blob);
                        count++;
                        if (count === images.length) {
                            zip.generateAsync({ type: 'blob' }).then(function (content) {
                                saveAs(content, `${taskName}.zip`);
                            });
                        }
                    }).catch(err => console.error("ZIP fetch error:", err));
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

                    // Jika is_deadline_active null, jadikan 0
                    let isDeadlineActive = status.is_deadline_active !== null ? status.is_deadline_active : 0;

                    // Jika is_finish = 1, tambahkan ikon bendera
                    let statusName = status.is_finish == 1 
                        ? `${status.nama_status} (<i class="fas fa-flag-checkered"></i>)` 
                        : status.nama_status;

                    let statusCard = `
                    <div class="card card-row" data-id-status="${status.id_dg_client_project_status}" data-nama-status="${status.nama_status}" 
                    data-order-status="${status.urutan_status}" data-deadline-status="${isDeadlineActive}" data-finish="${status.is_finish}">
                        <div class="card-header status-head">
                            <h3 class="card-title" style="background-color: ${status.warna_status} !important;">
                                ${statusName}
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

                        // Jika deadline_status ada dan is_deadline_active aktif
                        if (status.is_deadline_active && task.deadline_status) {
                            const deadlineDate = new Date(task.deadline_status);
                            const today = new Date();

                            // Reset jam supaya perbandingan hanya berdasarkan tanggal
                            deadlineDate.setHours(0, 0, 0, 0);
                            today.setHours(0, 0, 0, 0);

                            if (!isNaN(deadlineDate)) {
                                const formattedDeadline = deadlineDate.toLocaleDateString('id-ID', {
                                    weekday: 'long',
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });

                                const dayDiff = Math.floor((deadlineDate - today) / (1000 * 60 * 60 * 24));
                                let deadlineNote = '';

                                if (dayDiff > 0) {
                                    deadlineNote = `${dayDiff} days left`;
                                } else if (dayDiff === 0) {
                                    deadlineNote = `Deadline today !`;
                                } else {
                                    deadlineNote = `<span style="color:red;">Past ${Math.abs(dayDiff)} days !</span>`;
                                }

                                deadlineHtml = `
                                    <div class="info-date d-flex align-items-center" style="display: flex; align-items: center;">
                                        <i class="fas fa-calendar-alt" style="font-size: 22px; margin-right: 10px;"></i>
                                        <div style="font-size: 15px;">
                                            <div style="font-weight: bold;">${formattedDeadline}</div>
                                            <div>${deadlineNote}</div>
                                        </div>
                                    </div>`;

                            }
                        }


                        const userImages = task.users.map(user => `
                            <img class="img-circle info-img" src="img/profile/${user.photo || 't0.jpg'}" alt="${user.nama}" title="${user.nama}">
                        `).join('');

                        statusCard += `
                        <div class="card card-outline card-task" data-id-task="${task.id_dg_client_project_task}">
                            <div class="card-header">
                                <h5 class="card-title judul-task"><b>${task.nama_task}</b></h5>
                                <div class="card-tools">
                                                        
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool" title="Setting Task"
                                            data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item duplicate-task" href="#"><i class="fas fa-copy"></i> Duplicate Task</a>
                                            <a class="dropdown-item delete-task" href="#"><i class="fas fa-trash-alt"></i> Delete Task</a>
                                        </div>
                                    </div>
                            
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
                adjustStatusHeight();

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


   function initializeStickyHeaders() {
    const statusHeads = document.querySelectorAll('.status-head');

    function updateStatusHeadPosition() {
        statusHeads.forEach((statusHead) => {
            if (!statusHead) return;

            const parent = statusHead.parentElement;
            if (!parent) return;

            const statusBody = parent.querySelector('.status-body');
            const widthSource = statusBody || parent;
            const parentRect = parent.getBoundingClientRect();
            const offsetTop = 50;

            const isSticky = parent.classList.contains('is-sticky');

            if (parentRect.top <= offsetTop) {
                if (!isSticky) {
                    // Tambah padding-top agar tidak lompat
                    parent.style.paddingTop = `${statusHead.offsetHeight}px`;
                    parent.classList.add('is-sticky');
                }

                statusHead.style.position = 'fixed';
                statusHead.style.top = offsetTop + 'px';
                statusHead.style.zIndex = '999';
                statusHead.style.width = `${widthSource.scrollWidth}px`;
                statusHead.style.left = `${-widthSource.scrollLeft + parentRect.left}px`;
            } else {
                if (isSticky) {
                    parent.style.paddingTop = '0px';
                    parent.classList.remove('is-sticky');
                }

                statusHead.style.position = 'static';
                statusHead.style.top = '';
                statusHead.style.left = '';
                statusHead.style.width = '';
                statusHead.style.zIndex = '';
            }
        });
    }

    document.addEventListener('scroll', updateStatusHeadPosition);

    document.querySelectorAll('.status-body').forEach((statusBody) => {
        if (!statusBody) return;
        statusBody.addEventListener('scroll', updateStatusHeadPosition);
    });

    requestAnimationFrame(function check() {
        updateStatusHeadPosition();
        requestAnimationFrame(check);
    });
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
                    loadEverything(); // Reload the Kanban board
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
            const statusIsFinish = $(this).closest('.card-row').data('finish');
            const statusColor = $(this).closest('.card-row').find('.card-title').css('background-color');

            // Fill modal fields
            $('#editStatusId').val(statusId);
            $('#editStatusName').val(statusName);
            $('#editStatusOrder').val(statusOrder);
            $('#editHasDeadline').val(statusDeadline);
            $('#editIsFinish').val(statusIsFinish);
            $('#editStatusColor').val(rgbToHex(statusColor)); // Convert RGB to HEX

            //console.log(statusId, statusName, statusOrder, statusDeadline, statusIsFinish, statusColor);
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
                isFinish: $('#editIsFinish').val()
            };
            

            $.ajax({
                url: 'view/ajax/edit_status.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    //console.log(response);
                    if (response.success) {
                        //console.log('Status edited:', response);
                        $('#editStatusModal').modal('hide');
                        loadEverything(); // Reload Kanban board
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
                            loadEverything(); // Reload Kanban board
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


    $('#addTaskModal').on('shown.bs.modal', function () {
        $(this).find('.modal-content').animate({ scrollTop: 0 }, 300);
    });



    // Trigger modal dan langsung simpan data saat tombol + ditekan
    $(document).on('click', '[title="Add Task"]', function () {

        // Dapatkan id_status dari kolom tempat tombol di-klik
        const idStatus = $(this).closest('.card-row').data('id-status');
        $('#id_status').val(idStatus).trigger('change'); // Set id_status di modal dan trigger Select2
        
        $('#addTaskModal .loading-overlay').show();
        $('#modal-video-upload').addClass('summernote-modal');


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
                //console.log(response.sprints);

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

                
                //console.log(firstSprintId, firstTypeId, firstTypeDetail);

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
                get_statuses_with_deadline();

                function getNewTaskName() {
                    const baseName = "New Task";
                    let count = 1;
                    let newName = baseName;

                    // Loop selama ada elemen yang punya nama seperti newName
                    while ($(`h5.card-title.judul-task:contains("${newName}")`).length > 0) {
                        count++;
                        newName = `${baseName} ${count}`;
                    }

                    return newName;
                }
                // Dapatkan nama task yang unik
                const uniqueTaskName = getNewTaskName();
                $('#nama_task').val(uniqueTaskName);

                const idProject = <?php echo $id_dg_client_project; ?>;
                const createdBy = <?php echo $id_user; ?>;

                // Data awal yang akan dikirim
                const initialData = {
                    id_project: idProject,
                    id_sprint: firstSprintId ?? 0, // Ambil nilai yang telah disetel
                    id_type: firstTypeId, // Ambil nilai yang telah disetel
                    id_status: idStatus,
                    nama_task: uniqueTaskName, // Nama default
                    priority: $('#priority').val(), // Nilai priority awal
                    detail_project: firstTypeDetail, // Kosongkan detail project di awal
                    created_by: createdBy
                };
                

                // Tampilkan loader di modal
                $('#addTaskModal .loading-overlay').show();
                firstTypeDetail = decodeURIComponent(firstTypeDetail);
                if (firstTypeDetail=='null') {
                    firstTypeDetail = '';
                }
                $('#detail_project').summernote('code', firstTypeDetail || "");


                // Kirim data awal ke server untuk disimpan
                $.ajax({
                    url: 'view/ajax/add_task.php',
                    type: 'POST',
                    data: initialData,
                    dataType: 'json',
                    success: function (response) {
                        //console.log('Initial Data:', initialData);
                        // Sembunyikan loader
                        $('#addTaskModal .loading-overlay').hide();
                        refreshTeamSpaceTaskTable();
                        //loadCalendar();
                        loadKanban();
                        if (response.success) {
                            // Tampilkan modal setelah berhasil menyimpan
                            $('#id_task').val(response.taskId); // Simpan id_task yang baru dibuat
                            //console.log('Task created:', response.taskId);
                            toastr.success('Task created successfully!');
                        } else {
                            toastr.error(`Failed to create task: ${response.message || 'Unknown error'}`);
                            console.error('Failed to create task:', response);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#addTaskModal .loading-overlay').hide();
                        toastr.error(`Failed to create task: ${xhr.responseText || error}`);
                        console.error('Failed to create task:', error);
                    },
                    complete: function () {
                        $('#addTaskModal .loading-overlay').hide();
                        $('#addTaskModal .loading-overlay').hide();
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
            const $btn = $(this);
            if ($btn.prop('disabled')) return;

            $('#addTaskModal').find('.modal-content').animate({ scrollTop: 0 }, 300);

            $btn.prop('disabled', true);
            const taskId = $btn.closest('.card-task').data('id-task');

            

            editTask(taskId).always(() => {
                setTimeout(() => {
                    $btn.prop('disabled', false); // Aktifkan kembali setelah 0.5 detik

                    const currentContent = $('.detail_project').summernote('code');
                    // Setelah summernote terisi, update tombol Undo/Redo
                    updateUndoRedoState(taskId);

                }, 500);
            });

  

            
        });

    

    cleanupOldHistory();

        


    function editTask(taskId) {
        $('#addTaskModal').modal('show');
        $('#addTaskModal .loading-overlay').show();
        $('#modal-video-upload').addClass('summernote-modal');
        $('#addTaskModal .loading-overlay').show();
        get_statuses_with_deadline();


        $('#detail_project').summernote({
            codeviewFilter: false,
            codeviewIframeFilter: false
        });

        function loadDropdowns() {
            return $.ajax({
                url: 'view/ajax/fetch_dropdown_data.php',
                type: 'GET',
                data: { id_project: '<?php echo $id_dg_client_project; ?>' },
                dataType: 'json'
            }).done(function (response) {
                const sprintDropdown = $('#id_sprint');
                sprintDropdown.empty();
                response.sprints?.forEach(s => {
                    sprintDropdown.append(`<option value="${s.id_dg_client_project_sprint}">${s.nama_sprint}</option>`);
                });

                const typeDropdown = $('#id_type');
                typeDropdown.empty();
                response.types?.forEach(t => {
                    typeDropdown.append(`<option value="${t.id_dg_client_project_type}">${t.nama_type}</option>`);
                });

                const statusDropdown = $('#id_status');
                statusDropdown.empty();
                response.statuses?.forEach(st => {
                    statusDropdown.append(`<option value="${st.id}">${st.name}</option>`);
                });
            });
        }

        function loadTaskDetails(taskId) {
            return $.ajax({
                url: 'view/ajax/get_task_details.php',
                type: 'GET',
                data: { id_task: taskId },
                dataType: 'json'
            }).done(function (response) {
                $('#addTaskModal .loading-overlay').hide();
                if (response.success) {
                    let latestNotes = decodeURIComponent(response.data.detail_project);
                    if (latestNotes !== 'null') {
                        // Replace path sesuai keinginan
                        latestNotes = latestNotes
                            .replaceAll('view/ajax/uploads/images/task/', 'storage/task/img/')
                            .replaceAll('view/ajax/uploads/videos/task/', 'storage/task/video/')
                            .replaceAll('img/ai_images/', 'storage/ai/img/');

                        $('#detail_project').summernote('code', latestNotes || "");
                    }

                    Prism.highlightAll();
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
                            const selectedUsers = assignmentData.assigned_users?.map(item => item.id_user) || [];
                            const assignUsersSelect = $(`#assign_users_${assignmentData[0].id_status}`);
                            if (assignUsersSelect.length) {
                                assignUsersSelect.val(selectedUsers).trigger('change');
                            }
                        });
                    }
                    initialDataLoaded = true;
                } else {
                    toastr.error(`Failed to load task details: ${response.message || 'Unknown error'}`);
                }
            }).fail(function (xhr, status, error) {
                $('#addTaskModal .loading-overlay').hide();
                toastr.error(`Failed to load task details: ${xhr.responseText || error}`);
            });
        }

         
         

        return loadDropdowns()
            .then(() => loadTaskDetails(taskId))
            .always(() => {
                $('#addTaskModal .loading-overlay').hide();
            });

            
       
    }




    let isUndoing = false;
    let isRedoing = false;




    function getHistoryKey(taskId) {
        return `task_history_${taskId}`;
    }

    function getTaskHistory(taskId) {
        const raw = localStorage.getItem(getHistoryKey(taskId));
        if (!raw) return { undo: [], redo: [], timestamp: Date.now() };
        return JSON.parse(raw);
    }

    function setTaskHistory(taskId, data) {
        localStorage.setItem(getHistoryKey(taskId), JSON.stringify({ ...data, timestamp: Date.now() }));
    }

    function clearRedo(taskId) {
        const data = getTaskHistory(taskId);
        data.redo = [];
        setTaskHistory(taskId, data);
    }

    function pushUndo(taskId, content) {
        if (isUndoing || isRedoing) return;

        const data = getTaskHistory(taskId);
        const last = data.undo[data.undo.length - 1];

        if (last == content) {
            console.log("last==content");
        }else{
            console.log("last: ", last);
            console.log("content :", content);
        }

        if (last == content) return;

        data.undo.push(content);
        if (data.undo.length > 50) data.undo.shift();
        data.redo = [];
        setTaskHistory(taskId, data);
    }



    function doUndo(taskId) {
        const data = getTaskHistory(taskId);
        const currentContent = $('#detail_project').summernote('code');

        while (data.undo.length > 0) {
            const previous = data.undo.pop();
            if (previous !== currentContent) {
                data.redo.push(currentContent);
                setTaskHistory(taskId, data);
                return previous;
            }
        }
        return null; // Tidak ada yang bisa di-undo
    }


    function doRedo(taskId) {
        const data = getTaskHistory(taskId);
        if (data.redo.length === 0) return null;
        const currentContent = $('#detail_project').summernote('code');
        data.undo.push(currentContent);
        const next = data.redo.pop();
        setTaskHistory(taskId, data);
        return next;
    }

    function cleanupOldHistory() {
        const now = Date.now();
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('task_history_')) {
                const item = JSON.parse(localStorage.getItem(key));
                if (now - item.timestamp > 24 * 60 * 60 * 1000) {
                    localStorage.removeItem(key);
                }
            }
        });
    }


    $('#undoTidyUp').on('click', function () {
        const taskId = $('#id_task').val();
        isUndoing = true;
        const undoContent = doUndo(taskId);
        console.log("undoContent: ", undoContent);
        
        if (undoContent !== null) {
            $('#detail_project').summernote('code', undoContent);
        }
        isUndoing = false;
        updateUndoRedoState(taskId);
    });

    $('#redoTidyUp').on('click', function () {
        const taskId = $('#id_task').val();
        isRedoing = true;
        const redoContent = doRedo(taskId);

        console.log("redoContent: ", redoContent);
        if (redoContent !== null) {
            $('#detail_project').summernote('code', redoContent);
        }
        isRedoing = false;
        updateUndoRedoState(taskId);
    });



    function updateUndoRedoState(taskId) {
        const data = getTaskHistory(taskId);
        const currentContent = $('#detail_project').summernote('code');

        // Cek apakah masih ada undo yang berbeda dari current content
        const hasUndo = data.undo.some(content => content !== currentContent);
        const hasRedo = data.redo.length > 0;

        // console.log("currentContent: ", currentContent);
        // console.log("hasUndo: ", hasUndo);
        

        $('#undoTidyUp').prop('disabled', !hasUndo);
        $('#redoTidyUp').prop('disabled', !hasRedo);
    }


    function clearAllTaskHistories() {
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('task_history_')) {
                localStorage.removeItem(key);
            }
        });

        // Nonaktifkan tombol undo/redo jika pop-up sedang terbuka
        $('#undoTidyUp').prop('disabled', true);
        $('#redoTidyUp').prop('disabled', true);

        console.log('Semua cache task_history berhasil dihapus.');
    }


    //clearAllTaskHistories();



    let typingTimer; // Timer untuk delay
    const typingDelay = 20000; // Delay dalam milidetik (2 detik)

    function saveTaskData(detail) {
        //console.log('Save :' + detail);
        var id_task = $('#id_task').val(); // Ganti 'your_hidden_input_id' dengan ID sebenarnya
        if (!id_task) {
            return;
        }


        const currentContent = $('#detail_project').summernote('code');
        pushUndo(id_task, currentContent);
        updateUndoRedoState(id_task);


        // Ambil data dari Summernote dan input lainnya
        const detailProject = encodeURIComponent($('#detail_project').summernote('code'));
        const formData = $('#addTaskForm').serializeArray();

        formData.push({ name: 'detail_project', value: detailProject });
        formData.push({ name: 'id_user', value: <?php echo $id_user; ?> });

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

        

        // Tampilkan loader
        $('#addTaskModal .loading-overlay').show();

        $.ajax({
            url: 'view/ajax/update_task.php',
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function (response) {
                //console.log("Data yang dikirim:", formData);
                loadEverything();
                $('#addTaskModal .loading-overlay').hide();
                if (response.success) {
                    showSuccessToast('Task updated successfully!');
                } else {
                    toastr.error(`Failed to update task: ${response.message || 'Unknown error'}`);
                    console.error('Failed to update task:', response);
                }
            },
            error: function (xhr, status, error) {
                $('#addTaskModal .loading-overlay').hide();
                toastr.error(`Failed to update task: ${xhr.responseText || error}`);
                console.error('Failed to update task:', error);
            }
        });
    }

    // Fungsi untuk menunda penyimpanan saat mengetik
    function debounceSaveTaskData() {
        //console.log('Debouncing...');
        if (!initialDataLoaded) {
            return; // Lewati penyimpanan jika data awal sedang dimuat
        }
        clearTimeout(typingTimer); // Hentikan timer sebelumnya
        typingTimer = setTimeout(() => saveTaskData("debounces"), typingDelay);
    }


    let previousTypeId = null; // Variabel untuk menyimpan ID type sebelumnya
    let previousTemplate = null; // Variabel untuk menyimpan template type sebelumnya

    // Simpan nilai sebelum perubahan saat Select2 dibuka
    $('#id_type').on('select2:opening', function () {
        previousTypeId = $(this).val(); // Simpan ID type yang dipilih sebelum perubahan
        //console.log("Previous id_type (before change): " + previousTypeId);
    });

    // Event listener untuk perubahan pada Select2
    $('#id_type').on('select2:select', function (e) {
        const newTypeId = e.params.data.id; // ID type yang baru dipilih
        //console.log("Previous id_type: " + previousTypeId);
        //console.log("New id_type: " + newTypeId);

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
                const currentDetailProject = safeDecodeURIComponent($('#detail_project').summernote('code'));
                const typeTemplate = safeDecodeURIComponent(response.template);


                function safeDecodeURIComponent(str) {
                    try {
                        return decodeURIComponent(str);
                    } catch (e) {
                        console.warn('decodeURIComponent failed:', e, 'on string:', str);
                        return str; // Kembalikan string original jika gagal decode
                    }
                }


                //console.log("previousTemplate: "+previousTemplate);
                console.log("currentDetailProject: "+currentDetailProject);
                //console.log("typeTemplate: "+typeTemplate);
                

                // Cek apakah detail_project belum diubah atau masih null
                if (!currentDetailProject || currentDetailProject.trim() == '' || currentDetailProject.trim() == '<br>' || currentDetailProject == typeTemplate) {
                    // Perbarui detail_project dengan template baru
                    fetchNewTemplateByTypeId(newTypeId).then((response) => {
                        if (response.success) {
                            const newtypeTemplate = decodeURIComponent(response.template);
                            $('#detail_project').summernote('code', newtypeTemplate);
                            //console.log("newtypeTemplate: "+newtypeTemplate);
                        } else {
                            toastr.warning('Failed to fetch the new template for the selected type.');
                        }
                    }).catch((error) => {
                        console.error('Error fetching new template:', error);
                        toastr.error('An error occurred while fetching the new template.');
                    });
                    
                    toastr.info('Task Detail updated with the new type template.');
                } else {
                    //toastr.warning('Detail project was modified and will not be updated.');
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
        //console.log('Change...');
        //console.log('Initial data loaded: ' + initialDataLoaded);
        //console.log('Form data:', $(this).serializeArray());
        if (!initialDataLoaded) return;

        // Delay untuk menunggu elemen benar-benar update
        setTimeout(() => {
            saveTaskData("addTaskForm");
        }, 200); // 200ms cukup aman, bisa disesuaikan
    });




   
        function hiddenModal() {
            //console.log('Hiden...');
            saveTaskData("hidden"); // Simpan data saat modal ditutup
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

            $("[id^='assign_users_']").each(function () {
                $(this).val(null).trigger('change');
            });

            $("[id^='deadline_']").each(function () {
                $(this).val('');
            });


            // Reset Summernote
            $('#detail_project').summernote('code', ''); // Set konten Summernote menjadi kosong

            // Hapus input date yang di generate
            $('#deadlineContainer .form-group:not(:first)').remove();

            // Reset input date pertama
            $('#deadlineContainer .form-group:first input[type="date"]').val('');

            $('#addTaskModal').modal('hide'); // Tutup modal utama
        }



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

    $(document).on('click', '.delete-task', function (e) {
        e.preventDefault();

        let taskElement = $(this).closest('.card-task'); // Ambil elemen task yang diklik
        let taskId = taskElement.data('id-task'); // Ambil ID task

        // Tampilkan loader
        $('#addTaskModal .loading-overlay').show();

        if (!taskId) {
            toastr.error('No task to delete.');
            return;
        }

        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            $.ajax({
                url: 'view/ajax/delete_task.php',
                type: 'POST',
                data: { id_task: taskId, id_user: <?php echo $id_user; ?> },
                success: function (response) {
                    if (response.success) {
                        toastr.success('Task deleted successfully!');
                        taskElement.remove(); // Hapus elemen task dari DOM
                    } else {
                        toastr.error(response.message || 'Failed to delete task.');
                    }
                    $('#addTaskModal .loading-overlay').hide();
                },
                error: function (xhr, status, error) {
                    toastr.error(`Error deleting task: ${xhr.responseText || error}`);
                    $('#addTaskModal .loading-overlay').hide();
                }
            });
        }
    });

    $(document).on('click', '.duplicate-task', function (e) {
        e.preventDefault();

        let taskElement = $(this).closest('.card-task'); // Ambil elemen task yang diklik
        let taskId = taskElement.data('id-task'); // Ambil ID task

        if (!taskId) {
            toastr.error('No task to duplicate.');
            return;
        }
        // Tampilkan loader
        $('#addTaskModal .loading-overlay').show();

        $.ajax({
            url: 'view/ajax/duplicate_task.php', // Buat file ini untuk menangani duplikasi
            type: 'POST',
            data: { id_task: taskId, id_user: <?php echo $id_user; ?> },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success('Task duplicated successfully!');
                    loadEverything(); // Perbarui tampilan Kanban setelah duplikasi
                } else {
                    toastr.error(response.message || 'Failed to duplicate task.');
                }
                $('#addTaskModal .loading-overlay').hide();
            },
            error: function (xhr, status, error) {
                toastr.error(`Error duplicating task: ${xhr.responseText || error}`);
                $('#addTaskModal .loading-overlay').hide();
            }
        });
    });


    $('#deleteTaskButton').on('click', function () {
        const taskId = $('#id_task').val();
        if (!taskId) {
            toastr.error('No task to delete.');
            return;
        }
        
        // Tampilkan loader
        $('#addTaskModal .loading-overlay').show();

        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            $.ajax({
                url: 'view/ajax/delete_task.php', // Endpoint untuk menghapus task
                type: 'POST',
                data: { id_task: taskId, id_user : <?php echo $id_user; ?>},
                success: function (response) {
                    if (response.success) {
                        toastr.success('Task deleted successfully!');
                        $('#addTaskModal').modal('hide');
                        loadEverything(); // Memperbarui kanban setelah penghapusan
                    } else {
                        toastr.error(response.message || 'Failed to delete task.');
                    }
                    $('#addTaskModal .loading-overlay').hide();
                },
                error: function (xhr, status, error) {
                    toastr.error(`Error deleting task: ${xhr.responseText || error}`);
                    $('#addTaskModal .loading-overlay').hide();
                }
            });
        }
    });

    
    let copiedTaskIds = []; // Array untuk menyimpan task yang disalin

    // Event listener untuk Ctrl + C (Copy)
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && e.key === 'c') {
            // Cek apakah ada teks yang dipilih
            if (window.getSelection().toString().trim() !== '') return;

            copiedTaskIds = $('.card-task.sortable-selected').map(function () {
                return $(this).data('id-task');
            }).get(); // Ambil semua ID task yang terpilih

            if (copiedTaskIds.length === 0) {
                toastr.error('No task selected to copy.');
            } else {
                toastr.success(`${copiedTaskIds.length} task(s) copied.`);
            }
        }
    });

    // Event listener untuk Ctrl + V (Paste)
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && e.key === 'v') {
            // Cek apakah sedang fokus pada input, textarea, atau elemen yang dapat diedit (Summernote)
            if ($(document.activeElement).is('input, textarea, [contenteditable="true"]')) return;

            // Cek apakah ada teks yang dipilih
            if (window.getSelection().toString().trim() !== '') return;

            if (copiedTaskIds.length === 0) {
                toastr.error('No task copied.');
                return;
            }

            // Tampilkan loader
            $('#addTaskModal .loading-overlay').show();

            $.ajax({
                url: 'view/ajax/duplicate_task.php',
                type: 'POST',
                data: { id_task: copiedTaskIds, id_user: <?php echo $id_user; ?> }, // Kirim array ID
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(`${copiedTaskIds.length} task(s) duplicated successfully!`);
                        loadEverything(); // Refresh tampilan Kanban
                    } else {
                        toastr.error(response.message || 'Failed to duplicate task(s).');
                    }
                    $('#addTaskModal .loading-overlay').hide();
                },
                error: function (xhr, status, error) {
                    toastr.error(`Error duplicating task(s): ${xhr.responseText || error}`);
                    $('#addTaskModal .loading-overlay').hide();
                }
            });
        }
    });


    let selectedTaskIds = []; // Array untuk menyimpan task yang dipilih

    $(document).on('keydown', function (e) {
        if (e.key === 'Delete') {
            // Cek apakah ada teks yang dipilih
            if (window.getSelection().toString().trim() !== '') return;

            selectedTaskIds = $('.card-task.sortable-selected').map(function () {
                return $(this).data('id-task');
            }).get(); // Ambil semua ID task yang terpilih

            if (selectedTaskIds.length > 0) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete the selected tasks?')) {
                    return;
                }
                // Tampilkan loader
                $('#addTaskModal .loading-overlay').show();
                $.ajax({
                    url: 'view/ajax/delete_task.php',
                    type: 'POST',
                    data: { id_task: selectedTaskIds },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Tasks deleted successfully!');
                            loadEverything(); // Perbarui tampilan Kanban setelah penghapusan
                        } else {
                            toastr.error(response.message || 'Failed to delete tasks.');
                        }
                        $('#addTaskModal .loading-overlay').hide();
                    },
                    error: function (xhr, status, error) {
                        toastr.error(`Error deleting tasks: ${xhr.responseText || error}`);
                        $('#addTaskModal .loading-overlay').hide();
                    }
                });
            }
        }
    });





            // Deklarasi global untuk Selection.js dan isDragging
            let isDraggingSelection = false;
            let isDragging = false;
            let isLassoActive = false;
            let isMouseMove = false;

            // Pastikan selection dideklarasikan di global
            let selection = null;

            // 🔥 Tangkap event saat mouse bergerak
            document.addEventListener("mousemove", () => {
                isMouseMove = true; // ✅ Aktifkan flag dragging saat ada pergerakan   
            });

            // 🔥 Tangkap event saat mouse berhenti
            document.addEventListener("mouseup", () => {
                isMouseMove = false; 
            });

            document.addEventListener("DOMContentLoaded", function () {
                let touchStartY = 0;
                let touchStartX = 0;
                let isTouchScrolling = false;
                let touchTimer = null;
                let isLongPress = false;

                document.addEventListener("touchstart", (e) => {
                    touchStartY = e.touches[0].clientY;
                    touchStartX = e.touches[0].clientX;
                    isTouchScrolling = false;
                    isLongPress = false;

                    let targetTask = e.target.closest(".card-task");

                    if (targetTask) {
                        touchTimer = setTimeout(() => {
                            isLongPress = true;
                            targetTask.classList.add("sortable-selected"); // Select task
                            if (selection) selection.enable(); // Pastikan selection sudah ada
                        }, 2000);
                    }
                }, { passive: true });

                document.addEventListener("touchmove", (e) => {
                    let deltaY = Math.abs(e.touches[0].clientY - touchStartY);
                    let deltaX = Math.abs(e.touches[0].clientX - touchStartX);

                    if (deltaY > 10 || deltaX > 10) {
                        isTouchScrolling = true;
                        clearTimeout(touchTimer);
                        if (selection) selection.disable(); // Pastikan selection sudah ada
                    }
                }, { passive: true });

                document.addEventListener("touchend", () => {
                    clearTimeout(touchTimer);

                    if (!isLongPress && selection) {
                        selection.disable(); // Pastikan selection sudah ada
                    }
                }, { passive: true });

                if (window.innerWidth <= 768 && selection) {
                    selection.disable();
                }




                //console.log("SelectionArea:", typeof SelectionArea);

                selection = new SelectionArea({
                    selectables: [".card-task"],  // Hanya elemen .card-task yang bisa dipilih
                    boundaries: ["#kanban-board"], // Batas area seleksi
                    selectionAreaClass: "selection-area",
                    startThreshold: 10,
                    singleTap: {
                        allow: true,
                        intersect: "native"
                    }
                });

                // 🔹 Event ketika seleksi dimulai
                selection.on("start", ({ event }) => {
                    isLassoActive = true;
                    if (isDragging) return false; // Hindari konflik dengan Sortable.js
                    //console.log("🔹 Selection started");
                    isDraggingSelection = true;
                });

                // 🔥 Event saat seleksi bergerak
                selection.on("move", ({ store }) => {
                    if (!store || !store.changed) return;
                    const { added, removed } = store.changed;

                    //console.log("🟢 Added elements:", added);
                    //console.log("🔴 Removed elements:", removed);

                    added.forEach(el => {
                        let task = el.closest(".card-task");
                        //console.log("Task Netral:", task);
                        //console.log("isMouseMove:", isMouseMove);
                        //console.log("classList start:", task.classList);

                        // 🔥 Tunda eksekusi selama 3 detik
                        
                            if ((task && isMouseMove) || !task.classList.contains("sortable-selected")) {
                                //console.log("🟢 Task selected:", task);
                                task.classList.add("sortable-selected");
                            }else if(task.classList.contains("sortable-selected")){
                                //console.log("🔴 Task deselected:", task);
                                task.classList.remove("sortable-selected");
                            }

                            //console.log("classList finish:", task.classList);
                       

                        
                    });

                    removed.forEach(el => {
                        let task = el.closest(".card-task");
                        if (task) task.classList.remove("sortable-selected");
                        //console.log("🔴 Task deselected 2:", task);
                    });
                });

                // ✅ Event saat seleksi berhenti
                selection.on("stop", () => {
                    //console.log("✅ Selection done!");
                    isMouseMove = false; 
                    isDraggingSelection = false;
                });

                // 🛑 Hindari konflik dengan drag Sortable.js
                document.querySelector("#kanban-board").addEventListener("mousedown", function (e) { 
                    if (!e.target.closest(".card-task")) {
                        selection.clearSelection(); // Reset seleksi jika klik di luar task
                        //console.log("🔄 Selection cleared");
                    }
                });

                // 🚀 Load Kanban pertama kali
                loadKanban();
            });




            function initSortable() {
                const kanbanColumns = document.querySelectorAll('.card-row .status-body');

                function showOverlay() {
                    $('#workspace-overlay').show();
                }

                function hideOverlay() {
                    setTimeout(() => {
                        loadEverything();
                        $('#workspace-overlay').hide();
                    }, 500);
                }

                kanbanColumns.forEach(column => {
                    new Sortable(column, {
                        group: {
                            name: 'kanban',
                            put: function (to, from, dragged) {
                                const toColumn = to.el.closest('.card-row');
                                return !(toColumn && toColumn.classList.contains('no-status'));
                            },
                            pull: function (to, from, dragged) {
                                // ✅ Izinkan drag keluar dari column .no-status
                                return true;
                            }
                        },
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        handle: '.card-task',
                        draggable: '.card-task',
                        filter: '.custom-control',
                        preventOnFilter: true,
                        multiDrag: true,
                        selectedClass: "sortable-selected",

                        onStart: function (evt) {
                            selection.disable();
                            selection.clearSelection();
                            isDragging = true;

                            // Tambahkan padding bawah untuk semua status-body agar lebih mudah drop
                            $('.status-body').css('padding-bottom', '100px');

                            let selectedItems = document.querySelectorAll('.sortable-selected');

                            if (selectedItems.length > 0) {
                                let mainDraggedItem = evt.item;
                                let otherSelectedItems = [...selectedItems].filter(item => item !== mainDraggedItem);

                                // 🔥 Hilangkan sementara semua item yang dipilih kecuali yang utama
                                otherSelectedItems.forEach(item => {
                                    item.style.opacity = "0"; // Sembunyikan tapi tetap ada di DOM
                                    item.style.transition = "opacity 0.2s ease-out"; // Efek fade-out
                                });

                                // 🔥 Buat efek stack dengan clone dan sembunyikan elemen utama
                                mainDraggedItem.style.opacity = "0.5"; // Buat semi transparan
                                mainDraggedItem.style.transition = "opacity 0.2s ease-out";
                            }
                        },

                        onEnd: function (evt) {
                            isDragging = false;
                            showOverlay();

                            $('.status-body').css('padding-bottom', '0px'); // Hapus padding tambahan setelah drop

                            setTimeout(() => {
                                selection.clearSelection();
                                document.dispatchEvent(new MouseEvent('mouseup'));
                                selection.disable();
                                selection.enable();
                            }, 50);

                            let draggedItems = document.querySelectorAll('.sortable-selected, .sortable-ghost');
                            let draggedTaskIds = [...new Set([...draggedItems].map(item => item.dataset.idTask))];

                            if (draggedTaskIds.length === 0 && evt.item) {
                                let singleDraggedId = evt.item.dataset.idTask;
                                if (singleDraggedId) {
                                    draggedTaskIds = [singleDraggedId];
                                }
                            }

                            if (draggedTaskIds.length === 0) {
                                console.warn("No valid items were dragged.");
                                hideOverlay();
                                return;
                            }

                            resetSelection();

                            const newStatusElement = evt.to.closest('.card-row');
                            if (!newStatusElement) {
                                console.error("New status element not found.");
                                hideOverlay();
                                return;
                            }

                            const newStatusId = newStatusElement.dataset.idStatus;

                            const newOrder = Array.from(evt.to.children)
                                .filter(task => task.dataset.idTask)
                                .map((task, index) => ({
                                    id: task.dataset.idTask,
                                    urutan_task: index + 1
                                }));

                            let requests = []; // 🔥 FIX: Deklarasikan array untuk menampung request

                            draggedTaskIds.forEach((taskId) => {
                                let request = $.ajax({
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

                                requests.push(request);
                            });

                            // 🔥 Tunggu SEMUA request selesai dulu baru jalankan animasi
                            $.when.apply($, requests).then(() => {
                                setTimeout(() => {
                                    // 🔥 Tampilkan kembali item yang tadi disembunyikan
                                    document.querySelectorAll('.sortable-selected').forEach(item => {
                                        item.style.opacity = "1"; // Tampilkan kembali
                                    });

                                    // 🔥 Pastikan elemen utama juga muncul kembali setelah drag selesai
                                    if (evt.item) {
                                        evt.item.style.opacity = "1";
                                    }

                                    resetSelection();
                                    loadEverything();
                                    hideOverlay();
                                    toastr.success('Task status updated successfully!', 'Success');
                                }, 500);
                            }).fail((error) => {
                                console.error("❌ Error in AJAX requests:", error);
                                hideOverlay();
                                toastr.error('Failed to update some tasks.', 'Error');
                            });
                        }
                    });
                });







                // 🔹 Deteksi ketika lasso selesai digunakan
                document.addEventListener('mouseup', function () {
                    isMouseMove = false;
                    setTimeout(() => { 
                        isLassoActive = false; 
                    }, 100); // Beri jeda sedikit untuk menghindari konflik
                });

                // 🔹 Klik di luar task akan menghapus selection, tapi tidak jika lasso sedang aktif
                document.addEventListener('click', function (event) {
                    if (!isLassoActive && !event.target.closest('.card-task') && !event.target.closest('.selection-area')) {
                        document.querySelectorAll('.sortable-selected').forEach(item => {
                            item.classList.remove('sortable-selected'); // Hapus class selected
                        });

                        //console.log("🔥 Semua task ter-deselect");
                    }
                });





                function resetSelection() {
                    //console.log("🔄 Resetting selection...");

                    // 🔥 Paksa hapus class 'sortable-selected' dari semua task
                    document.querySelectorAll('.sortable-selected, .sortable-ghost').forEach(item => {
                        item.classList.remove('sortable-selected', 'sortable-ghost');
                    });

                    // 🔹 Hapus clone elemen dari Sortable.js jika ada
                    document.querySelectorAll('.sortable-fallback').forEach(item => {
                        item.remove();
                    });

                    // 🔹 Kosongkan draggedItems agar tidak menyimpan task sebelumnya
                    window.draggedItems = [];

                    // 🔥 Paksa reset multi-drag di Sortable.js jika masih aktif
                    if (window.Sortable && window.Sortable.utils && typeof Sortable.utils.deselectMultiDrag === "function") {
                        Sortable.utils.deselectMultiDrag();
                        //console.log("✅ Multi-drag selection cleared from Sortable.js");
                    }

                    // 🔥 Paksa klik ke luar (di elemen no-status jika ada) agar seleksi hilang
                    setTimeout(() => {
                        const noStatusColumn = document.querySelector('.card-row.no-status');
                        if (noStatusColumn) {
                            noStatusColumn.click();
                            //console.log("✅ Clicked on no-status column to clear selection.");
                        } else {
                            document.body.click();
                            //console.log("✅ Clicked on body to clear selection.");
                        }
                    }, 10);

                    //console.log("✅ Selection fully reset, no lingering click states.");
                }









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
                        selection.disable();
                        selection.clearSelection();
                        isDragging = true; // Set isDragging to true saat mulai drag
                    },
                    onEnd: function (evt) {
                        isDragging = false; // Set kembali ke false saat drag selesai
                        showOverlay(); // Tampilkan overlay saat pengiriman data dimulai

                        setTimeout(() => {
                                selection.clearSelection();
                                document.dispatchEvent(new MouseEvent('mouseup'));
                                selection.disable();
                                selection.enable();
                            }, 50);

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
                    loadEverything();
                    //console.log("conditionalLoadKanban");
                }
            }

            // Load Kanban pertama kali
            loadKanban();
            

            // Reinitialize Kanban setiap 10 detik jika tidak sedang drag
            //setInterval(conditionalLoadKanban, 20000);



            function adjustStatusHeight() {
                let maxHeight = 0;

                // Cari status-body dengan tinggi terbesar
                $('.status-body').each(function () {
                    let thisHeight = $(this).height();
                    if (thisHeight > maxHeight) {
                        maxHeight = thisHeight;
                    }
                });

                // Terapkan tinggi maksimum ke semua status-body
                $('.status-body').css('min-height', maxHeight + 'px');
            }


























            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                // Summernote
                $('#detail_project_tamplate_type').summernote({
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
                        },
                        onInit: function () {
                            // Tunggu modal Summernote muncul
                            $(document).on('shown.bs.modal', '.note-modal', function () {
                                let modal = $(this);

                                // Pastikan tombol close (X) tetap ada, tapi ubah fungsinya
                                let closeButton = modal.find('.close');
                                closeButton.off('click').on('click', function (event) {
                                    event.stopPropagation(); // Mencegah modal utama tertutup
                                    modal.modal('hide'); // Hanya tutup modal Summernote
                                });

                                // Tambahkan tombol close baru di footer sebelah "Import Image"
                                let footer = modal.find('.modal-footer');
                                if (footer.find('.custom-close-btn').length === 0) {
                                    let closeFooterButton = $('<button type="button" class="btn btn-secondary custom-close-btn">Close</button>');
                                    closeFooterButton.on('click', function () {
                                        modal.modal('hide'); // Tutup modal Summernote
                                    });
                                    footer.append(closeFooterButton); // Tambahkan tombol ke footer modal
                                }
                            });
                        }
                    }
                });

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
                                    loadProjectSprint();
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
                    tags: false, // Enable tagging
                    placeholder: "Search or select an option",
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
                            </div>
                        `;
                        return optionTemplate;
                    }
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

            //var element2 = document.getElementById("filter");
            //element2.classList.add("collapsed-card");
            






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

            $('#modal-cancel-sprint').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recipient_c = button.data('c');

                var recipient_v = button.data('v');
                var recipient_i = button.data('i');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.id_dg_client_project_sprint').val(recipient_c);
                document.getElementById("id_dg_client_project_sprint").value = recipient_c;


                document.getElementById("sprint_name").innerHTML = recipient_v;
            })

            $('#modal-cancel-type').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recipient_c = button.data('c');
                var recipient_d = button.data('d');
                var recipient_v = button.data('v');

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.del_id_dg_client_project_type').val(recipient_c);
                document.getElementById("del_id_dg_client_project_type").value = recipient_c;

                modal.find('.type_id_dg_client_project_jenis_del').val(recipient_d);
                document.getElementById("type_id_dg_client_project_jenis_del").value = recipient_d;
                

                document.getElementById("type_name_del").innerHTML = recipient_v;
            })

            $('#modal-edit-type').on('click', function (event) {
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
                        popover: {
                            image: [
                            ['custom', ['downloadImage']], // Tambahkan section dan button baru
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                            ]
                        },
                        buttons: {
                            downloadImage: function (context) {
                            var ui = $.summernote.ui;

                            // Buat tombol baru
                            var button = ui.button({
                                contents: '<i class="fas fa-download"></i>',
                                tooltip: 'Download Image',
                                click: function () {
                                    let img = $(context.invoke('restoreTarget'));
                                    if (img && img.length && img[0].src) {
                                        fetch(img[0].src)
                                            .then(response => response.blob())
                                            .then(blob => {
                                                const url = window.URL.createObjectURL(blob);
                                                
                                                // Ambil nama dari input
                                                const taskName = $('#nama_task').val().trim() || 'image';
                                                const fileName = taskName.replace(/\s+/g, '_') + '.jpg'; // Ganti ekstensi kalau perlu

                                                const link = document.createElement('a');
                                                link.href = url;
                                                link.download = fileName;
                                                document.body.appendChild(link);
                                                link.click();
                                                document.body.removeChild(link);
                                                window.URL.revokeObjectURL(url);
                                            })
                                            .catch(() => {
                                                alert('Gagal mengunduh gambar.');
                                            });
                                    } else {
                                        alert('Gambar tidak ditemukan.');
                                    }
                                }


                            });

                            return button.render(); // return elemen tombol
                            }
                        },
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
                        saveTaskData("closed");
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
                            //console.log("depan = " + $('#summernote').val());
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
                    toastr.remove();

                    // CEK SIZE DULU
                    var maxSize = 1.5 * 1024 * 1024; // 1.5MB dalam bytes
                    if (file.size > maxSize) {
                        toastr.error('Ukuran file melebihi 1.5MB. Silakan pilih file yang lebih kecil.');
                        return;
                    }

                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('id_dg_client_project', '<?php echo $id_dg_client_project; ?>');

                    console.log("Uploading Image ...");

                    // Simpan settings asli
                    var originalToastrOptions = $.extend(true, {}, toastr.options);

                    // Set toastr khusus upload
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: false
                    };
                    
                    // Tampilkan awal toast upload
                    toastr.info('Uploading image... <span id="upload-progress-text">0%</span>');

                    var $toast = $('.toast').last(); // Toast yang baru dibuat

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'view/ajax/upload_image.php', true);

                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            if ($toast.length) {
                                $toast.find('.toast-progress').css('width', percent + '%');
                                $toast.find('#upload-progress-text').text(percent + '%');
                            }
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            // >>> Hapus dulu toast upload
                            if ($toast.length) $toast.remove();

                            // >>> Baru balikin toastr ke setting awal
                            toastr.options = originalToastrOptions;

                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    $('#summernote').summernote('insertImage', response.imageUrl);
                                    toastr.success('Image uploaded successfully!');
                                    $('#summernote').one('summernote.change', function() {
                                        var notes_project = encodeURIComponent($('#summernote').val());
                                        saveNotes("uploadImage");
                                    });
                                } else {
                                    toastr.error(response.message || 'Failed to upload image.');
                                }
                            } else {
                                toastr.error('Error during upload. Server responded with status ' + xhr.status);
                            }
                        }
                    };

                    xhr.send(formData);
                }




                // Fungsi untuk upload gambar dengan progress bar di toastr
                function uploadImageTask(file) {
                    toastr.remove();
                    
                    // CEK SIZE DULU
                    var maxSize = 1.5 * 1024 * 1024; // 1.5MB dalam bytes
                    if (file.size > maxSize) {
                        toastr.error('Ukuran file melebihi 1.5MB. Silakan pilih file yang lebih kecil.');
                        return; // STOP, tidak lanjut upload
                    }

                    var formData = new FormData();
                    var id_task = $('#id_task').val();
                    formData.append('file', file);
                    formData.append('id_task', id_task);

                    console.log("Uploading Image ...");

                    // Simpan settings asli
                    var originalToastrOptions = $.extend(true, {}, toastr.options);

                    // Set toastr khusus upload
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: false
                    };
                    
                    // Tampilkan awal toast upload
                    toastr.info('Uploading image... <span id="upload-progress-text">0%</span>');

                    var $toast = $('.toast').last(); // Toast yang baru dibuat

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'view/ajax/upload_image_task.php', true);

                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            if ($toast.length) {
                                $toast.find('.toast-progress').css('width', percent + '%');
                                $toast.find('#upload-progress-text').text(percent + '%');
                            }
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            // Toast upload loading dihapus dulu, biar gak stuck
                            if ($toast.length) $toast.remove();

                            // Balikin toastr setting normal
                            toastr.options = originalToastrOptions;

                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    $('#detail_project').summernote('insertImage', response.imageUrl);
                                    toastr.success('Image uploaded successfully!');
                                    $('#detail_project').one('summernote.change', function() {
                                        var notes_project_task = encodeURIComponent($('#detail_project').val());
                                        saveNotes("uploadImage");
                                    });
                                } else {
                                    toastr.error(response.message || 'Failed to upload image.');
                                }
                            } else {
                                toastr.error('Error during upload. Server responded with status ' + xhr.status);
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
                    toastr.remove();
                    // CEK SIZE DULU
                    var maxSize = 50 * 1024 * 1024; // 50MB dalam bytes
                    if (file.size > maxSize) {
                        toastr.error('Ukuran video melebihi 50MB. Silakan pilih file yang lebih kecil.');
                        return;
                    }

                    $('#modal-video-upload').modal('hide');


                    var formData = new FormData();
                    var id_task = $('#id_task').val(); 
                    formData.append('file', file);
                    formData.append('type', type);
                    formData.append('id_task', id_task);
                    formData.append('id_dg_client_project', '<?php echo $id_dg_client_project; ?>');

                    console.log("Uploading Video ...");

                    // Simpan settings asli
                    var originalToastrOptions = $.extend(true, {}, toastr.options);

                    // Set toastr khusus upload
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0,
                        extendedTimeOut: 0,
                        tapToDismiss: false
                    };

                    // Tampilkan awal toast upload
                    toastr.info('Uploading video... <span id="upload-progress-text">0%</span>');

                    var $toast = $('.toast').last(); // Toast yang baru dibuat

                    var xhr = new XMLHttpRequest();
                    
                    if (!id_task) {
                        xhr.open('POST', 'view/ajax/upload_media.php', true);
                    } else {
                        xhr.open('POST', 'view/ajax/upload_media_task.php', true);
                    }

                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            if ($toast.length) {
                                $toast.find('.toast-progress').css('width', percent + '%');
                                $toast.find('#upload-progress-text').text(percent + '%');
                            }
                        }
                    });

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            // >>> Hapus toast upload dulu
                            if ($toast.length) $toast.remove();

                            // >>> Baru balikin toastr ke setting normal
                            toastr.options = originalToastrOptions;

                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    var videoUrl = response.videoUrl;

                                    // Membuat elemen video
                                    var videoCode = `<br><video height="210" controls src="${videoUrl}"></video><br><br>`;
                                    
                                    insertContentAtCursor(videoCode);

                                    toastr.success('Video uploaded successfully!');

                                    if (!id_task) {
                                        saveNotes("uploadVideo"); 
                                    } else {
                                        saveTaskData("uploadVideo");
                                    }

                                    // Tutup modal dan reset input
                                    $('#modal-video-upload').modal('hide');
                                    $('#modal-video-upload').find('input[type="file"]').val('');
                                    $('#modal-video-upload').find('textarea').val('');

                                    // Fokus kembali ke Summernote / Detail
                                    setTimeout(function() {
                                        if (!id_task) {
                                            checkForUpdates();
                                            $('#summernote').focus();
                                        } else {
                                            $('#detail_project').focus();
                                        }
                                    }, 500);

                                } else {
                                    toastr.error(response.message || 'Failed to upload video.');
                                }
                            } else {
                                toastr.error('Error during upload. Server responded with status ' + xhr.status);
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
                                        //console.log("Video is playing, AJAX refresh stopped.");
                                    });

                                    videoElement.addEventListener('pause', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        //console.log("Video is paused, AJAX refresh resumed.");
                                    });

                                    videoElement.addEventListener('ended', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        //console.log("Video ended, AJAX refresh resumed.");
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
                                        //console.log("Video is playing, AJAX refresh stopped.");
                                    });

                                    videoElement.addEventListener('pause', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        //console.log("Video is paused, AJAX refresh resumed.");
                                    });

                                    videoElement.addEventListener('ended', function () {
                                        isVideoPlaying = false;
                                        startAjaxRefresh();
                                        //console.log("Video ended, AJAX refresh resumed.");
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
                                //console.log(factor);
                                //console.log(document.getElementById("summernote").value);
                                //console.log(notes_project);
                                //console.log(response);
                                //console.log("Notes saved successfully.");
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
                                        let latestNotes = decodeURIComponent(jsonResponse.notes_project);
                                        var currentNotes = $('#summernote').summernote('code');

                                        if (latestNotes !== currentNotes) {
                                            // Replace path sesuai keinginan
                                            latestNotes = latestNotes
                                                .replaceAll('view/ajax/uploads/images/task/', 'storage/task/img/')
                                                .replaceAll('view/ajax/uploads/videos/task/', 'storage/task/video/')
                                                .replaceAll('img/ai_images/', 'storage/ai/img/');
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
                                    let latestNotes = decodeURIComponent(jsonResponse.notes_project);
                                    if (latestNotes !== 'null') {
                                        // Replace path sesuai keinginan
                                        latestNotes = latestNotes
                                                .replaceAll('view/ajax/uploads/images/task/', 'storage/task/img/')
                                                .replaceAll('view/ajax/uploads/videos/task/', 'storage/task/video/')
                                                .replaceAll('img/ai_images/', 'storage/ai/img/');
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
















 

                $(document).ready(function () {
                    const id_project = '<?php echo $id_dg_client_project; ?>';
                    const id_user = '<?php echo $id_user; ?>';


                    function formatDeadline(deadline) {
                        if (!deadline) return '-';

                        const today = new Date();
                        const deadlineDate = new Date(deadline);

                        // Normalisasi ke jam 00:00:00
                        today.setHours(0, 0, 0, 0);
                        deadlineDate.setHours(0, 0, 0, 0);

                        const options = {
                            weekday: 'long', // nama hari
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        };
                        const formattedDate = deadlineDate.toLocaleDateString('id-ID', options);

                        const oneDay = 24 * 60 * 60 * 1000;
                        const diffDays = Math.floor((deadlineDate - today) / oneDay);

                        let statusText = '';
                        let color = '';

                        if (diffDays > 0) {
                            statusText = ` (Sisa ${diffDays} hari)`;
                        } else if (diffDays === 0) {
                            statusText = ` (Hari ini)`;
                        } else {
                            statusText = ` (Lewat ${Math.abs(diffDays)} hari)`;
                            color = 'red';
                        }

                        return `<span style="color:${color}">${formattedDate}<br>${statusText}</span>`;
                    }




                    $('#select_group_table').select2({
                        placeholder: "Select Group By",
                        allowClear: true,
                        width: '100%'
                    });

                    function formatTaskRow(task, statusGroup) {
                        const displayUsers = task._singleUser || task.users;

                        const userImages = task.users ? task.users.map(user => `
                                    <img class="img-circle info-img" src="img/profile/${user.photo || 't0.jpg'}" alt="${user.nama}" title="${user.nama}" style="width:30px; height:30px; object-fit:cover; margin-right: 10px;">${user.nama}<br>
                                `).join('') : 'Not Assigned';

                        return {
                            deadline_status: formatDeadline(task.deadline_status),
                            id_task: task.id_dg_client_project_task,
                            task_name: task.nama_task,
                            sprint: task.nama_sprint || '-',
                            type: task.nama_type || '-',
                            status: statusGroup.nama_status || 'No Status',
                            assigned: `<div class="info-users">${userImages}</div>`,
                            priority: (function () {
                                if (task.priority == 1) {
                                    return `<span style="color:red; font-weight:bold;"><i class="fas fa-fire"></i> Urgent</span>`;
                                } else if (task.priority == 2) {
                                    return `<span style="color:#FFA500; font-weight:bold;"><i class="fas fa-minus-circle"></i> Standard</span>`;
                                } else {
                                    return `<span style="color:#666E79;"><i class="fas fa-question-circle"></i> Not Set</span>`;
                                }
                            })(),
                            _groupUser: task._groupUser || '' // ← Tambahkan baris ini
                        };
                    }


                            // Inisialisasi pertama tanpa grup
                            initTeamSpaceTaskTable(null);

                            $('#select_group_table').on('change', function () {
                                const groupVal = $(this).val();
                                let groupColumn = null;

                                switch (groupVal) {
                                    case '1': // User
                                        groupColumn = 0; // index kolom _groupUser!
                                        break;
                                    case '2': // Status
                                        groupColumn = 5;
                                        break;
                                    case '3': // Sprint
                                        groupColumn = 3;
                                        break;
                                    case '4': // Type
                                        groupColumn = 4;
                                        break;
                                }


                                initTeamSpaceTaskTable(groupColumn);


                            });
                    
                            function initTeamSpaceTaskTable(groupColumnIndex = null) {
                                // Destroy existing instance if any
                                if ($.fn.DataTable.isDataTable('#teamSpaceTaskTable')) {
                                    $('#teamSpaceTaskTable').DataTable().destroy();
                                }

                                const table = $('#teamSpaceTaskTable').DataTable({
                                    dom: '<"row mb-2"<"col-sm-6"l>>' + // Baris pertama: Show entries
                                        '<"row mb-2 align-items-center"<"col-sm-6"B><"col-sm-6 text-end"f>>' + // Baris kedua: Button kiri, search kanan
                                        'rt' + // Tabel
                                        '<"row mt-2"<"col-sm-6"i><"col-sm-6"p>>', // Info dan pagination
                                    buttons: [
                                        'copy',
                                        'csv',
                                        'excel',
                                        'pdf',
                                        'print',
                                        {
                                            text: '<i class="fas fa-plus"></i> Add Task',
                                            className: 'btn btn-sm btn-primary me-2',
                                            titleAttr: 'Add Task'
                                        }
                                    ],
                                    ajax: {
                                        url: 'view/ajax/fetch_kanban.php',
                                        type: 'GET',
                                        data: {
                                            id_project: id_project,
                                            id_user: id_user
                                        },
                                        dataSrc: function (json) {
                                            let rows = [];
                                            const groupBy = $('#select_group_table').val();

                                            json.forEach(statusGroup => {
                                                statusGroup.tasks.forEach(task => {
                                                    if (groupBy == 1 && task.users && task.users.length > 0) {
                                                        task.users.forEach(user => {
                                                            const clonedTask = Object.assign({}, task);
                                                            clonedTask._groupUser = user.nama;
                                                            clonedTask._singleUser = [user]; // opsional, kalau mau ditampilkan di kolom
                                                            rows.push(formatTaskRow(clonedTask, statusGroup));
                                                        });
                                                    } else {
                                                        // tambahkan _groupUser kosong agar DataTables tidak error
                                                        task._groupUser = '';
                                                        rows.push(formatTaskRow(task, statusGroup));
                                                    }
                                                });
                                            });

                                            return rows;
                                        }


                                    },
                                    columns: [
                                        { data: '_groupUser', visible: false }, // index 0, dipakai untuk group
                                        { data: 'deadline_status' },
                                        { data: 'task_name' },
                                        { data: 'sprint' },
                                        { data: 'type' },
                                        { data: 'status' },
                                        {
                                            data: '_singleUser',
                                            render: function (data, type, row) {
                                                return data && data.length ? data[0].nama : row.assigned;
                                            }
                                        },
                                        { data: 'priority' }
                                    ],


                                    columnDefs: [
                                        ...(groupColumnIndex !== null ? [{
                                            targets: groupColumnIndex,
                                            visible: false,
                                            orderSequence: ['asc', 'desc', ''] // tambahkan di sini
                                        }] : []),
                                        {
                                            targets: '_all',
                                            orderSequence: ['asc', 'desc', ''] // biar kolom lain juga bisa 3 mode
                                        }
                                    ],

                                    order: groupColumnIndex !== null ? [[groupColumnIndex, 'asc']] : [],
                                    displayLength: 25,
                                    drawCallback: function (settings) {
                                        if (groupColumnIndex === null) return;

                                        const api = this.api();
                                        const rows = api.rows({ page: 'current' }).nodes();
                                        let last = null;

                                        api.column(groupColumnIndex, { page: 'current' })
                                            .data()
                                            .each(function (group, i) {
                                                if (last !== group) {
                                                    $(rows)
                                                        .eq(i)
                                                        .before(
                                                            '<tr class="group"><td colspan="8"><strong>' +
                                                                group +
                                                                '</strong></td></tr>'
                                                        );
                                                    last = group;
                                                }
                                            });
                                    }

                                });

                                let sortState = {}; // Menyimpan status sort per kolom

                                $('#teamSpaceTaskTable thead').on('click', 'th', function () {
                                    const table = $('#teamSpaceTaskTable').DataTable();
                                    const colIndex = table.column(this).index(); // Gunakan index dari DataTables

                                    const currentState = sortState[colIndex] || 'none';

                                    let newOrder = [];
                                    let newState = 'asc';

                                    if (currentState === 'none') {
                                        newOrder = [[colIndex, 'asc']];
                                        newState = 'asc';
                                        table.order(newOrder).draw();
                                    } else if (currentState === 'asc') {
                                        newOrder = [[colIndex, 'desc']];
                                        newState = 'desc';
                                        table.order(newOrder).draw();
                                    } else if (currentState === 'desc') {
                                        // Klik ke-3: reset sorting dan reload dari server
                                        initTeamSpaceTaskTable(groupColumnIndex);
                                        newState = 'none';
                                        //console.log('Reset sorting and reload from server');
                                    }

                                    // Reset semua state kecuali kolom aktif
                                    sortState = {};
                                    sortState[colIndex] = newState;
                                });





                                
                                
                            }

                         








                        let isRowClickable = true; // Flag klik baris

                        $('#teamSpaceTaskTable tbody').on('click', 'tr', function () {
                            if (!isRowClickable) return;

                            const table = $('#teamSpaceTaskTable').DataTable();
                            const data = table.row(this).data();

                            if (data && data.id_task) {
                                isRowClickable = false; // Disable klik baris

                                viewTaskDetail(data.id_task).always(() => {
                                    setTimeout(() => {
                                        isRowClickable = true; // Aktifkan kembali setelah 0.5 detik
                                    }, 500);
                                });
                            }
                        });


                        // var currentOrder = table.order()[0];
                        // if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                        //     table.order([groupColumn, 'desc']).draw();
                        // }
                        // else {
                        //     table.order([groupColumn, 'asc']).draw();
                        // }





                    



                });


                function refreshTeamSpaceTaskTable() {
                    const tableElement = $('#teamSpaceTaskTable');
                    if (tableElement.length && $.fn.DataTable.isDataTable(tableElement)) {
                        const table = tableElement.DataTable();
                        table.ajax.reload(null, false);
                    } else {
                        console.warn('teamSpaceTaskTable belum diinisialisasi atau belum tersedia di DOM');
                    }
                }





                initialDataLoaded = false;

                function viewTaskDetail(id) {

                    const taskId = id;

                    // Tampilkan modal dan overlay
                    $('#addTaskModal').modal('show');
                    $('#addTaskModal .loading-overlay').show();
                    $('#modal-video-upload').addClass('summernote-modal');

                    // Tampilkan loader di modal
                    $('#addTaskModal .loading-overlay').show();
                    get_statuses_with_deadline();
                    
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
                            $('#addTaskModal .loading-overlay').hide();
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
                            $('#addTaskModal .loading-overlay').hide();
                            toastr.error(`Failed to load task details: ${xhr.responseText || error}`);
                        });
                    }

                    return loadDropdowns()
                    .then(() => loadTaskDetails(taskId))
                    .always(() => {
                        $('#addTaskModal .loading-overlay').hide();
                    });

                   
                }

                // Helper: Tentukan apakah background terang atau gelap
                function getContrastTextColor(hexColor) {
                    // Hilangkan "#" jika ada
                    hexColor = hexColor.replace('#', '');

                    // Pecah ke RGB
                    const r = parseInt(hexColor.substr(0, 2), 16);
                    const g = parseInt(hexColor.substr(2, 2), 16);
                    const b = parseInt(hexColor.substr(4, 2), 16);

                    // Konversi ke nilai luminance W3C
                    const a = [r, g, b].map((v) => {
                        v /= 255;
                        return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
                    });

                    const luminance = 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];

                    // Ambang batas 0.5 (luminance rendah → teks putih, tinggi → teks hitam)
                    return luminance > 0.5 ? '#000000' : '#ffffff';
                }


                let varCalendar = 0;
                let activeDate = new Date();

                function loadCalendar() {
                    document.getElementById('calendarLoadingOverlay').style.display = 'flex'; // Show loading

                    const calendarEl = document.getElementById('taskCalendar');

                    // Jika kalender sudah pernah dibuat, simpan bulan aktif saat ini
                    if (varCalendar && typeof varCalendar.getDate === 'function') {
                        activeDate = varCalendar.getDate(); // simpan tanggal aktif saat ini
                    }



                    const Calendar = FullCalendar.Calendar;
                    
                    

                    function setCalendar() {
                        

                        function getCurrentTimeForScroll() {
                            const now = new Date();
                            return now.getHours().toString().padStart(2, '0') + ':' +
                                now.getMinutes().toString().padStart(2, '0') + ':00';
                        }

                        $.ajax({
                            url: 'view/ajax/fetch_kanban.php',
                            method: 'GET',
                            data: {
                                id_project: '<?php echo $id_dg_client_project; ?>',
                                id_user: '<?php echo $id_user; ?>'
                            },
                            dataType: 'json',
                            success: function(response) {
                                const events = [];

                                // Ambil data calendar dari elemen terakhir
                                const calendarData = response.length > 0 ? response[response.length - 1].task_calendar_data : [];

                                const groupedTasks = {};

                                // Step 1: Kelompokkan berdasarkan ID task
                                calendarData.forEach(item => {
                                    const taskId = item.id_task;

                                    //console.log("item: "+item.nama_sprint);

                                    if (!groupedTasks[taskId]) {
                                        groupedTasks[taskId] = {
                                            nama_task: item.nama_task,
                                            nama_sprint: item.nama_sprint || '-',
                                            nama_status: item.nama_status_now || '-',
                                            deadline_status_now: item.deadline_status_now || '-',
                                            warna_status: item.warna_status || '#007bff',
                                            timelineMap: new Map()
                                        };
                                    }

                                    if (item.deadline_status) {
                                        const key = `${item.deadline_status}_${item.nama_status}`;
                                        groupedTasks[taskId].timelineMap.set(key, {
                                            status: item.nama_status,
                                            assigned_users: item.assigned_users,
                                            warna_status: item.warna_status || '#007bff',
                                            deadline: new Date(item.deadline_status)
                                        });
                                    }
                                });

                                // Step 2: Buat event per transisi status
                                Object.entries(groupedTasks).forEach(([taskId, taskData]) => {
                                    const sortedTimeline = Array.from(taskData.timelineMap.values())
                                        .sort((a, b) => a.deadline - b.deadline);

                                    for (let i = 0; i < sortedTimeline.length - 1; i++) {
                                        const current = sortedTimeline[i];
                                        const next = sortedTimeline[i + 1];
                                        
                                        const userImagesHtml = (current.assigned_users || []).map(user => 
                                            `<img src="img/profile/${user.photo}" title="${user.nama}" style="width:30px;height:30px;border-radius:50%;margin-right:2px;object-fit:cover;">`
                                        ).join('');

                                        const nextUserImagesHtml = (next.assigned_users || []).map(user => 
                                            `<img src="img/profile/${user.photo}" title="${user.nama}" style="width:30px;height:30px;border-radius:50%;margin-right:2px;object-fit:cover;">`
                                        ).join('');

                                        const warnaStatus = (next.assigned_users || []).map(user => {
                                            const warna = user.warna_status || '';
                                            const match = warna.match(/#[0-9a-fA-F]{3,6}/); // Ambil HEX pertama
                                            return match ? match[0] : '';
                                        })[0] || ''; // Ambil warna pertama dari hasil array


                                        // Skip jika tanggal deadline-nya sama
                                        if (current.deadline.getTime() === next.deadline.getTime() && current.status === next.status) {
                                            continue;
                                        }

                                        const endDate = new Date(next.deadline);
                                        endDate.setDate(endDate.getDate() + 1);

                                        events.push({
                                            title: `
                                            <div style="padding: 4px 6px;">
                                                <div style="margin-bottom: 6px; font-size: 15px;"><strong>${taskData.nama_task}</strong></div>
                                                <div style="margin-bottom: 4px;">Status : ${taskData.nama_status} <b style="margin-left:15px;"></b>Sprint: ${taskData.nama_sprint}</div>
                                                <div style="margin-bottom: 4px;">
                                                    Timeline from <strong>${current.status}</strong> to <strong>${next.status}</strong>
                                                </div>
                                                
                                                <div style="margin-bottom: 4px;">From: ${userImagesHtml} Assigned to: ${nextUserImagesHtml}</div>
                                            </div>
                                            `,
                                            start: current.deadline.toISOString().split('T')[0],
                                            end: endDate.toISOString().split('T')[0],
                                            backgroundColor: "#ffffff",
                                            borderColor: warnaStatus,
                                            textColor: "#000000",
                                            extendedProps: {
                                                id_task: taskId
                                            }
                                        });
                                    }

                                    // Jika hanya satu status dan deadline
                                    if (sortedTimeline.length === 1) {
                                        const single = sortedTimeline[0];
                                        const endDate = new Date(single.deadline);
                                        endDate.setDate(endDate.getDate() + 1);
                                        
                                        const userImagesHtml = (single.assigned_users || []).map(user => 
                                            `<img src="img/profile/${user.photo}" title="${user.nama}" style="width:30px;height:30px;border-radius:50%;margin-right:2px;object-fit:cover;">`
                                        ).join('');

                                        events.push({
                                            title: `
                                            <div style="padding: 4px 6px;">
                                                <div style="margin-bottom: 6px; font-size: 15px;"><strong>${taskData.nama_task}</strong></div>
                                                <div style="margin-bottom: 4px;">Status : ${taskData.nama_status}</div>
                                                <div style="margin-bottom: 4px;">Sprint: ${taskData.nama_sprint}</div>
                                                <div style="margin-bottom: 4px;">
                                                    Timeline from <strong>${single.status}</strong>
                                                </div>
                                                
                                                <div style="margin-bottom: 4px;">Assigned to: ${userImagesHtml}</div>
                                            </div>`,
                                            start: single.deadline.toISOString().split('T')[0],
                                            end: endDate.toISOString().split('T')[0],
                                            backgroundColor: "#ffffff",
                                            borderColor: taskData.warna_status,
                                            textColor: "#000000",
                                            extendedProps: {
                                                id_task: taskId
                                            }
                                        });
                                    }
                                });

                                // Hapus isi sebelumnya
                                calendarEl.innerHTML = "";

                                const calendar = new Calendar(calendarEl, {
                                    initialView: 'dayGridMonth',
                                    initialDate: activeDate, 
                                    headerToolbar: {
                                        left: 'prev,next,today',
                                        center: 'title',
                                        right: 'addTaskButton'
                                    },
                                    customButtons: {
                                        addTaskButton: {
                                            text: ' ',
                                            icon: 'plus'
                                        }
                                    },
                                    eventDidMount: function(info) {
                                        // Hapus konten default
                                        info.el.innerHTML = `
                                            <div class="fc-custom-card" style="overflow: auto;">
                                                <div class="fc-custom-title">${info.event.title}</div>
                                            </div>
                                        `;

                                        // Tambahkan styling card dengan border top
                                        const warna = info.event.borderColor || '#000';
                                        info.el.style.backgroundColor = '#ffffff';
                                        info.el.style.border = 'none';
                                        info.el.style.padding = '4px 6px';
                                        info.el.style.borderTop = `4px solid ${warna}`;
                                        info.el.style.borderRadius = '4px';
                                        info.el.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                                        info.el.style.color = '#000';
                                        info.el.style.fontSize = '12px';
                                        info.el.style.lineHeight = '1.4';
                                    },

                                    themeSystem: 'bootstrap',
                                    editable: false,
                                    droppable: false,
                                    scrollTime: getCurrentTimeForScroll(),
                                    events: events,
                                    eventClick: function(info) {
                                        const taskId = info.event.extendedProps.id_task;
                                        if (taskId) {
                                            editTask(taskId);
                                        }
                                    },
                                    windowResize: function(view) {
                                        if (window.innerWidth < 768) {
                                            calendar.changeView('timeGridWeek');
                                            calendar.setOption('scrollTime', getCurrentTimeForScroll());
                                        }
                                    }
                                });


                                calendar.render();
                                varCalendar = calendar;
                                calendarEl.style.transition = 'opacity 0.5s ease-in-out';
                                calendarEl.style.opacity = 1;
                                document.getElementById('calendarLoadingOverlay').style.display = 'none'; // Hide loading

                                // Pastikan tombol Add Task sudah dirender sebelum kamu ubah
                                setTimeout(() => {
                                    const addBtn = document.querySelector('.fc-addTaskButton-button');
                                    if (addBtn) {
                                        addBtn.className = 'btn btn-primary'; // override default class
                                        addBtn.innerHTML = '<i class="fas fa-plus"></i>'; // ganti isi dengan ikon
                                        addBtn.setAttribute('title', 'Add Task'); // set title
                                    }
                                }, 0); // 0 ms, cukup untuk tunggu DOM render cycle

                            },
                            error: function(xhr, status, error) {
                                console.error("Gagal memuat data kalender:", error);
                                document.getElementById('calendarLoadingOverlay').style.display = 'none'; // Hide loading

                            }
                            
                        });
                       
                    }

                    if (varCalendar==0) {
                        calendarEl.style.opacity = 0;
                        setTimeout(() => {
                            varCalendar = 1;
                            setCalendar();
                        }, 200);
                    }else{
                        setCalendar();
                    }
                    
                }

            // Trigger saat tab calendar diklik
            document.querySelector('#calendar-view-tab').addEventListener('click', function () {
                setTimeout(function () {
                    loadCalendar();
                }, 200);
            });





        // Buka tab terakhir saat halaman dimuat
        const lastTab = localStorage.getItem('lastActiveTab');
        if (lastTab) {
            loadCalendar();
            loadGalleryView();
            $(`a[href="${lastTab}"]`).tab('show');
        }


        // Simpan tab terakhir yang diklik
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            const target = $(e.target).attr("href"); // contoh: "#board-view"
            localStorage.setItem('lastActiveTab', target);
        });

            
            
        </script>

</body>

</html>