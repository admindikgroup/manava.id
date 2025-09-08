<!DOCTYPE html>

<?php include 'view/common/first_validation.php'; ?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Report</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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
        .select2-container--default .select2-selection--single {
            height: 38px;
        }
        /* CSS untuk menyembunyikan tombol X pada modal Summernote */
        .note-modal .close {
            display: none !important;
        }

        /* Untuk tampilan PC (lebih besar dari 1024px) */
        @media (min-width: 1025px) {
            .modal-dialog{
                min-width: 1000px !important;
            }
            .btn-success {
                right: 0px; 
                width: 150px; 
                margin-top: 10px; 
                margin-right: 20px;
            }
            .row-hg{
                height: 30px;
            }
            .date-awal{
                margin: 10px; 
                margin-left: 20px;
            }
        }

        /* Untuk tampilan tablet dan HP (kurang dari atau sama dengan 1024px) */
        @media (max-width: 1024px) {
            .btn-success { 
                width: 100%;
            }
            .row-hg{
                height: 150px;
            }
            .pd-bt{
                padding-left: 30px;
                padding-right: 30px;
            }
            .date-awal{
                margin: 10px; 
                margin-left: 10px;
            }
        }



    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">



    

    <div class="modal fade" id="modal-delete-event">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">ATTENTION !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Event?<br>
                        Event Name &nbsp; : <b id="nama_event_delete"></b><br>
                </div>
                
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="id_dg_event_delete" id="id_dg_event_delete" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" onClick="deleteDataEvent()" class="btn btn-danger">Yes</button>
                    </div>
               
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- Modal Pilihan Bulan dan Tahun -->
    <div class="modal fade" id="modal-post" tabindex="-1" role="dialog" aria-labelledby="modalPostLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 200px !important; max-width: 500px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPostLabel">Select Posting Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Dropdown untuk Bulan -->
                    <div class="form-group">
                        <label for="bulan">Periode Posting</label>
                        <input type="month" class="form-control selectBulanTahun" name="selectBulanTahun" id="selectBulanTahun">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn-post">Post</button>
                </div>
            </div>
        </div>
    </div>


    



    <div class="wrapper">
        <?php include "./view/common/navbar.php" ?>

        <?php include "./view/common/aside.php" ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12">
                            <h1 class="m-0">Attendance Report</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">



                    <div class="row">
                        <div class="col-12 form-group">
                            <div style="margin: 10px;" >
                                <div class="form-group row">
                                    <label for="nama_team2" class="col-12 col-form-label">Event Name</label>
                                        <select class="select2 form-control" id="namaEvent" name="namaEvent[]" multiple>
                                            <option value="" disabled>-- Select Event --</option>
                                            <?php 
                                                $result_head = mysqli_query($db2, "SELECT * FROM `dg_event`");
                                                while ($d_head = mysqli_fetch_array($result_head)) {
                                                    $id_dg_event = $d_head['id_dg_event'];
                                            ?>
                                                <option value="<?php echo $d_head['id_dg_event']; ?>"><?php echo $d_head['nama_event']; ?></option>
                                            <?php } ?>
                                        </select>

                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-6">
                                        <label for="fee_offline" class="col-12 col-form-label">Fee Offline</label>
                                        <input type="text" data-a-sign="" data-a-sep="." onChange="loadAbsensiTable()"
                                        style="text-align: right;" name="fee_offline" class="col-12 fee_offline form-control"
                                        placeholder="Rp. Harga Fee Offline" autocomplete="off" value="40000" min="0">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="fee_online" class="col-12 col-form-label">Fee Online</label>
                                        <input type="text" data-a-sign="" data-a-sep="." onChange="loadAbsensiTable()"
                                        style="text-align: right;" name="fee_online" class="col-12 fee_online form-control"
                                        placeholder="Rp. Harga Fee Online" autocomplete="off" value="10000" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="row row-hg">
                                    <div class="col-md-3 col-12">
                                        <div class="date-awal">
                                            <div class="input-group date" id="datetimepicker_awal" data-target-input="nearest">
                                                <input type="text" name="date_awal" class="form-control datetimepicker-input" data-target="#datetimepicker_awal"/>
                                                <div class="input-group-append" data-target="#datetimepicker_awal" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-12 d-none d-md-block">
                                        <div style="text-align: center;margin: 10px;font-size: 30px;" >-</div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div style="margin: 10px;" >
                                            <div class="input-group date" id="datetimepicker_akhir" data-target-input="nearest">
                                                <input type="text" name="date_akhir" class="form-control datetimepicker-input" data-target="#datetimepicker_akhir"/>
                                                <div class="input-group-append" data-target="#datetimepicker_akhir" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12 form-group pd-bt">
                                        <button class="btn btn-success float-sm-right" data-toggle="modal"
                                            data-target="#modal-post" data-backdrop="static" data-keyboard="false">
                                            Post Data
                                        </button>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body" id="tableAbsensi">
                                    <div class="" style="overflow: auto;">
                                        <table id="example1" class="table table-bordered table-striped" style="width: 100%; font-size: 12px; width: 100%;">

                                        </table>
                                    </div>
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
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(document).ready(function () {
            // Set default bulan dan tahun
            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1; // Bulan dimulai dari 0, jadi ditambah 1
            const currentYear = currentDate.getFullYear();

            // Tentukan nilai default untuk input month
            const defaultMonth = currentMonth < 10 ? '0' + currentMonth : currentMonth; // Pastikan bulan dua digit
            const defaultDate = `${currentYear}-${defaultMonth}`;

            // Set default value pada input month
            $('#selectBulanTahun').val(defaultDate);

            // Tentukan batasan untuk memilih bulan (tidak lebih dari 1 bulan ke belakang)
            const twoMonthsAgo = new Date();
            twoMonthsAgo.setMonth(currentDate.getMonth());
            const minYear = twoMonthsAgo.getFullYear();
            const minMonth = twoMonthsAgo.getMonth() + 1; // Bulan dimulai dari 0, jadi ditambah 1

            // Format tanggal min ke dalam format YYYY-MM untuk input type="month"
            const minDate = `${minYear}-${minMonth < 10 ? '0' + minMonth : minMonth}`;

            // Set atribut min pada input month
            $('#selectBulanTahun').attr('min', minDate);

            // Event handler untuk tombol Post
            $('#btn-post').click(function () {
                const selectedBulanTahun = $('#selectBulanTahun').val();
                const selectedEvents = $('#namaEvent').val(); // Mengambil ID event yang dipilih
                const startDateRaw = $('input[name="date_awal"]').val();
                const endDateRaw = $('input[name="date_akhir"]').val();

                // Format tanggal dari "DD-MMMM-YYYY" ke "YYYY-MM-DD"
                const startDate = moment(startDateRaw, "DD-MMMM-YYYY").format("DD MMMM YYYY");
                const endDate = moment(endDateRaw, "DD-MMMM-YYYY").format("DD MMMM YYYY");

                if (selectedBulanTahun && selectedEvents) {
                    // Mengubah format menjadi Bulan Tahun (MMMM-YYYY)
                    const date = new Date(selectedBulanTahun + "-01"); // Tambahkan tanggal untuk konversi
                    const bulan = date.toLocaleString('id-ID', { month: 'long' }); // Format bulan dalam bahasa Indonesia
                    const bulanNo = date.getMonth() + 1; // Menambahkan 1 karena getMonth() dimulai dari 0
                    const tahun = date.getFullYear();
                    const formattedBulanTahun = `${bulan} ${tahun}`;
                    const formattedTahunBulan = `${tahun}-${bulanNo}`;

                    // Konfirmasi sebelum posting data
                    if (confirm(`Are you sure you want to post data for the ${formattedBulanTahun} RAB period??`)) {
                        // Ambil data Total Fee dari tabel
                        const postData = [];
                        $('#example1 tbody tr').each(function () {
                            const idUser = $(this).data('id-user'); // Ambil ID User dari atribut data-id-user
                            const totalFee = $(this).find('td:last').text().replace(/[^\d]/g, ''); // Ambil kolom Total Fee
                            if (idUser && totalFee) {
                                postData.push({
                                    id_dg_user: idUser,
                                    total_fee: parseInt(totalFee, 10),
                                });
                            }
                        });

                        // Kirim data melalui AJAX
                        $.ajax({
                            url: 'view/ajax/post_total_fee.php', // Ganti dengan URL PHP yang sesuai
                            method: 'POST',
                            data: {
                                id_event: selectedEvents,
                                periode: formattedTahunBulan,
                                startDate: startDate,
                                endDate: endDate,
                                id_user: <?php echo $id_user; ?>,
                                data: postData,
                            },
                            success: function (response) {
                                console.log(response); // Tampilkan respons dari server
                                toastr.success('Data successfully posted!');
                                $('#modal-post').modal('hide'); // Tutup modal
                            },
                            error: function(xhr, status, error) {
                                toastr.error('An error occurred while posting data.'+error);
                            },
                        });
                    }
                } else {
                    toastr.success("Please select the period and event first.");
                }
            });

        });




        new AutoNumeric('.fee_offline', {
            allowDecimalPadding: false,
            decimalCharacter: ',',
            digitGroupSeparator: '.',
            minimumValue: "0",
            decimalPlaces: 6
        });

        new AutoNumeric('.fee_online', {
            allowDecimalPadding: false,
            decimalCharacter: ',',
            digitGroupSeparator: '.',
            minimumValue: "0",
            decimalPlaces: 6
        });
            


            // Inisialisasi datetimepicker
            $('#datetimepicker_awal').datetimepicker({
                format: 'DD-MMMM-YYYY',
                defaultDate: moment()
            });

            $('#datetimepicker_akhir').datetimepicker({
                format: 'DD-MMMM-YYYY',
                defaultDate: moment()
            });

            $('#namaEvent').on('change', function () {
                loadAbsensiTable();
            });

            $('#datetimepicker_awal, #datetimepicker_akhir').on('change.datetimepicker', function () {
                loadAbsensiTable();
            });


            function loadAbsensiTable() {
                const eventIds = $('#namaEvent').val(); // Mengambil semua ID event yang dipilih sebagai array
                const startDateRaw = $('input[name="date_awal"]').val();
                const endDateRaw = $('input[name="date_akhir"]').val();

                // Format tanggal dari "DD-MMMM-YYYY" ke "YYYY-MM-DD"
                const startDate = moment(startDateRaw, "DD-MMMM-YYYY").format("YYYY-MM-DD");
                const endDate = moment(endDateRaw, "DD-MMMM-YYYY").format("YYYY-MM-DD");

                if (!eventIds || !startDate || !endDate) {
                    $('#example1').html('<tr><td colspan="100%">Please select event and date range.</td></tr>');
                    return;
                }

                // AJAX request
                $.ajax({
                    url: 'view/ajax/load_absensi.php',
                    method: 'POST',
                    data: {
                        id_event: eventIds, // Kirim array ID event
                        start_date: startDate,
                        end_date: endDate,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            let tableHeader = '<tr><th style="min-width: 100px;">Nama User</th>';
                            response.dates.forEach(date => {
                                const formattedDate = moment(date, "YYYY-MM-DD").format("D MMM YY");
                                tableHeader += `<th style="text-align: right; min-width: 100px;">${formattedDate}</th>`;
                            });
                            tableHeader += '<th style="text-align: right; min-width: 150px;">Total Offline</th><th style="text-align: right; min-width: 100px;">Total Online</th><th style="text-align: right; min-width: 100px;">Total Fee</th></tr>';

                            let tableBody = '';

                            response.users.forEach(user => {
                                let totalOffline = 0;
                                let totalOnline = 0;

                                let totalPengeluaran = 0;

                                let countOffline = 0;
                                let countOnline = 0;

                                let feeOffline = 0;
                                let feeOnline = 0;

                                let tambahan_fee_offlineC = 0;
                                let tambahan_fee_onlineC = 0;


                                tableBody += `<tr data-id-user="${user.id}"><td>${user.name}</td>`;
                                response.dates.forEach(date => {
                                    const status = user.attendance[date] || 0; // Default: Alpha
                                    const pengeluaran = user.pengeluaran[date] || 0;

                                    const tambahan_fee_offline = user.tambahan_fee_offline[date] || 0;
                                    const tambahan_fee_online = user.tambahan_fee_online[date] || 0;

                                    let feeOffline = parseInt($('.fee_offline').val().replace(/\./g, '')) || 0;
                                    let feeOnline = parseInt($('.fee_online').val().replace(/\./g, '')) || 0;



                                    feeOffline = feeOffline + tambahan_fee_offline;
                                    feeOnline = feeOnline + tambahan_fee_online;

                                    // Hitung fee offline dikurangi pengeluaran
                                    let adjustedFee = 0;
                                    if (status === 1) { // Hadir Offline
                                        adjustedFee = feeOffline - pengeluaran;
                                        totalPengeluaran = totalPengeluaran + pengeluaran;
                                        totalOffline += adjustedFee;
                                        countOffline++;
                                    } else if (status === 2) { // Hadir Online
                                        totalOnline += feeOnline;
                                        countOnline++;
                                    }

                                    let finalFee = 0;

                                    // Hitung berdasarkan status kehadiran
                                    if (status === 1) { // Hadir Offline
                                        finalFee = feeOffline - pengeluaran;
                                    } else if (status === 2) { // Hadir Online
                                        finalFee = feeOnline;
                                    }

                                    // Format angka untuk tampilan
                                    const formattedFee = finalFee.toLocaleString('id-ID');
                                    tableBody += `<td style="text-align: right;">${getAttendanceLabel(status)}<br>Rp. ${formattedFee}</td>`;

                                    tambahan_fee_offlineC = tambahan_fee_offline;
                                    tambahan_fee_onlineC = tambahan_fee_online;


                                });

                                let feeOfflineC = parseInt($('.fee_offline').val().replace(/\./g, '')) || 0;
                                let feeOnlineC = parseInt($('.fee_online').val().replace(/\./g, '')) || 0;

                                feeOfflineC = feeOfflineC + tambahan_fee_offlineC;
                                feeOnlineC = feeOnlineC + tambahan_fee_onlineC;

                                const totalFee = totalOffline + totalOnline;
                                tableBody += `<td style="text-align: right;"><b>(${countOffline} X ${formatRupiah(feeOfflineC)}) - ${formatRupiah(totalPengeluaran)}<br>= Rp. ${formatRupiah(totalOffline)}</br></td>`;
                                tableBody += `<td style="text-align: right;"><b>(${countOnline} X ${formatRupiah(feeOnlineC)}) <br>= Rp. ${formatRupiah(totalOnline)}</b></td>`;
                                tableBody += `<td style="text-align: right;"><b>Rp. ${formatRupiah(totalFee)}</b></td>`;
                                tableBody += '</tr>';
                            });

                            $('#example1').html(`<thead>${tableHeader}</thead><tbody>${tableBody}</tbody>`);
                        } else {
                            $('#example1').html('<tr><td colspan="100%">No data available.</td></tr>');
                        }
                    },
                    error: function () {
                        $('#example1').html('<tr><td colspan="100%">Error loading data.</td></tr>');
                    },
                });
            }


            function formatRupiah(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            function getAttendanceLabel(status) {
                switch (parseInt(status)) {
                    case 1: return 'On-Site';
                    case 2: return 'Remote';
                    case 3: return 'Leave';
                    case 4: return 'Sick';
                    default: return 'Unexcused';
                }
            }


        $(document).ready(function () {
            // Cek koneksi
            checkConnection();
            setInterval(checkConnection, 1000); // Cek setiap 1 detik
 
            $('#namaEvent').select2({
                placeholder: "-- Pilih Event --",
                allowClear: true
            });
        });

       








        // Event listener untuk menambahkan tombol "Close" ke modal Summernote saat modal ditampilkan
        $(document).on('shown.bs.modal', '.note-modal', function() {
            var modal = $(this);
            
            // Periksa apakah tombol "Close" sudah ada untuk menghindari penambahan ganda
            if (modal.find('.custom-close').length === 0) {
                // Tambahkan tombol "Close" di footer modal
                modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary custom-close">Close</button>');
                
                // Event handler untuk tombol "Close"
                modal.find('.custom-close').on('click', function() {
                    modal.modal('hide'); // Menutup modal Summernote
                });
            }
        });





    </script>
</body>

</html>