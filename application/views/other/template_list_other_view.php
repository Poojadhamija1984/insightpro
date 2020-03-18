<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body   class="<?php if(!empty($welcomesetup_other_form)){echo 'setup_body';}?>">
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css"></style>
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"></style>
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php 
				if(empty($welcomesetup_other_form)){ 
                    $this->load->view('common/sidebar_view');
                    //echo "HHHHHHHHHHHH No Welcome";
                }
                // else{
                //     echo "YYYYYYYYYYYY WelcomeEEEEEEEEEE";
                // }
			?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Form</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item">Other Form</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right">
                                <?php if(!empty($welcomesetup_other_form)){ ?>
                                    <a class="back_btn2 mr-12" href="<?= site_url();?>//welcome-setup-skip/1">Back</a>
                                    <a class="skip_btn" href="<?= site_url();?>/welcome-setup-skip/3">Skip</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR START -->
                    <div class="log_msg error_section hide">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <span id='log_msg'></span>
                            </div>
                        </div>
                    </div>
                    <div class="rrr"> 
                    </div>
                    <?php if($this->session->flashdata('message') || $this->session->flashdata('success')) { ?>
                        <div class="error_section">
                            <div class="page_error success mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('message'); ?>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')) { ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- PAGE ERROR END -->
                    <!-- CARDS START -->
                    <div class="template-section mt-16">
                        <?php foreach($industry_type_template as $tkey=>$each_card) { ?>
                            <div class="templates-category">                            
                                <h3><?php echo $tkey;?></h3>
                                <div class="temp_cards_list">
                                    <?php foreach ($each_card as $key => $value) { ?>
                                        <div class="temp_card">                                     
                                            <h3><?php echo $value['template_type'];?></h3>
                                                <a href="<?php echo site_url();?>/template-edit/<?php echo $value['tmp_unique_id'];?>/selected<?php if(!empty($welcomesetup_other_form)){echo '/welcome_other_form';}?>">Select</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- CARDS END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view') ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
                    
    </body>
</html>
<script>
    $(document).ready(function(){
      
    });
</script>



 