<?php
// mengaktifkan session
header('Content-Type: application/json');
session_start();
include '../../controller/conn.php';

// Ambil parameter currentYear dari AJAX
$currentYear = isset($_GET['currentYear']) ? intval($_GET['currentYear']) : date('Y');
$currentMonth = isset($_GET['currentMonth']) ? intval($_GET['currentMonth']) : date('m');

// Array untuk menyimpan events
$events = [];

$result_event = mysqli_query($db2,"SELECT * FROM dg_event
                        WHERE (start_year <= $currentYear and finish_year >= $currentYear and bulan = $currentMonth)
                        OR (start_month <= $currentMonth and finish_month >= $currentMonth )
                        OR (
                                (YEAR(start_date) * 100 + MONTH(start_date)) <= ($currentYear * 100 + $currentMonth)
                                AND ((YEAR(finish_date) * 100 + MONTH(finish_date)) >= ($currentYear * 100 + $currentMonth) OR finish_date IS NULL)
                            )");
                        while($d_event = mysqli_fetch_array($result_event)){
                            if($d_event['type_event']=='yearly'){
                                $events[] = [
                                    'id' => $d_event['id_dg_event']."_".$currentYear."-".$d_event['bulan']."-".$d_event['tanggal'],
                                    'title' => $d_event['nama_event'],
                                    'date' => $d_event['tanggal'],
                                    'month' => $d_event['bulan'],
                                    'start' => $d_event['start_time'], 
                                    'finish' => $d_event['finish_time'], 
                                    'startYear' => $d_event['start_year'], // Tahun awal
                                    'endYear' => $d_event['finish_year'],   // Tahun akhir (opsional)
                                    'backgroundColor' => $d_event['background_color'],
                                    'borderColor' => $d_event['background_color'],
                                    'freq' => 'yearly',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id='.$d_event['id_dg_event'].'&tanggal='.$currentYear."-".$d_event['bulan']."-".$d_event['tanggal']
                                ];

                            } elseif($d_event['type_event']=='monthly'){

                                $events[] = [
                                    'id' => $d_event['id_dg_event']."_".$currentYear."-".$currentMonth."-".$d_event['tanggal'],
                                    'title' => $d_event['nama_event'],
                                    'date' => $d_event['tanggal'],
                                    'start' => $d_event['start_time'], 
                                    'finish' => $d_event['finish_time'], 
                                    'startMonthYear' => $d_event['start_year'].'-'.$d_event['start_month'], // Bulan dan tahun awal
                                    'endMonthYear' => $d_event['finish_year'].'-'.$d_event['finish_month'],   // Bulan dan tahun akhir (opsional)
                                    'backgroundColor' => $d_event['background_color'],
                                    'borderColor' => $d_event['background_color'],
                                    'freq' => 'monthly',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id='.$d_event['id_dg_event'].'&tanggal='.$currentYear."-".$currentMonth."-".$d_event['tanggal']
                                ];

                            } elseif($d_event['type_event']=='weekly'){
                                $weekly_dow = explode(',', $d_event['weekly_dow']);
                                $weekly_dow = array_map('intval', $weekly_dow);
                                $events[] = [
                                    'id' => $d_event['id_dg_event'],
                                    'title' => $d_event['nama_event'],
                                    'dow' => $weekly_dow,
                                    'start' => $d_event['start_time'], 
                                    'finish' => $d_event['finish_time'], 
                                    'startWeekly' => $d_event['start_date'], // Bulan dan tahun awal
                                    'endWeekly' => $d_event['finish_date'],   // Bulan dan tahun akhir (opsional)
                                    'backgroundColor' => $d_event['background_color'],
                                    'borderColor' => $d_event['background_color'],
                                    'freq' => 'weekly',
                                    'allDay' => false
                                ];
                                

                            } elseif($d_event['type_event']=='pick_date'){
                                $events[] = [
                                    'id' => $d_event['id_dg_event']."_".$currentYear."-".$currentMonth."-".$d_event['tanggal'],
                                    'title' => $d_event['nama_event'],
                                    'start' => date($d_event['start_date'].' '.$d_event['start_time']),
                                    'end' => date($d_event['finish_date'].' '.$d_event['finish_time']),
                                    'backgroundColor' => '#ff12ff',
                                    'borderColor' => '#ff12ff',
                                    'allDay' => false,
                                    'url' => 'calendar_event_detail.php?id='.$d_event['id_dg_event'].'&tanggal='.$currentYear."-".$currentMonth."-". date('d', strtotime(date($d_event['start_date'])))
                                ];

                            }
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
                $endYear = isset($event['endYear']) ? $event['endYear'] : PHP_INT_MAX;

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
            if (isset($event['startWeekly'])) {
                $startWeekly = new DateTime($event['startWeekly']);
                $endWeekly = isset($event['endWeekly']) ? new DateTime($event['endWeekly']) : new DateTime('9999-12-31');


                $currentDate = new DateTime($currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-01');
                // Gabungkan tahun dan bulan untuk memudahkan perbandingan dalam format YYYYMM
                $startWeeklyYearMonth = $startWeekly->format('Ym');  // Menghasilkan format 'YYYYMM'
                $endWeeklyYearMonth = $endWeekly->format('Ym');      // Menghasilkan format 'YYYYMM'
                $currentYearMonth = $currentDate->format('Ym');      // 'YYYYMM' dari $currentYear dan $currentMonth

                // Bandingkan YYYYMM
                if ($currentYearMonth >= $startWeeklyYearMonth && $currentYearMonth <= $endWeeklyYearMonth) {
                    foreach ($event['dow'] as $dayOfWeek) {
                        // Temukan tanggal pertama bulan ini
                        $firstDayOfMonth = new DateTime($currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-01');

                        // Temukan tanggal pertama yang sesuai dengan dayOfWeek dalam bulan ini
                        $firstDayOfMonth->modify('+' . ((($dayOfWeek - 1) - $firstDayOfMonth->format('N') + 7) % 7) . ' days');
                        

                        // Iterasi untuk setiap hari dengan dayOfWeek dalam bulan ini
                        while ($firstDayOfMonth->format('m') == str_pad($currentMonth, 2, '0', STR_PAD_LEFT)) {
                            if ($firstDayOfMonth >= $startWeekly && $firstDayOfMonth <= $endWeekly) {
                                $eventDate = $firstDayOfMonth->format('Y-m-d');
                                $filteredEvent = $event;
                                $filteredEvent['id'] = $event['id'] . '_' . $dayOfWeek . '_' . $firstDayOfMonth->format('j'); // Unique ID for each event
                                $filteredEvent['start'] = $eventDate . ' ' . $event['start'];
                                $filteredEvent['end'] = $eventDate . ' ' . $event['finish'];
                                $filteredEvent['url'] = 'calendar_event_detail.php?id='.$event['id'].'&tanggal='.$currentYear."-".$currentMonth."-".$firstDayOfMonth->format('d');
                                $filteredEvents[] = $filteredEvent;
                            }
                            // Pindah ke minggu berikutnya
                            $firstDayOfMonth->modify('+1 week');
                        }
                    }
                }
            }
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
