<?php session_start(); ?>

<!DOCTYPE html>

<html lang="PT. Digital Informasi Kreatif">



<?php 

    include 'view/head.php'; 

?>



<body class="main-bg">







    <!-- ==================== Start Loading ==================== -->



    <?php include 'view/loading.html'; ?>



    <!-- ==================== End Loading ==================== -->





    <div class="cursor"></div>





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

                            <h6 class="sub-title" style="color: #454545 !important;">Contact Us</h6>

                            <h1 class="fz-55" style="color: #00395B !important;">Let's make <br> your brand brilliant!</h1>

                        </div>

                    </div>

                    <div class="col-lg-5 valign">

                        <div class="text">

                            <p style="color: #454545 !important;">We help our clients succeed by creating brand identities, digital experiences, and print materials that communicate clearly, achieve marketing goals, and look fantastic.</p>

                        </div>

                    </div>

                </div>

            </div>

        </header>



        <!-- ==================== End Slider ==================== -->







        <!-- ==================== Start Contact ==================== -->



        <section class="contact-crev section-padding" style="background-color: #00395B; color: #AAAAAA !important;">

            <div class="container">

                <div class="row">

                    <div class="col-lg-5">

                        <div class="sec-lg-head mb-80">

                            <h6 class="mb-10">Get In Touch</h6>

                            <h2 class="fz-50" style="color: #FEB062;">Let's get in <br> touch with us.</h2>

                            <p class="fz-15 mt-10">If you would like to work with us or just want to get in

                                touch, we’d love to hear from you!</p>

                            <div class="phone fz-20 fw-200 mt-30 underline">

                                <a class="pb-10" href="mailto: info@dikgroup.id">info@dikgroup.id</a><br>

                                <a target="_blank" href="https://api.whatsapp.com/send?phone=6282385585576&text=Hello%2C+DIK+Group&#33+I&#39d+like+to+ask+about+the+service&#46">+62 823-8558-5576 (Admin KromaFlux)</a>

                                <a target="_blank" href="https://api.whatsapp.com/send?phone=6285721954543&text=Hello%2C+DG+Group&#33+I&#39d+like+to+ask+about+the+service&#46">+62 857-2195-4543 (Nixon)</a>

                            </div>

                            <ul class="rest social-text d-flex mt-60">

                                <li class="mr-30">

                                    <a href="#0">Terraform</a>

                                </li>

                                <li class="mr-30">

                                    <a href="#0">DiGrow</a>

                                </li>

                                <li class="mr-30">

                                    <a href="#0">KromaFlux</a>

                                </li>

                                <li>

                                    <a href="#0">DIK Product</a>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="col-lg-6 offset-lg-1 valign">

                    

                        <div class="full-width">

                            <form id="contact-form-1" method="post" action="controller/contact.php">

                            <?php

                            if (!isset($_SESSION['status_send'])) {

                                $_SESSION['status_send'] = "";

                            }

                            if ($_SESSION['status_send'] == "fail") {

                            ?>

                            <div class="alert">

                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 

                                <strong>Sorry!</strong> Your message could not be sent. <br>Please try again in a moment!

                            </div>

                            <?php }elseif($_SESSION['status_send'] == "sending"){?>

                            <div class="alert success">

                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 

                                <strong>Thank you!</strong> Your message has been successfully delivered.<br>Our team will get back to you shortly!

                            </div>

                            <?php } $_SESSION['status_send'] = ""; ?>



                                <div class="controls row">



                                    <div class="col-lg-6">

                                        <div class="form-group mb-30">

                                            <input id="form_name" type="text" name="name" placeholder="Name"

                                                required="required">

                                        </div>

                                    </div>



                                    <div class="col-lg-6">

                                        <div class="form-group mb-30">

                                            <input id="form_email" type="email" name="email" placeholder="Email"

                                                required="required">

                                        </div>

                                    </div>



                                    <div class="col-12">

                                        <div class="form-group mb-30">

                                            <input id="form_subject" type="text" name="subject" placeholder="Subject">

                                        </div>

                                    </div>



                                    <div class="col-12">

                                        <div class="form-group mb-30">

                                            <textarea id="form_message" name="message" placeholder="Message" rows="4"

                                                required="required"></textarea>

                                        </div>



                                        <div class="form-group mb-30">

                                            <div class="g-recaptcha" data-sitekey="6LfFT8opAAAAAGBIfqCZZ33fM6X7u3CGOjOfJCYX" data-callback="recaptchaCallback"></div>

                                        </div>

                                        

                                        <div class="mt-30">

                                            <button type="submit" id="submit-btn" class="butn butn-md butn-bord radius-30" disabled>

                                                <span class="text">Let's Talk</span>

                                            </button>

                                        </div>

                                    </div>



                                   



                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8634065841393!2d107.6147954747569!3d-6.906932393092458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ef05efd5e003%3A0x71ab2b80456e6da3!2sPT.%20Digital%20Informasi%20Kreatif%20(DG%20Group)!5e0!3m2!1sen!2sid!4v1705482222396!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <!-- ==================== End Contact ==================== -->



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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>



    <script>

    // Function to enable the submit button when reCAPTCHA is verified

    function recaptchaCallback() {

        document.getElementById('submit-btn').disabled = false;

    }



    // Event listener to prevent form submission if reCAPTCHA is not verified

    document.getElementById('contact-form-1').addEventListener('submit', function(event) {

        if (document.getElementById('submit-btn').disabled) {

            event.preventDefault(); // Prevent form submission if reCAPTCHA not verified

            alert('Please complete the reCAPTCHA');

        }

    });



    </script>



</body>



</html>