<?php 
include 'conn.php';
session_start();

$inputName = mysqli_real_escape_string($db2,$_POST['inputName']);
$deadline3 = mysqli_real_escape_string($db2,$_POST['deadline3']);
$deadline3 = DateTime::createFromFormat('d-F-Y', $deadline3)->format('Y-m-d');
echo $deadline3."<br>";
$inputEmail = mysqli_real_escape_string($db2,$_POST['inputEmail']);
$inputEmailPerusahaan = mysqli_real_escape_string($db2,$_POST['inputEmailPerusahaan']);
$inputNo = mysqli_real_escape_string($db2,$_POST['inputNo']);
$inputRe = mysqli_real_escape_string($db2,$_POST['inputRe']);
$namaBank = mysqli_real_escape_string($db2,$_POST['namaBank']);
$alamat = mysqli_real_escape_string($db2,$_POST['alamat']);
$jabatan = mysqli_real_escape_string($db2,$_POST['jabatan']);
$i_do = mysqli_real_escape_string($db2,$_POST['i_do']);
$link_team = mysqli_real_escape_string($db2,$_POST['link_team']);

$craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

$JenisKelamin = mysqli_real_escape_string($db2,$_POST['JenisKelamin']);

$namaPanggilan = mysqli_real_escape_string($db2,$_POST['namaPanggilan']);
$mbti = mysqli_real_escape_string($db2,$_POST['mbti']);
$quotes = mysqli_real_escape_string($db2,$_POST['quotes']);


$_SESSION['email'] = $inputEmail;
$target_dir = "../img/profile/";
$target_file = $target_dir . basename($_FILES["lampiran"]["name"]);
$name_image1 = basename($_FILES["lampiran"]["name"]);
if($name_image1 != null) {
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check = getimagesize($_FILES["lampiran"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

$name_image1 = $craeted_by.'-'.$inputName.'-'.basename($_FILES["lampiran"]["name"]);
$new_name = $target_dir.$name_image1;

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["lampiran"]["tmp_name"], $new_name)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["lampiran"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);

}


$query = "SELECT * FROM dg_user WHERE link_team = '$link_team' and id_dg_user != $craeted_by";
$result = mysqli_query($db2, $query);

// Cek apakah ID tersedia atau tidak
if (mysqli_num_rows($result) > 0) {
    $link_team = "";
    $result_head = mysqli_query($db2,"select * from `dg_user` where id_dg_user = '$craeted_by'");
        while($d_head = mysqli_fetch_array($result_head)){
          $link_team = $d_head['link_team'];
        }
} 

    $stmt1 = $db2->prepare("UPDATE `dg_user` set nama = ?, ulang_tahun = ?, email = ?, email_dg = ?, nomor_hp = ?, nomor_rekening = ?,
    bank = ?, alamat = ?, jabatan = ?, photo = ?, nama_panggilan = ?, quotes = ?,
    mbti = ?, jenis_kelamin = ?, i_do = ?, link_team = ?,
    updated_by = ?, updated_at  = ? where id_dg_user = ?");
    $stmt1->bind_param("sssssssssssssssssss", $inputName, $deadline3, $inputEmail, $inputEmailPerusahaan, $inputNo, $inputRe, $namaBank, $alamat, $jabatan, $name_image1,
    $namaPanggilan, $quotes, $mbti, $JenisKelamin, $i_do, $link_team,
    $craeted_by, $tanggal_now, $craeted_by);
    
        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../profile.php?id_user=$craeted_by");

	



?>