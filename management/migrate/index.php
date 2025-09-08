<?php
$mysqli = new mysqli("localhost", "root", "", "dggroup");

if ($mysqli->connect_errno) {
    die("❌ Gagal konek ke database: " . $mysqli->connect_error);
}

$files = glob(__DIR__ . '/*.sql');
sort($files); // urutkan berdasarkan nama file

foreach ($files as $file) {
    $sql = file_get_contents($file);
    echo "<h4>📄 Menjalankan: " . basename($file) . "</h4>";
    
    if ($mysqli->multi_query($sql)) {
        do {
            $mysqli->store_result();
        } while ($mysqli->more_results() && $mysqli->next_result());

        echo "<p style='color:green'>✅ Berhasil</p>";
    } else {
        echo "<p style='color:red'>❌ Error: " . $mysqli->error . "</p>";
        break;
    }
}

$mysqli->close();
?>
