<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Include librari phpmailer
include __DIR__ . '/../../controller/conn.php';
include __DIR__ . '/../../controller/phpmailer/Exception.php';
include __DIR__ . '/../../controller/phpmailer/PHPMailer.php';
include __DIR__ . '/../../controller/phpmailer/SMTP.php';


    

date_default_timezone_set('Asia/Jakarta');

$email_pengirim = 'notification@mng.dikgroup.id'; // Isikan dengan email pengirim
$nama_pengirim = "Notification DIK Group"; // Isikan dengan nama pengirim
$email_penerima = 'kevintg1212@gmail.com'; // Ambil email penerima dari inputan form
$email_password = 'NTDIKgroup123!';





// Ambil data event dari database
$sql = "SELECT * FROM dg_event";
echo "Before query execution -->".$dbxx;

$result = mysqli_query($db2, $sql);

if ($result) {
    echo "Query executed successfully!";
} else {
    echo "Query failed: " . mysqli_error($db2);
}


//echo 'PHP version: ' . phpversion().' date ='.date("Y-m-d H:i").'<br> email='.$email_password;

$current_time = date('H:i');
$current_date = date('Y-m-d');
$current_year = date('Y');
$current_month = date('m');
$current_day = date('d');
$current_dow = date('N'); // Minggu = 7, Senin = 1, dst.
$default_time = '07:00'; // Jam default untuk event yang tidak memiliki start_time

if ($current_dow == 7) {
    $current_dow = 1; // Ubah Minggu menjadi 1
} else {
    $current_dow += 1; // Ubah Senin-Sabtu menjadi 2-7
}


echo $current_time."</br>";
echo $current_date."</br>";
echo $current_year."</br>";
echo $current_month."</br>";
echo $current_day."</br>";
echo $current_dow."</br>";
echo $email_pengirim."</br>";


// Query untuk mendapatkan data hari libur
$sql_libur = "SELECT * FROM dg_event_hari_libur WHERE '$current_date' BETWEEN awal_tanggal_libur AND akhir_tanggal_libur";
$result_libur = mysqli_query($db2, $sql_libur);

// Cek apakah ada data yang cocok
    while ($row = mysqli_fetch_assoc($result)) {
        $type_event = $row['type_event'];

        $id_dg_user_group = $row['id_dg_user_group'];
        $pesan = $row['pesan_default'];
        
        echo $type_event."</br>";
        echo $row['nama_event']."</br>";
        echo 'id_dg_user_group ='.$id_dg_user_group."</br>";
        echo $row['start_year']."</br>";
        echo $row['finish_year']."</br>";
        echo $row['tanggal']."</br>";
        echo $row['bulan']."</br>";
        echo "start_time: ".$row['start_time']."</br>";

        // Mendapatkan waktu 3 jam sebelum start_time
        $start_time_minus = null;
        if (!is_null($row['start_time']) || $row['start_time'] == '') {
            $start_time_minus = date('H:i', strtotime('-3 hours', strtotime($row['start_time'])));
        }

        echo "start_time_minus : ".$start_time_minus."</br>";

        // Cek tipe event
        if ($type_event === 'yearly') {
            if (
                $current_year >= $row['start_year'] && 
                ($current_year <= $row['finish_year'] || is_null($row['finish_year'])) &&  // Jika finish_year NULL, anggap valid
                $current_day == $row['tanggal'] && 
                $current_month == $row['bulan'] &&
                    (
                        (!is_null($start_time_minus) && $current_time == $start_time_minus) || // Jika start_time ada, cocokkan dengan -3 jam
                        ((is_null($row['start_time']) || $row['start_time'] == '') && $current_time == $default_time)              // Jika start_time null, cocokkan jam
                    )
            ) {
            
                $start_time = $row['start_time'];
                echo "This One ! </br>";
                echo "email_pengirim =".$email_pengirim."</br>";

                // Ambil daftar email dari `dg_user_group_detail`
                $result_user = mysqli_query($db2, "SELECT * FROM `dg_user_group_detail` dd
                INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                WHERE dd.id_dg_user_group = $id_dg_user_group");
            
                // Kirim email untuk setiap user
                while ($d_user = mysqli_fetch_array($result_user)) {
                    $email_penerima = $d_user['email'];
                    $no_penerima = $d_user['nomor_hp'];
            
                            
                    // Periksa apakah nomor mengandung "@g"
                    if (strpos($no_penerima, '@g') === false) {
                        // Hilangkan spasi, strip, atau tanda-tanda lain
                        $no_penerima = preg_replace('/[^0-9\+]/', '', $no_penerima);

                        // Jika nomor dimulai dengan +62, ganti dengan 62
                        if (substr($no_penerima, 0, 3) == '+62') {
                            $no_penerima = substr($no_penerima, 1); // Hapus tanda +
                        }
                        // Jika nomor dimulai dengan 0, ganti dengan 62
                        elseif (substr($no_penerima, 0, 1) == '0') {
                            $no_penerima = '62' . substr($no_penerima, 1);
                        }
                    }
                                    
                    if (mysqli_num_rows($result_libur) > 0) {
                        echo "Hari libur</br>";
                    } else {         
                        sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
                    }
                }
            }
        } elseif ($type_event === 'monthly') {
            if (
                ($current_year == $row['finish_year'] || is_null($row['finish_year'])) && // Jika finish_year NULL, anggap valid
                ($current_month <= $row['finish_month'] || is_null($row['finish_month'])) && // Jika finish_month NULL, anggap valid
                $current_day == $row['tanggal'] &&
                    (
                        (!is_null($start_time_minus) && $current_time == $start_time_minus) || // Jika start_time ada, cocokkan dengan -3 jam
                        ((is_null($row['start_time']) || $row['start_time'] == '') && $current_time == $default_time)              // Jika start_time null, cocokkan jam
                    )
            ) {
                    $start_time = $row['start_time'];
                    
                    // Ambil daftar email dari `dg_user_group_detail`
                    $result_user = mysqli_query($db2, "SELECT * FROM `dg_user_group_detail` dd
                    INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                    WHERE dd.id_dg_user_group = $id_dg_user_group");
                        
                    // Kirim email untuk setiap user
                    while ($d_user = mysqli_fetch_array($result_user)) {
                            $email_penerima = $d_user['email'];
                            $no_penerima = $d_user['nomor_hp'];
            
                                    
                            // Hilangkan spasi, strip, atau tanda-tanda lain
                            $no_penerima = preg_replace('/[^0-9\+]/', '', $no_penerima);
                                            
                            // Jika nomor dimulai dengan +62, ganti dengan 62
                            if (substr($no_penerima, 0, 3) == '+62') {
                                $no_penerima = substr($no_penerima, 1); // Hapus tanda +
                            }
                            // Jika nomor dimulai dengan 0, ganti dengan 62
                            elseif (substr($no_penerima, 0, 1) == '0') {
                                $no_penerima = '62' . substr($no_penerima, 1);
                            }
                            if (mysqli_num_rows($result_libur) > 0) {
                                echo "Hari libur</br>";
                            } else {        
                                sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
                            }
                    }
            }
        } elseif ($type_event === 'weekly') {
            $weekly_dow_array = explode(',', $row['weekly_dow']);
            if (
                in_array($current_dow, $weekly_dow_array) && 
                $current_date >= $row['start_date'] && 
                ($current_date <= $row['finish_date'] || is_null($row['finish_date'])) && // Jika finish_date NULL, anggap valid
                    (
                        (!is_null($start_time_minus) && $current_time == $start_time_minus) || // Jika start_time ada, cocokkan dengan -3 jam
                        ((is_null($row['start_time']) || $row['start_time'] == '') && $current_time == $default_time)              // Jika start_time null, cocokkan jam
                    )
            ) {
            
                    $start_time = $row['start_time'];

                            // Ambil daftar email dari `dg_user_group_detail`
                $result_user = mysqli_query($db2, "SELECT * FROM `dg_user_group_detail` dd
                INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                WHERE dd.id_dg_user_group = $id_dg_user_group");
            
                // Kirim email untuk setiap user
                while ($d_user = mysqli_fetch_array($result_user)) {
                    $email_penerima = $d_user['email'];
                    $no_penerima = $d_user['nomor_hp'];
                    
                    echo 'email_penerima = '.$email_penerima.'<br>';
            
                            
                    // Periksa apakah nomor mengandung "@g"
                    if (strpos($no_penerima, '@g') === false) {
                        // Hilangkan spasi, strip, atau tanda-tanda lain
                        $no_penerima = preg_replace('/[^0-9\+]/', '', $no_penerima);

                        // Jika nomor dimulai dengan +62, ganti dengan 62
                        if (substr($no_penerima, 0, 3) == '+62') {
                            $no_penerima = substr($no_penerima, 1); // Hapus tanda +
                        }
                        // Jika nomor dimulai dengan 0, ganti dengan 62
                        elseif (substr($no_penerima, 0, 1) == '0') {
                            $no_penerima = '62' . substr($no_penerima, 1);
                        }
                    }
                    if (mysqli_num_rows($result_libur) > 0) {
                        echo "Hari libur</br>";
                    } else {
                        sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
                    }
                }
                
            
            }
        } elseif ($type_event === 'pick_date') {
            echo "Pick Date !<br>";
            if ($current_date == $row['start_date'] &&
                    (
                        (!is_null($start_time_minus) && $current_time == $start_time_minus) || // Jika start_time ada, cocokkan dengan -3 jam
                        ((is_null($row['start_time']) || $row['start_time'] == '') && $current_time == $default_time)              // Jika start_time null, cocokkan jam
                    )) {
                    $start_time = $row['start_time'];
                            // Ambil daftar email dari `dg_user_group_detail`
                $result_user = mysqli_query($db2, "SELECT * FROM `dg_user_group_detail` dd
                INNER JOIN dg_user du ON dd.id_dg_user = du.id_dg_user
                WHERE dd.id_dg_user_group = $id_dg_user_group");
            
                // Kirim email untuk setiap user
                while ($d_user = mysqli_fetch_array($result_user)) {
                    $email_penerima = $d_user['email'];
                    $no_penerima = $d_user['nomor_hp'];
            
                    // Periksa apakah nomor mengandung "@g"
                    if (strpos($no_penerima, '@g') === false) {
                        // Hilangkan spasi, strip, atau tanda-tanda lain
                        $no_penerima = preg_replace('/[^0-9\+]/', '', $no_penerima);

                        // Jika nomor dimulai dengan +62, ganti dengan 62
                        if (substr($no_penerima, 0, 3) == '+62') {
                            $no_penerima = substr($no_penerima, 1); // Hapus tanda +
                        }
                        // Jika nomor dimulai dengan 0, ganti dengan 62
                        elseif (substr($no_penerima, 0, 1) == '0') {
                            $no_penerima = '62' . substr($no_penerima, 1);
                        }
                    }
                    echo $email_pengirim."++".$nama_pengirim."++".$email_password."++".$email_penerima."++".$row['nama_event']."++".$row['start_time']."++".$pesan."++".$start_time."++".$no_penerima;
                    if (mysqli_num_rows($result_libur) > 0) {
                        echo "Hari libur</br>";
                    } else {
                        sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
                    }
                }
                
            }
        }
    }



function sendEmail($from, $name, $password, $to, $event_name, $start_time, $message, $waktu_jam, $phone_number) {
    echo "SEND !!!";
    $name = $name." : ".$event_name;
    // Variabel untuk tanggal dan waktu
    $event_date = date('l, d F Y'); // Contoh format: Monday, 01 January 2024
    $event_time = $start_time;

    // Path logo perusahaan
    $logo_path = 'https://dikgroup.id/management/dist/img/logogram.png'; // Ganti dengan URL yang sesuai atau path relatif


    $subjek = "Reminder for Event: $event_name";

        echo 'subjek -->'.$subjek."</br>";
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'ssl://mail.dikgroup.id';
        $mail->Username = $from; // Email Pengirim
        $mail->Password = $password; // Isikan dengan Password email pengirim
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Timeout = 60; // timeout pengiriman (dalam detik)
        $mail->SMTPKeepAlive = true; 
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
        $mail->setFrom($from, $name);
        $mail->addAddress($to, '');
        $mail->isHTML(true); // Aktifkan jika isi emailnya berupa html


                    // Array hari dan bulan dalam bahasa Indonesia
                    $hari_indonesia = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
                    $bulan_indonesia = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

                    // Mendapatkan hari, tanggal, bulan, dan tahun saat ini
                    $hari = $hari_indonesia[date('w')];
                    $tanggal = date('j');
                    $bulan = $bulan_indonesia[date('n')];
                    $tahun = date('Y');

                    // Format output: Hari, tanggal bulan tahun
                    echo "$hari, $tanggal $bulan $tahun";    


        $mail->Subject = $subjek;

        $message_wa = urldecode($message);
       
        $message = '<div style="display:flex;margin-bottom:20px">
                        <div style="margin-right:20px">
                            <img src="https://dikgroup.id/management/dist/img/logogram.png" alt="Logo Perusahaan" style="max-width:100px" class="CToWUd" data-bit="iit">
                        </div>
                        <div style="font-size:16px">
                            <b>'.$event_name.'</b><br>'.$hari.', '.$tanggal.' '.$bulan.' '.$tahun.' at '.$waktu_jam.'
                            </div>
                        </div>
                    </div>'.$message_wa;

        $mail->Body = $message;



        $send = $mail->send();
        session_start();
        echo 'Message has been sent';

        if ($send) {

            echo "sending";
        
        }else {
        
            echo "fail";
        
        }
        


        echo 'phone_number = '.$phone_number.'<br>';
        
        // Contoh penggunaan
        $formatted_number = $phone_number;
        
        echo 'formatted_number = '.$formatted_number.'<br>';

        // API Key Fonnte Anda
        $api_key = 'xJDWix7H3phtrgue1b+u'; 

        // Nomor tujuan (gunakan format internasional tanpa tanda +, misalnya 6281234567890 untuk Indonesia)
        //$target_number = '120363211973464084@g.us';




      function convertHtmlToPlainTextWA($html) {
            // Normalisasi line break dasar
            $html = str_replace(['<br>', '<br/>', '<br />', '</div>', '<div>'], "\n", $html);
            $html = str_replace(['<p>', '</p>'], "\n", $html);
            $html = str_replace(['&nbsp;'], ' ', $html);
            $html = str_replace(['&amp;'], '&', $html);

            // Tangani <ol> dan <ul>
            // Ordered list
            $html = preg_replace_callback('/<ol>(.*?)<\/ol>/si', function ($matches) {
                $listHtml = $matches[1];
                preg_match_all('/<li.*?>(.*?)<\/li>/si', $listHtml, $items);
                $output = '';
                foreach ($items[1] as $i => $item) {
                    $output .= ($i + 1) . '. ' . trim(strip_tags($item)) . "\n";
                }
                return $output;
            }, $html);

            // Unordered list
            $html = preg_replace_callback('/<ul>(.*?)<\/ul>/si', function ($matches) {
                $listHtml = $matches[1];
                preg_match_all('/<li.*?>(.*?)<\/li>/si', $listHtml, $items);
                $output = '';
                foreach ($items[1] as $item) {
                    $output .= '- ' . trim(strip_tags($item)) . "\n";
                }
                return $output;
            }, $html);

            // Bold dan italic formatting
            $html = preg_replace('/<\s*(strong|b)\s*>/', '*', $html);
            $html = preg_replace('/<\s*\/\s*(strong|b)\s*>/', '*', $html);
            $html = preg_replace('/<\s*(em|i)\s*>/', '_', $html);
            $html = preg_replace('/<\s*\/\s*(em|i)\s*>/', '_', $html);

            // Hapus sisa tag HTML
            $plain_text = strip_tags($html);

            // Normalisasi spasi dan line break
            $plain_text = html_entity_decode($plain_text);
            $plain_text = preg_replace("/[ \t]+/", ' ', $plain_text);
            $plain_text = preg_replace("/\n{3,}/", "\n\n", $plain_text); // Maks 2 line break berturut

            return trim($plain_text);
        }

        // Cara pakai:
        $plain_text = convertHtmlToPlainTextWA($message_wa);


        $plain_text = "*".$event_name."*\n".$hari.', '.$tanggal.' '.$bulan.' '.$tahun.' at '.$waktu_jam."\n\n".$plain_text;


        // URL endpoint API Fonnte
        $url = 'https://api.fonnte.com/send';

        

        // Data yang dikirim dalam POST request
        $data = [
            'target' => $formatted_number,
            'message' => $plain_text,
            'countryCode' => '62', // Kode negara penerima, untuk Indonesia gunakan 62
        ];

        // Opsi untuk cURL
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: $api_key"  // API Key dikirim dalam header
            ],
        ];

        // Inisiasi cURL dan kirim permintaan
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        // Cek jika ada kesalahan
        if ($error = curl_error($curl)) {
            echo "Error: $error";
        } else {
            // Tampilkan respon dari Fonnte
            echo "Response: $response";
        }

        // Tutup koneksi cURL
        curl_close($curl);


}



// Set waktu reminder jam 9 pagi
$reminder_time = '09:00';

// Cek jika waktu saat ini adalah jam 9 pagi
if ($current_time == $reminder_time) {
    // Ambil data ulang tahun dari tabel dg_user
    $sql_birthday = "SELECT * FROM dg_user WHERE DAY(ulang_tahun) = $current_day AND MONTH(ulang_tahun) = $current_month AND deleted_by is null AND status <= 4";
    $result_birthday = mysqli_query($db2, $sql_birthday);

    if ($result_birthday) {
        while ($row_birthday = mysqli_fetch_assoc($result_birthday)) {
            $email_penerima = $row_birthday['email'];
            $nama_user = $row_birthday['nama'];
            $tanggal_ulang_tahun = date('d F', strtotime($row_birthday['ulang_tahun']));
            
            // Kirim email pengingat ulang tahun
            $subjek = "Happy Birthday $nama_user!";

            // Array berisi 10 gaya pesan ucapan ulang tahun
            $pesan_list = [
                "HBD $nama_user! 🥳\nSemoga ulang tahunmu kali ini penuh kebahagiaan dan berkah.\nPanjang umur, sehat selalu!\n🎉 Selamat menikmati hari spesialmu!",
                "Happy Birthday, $nama_user! 🎂\nSemoga semua impianmu terkabul, dan tahun ini membawa lebih banyak kebahagiaan dan kesuksesan.\nDIK Group wishes you the best! 🎈",
                "Selamat ulang tahun, $nama_user! 🎉\nPanjang umur, sehat, sukses, dan penuh cinta selalu.\nSemoga hari ini menjadi awal dari tahun yang luar biasa! GBU 🙌",
                "Hi $nama_user, Happy Birthday! 🥳\nSemoga ulang tahun ini membawa kebahagiaan dan berkah yang melimpah.\nPanjang umur, sehat selalu, dan tetap semangat! 🎂🎁",
                "Wishing you the happiest birthday, $nama_user! 🎉\nSemoga hidupmu penuh warna, kesuksesan, dan kegembiraan sepanjang tahun ini.\nEnjoy your day! 🎊",
                "$nama_user, selamat ulang tahun! 🥳\nSemoga tahun ini membawa lebih banyak keceriaan, keberuntungan, dan kesuksesan.\nKeep shining! ✨",
                "HBD $nama_user! 🎂\nSemoga di hari spesial ini, kamu dikelilingi oleh cinta, kebahagiaan, dan harapan baik dari orang-orang tersayang.\nHave a blast! 🎈🎉",
                "Selamat ulang tahun $nama_user! 🎉\nSemoga umur panjang, kesehatan, dan kebahagiaan selalu menyertaimu.\nEnjoy your special day with love and joy! ❤️🎂",
                "Happy B'day $nama_user! 🎉\nSemoga kamu selalu diberi kesehatan, kesuksesan, dan kebahagiaan sepanjang tahun.\nDIK Group mengucapkan yang terbaik! 🎁",
                "$nama_user, wishing you a fabulous birthday filled with love, joy, and endless blessings. 🎂\nSelamat ulang tahun dan semoga harimu penuh kebahagiaan!",
                "Selamat ulang tahun $nama_user! 🎉\nSemoga kebahagiaan, cinta, dan kesuksesan selalu menyertaimu di setiap langkah kehidupan.\nStay awesome! 🎂💫",
                "Happy Birthday, $nama_user! 🎉\nSemoga tahun ini penuh keberkahan, kebahagiaan, dan cinta.\nEnjoy every moment and stay blessed!",
                "$nama_user, happy birthday! 🥳\nSemoga ulang tahun kali ini memberi banyak kebahagiaan dan kenangan indah.\nCheers to another amazing year ahead! 🎉",
                "Selamat ulang tahun, $nama_user! 🎂\nSemoga hidupmu selalu dipenuhi oleh cinta, keberuntungan, dan kebahagiaan.\nEnjoy your special day to the fullest! 🎊",
                "Wishing you the best on your special day, $nama_user! 🎉\nSemoga ulang tahun kali ini dipenuhi oleh cinta dan kegembiraan.\nStay blessed and joyful! 🎁",
                "HBD $nama_user! 🎂\nSelamat ulang tahun dan semoga kamu selalu sukses, sehat, dan bahagia.\nNikmati hari spesialmu dengan penuh sukacita! 🎉",
                "Happy Birthday, $nama_user! 🎉\nSemoga hidupmu penuh dengan kebahagiaan dan keceriaan setiap harinya.\nBest wishes from DIK Group! 🎊",
                "Selamat ulang tahun $nama_user! 🎉\nSemoga tahun ini membawa lebih banyak kebahagiaan, cinta, dan sukses.\nWe wish you all the best! 🎂",
                "Happy B'day $nama_user! 🥳\nSemoga setiap harimu dipenuhi dengan kebahagiaan dan kesuksesan.\nEnjoy this beautiful day to the fullest! 🎈🎉",
                "$nama_user, selamat ulang tahun! 🎂\nSemoga umur panjang, kesehatan, dan kesuksesan selalu mengiringi langkahmu.\nGBU and enjoy your day! 🎉",
            ];

            // Pilih pesan secara acak
            $pesan_random = $pesan_list[array_rand($pesan_list)];

            $nama_pengirim = "Happy B'day $nama_user!";

            sendEmailBirthday($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $subjek, $pesan_random);
        }
    }
}

// Fungsi untuk mengirim email ulang tahun
function sendEmailBirthday($from, $name, $password, $to, $subject, $message) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'ssl://mail.dggroup.id';
    $mail->Username = $from;
    $mail->Password = $password;
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->setFrom($from, $name);
    $mail->addAddress($to, '');
    $mail->isHTML(true);
    $mail->Subject = $subject;

    $pesan = str_replace("\n", "<br>", $message);

    // Pesan ulang tahun
    $mail->Body = $pesan;
    
    if ($mail->send()) {
        echo 'Birthday reminder sent successfully.';
    } else {
        echo 'Failed to send birthday reminder.';
    }



    
  
    $phone_number = '6282126184848-1623663250@g.us';
    //$phone_number = '6285156068580';

    // API Key Fonnte Anda
    $api_key = 'xJDWix7H3phtrgue1b+u'; 

    // URL endpoint API Fonnte
    $url = 'https://api.fonnte.com/send';

    // Data yang dikirim dalam POST request
    $data = [
        'target' => $phone_number,
        'message' => $message,
        'countryCode' => '62', // Kode negara penerima, untuk Indonesia gunakan 62
    ];

    // Opsi untuk cURL
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => [
            "Authorization: $api_key"  // API Key dikirim dalam header
        ],
    ];

    // Inisiasi cURL dan kirim permintaan
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);

    // Cek jika ada kesalahan
    if ($error = curl_error($curl)) {
        echo "Error: $error";
    } else {
        // Tampilkan respon dari Fonnte
        echo "Response: $response";
    }

    // Tutup koneksi cURL
    curl_close($curl);
}








$besok_date = date('Y-m-d', strtotime('+1 day'));

// Set waktu reminder jam 7 malam
$reminder_time2 = '18:50';


if ($current_time == $reminder_time2) {
    $task_list = []; // Menyimpan daftar task untuk setiap penerima

    // Ambil semua task dari event
    $sql_task = "SELECT u.email, u.nomor_hp, u.nama, t.deadline_task, t.isi_task, e.nama_event
                FROM dg_event_detail_task t
                INNER JOIN dg_user u ON t.id_dg_user = u.id_dg_user
                INNER JOIN dg_event_detail ed ON t.id_dg_event_detail = ed.id_dg_event_detail
                INNER JOIN dg_event e ON ed.id_dg_event = e.id_dg_event
                WHERE t.deadline_task <= DATE_SUB('$current_date', INTERVAL -14 DAY)
                AND t.status_task BETWEEN 0 AND 1";
    $result_task = mysqli_query($db2, $sql_task);

    while ($row = mysqli_fetch_assoc($result_task)) {
        $key = $row['email']; // Bisa pakai nomor HP juga
        if (!isset($task_list[$key])) {
            $task_list[$key] = [
                'email' => $row['email'],
                'phone' => formatPhoneNumber($row['nomor_hp']),
                'name' => $row['nama'],
                'tasks' => ['event' => [], 'teamspace' => []]
            ];
        }

        $hari_deadline = date('d F Y', strtotime($row['deadline_task']));
        $status_deadline = getDeadlineStatus($row['deadline_task'], $current_date, $besok_date);
        $task_list[$key]['tasks']['event'][] = "*".$row['nama_event']."*$status_deadline\nDeadline: ".$hari_deadline."\nTask: ".$row['isi_task']."\n";
        
    }

    // Ambil semua task dari teamspace
    $sql_task_assign = "SELECT u.email AS email_user, u.nomor_hp, u.nama, s.deadline_status, t.id_dg_client_project_task, t.nama_task, cp.id_dg_client_project, cp.nama_project, c.nama_client, ps.nama_status
                        FROM dg_client_project_task t
                        INNER JOIN dg_client_project_status_assign s ON t.id_dg_client_project_task = s.id_dg_client_project_task
                        INNER JOIN dg_user u ON s.id_dg_user_assign = u.id_dg_user
                        INNER JOIN dg_client_project cp ON t.id_dg_client_project = cp.id_dg_client_project
                        INNER JOIN dg_client c ON cp.id_dg_client = c.id_dg_client
                        INNER JOIN dg_client_project_status ps ON t.id_status = ps.id_dg_client_project_status
                        WHERE s.deadline_status <= DATE_SUB('$current_date', INTERVAL -14 DAY)
                        AND t.id_status = s.id_dg_client_project_status
                        AND cp.is_active = 1";
    $result_task_assign = mysqli_query($db2, $sql_task_assign);

    while ($row = mysqli_fetch_assoc($result_task_assign)) {
        $key = $row['email_user']; // Bisa pakai nomor HP juga
        if (!isset($task_list[$key])) {
            $task_list[$key] = [
                'email' => $row['email_user'],
                'phone' => formatPhoneNumber($row['nomor_hp']),
                'name' => $row['nama'],
                'tasks' => ['event' => [], 'teamspace' => []]
            ];
        }

        $hari_deadline = date('d F Y', strtotime($row['deadline_status']));
        $status_deadline = getDeadlineStatus($row['deadline_status'], $current_date, $besok_date);
        $task_link = "https://dikgroup.id/management/kanban.php?id=".$row['id_dg_client_project'];

        
        $task_list[$key]['tasks']['teamspace'][] = "*".$row['nama_client']." | ".$row['nama_project']."*$status_deadline\nDeadline: ".$hari_deadline."\nTask: ".$row['nama_task']."\nStatus: ".$row['nama_status']."\n🔗 *Link Task:* $task_link\n";
        
    }

    // Kirim satu pesan per penerima
    foreach ($task_list as $user) {
        if (empty($user['tasks']['event']) && empty($user['tasks']['teamspace'])) continue; // Lewati jika tidak ada task
    
        $no_task_event = 0; // Reset nomor event task untuk setiap user
        $no_task_teamspace = 0; // Reset nomor teamspace task untuk setiap user
    
        $message = "Halo, *".$user['name']."*.\nBerikut adalah daftar task Anda:\n\n";
    
        if (!empty($user['tasks']['event'])) {
            $message .= "====================\n🗓️ *Event Meeting Task:*\n====================\n\n";
            
            foreach ($user['tasks']['event'] as &$task) {
                $no_task_event++;
                $task = $no_task_event . ". " . $task; // Tambahkan nomor urutan ke setiap task
            }
            unset($task);
    
            $message .= implode("\n\n", $user['tasks']['event']) . "\n\n"; 
            $message .= "Update Status di: https://mng.dikgroup.id/\n\n";
        }
    
        if (!empty($user['tasks']['teamspace'])) {
            $message .= "====================\n👥 *Teamspace Task:*\n====================\n\n";
            
            foreach ($user['tasks']['teamspace'] as &$task) {
                $no_task_teamspace++;
                $task = $no_task_teamspace . ". " . $task; // Tambahkan nomor urutan ke setiap task
            }
            unset($task);
    
            $message .= implode("\n\n", $user['tasks']['teamspace']) . "\n\n"; 
        }
    
        $total_task = $no_task_event + $no_task_teamspace;
        $message .= "Harap segera selesaikan task Anda.\nTotal : $total_task task (2 Minggu ke depan).\nTerima kasih.";
    
        $subject = "Reminder Task - ".date('d F Y');
        sendReminderTask($email_pengirim, $user['name'], $email_password, $user['email'], $subject, $message, $user['phone']);
    }
    
}

// Fungsi untuk menentukan status deadline
function getDeadlineStatus($deadline, $current_date, $besok_date) {
    $diff = (strtotime($deadline) - strtotime($current_date)) / (60 * 60 * 24); // Hitung selisih hari

    if ($deadline < $current_date) {
        return "\n⛔ *SUDAH MELEBIHI DEADLINE*";
    } elseif ($deadline == $current_date) {
        return "\n⚠️ *Hari Ini Deadline*";
    } elseif ($deadline == $besok_date) {
        return "\n🔜 *Besok Deadline*";
    } elseif ($diff > 1) {
        return "\n🗓️ *Deadline dalam $diff hari*";
    }
    
    return "";
}

// Fungsi format nomor HP
function formatPhoneNumber($phone) {
    if (strpos($phone, '@g') === false) {
        $phone = preg_replace('/[^0-9\+]/', '', $phone);
        if (substr($phone, 0, 3) == '+62') {
            return substr($phone, 1);
        } elseif (substr($phone, 0, 1) == '0') {
            return '62' . substr($phone, 1);
        }
    }
    return $phone;
}

// Fungsi untuk mengirim reminder Task Melalui Teamspace / Event
function sendReminderTask($from, $name, $password, $to, $subject, $message, $phone_number) {
    $name_email = "DIK Group - MNG System";

    // Konversi teks yang diapit * menjadi <b>...</b> untuk email
    $message_html = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $message);

    // Ganti newline dengan <br> agar email tetap rapi
    $pesan_html = nl2br($message_html);

    // Setup PHPMailer
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'ssl://mail.dggroup.id';
    $mail->Username = $from;
    $mail->Password = $password;
    $mail->CharSet = 'UTF-8'; // Pastikan email menggunakan UTF-8
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->setFrom($from, $name_email);
    $mail->addAddress($to, '');
    $mail->isHTML(true);
    $mail->Subject = $subject;
    
    // Set body email dengan format HTML
    $mail->Body = $pesan_html;
    $mail->AltBody = strip_tags($message); // Versi text-only jika HTML tidak didukung

    // Kirim Email
    if ($mail->send()) {
        echo 'Task reminder sent successfully via email.<br>';
    } else {
        echo 'Failed to send Task reminder via email: ' . $mail->ErrorInfo . '<br>';
    }

    // Kirim ke WhatsApp menggunakan Fonnte API (tetap menggunakan * untuk bold)
    $message_wa = "*".$subject."*\n".$message;

    // Pastikan encoding UTF-8 benar
    $message_wa = mb_convert_encoding($message_wa, "UTF-8", "auto");

    // API Key Fonnte
    $api_key = 'xJDWix7H3phtrgue1b+u';

    // URL endpoint API Fonnte
    $url = 'https://api.fonnte.com/send';

    // Data yang dikirim dalam POST request
    $data = [
        'target' => $phone_number,
        'message' => $message_wa,
        'countryCode' => '62', // Kode negara penerima, untuk Indonesia gunakan 62
    ];

    // Opsi untuk cURL
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data), // Gunakan json_encode untuk memastikan encoding benar
        CURLOPT_HTTPHEADER => [
            "Authorization: $api_key",
            "Content-Type: application/json" // Pastikan dikirim dalam format JSON
        ],
    ];

    // Inisiasi cURL dan kirim permintaan
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);

    // Cek jika ada kesalahan
    if ($error = curl_error($curl)) {
        echo "Error sending WhatsApp: $error<br>";
    } else {
        echo "WhatsApp Response: $response<br>";
    }

    // Tutup koneksi cURL
    curl_close($curl);

}




?>
