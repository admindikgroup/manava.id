<?php

        $notes_mom = $_POST['notes_mom'];
        $nama_event = $_POST['nama_event'];
        $hari_tanggal = $_POST['hari_tanggal'];

        // API Key Fonnte Anda
        $api_key = 'xJDWix7H3phtrgue1b+u'; 

        // Nomor tujuan (gunakan format internasional tanpa tanda +, misalnya 6281234567890 untuk Indonesia)
        $target_number = '120363211973464084@g.us';
        //$target_number = '6285156068580';

        $message_wa = urldecode($notes_mom);

        // Menghapus atribut HTML dari tag <b>, <i>, <p>, dll.
        $message_wa = preg_replace('/<(\w+)(\s+[^>]*)?>/', '<$1>', $message_wa);
        
        // Mengganti &nbsp; dengan spasi biasa
        $message_wa = str_replace('&nbsp;', ' ', $message_wa);
        
        // Mengganti <p> dengan enter ganda untuk pemisahan paragraf
        $message_wa = str_replace(['<p>'], "", $message_wa);
        $message_wa = str_replace(['</p>'], "\n", $message_wa);

        $message_wa = str_replace(['&nbsp;</b>', '<br></b>'], "</b>", $message_wa);
        
        // Mengganti <b> dengan tanda *
        $message_wa = str_replace(['<b>', '</b>'], "*", $message_wa);
        
        // Mengganti <i> dengan tanda _
        $message_wa = str_replace(['<i>', '</i>'], "_", $message_wa);
        
        // Mengganti <br> atau <div> dengan line break (\n)
        $message_wa = str_replace(['<br>', '<br/>', '</div>', '<div>'], "\n", $message_wa);
        
        // Menangani list dan menambahkan nomor otomatis pada <li> dalam <ol>
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
        
        // Menghapus tag HTML lainnya yang tersisa
        $plain_text = strip_tags($message_wa);
        




        $plain_text = "*Minute of Meeting*\n".$nama_event."\n".$hari_tanggal."\n\n".$plain_text;


        // URL endpoint API Fonnte
        $url = 'https://api.fonnte.com/send';

        

        // Data yang dikirim dalam POST request
        $data = [
            'target' => $target_number,
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
            echo json_encode(['success' => false, 'message' => $error]);
        } else {
            // Tampilkan respon dari Fonnte
            echo json_encode(['success' => true, 'response' => $response]);
        }

        // Tutup koneksi cURL
        curl_close($curl);




?>
