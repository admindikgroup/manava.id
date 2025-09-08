<?php 
// mengaktifkan session
session_start();
include 'management/controller/conn.php';

$version = 2.1; 

$id = 0;
if(isset($_GET['id'])){
  $id = $_GET['id'];
}
$view_count = 1;
$result_head = mysqli_query($db2,"select * from dg_article
  where id_dg_article = $id");
  while($d_head = mysqli_fetch_array($result_head)){
      $judul_article = $d_head['judul_article']; 
      $banner_utama = $d_head['banner_utama']; 
      $isi_article_pembuka = $d_head['isi_article_pembuka']; 
      $quotes = $d_head['quotes']; 
      $author_quotes = $d_head['author_quotes']; 
      $banner1 = $d_head['banner1']; 
      $banner2 = $d_head['banner2'];  
      $isi_article = $d_head['isi_article'];  
      $id_author = $d_head['id_author']; 
      $view_count = $d_head['view_count']+1; 
      $date_created = date_format(date_create($d_head['created_at']),"d F Y");  
  }

  $stmt1 = $db2->prepare("UPDATE `dg_article` set view_count = ? where id_dg_article = ? ");
  $stmt1->bind_param("ss", $view_count, $id);

  $stmt1->execute();
  $stmt1->close();

  $result_au = mysqli_query($db2,"select * from dg_user
  where id_dg_user = $id_author");
  while($d_au = mysqli_fetch_array($result_au)){
      $nama_au = $d_au['nama']; 
      $jabatan = $d_au['jabatan']; 
      $photo = $d_au['photo']; 
      if ($photo=="") {
        $photo = 't0.jpg';
      }

  }


?>
<!DOCTYPE html>
<html lang="zxx">

<head>

    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="PT. Digital Informasi Kreatif, DIK Group, TerraTech, DiGrow, KromaFlux, DIK Ads, DIK Kreatif, DIK Tech, DIK Product">
    <meta name="description" content="PT. Digital Informasi Kreatif, DIK Group, TerraTech, DiGrow, KromaFlux, DIK Ads, DIK Kreatif, DIK Tech, DIK Product">
    <meta name="author" content="">

    <!-- Title  -->
    <title>DIK Group | Article</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <!-- Plugins -->
    <link rel="stylesheet" href="assets/css/plugins.css">

    <!-- Core Style Css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="assets/css/base.css">

    <style>
    b, strong {
        font-weight: bold !important;
    }
    p{
        margin: revert !important;
    }
    .thumb-post {
    position: relative;
    }

    .thumb-post::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: #00395B99; /* Warna hitam dengan tingkat kejernihan sebesar 0.4 (40%) */
        z-index: 1; /* Pastikan overlay berada di atas gambar latar belakang */
    }

    .thumb-post a {
        position: relative; /* Memberikan posisi relatif pada tautan untuk menempatkan teks di atas overlay */
        z-index: 2; /* Pastikan teks berada di atas overlay */
        display: block; /* Membuat tautan menjadi elemen blok agar dapat menangkap seluruh area overlay */
        padding: 20px; /* Berikan padding agar tautan dapat diklik dengan nyaman */
        color: #fff; /* Warna teks menjadi putih agar terlihat di atas overlay */
        text-decoration: none; /* Hapus garis bawah default pada tautan */
    }

    .thumb-post h6 {
        margin-top: 0; /* Hapus margin atas pada judul */
    }
    </style>

</head>

<body class="main-bg">



<!-- ==================== Start Loading ==================== -->

<?php include 'view/loading.html'; ?>

<!-- ==================== End Loading ==================== -->


<?php

$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
substr($useragent,0,4))){}else{

?>

<div class="cursor"></div>

<?php } ?>

<!-- ==================== Start progress-scroll-button ==================== -->

<div class="progress-wrap cursor-pointer">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<!-- ==================== End progress-scroll-button ==================== -->



<!-- ==================== Start Navbar ==================== -->

<?php include 'view/navbar.php'; ?>

<!-- ==================== End Navbar ==================== -->

    <main>

        <!-- ==================== Start Slider ==================== -->

        <header class="page-header blog-header section-padding pb-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="caption">
                            <div class="sub-title fz-12">
                                <?php 
                                    $result_category = mysqli_query($db2,"select * from dg_article_category_m dacm inner join dg_article_category dac
                                    on dacm.id_dg_article_category = dac.id_dg_article_category where dacm.id_dg_article = $id");
                                    while($d_category = mysqli_fetch_array($result_category)){
                                 ?>
                                <a><span> | <?php echo $d_category['nama_category'];?></span></a>
                                <?php } ?>
                            </div>
                            <h1 class="fz-55 mt-30"><?php echo $judul_article;?></</h1>
                        </div>
                        <div class="info d-flex mt-40 align-items-center">
                            <div class="left-info">
                                <div class="d-flex">
                                    <div class="author-info">
                                        <div class="d-flex align-items-center">
                                            <a href="#0" class="circle-60">
                                                <img src="management/img/profile/<?php echo $photo;?>" alt="" class="circle-img">
                                            </a>
                                            <a href="#0" class="ml-20">
                                                <span class="opacity-7"><?php echo $nama_au;?></span>
                                                <h6 class="fz-16"><?php echo $jabatan;?></h6>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="date ml-50">
                                        <a href="#0">
                                            <span class="opacity-7">Published</span>
                                            <h6 class="fz-16"><?php echo $date_created;?></h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="right-info ml-auto">
                                <div>
                                    <span class="pe-7s-look fz-18 mr-10"></span>
                                    <span class="opacity-7"><?php echo $view_count;?> Views</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background bg-img parallaxie" data-background="management/img/article/<?php echo $banner_utama;?>"></div>
        </header>

        <!-- ==================== End Slider ==================== -->



        <!-- ==================== Start Blog ==================== -->

        <section class="blog section-padding pb-0">
            <div class="container" style="background-color: #00395b; padding-bottom: 100px;">
                <div class="main-post">
                    <div class="item pb-60">
                        <div>
                            
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="text" style="text-align: justify;">
                                        <div style="clear: both;">
                                            <?php 
                                                // Menghilangkan tag HTML dan atribut style dari teks
                                                $result = preg_replace('/<[^>]+>/', '', $isi_article_pembuka);
                                                // Mengambil karakter pertama dari teks yang sudah di-strip tag HTML-nya
                                                $first_char = substr(strip_tags($result), 0, 1);
                                            ?>
                                            <span class="fz-55 fw-600 main-color line-height-1 mr-10" style="float: left;"><?php echo $first_char; ?></span>
                                                <div style="line-height: 1.8; font-size: 16px; font-weight: 300;color: #ddd;">
                                                <?php 
                                                    // Menghilangkan karakter pertama dari teks yang sudah di-strip tag HTML-nya
                                                    $result = substr(strip_tags($result), 1);
                                                    echo $result; // Menampilkan teks tanpa tag HTML dan atribut style
                                                ?>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                           
                        </div>

                    <?php if($quotes!=""){?>
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="post-qoute mt-50">
                                    <h6 class="fz-20">
                                        <span class="l-block"><?php echo $quotes; ?></span>
                                        <p class="main-color mt-20 mb-0"> - <?php echo $author_quotes; ?></p>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                        <div class="mb-50 mt-50">
                            <div class="row justify-content-center">
                                <?php if($banner1!="b1.jpg"){?>
                                <div class="col-sm-6  mx-auto">
                                    <div class="iner-img sm-mb30">
                                        <img src="management/img/article/<?php echo $banner1;?>" alt="">
                                    </div>
                                </div>
                                <?php } if($banner2!="b1.jpg"){?>
                                <div class="col-sm-6  mx-auto">
                                    <div class="iner-img">
                                        <img src="management/img/article/<?php echo $banner2;?>" alt="">
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>

                        <div class="row justify-content-center" style="text-align: justify;">
                            <div class="col-lg-10">
                                <div style="line-height: 1.8; font-size: 16px; font-weight: 300;color: #ddd;">
                                    <?php 
                                    $result = preg_replace('/(<[^>]+) style="[^"]*\bcolor:\s*rgb\(.*?\)[^"]*"/i', '$1', $isi_article);
                                    echo $result;
                                    ?>
                                </div>
                            </div>
                        </div>







                    </div>
                    <div class="info-area flex mt-20 pb-20">
                        <div>
                            <div class="tags flex">
                                <div class="valign">
                                    <span>Tags :</span>
                                </div>
                                <div>

                                <?php 
                                    $result_tags = mysqli_query($db2,"select * from dg_article_tags_m dacm inner join dg_article_tags dac
                                    on dacm.id_dg_article_tags = dac.id_dg_article_tags where dacm.id_dg_article = $id");
                                    while($d_tags = mysqli_fetch_array($result_tags)){
                                 ?>
                                 <a><?php echo $d_tags['nama_tags'];?></a>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto">
                            <div class="share-icon flex">
                                <div class="valign">
                                    <span>Share :</span>
                                </div>
                                <div>
                                    <a onclick="shareToFacebook()"><i class="fab fa-facebook-f"></i></a>
                                    <a onclick="shareToTwitter()"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="author-area mt-50">
                        <div class="flex">
                            <div class="author-img mr-30">
                                <div class="img">
                                    <img src="management/img/profile/<?php echo $photo;?>" alt="" class="circle-img">
                                </div>
                            </div>

                            <div class="cont valign">
                                <div class="full-width">
                                    <h6 class="fw-600 mb-10"><?php echo $nama_au;?></h6>
                                    <p><?php echo $quotes;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="next-prv-post flex mt-50 mb-50" style="color: #ddd !important;">

                    <?php $result_prev = mysqli_query($db2,"SELECT * FROM dg_article WHERE id_dg_article < $id AND deleted_at IS NULL ORDER BY id_dg_article DESC LIMIT 1");
                          while($d_prev = mysqli_fetch_array($result_prev)){ ?>
                        <div class="thumb-post bg-img" data-background="management/img/article/<?php echo $d_prev['banner_utama'];?>">
                            <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_prev['judul_article']); ?>&id=<?php echo $d_prev['id_dg_article']; ?>">
                                <span class="fz-12 text-u ls1 main-color mb-15"><i class="pe-7s-angle-left"></i>
                                    Prev Post</span>
                                <h6 class="fw-600 fz-16"><?php echo $d_prev['judul_article']; ?></h6>
                            </a>
                        </div>
                        
                    <?php }
                    
                    $result_next = mysqli_query($db2,"SELECT * FROM dg_article WHERE id_dg_article > $id AND deleted_at IS NULL ORDER BY id_dg_article ASC LIMIT 1");
                          while($d_next = mysqli_fetch_array($result_next)){ 
                    ?>

                        <div class="thumb-post ml-auto text-right bg-img"
                            data-background="management/img/article/<?php echo $d_next['banner_utama'];?>">
                            <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_next['judul_article']); ?>&id=<?php echo $d_next['id_dg_article']; ?>">
                                <span class="fz-12 text-u ls1 main-color mb-15">Next Post <i
                                        class="pe-7s-angle-right"></i></span>
                                <h6 class="fw-600 fz-16"><?php echo $d_next['judul_article']; ?></h6>
                            </a>
                        </div>

                    <?php } ?>

                    </div>

                    
                    
                </div>
                
            </div>


           <hr>

            
        </section>

        <!-- ==================== End Blog ==================== -->


    </main>


       <!-- ==================== Start Footer ==================== -->

       <?php include "view/footer.php"; ?>

<!-- ==================== End Footer ==================== -->










    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/jquery-migrate-3.4.0.min.js"></script>

    <!-- plugins -->
    <script src="assets/js/plugins.js"></script>

    <script src="assets/js/ScrollTrigger.min.js"></script>

    <!-- custom scripts -->
    <script src="assets/js/scripts.js"></script>

    <script>
        function shareToFacebook() {
            // Mendapatkan URL saat ini dari browser
            var currentURL = window.location.href;

            // Membuka jendela baru untuk berbagi di Facebook
            window.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(currentURL), "_blank");
        }
        function shareToTwitter() {
            // Mendapatkan URL saat ini dari browser
            var currentURL = window.location.href;

            // Mendapatkan judul atau teks tambahan yang ingin Anda bagikan
            var tweetText = "Check out this link: ";

            // Membuka jendela baru untuk berbagi di Twitter
            window.open("https://twitter.com/intent/tweet?url=" + encodeURIComponent(currentURL) + "&text=" + encodeURIComponent(tweetText), "_blank");
        }
    </script>

</body>

</html>