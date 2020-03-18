<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php $this->load->view('common/sidebar_view') ?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>                
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Team</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item"><span>Permission</span></li>
                                <li class="breadcrumb-item"><span>Not Authorized</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h2>Sorry you don't have to access this page</h2>
                        </div>
                    </div>
                </div>
                    <!-- TABLE SECTION START -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
</html>