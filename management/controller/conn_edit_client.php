<?php 
include 'conn.php';
session_start();

$namaClient2 = $_POST['namaClient'];
echo $namaClient2."<br>";
$alamatClient2 = mysqli_real_escape_string($db2,$_POST['alamatClient']);
$alamatClient2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $alamatClient2);

$aboutClient2 = mysqli_real_escape_string($db2,$_POST['aboutClient']);
$aboutClient2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
", $aboutClient2);
// $namaPic2 = mysqli_real_escape_string($db2,$_POST['namaPic']);
$emailPic2 = mysqli_real_escape_string($db2,$_POST['emailPic']);
$nomorPic2 = mysqli_real_escape_string($db2,$_POST['nomorPic']);
// $support = mysqli_real_escape_string($db2,$_POST['support']);

$craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

$id_task = mysqli_real_escape_string($db2,$_POST['id_task']);



$target_dir = "../img/client_logo/";
$target_file = $target_dir . basename($_FILES["logo_client"]["name"]);
$name_image1 = basename($_FILES["logo_client"]["name"]);
if($name_image1 != null) {
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check = getimagesize($_FILES["logo_client"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

$name_image1 = $id_task.'-'.$namaClient2.'-'.basename($_FILES["logo_client"]["name"]);
$new_name = $target_dir.$name_image1;

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["logo_client"]["tmp_name"], $new_name)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["logo_client"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);

}

    $stmt1 = $db2->prepare("UPDATE `dg_client` set nama_client = ?, alamat_client = ?, about_client = ?, email = ?, no_client = ?,
    logo_client = ?, edited_by = ?, edited_at  = ? where id_dg_client = ?");
    $stmt1->bind_param("sssssssss", $namaClient2, $alamatClient2, $aboutClient2, $emailPic2, $nomorPic2, $name_image1,
    $craeted_by, $tanggal_now, $id_task);
    

        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();
    
    header("location:../client.php");

	



?>