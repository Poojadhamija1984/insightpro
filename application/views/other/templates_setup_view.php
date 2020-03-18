<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="setup_body">
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php //$this->load->view('common/sidebar_view') ?>
            
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents custom-flex">
                    <div class="setup-section">
                        <div class="setup-header">
                            <div class="progress-steps">
                                <div class="single_step">
                                    <span class="step-counter">1</span>
                                    <span class="step-text">Choose Form</span>
                                </div>
                                <div class="single_step">
                                    <span class="step-counter">2</span>
                                    <span class="step-text">User Management</span>
                                </div>
                                <div class="single_step">
                                    <span class="step-counter">3</span>
                                    <span class="step-text">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="setup-contents">
                            <div class="temp_cards_list center">
                                <div class="temp_card2">
                                    <a href="<?= site_url();?>/template-details/welcomesetup_create_form">
                                        <span class="right-tick"></span>
                                        <span class="form-icon"></span>
                                        <h3>Create New Form</h3>
                                    </a>
                                </div>
                                <div class="temp_card2">
                                    <a href="<?php echo site_url()?>/other-template-list/welcome_other_form">
                                        <span class="right-tick"></span>
                                        <span class="form-icon"></span>
                                        <h3>Choose Form</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="setup-footer right-align">
                            <a class="skip_btn" href="<?= site_url();?>/welcome-setup-skip/3">Skip</a>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
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
</html>