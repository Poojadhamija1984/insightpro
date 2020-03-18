<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="setup_body">
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php //$this->load->view('common/sidebar_view') ?>
            
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <div class="setup-section">
                        <div class="account-setup d-flex flex-wrap align-items-center justify-content-center">
                            <div class="center">
                                <h2>Account setup successfully</h2>
                                <a class="setup_link" href="<?= site_url();?>/user-management">Go to Dashboard</a>
                            </div>
                        </div>
                    </div>
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