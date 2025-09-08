<?php
// mengaktifkan session
header('Content-Type: application/json');
session_start();
include '../../controller/conn.php';


                        // Ambil parameter currentYear dari AJAX
                        $currentYear = isset($_GET['currentYear']) ? intval($_GET['currentYear']) : date('Y');
                        $currentMonth = isset($_GET['currentMonth']) ? intval($_GET['currentMonth']) : date('m');

                        // 1. Ambil semua data perubahan tanggal dari dg_event_detail
                        $mapTanggalBerubah = [];
                        $skipWeeklyDate = [];

                        $result_detail = mysqli_query($db2, "
                            SELECT id_dg_event, dg_event_tanggal, dg_event_tanggal_berubah 
                            FROM dg_event_detail 
                            WHERE dg_event_tanggal_berubah IS NOT NULL
                        ");

                        while ($row = mysqli_fetch_assoc($result_detail)) {
                            $id = $row['id_dg_event'];
                            $tanggalAsli = $row['dg_event_tanggal'];
                            $tanggalBaru = $row['dg_event_tanggal_berubah'];

                            $mapTanggalBerubah[$id][$tanggalAsli] = $tanggalBaru;

                            // Tandai tanggal yang perlu di-skip untuk weekly
                            $skipWeeklyDate[$id][$tanggalAsli] = true;
                        }


                        $skipOriginalEvent = [];
                        foreach ($mapTanggalBerubah as $eventId => $entries) {
                            foreach ($entries as $tanggalAsli => $tanggalBaru) {
                                $skipOriginalEvent[$eventId][$tanggalAsli] = true;
                            }
                        }

                        // 2. Ambil event utama yang memang dijadwalkan untuk bulan ini
                        $result_event = mysqli_query($db2, "SELECT * FROM dg_event
                            WHERE 
                                (
                                    (start_year <= $currentYear AND (finish_year >= $currentYear OR finish_year IS NULL) AND bulan = $currentMonth)
                                )
                                OR 
                                (
                                    (start_month <= $currentMonth AND (finish_month >= $currentMonth OR finish_month IS NULL))
                                )
                                OR 
                                (
                                    ((YEAR(start_date) * 100 + MONTH(start_date)) <= ($currentYear * 100 + $currentMonth))
                                    AND 
                                    (
                                        ((YEAR(finish_date) * 100 + MONTH(finish_date)) >= ($currentYear * 100 + $currentMonth)) 
                                        OR finish_date IS NULL
                                    )
                                )
                        ");

                        $events = [];

                        while($d_event = mysqli_fetch_array($result_event)){

                            $startTime = !empty($d_event['start_time']) ? $d_event['start_time'] : '07:00:00';
                            $finishTime = !empty($d_event['finish_time']) ? $d_event['finish_time'] : '09:00:00';

                            $endYear = isset($d_event['finish_year']) ? $d_event['finish_year'] : 9999;
                            $endMonth = isset($d_event['finish_month']) ? $d_event['finish_month'] : 12;

                            $idEvent = $d_event['id_dg_event'];



                            if($d_event['type_event']=='yearly'){

                                $tanggalOriginal = sprintf('%04d-%02d-%02d', $currentYear, $d_event['bulan'], $d_event['tanggal']);
                                
                                if (isset($skipOriginalEvent[$idEvent][$tanggalOriginal])) continue;

                                $tanggalFinal = $tanggalOriginal;
                                $tanggalFinalDate = new DateTime($tanggalFinal);

                                $events[] = [
                                    'id' => $idEvent . '_' . $tanggalFinal,
                                    'title' => $d_event['nama_event'],
                                    'date' => (int)$tanggalFinalDate->format('d'),
                                    'month' => (int)$tanggalFinalDate->format('m'),
                                    'start' => $startTime,
                                    'finish' => $finishTime,
                                    'startYear' => $d_event['start_year'],
                                    'endYear' => $endYear,
                                    'backgroundColor' => $d_event['background_color'],
                                    'borderColor' => $d_event['background_color'],
                                    'freq' => 'yearly',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id=' . $idEvent . '&tanggal=' . $tanggalFinal
                                ];


                            } elseif($d_event['type_event']=='monthly'){

                                $tanggalOriginal = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $d_event['tanggal']);

                                $tanggalFinal = isset($mapTanggalBerubah[$idEvent][$tanggalOriginal])
                                            ? $mapTanggalBerubah[$idEvent][$tanggalOriginal]
                                            : $tanggalOriginal;

                                // Ambil kembali nilai tanggal dan bulan dari $tanggalFinal
                                $tanggalFinalDate = new DateTime($tanggalFinal);
                                $finalDay   = (int)$tanggalFinalDate->format('d');
                                $finalMonth = (int)$tanggalFinalDate->format('m');

                                $events[] = [
                                    'id' => $d_event['id_dg_event']."_".$tanggalFinal,
                                    'title' => $d_event['nama_event'],
                                    'date' => $finalDay,
                                    'start' => $startTime, 
                                    'finish' =>  $finishTime,
                                    'startMonthYear' => $d_event['start_year'].'-'.$d_event['start_month'], // Bulan dan tahun awal
                                    'endMonthYear' => $endYear."-".$endMonth,   // Bulan dan tahun akhir (opsional)
                                    'backgroundColor' => $d_event['background_color'],
                                    'borderColor' => $d_event['background_color'],
                                    'freq' => 'monthly',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id='.$d_event['id_dg_event'].'&tanggal='.$tanggalFinal
                                ];

                            } elseif($d_event['type_event']=='weekly'){

                                $weekly_dow = explode(',', $d_event['weekly_dow']);
                                $weekly_dow = array_map('intval', $weekly_dow);
                                          
                                $startWeekly = new DateTime($d_event['start_date']);
                                $endWeekly = $d_event['finish_date'] ? new DateTime($d_event['finish_date']) : new DateTime('9999-12-31');

                                $currentDate = new DateTime("$currentYear-$currentMonth-01");
                                $currentMonthStr = $currentDate->format('m');

                                foreach ($weekly_dow as $dow) {
                                    // Temukan tanggal pertama yang cocok
                                    $firstOfMonth = new DateTime("$currentYear-$currentMonth-01");
                                    $selisihHari = (($dow - $firstOfMonth->format('N') + 7) % 7)-1;
                                    $firstOfMonth->modify("+$selisihHari days");

                                    while ($firstOfMonth->format('m') == $currentMonthStr) {
                                        $eventDateStr = $firstOfMonth->format('Y-m-d');

                                        // Skip jika sudah ada override untuk tanggal ini
                                        if (isset($skipWeeklyDate[$d_event['id_dg_event']][$eventDateStr])) {
                                            $firstOfMonth->modify('+7 days');
                                            continue;
                                        }

                                        // Pastikan tanggal ini dalam rentang aktif
                                        if ($firstOfMonth >= $startWeekly && $firstOfMonth <= $endWeekly) {
                                            $events[] = [
                                                'id' => $d_event['id_dg_event'] . '_' . $eventDateStr,
                                                'title' => $d_event['nama_event'],
                                                'start' => $eventDateStr . ' ' . $startTime,
                                                'end' => $eventDateStr . ' ' . $finishTime,
                                                'backgroundColor' => $d_event['background_color'],
                                                'borderColor' => $d_event['background_color'],
                                                'freq' => 'pick_date',
                                                'allDay' => false,
                                                'url' => 'calendar_event_detail.php?id=' . $d_event['id_dg_event'] . '&tanggal=' . $eventDateStr
                                            ];
                                        }

                                        $firstOfMonth->modify('+7 days');
                                    }
                                }
                                

                            } elseif($d_event['type_event']=='pick_date'){


                                $tanggalOriginal = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, date('d', strtotime(date($d_event['start_date']))));

                                $tanggalFinal = isset($mapTanggalBerubah[$idEvent][$tanggalOriginal])
                                            ? $mapTanggalBerubah[$idEvent][$tanggalOriginal]
                                            : $tanggalOriginal;

                                // Ambil kembali nilai tanggal dan bulan dari $tanggalFinal
                                $tanggalFinalDate = new DateTime($tanggalFinal);
                                $finalDay   = (int)$tanggalFinalDate->format('d');
                                $finalMonth = (int)$tanggalFinalDate->format('m');
                                $finalYear = (int)$tanggalFinalDate->format('Y');

                                $events[] = [
                                    'id' => $d_event['id_dg_event']."_".$tanggalFinal,
                                    'title' => $d_event['nama_event'],
                                    'start' => date($d_event['start_date'].' '.$startTime),
                                    'end' => date($d_event['finish_date'].' '.$finishTime ),
                                    'backgroundColor' => '#ff12ff',
                                    'borderColor' => '#ff12ff',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id='.$d_event['id_dg_event'].'&tanggal='.$tanggalFinal
                                ];

                            }
                        }

                        // 3. Tambahkan event dari dg_event_detail yang pindah ke bulan ini
                        $result_perubahan = mysqli_query($db2, "
                            SELECT d.id_dg_event, d.dg_event_tanggal, d.dg_event_tanggal_berubah, e.*
                            FROM dg_event_detail d
                            JOIN dg_event e ON d.id_dg_event = e.id_dg_event
                            WHERE 
                                MONTH(d.dg_event_tanggal_berubah) = $currentMonth AND 
                                YEAR(d.dg_event_tanggal_berubah) = $currentYear
                        ");

                        while ($d_event = mysqli_fetch_array($result_perubahan)) {
                            $idEvent = $d_event['id_dg_event'];
                            $tanggalFinal = $d_event['dg_event_tanggal_berubah'];
                            $tanggalFinalDate = new DateTime($tanggalFinal);
                            $startTime = !empty($d_event['start_time']) ? $d_event['start_time'] : '07:00:00';
                            $finishTime = !empty($d_event['finish_time']) ? $d_event['finish_time'] : '09:00:00';

                            $events[] = [
                                'id' => $idEvent . '_' . $tanggalFinal,
                                'title' => $d_event['nama_event'],
                                'date' => (int)$tanggalFinalDate->format('d'),
                                'month' => (int)$tanggalFinalDate->format('m'),
                                'start' => $tanggalFinal . ' ' . $startTime,
                                'end' => $tanggalFinal . ' ' . $finishTime,
                                'backgroundColor' => $d_event['background_color'],
                                'borderColor' => $d_event['background_color'],
                                'freq' => 'override',
                                'allDay' => false,
                                'url' => 'calendar_event_detail.php?id=' . $idEvent . '&tanggal=' . $tanggalFinal
                            ];
                        }


// Query untuk mengambil data pengguna yang ulang tahun
$result_user = mysqli_query($db2, "SELECT * FROM dg_user WHERE MONTH(ulang_tahun) = $currentMonth AND deleted_by is null AND status <= 4");

// Loop untuk menambahkan event ulang tahun
while ($d_user = mysqli_fetch_array($result_user)) {
    $user_birthday = new DateTime($d_user['ulang_tahun']);
    $user_birthday_year = $user_birthday->format('Y');
    
    // Jika ulang tahun terjadi di bulan yang sedang diproses
    if ($currentYear >= $user_birthday_year) {
        $birthday_event_date = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($user_birthday->format('d'), 2, '0', STR_PAD_LEFT);
        
        // Menambahkan event ulang tahun dengan jam 9 pagi - 10 pagi
        $events[] = [
            'id' => 'birthday_' . $d_user['id_dg_user'] . '_' . $birthday_event_date,
            'title' =>  'Ulang Tahun 🎉 | '.$d_user['nama'],
            'start' => $birthday_event_date . ' 09:00:00',
            'end' => $birthday_event_date . ' 10:00:00',
            'backgroundColor' => '#FFD700',  // Warna latar kuning
            'borderColor' => '#FFD700',      // Warna border kuning
            'allDay' => false
        ];
    }
}



// Filter events berdasarkan frekuensi
$filteredEvents = [];
$event = [];
foreach ($events as $event) {
    if (isset($event['freq'])) {
        if ($event['freq'] === 'yearly') {
            // Proses event tahunan
            if (isset($event['startYear'])) {
                $startYear = $event['startYear'];
                $endYear = isset($event['endYear']) ? $event['endYear'] : 9999;

                if ($currentYear >= $startYear && $currentYear <= $endYear) {
                    $eventDate = sprintf('%d-%02d-%02d', $currentYear, $event['month'], $event['date']);
                    $event['start'] = $eventDate . ' ' . $event['start'];
                    $event['end'] = $eventDate . ' ' . $event['finish'];
                    $filteredEvents[] = $event;
                }
            }
        } elseif ($event['freq'] === 'monthly') {
            // Proses event bulanan
            if (isset($event['startMonthYear'])) {
                $startYearMonth = new DateTime($event['startMonthYear'] . '-01');
                $endYearMonth = isset($event['endMonthYear']) ? new DateTime($event['endMonthYear'] . '-01') : new DateTime('9999-12-31');

                $currentDate = new DateTime($currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-01');

                if ($currentDate >= $startYearMonth && $currentDate <= $endYearMonth) {
                    $eventDate = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($event['date'], 2, '0', STR_PAD_LEFT);
                    $event['start'] = $eventDate . ' ' . $event['start'];
                    $event['end'] = $eventDate . ' ' . $event['finish'];
                    $filteredEvents[] = $event;
                }
            }
        } elseif ($event['freq'] === 'weekly') {
            // Proses event mingguan
            
        } else {
            // Jika tidak ada frekuensi, tambahkan event tanpa filter
            $filteredEvents[] = $event;
        }
    } else {
        // Jika tidak ada frekuensi, tambahkan event tanpa filter
        $filteredEvents[] = $event;
    }
}





// Mengubah array ke JSON
echo json_encode($filteredEvents);

?>
