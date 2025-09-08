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

// $email_pengirim = 'info@dggroup.id'; // Isikan dengan email pengirim
// $nama_pengirim = "Notification DIK Group"; // Isikan dengan nama pengirim
// $email_penerima = 'kevintg1212@gmail.com'; // Ambil email penerima dari inputan form
// $email_password = 'InfoDGGroup123!';





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


while ($row = mysqli_fetch_assoc($result)) {
    $type_event = $row['type_event'];

    $id_dg_user_group = $row['id_dg_user_group'];
    $pesan = $row['pesan_default'];
    
    echo $type_event."</br>";
    echo 'id_dg_user_group ='.$id_dg_user_group."</br>";
    echo $row['start_year']."</br>";
    echo $row['finish_year']."</br>";
    echo $row['tanggal']."</br>";
    echo $row['bulan']."</br>";
    echo $row['start_time']."</br>";

    // Mendapatkan waktu 3 jam sebelum start_time
    $start_time_minus = date('H:i', strtotime('-3 hours', strtotime($row['start_time'])));

    // Cek tipe event
    if ($type_event === 'yearly') {
        
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
                                
                                    
                sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
            }
        
    } elseif ($type_event === 'monthly') {
        
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
                                
                        sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
                }
        
    } elseif ($type_event === 'weekly') {
        $weekly_dow_array = explode(',', $row['weekly_dow']);
       
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

                sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
            }
            
        
        
    } elseif ($type_event === 'pick_date') {

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

                sendEmail($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $row['nama_event'], $row['start_time'], $pesan, $start_time, $no_penerima);
            }
            
        }
    
}


function sendEmail($from, $name, $password, $to, $event_name, $start_time, $message, $waktu_jam, $phone_number) {

    $name = $name." : ".$event_name;
    // Variabel untuk tanggal dan waktu
    $event_date = date('l, d F Y'); // Contoh format: Monday, 01 January 2024
    $event_time = $start_time;

    // Path logo perusahaan
    $logo_path = 'https://dikgroup.id/management/dist/img/logogram.png'; // Ganti dengan URL yang sesuai atau path relatif


    $subjek = "Reminder for Event: $event_name";

        echo 'subjek -->'.$subjek."</br>";
        // $mail = new PHPMailer;
        // $mail->isSMTP();
        // $mail->Host = 'ssl://mail.dggroup.id';
        // $mail->Username = $from; // Email Pengirim
        // $mail->Password = $password; // Isikan dengan Password email pengirim
        // $mail->Port = 465;
        // $mail->SMTPAuth = true;
        // $mail->Timeout = 60; // timeout pengiriman (dalam detik)
        // $mail->SMTPKeepAlive = true; 
        // $mail->SMTPSecure = 'ssl';
        // $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
        // $mail->setFrom($from, $name);
        // $mail->addAddress($to, '');
        // $mail->isHTML(true); // Aktifkan jika isi emailnya berupa html


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


        // $mail->Subject = $subjek;

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

        // $mail->Body = $message;



        // $send = $mail->send();
        session_start();
        echo 'Message has been sent';

        // if ($send) {

        //     echo "sending";
        
        // }else {
        
        //     echo "fail";
        
        // }
        


        echo 'phone_number = '.$phone_number.'<br>';
        
        // Contoh penggunaan
        $formatted_number = $phone_number;
        
        echo 'formatted_number = '.$formatted_number.'<br>';

        // API Key Fonnte Anda
        // $api_key = 'xJDWix7H3phtrgue1b+u'; 

        // Nomor tujuan (gunakan format internasional tanpa tanda +, misalnya 6281234567890 untuk Indonesia)
        //$target_number = '120363211973464084@g.us';




        // Mengganti &nbsp; dengan spasi biasa
        $message_wa = str_replace('&nbsp;', ' ', $message_wa);

        // Mengganti <br> atau <div> yang seharusnya menjadi line break dengan \n
        $message_wa = str_replace(['<br>', '<br/>', '</div>', '<div>'], "\n", $message_wa);

        // Mengganti <p> dengan enter ganda untuk pemisahan paragraf
        $message_wa = str_replace(['<p>', '</p>'], "\n", $message_wa);

        $message_wa = str_replace(['&amp;'], "&", $message_wa);
        
        // Menangani list dan menambahkan nomor otomatis pada <li> dalam <ol>
        $counter = 1;
        $message_wa = preg_replace_callback('/<ol>.*?<li.*?>(.*?)<\/li>.*?<\/ol>/s', function ($matches) {
            $items = explode('</li>', $matches[0]); // Pisahkan item list
            $result = '';
            $counter = 1;
            foreach ($items as $item) {
                if (strip_tags($item)) {
                    $result .= $counter++ . '. ' . strip_tags($item) . "\n"; // Tambahkan nomor
                }
            }
            return $result;
        }, $message_wa);

        // Menghapus tag HTML lainnya
        $plain_text = strip_tags($message_wa);




        $plain_text = $event_name."\n".$hari.', '.$tanggal.' '.$bulan.' '.$tahun.' at '.$waktu_jam."\n\n".$plain_text;

        echo "<br> plain_text = <br>".$plain_text."<br>";
        // URL endpoint API Fonnte
        // $url = 'https://api.fonnte.com/send';

        

        // Data yang dikirim dalam POST request
        // $data = [
        //     'target' => $formatted_number,
        //     'message' => $plain_text,
        //     'countryCode' => '62', // Kode negara penerima, untuk Indonesia gunakan 62
        // ];

        // Opsi untuk cURL
        // $options = [
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => http_build_query($data),
        //     CURLOPT_HTTPHEADER => [
        //         "Authorization: $api_key"  // API Key dikirim dalam header
        //     ],
        // ];

        // Inisiasi cURL dan kirim permintaan
        // $curl = curl_init();
        // curl_setopt_array($curl, $options);
        // $response = curl_exec($curl);

        // // Cek jika ada kesalahan
        // if ($error = curl_error($curl)) {
        //     echo "Error: $error";
        // } else {
        //     // Tampilkan respon dari Fonnte
        //     echo "Response: $response";
        // }

        // // Tutup koneksi cURL
        // curl_close($curl);


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

            // sendEmailBirthday($email_pengirim, $nama_pengirim, $email_password, $email_penerima, $subjek, $pesan_random);
        }
    }
}

// Fungsi untuk mengirim email ulang tahun
function sendEmailBirthday($from, $name, $password, $to, $subject, $message) {
    // $mail = new PHPMailer;
    // $mail->isSMTP();
    // $mail->Host = 'ssl://mail.dggroup.id';
    // $mail->Username = $from;
    // $mail->Password = $password;
    // $mail->Port = 465;
    // $mail->SMTPAuth = true;
    // $mail->SMTPSecure = 'ssl';
    // $mail->setFrom($from, $name);
    // $mail->addAddress($to, '');
    // $mail->isHTML(true);
    // $mail->Subject = $subject;

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
    // $api_key = 'xJDWix7H3phtrgue1b+u'; 

    // URL endpoint API Fonnte
    // $url = 'https://api.fonnte.com/send';

    // Data yang dikirim dalam POST request
    // $data = [
    //     'target' => $phone_number,
    //     'message' => $message,
    //     'countryCode' => '62', // Kode negara penerima, untuk Indonesia gunakan 62
    // ];

    // Opsi untuk cURL
    // $options = [
    //     CURLOPT_URL => $url,
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_POST => true,
    //     CURLOPT_POSTFIELDS => http_build_query($data),
    //     CURLOPT_HTTPHEADER => [
    //         "Authorization: $api_key"  // API Key dikirim dalam header
    //     ],
    // ];

    // Inisiasi cURL dan kirim permintaan
    // $curl = curl_init();
    // curl_setopt_array($curl, $options);
    // $response = curl_exec($curl);

    // Cek jika ada kesalahan
    // if ($error = curl_error($curl)) {
    //     echo "Error: $error";
    // } else {
    //     // Tampilkan respon dari Fonnte
    //     echo "Response: $response";
    // }

    // // Tutup koneksi cURL
    // curl_close($curl);
}





?>
