<?php 
// mengaktifkan session
session_start();
include '../../controller/conn.php';
$id_user_team_memo = $_GET['id_user_team'];
$id_dg_project_memo = $_GET['id_dg_project'];
$id_user_memp = $_GET['id_user'];
$id_division_memo = $_GET['id_division'];

?>    
<div class="row">
    
    <div class="col-6" style="padding-right: 20px;">

        <div class="form-group row">
            <label for="jabatan2_memo" class="col-sm-12 col-form-label">Nama Jabatan</label>
            <div class="col-sm-12">
                <select class="form-control select jabatan2_memo" style="width: 100%;" name="jabatan2_memo" id="jabatan2_memo">
                    <option selected disabled value="">-Pilih Nama Jabatan-</option>    
                    <?php 
                        $result_team = mysqli_query($db2,"SELECT * 
                        FROM dg_client_project_team cpt 
                        JOIN dg_job j ON cpt.id_dg_job = j.id_dg_job
                        WHERE id_dg_client_project = $id_dg_project_memo and id_dg_user = $id_user_team_memo");
                        while($d_team = mysqli_fetch_array($result_team)){
                    ?>
                    <option value="<?php echo $d_team['id_dg_job']; ?>"><?php echo $d_team['job_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="komponenProject_memo" class="col-sm-12 col-form-label">Komponen Pekerjaan</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="komponenProject_memo" name="komponenProject_memo"
                    onchange="updateTableValuesMemo()"
                    placeholder="Ketikan Komponen Pekerjaan" value="" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="jumlahKomponen_memo" class="col-sm-12 col-form-label">Jumlah Komponen</label>
            <div class="col-sm-12">
                <input type="number" id="jumlahKomponen_memo" style="text-align: right;" 
                    name="jumlahKomponen_memo" class="form-control" onchange="updateTableValuesMemo()"
                    placeholder="Jumlah Komponen" value="1" min=0 required>
            </div>
        </div>


    </div>

    <div class="col-6" style="padding-left: 20px;">

       <div class="form-group row">
            <label for="hargaModal_memo" class="col-sm-12 col-form-label">Harga Modal per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaModal_memo" onchange="updateTableValuesMemo()"
                    style="text-align: right;" name="hargaModal_memo" class="form-control"
                    placeholder="Rp. Harga Modal" autocomplete="off" value="" min=0 required>
            </div>
        </div>

        <div class="form-group row">
            <label for="hargaJual_memo" class="col-sm-12 col-form-label">Harga Jual per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaJual_memo" onchange="updateTableValuesMemo()"
                    style="text-align: right;" name="hargaJual_memo" class="form-control"
                    placeholder="Rp. Harga Jual" autocomplete="off" value="" min=0 required>
            </div>
        </div>


        <div class="form-group row">
            <label for="hargaDiscount_memo" class="col-sm-12 col-form-label">Discount dari Total Jual</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaDiscount_memo" onchange="updateTableValuesMemo()"
                    style="text-align: right;" name="hargaDiscount_memo" class="form-control"
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
                <th colspan="3" id="tableNamaKomponen_memo" style="width: 75%; text-align: left;">-</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>Harga Modal per Komponen</td>
                <td id="tableHargaKomponen_memo" style="text-align: right;">Rp 0</td> 
                <td>Harga Jual per Komponen</td>
                <td id="tableHargaJualKomponen_memo" style="text-align: right;">Rp 0</td> 
            </tr>
            <tr>
                <td>Jumlah Komponen</td>
                <td id="tableJumlahKomponen_memo" style="text-align: right;">0</td> 
                <td>Jumlah Komponen</td> 
                <td id="tableJumlahKomponen2_memo" style="text-align: right;">0</td> 
            </tr>
            <tr>
                <td><b>Total Harga Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaKomponen_memo">Rp 0</b></td>
                <td><b>Total Harga Jual Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaJualKomponen_memo">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"><b>Harga Jual - Harga Modal</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableHarga_memo">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b style="color: red;">Discount</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableDiscount_memo" style="color: red;">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b>Total Keuntungan</b></td>
                <td  colspan="2" style="text-align: right;"><b id="tableKeuntungan_memo">Rp 0</b></td> 
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
                <input type="month" class="form-control selectBulanTahunMemo" name="selectBulanTahunMemo[]">
            </td>
            <td style="text-align: right;">
                <input type="text" data-a-sign="" data-a-sep="." onchange="updateTableValuesMemo()"
                style="text-align: right;" name="hargaFeeMemo[]" class="hargaFeeMemo form-control"
                placeholder="Rp. Harga Fee" autocomplete="off" value="0" min="0" required>
            </td>
            <td style="text-align: center;">
                <button class="btn btn-danger removeRowBtn_memo" style="width: 30px;">x</button>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="row">
                    <hr style="width: 80%;"><button  id="addRowBtnMemo" style="width: 15%;" type="button" class="btn btn-success">+</button>
                </div>
            </td>
        </tr>
        <tr>
            <td><b>Total Fee</b></td>
            <td style="text-align: right;"><b id="totalFeeMemo">Rp 0</b></td> 
            <td></td>
        </tr>
        <tr style="display: none;" id="rowSelisihMemo">
            <td><b style ="color:red;">Selisih Fee</b></td>
            <td style="text-align: right;"><b style ="color:red;" id="selisihFeeMemo">Rp 0</b></td> 
            <td></td>
        </tr>
    </tbody>
</table>


</div>
<script>

// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtnMemo");
// Ambil semua elemen input dengan kelas hargaFeeMemo
var inputs = document.querySelectorAll('.hargaFeeMemo');

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
    // Ambil elemen input selectBulanTahunMemo
    var selectBulanTahunMemo = $('.selectBulanTahunMemo');

    // Buat objek Date untuk bulan saat ini
    var currentDate = new Date();
    currentDate.setDate(1);

    // Tambahkan satu bulan ke bulan saat ini
    currentDate.setMonth(currentDate.getMonth() + 1);

    // Dapatkan tahun dan bulan baru
    var newYear = currentDate.getFullYear();
    var newMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Gabungkan tahun dan bulan baru menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Atur nilai input selectBulanTahunMemo menjadi bulan berikutnya dari sekarang
    selectBulanTahunMemo.val(nextMonth);

    // Set nilai minimum untuk input month
    var minDate = newYear + '-' + newMonth;
    selectBulanTahunMemo.attr('min', minDate);

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisihMemo(selisihFeeMemo !== 0);

    // Tambahkan event listener ke tombol "x" untuk menghapus baris
    $('.removeRowBtn_memo').click(function() {
        $(this).closest('tr').remove(); // Hapus baris <tr> terdekat saat tombol "x" ditekan
        updateSelisihFeeMemo(); // Perbarui nilai selisih fee setelah baris dihapus
    });
});





// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtnMemo");

// Tambahkan event listener ke tombol "+" untuk menambahkan baris baru ke tabel
addButton.addEventListener("click", function() {
    // Dapatkan semua input bulan
    var monthInputs = document.querySelectorAll('.selectBulanTahunMemo');

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
    monthInput.className = 'form-control selectBulanTahunMemo';
    monthInput.name = 'selectBulanTahunMemo[]';
    monthInput.value = nextMonth;

    // Buat elemen input untuk harga fee
    var hargaFeeMemoInput = document.createElement('input');
    hargaFeeMemoInput.type = 'text';
    hargaFeeMemoInput.className = 'hargaFeeMemo form-control';
    hargaFeeMemoInput.setAttribute('data-a-sign', '');
    hargaFeeMemoInput.setAttribute('data-a-sep', '.');
    hargaFeeMemoInput.setAttribute('onchange', 'updateTableValuesMemo()');
    hargaFeeMemoInput.style.textAlign = 'right';
    hargaFeeMemoInput.name = 'hargaFeeMemo[]';
    hargaFeeMemoInput.placeholder = 'Rp. Harga Fee';
    hargaFeeMemoInput.value = '0';
    hargaFeeMemoInput.min = '0';
    hargaFeeMemoInput.required = true;

    // Buat tombol hapus baris
    var removeRowBtn_memo = document.createElement('button');
    removeRowBtn_memo.className = 'btn btn-danger removeRowBtn_memo';
    removeRowBtn_memo.style.width = '30px';
    removeRowBtn_memo.textContent = 'x';
    removeRowBtn_memo.addEventListener('click', function() {
        newRow.remove(); // Menghapus baris saat tombol x ditekan
        updateSelisihFeeMemo();
    });

    // Buat elemen td untuk baris baru
    var newRow = document.createElement('tr');
    
    // Buat elemen td untuk input bulan
    var monthCell = document.createElement('td');
    monthCell.appendChild(monthInput);
    newRow.appendChild(monthCell);

    // Buat elemen td untuk input harga fee
    var hargaFeeMemoCell = document.createElement('td');
    hargaFeeMemoCell.style.textAlign = 'right';
    hargaFeeMemoCell.appendChild(hargaFeeMemoInput);
    newRow.appendChild(hargaFeeMemoCell);
    
    // Buat elemen td untuk tombol hapus baris
    var removeRowCell = document.createElement('td');
    removeRowCell.style.textAlign = 'center';
    removeRowCell.appendChild(removeRowBtn_memo);
    newRow.appendChild(removeRowCell);
    
    // Sisipkan baris baru sebelum parent dari parent tombol "+"
    addButton.closest('tr').insertAdjacentElement('beforebegin', newRow);

    // Inisialisasi AutoNumeric untuk input harga fee baru
    new AutoNumeric(hargaFeeMemoInput, {
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

    // Ambil elemen input selectBulanTahunMemo
    var selectBulanTahunMemo = $('.selectBulanTahunMemo');
    // Set nilai minimum untuk input month
    var minDate = newYearX + '-' + newMonthX;
    selectBulanTahunMemo.attr('min', minDate);
});




// Fungsi untuk menampilkan atau menyembunyikan baris selisih
function toggleRowSelisihMemo(isVisible) {
    var rowSelisihMemo = document.getElementById("rowSelisihMemo");
    rowSelisihMemo.style.display = isVisible ? "table-row" : "none";
}


function updateSelisihFeeMemo() {
    // Ambil nilai total harga fee dari semua input harga fee
    var totalHargaFeeMemo = 0;
    var hargaFeeMemoInputs = document.querySelectorAll('.hargaFeeMemo');
    hargaFeeMemoInputs.forEach(function(input) {
        totalHargaFeeMemo += parseFloat(input.value.replace(/\./g, '').replace(/,/g, '.'));
    });

    // Ambil nilai jumlah komponen
    var jumlahKomponen_memo = parseFloat(document.getElementById("jumlahKomponen_memo").value.replace(/\./g, '').replace(/,/g, '.'));

    // Ambil nilai harga modal
    var hargaModal_memo = parseFloat(document.getElementById("hargaModal_memo").value.replace(/\./g, '').replace(/,/g, '.'));

    // Hitung selisih fee
    var selisihFeeMemo = totalHargaFeeMemo - (jumlahKomponen_memo * hargaModal_memo);

    // Update tampilan selisih fee
    var selisihFeeMemoElement = document.getElementById("selisihFeeMemo");
    selisihFeeMemoElement.textContent = 'Rp ' + selisihFeeMemo.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    // Hitung selisih fee
    var totalFeeMemo = totalHargaFeeMemo;

    // Update tampilan selisih fee
    var totalFeeElement = document.getElementById("totalFeeMemo");
    totalFeeElement.textContent = 'Rp ' + totalFeeMemo.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisihMemo(selisihFeeMemo !== 0);

}

// Fungsi untuk menghitung ulang dan memperbarui nilai di tabel
function updateTableValuesMemo() {
    // Ambil nilai dari input yang diubah
    var hargaModal_memo = parseFloat(document.getElementById("hargaModal_memo").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaJual_memo = parseFloat(document.getElementById("hargaJual_memo").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaDiscount_memo = parseFloat(document.getElementById("hargaDiscount_memo").value.replace(/\./g, '').replace(/,/g, '.'));

    var jumlahKomponen_memo = parseFloat(document.getElementById("jumlahKomponen_memo").value);
    var namaKomponen = document.getElementById("komponenProject_memo").value;

    // Hitung total harga komponen dan total harga jual komponen
    var totalHargaKomponen = hargaModal_memo * jumlahKomponen_memo;
    var totalHargaJualKomponen = hargaJual_memo * jumlahKomponen_memo;

    // Hitung nilai discount
    var discount = hargaDiscount_memo;

    // Hitung nilai discount
    var modalJual = totalHargaJualKomponen - totalHargaKomponen;

    // Hitung total keuntungan
    var totalKeuntungan =  totalHargaJualKomponen - totalHargaKomponen - hargaDiscount_memo;

    // Perbarui nilai di tabel
    document.getElementById("tableNamaKomponen_memo").innerText = namaKomponen;
    document.getElementById("tableJumlahKomponen_memo").innerText = jumlahKomponen_memo;
    document.getElementById("tableJumlahKomponen2_memo").innerText = jumlahKomponen_memo;
    document.getElementById("tableHargaKomponen_memo").innerText = formatCurrency(hargaModal_memo);
    document.getElementById("tableHargaJualKomponen_memo").innerText = formatCurrency(hargaJual_memo);
    document.getElementById("tableTotalHargaKomponen_memo").innerText = formatCurrency(totalHargaKomponen);
    document.getElementById("tableTotalHargaJualKomponen_memo").innerText = formatCurrency(totalHargaJualKomponen);
    document.getElementById("tableHarga_memo").innerText = formatCurrency(modalJual);
    document.getElementById("tableDiscount_memo").innerText = formatCurrency(discount);
    document.getElementById("tableKeuntungan_memo").innerText = formatCurrency(totalKeuntungan);

    // Perbarui nilai di tabel
    updateSelisihFeeMemo();
}

// Panggil fungsi updateSelisihFeeMemo saat ada perubahan pada input harga fee atau input jumlah komponen
var hargaFeeMemoInputs = document.querySelectorAll('.hargaFeeMemo');
hargaFeeMemoInputs.forEach(function(input) {
    input.addEventListener('input', updateSelisihFeeMemo);
});

var jumlahKomponenInput = document.getElementById("jumlahKomponen_memo");
jumlahKomponenInput.addEventListener('input', updateSelisihFeeMemo);


// Fungsi untuk memformat angka menjadi format mata uang (misalnya: Rp 1.000.000)
function formatCurrency(amount) {
    return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}



new AutoNumeric('#hargaModal_memo', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaJual_memo', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaDiscount_memo', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});


function saveDataBreakDownMemo() {
    // Ambil nilai dari input
    var jabatan = document.getElementById("jabatan2_memo").value;
    var komponen = document.getElementById("komponenProject_memo").value;
    var jumlahKomponen_memo = document.getElementById("jumlahKomponen_memo").value;
    var hargaModal_memo = document.getElementById("hargaModal_memo").value;
    var hargaJual_memo = document.getElementById("hargaJual_memo").value;
    var hargaDiscount_memo = document.getElementById("hargaDiscount_memo").value;
    var id_dg_client_project = <?php echo $id_dg_project_memo;?>;
    var id_user_team = <?php echo $id_user_team_memo;?>;
    var id_user = <?php echo $id_user_memp;?>;
    var id_division = <?php echo $id_division_memo;?>;
    var status_breakdown2 = 1;
    var status_rab = 2;
    
    // Mendapatkan nilai dari input selectBulanTahunMemo[]
    var selectBulanTahunMemo = [];
    var inputs = document.querySelectorAll('.selectBulanTahunMemo');
    inputs.forEach(function(input) {
        selectBulanTahunMemo.push(input.value);
    });

    // Mendapatkan nilai dari input hargaFeeMemo[]
    var hargaFeeMemo = [];
    var inputs = document.querySelectorAll('.hargaFeeMemo');
    inputs.forEach(function(input) {
        var value = input.value.trim(); // Menghapus spasi di awal dan akhir
        hargaFeeMemo.push(value);
    });
    
    // Cek apakah ada selisih fee
    var selisihFeeMemo = parseFloat(document.getElementById("selisihFeeMemo").textContent.replace(/\D+/g, '')); // Menghapus semua karakter non-digit
    if (selisihFeeMemo !== 0) {
        toastr.warning('Tidak dapat menyimpan data karena masih ada selisih fee.');
        return; // Keluar dari fungsi jika ada selisih fee
    }

    // Cek apakah ada hargaFeeMemo yang kosong atau bernilai 0
    if (hargaFeeMemo.some(val => val === '' || parseFloat(val) === 0)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat harga fee yang kosong atau bernilai 0.');
        return; // Keluar dari fungsi jika ada hargaFeeMemo yang kosong atau bernilai 0
    }

    // Cek apakah ada nilai yang sama di dalam array selectBulanTahunMemo
    if (hasDuplicates(selectBulanTahunMemo)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat bulan dan tahun yang sama.');
        return; // Keluar dari fungsi jika ada nilai yang sama di dalam array selectBulanTahunMemo
    }

    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: 'controller/conn_add_client_project_breakdown.php',
        type: 'POST',
        data: {
            jabatan: jabatan,
            komponen: komponen,
            jumlahKomponen: jumlahKomponen_memo,
            hargaModal: hargaModal_memo,
            hargaJual: hargaJual_memo,
            hargaDiscount: hargaDiscount_memo,
            id_dg_client_project : id_dg_client_project,
            id_user_team : id_user_team,
            id_user : id_user,
            id_division : id_division,
            status_breakdown2 : status_breakdown2,
            selectBulanTahun: selectBulanTahunMemo,
            hargaFee: hargaFeeMemo,
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
            $('#modal-add-breakdown-memo').modal('hide');
            $('#select-jabatan-memo').hide();
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