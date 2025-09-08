<?php 
// mengaktifkan session
session_start();
include '../../controller/conn.php';
date_default_timezone_set('Asia/Jakarta');
// Ubah format tanggal menjadi nama bulan - tahun
$selectedDate = trim($_GET['selectedDate']) . '-01';
$dateObj = DateTime::createFromFormat('Y-m-d', $selectedDate);

$errors = DateTime::getLastErrors();
if ($errors['warning_count'] == 0 && $errors['error_count'] == 0) {
    $formattedDate = $dateObj->format('F Y');
    $formattedDate2 = $dateObj->format('Ym');
    $monthDate = $dateObj->format('m');
    $yearDate = $dateObj->format('Y');

} else {
    echo "Error parsing date<br>";
    print_r($errors);
}


?>  
<div class="card-body padding-print">

    <div class="d-flex justify-content-between align-items-center"  style="margin-bottom: -15px;  margin-top: -25px;">
        <img class="img-logo" style="margin-left: -15px;" src="img/client_logo/logo.png" alt="DIK Group Logo" />
        <h3 class="modal-title ml-auto" style="color: #00395B; text-transform: uppercase;"><b id="labelRAB">RANCANGAN ANGGARAN BIAYA</b> | <b><?php echo $formattedDate; ?></b></h3>      
    </div>
    <hr>
    <!-- Menggunakan CSS untuk membuat teks berada di tengah -->
    <div class="row">
        <div class="col-12">
            <div class="row">
                <label class="col-12 col-form-label"  style="font-weight: unset !important;"><b>Bandung, Jawa Barat - Indonesia</b></label>
            </div>
        </div>
        


        <div class="col-md-4 col-12" style="margin-bottom: -15px;">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">WA Number</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: 082126184848</label>
            </div>
        </div>
        <div class="col-md-4 col-12 mobile-none" style="margin-bottom: -15px;"></div>

        <div class="col-md-4 col-12" style="margin-bottom: -15px;">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">Date</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: <?php echo "5 ".$formattedDate; ?></label>
            </div>
        </div>

        <div class="col-md-4 col-12" style="margin-bottom: -15px;">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">Email</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: info@dikgroup.id</label>
            </div>
        </div>
        <div class="col-md-4 col-12" style="margin-bottom: -15px;"></div>

        <div class="col-md-4 col-12" style="margin-bottom: -15px;">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">RAB #</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: <?php echo 'GA-'.$formattedDate2.'05'; ?></label>
            </div>
        </div>

        <div class="col-md-4 col-12"  style="margin-bottom: -15px;">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">Web</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: dikgroup.id</label>
            </div>
        </div>
        <div class="col-md-4 col-12 mobile-none"></div>

        <div class="col-md-4 col-12">
            <div class="row">
                <label class="col-md-5 col-6 col-form-label"  style="font-weight: unset !important;">Subject ID</label>
                <label class="col-md-7 col-6 col-form-label"  style="font-weight: unset !important;">: General Afair</label>
            </div>
        </div>

    

    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 col-12" style=" margin-bottom: 20px;">
            <div class="row">
                <p class="col-md-12" style="background-color: #00395B; color: #fff; margin-bottom: 0px;"><b>BILL TO:</b><br></p>
                <p class="col-md-12"><b>PT Digital Informasi Kreatif</b><br>
                Jl. Banda No.30, Citarum Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115</p>
            </div>
        </div>
        <div style="overflow-x: auto; width: 100%;">
            <table id="tableIsiRAB" class="table table-bordered table-striped" style="font-size: 12px; margin-bottom: 50px; width: 100%;">
                <thead>
                    <tr style="background-color: #00395B !important; color: #fff; text-transform: uppercase;">
                        <th style="width: 12%; text-align: center; background-color: #00395B !important;">Divisi</th>
                        <th style="width: 18%; background-color: #00395B !important;">Project</th>
                        <th style="width: 22%; background-color: #00395B !important;">Deskripsi</th>
                        <th style="width: 15%; background-color: #00395B !important;">Nama</th>
                        <th style="width: 13%; background-color: #00395B !important;">No. Rekening</th>
                        <th style="width: 5%; background-color: #00395B !important;">Bank</th>
                        <th style="width: 15%; background-color: #00395B !important;">Amount</th>
                        <?php if($_SESSION['priv']==1){?>
                        <th class="no-print" style="width: 5%; background-color: #00395B !important;">Action</th>
                        <th class="no-print" style="width: 5%; background-color: #00395B !important;">Check</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sub_total = 0;
                    $id_dg_division_temp = 0;
                    $id_dg_client_project_temp = 0;
                    $result_rab = mysqli_query($db2,"SELECT * FROM `dg_rab_detail` drd
                    INNER JOIN dg_division dd
                    ON drd.id_dg_division = dd.id_dg_division
                    WHERE MONTH(drd.date_rab) = $monthDate AND YEAR(drd.date_rab) = $yearDate AND (status_rab = 0 OR status_rab is null OR status_rab = 1)
                    ORDER BY dd.id_dg_division ASC, drd.id_dg_client_project DESC, drd.no_rekening ASC, drd.id_dg_rab_detail DESC");
                    while($d_rab = mysqli_fetch_array($result_rab)){
                        $id_dg_rab_detail = $d_rab['id_dg_rab_detail']; 
                        $division_name = $d_rab['division_name']; 
                        $project_name = $d_rab['project_name'];
                        $deskripsi_rab = $d_rab['deskripsi_rab'];
                        $nama_rekening = $d_rab['nama_rekening'];
                        $no_rekening = $d_rab['no_rekening'];
                        $nama_bank = $d_rab['nama_bank'];
                        $amount = $d_rab['amount'];
                        $check = $d_rab['check_rab'];
                        $id_dg_division = $d_rab['id_dg_division'];
                        $status_rab = $d_rab['status_rab'];
                        $sub_total =  $sub_total + $amount;
                        $id_dg_client_project = 99999999999;
                        $nama_client = '';

                    $result_cp = mysqli_query($db2,"SELECT * FROM `dg_rab_detail` drd
                    INNER JOIN dg_client_project_breakdown_rab dcpb
                    ON drd.id_dg_rab_detail = dcpb.id_dg_rab_detail

                    INNER JOIN dg_client_project_breakdown dcp
                    ON dcpb.id_dg_client_project_breakdown = dcp.id_dg_client_project_breakdown

                    INNER JOIN dg_client_project dc
                    ON dc.id_dg_client_project = dcp.id_dg_client_project

                    INNER JOIN dg_client dcx
                    ON dc.id_dg_client = dcx.id_dg_client

                    WHERE MONTH(drd.date_rab) = $monthDate AND YEAR(drd.date_rab) = $yearDate
                    AND drd.id_dg_rab_detail = $id_dg_rab_detail

                    AND (drd.status_rab is null or drd.status_rab= 0 or drd.status_rab= 1)

                    ORDER BY dcp.id_dg_client_project_breakdown ASC");
                    while($d_cp = mysqli_fetch_array($result_cp)){
                    $id_dg_client_project = $d_cp['id_dg_client_project'];
                    $division = $d_cp['division'];
                    $id_dg_client = $d_cp['id_dg_client'];
                    $nama_client = $d_cp['nama_client'];
                    }


                    // Kueri SQL untuk menghitung jumlah baris yang memenuhi kriteria tertentu
                    $sql_count_division = "SELECT COUNT(*) AS total_id_dg_division
                    FROM `dg_rab_detail` drd
                    INNER JOIN dg_division dd ON drd.id_dg_division = dd.id_dg_division
                    WHERE MONTH(drd.date_rab) = $monthDate AND YEAR(drd.date_rab) = $yearDate AND dd.id_dg_division= $id_dg_division
                    AND (drd.status_rab is null or drd.status_rab= 0 or drd.status_rab= 1)";

                    // Jalankan kueri
                    $result_count_div = $db2->query($sql_count_division);
                    $row = $result_count_div->fetch_assoc();
                    $row_span = $row['total_id_dg_division'];


                    // Kueri SQL untuk menghitung jumlah baris yang memenuhi kriteria tertentu
                    $sql_count_project = "SELECT COUNT(*) AS total_id_dg_client_project FROM dg_rab_detail
                    WHERE MONTH(date_rab) = $monthDate AND YEAR(date_rab) = $yearDate 
                    AND id_dg_client_project = $id_dg_client_project AND id_dg_client_project != 0 AND id_dg_division = $id_dg_division";

                    // Jalankan kueri
                    $result_count_pro = $db2->query($sql_count_project);
                    $row_pro = $result_count_pro->fetch_assoc();
                    $row_span_pro = $row_pro['total_id_dg_client_project'];
                    if($row_span_pro==0){$row_span_pro = 1;}
                    
                    ?>
                    <tr>
                        <?php if($id_dg_division!=$id_dg_division_temp){ ?>
                            <td style="text-align: center; vertical-align: middle;" rowspan="<?php echo $row_span; ?>"><b><?php echo $division_name; ?></b></td>
                        <?php } ?>
                        
                        <?php if($id_dg_client_project!=$id_dg_client_project_temp || $id_dg_client_project==99999999999){ ?>
                            <td style="vertical-align: middle;" rowspan="<?php echo $row_span_pro; ?>"><a target="_blank" style="color: inherit; text-decoration: inherit;" 
                                <?php if($id_dg_client_project!=99999999999){ ?>href="client_project_invoice.php?id_client=<?php echo $id_dg_client; ?>&id_dg_project=<?php echo $id_dg_client_project; ?>"<?php } ?>>
                                <?php if($nama_client!=""){ echo $nama_client.'<br>'; }; ?><?php echo $project_name; ?></a></td>
                        <?php }else if($status_rab==1){ ?>
                            <td style="vertical-align: middle;"><a><?php echo $project_name; ?></a></td>
                        <?php } ?>

                        <td style="vertical-align: middle;"><?php echo nl2br($deskripsi_rab); ?></td>
                        <td style="vertical-align: middle;"><?php echo $nama_rekening; ?></td>
                        <td style="vertical-align: middle;"><?php echo $no_rekening; ?></td>
                        <td style="vertical-align: middle;"><?php echo $nama_bank; ?></td>
                        <td style="vertical-align: middle; text-align: right;">Rp. <?php echo number_format($d_rab['amount'], 2, ',', '.'); ?></td>
                        <?php if($_SESSION['priv']==1){?>
                        <td class="no-print" style="text-align: center;">
                            <?php if($status_rab==1){?>
                                <!-- <button class="btn btn-info btn-sm" name="id_ev"
                                        style="margin-bottom: 10px;"
                                        data-a="<?php echo $id_dg_rab_detail; ?>"
                                        data-b="<?php echo $d_head['name_link']; ?>"
                                        data-c="<?php echo $d_head['dg_link']; ?>"
                                        data-d="<?php echo $d_head['bobot_link']; ?>"
                                        data-toggle="modal"
                                        data-target="#modal-edit-header" data-backdrop="static"
                                        data-keyboard="false">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                </button> -->
                                <button class="btn btn-danger btn-sm" data-backdrop="static"
                                    data-keyboard="false"
                                    data-c="<?php echo $id_dg_rab_detail; ?>"
                                    data-v="<?php echo $division_name.'-'.$project_name; ?>"
                                    data-toggle="modal" data-target="#modal-cancel-rab">
                                    <i class="fas fa-trash">
                                    </i>         
                                </button>
                            <?php } ?>

                        </td>
                        <td class="no-print" style="text-align: center; vertical-align: middle">
                        <input type="checkbox" id="myCheckbox" name="myCheckbox" 
                            value="<?php echo $id_dg_rab_detail; ?>" style="width: 100%;" <?php if($check==1){echo "checked";} ?> 
                            onchange="saveCheckboxStatus(<?php echo $id_dg_rab_detail; ?>,this.checked)">

                        </td>
                        <?php 
                        }
                        $id_dg_division_temp=$id_dg_division;
                        $id_dg_client_project_temp = $id_dg_client_project;
                        ?>
                        
                    </tr>

                    <?php  } ?>


                    </tbody>
                </table>
            </div>
        <div class="col-md-5 col-12" style="border: 1px solid #0002;">
            <div class="row">
                <p class="col-md-12" style="background-color: #00395B; color: #fff; margin-bottom: 0px;"><b>NOTES</b><br></p>
                <p class="col-md-12">Seluruh keuangan akan dibayarkan pada tanggal 5 bulan berikutnya secara otomatis.<br>
                Harap diperhatikan biaya yang akan dikeluarkan.</p>
            </div>
        </div>
        
        <div class="col-md-3 col-12"></div>
        <br class="pc-none">
        <div class="col-md-4 col-12">
            <div class="row" style="margin-bottom: -15px;">
                <p class="col-md-5 col-6"><b>SUB TOTAL</b></p>
                <p class="col-2">: Rp. </p>
                <p class="col-4" style="text-align: right;"><?php echo number_format($sub_total, 2, ',', '.');?></p>
                <p class="col-1"></p>
            </div>
            <div class="row" style="margin-bottom: -15px;">
                <p class="col-md-5 col-6"><b>TAX</b></p>
                <p class="col-2">: Rp. </p>
                <p class="col-4" style="text-align: right;"><?php echo number_format(0, 2, ',', '.');?></p>
                <p class="col-1"></p>
            </div>
            <div class="row" style="margin-bottom: -15px; border-top: 1px solid #0009;">
                <p class="col-md-5 col-6"><b>TOTAL</b></p>
                <p class="col-2"><b>: Rp. </b></p>
                <p class="col-4" style="text-align: right;"><b><?php echo number_format($sub_total, 2, ',', '.');?></b></p>
                <p class="col-1"></p>
            </div>
        </div>
        

        <div class="col-12" style="margin-top: 50px;">
            <div class="row">
                <p class="col-md-12">If you have any questions about this RAB, please contact:<br>
                <b>[Axel Novian Anthonius, +62-8212-618-4848, axelnovian.an@gmail.com]</b></p>
            </div>
        </div>
        
        <div class="col-12" style="margin-top: 50px; margin-bottom: 150px; text-align: center;">
            <div class="row">
                <p class="col-md-4">Disetujui Oleh,<br><br><br><br><br>
                <b>Kevin T. Gunawan</b><br><i>President Director</i></p>
                <br class="pc-none"><hr style="border: 1px solid black; width: 100%;" class="pc-none"><br class="pc-none">
                <p class="col-md-4">Diketahui Oleh,<br><br><br><br><br>
                <b>Reiner Febrian</b><br><i>Vice President</i></p>
                <br class="pc-none"><hr style="border: 1px solid black; width: 100%;" class="pc-none"><br class="pc-none">
                <p class="col-md-4">Dibuat Oleh,<br><br><br><br><br>
                <b>Axel Novian Anthonius</b><br><i>General Affair</i></p>
            </div>
        </div>


        
    </div>

</div>



<script>


    var bulanInput = document.getElementById("bdaymonth").value;
    var tanggal = new Date(bulanInput);
    var namaBulan = tanggal.toLocaleString('default', { month: 'long' });
    var tahun = tanggal.getFullYear();

    var now = new Date();
    var tahun = now.getFullYear();
    var bulan = (now.getMonth() + 1 < 10 ? '0' : '') + (now.getMonth() + 1);
    var tanggal = (now.getDate() < 10 ? '0' : '') + now.getDate();
    var hasil = tahun + bulan + tanggal;
    document.title = "RAB & Invoice DIK Group (" + namaBulan + " " + tahun + ")" + " - " + hasil;


// Menambahkan footer ke setiap halaman saat mencetak
window.onbeforeprint = function() {
    var footer = document.createElement('div');
    footer.classList.add('footer-print');
    footer.innerHTML = "<hr><div class='col-12' style='color: #0007;'> Copyright | <b>PT. Digital Informasi Kreatif</b> &copy; <?php date_default_timezone_set('Asia/Jakarta'); echo date('Y'); ?> | All rights reserved. <div class='float-right d-none d-sm-inline-block'> Date Printed : <?php echo date('d F Y H:i'); ?> </div></div>";
    
    document.body.appendChild(footer);
};

// Menghapus footer setelah pencetakan selesai
window.onafterprint = function() {
    var footer = document.querySelector('.footer-print');
    footer.parentNode.removeChild(footer);
};


function saveCheckboxStatus(id_dg_rab_detail,isChecked) {

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            url: 'controller/conn_check_RAB.php',
            type: 'POST',
            data: { id_dg_rab_detail: id_dg_rab_detail,  isChecked: isChecked ? 1 : 0 },
            dataType: 'html',
            success: function(response) {
                // Tangkap respons dari server
                if (!response.includes('Error')) {
                    // Lakukan tindakan sesuai dengan penghapusan berhasil
                    toastr.success(response);
                } else {
                    // Lakukan tindakan sesuai dengan penghapusan gagal
                    toastr.error('Gagal Checklist!<br>'+response);
                }
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan saat mengirim permintaan AJAX
                console.error('Error:', error);
            }
        });
    }


    $('#modal-cancel-rab').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_dg_rab_detail').val(recipient_c);
            document.getElementById("id_dg_rab_detail").value = recipient_c;


            document.getElementById("Jenis_warna3").innerHTML = recipient_v;
        })
</script>