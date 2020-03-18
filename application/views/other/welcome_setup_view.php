<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="setup_body">
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php //$this->load->view('common/sidebar_view') ?>
            
            <!-- <main class="welcome-setup"> -->
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <div class="setup-section">
                        <div class="account-setup d-flex flex-wrap align-items-center justify-content-between">
                            <div class="account-setup-text">
                                <h2>Welcome to <span class="logo-text">Insights<span>PRO</span></span></h2>
                                <p class="m-0">We bring in quality improvement expertise of more than 13 years working across industries with organizations from around the globe.</p>
                                <a class="setup_link" href="<?= site_url();?>/welcome-setup/templates">Start Account Setup</a>
                            </div>
                            <div class="account-setup-img">
                                <img src="<?=base_url()?>assets/images/welcome_page_img2.png" alt="anc">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="setup-section second d-flex flex-wrap align-items-center">
                        <div class="account-setup-text">
                            <h2>Welcome to <span class="logo-text">Insights<span>PRO</span></span></h2>
                            <p class="m-0">We bring in quality improvement expertise of more than 13 years working across industries with organizations from around the globe.</p>
                            <a class="setup_link" href="<?= site_url();?>/welcome-setup/templates">Start Account Setup</a>
                        </div>
                    </div> -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
                <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDPIDt4IcQXSQAhS-dyux-3ZNO4Lzx8H5E&libraries=places&callback=initAutocomplete" async defer></script> -->

    <script type="text/javascript">
        
    </script>
</html>