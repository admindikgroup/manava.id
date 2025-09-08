<?php 
// mengaktifkan session
session_start();
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (strpos($current_url, 'mng.dikgroup.id')) {
    header('Location: https://dikgroup.id/management/');
    exit;
}
if (!strpos($current_url, 'dikgroup.id') && !strpos($current_url, 'localhost')) {
    header('Location: https://dikgroup.id');
    exit;
}

include 'controller/conn.php';

$version = 3.1; 
?>
<!DOCTYPE html>
<html lang="PT. Digital Informasi Kreatif">

<?php 
    include 'view/head.php'; 
?>
<style>
.blog-list-half.crev .item .img img{
    bottom: 0px;
}

</style>
<body class="home-main-crev main-bg">



    <!-- ==================== Start Loading ==================== -->

    <?php include 'view/loading.html'; ?>

    <!-- ==================== End Loading ==================== -->
    <?php

    $useragent=$_SERVER['HTTP_USER_AGENT'];

    if (
        preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|ad|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|tablet|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone|tablet)|xda|xiino/i', $useragent) 
        || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent,0,4))
    ){}else{

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


        <?php include 'view/navbar.php'; ?>


        <div id="smooth-content">

            <main class="main-bg">

                <!-- ==================== Start Slider ==================== -->

                <section class="parallax-show">
                    <section class="parallaxie" data-background="assets/imgs/patterns/1.png?<?php echo $version;?>">
                        <div class="crev-slider position-re" style="color: #FEB062;">
                            <div class="container-fluid ontop">
                                <div class="row">
                                    <div class="col-lg-6 d-flex align-items-end order2">
                                        <div class="full-width">
                                            <div class="gallery-text" style="padding-bottom: 0px !important;">
                                                <div class="swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="text">
                                                                <h6 class="sub-title">Digital Ecosystem</h6>
                                                                <h1>We Build a Digital Legacy For Your Company.</h1>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="text">
                                                                <h6 class="sub-title">Digital Agency</h6>
                                                                <h1>Being a Blessed Provider of Digital Ecosystem
                                                                    Services.
                                                                </h1>
                                                            </div>
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <div class="text">
                                                                <h6 class="sub-title">System & Information</h6>
                                                                <h1>Create an Integrated System That is Effective and
                                                                    Efficient.
                                                                </h1>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="swiper-controls d-flex align-items-center"
                                                    style="background-color: #00395B; opacity: 0.8;">
                                                    <div class="swiper-pagination"></div>
                                                    <div class="arrows ml-auto">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="swiper-button-prev swiper-nav-ctrl cursor-pointer">
                                                                <div><i class="fas fa-chevron-left"></i></div>
                                                            </div>
                                                            <div
                                                                class="swiper-button-next swiper-nav-ctrl cursor-pointer">
                                                                <div><i class="fas fa-chevron-right"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 order1"
                                        style="padding-right: 0px; position: relative; bottom: 0px;">
                                        <div class="gallery-img" style="position: relative; bottom: 0px;">
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <div class="bg-img banner"
                                                            data-background="assets/imgs/header/slid1.png?<?php echo $version;?>">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="bg-img banner"
                                                            data-background="assets/imgs/header/slid2.png?<?php echo $version;?>">
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="bg-img banner"
                                                            data-background="assets/imgs/header/slid3.png?<?php echo $version;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>


                    <!-- ==================== Start marq ==================== -->

                    <div class="bg-img inner parallaxie">
                        <section class="serv-marq main-colorbg2">
                            <div class="container-fluid ontop sub-bg rest pt-20 pb-20"
                                style="background-color: #00395b; max-width: 100%; overflow: hidden;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="main-marq light-text">
                                            <div class="slide-har st1" style="max-width: 100%;">
                                                <div class="box non-strok">
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>UI-UX Design</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Web
                                                                Development</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Digital
                                                                Marketing</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Product
                                                                Design</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Social Media
                                                                Content</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Search Engine
                                                                Optimization</span> <span
                                                                class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                </div>
                                                <div class="box non-strok">
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>UI-UX Design</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Web
                                                                Development</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Digital
                                                                Marketing</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Product
                                                                Design</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Social Media
                                                                Content</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center"><span>Search Engine
                                                                Optimization</span> <span
                                                                class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <!-- ==================== End marq ==================== -->

                        <!-- ==================== Start about ==================== -->

                        <section class="about-intro section-padding parallaxie"
                            data-background="assets/imgs/patterns/2.png?<?php echo $version;?>"
                            style="background-color: white; color: #AAAAAA !important;">
                            <div class="container">
                                <div class="row mb-40">
                                    <div class="col-lg-5">
                                        <div class="sec-lg-head md-mb30">
                                            <h6 class="sub-title" style="color: #454545 !important;">OUR TAGLINE</h6>
                                            <h2 class="d-rotate wow">
                                                <span class="rotate-text" style="color: #00395B !important;">Shape
                                                    <br>Your Digital Business.</span>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 offset-lg-2 valign">
                                        <div class="text">
                                            <p class="d-slideup wow" style="color: #AAAAAA;">
                                                <span class="sideup-text">
                                                    <span class="up-text"><b
                                                            style="font-weight: bold; color: #00395B !important;"><u>Our
                                                                Vision:</u></b>
                                                        <br>
                                                        <p style="color: #454545 !important;">Being a blessed provider
                                                            of
                                                            digital ecosystem services will impact all aspects of the
                                                            digital
                                                            business to reach full market potential.</p>
                                                    </span>
                                                </span>
                                                <br>
                                                <span class="sideup-text">
                                                    <span class="up-text"><b
                                                            style="font-weight: bold; color: #00395B !important;"><u>Our
                                                                Mission:</u></b>
                                                        <br>
                                                        <p style="color: #454545 !important;">Observing current
                                                            development,
                                                            planning innovative plans, working with honesty, executing
                                                            with
                                                            passion,
                                                            and evaluating all actions to achieve the full market
                                                            potential.</p>
                                                    </span>
                                                </span>
                                            </p>
                                            <div class="vew-all bg-2 mt-50 ml-30 wow fadeIn" data-wow-delay=".2s">
                                                <!-- <a href="#" style="font-weight: bold; color: #00395B !important;">View
                                                    All About Us
                                                    <span>
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row mb-80 ">
                                    <div class="col-lg-12">
                                        <div class="sec-lg-head md-mb30" style="text-align: center;">
                                            <h6 class="sub-title d-slideup wow" style="color: #454545 !important;">OUR VALUE</h6>
                                            <h2 class="d-rotate wow">
                                                <span class="rotate-text" style="color: #00395B !important;">P  A  C  E</span>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="imago wow col-lg-3 col-md-6 col-6" style="text-align: center;">
                                        <img style="width: 80%;" src="assets/imgs/value/1.png?<?php echo $version;?>" alt="">
                                        <p style="font-size: 13px; line-height: 1.5; color: #00395B !important; text-align: center;">Doing everything with enthusiasm<br>and full dedication to achieve<br>the best results.</p>
                                    </div>
                                    <div class="imago wow col-lg-3 col-md-6 col-6" style="text-align: center;">
                                        <img style="width: 80%;" src="assets/imgs/value/2.png?<?php echo $version;?>" alt="">
                                        <p style="font-size: 13px; line-height: 1.5; color: #00395B !important; text-align: center;">Being quick to respond<br>to change and able to adapt<br>in various situations.</p>
                                    </div>
                                    <div class="imago wow col-lg-3 col-md-6 col-6" style="text-align: center;">
                                        <img style="width: 80%;" src="assets/imgs/value/3.png?<?php echo $version;?>" alt="">
                                        <p style="font-size: 13px; line-height: 1.5; color: #00395B !important; text-align: center;">Empathetic and caring towards<br>all needs, willing to help sincerely.</p>
                                    </div>
                                    <div class="imago wow col-lg-3 col-md-6 col-6" style="text-align: center;">
                                        <img style="width: 80%;" src="assets/imgs/value/4.png?<?php echo $version;?>" alt="">
                                        <p style="font-size: 13px; line-height: 1.5; color: #00395B !important; text-align: center;">Committed to being<br>the best by continuously<br>enhancing self-value.</p>
                                    </div>

                                    
                                </div>


                                <div class="row justify-content-center">
                                    <div class="col-lg-6 rest">
                                        <div class="imgs md-mb50">
                                            <div class="img1">
                                                <div class="o-hidden">
                                                    <div class="imago wow">
                                                        <img src="assets/imgs/about/01.jpg?<?php echo $version;?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="img2">
                                                <div class="o-hidden">
                                                    <div class="imago wow">
                                                        <img src="assets/imgs/about/1.jpg?<?php echo $version;?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 valign rest">
                                        <div class="cont">
                                            <h2 class="d-rotate wow">
                                                <span class="rotate-text" style="color: #00395B !important;">Unlock
                                                    Revenue Growth for Your
                                                    Business.</span>
                                            </h2>
                                            <div class="feat mt-80">
                                                <div class="item-flex d-flex align-items-center mb-50 wow fadeIn"
                                                    data-wow-delay=".2s">
                                                    <div>
                                                        <div class="icon-img-50">
                                                            <img src="assets/imgs/serv-icons/0.png?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="cont ml-30">
                                                        <h6 style="font-weight: bold; color: #00395B !important;">
                                                            Measure & Scale</h6>
                                                        <p class="fz-15" style="color: #454545 !important;">We are
                                                            dedicated to measuring and optimizing
                                                            for
                                                            your
                                                            maximum business potential.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="item-flex d-flex align-items-center wow fadeIn"
                                                    data-wow-delay=".2s">
                                                    <div>
                                                        <div class="icon-img-50">
                                                            <img src="assets/imgs/serv-icons/1.png?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="cont ml-30">
                                                        <h6 style="font-weight: bold; color: #00395B !important;">
                                                            Established Team</h6>
                                                        <p class="fz-15" style="color: #454545 !important;">We do a lot
                                                            of training and certification for
                                                            our
                                                            team.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <!-- ==================== End about ==================== -->



                    <!-- ==================== Start marq ==================== -->

                    <section class="serv-marq main-colorbg2">
                        <div class="container-fluid ontop sub-bg rest pt-20 pb-20" style="background-color: #00395b;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="main-marq light-text">
                                        <div class="slide-har st1" style="max-width: 100%; overflow: hidden;">
                                            <div class="box non-strok">
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>PT. Digital Informasi
                                                            Kreatif</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Di-Grow</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Kroma Flux</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Terraform</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>DIK Product</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>DIK Group</span> <span
                                                            class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                            </div>
                                            <div class="box non-strok">
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>PT. Digital Informasi
                                                            Kreatif</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Di-Grow</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Kroma Flux</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>Terraform</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>DIK Product</span>
                                                        <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                                <div class="item">
                                                    <h4 class="d-flex align-items-center"><span>DIK Group</span> <span
                                                            class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                    <!-- ==================== End marq ==================== -->



                    <!-- ==================== Start services tabs ==================== -->

                    <section class="services-tab revers section-padding pt-80 parallaxie"
                        data-background="none"
                        style="color: #AAAAAA !important; background-color: #00395b;">
                        <div class="container">

                            <div class="row justify-content-center" id="tabs">
                                <div class="col-lg-5 valign">
                                    <div class="serv-tab-link tab-links full-width md-mb50">
                                        <div class="sec-lg-head mb-80 wow fadeIn">

                                            <div class="sec-lg-head md-mb30">
                                                <h6 class="sub-title" style="color: #fff !important;">DIK GROUP</h6>
                                                <h2 class="d-rotate wow">
                                                    <span class="rotate-text" style="color: #FEB062 !important;">Entrust
                                                        all your digital needs to us.</span>
                                                </h2>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <ul class="rest" style="color: #FEB062 !important;">
                                                    <li class="item-link current mb-15 pb-15 bord-thin-bottom"
                                                        data-tab="tabs-1"><span
                                                            style="color: #fff !important;">01</span> Terraform</li>
                                                    <li class="item-link mb-15 pb-15 bord-thin-bottom"
                                                        data-tab="tabs-2">
                                                        <span style="color: #fff !important;">02</span> Di-Grow
                                                    </li>
                                                    <li class="item-link mb-15 pb-15 bord-thin-bottom"
                                                        data-tab="tabs-3">
                                                        <span style="color: #fff !important;">03</span> Kromaflux
                                                    </li>
                                                    <li class="item-link" data-tab="tabs-4"><span
                                                            style="color: #fff !important;">04</span> DIK Product</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="serv-tab-cont">
                                        <div class="tab-content current" id="tabs-1">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="assets/imgs/sass-img/serv/4.jpg?<?php echo $version;?>"
                                                        alt="">
                                                </div>
                                                <div class="cont sub-bg" style="background-color: #013352;">
                                                    <div class="icon-img-120 mb-40">
                                                        <img src="assets/imgs/brands/01.png?<?php echo $version;?>"
                                                            alt="">
                                                    </div>
                                                    <div class="text">
                                                        <p> Terraform specializes in system creation, analysis, and
                                                            application
                                                            development.
                                                            Our expert team combines system analysis expertise with
                                                            cutting-edge application
                                                            development to provide efficient tech solutions that
                                                            transform
                                                            how your business operates.</p>
                                                    </div>
                                                    <div class="vew-all mt-50 ml-30">
                                                        <a href="#">Learn More
                                                            <span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="bg-pattern bg-img"
                                                        data-background="assets/imgs/patterns/abstact-BG.png?<?php echo $version;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="tabs-2">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="assets/imgs/sass-img/serv/2.jpg?<?php echo $version;?>"
                                                        alt="">
                                                </div>
                                                <div class="cont sub-bg" style="background-color: #013352;">
                                                    <div class="icon-img-120 mb-40">
                                                        <img src="assets/imgs/brands/02.png?<?php echo $version;?>"
                                                            alt="">
                                                    </div>
                                                    <div class="text">
                                                        <p>Di-Grow excels in digital marketing strategies and solutions.
                                                            Our seasoned team seamlessly merges in-depth data analysis
                                                            with
                                                            state-of-the-art
                                                            marketing techniques to deliver effective digital marketing
                                                            solutions that redefine
                                                            your business's online presence.</p>
                                                    </div>
                                                    <div class="vew-all mt-50 ml-30">
                                                        <a href="#">Learn More
                                                            <span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="bg-pattern bg-img"
                                                        data-background="assets/imgs/patterns/abstact-BG.png?<?php echo $version;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="tabs-3">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="assets/imgs/sass-img/serv/3.jpg?<?php echo $version;?>"
                                                        alt="">
                                                </div>
                                                <div class="cont sub-bg" style="background-color: #013352;">
                                                    <div class="icon-img-120 mb-40">
                                                        <img src="assets/imgs/brands/03.png?<?php echo $version;?>"
                                                            alt="">
                                                    </div>
                                                    <div class="text">
                                                        <p>Kromaflux is your go-to destination for visionary visual
                                                            design.
                                                            Our creative team seamlessly merges artistic flair with
                                                            cutting-edge
                                                            design techniques to craft captivating visuals that elevate
                                                            your
                                                            brand on
                                                            social media, enhance your products, and fulfill your visual
                                                            design
                                                            requirements with a touch of artistry.</p>
                                                    </div>
                                                    <div class="vew-all mt-50 ml-30">
                                                        <a href="#">Learn More
                                                            <span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="bg-pattern bg-img"
                                                        data-background="assets/imgs/patterns/abstact-BG.png?<?php echo $version;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="tabs-4">
                                            <div class="item">
                                                <div class="img">
                                                    <img src="assets/imgs/sass-img/serv/1.jpg?<?php echo $version;?>"
                                                        alt="">
                                                </div>
                                                <div class="cont sub-bg" style="background-color: #013352;">
                                                    <div class="icon-img-120 mb-40">
                                                        <a>DG_Product</a>
                                                    </div>
                                                    <div class="text">
                                                        <p>DIK Product is your partner in brand product incubation and
                                                            collaborative growth.
                                                            Our dedicated team combines industry expertise with
                                                            innovative
                                                            strategies to nurture
                                                            and co-develop promising product brands.
                                                            Together, we'll embark on a journey to transform concepts
                                                            into
                                                            market-ready successes,
                                                            bringing your product visions to life.</p>
                                                    </div>
                                                    <div class="vew-all mt-50 ml-30">
                                                        <a href="#">Learn More
                                                            <span>
                                                                <svg width="18" height="18" viewBox="0 0 18 18"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="bg-pattern bg-img"
                                                        data-background="assets/imgs/patterns/abstact-BG.png?<?php echo $version;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- ==================== End services tabs ==================== -->




                            <!-- ==================== Start Services ==================== -->

                            <section class="services section-padding pb-0 block-pattern"
                                style="color: #AAAAAA !important;">
                                <div class="container">
                                    <div class="sec-head mb-80">
                                        <div class="row">
                                            <div class="col-lg-5 sec-lg-head">

                                                <div class="sec-lg-head md-mb30">
                                                    <h6 class="sub-title" style="color: #fff !important;">MAIN DIRECTION
                                                    </h6>
                                                    <h2 class="d-rotate wow">
                                                        <span class="rotate-text" style="color: #FEB062 !important;">Our
                                                            Services.</span>
                                                    </h2>
                                                </div>


                                            </div>
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <div class="text d-rotate wow md-mb30">
                                                    <p class="rotate-text">Finding the best marketing solution for your
                                                        business.
                                                        Driven
                                                        by
                                                        data based on human
                                                        behavior.</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 d-flex align-items-center wow fadeIn">
                                                <div class="full-width">
                                                    <div class="d-flex justify-content-end justify-end">
                                                        <div class="swiper-controls arrow-out d-flex">
                                                            <div class="swiper-button-prev">
                                                                <span class="left">
                                                                    <svg width="20" height="20" viewBox="0 0 20 20"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M17.2031 10.3281L11.5781 15.9531C11.535 15.9961 11.4839 16.0303 11.4276 16.0536C11.3713 16.077 11.3109 16.089 11.25 16.089C11.1891 16.089 11.1287 16.077 11.0724 16.0536C11.0161 16.0303 10.965 15.9961 10.9219 15.9531C10.8788 15.91 10.8446 15.8588 10.8213 15.8025C10.798 15.7462 10.786 15.6859 10.786 15.6249C10.786 15.564 10.798 15.5036 10.8213 15.4473C10.8446 15.391 10.8788 15.3399 10.9219 15.2968L15.7422 10.4687H3.125C3.00068 10.4687 2.88145 10.4193 2.79354 10.3314C2.70564 10.2435 2.65625 10.1242 2.65625 9.99993C2.65625 9.87561 2.70564 9.75638 2.79354 9.66847C2.88145 9.58056 3.00068 9.53118 3.125 9.53118H15.7422L10.9219 4.70305C10.8349 4.61603 10.786 4.498 10.786 4.37493C10.786 4.25186 10.8349 4.13383 10.9219 4.0468C11.0089 3.95978 11.1269 3.91089 11.25 3.91089C11.3731 3.91089 11.4911 3.95978 11.5781 4.0468L17.2031 9.6718C17.2476 9.71412 17.2829 9.76503 17.3071 9.82143C17.3313 9.87784 17.3438 9.93856 17.3438 9.99993C17.3438 10.0613 17.3313 10.122 17.3071 10.1784C17.2829 10.2348 17.2476 10.2857 17.2031 10.3281Z"
                                                                            fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                            <div class="swiper-button-next ml-50">
                                                                <span class="right">
                                                                    <svg width="20" height="20" viewBox="0 0 20 20"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M17.2031 10.3281L11.5781 15.9531C11.535 15.9961 11.4839 16.0303 11.4276 16.0536C11.3713 16.077 11.3109 16.089 11.25 16.089C11.1891 16.089 11.1287 16.077 11.0724 16.0536C11.0161 16.0303 10.965 15.9961 10.9219 15.9531C10.8788 15.91 10.8446 15.8588 10.8213 15.8025C10.798 15.7462 10.786 15.6859 10.786 15.6249C10.786 15.564 10.798 15.5036 10.8213 15.4473C10.8446 15.391 10.8788 15.3399 10.9219 15.2968L15.7422 10.4687H3.125C3.00068 10.4687 2.88145 10.4193 2.79354 10.3314C2.70564 10.2435 2.65625 10.1242 2.65625 9.99993C2.65625 9.87561 2.70564 9.75638 2.79354 9.66847C2.88145 9.58056 3.00068 9.53118 3.125 9.53118H15.7422L10.9219 4.70305C10.8349 4.61603 10.786 4.498 10.786 4.37493C10.786 4.25186 10.8349 4.13383 10.9219 4.0468C11.0089 3.95978 11.1269 3.91089 11.25 3.91089C11.3731 3.91089 11.4911 3.95978 11.5781 4.0468L17.2031 9.6718C17.2476 9.71412 17.2829 9.76503 17.3071 9.82143C17.3313 9.87784 17.3438 9.93856 17.3438 9.99993C17.3438 10.0613 17.3313 10.122 17.3071 10.1784C17.2829 10.2348 17.2476 10.2857 17.2031 10.3281Z"
                                                                            fill="currentColor"></path>
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="serv-items-crev">
                                        <div class="serv-swiper" data-carousel="swiper" data-items="10" data-loop="true"
                                            data-space="0" data-speed="1000">
                                            <div id="content-carousel-container-unq-serv" class="swiper-container"
                                                data-swiper="container">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/0-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Marketing
                                                                Strategy</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Develop a roadmap for
                                                                promoting
                                                                products
                                                                or services to meet business objectives.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <svg width="18" height="18" viewBox="0 0 18 18"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                            fill="currentColor"></path>
                                                                    </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/1-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Social
                                                                Media Management</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Involves the strategic
                                                                planning,
                                                                execution, and monitoring of a brand's online presence
                                                                on
                                                                various
                                                                social platforms to engage.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Social
                                                                Media Marketing</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">The use of social platforms to
                                                                promote
                                                                products or services, build brand awareness, and connect
                                                                with
                                                                audiences, employing various strategies to achieve
                                                                marketing
                                                                goals.
                                                            </p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/1-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Integrated
                                                                System</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Develop cutting-edge IT
                                                                solutions for
                                                                your
                                                                business needs.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/0-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Search
                                                                Engine Optimization
                                                            </h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Perform a comprehensive
                                                                website audit
                                                                &
                                                                optimization to attract more visitors.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/1-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Product
                                                                Design</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Involves creating and refining
                                                                physical or
                                                                digital products to ensure they are functional,
                                                                aesthetically
                                                                pleasing, and user-friendly.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                Website
                                                                Design</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Is the art and science of
                                                                creating
                                                                visually appealing and user-friendly websites to engage
                                                                and
                                                                inform
                                                                visitors effectively.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide wow fadeIn" data-wow-delay=".2s">
                                                        <div class="item">
                                                            <div class="icon-img-60 mb-40">
                                                                <img src="assets/imgs/serv-icons/1-2.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                            <h6 class="mb-15"
                                                                style="min-height: 40px; color: #FEB062 !important;">
                                                                E-Commerce
                                                                Enabler</h6>
                                                            <hr>
                                                            <p style="min-height: 150px;">Refers to the buying and
                                                                selling of
                                                                goods
                                                                or services online, making transactions convenient.</p>
                                                            <div class="vew-all mt-50 ml-30">
                                                                <a href="page-contact.php">Contact Us
                                                                    <span>
                                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                                            fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </section>

                    <!-- ==================== End Services ==================== -->




                    <!-- ==================== Start section ==================== -->

                    <section class="works thecontainer" style="display: none !important;"></section>

                    <!-- ==================== End section ==================== -->




                    <!-- ==================== Start Services ==================== -->

                    <section class="services-tab revers pt-0" style="background-color: #00395B;">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="full-width">
                                        <div class="main-marq o-hidden pt-40 pb-40 bord-thin-top bord-thin-bottom">
                                            <div class="slide-har st1">
                                                <div class="box"
                                                    style="animation: slide-har 30s linear infinite !important;">
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>Let's Make the
                                                                Future a Utopia</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>The Future is
                                                                Already Here</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>Let's Make the
                                                                Future a Utopia</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>

                                                </div>
                                                <div class="box"
                                                    style="animation: slide-har 30s linear infinite !important;">
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>The Future is
                                                                Already Here</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>Let's Make the
                                                                Future a Utopia</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>
                                                    <div class="item">
                                                        <h4 class="d-flex align-items-center fz-30"><span>The Future is
                                                                Already Here</span>
                                                            <span class="fz-50 ml-50"><img style="width: 15px;" src="assets/imgs/logogram.png?<?php echo $version;?>" alt=""></span>
                                                        </h4>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>



                    <!-- ==================== End Services ==================== -->






                    <!-- ==================== Start testimonails ==================== -->

                    <section class="testim-crv2 section-padding parallaxie"
                        data-background="assets/imgs/patterns/2.png?<?php echo $version;?>"
                        style="background-color: white; color: #AAAAAA !important;">
                        <div class="container">
                            <div class="row" style="display: none !important;">
                                <div class="col-12">
                                    <div class="sec-lg-head mb-80">
                                        <div class="position-re text-center">
                                            <h2 class="d-rotate wow" style="color: #00395B !important;">
                                                <span class="rotate-text"><u>Quotes From Our Team</u></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>





                                <div class="testim-swiper" data-carousel="swiper" data-items="1" data-loop="true"
                                    data-space="30">
                                    <div id="content-carousel-container-unq-testim" class="swiper-container"
                                        data-swiper="container">
                                        <div class="swiper-wrapper">

                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/1.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">Unlock
                                                                the digital potential of your
                                                                business
                                                                with us.
                                                                As your trusted partner in the dynamic world of digital
                                                                ecosystems,
                                                                we're here to turn your vision into reality. Remember,
                                                                success is not about standing still;
                                                                it's about evolving, adapting, and thriving.
                                                                With our expertise, we'll help you harness the full
                                                                power of
                                                                the digital realm. </h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/1.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Kevin T.
                                                                            Gunawan</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">President
                                                                        Director</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Kevin T. Gunawan</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">President
                                                                    Director</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/2.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">
                                                                Failure simply means we're in the early
                                                                stages. Never shy away from it; instead,
                                                                embrace it as a teacher. At DIK Group, we believe in the
                                                                power of resilience and growth.
                                                                Our digital ecosystem services are designed to transform
                                                                setbacks into stepping stones
                                                                and challenges into opportunities.</h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/2.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Theodorus
                                                                            Gratianus</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">Head of DG
                                                                        Product</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Theodorus Gratianus</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">Head of DG
                                                                    Product</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/3.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">
                                                                Everyone has dreams to fulfill; without
                                                                dreams, we lack purpose.
                                                                Dreams inspire us to take responsibility for their
                                                                realization. At DIK Group,
                                                                we're here to turn your digital aspirations into
                                                                reality.
                                                                Join us in this journey of achievement,
                                                                where dreams become goals, and goals become success
                                                                stories.
                                                            </h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/3.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Samuel
                                                                            Tito</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">Head of
                                                                        Di-Grow</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Samuel Tito</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">Head of
                                                                    Di-Grow</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/4.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">Design
                                                                is not just about how it looks
                                                                good;
                                                                it's also about how the story behind it
                                                                resonates in the minds. Unlock the potential of design
                                                                with
                                                                DIK Group.
                                                                Join us in crafting digital ecosystems where every
                                                                design
                                                                tells a captivating story,
                                                                turning your vision into a digital masterpiece!</h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/4.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Monika
                                                                            Feliciana</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">Head of
                                                                        Kromaflux</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Monika Feliciana</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">Head of
                                                                    Kromaflux</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>


                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/5.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">Beyond
                                                                Boundaries, Exploring Creativity.
                                                                At DIK Group, we're your passport to digital innovation.
                                                                Join us in unlocking new horizons, where creativity
                                                                knows no
                                                                limits,
                                                                and let's redefine your digital journey together.</h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/5.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Geraldo
                                                                            Taroreh</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">SPV of
                                                                        Kromaflux</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Geraldo Taroreh</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">SPV of
                                                                    Kromaflux</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>


                                            <div class="swiper-slide">
                                                <div class="item row">
                                                    <div class="col-lg-5 position-re wow fadeIn" data-wow-delay=".2s">
                                                        <div
                                                            class="bord-qoute d-flex align-items-center justify-content-center">
                                                            <div class="qoute-icon" style="background-color: #00395B">
                                                                <img src="assets/imgs/svg-assets/quote.png?<?php echo $version;?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="img-qoute">
                                                            <img src="assets/imgs/testim/6.jpg?<?php echo $version;?>"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 wow fadeIn" data-wow-delay=".2s">

                                                        <div class="cont mb-40">
                                                            <h5 class="fw-400" style="color: #444444 !important;">Don't
                                                                be afraid to try before you start.
                                                                We never know that the risks we can take will result in
                                                                satisfying results.
                                                                In the DIK Group, we can learn to consider the risks
                                                                faced to
                                                                achieve the desired goals.</h5>
                                                        </div>
                                                        <?php

                                        $useragent=$_SERVER['HTTP_USER_AGENT'];

                                        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
                                        ||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                        substr($useragent,0,4))){

                                    ?>

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="img circle-60">
                                                                    <img src="assets/imgs/testim/6.jpg?<?php echo $version;?>"
                                                                        alt="" class="circle-img">
                                                                </div>
                                                            </div>
                                                            <div class="ml-30">
                                                                <div class="info">
                                                                    <h6 class="fz-16"
                                                                        style="color: #444444 !important;"><u>Axel
                                                                            Novian</u></h6>
                                                                    <span class="opacity-7 sub-title"
                                                                        style="color: #444444 !important;">General
                                                                        Affair</span>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <?php }else{ ?>

                                                        <div class="d-flex align-items-center">
                                                            <div class="info">
                                                                <h6 class="fz-16" style="color: #444444 !important;">
                                                                    <u>Axel Novian</u></h6>
                                                                <span class="opacity-7 sub-title"
                                                                    style="color: #444444 !important;">General
                                                                    Affair</span>
                                                            </div>
                                                        </div>

                                                        <?php } ?>


                                                    </div>

                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="swiper-controls testim-controls arrow-out d-flex ml-auto">
                                        <div class="swiper-button-prev">
                                            <span class="left" style="color: #00395B; border: 1px solid #00395B;">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.2031 10.3281L11.5781 15.9531C11.535 15.9961 11.4839 16.0303 11.4276 16.0536C11.3713 16.077 11.3109 16.089 11.25 16.089C11.1891 16.089 11.1287 16.077 11.0724 16.0536C11.0161 16.0303 10.965 15.9961 10.9219 15.9531C10.8788 15.91 10.8446 15.8588 10.8213 15.8025C10.798 15.7462 10.786 15.6859 10.786 15.6249C10.786 15.564 10.798 15.5036 10.8213 15.4473C10.8446 15.391 10.8788 15.3399 10.9219 15.2968L15.7422 10.4687H3.125C3.00068 10.4687 2.88145 10.4193 2.79354 10.3314C2.70564 10.2435 2.65625 10.1242 2.65625 9.99993C2.65625 9.87561 2.70564 9.75638 2.79354 9.66847C2.88145 9.58056 3.00068 9.53118 3.125 9.53118H15.7422L10.9219 4.70305C10.8349 4.61603 10.786 4.498 10.786 4.37493C10.786 4.25186 10.8349 4.13383 10.9219 4.0468C11.0089 3.95978 11.1269 3.91089 11.25 3.91089C11.3731 3.91089 11.4911 3.95978 11.5781 4.0468L17.2031 9.6718C17.2476 9.71412 17.2829 9.76503 17.3071 9.82143C17.3313 9.87784 17.3438 9.93856 17.3438 9.99993C17.3438 10.0613 17.3313 10.122 17.3071 10.1784C17.2829 10.2348 17.2476 10.2857 17.2031 10.3281Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="swiper-button-next ml-50">
                                            <span class="right" style="color: #00395B; border: 1px solid #00395B;">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.2031 10.3281L11.5781 15.9531C11.535 15.9961 11.4839 16.0303 11.4276 16.0536C11.3713 16.077 11.3109 16.089 11.25 16.089C11.1891 16.089 11.1287 16.077 11.0724 16.0536C11.0161 16.0303 10.965 15.9961 10.9219 15.9531C10.8788 15.91 10.8446 15.8588 10.8213 15.8025C10.798 15.7462 10.786 15.6859 10.786 15.6249C10.786 15.564 10.798 15.5036 10.8213 15.4473C10.8446 15.391 10.8788 15.3399 10.9219 15.2968L15.7422 10.4687H3.125C3.00068 10.4687 2.88145 10.4193 2.79354 10.3314C2.70564 10.2435 2.65625 10.1242 2.65625 9.99993C2.65625 9.87561 2.70564 9.75638 2.79354 9.66847C2.88145 9.58056 3.00068 9.53118 3.125 9.53118H15.7422L10.9219 4.70305C10.8349 4.61603 10.786 4.498 10.786 4.37493C10.786 4.25186 10.8349 4.13383 10.9219 4.0468C11.0089 3.95978 11.1269 3.91089 11.25 3.91089C11.3731 3.91089 11.4911 3.95978 11.5781 4.0468L17.2031 9.6718C17.2476 9.71412 17.2829 9.76503 17.3071 9.82143C17.3313 9.87784 17.3438 9.93856 17.3438 9.99993C17.3438 10.0613 17.3313 10.122 17.3071 10.1784C17.2829 10.2348 17.2476 10.2857 17.2031 10.3281Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- ==================== End testimonails ==================== -->

                        <!-- ==================== Start Blog ==================== -->

                        <section class="blog-list-half crev section-padding">
                            <div class="container">
                                <div class="sec-lg-head mb-80">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h6 class="sub-title" style="color: #454545 !important;">OUR BLOG</h6>
                                            <h2 class="d-rotate wow">
                                                <span class="rotate-text" style="color: #00395B !important">Inspire, Inform, Engage, Empower !</span>
                                            </h2>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-center">
                                            <div class="full-width d-flex justify-content-end justify-end">

                                                <div class="vew-all bg-2 mt-50 ml-30 wow fadeIn" data-wow-delay=".2s">
                                                    <a href="blog.php"
                                                        style="font-weight: bold; color: #00395B !important;">View All
                                                        <span>
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row wow fadeIn" data-wow-delay=".2s">

                                  <?php 
                                        $result_head = mysqli_query($db2,"select *, da.created_at as tanggal_buat from dg_article da
                                        inner join dg_user du on da.id_author = du.id_dg_user
                                        where da.deleted_at is null
                                        ORDER BY da.created_at DESC
                                        limit 2");
                                        while($d_head = mysqli_fetch_array($result_head)){
                                            $id_dg_article = $d_head['id_dg_article'];  
                                    ?>
                                    <div class="col-lg-6">
                                        <div class="item md-mb80" style="border: 1px solid #00395B">
                                            <div class="row rest">
                                                <div class="col-md-6">
                                                    <div class="img" style="display: flex; align-items: center;">
                                                        <img src="management/img/article/<?php echo $d_head['banner_utama']; ?>" alt="<?php echo $d_head['banner_utama']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 valign">
                                                    <div class="cont">
                                                        <span class="date fz-12 ls1 text-u opacity-7 mb-15"
                                                            style="color: #00395B !important;">
                                                                <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>">
                                                                    <?php echo date_format(date_create($d_head['tanggal_buat']),"d F Y"); ?>
                                                                </a>
                                                        </span>
                                                        <h5>
                                                            <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>"
                                                                style="color: #00395B !important;"><?php echo $d_head['judul_article']; ?></a>
                                                        </h5>
                                                        <div class="tags colorbg mt-15">
                                                            <?php 
                                                                $result_category = mysqli_query($db2,"select * from dg_article_category_m dacm inner join dg_article_category dac
                                                                on dacm.id_dg_article_category = dac.id_dg_article_category where dacm.id_dg_article = $id_dg_article");
                                                                while($d_category = mysqli_fetch_array($result_category)){
                                                            ?>
                                                            <a href="blog.php" style="border: 1px solid #454545 !important; color: #454545 !important;"><?php  echo $d_category['nama_category']; ?></a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </section>

        </div>
        </section>

        <!-- ==================== End Blog ==================== -->





        </section>



        <!-- ==================== End Slider ==================== -->












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

    </script>

</body>

</html>