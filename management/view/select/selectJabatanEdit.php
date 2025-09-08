<?php 
// mengaktifkan session
session_start();
include '../../controller/conn.php';
$id_dg_project = 0;
$id_dg_client_project_breakdown = $_GET['id_dg_client_project_breakdown'];
$result_breakdown = mysqli_query($db2,"SELECT * FROM dg_client_project_breakdown  
                        WHERE id_dg_client_project_breakdown = $id_dg_client_project_breakdown");
                        while($d_breakdown = mysqli_fetch_array($result_breakdown)){
                            $id_dg_project = $d_breakdown['id_dg_client_project'];
                            $id_dg_user_job = $d_breakdown['id_dg_user_job'];
                            $nama_komponen = $d_breakdown['nama_komponen'];
                            $jumlah_komponen = $d_breakdown['jumlah_komponen'];
                            $harga_modal = $d_breakdown['harga_modal'];
                            $harga_jual = $d_breakdown['harga_jual'];
                            $discount = $d_breakdown['discount'];
                            
                        }

$id_user_team = $_GET['id_user_team'];
$id_user = $_GET['id_user'];
$id_division = $_GET['id_division'];
$status_breakdown = $_GET['status_breakdown'];
$status_rab = $_GET['status_rab'];

?>    
<div class="row">
    
    <div class="col-6" style="padding-right: 20px;">

        <div class="form-group row">
            <label for="jabatan3" class="col-sm-12 col-form-label">Nama Jabatan</label>
            <div class="col-sm-12">
                <select class="form-control select jabatan3" style="width: 100%;" name="jabatan3" id="jabatan3">
                    <option selected disabled value="">-Pilih Nama Jabatan-</option>    
                    <?php 
                        $result_team = mysqli_query($db2,"SELECT * 
                        FROM dg_client_project_team cpt 
                        JOIN dg_job j ON cpt.id_dg_job = j.id_dg_job
                        WHERE id_dg_client_project = $id_dg_project and id_dg_user = $id_user_team");
                        while($d_team = mysqli_fetch_array($result_team)){
                    ?>
                    <option <?php if($id_dg_user_job==$d_team['id_dg_job']){echo "selected";}; ?> value="<?php echo $d_team['id_dg_job']; ?>"><?php echo $d_team['job_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="komponenProject2" class="col-sm-12 col-form-label">Komponen Pekerjaan</label>
            <div class="col-sm-12">
                <input type="text" class="form-control" id="komponenProject2" name="komponenProject2"
                    onchange="updateTableValues()"
                    placeholder="Ketikan Komponen Pekerjaan" value="<?php echo $nama_komponen; ?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="jumlahKomponen2" class="col-sm-12 col-form-label">Jumlah Komponen</label>
            <div class="col-sm-12">
                <input type="number" id="jumlahKomponen2" style="text-align: right;" 
                    name="jumlahKomponen2" class="form-control" onchange="updateTableValues()"
                    placeholder="Jumlah Komponen" value="<?php echo $jumlah_komponen; ?>" min=0 required>
            </div>
        </div>


    </div>

    <div class="col-6" style="padding-left: 20px;">

       <div class="form-group row">
            <label for="hargaModal2" class="col-sm-12 col-form-label">Harga Modal per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaModal2" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaModal2" class="form-control"
                    placeholder="Rp. Harga Modal" autocomplete="off" value="<?php echo $harga_modal; ?>" min=0 required>
            </div>
        </div>

        <div class="form-group row">
            <label for="hargaJual2" class="col-sm-12 col-form-label">Harga Jual per Komponen</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaJual2" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaJual2" class="form-control"
                    placeholder="Rp. Harga Jual" autocomplete="off" value="<?php echo $harga_jual; ?>" min=0 required>
            </div>
        </div>


        <div class="form-group row">
            <label for="hargaDiscount2" class="col-sm-12 col-form-label">Discount dari Total Jual</label>
            <div class="col-sm-12">
                <input type="text" data-a-sign="" data-a-sep="." id="hargaDiscount2" onchange="updateTableValues()"
                    style="text-align: right;" name="hargaDiscount2" class="form-control"
                    placeholder="Rp. Harga Discount Jual" autocomplete="off" value="<?php echo $discount; ?>" min=0 required>
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
                <th colspan="3" id="tableNamaKomponen2" style="width: 75%; text-align: left;">-</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>Harga Modal per Komponen</td>
                <td id="tableHargaKomponen2" style="text-align: right;">Rp 0</td> 
                <td>Harga Jual per Komponen</td>
                <td id="tableHargaJual2Komponen2" style="text-align: right;">Rp 0</td> 
            </tr>
            <tr>
                <td>Jumlah Komponen</td>
                <td id="tableJumlahKomponen22" style="text-align: right;">0</td> 
                <td>Jumlah Komponen</td> 
                <td id="tableJumlahKomponen222" style="text-align: right;">0</td> 
            </tr>
            <tr>
                <td><b>Total Harga Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaKomponen2">Rp 0</b></td>
                <td><b>Total Harga Jual Komponen</b></td>
                <td style="text-align: right;"><b id="tableTotalHargaJual2Komponen2">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2"><b>Harga Jual - Harga Modal</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableHarga2">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b style="color: red;">Discount</b></td>
                <td colspan="2" style="text-align: right;"><b id="tableDiscount2" style="color: red;">Rp 0</b></td> 
            </tr>
            <tr>
                <td colspan="2"><b>Total Keuntungan</b></td>
                <td  colspan="2" style="text-align: right;"><b id="tableKeuntungan2">Rp 0</b></td> 
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
    <?php 
    $result_breakdown_rab = mysqli_query($db2,"SELECT * FROM dg_client_project_breakdown_rab  
    WHERE id_dg_client_project_breakdown = $id_dg_client_project_breakdown");
    while($d_breakdown_rab = mysqli_fetch_array($result_breakdown_rab)){
        $id_dg_rab_detail = $d_breakdown_rab['id_dg_rab_detail'];

        $result_rab_detail = mysqli_query($db2,"SELECT * FROM dg_rab_detail  
        WHERE id_dg_rab_detail = $id_dg_rab_detail");
        while($d_rab_detail = mysqli_fetch_array($result_rab_detail)){
            $amount = $d_rab_detail['amount'];
            $date_rab = $d_rab_detail['date_rab'];
            $date_formatted = date('Y-m', strtotime($date_rab));
        }
        $disabled = '';
        // Periksa apakah $date_formatted sebelum bulan saat ini
        $currentMonth = date('Y-m');
        $currentDay = date('d'); // Ambil tanggal saat ini
        
        // Jika hari ini sudah tanggal 5 atau lebih, maka bulan ini bisa diedit
        if ($currentDay < 5  && $_SESSION['priv'] == 1) {
            $minAllowedMonth = $currentMonth; // Bulan ini masih bisa dipilih
        } else {
            $minAllowedMonth = date('Y-m', strtotime('+1 month')); // Bulan berikutnya
        }

        // Cek apakah $date_formatted lebih kecil dari batas minimal
        if ($date_formatted < $minAllowedMonth) {
            $disabled = 'disabled';
        } else {
            $disabled = '';
        }
    ?>
        <tr>
            <td>
                <input type="month" class="form-control selectBulanTahun2" name="selectBulanTahun2[]" value="<?php echo $date_formatted; ?>" <?php echo $disabled; ?>>
            </td>
            <td style="text-align: right;">
                <input type="text" data-a-sign="" data-a-sep="." onchange="updateTableValues()"
                style="text-align: right;" name="hargaFee2[]" class="hargaFee2 form-control"  <?php echo $disabled; ?>
                placeholder="Rp. Harga Fee" autocomplete="off" value="<?php echo $amount; ?>" min="0" required>
            </td>
            <td style="text-align: center;">
                <button class="btn btn-danger removeRowBtn2" style="width: 30px;"  <?php echo $disabled; ?>>x</button>
            </td>
            <?php 
                if ($disabled == 'disabled') {
            ?>
                    <input type="hidden" name="selectBulanTahun2[]" value="<?php echo $date_formatted; ?>">
                    <input type="hidden" name="hargaFee2[]" value="<?php echo $amount; ?>">
            <?php
                }
            ?>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="3">
                <div class="row">
                    <hr style="width: 80%;"><button  id="addRowBtn2" style="width: 15%;" type="button" class="btn btn-success">+</button>
                </div>
            </td>
        </tr>
        <tr>
            <td><b>Total Fee</b></td>
            <td style="text-align: right;"><b id="totalFee2">Rp 0</b></td> 
            <td></td>
        </tr>
        <tr style="display: none;" id="rowSelisih2">
            <td><b style ="color:red;">Selisih Fee</b></td>
            <td style="text-align: right;"><b style ="color:red;" id="selisihFee2">Rp 0</b></td> 
            <td></td>
        </tr>
    </tbody>
</table>


</div>
<script>

// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn2");
// Ambil semua elemen input dengan kelas hargaFee2
var inputs = document.querySelectorAll('.hargaFee2');

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
    updateTableValues();

    // Ambil elemen input selectBulanTahun2
    var selectBulanTahun2 = $('.selectBulanTahun2');

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


    // Set nilai minimum untuk input month
    var minDate = newYear + '-' + newMonth;
    selectBulanTahun2.attr('min', minDate);
   

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisih2(selisihFee2 !== 0);

    // Tambahkan event listener ke tombol "x" untuk menghapus baris
    $('.removeRowBtn2').click(function() {
        $(this).closest('tr').remove(); // Hapus baris <tr> terdekat saat tombol "x" ditekan
        updateSelisihFee2(); // Perbarui nilai selisih fee setelah baris dihapus
    });
});



// Ambil referensi elemen tombol "+"
var addButton = document.getElementById("addRowBtn2");

// Tambahkan event listener ke tombol "+" untuk menambahkan baris baru ke tabel
addButton.addEventListener("click", function() {
    // Dapatkan semua input bulan
    var monthInputs = document.querySelectorAll('.selectBulanTahun2');

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


    // Dapatkan tanggal saat ini
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentDay = currentDate.getDate(); // Ambil tanggal saat ini

    // Jika tanggal >= 5, tambahkan satu bulan, jika tidak, tetap di bulan ini
    if (currentDay < 5 && <?php echo $_SESSION['priv']; ?> == 1) {
        var currentMonth = currentDate.getMonth(); // Bulan dalam JavaScript dimulai dari 0
    }else{
        var currentMonth = currentDate.getMonth()+1; // Bulan dalam JavaScript dimulai dari 0
    }

    // Bandingkan lastMonthDate dengan bulan dan tahun saat ini
    if (lastMonthDate.getFullYear() < currentYear || 
        (lastMonthDate.getFullYear() === currentYear && lastMonthDate.getMonth() + 1 < currentMonth)) {
            console.log(lastMonthDate.getMonth()+"-"+lastMonthDate.getFullYear());
            lastMonthDate.setMonth(currentMonth);
            lastMonthDate.setYear(currentYear);
            console.log(lastMonthDate.getMonth()+"-"+lastMonthDate.getFullYear());
    }


    // Dapatkan tahun dan bulan baru
    var newYear = lastMonthDate.getFullYear();
    var newMonth = (lastMonthDate.getMonth() + 1).toString().padStart(2, '0');



    // Gabungkan tahun dan bulan menjadi format "YYYY-MM"
    var nextMonth = newYear + '-' + newMonth;

    // Buat elemen input untuk bulan
    var monthInput = document.createElement('input');
    monthInput.type = 'month';
    monthInput.className = 'form-control selectBulanTahun2';
    monthInput.name = 'selectBulanTahun2[]';
    monthInput.value = nextMonth;

    // Buat elemen input untuk harga fee
    var hargaFee2Input = document.createElement('input');
    hargaFee2Input.type = 'text';
    hargaFee2Input.className = 'hargaFee2 form-control';
    hargaFee2Input.setAttribute('data-a-sign', '');
    hargaFee2Input.setAttribute('data-a-sep', '.');
    hargaFee2Input.setAttribute('onchange', 'updateTableValues()');
    hargaFee2Input.style.textAlign = 'right';
    hargaFee2Input.name = 'hargaFee2[]';
    hargaFee2Input.placeholder = 'Rp. Harga Fee';
    hargaFee2Input.value = '0';
    hargaFee2Input.min = '0';
    hargaFee2Input.required = true;

    // Buat tombol hapus baris
    var removeRowBtn2 = document.createElement('button');
    removeRowBtn2.className = 'btn btn-danger removeRowBtn2';
    removeRowBtn2.style.width = '30px';
    removeRowBtn2.textContent = 'x';
    removeRowBtn2.addEventListener('click', function() {
        newRow2.remove(); // Menghapus baris saat tombol x ditekan
        updateSelisihFee2();
    });

    // Buat elemen td untuk baris baru
    var newRow2 = document.createElement('tr');
    
    // Buat elemen td untuk input bulan
    var monthCell = document.createElement('td');
    monthCell.appendChild(monthInput);
    newRow2.appendChild(monthCell);

    // Buat elemen td untuk input harga fee
    var hargaFee2Cell = document.createElement('td');
    hargaFee2Cell.style.textAlign = 'right';
    hargaFee2Cell.appendChild(hargaFee2Input);
    newRow2.appendChild(hargaFee2Cell);
    
    // Buat elemen td untuk tombol hapus baris
    var removeRowCell = document.createElement('td');
    removeRowCell.style.textAlign = 'center';
    removeRowCell.appendChild(removeRowBtn2);
    newRow2.appendChild(removeRowCell);
    
    // Sisipkan baris baru sebelum parent dari parent tombol "+"
    addButton.closest('tr').insertAdjacentElement('beforebegin', newRow2);

    // Inisialisasi AutoNumeric untuk input harga fee baru
    new AutoNumeric(hargaFee2Input, {
        allowDecimalPadding: false,
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        minimumValue: "0",
        decimalPlaces: 6
    });
    
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
    var newYearX = currentDate.getFullYear();

    var newMonthX = (currentDate.getMonth() + 1).toString().padStart(2, '0');

    // Ambil elemen input selectBulanTahun
    var selectBulanTahun = $('.selectBulanTahun2');
    // Set nilai minimum untuk input month
    var minDate = newYearX + '-' + newMonthX;
    selectBulanTahun.attr('min', minDate);

});




// Fungsi untuk menampilkan atau menyembunyikan baris selisih
function toggleRowSelisih2(isVisible) {
    var rowSelisih2 = document.getElementById("rowSelisih2");
    rowSelisih2.style.display = isVisible ? "table-row" : "none";
}


function updateSelisihFee2() {
    // Ambil nilai total harga fee dari semua input harga fee
    var totalHargaFee2 = 0;
    var hargaFee2Inputs = document.querySelectorAll('.hargaFee2');
    hargaFee2Inputs.forEach(function(input) {
        totalHargaFee2 += parseFloat(input.value.replace(/\./g, '').replace(/,/g, '.'));
    });

    // Ambil nilai jumlah komponen
    var jumlahKomponen2 = parseFloat(document.getElementById("jumlahKomponen2").value.replace(/\./g, '').replace(/,/g, '.'));

    // Ambil nilai harga modal
    var hargaModal2 = parseFloat(document.getElementById("hargaModal2").value.replace(/\./g, '').replace(/,/g, '.'));

    // Hitung selisih fee
    var selisihFee2 = totalHargaFee2 - (jumlahKomponen2 * hargaModal2);

    // Update tampilan selisih fee
    var selisihFee2Element = document.getElementById("selisihFee2");
    selisihFee2Element.textContent = 'Rp ' + selisihFee2.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    // Hitung selisih fee
    var totalFee2 = totalHargaFee2;

    // Update tampilan selisih fee
    var totalFee2Element = document.getElementById("totalFee2");
    totalFee2Element.textContent = 'Rp ' + totalFee2.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    

    // Tampilkan atau sembunyikan baris selisih berdasarkan apakah ada selisih atau tidak
    toggleRowSelisih2(selisihFee2 !== 0);

}

// Fungsi untuk menghitung ulang dan memperbarui nilai di tabel
function updateTableValues() {
    // Ambil nilai dari input yang diubah
    var hargaModal2 = parseFloat(document.getElementById("hargaModal2").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaJual2 = parseFloat(document.getElementById("hargaJual2").value.replace(/\./g, '').replace(/,/g, '.'));
    var hargaDiscount2 = parseFloat(document.getElementById("hargaDiscount2").value.replace(/\./g, '').replace(/,/g, '.'));

    var jumlahKomponen2 = parseFloat(document.getElementById("jumlahKomponen2").value);
    var namaKomponen = document.getElementById("komponenProject2").value;

    // Hitung total harga komponen dan total harga jual komponen
    var totalHargaKomponen = hargaModal2 * jumlahKomponen2;
    var totalHargaJual2Komponen = hargaJual2 * jumlahKomponen2;

    // Hitung nilai discount
    var discount = hargaDiscount2;

    // Hitung nilai discount
    var modalJual = totalHargaJual2Komponen - totalHargaKomponen;

    // Hitung total keuntungan
    var totalKeuntungan =  totalHargaJual2Komponen - totalHargaKomponen - hargaDiscount2;

    // Perbarui nilai di tabel
    document.getElementById("tableNamaKomponen2").innerText = namaKomponen;
    document.getElementById("tableJumlahKomponen22").innerText = jumlahKomponen2;
    document.getElementById("tableJumlahKomponen222").innerText = jumlahKomponen2;
    document.getElementById("tableHargaKomponen2").innerText = formatCurrency(hargaModal2);
    document.getElementById("tableHargaJual2Komponen2").innerText = formatCurrency(hargaJual2);
    document.getElementById("tableTotalHargaKomponen2").innerText = formatCurrency(totalHargaKomponen);
    document.getElementById("tableTotalHargaJual2Komponen2").innerText = formatCurrency(totalHargaJual2Komponen);
    document.getElementById("tableHarga2").innerText = formatCurrency(modalJual);
    document.getElementById("tableDiscount2").innerText = formatCurrency(discount);
    document.getElementById("tableKeuntungan2").innerText = formatCurrency(totalKeuntungan);

    // Perbarui nilai di tabel
    updateSelisihFee2();
}

// Panggil fungsi updateSelisihFee2 saat ada perubahan pada input harga fee atau input jumlah komponen
var hargaFee2Inputs = document.querySelectorAll('.hargaFee2');
hargaFee2Inputs.forEach(function(input) {
    input.addEventListener('input', updateSelisihFee2);
});

var jumlahKomponen2Input = document.getElementById("jumlahKomponen2");
jumlahKomponen2Input.addEventListener('input', updateSelisihFee2);


// Fungsi untuk memformat angka menjadi format mata uang (misalnya: Rp 1.000.000)
function formatCurrency(amount) {
    return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}



new AutoNumeric('#hargaModal2', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaJual2', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});

new AutoNumeric('#hargaDiscount2', {
    allowDecimalPadding: false,
    decimalCharacter: ',',
    digitGroupSeparator: '.',
    minimumValue: "0",
    decimalPlaces: 6
});


function saveDataBreakDownEdit() {
    
    // Referensi tombol save
    var saveButton = document.querySelector('button[onclick="saveDataBreakDownEdit()"]');

    // Ubah tombol menjadi disabled dan tambahkan ikon loading
    saveButton.disabled = true;
    saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Saving...';

    // Ambil nilai dari input
    var id_dg_client_project_breakdown2 = document.getElementById("id_dg_client_project_breakdown2").value;
    var jabatan = document.getElementById("jabatan3").value;
    var komponen = document.getElementById("komponenProject2").value;
    var jumlahKomponen2 = document.getElementById("jumlahKomponen2").value;
    var hargaModal2 = document.getElementById("hargaModal2").value;
    var hargaJual2 = document.getElementById("hargaJual2").value;
    var hargaDiscount2 = document.getElementById("hargaDiscount2").value;
    var id_dg_client_project = <?php echo $id_dg_project;?>;
    var id_user_team = <?php echo $id_user_team;?>;
    var id_user = <?php echo $id_user;?>;
    var id_division = <?php echo $id_division;?>;
    var status_breakdown = <?php echo $status_breakdown;?>;
    var status_rab = <?php echo $status_rab;?>;
    
    // Mendapatkan nilai dari input selectBulanTahun2[]
    var selectBulanTahun2 = [];
    var inputs = document.querySelectorAll('.selectBulanTahun2');
    inputs.forEach(function(input) {
        selectBulanTahun2.push(input.value);
    });

    console.log(selectBulanTahun2);

    // Mendapatkan nilai dari input hargaFee2[]
    var hargaFee2 = [];
    var inputs = document.querySelectorAll('.hargaFee2');
    inputs.forEach(function(input) {
        var value = input.value.trim(); // Menghapus spasi di awal dan akhir
        hargaFee2.push(value);
    });

    console.log(hargaFee2);
    
    // Cek apakah ada selisih fee
    var selisihFee2 = parseFloat(document.getElementById("selisihFee2").textContent.replace(/\D+/g, '')); // Menghapus semua karakter non-digit
    if (selisihFee2 !== 0) {
        toastr.warning('Tidak dapat menyimpan data karena masih ada selisih fee.');
        resetSaveButton(saveButton);
        return; // Keluar dari fungsi jika ada selisih fee
    }

    // Cek apakah ada hargaFee2 yang kosong atau bernilai 0
    if (hargaFee2.some(val => val === '' || parseFloat(val) === 0)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat harga fee yang kosong atau bernilai 0.');
        resetSaveButton(saveButton);
        return; // Keluar dari fungsi jika ada hargaFee2 yang kosong atau bernilai 0
    }

    // Cek apakah ada nilai yang sama di dalam array selectBulanTahun
    if (hasDuplicates(selectBulanTahun2)) {
        toastr.warning('Tidak dapat menyimpan data karena terdapat bulan dan tahun yang sama.');
        resetSaveButton(saveButton);
        return; // Keluar dari fungsi jika ada nilai yang sama di dalam array selectBulanTahun
    }

    // Kirim data ke server menggunakan AJAX
    $.ajax({
        url: 'controller/conn_edit_client_project_breakdown.php',
        type: 'POST',
        data: {
            id_dg_client_project_breakdown2: id_dg_client_project_breakdown2,
            jabatan: jabatan,
            komponen: komponen,
            jumlahKomponen2: jumlahKomponen2,
            hargaModal2: hargaModal2,
            hargaJual2: hargaJual2,
            hargaDiscount2: hargaDiscount2,
            id_dg_client_project : id_dg_client_project,
            id_user_team : id_user_team,
            id_user : id_user,
            id_division : id_division,
            selectBulanTahun2: selectBulanTahun2,
            status_breakdown: status_breakdown,
            hargaFee2: hargaFee2,
            status_rab : status_rab
        },
        dataType: 'html',
        success: function(response) {
            // Tangkap respons dari server dan lakukan tindakan sesuai dengan itu
            if (!response.includes('Error')) {
                toastr.success('Data berhasil disimpan.<br>'+ response);
            } else {
                toastr.error('Data gagal disimpan !<br>' + response);
            }
            resetSaveButton(saveButton); // Kembalikan tombol
            // Kosongkan nilai input
            $('#modal-edit-breakdown').modal('hide');
            $('#select-jabatan').hide();
        },
        error: function(xhr, status, error) {
            // Tangani kesalahan saat mengirim permintaan AJAX
            console.error('Error:', error);
            resetSaveButton(saveButton); // Kembalikan tombol
        }
    });
}
// Fungsi untuk mengembalikan tombol ke keadaan semula
function resetSaveButton(button) {
    button.disabled = false;
    button.innerHTML = 'Save';
}

// Fungsi untuk memeriksa apakah ada nilai yang sama di dalam array
function hasDuplicates(array) {
    return (new Set(array)).size !== array.length;
}




</script>