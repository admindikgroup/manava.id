<?php
// API Key Fonnte Anda
$api_key = 'xJDWix7H3phtrgue1b+u'; 

// Nomor tujuan (gunakan format internasional tanpa tanda +, misalnya 6281234567890 untuk Indonesia)
$target_number = '6282126184848-1623663250';

// Pesan yang ingin dikirim
$message = 'Pesan ini merupakan Uji Coba Otomatis 2 dari : dikgroup.id';

// URL endpoint API Fonnte
$url = 'https://api.fonnte.com/send';

// Data yang dikirim dalam POST request
$data = [
    'target' => $target_number,
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
?>
