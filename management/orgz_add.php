<!DOCTYPE html>
<?php 
include 'view/common/first_validation.php';
// --- Default value supaya tidak Undefined ---
$organization_slug = "";
$organization_logo = "";
$organization_name = "";
$organization_email = "";
$organization_telp = "";
$organization_nomor_rekening = "";
$organization_nama_bank = "";
$organization_alamat = "";
$organization_country = "";
$organization_province = "";
$organization_city = "";
$organization_district = "";
$organization_village = "";
$organization_zip_code = "";
$organization_jenis_usaha = "";
$organization_tanggal_beridri = "";
$organization_npwp = "";
$organization_nib = "";

// --- Query data organisasi ---
$result_head = mysqli_query($db2,"
    SELECT * FROM `dg_user_organization` duo
    INNER JOIN dg_user du 
        ON duo.id_dg_user_organization = du.id_dg_user_organization
    WHERE du.id_dg_user = $id_user
");

// --- Isi variabel dari query ---
if ($result_head && mysqli_num_rows($result_head) > 0) {
    while($d_head = mysqli_fetch_array($result_head)){
        $id_dg_user_organization = $d_head['id_dg_user_organization'];
        $organization_logo = $d_head['organization_logo'] ?? "";
        $organization_name = $d_head['organization_name'] ?? "";
        $organization_email = $d_head['organization_email'] ?? "";
        $organization_telp = $d_head['organization_telp'] ?? "";
        $organization_nomor_rekening = $d_head['organization_nomor_rekening'] ?? "";
        $organization_nama_bank = $d_head['organization_nama_bank'] ?? "";
        $organization_alamat = $d_head['organization_alamat'] ?? "";
        $organization_country = $d_head['organization_country'] ?? "";
        $organization_province = $d_head['organization_province'] ?? "";
        $organization_city = $d_head['organization_city'] ?? "";
        $organization_district = $d_head['organization_district'] ?? "";
        $organization_village = $d_head['organization_village'] ?? "";
        $organization_zip_code = $d_head['organization_zip_code'] ?? "";
        $organization_jenis_usaha = $d_head['organization_jenis_usaha'] ?? "";
        $organization_tanggal_beridri = $d_head['organization_tanggal_beridri'] ?? "";
        $organization_slug = $d_head['organization_slug'] ?? "";
        $organization_npwp = $d_head['organization_npwp'] ?? "";
        $organization_nib = $d_head['organization_nib'] ?? "";

        $_SESSION['tidak_lengkap'] = 0;

        if (
            $organization_logo == "" ||
            $organization_name == "" ||
            $organization_tanggal_beridri == "" ||
            $organization_email == "" ||
            $organization_telp == "" ||
            $organization_jenis_usaha == "" ||
            $organization_nomor_rekening == "" ||
            $organization_nama_bank == "" ||
            $organization_alamat == "" ||
            $organization_country == "" ||
            $organization_province == "" ||
            $organization_city == "" ||
            $organization_district == "" ||
            $organization_village == "" ||
            $organization_zip_code == "" ||
            $organization_slug == ""
        ) {
            $_SESSION['tidak_lengkap'] = 1;
        }
    }
}
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Organization  | DIK Group</title>

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
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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





  .custom-file-upload-wrapper {
    position: relative;
    width: 100%;
    max-width: 300px;
  }

  .custom-file-upload {
    width: 100%;
    opacity: 0;
    position: absolute;
    height: 100%;
    top: 0;
    left: 0;
    cursor: pointer;
    z-index: 2;
  }

  .file-upload-label {
    background-color: #f8f9fa;
    border: 2px dashed #ced4da;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    font-size: 14px;
    color: #6c757d;
    transition: 0.3s;
    position: relative;
    z-index: 1;
  }

  .file-upload-label:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
  }

  .file-upload-label i {
    display: block;
    font-size: 24px;
    margin-bottom: 5px;
    color: #6c757d;
  }

  #blah {
    max-height: 180px;
    object-fit: contain;
    margin-bottom: 12px;
    cursor: pointer;
    transition: 0.3s;
  }

  #blah:hover {
    transform: scale(1.03);
    opacity: 0.85;
  }

  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">


  <div class="wrapper">
    <?php include "./view/common/navbar.php" ?>

    <?php include "./view/common/aside.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->
    <section class="content py-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


                <h3 class="m-0">Add Organization </h3>
      

                
                 <form id="formOrganization" enctype="multipart/form-data" method="POST" action="controller/conn_add_orgz.php">
                    
                    <div class="container-fluid p-4 row">
                      <!-- Section: Organization Logo -->
                       <div class="col-12 col-md-4">
                        <div class="card mb-4"  style="min-height: 400px;">
                          <div class="card-header card-primary card-outline font-weight-bold">
                            Organization Logo
                          </div>

                          <div class="card-body d-flex justify-content-center align-items-center flex-column text-center">
                            <div class="mb-3">
                              <img
                                id="blah"
                                src="img/organization/<?php echo $organization_logo ?: 't0.jpg'; ?>"
                                alt="Organization Logo"
                                class="img-thumbnail"
                                style="width: auto;"
                              />
                            </div>

                            <div class="custom-file-upload-wrapper">
                              <input type="file" id="lampiran" name="lampiran" class="custom-file-upload" />
                              
                              <div class="file-upload-label">
                                <i class="fas fa-upload"></i>
                                Click or drag file to upload
                              </div>

                              <input
                                type="hidden"
                                name="bannerLama"
                                value="<?php echo $organization_logo ?: 't0.jpg'; ?>"
                              />
                            </div>
                          </div>

                        </div>
                      </div>


                      <!-- Section: Organization Info -->
                      <div class="col-12 col-md-8">
                        <div class="card mb-4" style="min-height: 400px;">
                          <div class="card-header font-weight-bold  card-primary card-outline">Organization Information</div>
                          <div class="card-body">
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-2 col-form-label">Name *</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo $organization_name; ?>" placeholder="Organization Name" required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="slugName" class="col-sm-2 col-form-label">Slug *</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="slugName" name="slugName" value="<?php echo $organization_slug; ?>" placeholder="Organization Slug" required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="organization_jenis_usaha" class="col-sm-2 col-form-label">Business Type *</label>
                              <div class="col-sm-10">
                                <select class="form-control select2" name="organization_jenis_usaha" id="organization_jenis_usaha" required>
                                  <option value="">-- Select Business Type --</option>
                                  <option value="retail" <?php if($organization_jenis_usaha == 'retail') echo 'selected'; ?>>Retail</option>
                                  <option value="wholesale" <?php if($organization_jenis_usaha == 'wholesale') echo 'selected'; ?>>Wholesale</option>
                                  <option value="manufacturing" <?php if($organization_jenis_usaha == 'manufacturing') echo 'selected'; ?>>Manufacturing</option>
                                  <option value="service" <?php if($organization_jenis_usaha == 'service') echo 'selected'; ?>>Service</option>
                                  <option value="construction" <?php if($organization_jenis_usaha == 'construction') echo 'selected'; ?>>Construction</option>
                                  <option value="agriculture" <?php if($organization_jenis_usaha == 'agriculture') echo 'selected'; ?>>Agriculture</option>
                                  <option value="food_and_beverage" <?php if($organization_jenis_usaha == 'food_and_beverage') echo 'selected'; ?>>Food and Beverage</option>
                                  <option value="transportation" <?php if($organization_jenis_usaha == 'transportation') echo 'selected'; ?>>Transportation</option>
                                  <option value="real_estate" <?php if($organization_jenis_usaha == 'real_estate') echo 'selected'; ?>>Real Estate</option>
                                  <option value="education" <?php if($organization_jenis_usaha == 'education') echo 'selected'; ?>>Education</option>
                                  <option value="finance" <?php if($organization_jenis_usaha == 'finance') echo 'selected'; ?>>Finance</option>
                                  <option value="technology" <?php if($organization_jenis_usaha == 'technology') echo 'selected'; ?>>Technology</option>
                                  <option value="healthcare" <?php if($organization_jenis_usaha == 'healthcare') echo 'selected'; ?>>Healthcare</option>
                                  <option value="entertainment" <?php if($organization_jenis_usaha == 'entertainment') echo 'selected'; ?>>Entertainment</option>
                                  <option value="hospitality" <?php if($organization_jenis_usaha == 'hospitality') echo 'selected'; ?>>Hospitality</option>
                                  <option value="logistics" <?php if($organization_jenis_usaha == 'logistics') echo 'selected'; ?>>Logistics</option>
                                  <option value="consulting" <?php if($organization_jenis_usaha == 'consulting') echo 'selected'; ?>>Consulting</option>
                                  <option value="marketing" <?php if($organization_jenis_usaha == 'marketing') echo 'selected'; ?>>Marketing</option>
                                  <option value="non_profit" <?php if($organization_jenis_usaha == 'non_profit') echo 'selected'; ?>>Non-Profit</option>
                                  <option value="other" <?php if($organization_jenis_usaha == 'other') echo 'selected'; ?>>Other</option>
                                </select>

                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="foundingDate" class="col-sm-2 col-form-label">Founding Date</label>
                              <div class="col-sm-4 input-group date" id="foundingDate" data-target-input="nearest">
                                <input type="text" autocomplete="off" name="deadline3" class="form-control datetimepicker-input" data-target="#foundingDate" value="<?php echo !empty($organization_tanggal_beridri) ? date_format(date_create($organization_tanggal_beridri),'d-F-Y') : ''; ?>">
                                <div class="input-group-append" data-target="#foundingDate" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>

                      <!-- Section: Contact Information -->
                      <div class="col-12 col-md-5">
                        <div class="card mb-4" style="min-height: 520px;">
                          <div class="card-header font-weight-bold  card-primary card-outline">Contact, Banking & Legal</div>
                          <div class="card-body">
                            <div class="form-group row">
                              <label for="inputorganization_email" class="col-sm-3 col-form-label">Email</label>
                              <div class="col-sm-9">
                                <input required type="email" class="form-control" id="inputorganization_email" name="inputorganization_email" value="<?php echo $organization_email; ?>" placeholder="Email">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="inputNo" class="col-sm-3 col-form-label">Phone</label>
                              <div class="col-sm-9">
                                <input required type="text" class="form-control" id="inputNo" name="inputNo" value="<?php echo $organization_telp; ?>" placeholder="Phone Number">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="inputRe" class="col-sm-3 col-form-label">Account Number</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputRe" name="inputRe" value="<?php echo $organization_nomor_rekening; ?>" placeholder="Account Number">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="bankName" class="col-sm-3 col-form-label">Bank Name</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="bankName" name="bankName" value="<?php echo $organization_nama_bank; ?>" placeholder="Bank Name">
                              </div>
                            </div>

                            <hr style="background: #007bff; height: 1px; border: none;">

                            <div class="form-group row">
                              <label for="npwp" class="col-sm-3 col-form-label">TIN / NPWP</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="npwp" name="npwp" value="<?php echo $organization_npwp; ?>" placeholder="Tax Identification Number">
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="nib" class="col-sm-3 col-form-label">NIB</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="nib" name="nib" value="<?php echo $organization_nib; ?>" placeholder="Business Registration Number">
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <!-- Section: Location Information -->
                      <div class="col-12 col-md-7">
                        <div class="card mb-4" style="min-height: 520px;">
                          <div class="card-header font-weight-bold  card-primary card-outline">Location Information</div>
                          <div class="card-body">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Country</label>
                              <div class="col-sm-9">
                                <select required id="country" name="country" class="form-control select2 w-100">
                                  <option value="">- Select Country -</option>
                                  <option value="">Indonesia</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Province</label>
                              <div class="col-sm-9">
                                <select id="province" name="province" class="form-control select2">
                                  <option value="">- Select Province -</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">City</label>
                              <div class="col-sm-9">
                                <select id="city" name="city" class="form-control select2">
                                  <option value="">- Select City -</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">District</label>
                              <div class="col-sm-9">
                                <select id="district" name="district" class="form-control select2">
                                  <option value="">- Select District -</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Village</label>
                              <div class="col-sm-9">
                                <select id="village" name="village" class="form-control select2">
                                  <option value="">- Select Village -</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="address" class="col-sm-3 col-form-label">Address</label>
                              <div class="col-sm-9">
                                <textarea required class="form-control" id="address" name="address" placeholder="Organization Address"><?php echo $organization_alamat; ?></textarea>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="zipCode" class="col-sm-3 col-form-label">Zip Code</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="zipCode" name="zipCode" value="<?php echo $organization_zip_code; ?>" placeholder="Zip Code">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Hidden input -->
                      <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                      <input type="hidden" name="id_dg_user_organization" value="<?php echo $id_dg_user_organization; ?>">

                      <!-- Submit Button -->
                      <div class="text-right col-12">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Add</button>
                      </div>
                    </div>

                    <!-- Loading overlay -->
                    <div id="loadingOverlay" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0.8); z-index:9999; text-align:center; padding-top:20%;">
                      <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                      </div>
                    </div>

                  </form>

                </div>
                <!-- /.card-body -->
     

           
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

  <!-- Page specific script -->
  <script>

    <?php if($_SESSION['tidak_lengkap']==1){ ?>
        $(window).on('load', function() {
            $('#modal-Organization profile').modal('show');
        });
    <?php } ?>


        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });


  </script>
</body>

</html>