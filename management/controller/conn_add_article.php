<?php 
include 'conn.php';
session_start();

$id_dg_article = 1;
$result_head = mysqli_query($db2,"select * from `dg_article` order by id_dg_article desc limit 1");
while($d_head = mysqli_fetch_array($result_head)){
    $id_dg_article = $d_head['id_dg_article']+1;
}

$judul_article = mysqli_real_escape_string($db2,$_POST['judul_article']);
$id_user = mysqli_real_escape_string($db2,$_POST['id_user']);
$summernote = $_POST['summernote'];
$summernote2 = $_POST['summernote2'];

$quotes = mysqli_real_escape_string($db2,$_POST['quotes']);
$author_quotes = mysqli_real_escape_string($db2,$_POST['author_quotes']);


//Banner Utama
$target_dir = "../img/article/";
$target_file = $target_dir . basename($_FILES["banner_utama"]["name"]);
$name_image1 = basename($_FILES["banner_utama"]["name"]);
if($name_image1 != null) {
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check = getimagesize($_FILES["banner_utama"]["tmp_name"]);
if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

$name_image1 = "1-".$id_dg_article.'-'.$judul_article.'-'.basename($_FILES["banner_utama"]["name"]);
$name_image1 = str_replace(' ', '', $name_image1);
$new_name = $target_dir.$name_image1;

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["banner_utama"]["tmp_name"], $new_name)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["banner_utama"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image1 = mysqli_real_escape_string($db2,$_POST['banner_utama_lama']);

}



//Banner 2
$target_dir = "../img/article/";
$target_file = $target_dir . basename($_FILES["banner2"]["name"]);
$name_image2 = basename($_FILES["banner2"]["name"]);
if($name_image2 != null) {
$uploadOk2 = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check2 = getimagesize($_FILES["banner2"]["tmp_name"]);
if($check2 !== false) {
    echo "File is an image - " . $check2["mime"] . ".";
    $uploadOk2 = 1;
} else {
    echo "File is not an image.";
    $uploadOk2 = 0;
}

$name_image2 = "2-".$id_dg_article.'-'.$judul_article.'-'.basename($_FILES["banner2"]["name"]);
$name_image2 = str_replace(' ', '', $name_image2);
$new_name2 = $target_dir.$name_image2;

if ($uploadOk2 == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["banner2"]["tmp_name"], $new_name2)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["banner2"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image2 = mysqli_real_escape_string($db2,$_POST['banner2_lama']);

}

//Banner 3
$target_dir = "../img/article/";
$target_file = $target_dir . basename($_FILES["banner3"]["name"]);
$name_image3 = basename($_FILES["banner3"]["name"]);
if($name_image3 != null) {
$uploadOk3 = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$check3 = getimagesize($_FILES["banner3"]["tmp_name"]);
if($check3 !== false) {
    echo "File is an image - " . $check3["mime"] . ".";
    $uploadOk3 = 1;
} else {
    echo "File is not an image.";
    $uploadOk3 = 0;
}

$name_image3 = "3-".$id_dg_article.'-'.$judul_article.'-'.basename($_FILES["banner3"]["name"]);
$name_image3 = str_replace(' ', '', $name_image3);
$new_name3 = $target_dir.$name_image3;

if ($uploadOk3 == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["banner3"]["tmp_name"], $new_name3)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["banner3"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}else{
  $name_image3 = mysqli_real_escape_string($db2,$_POST['banner3_lama']);

}



    
    $stmt1 = $db2->prepare("INSERT INTO `dg_article` (judul_article, id_author, banner_utama, isi_article_pembuka, 
    quotes, author_quotes, banner1, banner2, 
    isi_article, created_by, created_at) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssssssssss", $judul_article, $id_user, $name_image1, $summernote, 
    $quotes, $author_quotes, $name_image2, $name_image3, $summernote2,
    $id_user, $tanggal_now);
    

        
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_now = date("Y-m-d H:i:s");

    $stmt1->execute();
    $stmt1->close();



    
    $article_category = $_POST['article_category'];
    foreach($article_category as $value_article_category){
      $stmt2 = $db2->prepare("INSERT INTO `dg_article_category_m` (id_dg_article, id_dg_article_category) value (?,?)");
      $stmt2->bind_param("ss", $id_dg_article, $value_article_category);
  
      $stmt2->execute();
      $stmt2->close();
    }

    $aticle_tags = $_POST['aticle_tags'];
    foreach($aticle_tags as $value_aticle_tags){
      $stmt3 = $db2->prepare("INSERT INTO `dg_article_tags_m` (id_dg_article, id_dg_article_tags) value (?,?)");
      $stmt3->bind_param("ss", $id_dg_article, $value_aticle_tags);
  
      $stmt3->execute();
      $stmt3->close();
    }
    
    header("location:../article.php");




?>