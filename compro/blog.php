<?php 
// mengaktifkan session
session_start();
include 'management/controller/conn.php';

$version = 2.1; 
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

        <header class="page-header section-padding sub-bg" style="background-color: #EEEEEE; color: #AAAAAA !important;">
            <div class="container mt-80">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="sec-lg-head md-mb30">
                            <h6 class="sub-title" style="color: #454545 !important;">OUR BLOG</h6>
                            <h1 class="fz-55" style="color: #00395B !important;">Inspire, Inform, Engage, Empower!</h1>
                        </div>
                    </div>
                    <div class="col-lg-5 valign">
                        <div class="text">
                            <p style="color: #454545 !important;">Embark on a journey through insights and inspiration. Explore with us on Our Blog as we delve into in-depth perspectives, spark innovative ideas, and navigate the latest trends in our dynamic digital landscape!</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ==================== End Slider ==================== -->
        


        <!-- ==================== Start Blog ==================== -->

        <section class="portfolio blog-modern section-padding sub-bg" style="min-height: 1000px;">
            <div class="container">

                <div class="row">
                    <!-- filter links -->
                    <div class="filtering col-12 mb-80 text-center">
                        <div class="filter">
                            <span class="text">Filter By :</span>
                            <span data-filter='*' class='active' >All</span>
                            <?php 
                            $result_head = mysqli_query($db2,"select * from `dg_article_category`");
                            while($d_head = mysqli_fetch_array($result_head)){
                            ?>
                            <span data-filter='.<?php echo $d_head['nama_category']; ?>' ><?php echo $d_head['nama_category']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="gallery">
                    <div class="row grid md-marg">
                    

                        <?php 

                        $result_head = mysqli_query($db2,"select *, da.created_at as tanggal_buat from dg_article da
                        inner join dg_user du on da.id_author = du.id_dg_user
                        where da.deleted_at is null
                        ORDER BY da.created_at DESC");
                        while($d_head = mysqli_fetch_array($result_head)){
                            $id_dg_article = $d_head['id_dg_article'];  
                        ?>

                        <div class="col-lg-4 col-md-6 items <?php 
                                                        $result_category = mysqli_query($db2,"select * from dg_article_category_m dacm inner join dg_article_category dac
                                                        on dacm.id_dg_article_category = dac.id_dg_article_category where dacm.id_dg_article = $id_dg_article");
                                                        while($d_category = mysqli_fetch_array($result_category)){
                                                            echo $d_category['nama_category']." "; 
                                                        } ?> info-overlay mb-50">
                            <div class="item mb-50">
                                <div class="img">
                                <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>"><img src="management/img/article/<?php echo $d_head['banner_utama']; ?>" alt="<?php echo $d_head['banner_utama']; ?>"></a>
                                    <div class="date">
                                        <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>"><?php echo date_format(date_create($d_head['tanggal_buat']),"d F Y"); ?></a>
                                    </div>
                                </div>
                                <div class="cont mt-30">
                                    <h6>
                                        <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>" style="color: #FEB062 !important;"><?php echo $d_head['judul_article']; ?></a>
                                    </h6>
                                        <a href="blog-details.php?judul=<?php echo str_replace(' ', '-', $d_head['judul_article']); ?>&id=<?php echo $d_head['id_dg_article']; ?>" class="mt-20 ls1 sub-title">Read More <i
                                            class="ml-5"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z" fill="currentColor"></path>
                                            </svg></i></a>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- ==================== Start Blog ==================== -->

        <section class="testim-crv2 section-padding parallaxie"
                        data-background="assets/imgs/works/full/2.jpg?<?php echo $version;?>"
                        style="background-color: #00395B; color: #AAAAAA !important;">
                        
        </section>

        <!-- ==================== End Blog ==================== -->

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

</body>

</html>