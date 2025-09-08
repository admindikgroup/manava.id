<?php 
include 'conn.php';
session_start();


$username2 = null;
$namaUser2 = null;
$JenisKelamin2 = null;
$ulangtahun2 = null;
$emailUser2 = null;
$emailPerusahaan2 = null;
$nomorUser2 = null;
$noRek2 = null;

$bank2 = null;
$alamatUser2 = null;
$Jabatan2 = null;
$status2 = null;
$name_image1 = null;
$NamaPanggilan2 = null;
$quotes2 = null;
$mbti2 = null;
$craeted_by = null;
$id_task = null;

$profile = mysqli_real_escape_string($db2,$_POST['profile']);

$namaUser2 = mysqli_real_escape_string($db2,$_POST['namaUser']);
$username2 = mysqli_real_escape_string($db2,$_POST['username']);
$JenisKelamin2 = mysqli_real_escape_string($db2,$_POST['JenisKelamin']);
$alamatUser2 = mysqli_real_escape_string($db2,$_POST['alamatUser']);
$alamatUser2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $alamatUser2);

  if (isset($_POST['ulangtahun'])) {

    if ($_POST['ulangtahun']!="NaN-undefined-NaN") {
      $ulangtahun2 = mysqli_real_escape_string($db2,$_POST['ulangtahun']);
      $ulangtahun2 = DateTime::createFromFormat('d-F-Y', $ulangtahun2)->format('Y-m-d');
    }
   
  }


$emailUser2 = mysqli_real_escape_string($db2,$_POST['emailUser']);
$emailPerusahaan2 = mysqli_real_escape_string($db2,$_POST['emailPerusahaan']);
$nomorUser2 = mysqli_real_escape_string($db2,$_POST['nomorUser']);
$Jabatan2 = mysqli_real_escape_string($db2,$_POST['Jabatan']);
$noRek2 = mysqli_real_escape_string($db2,$_POST['noRek']);
$bank2 = mysqli_real_escape_string($db2,$_POST['bank']);
$status2 = mysqli_real_escape_string($db2,$_POST['status']);
$nama_gambar = mysqli_real_escape_string($db2,$_POST['bannerLama']);


$NamaPanggilan2 = mysqli_real_escape_string($db2,$_POST['namaPanggilan']);
$mbti2 = mysqli_real_escape_string($db2,$_POST['mbti']);
$quotes2 = mysqli_real_escape_string($db2,$_POST['quotes']);

$craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);
$id_task = mysqli_real_escape_string($db2,$_POST['id_task']);
if ($_SESSION['id_user']==$id_task) {
  $_SESSION['email'] = $emailUser2;
}


$name_image1 = basename($_FILES["foto_user"]["name"]);

if($name_image1 != "img/profile/t0.jpg" && $name_image1 != "") {
  $target_dir = "../img/profile/";
  $target_file = $target_dir . basename($_FILES["foto_user"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $temp = explode(".", $_FILES["foto_user"]["name"]);
  $newfilename = 'bg-image2.' . end($temp);
  // Check if image file is a actual image or fake image
  
  $check = getimagesize($_FILES["foto_user"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
  $name_image1 = $craeted_by.'-'.$username2.'-'.basename($_FILES["foto_user"]["name"]);
  $new_name = $target_dir.$name_image1;
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["foto_user"]["tmp_name"], $new_name)) {
    
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }


  
} else {

  $name_image1 = $nama_gambar;

}
      



if ($profile!=3) {
    
    $stmt1 = $db2->prepare("UPDATE `dg_user` set username = ?, nama = ?,  jenis_kelamin = ?, ulang_tahun = ?, email = ?, email_dg = ?, nomor_hp = ?, nomor_rekening = ?,
    bank = ?, alamat = ?, jabatan = ?, status = ?, photo = ?, nama_panggilan = ?, quotes = ?, mbti = ?,
    updated_by = ?, updated_at = ? where id_dg_user = ?");
    $stmt1->bind_param("sssssssssssssssssss", $username2, $namaUser2, $JenisKelamin2, $ulangtahun2, $emailUser2, $emailPerusahaan2, $nomorUser2, $noRek2, 
    $bank2, $alamatUser2, $Jabatan2, $status2, $name_image1, $NamaPanggilan2, $quotes2, $mbti2,
    $craeted_by, $tanggal_now, $id_task);

            
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
  
    

    if ($stmt1->execute()) {
      
    } else {
        echo "Error updating record: " . $stmt1->error;
    }
    $stmt1->close();

  }else{

    $stmt1 = $db2->prepare("UPDATE `dg_user` set nama = ?,  email = ?, nomor_hp = ?, nomor_rekening = ?,
    bank = ?, alamat = ?, status = ?, photo = ?,
    updated_by = ?, updated_at = ? where id_dg_user = ?");
    $stmt1->bind_param("sssssssssss", $namaUser2, $emailUser2, $nomorUser2, $noRek2, 
    $bank2, $alamatUser2, $status2, $name_image1,
    $craeted_by, $tanggal_now, $id_task);

            
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
  
    

    if ($stmt1->execute()) {
     
    } else {
        echo "Error updating record: " . $stmt1->error;
    }
    $stmt1->close();

  }

 echo "success";

	



?>