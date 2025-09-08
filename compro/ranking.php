<!DOCTYPE html>
<html lang="PT. Digital Informasi Kreatif">
<?php 
// mengaktifkan session
session_start();
include 'controller/conn.php';
?>
<?php $version = 2.0; ?>
<head>

    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="PT. Digital Informasi Kreatif, DIK Group, TerraTech, DiGrow, KromaFlux, DIK Ads, DIK Kreatif, DIK Tech, DIK Product">
    <meta name="description" content="PT. Digital Informasi Kreatif, TerraTech, DiGrow, KromaFlux, DIK Group, DIK Ads, DIK Kreatif, DIK Tech, DIK Product">
    <meta name="author" content="">

    <!-- Title  -->
    <title>PT. Digital Informasi Kreatif</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico?<?php echo $version;?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Plugins -->
    <link rel="stylesheet" href="assets/css/plugins.css?<?php echo $version;?>">

    <!-- Core Style Css -->
    <link rel="stylesheet" href="assets/css/style.css?<?php echo $version;?>">
    <link rel="stylesheet" type="text/css" href="assets/css/base.css?<?php echo $version;?>">
    <style>

    .swiper-slide.wow{
        width: 380px !important;
    }
    .hover-underline-animation:after {    
        text-decoration: underline !important;
        transition: width 0.3s ease 0s, left 0.3s ease 0s;
    }
    .hover-underline-animation:hover { 
        text-decoration: underline !important;
        transition: width 0.3s ease 0s, left 0.3s ease 0s;
    }
    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

    .alert.success {background-color: #04AA6D;}
    .alert.info {background-color: #2196F3;}
    .alert.warning {background-color: #ff9800;}

    .float{
        position:fixed;
        width:60px;
        height:60px;
        bottom:40px;
        right:40px;
        background-color:#25d366;
        color:#FFF;
        border-radius:50px;
        text-align:center;
        font-size:30px;
        box-shadow: 2px 2px 3px #999;
        z-index:100;
    }

    .my-float{
        margin-top:16px;
    }
    .bg-2 a:after{
        background: #00395B !important;
    }
    .error {
            color: red;
        }
    </style>

</head>
<body class="home-main-crev main-bg">



    <!-- ==================== Start Loading ==================== -->

   

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



    <div id="smooth-wrapper">


        <?php include 'view/navbar.html'; ?>



        <div id="smooth-content">

            <main class="main-bg">



                        <section class="blog-list-half crev section-padding" style="background-color: #ffffff; margin-top: 150px;">
                            <div class="container">
                                <div class="sec-lg-head mb-80">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php 
                                            $urutan = 0;
                                            $rank = 0;
                                            $id_jawaban = $_SESSION['id_jawaban'];
                                            $result_head = mysqli_query($db2,"SELECT * FROM jawaban");
                                            while($d_head = mysqli_fetch_array($result_head)){ 
                                                $urutan++;
                                                if ($id_jawaban==$d_head['id_jawaban']) {
                                                    $rank = $urutan;
                                                }
                                                
                                            }
                                            ?>
                                            <h2 class="d-rotate wow">
                                                <span class="rotate-text" style="color: #00395B !important">#<?php echo $rank; ?> RANK</span>
                                            </h2>
                                            <?php
                                            if ($rank==1) {
                                            ?>
                                            <h6 class="sub-title" style="color: #454545 !important;">Selamat andalah juaranya !!!</h6>
                                            <?php }else{ ?>
                                                <h6 class="sub-title" style="color: #454545 !important;">Jangan berkecil hati masih ada kesempatan lain kali.</h6>
                                            <?php } ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                



                               
                            </div>
                        </section>


            </main>


            <?php include "view/footer.php"; ?>


        </div>
    </div>







    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js?<?php echo $version;?>"></script>
    <script src="assets/js/jquery-migrate-3.4.0.min.js?<?php echo $version;?>"></script>

    <!-- plugins -->
    <script src="assets/js/plugins.js?<?php echo $version;?>"></script>

    <script src="assets/js/ScrollTrigger.min.js?<?php echo $version;?>"></script>

    <!-- custom scripts -->
    <script src="assets/js/scripts.js?<?php echo $version;?>"></script>



    <script>

    function validateForm() {
        // Mendapatkan nilai dari pilihan
        var selectedOption = document.getElementById("pertanyaan1").value;

        if (selectedOption != 1) {
            alert("JAWABAN NOMOR 1, SALAH !!!");
            return false;
        }

        var selectedOption2 = document.getElementById("pertanyaan2").value;

        if (selectedOption2 != 4) {
            alert("JAWABAN NOMOR 2, SALAH !!!");
            return false;
        }

        var selectedOption3 = document.getElementById("pertanyaan3").value;

        if (selectedOption3 !=2) {
            alert("JAWABAN NOMOR 3, SALAH !!!");
            return false;
        }

        return true; 
    }

   
   
    </script>

</body>

</html>