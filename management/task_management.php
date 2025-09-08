<!DOCTYPE html>
<?php include 'view/common/first_validation.php'; ?>
<?php 

$id_dg_event = 0;
if(isset($_GET['id'])){
  $id_dg_event = $_GET['id'];
}
$tanggal = 0;
if(isset($_GET['tanggal'])){
  $tanggal = $_GET['tanggal'];
}
$x = 0;
if(isset($_GET['x'])){
  $x = $_GET['x'];
}


?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management Article | DIK Group</title>

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
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- icon -->
    <link rel="icon" href="dist/img/icon.png">
    <style>
        .none {
            display: none;
        }

        .dtr-data {
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

        .input-group{
          min-width: 200px;
        }

        .dropdown-menu{
          z-index: 999;
        }

        .bootstrap-datetimepicker-widget {
            position: absolute;
            z-index: 9999 !important;
        }



        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
          .taskTableAdd{
            overflow: none;
          }
          .taskTable{
            overflow: none;
          }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
          .taskTableAdd{
            overflow: scroll;
          }
          .taskTable{
            overflow: scroll;
          }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">




  <div class="wrapper">
    <!-- Navbar -->
    <?php include "./view/common/navbar.php" ?>

    <?php include "./view/common/aside.php" ?>



    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">

            <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Task Add</h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <!-- Tabel No, Task, Owner Task, Delete -->
                  <div class="col-sm-12">
                    <div class="col-sm-12 taskTableAdd">
                      <table id="taskTableAdd" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="min-width: 250px;">Task</th>
                            <th style="min-width: 150px;">Owner Task</th>
                            <th style="min-width: 150px;">Deadline</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><input type="text" name="task_add" style="min-width: 200px;" class="form-control"></td>
                            <td>
                              <select class="form-control owner-select select2" name="owner_add" style="width: 100%;">
                                <option value="">-- Select Owner --</option>
                                <?php
                                      $result_user = mysqli_query($db2, "SELECT * FROM dg_user
                                      where deleted_at is null and status<5");
                                            while ($row = mysqli_fetch_assoc($result_user)) {
                                              echo '<option value="'.$row['id_dg_user'].'">'.$row['nama'].'</option>';
                                            }
                                      ?>
                              </select>
                            </td>
                            <td style="text-align: center; width: 25%;">
                              <div class="input-group date col-sm-12" id="reservationdate_add" data-target-input="nearest">
                                <input type="text" name="deadline_add"
                                  class="form-control datetimepicker-input deadline_add" data-target="#reservationdate_add"
                                  value="">
                                <div class="input-group-append" data-target="#reservationdate_add"
                                  data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-12 col-md-6"></div>
                      <div class="col-12 col-md-6">
                        <button type="button" id="saveTask" class="btn btn-success" style="width: 100%; float: right;">
                          <i class="fa fa-save"></i> Save Task</button>
                      </div>
                    </div>
                  </div>

                  <br><br>

                </div>

              </div>
            </div>



            <div class="card card-outline card-info">
              <div class="card-header">
                <h3 class="card-title">Task List</h3>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <!-- Tabel No, Task, Owner Task, Delete -->
                  <div class="col-sm-12">
                    <div class="col-sm-12 taskTable">
                      <table id="taskTable" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="text-align: center; width: 10%;">No</th>
                            <th style="min-width: 250px;">Task</th>
                            <th style="min-width: 150px;">Owner Task</th>
                            <th style="min-width: 150px;">Deadline</th>
                            <th style="min-width: 150px;">Status</th>
                            <th style="text-align: center;">Delete</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                    <p style="text-align: left; font-size: 15px; margin-left: 15px; margin-top: 15px;">Notes: <br>
                      1. Task dengan status yang belum Done / Cancel, akan terus dimunculkan diatas.<br>
                      2. Task dengan status Done akan muncul selama 7 hari setelah Done di-klik.<br>
                      3. Task yang di Cancel akan langsung menghilang, namun muncul di Dashboard user nya.<br>
                      4. Mengedit status dapat dilakukan pada halaman Dashboard masing-masing user.
                    </p>

                  </div>

                  <br><br>

                </div>

              </div>
            </div>


          </div>
        </div>



      </section>
      <!-- /.content -->

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js" type="text/javascript">
    </script>
    <script src="plugins/autoNumeric/src/main.js" type="text/javascript"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
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
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>


  <script>

  $(document).ready(function () {
    
      // Inisialisasi variabel interval
      let loadTasksInterval;
      let isFocused = false;
      let id_dg_user_t = "";

      function loadTasks() {
        if (!isFocused) {
            $.ajax({
                url: 'view/calendar/load_tasks.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#taskTable tbody').empty();
                    $.each(data.tasks, function(index, task) {
                        let taskRow = `
                            <tr>
                                <td style="text-align: center;">${index + 1}</td>
                                <td>
                                    <input type="text" class="form-control" name="task_${task.id_dg_event_detail_task}" value="${task.isi_task}">
                                </td>
                                <td>
                                    <select class="form-control owner-select" name="owner_${task.id_dg_event_detail_task}" id="owner_${task.id_dg_event_detail_task}">
                                        <option value="">-- Select Owner --</option>
                                        <?php
                                            $result_user = mysqli_query($db2, "SELECT * FROM dg_user WHERE deleted_at IS NULL AND status < 5");
                                            while ($row = mysqli_fetch_assoc($result_user)) {
                                                echo '<option value="'.$row["id_dg_user"].'">'.$row['nama'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td style="text-align: center; width: 25%;">
                                    <div class="input-group date" id="reservationdate_${task.id_dg_event_detail_task}" data-target-input="nearest">
                                        <input type="text" name="deadline_${task.id_dg_event_detail_task}" class="form-control datetimepicker-input deadline_${task.id_dg_event_detail_task}" data-target="#reservationdate_${task.id_dg_event_detail_task}" value="${task.deadline_task}">
                                        <div class="input-group-append" data-target="#reservationdate_${task.id_dg_event_detail_task}" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    ${task.status_task === 0 ? "Open" : task.status_task === 1 ? "On Progress" : task.status_task === 2 ? "Cancel" : "Done"}
                                </td>
                                <td style="text-align: center;">
                                    <button <?php if($priv !=1 ){echo "disabled"; } ?> type="button" class="btn btn-danger delete-row-btn" data-id="${task.id_dg_event_detail_task}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>`;

                        // Tambahkan row ke tabel
                        $('#taskTable tbody').append(taskRow);

                        // Setelah elemen ditambahkan ke DOM, atur nilai dropdown
                        setTimeout(() => {
                            let selectElement = document.querySelector(`#owner_${task.id_dg_event_detail_task}`);
                            if (selectElement) {
                                selectElement.value = task.owner_id; // Atur nilai sesuai owner_id
                            }
                        }, 100); // Tunggu sedikit agar elemen sudah ada
                    });
                },
                error: function() {
                    toastr.error("Failed to load tasks.");
                }
            });
        }
    }


    // Fungsi AJAX untuk memperbarui deadline task
    function updateTaskDeadline(taskId, deadline) {
        $.ajax({
            url: 'view/calendar/conn_update_task.php',
            type: 'POST',
            data: {
                id_dg_event_detail_task: taskId,
                deadline: deadline,
                change: 1
            },
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    loadTasks();
                    toastr.success("Deadline updated successfully.");
                } else {
                    toastr.error("Failed to update deadline.");
                }
            },
            error: function() {
                toastr.error("An error occurred while updating the deadline.");
            }
        });
    }
    
    loadTasks();

    // // Fungsi untuk memulai interval pengambilan data
    // function startLoadTasks() {
    //     loadTasksInterval = setInterval(loadTasks, 5000); // Refresh setiap 5 detik
    // }

    // // Menghentikan interval loadTasks
    // function stopLoadTasks() {
    //     clearInterval(loadTasksInterval);
    // }

    // // Mulai interval saat halaman selesai dimuat
    // startLoadTasks();

    // Menangani focus dan blur pada elemen input dan select di taskTable
    $('#taskTable').on('focus', 'input, select', function() {
        isFocused = true;
        stopLoadTasks(); // Hentikan interval saat input/select mendapatkan fokus
    });

    $('#taskTable').on('blur', 'input, select', function() {
        isFocused = false;
        startLoadTasks(); // Mulai ulang interval saat input/select kehilangan fokus
    });


        // Fungsi untuk menghapus task saat tombol delete diklik
        $(document).on('click', '.delete-row-btn', function() {
          var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol delete

            // Nonaktifkan semua tombol delete selama 2 detik setelah diklik
            $('.delete-row-btn').prop('disabled', true);
            setTimeout(function() {
                $('.delete-row-btn').prop('disabled', false); // Aktifkan kembali semua tombol delete setelah 2 detik
            }, 3000);

            var taskId = $(this).data('id'); // Mendapatkan id task dari atribut data-id pada tombol delete
            $.ajax({
                url: 'view/calendar/conn_delete_task.php', // URL endpoint untuk menghapus task
                type: 'POST',
                data: { id: taskId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        loadTasks();
                        toastr.success("Task successfully deleted.");
                    } else {
                        toastr.error("Failed to delete task.");
                    }
                },
                error: function() {
                    toastr.error("Error deleting task.");
                }
            });
        });

        $('#saveTask').on('click', function() {

            var $this = $(this);

            // Disable tombol dan atur timeout untuk re-enable
            $this.prop('disabled', true); // Menonaktifkan tombol


            var task = $('input[name="task_add"]').val();
            var owner = $('select[name="owner_add"]').val();
            var deadline = $('input[name="deadline_add"]').val();

            if (task && owner && deadline) {
                // Parsing tanggal dari format "DD-MMMM-YYYY" ke "YYYY-MM-DD"
                var parts = deadline.split('-');
                var day = parts[0];
                var month = new Date(Date.parse(parts[1] + " 1, 2023")).getMonth() + 1; // Mengambil bulan dari nama
                var year = parts[2];
                var formattedDeadline = `${year}-${month.toString().padStart(2, '0')}-${day.padStart(2, '0')}`;
                var id_dg_event_detail = 1;
                var id_user = <?php echo $id_user; ?>;

                $.ajax({
                    url: 'view/calendar/conn_save_task.php',
                    type: 'POST',
                    data: {
                        id_dg_event_detail: id_dg_event_detail,
                        task: task,
                        owner: owner,
                        deadline: formattedDeadline,
                        id_user: id_user
                    },
                    success: function(response) {
                      if (response.trim() === "") {
                          toastr.error("Empty response from server. Check PHP script for errors.");
                          console.log("Empty response received from PHP.");
                          return;
                      }
                      try {
                          var res = JSON.parse(response);
                          if (res.success) {
                              loadTasks();
                              toastr.success('Task saved successfully.');
                              setTimeout(function() {
                                  $this.prop('disabled', false); // Mengaktifkan kembali tombol setelah 2 detik
                              }, 2000);

                              // Reset input setelah berhasil menyimpan
                              $('input[name="task_add"]').val('');
                              $('select[name="owner_add"]').val('').trigger('change');
                              $('input[name="deadline_add"]').val('');
                              
                          } else {
                              toastr.error('Failed to save task: ' + (res.error || 'Unknown error'));
                          }
                      } catch (e) {
                          toastr.error('Failed to parse JSON response.');
                          console.log("Error parsing JSON:", response);
                      }
                  },
                  error: function(xhr) {
                      toastr.error('AJAX request failed: ' + xhr.responseText);
                      console.log("Error response from PHP:", xhr.responseText);
                  }

                });
            } else {
                toastr.warning('Please fill in all fields before saving.');
            }
        });


         // Event onChange untuk kolom Task, Owner, dan Deadline
          $('#taskTable').on('change', 'input, select', function () {
              const row = $(this).closest('tr');
              const id = row.find('.delete-row-btn').data('id'); // Ambil ID task
              const task = row.find('input[name^="task_"]').val(); // Ambil nilai dari kolom Task
              const owner = row.find('select[name^="owner_"]').val(); // Ambil nilai dari kolom Owner
              
              // Mengambil nilai deadline dari datepicker
              const deadline = row.find('input[name^="deadline_"]').val();
              console.log("deadline: "+deadline);
              var parts = deadline.split('-');
              var day = parts[0];
              var month = new Date(Date.parse(parts[1] + " 1, 2023")).getMonth() + 1; // Mengambil bulan dari nama
              var year = parts[2];
              var formattedDeadline = `${year}-${month.toString().padStart(2, '0')}-${day.padStart(2, '0')}`;

              // Debug: Log data yang akan dikirim
              console.log("Updating task with ID:", id);
              console.log("Task:", task);
              console.log("Owner:", owner);
              console.log("Formatted Deadline:", formattedDeadline);

              // AJAX untuk meng-update data
              $.ajax({
                  url: 'view/calendar/conn_update_task.php', // URL untuk proses update
                  type: 'POST',
                  data: {
                      id_dg_event_detail_task: id,
                      task: task,
                      owner: owner,
                      deadline: formattedDeadline
                  },
                  success: function (response) {
                      const result = JSON.parse(response);
                      if (result.success) {
                          loadTasks();
                          toastr.success("Task updated successfully.");
                      } else {
                          toastr.error("Failed to update task.");
                      }
                  },
                  error: function () {
                      toastr.error("An error occurred while updating the task.");
                  }
              });
          });



    });


    $(function () {   


      $("#taskTable").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "sorting": false,
        "buttons": false,
        "pageLength": false,
        "bInfo" : false,
        "searching": false
      });

      $("#taskTableAdd").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "sorting": false,
        "buttons": false,
        "pageLength": false,
        "bInfo" : false,
        "searching": false
      });
      

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

      //Money Euro
      $('[data-mask]').inputmask()

      $('#reservationdate_add').datetimepicker({
          format: 'DD-MMMM-yyyy',
          showTodayButton: true, // Menampilkan tombol 'Today'
          icons: {
              today: 'fa fa-calendar-day', // Ikon untuk tombol 'Today'
          },
          buttons: {
              showToday: true
          }
      });
      // Trigger datetimepicker saat input text diklik
      $('.deadline_add').on('focus click', function() {
        $('#reservationdate_add').datetimepicker('show');
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

      //Timepicker
      $('#timepicker').datetimepicker({
          format: 'DD/MM/YYYY'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()
    });

   


    
    function toggleCard(element) {
      // Cari elemen card utama
      const card = element.closest('.card');
      // Aktifkan event collapse dari data-card-widget
      $(card).CardWidget('toggle');
    }


            
    checkConnection();
    setInterval(checkConnection, 3000); // Cek setiap 3 detik
   

  </script>
</body>

</html>