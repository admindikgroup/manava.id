<?php 
include 'conn.php';
session_start();

$profile = mysqli_real_escape_string($db2,$_POST['profile']);
$namaUser2 = mysqli_real_escape_string($db2,$_POST['namaUser2']);
$username2 = mysqli_real_escape_string($db2,$_POST['username2']);
$username3 = mysqli_real_escape_string($db2,$_POST['username3']);
$JenisKelamin2 = mysqli_real_escape_string($db2,$_POST['JenisKelamin2']);

$emailUser2 = mysqli_real_escape_string($db2,$_POST['emailUser2']);
$emailPerusahaan2 = mysqli_real_escape_string($db2,$_POST['emailPerusahaan2']);
$nomorUser2 = mysqli_real_escape_string($db2,$_POST['nomorUser2']);
$Jabatan2 = mysqli_real_escape_string($db2,$_POST['Jabatan2']);
$noRek2 = mysqli_real_escape_string($db2,$_POST['noRek2']);
$bank2 = mysqli_real_escape_string($db2,$_POST['bank2']);
$status2 = mysqli_real_escape_string($db2,$_POST['status2']);

$NamaPanggilan2 = mysqli_real_escape_string($db2,$_POST['NamaPanggilan2']);
$mbti2 = mysqli_real_escape_string($db2,$_POST['mbti2']);
$quotes2 = mysqli_real_escape_string($db2,$_POST['quotes2']);
$id_dg_user_organization = mysqli_real_escape_string($db2,$_POST['id_dg_user_organization']);
    
$craeted_by = mysqli_real_escape_string($db2,$_POST['id_user']);

$target_dir = "../img/profile/";



    if ($profile==1) {


      $target_file = $target_dir . basename($_FILES["foto_user2"]["name"]);
      $name_image1 = basename($_FILES["foto_user2"]["name"]);
      if($name_image1 != null) {
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      
      $check = getimagesize($_FILES["foto_user2"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
      
      $name_image1 = $craeted_by.'-'.$username2.'-'.basename($_FILES["foto_user2"]["name"]);
      $new_name = $target_dir.$name_image1;
      
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["foto_user2"]["tmp_name"], $new_name)) {
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
      }else{
        $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);
      
      }



    $alamatUser2 = mysqli_real_escape_string($db2,$_POST['alamatUser2']);
    $alamatUser2 = str_replace(array("\\r\\n", "\\r", "\\n"), "
    ", $alamatUser2);
    $ulangtahun2 = mysqli_real_escape_string($db2,$_POST['ulangtahun2']);
    $ulangtahun2 = DateTime::createFromFormat('d-F-Y', $ulangtahun2)->format('Y-m-d');

    $stmt1 = $db2->prepare("INSERT INTO `dg_user` (id_dg_user_organization, username, password_dg, nama, jenis_kelamin, ulang_tahun, email, email_dg, nomor_hp, nomor_rekening,
    bank, alamat, jabatan, status, photo, nama_panggilan, quotes, mbti,
    created_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssssssssssssssssss", $id_dg_user_organization, $username2, $password_dg, $namaUser2, $JenisKelamin2, $ulangtahun2, $emailUser2, $emailPerusahaan2, $nomorUser2, $noRek2, 
    $bank2, $alamatUser2, $Jabatan2, $status2, $name_image1, $NamaPanggilan2, $quotes2, $mbti2,
    $craeted_by, $tanggal_now);
    
    //dgads123!
    $password_dg = "f213094f59b8ef4da15817086ca6e6c2";

        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();

    }

    if ($profile==0) {


      $target_file = $target_dir . basename($_FILES["foto_user3"]["name"]);
      $name_image1 = basename($_FILES["foto_user3"]["name"]);
      if($name_image1 != null) {
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      
      $check = getimagesize($_FILES["foto_user3"]["tmp_name"]);
      if($check !== false) {
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
      
      $name_image1 = $craeted_by.'-'.$username3.'-'.basename($_FILES["foto_user3"]["name"]);
      $new_name = $target_dir.$name_image1;
      
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["foto_user3"]["tmp_name"], $new_name)) {
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }
      }else{
        $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);
      
      }



      $stmt1 = $db2->prepare("INSERT INTO `dg_user` (id_dg_user_organization, username, password_dg, nama, 
      jabatan, status, photo, email, nomor_hp, nomor_rekening, bank,  created_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt1->bind_param("sssssssssssss", $id_dg_user_organization, $username3, $password_dg, $namaUser2, 
      $Jabatan2, $status2, $name_image1, $emailUser2, $nomorUser2, $noRek2, $bank2,
      $craeted_by, $tanggal_now);
      
      $password_dg = "f213094f59b8ef4da15817086ca6e6c2";
  
          
      date_default_timezone_set('Asia/Jakarta');
      $tanggal_now = date("Y-m-d H:i:s");
  
      $stmt1->execute();
      $stmt1->close();
  
      }

      if ($profile==3) {


        $target_file = $target_dir . basename($_FILES["foto_user4"]["name"]);
        $name_image1 = basename($_FILES["foto_user4"]["name"]);
        if($name_image1 != null) {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        
        $check = getimagesize($_FILES["foto_user4"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        $name_image1 = $craeted_by.'-'.$username2.'-'.basename($_FILES["foto_user4"]["name"]);
        $new_name = $target_dir.$name_image1;
        
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } else {
            if (move_uploaded_file($_FILES["foto_user4"]["tmp_name"], $new_name)) {
            } else {
              echo "Sorry, there was an error uploading your file.";
            }
          }
        }else{
          $name_image1 = mysqli_real_escape_string($db2,$_POST['bannerLama']);
        
        }



        $stmt1 = $db2->prepare("INSERT INTO `dg_user` (nama, email, nomor_hp, nomor_rekening,
        bank, alamat, status, photo, created_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("ssssssssss", $namaUser2, $emailUser2, $nomorUser2, $noRek2, 
        $bank2, $alamatUser2, $status2, $name_image1, $craeted_by, $tanggal_now);
    
            
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_now = date("Y-m-d H:i:s");
    
        $stmt1->execute();
        $stmt1->close();
    
        }
    
  

    echo "success";

	



?>