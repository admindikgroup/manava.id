<?php 
// Mengaktifkan session
session_start();
include '../../controller/conn.php';
date_default_timezone_set('Asia/Jakarta');

// Ambil data dari database
$result_head = mysqli_query($db2, "SELECT * FROM dg_event ORDER BY id_dg_event DESC");

$id_user = $_SESSION['id_user'];
// Menyimpan data dalam array
$data = [];
$no =0;
while ($d_head = mysqli_fetch_assoc($result_head)) {
    $show = "";
    if ($d_head['created_by']!=$id_user && $_SESSION['statusX']>2) {
        $show = "disabled";
    }
    
    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $hari = [
        1 => 'Minggu',
        2 => 'Senin',
        3 => 'Selasa',
        4 => 'Rabu',
        5 => 'Kamis',
        6 => 'Jumat',
        7 => 'Sabtu'
    ];
    $no++;

    $hari_array = explode(',', $d_head['weekly_dow']);
    $nama_hari_string = [];
    foreach ($hari_array as $day) {
        $nama_hari_string[] = $hari[(int)$day];
    }
    $hari_text = implode(', ', $nama_hari_string);
    
    $data[] = [
        'no' => $no,
        'nama_event' => $d_head['nama_event'],
        'type_event' => $d_head['type_event'],
        'id_dg_user_group' => $d_head['id_dg_user_group'],
        'summernote' => $d_head['pesan_default'],
        'pengulangan' => ($d_head['type_event'] == 'yearly' ? 'Setiap Tahun, pada tanggal <br>' . $d_head['tanggal'] . '-' . $bulan[$d_head['bulan']] :
                         ($d_head['type_event'] == 'monthly' ? 'Setiap Bulan, pada tanggal <br>' . $d_head['tanggal'] :
                         ($d_head['type_event'] == 'weekly' ? 'Setiap Minggu, pada hari <br>' . $hari_text : '-'))),
        'waktu_mulai_akhir' => (
                            $d_head['type_event'] == 'yearly'
                                ? $bulan[$d_head['start_month']] . ' ' . $d_head['start_year'] . ' - ' .
                                  ($d_head['finish_year'] == '9999' ? 'not set' : $bulan[$d_head['finish_month']] . ' ' . $d_head['finish_year'])
                            : ($d_head['type_event'] == 'monthly'
                                ? $bulan[$d_head['start_month']] . ' ' . $d_head['start_year'] . ' - ' .
                                  ($d_head['finish_year'] == '9999' ? 'not set' : $bulan[$d_head['finish_month']] . ' ' . $d_head['finish_year'])
                            : (
                                date_format(date_create($d_head['start_date']), "d F Y") . ' - ' .
                                (strpos($d_head['finish_date'], '9999') !== false ? 'not set' : date_format(date_create($d_head['finish_date']), "d F Y"))
                            ))
                        ),
        'pukul' => $d_head['start_time'] . '-' . $d_head['finish_time'],
        'background_color' => $d_head['background_color'],
        'actions' => [
            'edit' => [
                'id' => $d_head['id_dg_event'],
                'nama_event' => $d_head['nama_event'],
                'type_event' => $d_head['type_event'],
                'id_dg_user_group' => $d_head['id_dg_user_group'],
                'summernote' => $d_head['pesan_default'],
                'background_color' => $d_head['background_color'],
                'tanggal' => $d_head['tanggal'],
                'bulan' => $d_head['bulan'],
                'start_year' => $d_head['start_year'],
                'finish_year' => $d_head['finish_year'],
                'start_month' => $d_head['start_month'],
                'finish_month' => $d_head['finish_month'],
                'start_date' => $d_head['start_date'],
                'finish_date' => $d_head['finish_date'],
                'start_time' => $d_head['start_time'],
                'finish_time' => $d_head['finish_time'],
                'weekly_dow' => $d_head['weekly_dow'],
                'show' => $show
            ],
            'delete' => [
                'id' => $d_head['id_dg_event'],
                'nama_event' => $d_head['nama_event']
            ]
        ]
    ];
}

// Mengeluarkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
