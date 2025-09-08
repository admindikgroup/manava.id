<?php include 'view/common/first_validation.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Ticket | DG Group</title>

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
        .dtr-data{
            white-space: pre;
            display: block;
        }

        .dtr-data .btn{
            white-space: initial;
        }

        table.dataTable>thead .sorting:after, table.dataTable>thead .sorting:before{
            content: "";
        }
        .xx:before{
            display: none !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus ticket ini ?<br>
                        ID Ticket &nbsp; :<b id="textCode"></b><br>
                        Ticket Name &nbsp; :<b id="textName"></b></p>
                </div>
                <form action="controller/conn_delete_ticket.php" method="post">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task4" id="id_task4" value="">
                        <input type="hidden" name="type4" id="type4" value="">
                        <input type="hidden" name="task_link" value="ticket">

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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit - Group Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="controller/conn_edit_ticket.php" method="post">
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="nameTask3" class="col-sm-3 col-form-label">Task Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameTask3" name="nameTask3"
                                    placeholder="Masukan Nama Task" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskTask3" class="col-sm-3 col-form-label">Deskripsi Task</label>
                            <div class="col-sm-9">
                                <textarea rows="5" type="text" class="form-control" id="deskTask3" name="deskTask3"
                                    placeholder="Masukan detail penjelasan deskTask3"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reservationdate3" class="col-sm-3 col-form-label">Deadline</label>
                            <div class="input-group date col-sm-9" id="reservationdate3" data-target-input="nearest"
                                required>
                                <input type="text" name="deadline3" class="form-control datetimepicker-input deadline3"
                                    data-target="#reservationdate3" value="" required>
                                <div class="input-group-append" data-target="#reservationdate3"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                      
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task3" id="id_task3" value="">
                        <input type="hidden" name="type" value="head">
                        <input type="hidden" name="task_link" value="ticket">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-edit-account">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Edit - Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="controller/conn_edit_ticket.php" method="post">
                    <div class="modal-body">



                        <div class="form-group row">
                            <label for="nameTask2" class="col-sm-3 col-form-label">Task Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameTask2" name="nameTask2"
                                    placeholder="Masukan Nama Task" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskTask2" class="col-sm-3 col-form-label">Deskripsi Task</label>
                            <div class="col-sm-9">
                                <textarea rows="5" type="text" class="form-control" id="deskTask2" name="deskTask2"
                                    placeholder="Masukan detail penjelasan task"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reservationdate2" class="col-sm-3 col-form-label">Deadline</label>
                            <div class="input-group date col-sm-9" id="reservationdate2" data-target-input="nearest"
                                required>
                                <input type="text" name="deadline2" class="form-control datetimepicker-input deadline2"
                                    data-target="#reservationdate2" value="" required>
                                <div class="input-group-append" data-target="#reservationdate2"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        
                            <div class="form-group row">
                                <label for="support2" class="col-sm-3 col-form-label">Support</label>
                                <div class="col-sm-9">
                                    <select class="form-control select support2" style="width: 100%;" name="support2">
                                        
                                        <?php 
                                        $no = 1;
                                        $result_headt = mysqli_query($db2,"select * from `dg_user`");
                                        while($d_headt = mysqli_fetch_array($result_headt)){
                                        ?>
                                        <option value="<?php echo $d_headt['id_dg_user']; ?>">
                                            <?php echo $d_headt['nama']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="groupTask2" class="col-sm-3 col-form-label">Task Group</label>
                                <div class="col-sm-9">
                                    <select class="form-control select groupTask2" style="width: 100%;" name="groupTask2">
                                        <?php 
                                        $no = 1;
                                        $result_headt = mysqli_query($db2,"select * from `dg_task`
                                        inner join dg_client on dg_task.id_client = dg_client.id_dg_client
                                        where dg_task.deleted_at is null and dg_client.deleted_at is null");
                                        while($d_headt = mysqli_fetch_array($result_headt)){
                                    ?>
                                        <option value="<?php echo $d_headt['id_dg_task']; ?>">
                                        <?php echo $d_headt['nama_client']; ?> | <?php echo $d_headt['nama_task']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status2" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control select status2" style="width: 100%;" name="status2">
                                        <option value="1">Stand By</option>
                                        <option value="2">On Going</option>
                                        <option value="3">Done</option>
                                        <option value="4">Problem</option>
                                        <option value="5">Canceled</option>
                                    </select>
                                </div>
                            </div>
                        
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task2" id="id_task2" value="">
                        <input type="hidden" name="type" value="detail">
                        <input type="hidden" name="task_link" value="ticket">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add - Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="controller/conn_add_ticket.php" method="post">
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="typeTicket" class="col-sm-3 col-form-label">Ticket Type</label>
                            <div class="col-sm-9">
                                <select class="form-control select" style="width: 100%;" name="typeTicket"
                                    id="selectid" required>
                                    <option value="1">Ticket Group</option>
                                    <option value="0" selected>Ticket Detail</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row none" id="client_task">
                            <label for="client" class="col-sm-3 col-form-label">Client</label>
                            <div class="col-sm-9">
                                <select class="form-control select" style="width: 100%;" name="client">
                                    
                                    <?php 
                                        $result_headt = mysqli_query($db2,"select * from `dg_client` where dg_client.deleted_at is null");
                                        while($d_headt = mysqli_fetch_array($result_headt)){
                                    ?>
                                    <option value="<?php echo $d_headt['id_dg_client']; ?>">
                                        <?php echo $d_headt['nama_client']; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nameTask" class="col-sm-3 col-form-label">Task Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameTask" name="nameTask"
                                    placeholder="Masukan Nama Task" value="" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskTask" class="col-sm-3 col-form-label">Deskripsi Task</label>
                            <div class="col-sm-9">
                                <textarea rows="5" type="text" class="form-control" id="deskTask" name="deskTask"
                                    placeholder="Masukan detail penjelasan task"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reservationdate" class="col-sm-3 col-form-label">Deadline</label>
                            <div class="input-group date col-sm-9" id="reservationdate" data-target-input="nearest"
                                required>
                                <input type="text" name="deadline" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" value="" required>
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div id="accountHead" class="none">
                            <div class="form-group row">
                                <label for="support" class="col-sm-3 col-form-label">Support</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" style="width: 100%;" name="support">
                                        
                                        <?php 
                                        $no = 1;
                                        $result_headt = mysqli_query($db2,"select * from `dg_user`");
                                        while($d_headt = mysqli_fetch_array($result_headt)){
                                    ?>
                                        <option value="<?php echo $d_headt['id_dg_user']; ?>">
                                            <?php echo $d_headt['nama']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="groupTask" class="col-sm-3 col-form-label">Task Group</label>
                                <div class="col-sm-9">
                                    <select class="form-control select" style="width: 100%;" name="groupTask">
                                        <?php 
                                        $no = 1;
                                        $result_headt = mysqli_query($db2,"select * from `dg_task`
                                        inner join dg_client on dg_task.id_client = dg_client.id_dg_client
                                        where dg_task.deleted_at is null and dg_client.deleted_at is null");
                                        while($d_headt = mysqli_fetch_array($result_headt)){
                                    ?>
                                        <option value="<?php echo $d_headt['id_dg_task']; ?>">
                                        <?php echo $d_headt['nama_client']; ?> | <?php echo $d_headt['nama_task']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_user" value="<?php echo $id_user;?>">
                        <input type="hidden" name="task_link" value="ticket">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">All Ticket
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Management</a></li>
                                <li class="breadcrumb-item active">Ticket</li>
                            </ol>
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
                                <div style="text-align: right;">
                                    <button class="btn btn-success float-sm-right" data-toggle="modal"
                                        data-target="#modal-add"
                                        style="right: 0px; width: 150px; margin-top: 10px; margin-right: 20px;">
                                        + Add Ticket
                                    </button>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Detail</th>
                                                <th>Id Task</th>
                                                <th>Task Name</th>
                                                <th class="none">Task Detail :</th>
                                                <th>Owner Task</th>
                                                <th>Deadline</th>
                                                <th>Sisa Hari</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            $result_client = mysqli_query($db2,"select * from `dg_client` 
                                            where deleted_at IS NULL ORDER BY created_at ASC");
                                            while($d_client= mysqli_fetch_array($result_client)){
                                                $id_client = $d_client['id_dg_client']; 
                                                $nama_client = $d_client['nama_client'];

                                                $result_acc0x = mysqli_query($db2,"SELECT * FROM `dg_client`
                                                inner JOIN dg_task ON dg_task.`id_client` = dg_client.`id_dg_client`
                                                WHERE dg_client.id_dg_client = $id_client and
                                                dg_client.deleted_at IS NULL ORDER BY dg_client.created_at ASC");
                                                $cek0x = mysqli_num_rows($result_acc0x);
                                                if ($cek0x!=0) {
                                                ?>
                                            <tr style="background: rgba(0,0,0,.15); font-size: 18px;">
                                                <td class="xx"></td>
                                                <td><b>Client :</b></td>
                                                <td style="text-transform: uppercase; "><b><?php echo $nama_client; ?></b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php 
                                                }
                                            $result_head = mysqli_query($db2,"select * from `dg_task` 
                                            inner join dg_user on dg_task.owner_task = dg_user.id_dg_user
                                            where dg_task.deleted_at is null and id_client=$id_client ORDER BY deadline ASC");
                                            while($d_head = mysqli_fetch_array($result_head)){

                                                 
                                                $id_header = $d_head['id_dg_task'];  
                                                $result_acc1 = mysqli_query($db2,"select * from `dg_task_detail` 
                                                inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
                                                where dg_task_detail.id_dg_task = $id_header AND status_detail = 3 and dg_task_detail.deleted_at is null"); 
                                                $result_acc2 = mysqli_query($db2,"select * from `dg_task_detail` 
                                                inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
                                                where dg_task_detail.id_dg_task = $id_header and dg_task_detail.deleted_at is null"); 
                                                $cek1 = mysqli_num_rows($result_acc1);
                                                $cek2 = mysqli_num_rows($result_acc2);
                                                if ($cek1==0) {
                                                    $hasil_cek = 0;
                                                }else{
                                                    $hasil_cek = $cek1*100/$cek2;
                                                }

                                            ?>
                                            <tr style="background: rgba(0,0,0,.05);">
                                                <td></td>
                                                <td><b>TH-<?php echo $d_head['id_dg_task']; ?>-<?php echo $d_head['owner_task']; ?></b></td>
                                                <td><b><?php echo $d_head['nama_task']; ?></b></td>
                                                <td><?php echo $d_head['deskripsi']; ?></td>
                                                <td><b><?php echo $d_head['nama']; ?></b></td>
                                                <td><b><?php echo date_format(date_create($d_head['deadline']),"d F Y"); ?></b></td>
                                                <td><b><?php 
                                                $tgl1 = new DateTime(date("Y-m-d"));
                                                $tgl2 = new DateTime($d_head['deadline']);
                                                $d = $tgl2->diff($tgl1)->days + 1;
                                                if($hasil_cek==100) {
                                                    echo "-";
                                                }else if ($tgl1 < $tgl2) {
                                                    echo $d." hari";
                                                }else{
                                                    echo "<b style='color: red;'>-".$d." hari</b>";
                                                }
                                                ?></b></td>
                                                <td><b><?php echo number_format($hasil_cek, 2, ',', '.'); ?>%</b></td>
                                                <td>
                                                    <div class="row">

                                                        <button class="btn btn-info btn-sm" name="id_ev"
                                                            data-a="<?php echo $d_head['id_dg_task']; ?>"
                                                            data-b="<?php echo $d_head['nama_task']; ?>"
                                                            data-c="<?php echo $d_head['deskripsi']; ?>"
                                                            data-d="<?php echo $d_head['deadline']; ?>"
                                                            
                                                            data-toggle="modal" data-target="#modal-edit-header">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-danger btn-sm"
                                                            data-a="TH-<?php echo $d_head['id_dg_task']; ?>-<?php echo $d_head['owner_task']; ?>"
                                                            data-b="<?php echo $d_head['nama_task']; ?>"
                                                            data-c="<?php echo $d_head['id_dg_task']; ?>" data-d="1"
                                                            data-toggle="modal" data-target="#modal-cancel">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php 
                                            $id_header = $d_head['id_dg_task'];  
                                            $result_acc = mysqli_query($db2,"select * from `dg_task_detail` 
                                            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
                                            where dg_task_detail.id_dg_task = $id_header and dg_task_detail.deleted_at is null ORDER BY deadline ASC"); 
                                            while($d_acc = mysqli_fetch_array($result_acc)){
                                            ?>
                                            <tr style="background: white;">
                                                <td></td>
                                                <td>TD-<?php echo $d_acc['id_dg_task']; ?><?php echo $d_acc['id_dg_task_detail']; ?>-<?php echo $d_acc['support']; ?></td>
                                                <td><?php echo $d_acc['nama_task_detail']; ?></td>
                                                <td><?php echo $d_acc['deskripsi_task_detail']; ?></td>
                                                <td><?php echo $d_acc['nama']; ?></td>
                                                <td><?php echo date_format(date_create($d_acc['deadline']),"d F Y"); ?></td>
                                                <td><?php 
                                                $tgl1 = new DateTime(date("Y-m-d"));
                                                $tgl2 = new DateTime($d_acc['deadline']);
                                                $d = $tgl2->diff($tgl1)->days + 1;
                                                if($d_acc['status_detail']==3 || $d_acc['status_detail']==5) {
                                                    echo "-";
                                                }else if ($tgl1 < $tgl2) {
                                                    echo $d." hari";
                                                }else{
                                                    echo "<b style='color: red;'>-".$d." hari</b>";
                                                }
                                                ?></td>
                                                <td
                                                style = "background: <?php 
                                                if ($d_acc['status_detail']==1) {
                                                   echo "#FFF3D9";
                                                }else if($d_acc['status_detail']==2) {
                                                    echo "#FFC55C";
                                                 }else if($d_acc['status_detail']==3) {
                                                    echo "#00EE00";
                                                 }else if($d_acc['status_detail']==4) {
                                                    echo "#DC4731";
                                                 }else if($d_acc['status_detail']==5) {
                                                    echo "#FFFFFF";
                                                 }
                                                
                                                ?>;"
                                                ><b><?php 
                                                if ($d_acc['status_detail']==1) {
                                                   echo "Stand By";
                                                }else if($d_acc['status_detail']==2) {
                                                    echo "On Going";
                                                 }else if($d_acc['status_detail']==3) {
                                                    echo "Done";
                                                 }else if($d_acc['status_detail']==4) {
                                                    echo "Problem";
                                                 }else if($d_acc['status_detail']==5) {
                                                    echo "Canceled";
                                                 }
                                                
                                                ?></b></td>
                                                <td>
                                                    <div class="row">

                                                        <button class="btn btn-info btn-sm" name="id_ev"
                                                            data-a="<?php echo $d_acc['id_dg_task_detail']; ?>"
                                                            data-b="<?php echo $d_acc['nama_task_detail']; ?>"
                                                            data-c="<?php echo $d_acc['deskripsi_task_detail']; ?>"
                                                            data-d="<?php echo $d_acc['support']; ?>"
                                                            data-e="<?php echo $d_acc['deadline']; ?>"
                                                            data-f="<?php echo $d_acc['status_detail']; ?>"
                                                            data-g="<?php echo $id_header; ?>"
                                                            data-toggle="modal" data-target="#modal-edit-account">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-danger btn-sm"
                                                            data-a="TD-<?php echo $d_acc['id_dg_task']; ?><?php echo $d_acc['id_dg_task_detail']; ?>-<?php echo $d_acc['support']; ?>"
                                                            data-b="<?php echo $d_acc['nama_task_detail']; ?>"
                                                            data-c="<?php echo $d_acc['id_dg_task_detail']; ?>" data-d="0"
                                                            data-toggle="modal" data-target="#modal-cancel">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }}} 
                                            $result_acc = mysqli_query($db2,"select * from `dg_task_detail` where id_dg_task = 0 limit 1"); 
                                            while($d_acc = mysqli_fetch_array($result_acc)){ ?>
                                            <tr style="background: black;">
                                                <td class="xx"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><b>Tidak Memiliki Group Task</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php }
                                            $id_header = 0;  
                                            $result_acc = mysqli_query($db2,"select * from `dg_task_detail`
                                            inner join dg_user on dg_task_detail.support = dg_user.id_dg_user
                                            where dg_task_detail.id_dg_task = $id_header and
                                            dg_task_detail.deleted_at is null ORDER BY id_dg_task_detail ASC"); 
                                            while($d_acc = mysqli_fetch_array($result_acc)){
                                            ?>
                                            <tr>
                                            <td></td>
                                            <td>TD-<?php echo $d_acc['id_dg_task']; ?><?php echo $d_acc['id_dg_task_detail']; ?>-<?php echo $d_acc['support']; ?></td>
                                                <td><?php echo $d_acc['nama_task_detail']; ?></td>
                                                <td><?php echo $d_acc['deskripsi_task_detail']; ?></td>
                                                <td><?php echo $d_acc['nama']; ?></td>
                                                <td><?php echo date_format(date_create($d_acc['deadline']),"d F Y"); ?></td>
                                                <td><?php 
                                                $tgl1 = new DateTime(date("Y-m-d"));
                                                $tgl2 = new DateTime($d_acc['deadline']);
                                                $d = $tgl2->diff($tgl1)->days + 1;
                                                if($d_acc['status_detail']==3  || $d_acc['status_detail']==5) {
                                                    echo "-";
                                                }else if ($tgl1 < $tgl2) {
                                                    echo $d." hari";
                                                }else{
                                                    echo "<b style='color: red;'>-".$d." hari</b>";
                                                }
                                                ?></td>
                                                <td
                                                style = "background: <?php 
                                                if ($d_acc['status_detail']==1) {
                                                   echo "#FFF3D9";
                                                }else if($d_acc['status_detail']==2) {
                                                    echo "#FFC55C";
                                                 }else if($d_acc['status_detail']==3) {
                                                    echo "#00EE00";
                                                 }else if($d_acc['status_detail']==4) {
                                                    echo "#DC4731";
                                                 }else if($d_acc['status_detail']==5) {
                                                    echo "#FFFFFF";
                                                 }
                                                
                                                ?>;"
                                                ><b><?php 
                                                if ($d_acc['status_detail']==1) {
                                                   echo "Stand By";
                                                }else if($d_acc['status_detail']==2) {
                                                    echo "On Going";
                                                 }else if($d_acc['status_detail']==3) {
                                                    echo "Done";
                                                 }else if($d_acc['status_detail']==4) {
                                                    echo "Problem";
                                                 }else if($d_acc['status_detail']==5) {
                                                    echo "Canceled";
                                                 }
                                                
                                                ?></b></td>
                                                <td>
                                                    <div class="row">

                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                            data-a="<?php echo $d_acc['id_dg_task_detail']; ?>"
                                                            data-b="<?php echo $d_acc['nama_task_detail']; ?>"
                                                            data-c="<?php echo $d_acc['deskripsi_task_detail']; ?>"
                                                            data-d="<?php echo $d_acc['support']; ?>"
                                                            data-e="<?php echo $d_acc['deadline']; ?>"
                                                            data-f="<?php echo $d_acc['status_detail']; ?>"
                                                            data-g="<?php echo $id_header; ?>"
                                                            data-toggle="modal" data-target="#modal-edit-account">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-danger btn-sm"
                                                            data-a="TD-<?php echo $d_acc['id_dg_task']; ?><?php echo $d_acc['id_dg_task_detail']; ?>-<?php echo $d_acc['support']; ?>"
                                                            data-b="<?php echo $d_acc['nama_task_detail']; ?>"
                                                            data-c="<?php echo $d_acc['id_dg_task_detail']; ?>" data-d="0"
                                                            data-toggle="modal" data-target="#modal-cancel">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            Delete
                                                        </button>
                                                    </div>
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
    </div>s
    <!-- ./wrapper -->
    <!-- jQuery -->
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
        $("#accountHead").removeClass("none");
        $("#selectid").on("change", function () {
            $("#accountHead").addClass("none");
            if (this.value == "0") {
                $("#accountHead").removeClass("none");
                $("#client_task").addClass("none");
            } else {
                $("#client_task").removeClass("none");
            }

        });
        $(function () {
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
            var recipient_a = button.data('a'); // Extract info from data-* attributes
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task4').val(recipient_c);
            modal.find('.textName').val(recipient_b);
            modal.find('.type4').val(recipient_d);

            document.getElementById("id_task4").value = recipient_c;
            document.getElementById("textCode").innerHTML = recipient_a;
            document.getElementById("textName").innerHTML = recipient_b;
            document.getElementById("type4").value = recipient_d;

        })

        $('#modal-edit-header').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var recipient_a = button.data('a'); // Extract info from data-* attributes
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');


            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task3').val(recipient_a);
            modal.find('.nameTask3').val(recipient_b);
            modal.find('.deskTask3').val(recipient_c);

            var dateX = new Date(recipient_d);
            const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
            dayX = dateX.getDate();
            monthX = monthNames[dateX.getMonth()];
            yearX = dateX.getFullYear();


            modal.find('.deadline3').val(dayX+'-'+monthX+'-'+yearX);


            document.getElementById("id_task3").value = recipient_a;
            document.getElementById("nameTask3").value = recipient_b;
            document.getElementById("deskTask3").innerHTML = recipient_c;
        })

        $('#modal-edit-account').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var recipient_a = button.data('a'); // Extract info from data-* attributes
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');
            var recipient_d = button.data('d');
            var recipient_e = button.data('e');
            var recipient_f = button.data('f');
            var recipient_g = button.data('g');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task2').val(recipient_a);
            modal.find('.nameTask2').val(recipient_b);
            modal.find('.deskTask2').val(recipient_c);
            modal.find('.support2').val(recipient_d);
            var dateX = new Date(recipient_e);
            const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];
            dayX = dateX.getDate();
            monthX = monthNames[dateX.getMonth()];
            yearX = dateX.getFullYear();


            modal.find('.deadline2').val(dayX+'-'+monthX+'-'+yearX);
            modal.find('.status2').val(recipient_f);
            modal.find('.groupTask2').val(recipient_g);

            document.getElementById("id_task2").value = recipient_a;
            document.getElementById("nameTask2").value = recipient_b;
            document.getElementById("deskTask2").innerHTML = recipient_c;

            
            
            
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
                format: 'DD-MMMM-yyyy',
                minDate: new Date()
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
                format: 'DD-MMMM-yyyy',
                minDate: new Date()
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
                format: 'DD-MMMM-yyyy',
                minDate: new Date()
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




            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'DD/MM/YYYY'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()


        })

        $(document).ready(function() {

            $('#dtr-details').each(function(e) {
                $( "<br />" ).insertAfter( 'span' );
            });
            
            
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        
        });
    </script>
</body>

</html>