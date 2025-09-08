<?php 
// mengaktifkan session
session_start();
include '../../controller/conn.php';
$id_dg_client_project = $_GET['id_dg_project'];
$total_harga_modal2 = 0;
?>                    

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Break Down Memo</h5>
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                                data-target="#modal-add-breakdown-memo" data-backdrop="static" data-keyboard="false"
                                                style="margin-left: auto; width: 150px;">
                                                + Add Memo
                                        </button>                                    
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table_breakdown" class="table table-bordered table-striped" style="font-size: 15px;">
                                        <thead>
                                            <tr>
                                                
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Komponen</th>
                                                <th>Harga Modal</th>
                                                <th>Harga Jual</th>
                                                <th>Discount</th>
                                                <th>Keuntungan</th>
                                                <th>Status</th>
                                                
                                                <th style="width: 10%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no_temp = 0;
                                            $result_head = mysqli_query($db2,"select * from `dg_client_project_breakdown` where id_dg_client_project = $id_dg_client_project
                                            and (status_breakdown is not null AND status_breakdown != 0)");
                                            while($d_head = mysqli_fetch_array($result_head)){
                                               
                                                $id_dg_client_project_breakdown = $d_head['id_dg_client_project_breakdown'];
                                                $id_user = $d_head['id_dg_user'];
                                                $id_dg_job = $d_head['id_dg_user_job'];
                                                $nama_job = "";
                                                $nama_user = "";
                                                
                                                $result_user = mysqli_query($db2,"select * from `dg_user` where id_dg_user = $id_user");
                                                while($d_user = mysqli_fetch_array($result_user)){
                                                    $nama_user = $d_user['nama'];
                                                    $deleted_at = $d_user['deleted_at'];
                                                    if ($deleted_at!=null) {
                                                        $nama_user = $nama_user . " (DELETED) ";
                                                    }
                                                } 
                                                
                                                $result_job = mysqli_query($db2,"select * from `dg_job` where id_dg_job = $id_dg_job");
                                                while($d_job = mysqli_fetch_array($result_job)){
                                                    $nama_job = $d_job['job_name'];
                                                } 
                                                $keuntungan = $d_head['harga_jual']-$d_head['harga_modal']-$d_head['discount'];
                                                $no_temp++;
                                                
                                                if ($d_head['harga_jual'] == 0) {
                                                    // Menangani kasus di mana harga_jual adalah nol untuk mencegah pembagian dengan nol
                                                    $status_keuntungan = "Invalid"; // Atau nilai lain yang sesuai dengan logika bisnis Anda
                                                } else {
                                                    $ratio = $d_head['harga_modal'] / $d_head['harga_jual'];
                                                    if ($ratio < 0.38) {
                                                        $status_keuntungan = "Good";
                                                    } else if ($ratio == 0.38) {
                                                        $status_keuntungan = "Minimum";
                                                    } else {
                                                        $status_keuntungan = "Warning";
                                                    }
                                                }
                                                

                                                $date_formatted = "9999-01";

                                                $result_head_rab = mysqli_query($db2,"SELECT date_rab FROM dg_client_project_breakdown   dcpb
                                                INNER JOIN dg_client_project_breakdown_rab dcpbr
                                                ON dcpb.id_dg_client_project_breakdown = dcpbr.id_dg_client_project_breakdown
                                                INNER JOIN dg_rab_detail drd
                                                ON dcpbr.id_dg_rab_detail = drd.id_dg_rab_detail
                                                WHERE dcpb.id_dg_client_project_breakdown = $id_dg_client_project_breakdown
                                                ORDER BY date_rab ASC
                                                LIMIT 1");
                                                
                                                while($d_head_rab = mysqli_fetch_array($result_head_rab)){
                                                    $date_rab_x = $d_head_rab['date_rab'];
                                                    $date_formatted = date('Y-m', strtotime($date_rab_x));
                                                }
                                                // Periksa apakah $date_formatted sebelum bulan saat ini
                                                $currentMonth = date('Y-m');
                                                $disabled = '';
                                                if ($date_formatted <= $currentMonth) {
                                                    // Jika $date_formatted sebelum bulan saat ini, tambahkan atribut 'disabled'
                                                    $disabled = 'disabled';
                                                } else {
                                                    // Jika tidak, tampilkan input tanpa atribut 'disabled'
                                                    $disabled = '';
                                                }
                                                if ($d_head['status_breakdown']==1) {
                                                    $status_disetujui = 'Belum Disetujui';
                                                    $warna_disetujui = 'orange';
                                                }else  if ($d_head['status_breakdown']==2) {
                                                    $status_disetujui = 'Disetujui';
                                                    $warna_disetujui = 'green';
                                                }else  if ($d_head['status_breakdown']==3) {
                                                    $status_disetujui = 'Tidak Disetujui';
                                                    $warna_disetujui = 'red';
                                                }
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $no_temp; ?></td>
                                                <td><?php echo $nama_user; ?></td>
                                                <td><?php echo $nama_job; ?></td>
                                                <td><?php echo $d_head['nama_komponen']; ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($d_head['harga_modal']*$d_head['jumlah_komponen'], 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($d_head['harga_jual']*$d_head['jumlah_komponen'], 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($d_head['discount'], 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($keuntungan, 2, ',', '.'); ?></td>
                                                <td><?php echo $status_keuntungan; ?><br><b style="color: <?php echo $warna_disetujui; ?>;"><?php echo $status_disetujui; ?></b></td>
                                                
                                                <td style="text-align: center;">
                                                    
                                                    <button class="btn btn-info btn-sm"
                                                        style="margin-right: 15px;" title="Edit this Project Breakdown"
                                                        data-a="<?php echo $d_head['id_dg_client_project_breakdown']; ?>"
                                                        data-b="<?php echo $d_head['id_dg_user']; ?>"
                                                        data-c="1"
                                                        data-d="2"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-breakdown" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false" title="Delete this Breakdown" <?php echo $disabled; ?>
                                                        data-c="<?php echo $d_head['id_dg_client_project_breakdown']; ?>"
                                                        data-v="<?php echo $nama_user.' - '.$d_head['nama_komponen']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel-breakdown">
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


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Total Value Project</h5>                                  
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped" style="font-size: 15px;">
                                        <thead>
                                            <tr>
                                                <th>Total Harga Modal</th>
                                                <th>Total Harga Jual</th>
                                                <th>Total Discount</th>
                                                <th>Total Keuntungan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $harga_jual_total = 0;
                                            $harga_modal_total = 0;
                                            $harga_discount_total = 0;
                                            $keuntungan_total = 0;
                                            $result_head_total = mysqli_query($db2,"select * from `dg_client_project_breakdown` where id_dg_client_project = $id_dg_client_project");
                                            while($d_head_total = mysqli_fetch_array($result_head_total)){

                                                $harga_jual_total = $harga_jual_total + ($d_head_total['harga_jual']*$d_head_total['jumlah_komponen']);
                                                $harga_modal_total = $harga_modal_total + ($d_head_total['harga_modal']*$d_head_total['jumlah_komponen']);
                                                $harga_discount_total = $harga_discount_total + $d_head_total['discount'];
                                                
                                                
                                                

                                            }
                                            $keuntungan_total = $harga_jual_total - $harga_modal_total - $harga_discount_total;

                                            if ($harga_jual_total == 0) {
                                                // Menangani kasus di mana harga_jual adalah nol untuk mencegah pembagian dengan nol
                                                $status_keuntungan_total = "Invalid"; // Atau nilai lain yang sesuai dengan logika bisnis Anda
                                            } else {
                                                $ratio = $harga_modal_total / $harga_jual_total;
                                                if ($ratio < 0.38) {
                                                    $status_keuntungan_total = "Good";
                                                } else if ($ratio == 0.38) {
                                                    $status_keuntungan_total = "Minimum";
                                                } else {
                                                    $status_keuntungan_total = "Warning";
                                                }
                                            }
                                                
                                            ?>
                                            
                                            <tr>
                                                <td style="text-align: right;">Rp. <?php echo number_format($harga_modal_total, 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($harga_jual_total, 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($harga_discount_total, 2, ',', '.'); ?></td>
                                                <td style="text-align: right;">Rp. <?php echo number_format($keuntungan_total, 2, ',', '.'); ?></td>
                                                <td><?php echo $status_keuntungan_total; ?></td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                    </div>
                    <!-- /.row (main row) -->



