<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management Profile's | DIK Group</title>

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
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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

    .btn-group {
            float: right !important;
            margin-top: -39px;
            margin-bottom: 20px;
        }

    .select2-container--default .select2-selection--single {
           height: 38px;
    }

  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


      <div class="modal fade" id="modal-add-job">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Job ke User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_user_job.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                      <div class="form-group row">
                          <label for="userJob" class="col-sm-12 col-form-label">Jobs</label>
                          <div class="col-sm-12">
                              <select class="form-control select2 userJob" style="width: 100%;" name="userJob" id="userJob">
                                <option value="" disabled selected>- Pilih Job -</option>   
                                  <?php 
                                  $result_duj = mysqli_query($db2,"SELECT dj.*
                                  FROM dg_job dj
                                  WHERE dj.deleted_by is null and NOT EXISTS (
                                      SELECT 1
                                      FROM dg_user_job duj
                                      WHERE duj.id_dg_job = dj.id_dg_job
                                      AND duj.id_dg_user = $id_user
                                  )");
                                  while($d_duj = mysqli_fetch_array($result_duj)){
                                  ?>
                                  <option value="<?php echo $d_duj['id_dg_job']; ?>"><?php echo $d_duj['job_name']; ?></option>    
                                  <?php } ?>
                              </select>
                          </div>
                      </div>

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-add-skill">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Skill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_user_skill.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                        <div class="form-group row">
                            <label for="namaSkill" class="col-sm-12 col-form-label">Nama Skill</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="namaSkill" name="namaSkill"
                                    placeholder="Ketikan Nama Skill" value="" required>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="precentase" class="col-sm-12 col-form-label">Precentase Skill</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="precentase" name="precentase"
                                    placeholder="Ketikan Precentase Skill" value="" min="0" max="100">
                            </div>
                        </div>
                        
                        

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->


    <div class="modal fade" id="modal-edit-skill">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Edit Data Skill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_edit_user_skill.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        
                        <div class="form-group row">
                            <label for="namaSkill2" class="col-sm-12 col-form-label">Nama Skill</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="namaSkill2" name="namaSkill2"
                                    placeholder="Ketikan Nama Skill" value="" required>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label for="precentase2" class="col-sm-12 col-form-label">Precentase Skill</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="precentase2" name="precentase2"
                                    placeholder="Ketikan Precentase Skill" value="" min="0" max="100">
                            </div>
                        </div>
                        
                        

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="id_task4" id="id_task4" value="">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal -->



      <div class="modal fade" id="modal-cancel-skill">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Skill ini ?<br>
                        Nama Skill &nbsp; : <b id="Jenis_warna2"></b><br>
                </div>
                <form action="controller/conn_delete_user_skill.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task2" id="id_task2" value="">

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

    <div class="modal fade" id="modal-cancel-job">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">PERHATIAN !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus Job ini ?<br>
                        Nama Job &nbsp; : <b id="Jenis_warna3"></b><br>
                </div>
                <form action="controller/conn_delete_user_job.php" method="post">
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_task3" id="id_task3" value="">

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

  <div class="wrapper">
    <?php include "./view/common/navbar.php" ?>

    <?php include "./view/common/aside.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->
      <section class="content" style="padding-top: 20px;">
        <div class="container-fluid">
        <?php 
        $result_head = mysqli_query($db2,"select * from `dg_user` where id_dg_user = $id_user");
        while($d_head = mysqli_fetch_array($result_head)){
          $photo = $d_head['photo'];
          $nama = $d_head['nama'];
          $ulang_tahun = $d_head['ulang_tahun'];
          $email = $d_head['email'];
          $nomor_hp = $d_head['nomor_hp'];
          $nomor_rekening = $d_head['nomor_rekening'];
          $bank = $d_head['bank'];
          $alamat = $d_head['alamat'];
          $jabatan = $d_head['jabatan'];
          $jenisKelamin = $d_head['jenis_kelamin'];
          $email_perusahaan = $d_head['email_dg'];

          $nama_panggilan = $d_head['nama_panggilan'];
          $mbti = $d_head['mbti'];
          $quotes = $d_head['quotes'];
          $i_do = $d_head['i_do'];
          $link_team = $d_head['link_team'];

          

          $_SESSION['tidak_lengkap']=0;

          if ($d_head['photo'] == "" ||
              $d_head['nama']  == "" ||
              $d_head['jenis_kelamin']  == "" ||
              $d_head['ulang_tahun']  == "" ||
              $d_head['email']  == "" ||
              $d_head['nomor_hp']  == "" ||
              $d_head['jabatan']  == "" ||
              $d_head['nomor_rekening']  == "" || 
              $d_head['bank']  == "" || 
              $d_head['alamat']  == "" || 
              $d_head['status']  == "" || 
              $d_head['username']  == "" ||
              $d_head['nama_panggilan']  == "" ||
              $d_head['mbti']  == "" ||
              $d_head['quotes']  == "" ) { 
                $_SESSION['tidak_lengkap'] = 1; }
          }

        ?>


          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->

                <div class="card-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h2 class="m-0">My Profile
                        </h2>
                      </div><!-- /.col -->
                      <div class="col-sm-6">

                      </div><!-- /.col -->
                    </div><!-- /.row -->
                  </div><!-- /.container-fluid -->
                </div>


                <div class="card-body">
                  <form class="form-horizontal" action="controller/conn_edit_profile.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-3 col-sm-12">
                        <div class="row form-group">
                          
                          
                          <label for="lampiran" class="col-12"><img id="blah"
                              style="width: 100%; border: 1px solid black; padding: 10px;"
                              src="img/profile/<?php if($photo==""){echo 't0.jpg'; }else{ echo $photo; } ?>" alt="your image" /></label>
                          <label for="inputLampiran" class="col-12">Photo Profile</label>
                          <input class="form-control col-12" type="file" id="lampiran" name="lampiran">
                          <input type="hidden" class="form-group" id="bannerLama" name="bannerLama" value="<?php if($photo==""){echo 't0.jpg'; }else{ echo $photo; } ?>">
                          
                          
                        </div>

                        <div class="form-group row">
                          <label for="link_team" class="col-sm-12 col-form-label">User ID</label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="link_team" name="link_team" placeholder="Masukan User ID untuk profile." onkeyup="validateInput(this)" onchange="checkAvailability(this.value)" value="<?php echo $link_team; ?>">
                              <span id="link_team_message" style="color: red;"></span>
                          </div>
                      </div>
                      <p style="font-size: 12px;">Digunakan untuk link QR Code dibawah ini dan untuk share Profile kamu di web.
                      Nanti kamu bisa lihat di :  <br>
                      <?php 
                      if ($link_team=="") {
                        echo " dikgroup.id/team.php?id=[User ID Link]";
                      } else {
                        echo "<a target='_blank' href='https://dikgroup.id/team.php?id=".$link_team."'> dikgroup.id/team.php?id=".$link_team."</a>";
                      }
                      ?>
                       </p>
                      
                      <div class="form-group row">
                          <label for="link_team" class="col-sm-12 col-form-label">QR Code Link Team: </label>
                          <div class="col-sm-12" style="height: 100%;">
                            <?php
                              // Panggil library PHP QR Code
                              require 'phpqrcode/qrlib.php';

                              // Fungsi untuk membuat QR Code
                              function generateQRCode($link, $filename) {
                                  // Tentukan ukuran dan level ECC dari QR Code
                                  $ecc = 'L'; // Level ECC: L, M, Q, H
                                  $size = 10; // Ukuran QR Code dalam modul
                                  $margin = 2; // Jarak margin di sekitar QR Code

                                  // Generate QR Code
                                  QRcode::png($link, $filename, $ecc, $size, $margin);
                              }

                              // Contoh penggunaan fungsi generateQRCode
                              if ($link_team!="") {
                                $link = "https://dikgroup.id/team.php?id=".$link_team; // Link yang ingin Anda jadikan QR Code
                                $filename = "qr_code/qr_code_".$link_team.".png"; // Nama file untuk menyimpan QR Code
                              }else {
                                $link = "https://dikgroup.id/"; // Link yang ingin Anda jadikan QR Code
                                $filename = "qr_code/qr_code_dggroup.png";
                              }
                             

                              // Panggil fungsi generateQRCode
                              generateQRCode($link, $filename);

                              echo "<img style='height: 100%;' class='form-control' src='$filename' alt='QR Code'>";
                              ?>
                              <span id="qr_code_message" style="color: red;"></span>
                            </div>
                        </div>

                      </div>

                      <div class="col-md-9 col-sm-12" 
                      <?php 
                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                        substr($useragent,0,4))){}else{echo "style='padding-left: 60px;'";}
                      ?>>

                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nama Lengkap" value="<?php echo $nama; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="namaPanggilan" class="col-sm-2 col-form-label">Nama Panggilan</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaPanggilan" name="namaPanggilan" placeholder="Nama Panggilan" value="<?php echo $nama_panggilan; ?>">
                          </div>
                        </div>


                        <div class="form-group row">
                          <label for="JenisKelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                          <div class="col-sm-10">
                            <select class="form-control select2 JenisKelamin" style="width: 100%;" name="JenisKelamin" id="JenisKelamin">
                              <option value="">-Pilih Gender-</option>    
                              <option <?php if($jenisKelamin == "L"){ echo "selected"; } ?> value="L">Laki-laki</option>
                              <option <?php if($jenisKelamin == "P"){ echo "selected"; } ?> value="P">Perempuan</option>
                            </select>
                          </div>
                        </div>



                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Tgl Ulang Tahun</label>
                          <div class="input-group date col-sm-4" id="reservationdate3" data-target-input="nearest"
                            required>
                            <input type="text" name="deadline3" class="form-control datetimepicker-input deadline3"
                              data-target="#reservationdate3" value="<?php echo date_format(date_create($ulang_tahun),'d-F-Y'); ?>" required>
                            <div class="input-group-append" data-target="#reservationdate3"
                              data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="inputEmailPerusahaan" class="col-sm-2 col-form-label">Email Perusahaan</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmailPerusahaan" name="inputEmailPerusahaan" placeholder="Email Perusahaan" value="<?php echo $email_perusahaan; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email Pribadi</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" value="<?php echo $email; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="inputNo" class="col-sm-2 col-form-label">Nomor HP</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputNo" name="inputNo" placeholder="Nomor Hp" value="<?php echo $nomor_hp; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="inputRe" class="col-sm-2 col-form-label">Nomor Rekening</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputRe" name="inputRe"  placeholder="Nomor Rekening" value="<?php echo $nomor_rekening; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="namaBank" class="col-sm-2 col-form-label">Nama Bank</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="namaBank" name="namaBank" placeholder="Nama Bank" value="<?php echo $bank; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>">
                          </div>
                        </div>

                        <p style="font-size: 15px; text-align: right;">Jika Jabatan tidak ada pilihannya, scroll ke bawah dan + Add Job.</p>

                        <div class="form-group row">
                          <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                          <div class="col-sm-10">
                            
                            <select class="form-control select2 jabatan" style="width: 100%;" name="jabatan" id="jabatan">
                                <option value="" disabled>- Pilih Jabatan -</option>   
                                  <?php 
                                  $result_dujs = mysqli_query($db2,"SELECT dj.*
                                  FROM dg_job dj
                                  WHERE dj.deleted_by is null and EXISTS (
                                      SELECT 1
                                      FROM dg_user_job duj
                                      WHERE duj.id_dg_job = dj.id_dg_job
                                      AND duj.id_dg_user = $id_user
                                  )");
                                  while($d_dujs = mysqli_fetch_array($result_dujs)){
                                  ?>
                                  <option <?php if ($d_dujs['job_name']==$jabatan){echo "selected";} ?> value="<?php echo $d_dujs['job_name']; ?>"><?php echo $d_dujs['job_name']; ?></option>    
                                  <?php } ?>
                              </select>

                          </div>
                        </div>
                        

                        <div class="form-group row">
                          <label for="mbti" class="col-sm-2 col-form-label">MBTI</label>
                          <div class="col-sm-10">
                              <select class="form-control select2 mbti" style="width: 100%;" name="mbti" id="mbti">
                                  <option value="">-Pilih MBTI-</option>
                                  <option value="-">-Belum Test-</option>
                                  <option <?php if($mbti == "ISTJ"){ echo "selected"; } ?> value="ISTJ">ISTJ</option>
                                  <option <?php if($mbti == "ISFJ"){ echo "selected"; } ?> value="ISFJ">ISFJ</option>
                                  <option <?php if($mbti == "INFJ"){ echo "selected"; } ?> value="INFJ">INFJ</option>
                                  <option <?php if($mbti == "INTJ"){ echo "selected"; } ?> value="INTJ">INTJ</option>
                                  <option <?php if($mbti == "ISTP"){ echo "selected"; } ?> value="ISTP">ISTP</option>
                                  <option <?php if($mbti == "ISFP"){ echo "selected"; } ?> value="ISFP">ISFP</option>
                                  <option <?php if($mbti == "INFP"){ echo "selected"; } ?> value="INFP">INFP</option>
                                  <option <?php if($mbti == "INTP"){ echo "selected"; } ?> value="INTP">INTP</option>
                                  <option <?php if($mbti == "ESTP"){ echo "selected"; } ?> value="ESTP">ESTP</option>
                                  <option <?php if($mbti == "ESFP"){ echo "selected"; } ?> value="ESFP">ESFP</option>
                                  <option <?php if($mbti == "ENFP"){ echo "selected"; } ?> value="ENFP">ENFP</option>
                                  <option <?php if($mbti == "ENTP"){ echo "selected"; } ?> value="ENTP">ENTP</option>
                                  <option <?php if($mbti == "ESTJ"){ echo "selected"; } ?> value="ESTJ">ESTJ</option>
                                  <option <?php if($mbti == "ESFJ"){ echo "selected"; } ?> value="ESFJ">ESFJ</option>
                                  <option <?php if($mbti == "ENFJ"){ echo "selected"; } ?> value="ENFJ">ENFJ</option>
                                  <option <?php if($mbti == "ENTJ"){ echo "selected"; } ?> value="ENTJ">ENTJ</option>
                              </select>

                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="quotes" class="col-sm-2 col-form-label">Quotes</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="quotes" name="quotes" placeholder="Quotes" value="<?php echo $quotes; ?>">
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="i_do" class="col-sm-2 col-form-label">What I do?</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="i_do" name="i_do" placeholder="Enter what you do"><?php echo $i_do; ?></textarea>
                            </div>
                        </div>

                

                      </div>
                      <input type="hidden" name="id_user" value="<?php echo $id_user;?>">

                      <div class="col-sm-12">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <button type="submit" class="btn btn-block  btn-success">Save</button>
                          </div>
                        </div>
                      </div>
                      
                    </div>

                  </form>

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


              <!-- Main content -->
              <section class="content">
                <div class="container-fluid">



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row" style="height: 40px;">
                                    <div class="col-6 form-group">
                                        <h2 style="padding: 20px;">Professionals Skills</h2>
                                    </div>
                                    <div class="col-6 form-group">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-skill" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 150px; margin-top: 10px; margin-right: 20px;">
                                            + Add Skill
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                                        <thead>
                                            <tr>
                                                <th>Professionals Skills</th>
                                                <th style="width: 15%; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $result_dus = mysqli_query($db2,"SELECT * FROM dg_user_skills dus INNER JOIN dg_user du
                                            ON dus.id_dg_user = du.id_dg_user
                                            WHERE dus.id_dg_user = $id_user");
                                            while($d_dus = mysqli_fetch_array($result_dus)){
                                            ?>
                                            <tr>
                                

                                                <td>
                                                  <div class="progress-group">
                                                     <b><?php echo $d_dus['skill_name']; ?></b>
                                                    <span class="float-right"><b><?php echo $d_dus['percent']; ?></b>/100</span>
                                                    <div class="progress progress-sm">
                                                      <div class="progress-bar bg-primary" style="width: <?php echo $d_dus['percent']; ?>%"></div>
                                                    </div>
                                                  </div>  
                                                </td>
                                                

                                                <td style="text-align: center;">
                                                    <button class="btn btn-info btn-sm" name="id_ev"
                                                    style="margin-right: 15px;"
                                                        data-a="<?php echo $d_dus['id_dg_user_skills']; ?>"
                                                        data-b="<?php echo $d_dus['skill_name']; ?>"
                                                        data-c="<?php echo $d_dus['percent']; ?>"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-skill" data-backdrop="static"
                                                        data-keyboard="false">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </button>
                                                    
                                                    
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-c="<?php echo $d_dus['id_dg_user_skills']; ?>"
                                                        data-v="<?php echo $d_dus['skill_name']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel-skill">
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
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="row" style="height: 40px;">
                                    <div class="col-6 form-group">
                                        <h2 style="padding: 20px;">My Job / What i Do</h2>
                                    </div>
                                    <div class="col-6 form-group">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-add-job" data-backdrop="static" data-keyboard="false"
                                            style="right: 0px; width: 150px; margin-top: 10px; margin-right: 20px;">
                                            + Add Job
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped" style="font-size: 15px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%;">Job Name</th>
                                                <th>Job Description</th>
                                                <th style="width: 10%; text-align: center;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                             $result_duj = mysqli_query($db2,"SELECT * FROM dg_user_job duj INNER JOIN dg_user du
                                             ON duj.id_dg_user = du.id_dg_user
                                             INNER JOIN dg_job dj
                                             ON duj.id_dg_job = dj.id_dg_job
                                             WHERE duj.id_dg_user = $id_user");
                                             while($d_duj = mysqli_fetch_array($result_duj)){
                                            ?>
                                            <tr>
                                

                                                <td><?php echo $d_duj['job_name']; ?></td>
                                                <td><?php echo $d_duj['job_description']; ?></td>
                                                

                                                <td style="text-align: center;">
                                                    
                                                    <button class="btn btn-danger btn-sm" data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-c="<?php echo $d_duj['id_dg_user_job']; ?>"
                                                        data-v="<?php echo $d_duj['job_name']; ?>"
                                                        data-toggle="modal" data-target="#modal-cancel-job">
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

  <!-- Page specific script -->
  <script>

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
              theme: 'bootstrap4'
            })
          })

          function validateInput(input) {
              // Menghapus spasi dari input
              input.value = input.value.replace(/\s/g, '');

              // Menghapus tanda baca dari input
              input.value = input.value.replace(/[^\w\s]/gi, '');
          }


          function checkAvailability(link_team) {
            $('#qr_code_message').text('QR Code akan terupdate setelah disave.');
            var id_user = <?php echo $id_user; ?>;
              // Membuat AJAX request untuk memeriksa ketersediaan ID
              $.ajax({
                  type: 'POST',
                  url: 'controller/check_link_team.php',
                  data: { link_team: link_team, id_user: id_user },
                  success: function(response) {
                      if (response == 'available') {
                          $('#link_team_message').text('');
                      } else {
                          $('#link_team_message').text('ID sudah terpakai');
                      }
                  }
              });
          }


          $('#modal-cancel-job').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task3').val(recipient_c);
            document.getElementById("id_task3").value = recipient_c;


            document.getElementById("Jenis_warna3").innerHTML = recipient_v;
        })

        $('#modal-cancel-skill').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_c = button.data('c');

            var recipient_v = button.data('v');
            var recipient_i = button.data('i');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task2').val(recipient_c);
            document.getElementById("id_task2").value = recipient_c;


            document.getElementById("Jenis_warna2").innerHTML = recipient_v;
        })



        $('#modal-add-job').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $('#modal-add-skill').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })




        $('#modal-edit-skill').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient_a = button.data('a');
            var recipient_b = button.data('b');
            var recipient_c = button.data('c');


            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.id_task4').val(recipient_a);
            document.getElementById("id_task4").value = recipient_a;

            modal.find('.namaSkill2').val(recipient_b);
            document.getElementById("namaSkill2").value = recipient_b;

            modal.find('.precentase2').val(recipient_c);
            document.getElementById("precentase2").value = recipient_c;



        })



        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "sorting": false
            });

        });

        $(function () {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "sorting": false
            });

        });

      function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }

      $("#lampiran").change(function () {
        readURL(this);
      });
    
    $(function () {

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
    })

    <?php if($_SESSION['tidak_lengkap']==1){ ?>
        $(window).on('load', function() {
            $('#modal-profile').modal('show');
        });
    <?php } ?>


        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });


  </script>
</body>

</html>