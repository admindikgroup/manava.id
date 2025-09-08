<?php 
// mengaktifkan session
session_start();
include '../../controller/conn.php';
$id_user_team = $_GET['id_user_team'];
$id_dg_project = $_GET['id_dg_project'];
$id_user = $_GET['id_user'];
$id_division = $_GET['id_division'];

?>    
<div class="row">
    
    <div class="col-6" style="padding-right: 20px;">

        <div class="form-group row">
            <label for="jabatan2" class="col-sm-12 col-form-label">Nama Jabatan</label>
            <div class="col-sm-12">
                <select class="form-control select jabatan2" style="width: 100%;" name="jabatan2" id="jabatan2">
                    <option selected disabled value="">-Pilih Nama Jabatan-</option>    
                    <?php 
                        $result_team = mysqli_query($db2,"SELECT * 
                        FROM dg_client_project_team cpt 
                        JOIN dg_job j ON cpt.id_dg_job = j.id_dg_job
                        WHERE id_dg_client_project = $id_dg_project and id_dg_user = $id_user_team");
                        while($d_team = mysqli_fetch_array($result_team)){
                    ?>
                    <option value="<?php echo $d_team['id_dg_job']; ?>"><?php echo $d_team['job_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="komponenProject" class="col-sm-12 col-form-label">Komponen Pekerjaan</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="komponenProject" name="komponenProject"
                    onchange="updateTableValues()"
                    placeholder="Ketikan Komponen Pekerjaan" value="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="jumlahKomponen" class="col-sm-12 col-form-label">Jumlah Komponen</label>
            <div class="col-sm-12">
                <input type="number" id="jumlahKomponen" style="text-align: right;" 
                    name="jumlahKomponen" class="form-control" onchange="updateTableValues()"
                    placeholder="Jumlah Komponen" value="1" min=0 required>
            </div>
        </div>


    </div>

    <div class="col-6" style="padding-left: 20px;">

       <div class="form-group row">
            <label for="hargaModal" class="col-sm-12 col-form-label">Harga Modal per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaModal" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaModal" class="form-control"
                    placeholder="Rp. Harga Modal" autocomplete="off" value="" min=0 required>
            </div>
        </div>

        <div class="form-group row">
            <label for="hargaJual" class="col-sm-12 col-form-label">Harga Jual per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaJual" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaJual" class="form-control"
                    placeholder="Rp. Harga Jual" autocomplete="off" value="" min=0 required>
            </div>
        </div>


        <div class="form-group row">
            <label for="hargaDiscount" class="col-sm-12 col-form-label">Discount dari Total Jual</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaDiscount" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaDiscount" class="form-control"
                    placeholder="Rp. Harga Discount Jual" autocomplete="off" value="0" min=0 required>
            </div>
        </div>


    </div>

</div>
<hr>
<div class="row">
    
    <table class="table table-bordered table-striped" style="font-size: 15px;">
        <thead>
            <tr>
                <th style="width: 25%;">Nama Komponen</th>
                <th colspan="3" id="tableNamaKomponen" style="width: 75%; text-align: left;">-</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>Harga Modal per Komponen</td>
                <td id="tableHargaKomponen" style="text-align: right;">Rp 0</td> 
                <td>Harga Jual per Komponen</td>
                <td id="tableHargaJualKomponen" style="text-align: right;">Rp 0</td> 
            </tr>
            <tr>
                <td>Jumlah Komponen</td>
                <td id="tableJumlahKomponen" style="text-align: right;">0</td> 
                <td>Jumlah Komponen</td> 
                <td id="tableJumlahKomponen2" style="text-align: right;">0</td> 
            </tr>
            <tr>
                <td><b>Total Harga Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaKomponen">Rp 0</b></td>
                <td><b>Total Harga Jual Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaJualKomponen">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"><b>Harga Jual - Harga Modal</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableHarga">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b style="color: red;">Discount</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableDiscount" style="color: red;">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b>Total Keuntungan</b></td>
                <td  colspan="2" style="text-align: right;"><b id="tableKeuntungan">Rp 0</b></td> 
            </tr>
            

        </tbody>
    </table>

</div>
<hr>
<div class="row">
    
<table id="table-rab" class="table table-bordered table-striped" style="font-size: 15px;">
    <thead>
        <tr>
            <th style="width: 20%;">Bulan</th>
            <th style="width: 20%; text-align: right;">Harga Fee</th>
            <th style="width: 5%; text-align: center;">Clear</th>
        </tr>
    </thead>
    <tbody id="tbody-rab">
        <tr>
            <td>
                <input type="month" class="form-control selectBulanTahun" name="selectBulanTahun[]">
            </td>
            <td style="text-align: right;">
                <input type="text" data-a-sign="" data-a-sep="." onchange="updateTableValues()"
                style="text-align: right;" name="hargaFee[]" class="hargaFee form-control"
                placeholder="Rp. Harga Fee" autocomplete="off" value="0" min="0" required>
            </td>
            <td style="text-align: center;">
                <button class="btn btn-danger removeRowBtn" style="width: 30px;">x</button>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="row">
                    <hr style="width: 80%;"><button  id="addRowBtn" style="width: 15%;" type="button" class="btn btn-success">+</button>
                </div>
            </td>
        </tr>
        <tr>
            <td><b>Total Fee</b></td>
            <td style="text-align: right;"><b id="totalFee">Rp 0</b></td> 
            <td></td>
        </tr>
        <tr style="display: none;" id="rowSelisih">
            <td><b style ="color:red;">Selisih Fee</b></td>
            <td style="text-align: right;"><b style ="color:red;" id="selisihFee">Rp 0</b></td> 
            <td></td>
        </tr>
    </tbody>
</table>


</div>
<script>

// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn");
// Ambil semua elemen input dengan kelas hargaFee
var inputs = document.querySelectorAll('.hargaFee');

// Iterasi melalui setiap elemen input dan terapkan AutoNumeric
inputs.forEach(function(input) {
    new AutoNumeric(input, {
        allowDecimalPadding: false,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        minimumValue: "0",
        decimalPlaces: 6
    });
});

$(document).ready(function() {
    // Ambil elemen input selectBulanTahun
    var selectBulanTahun = $('.selectBulanTahun');

    // Buat objek Date untuk bulan saat ini
    var currentDate = new Date();
    var currentDay = currentDate.getDate(); // Ambil tanggal saat ini

    // Jika tanggal >= 5, tambahkan satu bulan, jika tidak, tetap di bulan ini
    if (currentDay < 5 && <?php echo $_SESSION['priv']; ?> == 1) {
        currentDate.setMonth(currentDate.getMonth());
    }else{
        currentDate.setMonth(currentDate.getMonth() + 1);
    }


    // Dapatkan tahun dan bulan baru
    var newYear = currentDate.getFullYear();
    var newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Gabungkan tahun dan bulan baru menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Atur nilai input selectBulanTahun menjadi bulan berikutnya dari sekarang
    selectBulanTahun.val(nextMonth);

    // Set nilai minimum untuk input month
    var minDate = newYear + '-' + newMonth;
    selectBulanTahun.attr('min', minDate);

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisih(selisihFee !== 0);

    // Tambahkan event listener ke tombol "x" untuk menghapus baris
    $('.removeRowBtn').click(function() {
        $(this).closest('tr').remove(); // Hapus baris <tr> terdekat saat tombol "x" ditekan
        updateSelisihFee(); // Perbarui nilai selisih fee setelah baris dihapus
    });
});





// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn");

// Tambahkan event listener ke tombol "+" untuk menambahkan baris baru ke tabel
addButton.addEventListener("click", function() {
    // Dapatkan semua input bulan
    var monthInputs = document.querySelectorAll('.selectBulanTahun');

    // Dapatkan nilai bulan terakhir
    var lastMonthInput = monthInputs[monthInputs.length - 1];
    
    // Periksa jika lastMonth tidak memiliki nilai
    if (typeof lastMonthInput === 'undefined' || !lastMonthInput.value) {
        // Buat objek Date untuk bulan saat ini
        var currentDate = new Date();
        currentDate.setDate(1);

        // Dapatkan tahun dan bulan baru
        var newYear = currentDate.getFullYear();
        var newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

        // Atur lastMonthDate ke bulan saat ini
        lastMonthDate = new Date(newYear + '-' + newMonth);
    }else{

        var lastMonth = lastMonthInput.value;

        // Ubah nilai bulan terakhir menjadi objek Date
        var lastMonthDate = new Date(lastMonth);
    }



    

    // Tambahkan satu bulan ke nilai bulan terakhir
    lastMonthDate.setMonth(lastMonthDate.getMonth() + 1);

    // Dapatkan tahun dan bulan baru
    var newYear = lastMonthDate.getFullYear();
    var newMonth = (lastMonthDate.getMonth() + 1).toString().padStart(2, '0');

    // Gabungkan tahun dan bulan menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Buat elemen input untuk bulan
    var monthInput = document.createElement('input');
    monthInput.type = 'month';
    monthInput.className = 'form-control selectBulanTahun';
    monthInput.name = 'selectBulanTahun[]';
    monthInput.value = nextMonth;

    // Buat elemen input untuk harga fee
    var hargaFeeInput = document.createElement('input');
    hargaFeeInput.type = 'text';
    hargaFeeInput.className = 'hargaFee form-control';
    hargaFeeInput.setAttribute('data-a-sign', '');
    hargaFeeInput.setAttribute('data-a-sep', '.');
    hargaFeeInput.setAttribute('onchange', 'updateTableValues()');
    hargaFeeInput.style.textAlign = 'right';
    hargaFeeInput.name = 'hargaFee[]';
    hargaFeeInput.placeholder = 'Rp. Harga Fee';
    hargaFeeInput.value = '0';
    hargaFeeInput.min = '0';
    hargaFeeInput.required = true;

    // Buat tombol hapus baris
    var removeRowBtn = document.createElement('button');
    removeRowBtn.className = 'btn btn-danger removeRowBtn';
    removeRowBtn.style.width = '30px';
    removeRowBtn.textContent = 'x';
    removeRowBtn.addEventListener('click', function() {
        newRow.remove(); // Menghapus baris saat tombol x ditekan
        updateSelisihFee();
    });

    // Buat elemen td untuk baris baru
    var newRow = document.createElement('tr');
    
    // Buat elemen td untuk input bulan
    var monthCell = document.createElement('td');
    monthCell.appendChild(monthInput);
    newRow.appendChild(monthCell);

    // Buat elemen td untuk input harga fee
    var hargaFeeCell = document.createElement('td');
    hargaFeeCell.style.textAlign = 'right';
    hargaFeeCell.appendChild(hargaFeeInput);
    newRow.appendChild(hargaFeeCell);
    
    // Buat elemen td untuk tombol hapus baris
    var removeRowCell = document.createElement('td');
    removeRowCell.style.textAlign = 'center';
    removeRowCell.appendChild(removeRowBtn);
    newRow.appendChild(removeRowCell);
    
    // Sisipkan baris baru sebelum parent dari parent tombol "+"
    addButton.closest('tr').insertAdjacentElement('beforebegin', newRow);

    // Inisialisasi AutoNumeric untuk input harga fee baru
    new AutoNumeric(hargaFeeInput, {
        allowDecimalPadding: false,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        minimumValue: "0",
        decimalPlaces: 6
    });

    // Buat objek Date untuk bulan saat ini
    var currentDate = new Date();
    currentDate.setDate(1);

    // Tambahkan satu bulan ke bulan saat ini
    currentDate.setMonth(currentDate.getMonth() + 1);


    // Dapatkan tahun dan bulan baru
    var newYearX = currentDate.getFullYear();
    var newMonthX = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Ambil elemen input selectBulanTahun
    var selectBulanTahun = $('.selectBulanTahun');
    // Set nilai minimum untuk input month
    var minDate = newYearX + '-' + newMonthX;
    selectBulanTahun.attr('min', minDate);
});




// Fungsi untuk menampilkan atau menyembunyikan baris selisih
function toggleRowSelisih(isVisible) {
    var rowSelisih = document.getElementById("rowSelisih");
    rowSelisih.style.display = isVisible ? "table-row" : "none";
}


function updateSelisihFee() {
    // Ambil nilai total harga fee dari semua input harga fee
    var totalHargaFee = 0;
    var hargaFeeInputs = document.querySelectorAll('.hargaFee');
    hargaFeeInputs.forEach(function(input) {
        totalHargaFee += parseFloat(input.value.replace(/\./g, '').replace(/,/g, '.'));
    });

    // Ambil nilai jumlah komponen
    var jumlahKomponen = parseFloat(document.getElementById("jumlahKomponen").value.replace(/\./g, '').replace(/,/g, '.'));

    // Ambil nilai harga modal
    var hargaModal = parseFloat(document.getElementById("hargaModal").value.replace(/\./g, '').replace(/,/g, '.'));

    // Hitung selisih fee
    var selisihFee = totalHargaFee - (jumlahKomponen * hargaModal);

    // Update tampilan selisih fee
    var selisihFeeElement = document.getElementById("selisihFee");
    selisihFeeElement.textContent = 'Rp ' + selisihFee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    // Hitung selisih fee
    var totalFee = totalHargaFee;

    // Update tampilan selisih fee
    var totalFeeElement = document.getElementById("totalFee");
    totalFeeElement.textContent = 'Rp ' + totalFee.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisih(selisihFee !== 0);

}

// Fungsi untuk menghitung ulang dan memperbarui nilai di tabel
function updateTableValues() {
    // Ambil nilai dari input yang diubah
    var hargaModal = parseFloat(document.getElementById("hargaModal").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaJual = parseFloat(document.getElementById("hargaJual").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaDiscount = parseFloat(document.getElementById("hargaDiscount").value.replace(/\./g, '').replace(/,/g, '.'));

    var jumlahKomponen = parseFloat(document.getElementById("jumlahKomponen").value);
    var namaKomponen = document.getElementById("komponenProject").value;

    // Hitung total harga komponen dan total harga jual komponen
    var totalHargaKomponen = hargaModal * jumlahKomponen;
    var totalHargaJualKomponen = hargaJual * jumlahKomponen;

    // Hitung nilai discount
    var discount = hargaDiscount;

    // Hitung nilai discount
    var modalJual = totalHargaJualKomponen - totalHargaKomponen;

    // Hitung total keuntungan
    var totalKeuntungan =  totalHargaJualKomponen - totalHargaKomponen - hargaDiscount;

    // Perbarui nilai di tabel
    document.getElementById("tableNamaKomponen").innerText = namaKomponen;
    document.getElementById("tableJumlahKomponen").innerText = jumlahKomponen;
    document.getElementById("tableJumlahKomponen2").innerText = jumlahKomponen;
    document.getElementById("tableHargaKomponen").innerText = formatCurrency(hargaModal);
    document.getElementById("tableHargaJualKomponen").innerText = formatCurrency(hargaJual);
    document.getElementById("tableTotalHargaKomponen").innerText = formatCurrency(totalHargaKomponen);
    document.getElementById("tableTotalHargaJualKomponen").innerText = formatCurrency(totalHargaJualKomponen);
    document.getElementById("tableHarga").innerText = formatCurrency(modalJual);
    document.getElementById("tableDiscount").innerText = formatCurrency(discount);
    document.getElementById("tableKeuntungan").innerText = formatCurrency(totalKeuntungan);

    // Perbarui nilai di tabel
    updateSelisihFee();
}

// Panggil fungsi updateSelisihFee saat ada perubahan pada input harga fee atau input jumlah komponen
var hargaFeeInputs = document.querySelectorAll('.hargaFee');
hargaFeeInputs.forEach(function(input) {
    input.addEventListener('input', updateSelisihFee);
});

var jumlahKomponenInput = document.getElementById("jumlahKomponen");
jumlahKomponenInput.addEventListener('input', updateSelisihFee);


// Fungsi untuk memformat angka menjadi format mata uang (misalnya: Rp 1.000.000)
function formatCurrency(amount) {
    return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}



new AutoNumeric('#hargaModal', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaJual', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaDiscount', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});


function saveDataBreakDown() {
    // Ambil nilai dari input
    var jabatan = document.getElementById("jabatan2").value;
    var komponen = document.getElementById("komponenProject").value;
    var jumlahKomponen = document.getElementById("jumlahKomponen").value;
    var hargaModal = document.getElementById("hargaModal").value;
    var hargaJual = document.getElementById("hargaJual").value;
    var hargaDiscount = document.getElementById("hargaDiscount").value;
    var id_dg_client_project = <?php echo $id_dg_project;?>;
    var id_user_team = <?php echo $id_user_team;?>;
    var id_user = <?php echo $id_user;?>;
    var id_division = <?php echo $id_division;?>;
    var status_breakdown2 = 0;
    var status_rab = 0; 
    
    // Mendapatkan nilai dari input selectBulanTahun[]
    var selectBulanTahun = [];
    var inputs = document.querySelectorAll('.selectBulanTahun');
    inputs.forEach(function(input) {
        selectBulanTahun.push(input.value);
    });

    // Mendapatkan nilai dari input hargaFee[]
    var hargaFee = [];
    var inputs = document.querySelectorAll('.hargaFee');
    inputs.forEach(function(input) {
        var value = input.value.trim(); // Menghapus spasi di awal dan akhir
        hargaFee.push(value);
    });
    
    // Cek apakah ada selisih fee
    var selisihFee = parseFloat(document.getElementById("selisihFee").textContent.replace(/\D+/g, '')); // Menghapus semua karakter non-digit
    if (selisihFee !== 0) {
        toastr.warning('Tidak dapat menyimpan data karena masih ada selisih fee.');
        return; // Keluar dari fungsi jika ada selisih fee
    }

    // Cek apakah ada hargaFee yang kosong atau bernilai 0
    if (hargaFee.some(val => val === '' || parseFloat(val) === 0)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat harga fee yang kosong atau bernilai 0.');
        return; // Keluar dari fungsi jika ada hargaFee yang kosong atau bernilai 0
    }

    // Cek apakah ada nilai yang sama di dalam array selectBulanTahun
    if (hasDuplicates(selectBulanTahun)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat bulan dan tahun yang sama.');
        return; // Keluar dari fungsi jika ada nilai yang sama di dalam array selectBulanTahun
    }

    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: 'controller/conn_add_client_project_breakdown.php',
        type: 'POST',
        data: {
            jabatan: jabatan,
            komponen: komponen,
            jumlahKomponen: jumlahKomponen,
            hargaModal: hargaModal,
            hargaJual: hargaJual,
            hargaDiscount: hargaDiscount,
            id_dg_client_project : id_dg_client_project,
            id_user_team : id_user_team,
            id_user : id_user,
            id_division : id_division,
            status_breakdown2 : status_breakdown2,
            selectBulanTahun: selectBulanTahun,
            hargaFee: hargaFee, 
            status_rab : status_rab
        },
        dataType: 'html',
        success: function(response) {
            // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
            if (!response.includes('Error')) {
                toastr.success('Data berhasil disimpan.');
            } else {
                toastr.error('Data gagal disimpan !<br>' + response);
            }
            // Kosongkan nilai input
            $('#modal-add-breakdown').modal('hide');
            $('#select-jabatan').hide();
        },
        error: function(xhr, status, error) {
            // Tangani kesalahan saat mengirim permintaan AJAX
            console.error('Error:', error);
        }
    });
}

// Fungsi untuk memeriksa apakah ada nilai yang sama di dalam array
function hasDuplicates(array) {
    return (new Set(array)).size !== array.length;
}






</script>