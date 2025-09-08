<!-- ==================== Start Footer ==================== -->
<?php
$path = $_SERVER['REQUEST_URI'];
$pathFragments = explode('/', $path);
$end = end($pathFragments);

    if ($end != "page-contact.php") {
?>
<footer class="sub-bg" style="background-color: #00395B; color: #FEB062;">
    <div class="footer-container">
        <div class="container ontop" style="padding-top: 150px; padding-bottom: 150px;">
            <?php if ($end == "index.php" || $end == "index2.php" || $end == "") { ?>
            <div class="call-box text-center mb-80">
                <h2>
                    <a href="page-contact.php">Let's <span class="stroke"> Discuss</span></a>
                    <span class="arrow">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.922 4.5V11.8125C13.922 11.9244 13.8776 12.0317 13.7985 12.1108C13.7193 12.1899 13.612 12.2344 13.5002 12.2344C13.3883 12.2344 13.281 12.1899 13.2018 12.1108C13.1227 12.0317 13.0783 11.9244 13.0783 11.8125V5.51953L4.79547 13.7953C4.71715 13.8736 4.61092 13.9176 4.50015 13.9176C4.38939 13.9176 4.28316 13.8736 4.20484 13.7953C4.12652 13.717 4.08252 13.6108 4.08252 13.5C4.08252 13.3892 4.12652 13.283 4.20484 13.2047L12.4806 4.92188H6.18765C6.07577 4.92188 5.96846 4.87743 5.88934 4.79831C5.81023 4.71919 5.76578 4.61189 5.76578 4.5C5.76578 4.38811 5.81023 4.28081 5.88934 4.20169C5.96846 4.12257 6.07577 4.07813 6.18765 4.07812H13.5002C13.612 4.07813 13.7193 4.12257 13.7985 4.20169C13.8776 4.28081 13.922 4.38811 13.922 4.5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                </h2>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-4">
                    <div class="colum md-mb50">
                        <div class="tit mb-20">
                            <h6>Address</h6>
                        </div>
                        <div class="text">
                            <p><a href="https://maps.app.goo.gl/YScDvu14aMbqGLXq6">Jl. Banda No. 30, Gedung Graha Pos Indonesia Lt. 2 Blok C, Citarum, Bandung Wetan, Kota Bandung 40115</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="colum md-mb50">
                        <div class="tit mb-20">
                            <h6>Say Hello</h6>
                        </div>
                        <div class="text">
                            <p class="mb-10">
                                <a class="hover-underline-animation" href="mailto: info@dggroup.id">info@dggroup.id</a>
                            </p>
                            <p>
                                <a class="hover-underline-animation" target="_blank" href="https://api.whatsapp.com/send?phone=6282385585576&text=Hello%2C+DIK+Group&#33+I&#39d+like+to+ask+about+the+service&#46">+62 823-8558-5576 (Admin KromaFlux)</a>
                            </p>
                            <p>
                                <a class="hover-underline-animation" target="_blank" href="https://api.whatsapp.com/send?phone=6285721954543&text=Hello%2C+DIK+Group&#33+I&#39d+like+to+ask+about+the+service&#46">+62 857-2195-4543 (Nixon - Marketing)</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 md-mb50">
                    <div class="tit mb-20">
                        <h6>DIK Group</h6>
                    </div>                   
                        <p><a class="hover-underline-animation" target="_blank" href="https://drive.google.com/file/d/1nqn0juidO8ZlM2HO-e1Gj4F6FmN7IxVJ/view?usp=sharing">DiGrow (Digital Marketing)</a></p>
                        <p><a class="hover-underline-animation" target="_blank" href="page-comingsoon.php">Kromaflux (Studio Design)</a></p>
                        <p><a class="hover-underline-animation" target="_blank" href="https://drive.google.com/file/d/1UPZAjqtom5e_RObyE7-Mh6oa4ohdKrhm/view?usp=sharing">TerraTech (Technology)</a></p>
                        <p><a class="hover-underline-animation" target="_blank" href="page-comingsoon.php">DIK Product (Product Incubation)</a></p>
                </div>
                
            </div>
        </div>
        <div class="sub-footer pt-40 pb-40 bord-thin-top ontop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        
                    </div>
                    <div class="col-lg-8">
                        <div class="copyright d-flex">
                            <div class="ml-auto">
                                <p class="fz-13">© <?php echo date('Y'); ?> | PT Digital Informasi Kreatif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- ==================== End Footer ==================== -->

<?php }else{ ?>
<footer class="sub-bg" style="background-color: #00395B; color: #FEB062;">
        <div class="sub-footer pt-40 pb-40 bord-thin-top ontop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        
                    </div>
                    <div class="col-lg-8">
                        <div class="copyright d-flex">
                            <div class="ml-auto">
                                <p class="fz-13">© <?php echo date('Y'); ?> | PT Digital Informasi Kreatif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php } ?>