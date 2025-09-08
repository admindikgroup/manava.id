<?php

    $notes_mom = $_POST['notes_mom'];
    $nama_event = $_POST['nama_event'];
    $hari_tanggal = $_POST['hari_tanggal'];
    $target = $_POST['target']; // announcement, wa_group, all, individual
    $nomor = $_POST['nomor'] ?? null;

    // API Key Fonnte Anda
    $api_key = 'xJDWix7H3phtrgue1b+u'; 

    // Tentukan target_number berdasarkan jenis target
    switch ($target) {
        case 'announcement':
            $target_number = '120363211973464084@g.us'; // sementara, bisa disesuaikan nanti
            break;

        case 'wa_group':
            $target_number = '120363211973464084@g.us'; // ganti ke grup WA sebenarnya nanti
            break;

        case 'all':
            // Anda harus mengambil seluruh daftar nomor dari database dan mengirim satu per satu
            // Untuk sekarang, ditangani di bawah dalam logika pengulangan
            break;

        case 'individual':
            if (!$nomor) {
                echo json_encode(['success' => false, 'message' => 'Nomor tidak ditemukan untuk individu']);
                exit;
            }
            $target_number = $nomor;
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Target tidak valid']);
            exit;
    }

    $plain_text = formatHtmlToPlainTextWA($notes_mom);

    function formatHtmlToPlainTextWA($html) {
        // Persiapan awal
        $html = urldecode($html);
        $html = str_replace(["<br><br>", "&nbsp;"], ["<br>", " "], $html);
        $html = preg_replace('/<\/(strong|b)>\s*<(strong|b)>/', '', $html);

        // Load HTML ke DOMDocument
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $html);
        libxml_clear_errors();

        // Parsing rekursif
        function parseNode($node, $depth = 0) {
            $text = '';
            foreach ($node->childNodes as $child) {
                if ($child->nodeType === XML_TEXT_NODE) {
                    $text .= $child->nodeValue;
                } elseif ($child->nodeType === XML_ELEMENT_NODE) {
                    switch (strtolower($child->nodeName)) {
                        case 'strong':
                        case 'b':
                            $inner = trim(parseNode($child, $depth));
                            $prevChar = substr($text, -1);
                            if ($prevChar && !in_array($prevChar, ["", " ", "\n"])) $text .= ' ';
                            $text .= '*' . $inner . '*';
                            break;

                        case 'em':
                        case 'i':
                            $inner = trim(parseNode($child, $depth));
                            $prevChar = substr($text, -1);
                            if ($prevChar && !in_array($prevChar, ["", " ", "\n"])) $text .= ' ';
                            $text .= '_' . $inner . '_';
                            break;

                        case 'br':
                            $text .= "\n";
                            break;

                        case 'p':
                            $innerText = trim(parseNode($child, $depth));
                            $innerText = rtrim($innerText, "\n");
                            $text .= $innerText . "\n";
                            break;

                        case 'ol':
                            $i = 1;
                            foreach ($child->childNodes as $li) {
                                if ($li->nodeName === 'li') {
                                    $text .= $i++ . '. ' . trim(parseNode($li, $depth + 1)) . "\n";
                                }
                            }
                            break;

                        case 'ul':
                            foreach ($child->childNodes as $li) {
                                if ($li->nodeName === 'li') {
                                    $text .= str_repeat("  ", $depth + 1) . '- ' . trim(parseNode($li, $depth + 1)) . "\n";
                                }
                            }
                            break;

                        case 'li':
                            $liText = '';
                            $subListText = '';
                            foreach ($child->childNodes as $liChild) {
                                if ($liChild->nodeType === XML_TEXT_NODE) {
                                    $liText .= $liChild->nodeValue;
                                } elseif ($liChild->nodeType === XML_ELEMENT_NODE) {
                                    if (in_array(strtolower($liChild->nodeName), ['ul', 'ol'])) {
                                        $subListText .= parseNode($liChild, $depth + 1);
                                    } else {
                                        $liText .= parseNode($liChild, $depth);
                                    }
                                }
                            }
                            $liText = trim($liText);
                            if ($liText !== '') {
                                $text .= str_repeat("  ", $depth) . $liText . "\n";
                            }
                            if ($subListText !== '') {
                                $text .= $subListText;
                            }
                            break;

                        case 'div':
                            $text .= trim(parseNode($child, $depth)) . "\n";
                            break;

                        case 'table':
                            $rows = [];
                            foreach ($child->getElementsByTagName('tr') as $tr) {
                                $cells = [];
                                foreach ($tr->childNodes as $td) {
                                    if ($td->nodeType === XML_ELEMENT_NODE && in_array(strtolower($td->nodeName), ['td', 'th'])) {
                                        $cells[] = trim(parseNode($td, $depth));
                                    }
                                }
                                $rows[] = $cells;
                            }

                            if (!empty($rows)) {
                                // Buat baris sebagai teks
                                $colWidths = [];
                                foreach ($rows as $row) {
                                    foreach ($row as $i => $cell) {
                                        $colWidths[$i] = max($colWidths[$i] ?? 0, mb_strlen($cell));
                                    }
                                }

                                foreach ($rows as $i => $row) {
                                    foreach ($row as $j => $cell) {
                                        $pad = $colWidths[$j] ?? 10;
                                        $text .= str_pad($cell, $pad);
                                        if ($j < count($row) - 1) {
                                            $text .= " | ";
                                        }
                                    }
                                    $text .= "\n";

                                    // Tambahkan garis pemisah setelah header
                                    if ($i === 0) {
                                        foreach ($colWidths as $width) {
                                            $text .= str_repeat("-", $width) . " | ";
                                        }
                                        $text = rtrim($text, " | ") . "\n";
                                    }
                                }
                                $text .= "\n";
                            }
                            break;


                        default:
                            $text .= parseNode($child, $depth);
                    }
                }
            }
            return $text;
        }


        $body = $doc->getElementsByTagName('body')->item(0);
        $parsedText = trim(parseNode($body));

        // Normalisasi hasil
        $parsedText = html_entity_decode($parsedText);
        $parsedText = preg_replace("/[ \t]+/", ' ', $parsedText);
        $parsedText = preg_replace("/\n{3,}/", "\n\n", $parsedText);
        $parsedText = preg_replace('/\*\s+\*/', '*', $parsedText);
        $parsedText = preg_replace('/\n\*\s/', "\n*", $parsedText);
        $parsedText = preg_replace('/\*\_([^\*]+)\_\*/', '*_$1_*', $parsedText);
        $parsedText = preg_replace('/\_\*([^\_]+)\*\_/', '_*$1*_', $parsedText);
        $parsedText = preg_replace("/\n{3,}/", "\n\n", $parsedText);

        return trim($parsedText);
    }




    $plain_text = "*Minute of Meeting*\n$nama_event\n$hari_tanggal\n\n" . $plain_text;


    // Fungsi kirim ke 1 nomor
    function kirimPesan($target_number, $plain_text, $api_key) {
        $url = 'https://api.fonnte.com/send';
        $data = [
            'target' => $target_number,
            'message' => $plain_text,
            'countryCode' => '62',
        ];
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: $api_key"
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return ['success' => false, 'message' => $error];
        } else {
            return ['success' => true, 'response' => $response];
        }
    }

    // Kirim berdasarkan jenis target
    if ($target === 'all') {
        include "conn.php";
        $id_dg_event_detail = $_POST['id_dg_event_detail'] ?? 0;
        $id_dg_user_group = $_POST['id_dg_user_group'] ?? 0;

        $sql = "SELECT dd.id_dg_event_detail, de.id_dg_user_group, du.nomor_hp FROM dg_event_detail dd
                    INNER JOIN dg_event de
                    ON de.id_dg_event = dd.id_dg_event
                    INNER JOIN dg_user_group dg
                    ON dg.id_dg_user_group = de.id_dg_user_group
                    INNER JOIN dg_user_group_detail dgd
                    ON dgd.id_dg_user_group = dg.id_dg_user_group
                    INNER JOIN dg_user du
                    ON du.id_dg_user = dgd.id_dg_user
                    WHERE dd.id_dg_event_detail = ? AND de.id_dg_user_group = ? AND du.nomor_hp IS NOT NULL";
        $stmt = $db2->prepare($sql);
        $stmt->bind_param("ii", $id_dg_event_detail, $id_dg_user_group);
        $stmt->execute();
        $result = $stmt->get_result();

        $berhasil = 0;
        $gagal = 0;
        $log = [];

        while ($row = $result->fetch_assoc()) {
            $nomor_hp = $row['nomor_hp'];
            $res = kirimPesan($nomor_hp, $plain_text, $api_key);
            $log[] = ['nomor' => $nomor_hp, 'success' => $res['success']];
            if ($res['success']) $berhasil++; else $gagal++;
        }


        echo json_encode([
            'success' => true,
            'message' => "Kirim ke semua selesai",
            'berhasil' => $berhasil,
            'gagal' => $gagal,
            'log' => $log
        ]);

    } else {
        $res = kirimPesan($target_number, $plain_text, $api_key);
        echo json_encode($res);
    }

?>
