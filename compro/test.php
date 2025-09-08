<?php
define('HOST2','localhost');
define('USER2','root');
define('PASS2','');
define('DB2', 'dggroup');

$db2 = new mysqli(HOST2, USER2, PASS2, DB2);

$result_head = mysqli_query($db2,"select *, da.created_at as tanggal_buat from dg_article da
inner join dg_user du on da.id_author = du.id_dg_user
where da.deleted_at is null
limit 2");
while($d_head = mysqli_fetch_array($result_head)){
    echo $d_head['id_dg_article']."<br>";  
}

if ($db2->connect_error) {
    die("Koneksi ke database gagal: " . $db2->connect_error);
}


if (!$result_head) {
    die("Kesalahan dalam menjalankan kueri: " . mysqli_error($db2));
}


echo "TEST";
?>