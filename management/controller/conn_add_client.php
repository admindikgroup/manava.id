<?php 
include 'conn.php';
session_start();

$namaClient2 = "";
$alamatClient2 = "";
$aboutClient2 = "";
$emailPic2 = "";
$nomorPic2 = "";
$name_image1 = "";
$craeted_by = "";
$tanggal_now = "";


$result_head = mysqli_query($db2,"select * from `dg_client` order by id_dg_client desc limit 1");
while($d_head = mysqli_fetch_array($result_head)){
    $id_dg_client = $d_head['id_dg_client']+1;
}

$namaClient2 = $_POST['namaClient2'];
$alamatClient2 = mysqli_real_escape_string($db2,$_POST['alamatClient2']);
$alamatClient2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $alamatClient2);
$aboutClient2 = mysqli_real_escape_string($db2,$_POST['aboutClient2']);
$aboutClient2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $aboutClient2);
$aboutClient2 = $aboutClient2."";

//$namaPic2 = mysqli_real_escape_string($db2,$_POST['namaPic2']);
if (isset($_POST['emailPic2'])) {
  $emailPic2 = mysqli_real_escape_string($db2,$_POST['emailPic2']);
}

$nomorPic2 = mysqli_real_escape_string($db2,$_POST['nomorPic2']);

$craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);


$target_dir = "../img/client_logo/";
$target_file = $target_dir . basename($_FILES["logo_client2"]["name"]);
$name_image1 = basename($_FILES["logo_client2"]["name"]);
if($name_image1 != null) {
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check = getimagesize($_FILES["logo_client2"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

$name_image1 = $id_dg_client.'-'.$namaClient2.'-'.basename($_FILES["logo_client2"]["name"]);
$new_name = $target_dir.$name_image1;

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["logo_client2"]["tmp_name"], $new_name)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["logo_client2"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);

}

    
    $stmt1 = $db2->prepare("INSERT INTO `dg_client` (nama_client, alamat_client, about_client, email, no_client, logo_client,
    created_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssssss", $namaClient2, $alamatClient2, $aboutClient2, $emailPic2, $nomorPic2, $name_image1,
    $craeted_by, $tanggal_now);    

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");


    $stmt1->execute();
    $stmt1->close();
    
    header("location:../client.php");

	



?>