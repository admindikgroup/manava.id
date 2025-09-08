<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management Article</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- CodeMirror -->
  <link rel="stylesheet" href="plugins/codemirror/codemirror.css">
  <link rel="stylesheet" href="plugins/codemirror/theme/monokai.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Dropzone CSS -->
  <link href="upload/dropzone.min.css" rel="stylesheet" type="text/css">
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

    .select2-container .select2-selection--single {
      height: calc(2.25rem + 2px);
    }

    #previews .row {
      border: 2px #e0e0e0 solid;
      margin: 2px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #007bff !important;
    }

    td label {
      display: block;
      text-align: center;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">


<div class="modal fade" id="modal-add-tags">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Tags</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_tags.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="nama_tags2" class="col-sm-12 col-form-label">Tags Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_tags2" name="nama_tags2"
                                    placeholder="Ketikan Nama tags" value="">
                            </div>
                        </div>
                       

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="add" value="1">


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

<div class="modal fade" id="modal-add-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">Add Data Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/conn_add_category.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="nama_category2" class="col-sm-12 col-form-label">Category Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_category2" name="nama_category2"
                                    placeholder="Ketikan Nama Category" value="">
                            </div>
                        </div>
                       

                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="add" value="1">


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



  <div class="wrapper">
    <!-- Navbar -->
    <?php include "./view/common/navbar.php" ?>

    <?php include "./view/common/aside.php" ?>


    <form id='frmTarget' action="controller/conn_add_article.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <!-- /.card-header -->

                <div class="card-body">
                  <div div class="form-group row">
                    <div class="col-sm-12">
                      <label for="judul_article" class="col-sm-12 col-form-label">Article Title</label>
                      <div class="col-sm-12">
                        <input type="text" class="form-control" id="judul_article" name="judul_article"
                          placeholder="Ketikan Judul Dokumen" value="<?php echo $judul_article; ?>">
                      </div>
                    </div>
                    <div class="col-sm-10">
                      <label for="article_category" class="col-sm-12 col-form-label">Category</label>
                      <div class="col-sm-12 select2-green">
                        <select class="select2" multiple="multiple" data-placeholder="Select a Category" id="article_category" name="article_category[]"
                          data-dropdown-css-class="select2-green" style="width: 100%;">
                          <?php 
                            $result_head = mysqli_query($db2,"select * from `dg_article_category`");
                            while($d_head = mysqli_fetch_array($result_head)){
                          ?>
                            <option value="<?php echo $d_head['id_dg_article_category']; ?>"><?php echo $d_head['nama_category']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-success float-sm-right" data-toggle="modal"
                            data-target="#modal-add-category" data-backdrop="static" data-keyboard="false"
                            style="right: 0px; width: 150px; margin-top: 35px; ">
                            + Category
                        </a>
                    </div>
                    <div class="col-sm-10">
                      <label for="aticle_tags" class="col-sm-12 col-form-label">Tags / Keword</label>
                      <div class="col-sm-12 select2-purple">
                        <select class="select2" multiple="multiple" data-placeholder="Select a Tags" id="aticle_tags" name="aticle_tags[]"
                          data-dropdown-css-class="select2-purple" style="width: 100%;">
                          <?php 
                            $result_head = mysqli_query($db2,"select * from `dg_article_tags`");
                            while($d_head = mysqli_fetch_array($result_head)){
                          ?>
                            <option value="<?php echo $d_head['id_dg_article_tags']; ?>"><?php echo $d_head['nama_tags']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-success float-sm-right" data-toggle="modal"
                            data-target="#modal-add-tags" data-backdrop="static" data-keyboard="false"
                            style="right: 0px; width: 150px; margin-top: 35px; ">
                            + Tags
                        </a>
                    </div>
                  </div>
                  <div class="col-sm-12" style="width : 500px;">
                    <label for="banner_utama" class="col-sm-12 col-form-label">Main Banner: (1920x1280)</label>
                    <div class="row form-group" style="padding-right: 60px;">


                      <label for="banner_utama" class="col-12"><img id="blah"
                          style="width: 100%; border: 1px solid black; paddingL 10px;"
                          src="img/article/<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>"
                          alt="your image" /></label>

                      <input class="form-control col-12" type="file" id="banner_utama" name="banner_utama">
                      <input type="hidden" class="form-group" id="banner_utama_lama" name="banner_utama_lama"
                        value="<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>">


                    </div>
                  </div>




                </div>

              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- ./row -->

          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">
                    Article - Attention & Interest:
                  </h3>
                </div>
                <!-- /.card-header -->
                <!-- /.card-body -->
                <div class="card-body">
                  <textarea id="summernote" name="summernote"></textarea>

                    <div class="col-sm-12">
                        <label for="quotes" class="col-sm-12 col-form-label">Quotes</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="quotes" name="quotes"
                            placeholder="Ketikan Judul Dokumen" value="<?php echo $quotes; ?>">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label for="author_quotes" class="col-sm-12 col-form-label">Quotes Author</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="author_quotes" name="author_quotes"
                            placeholder="Ketikan Judul Dokumen" value="<?php echo $author_quotes; ?>">
                        </div>
                    </div>
                    
                </div>
                
              </div>
              <!-- /.col-->
            </div>
            <!-- ./row -->
          </div>
          

         
          

          <div class="card card-outline card-info">
            <div class="card-body">
              <div div class="form-group row">
                <div class="col-sm-4" style="width : 500px;">
                  <label for="banner2" class="col-sm-12 col-form-label">Content Banner 1: (3:2 / 1:1 /
                    4:3)</label>
                  <div class="row form-group" style="padding-right: 60px;">


                    <label for="banner2" class="col-12"><img id="blah2"
                        style="width: 100%; border: 1px solid black; paddingL 10px;"
                        src="img/article/<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>"
                        alt="your image" /></label>

                    <input class="form-control col-12" type="file" id="banner2" name="banner2">
                    <input type="hidden" class="form-group" id="banner2_lama" name="banner2_lama"
                      value="<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>">


                  </div>
                </div>
                <div class="col-sm-4" style="width : 500px;">
                  <label for="banner3" class="col-sm-12 col-form-label">Content Banner 2: (3:2 / 1:1 /
                    4:3)</label>
                  <div class="row form-group" style="padding-right: 60px;">


                    <label for="banner3" class="col-12"><img id="blah3"
                        style="width: 100%; border: 1px solid black; paddingL 10px;"
                        src="img/article/<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>"
                        alt="your image" /></label>

                    <input class="form-control col-12" type="file" id="banner3" name="banner3">
                    <input type="hidden" class="form-group" id="banner3_lama" name="banner3_lama"
                      value="<?php if($photo==""){echo 'b1.jpg'; }else{ echo $photo; } ?>">


                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">
                    Article - Desire & Action :
                  </h3>
                </div>
                <!-- /.card-header -->
                <!-- /.card-body -->
                <div class="card-body">
                  <textarea id="summernote2" name="summernote2"></textarea>
                  <div class="row">
                    <div id="actions2" class="col-sm-12">
                      <button type="submit" class="btn btn-primary start" style="width: 100%;">Save</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
            <!-- ./row -->
          </div>


        </section>
        <!-- /.content -->
      </div>
    </form>



    <?php include 'view/common/footer.html'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- CodeMirror -->
  <script src="plugins/codemirror/codemirror.js"></script>
  <script src="plugins/codemirror/mode/css/css.js"></script>
  <script src="plugins/codemirror/mode/xml/xml.js"></script>
  <script src="plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Select2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- Dropzone JS -->
  <script src="upload/dropzone.min.js" type="text/javascript"></script>
  <!-- Page specific script -->


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


  <script>

        $("#banner_utama").change(function () {
            readURL(this);
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

        $("#banner2").change(function () {
            readURL2(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#banner3").change(function () {
            readURL3(this);
        });

        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah3').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }


    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "paging": true,
        "sorting": false,
        "buttons": false,
        "pageLength": 5,
      });

    });
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });

    $(function () {
      // Summernote
      $('#summernote').summernote({
        height: 350, //set editable area's height
        placeholder: 'Ketikan sesuatu disini...',
        codemirror: { // codemirror options
          theme: 'monokai'
        }
      })
    })

    $(function () {
      // Summernote
      $('#summernote2').summernote({
        height: 350, //set editable area's height
        placeholder: 'Ketikan sesuatu disini...',
        codemirror: { // codemirror options
          theme: 'monokai'
        }
      })
    })

    $('#modal-add').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var modal = $(this)
    })

        $('#modal-add-category').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })


        
        $('#modal-add-tags').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)
        })

        $(document).ready(function() {
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
        });
  </script>
</body>

</html>