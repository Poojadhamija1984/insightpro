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
                            <h3 class="page-title">Dashboard</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><span>User Details</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->
                <!-- PAGE ERROR -->
                <div class="error_section px-24">
                   <?php
                    if($this->session->flashdata('message')){
                        echo $this->session->flashdata('message'); 
                    }
                   ?>
                </div>
                <!-- PAGE ERROR END -->

                <!-- USER PROFILE SECTION START -->
                <div class="profile-section px-24 mb-24 col">
                    <div class="profile-card card">
                        <div class="card-top d-flex">
                            <div class="card-left profile_img">
                            	<?php 
                            	if(!empty($users->profile_img) && file_exists(base_url().$users->profile_img)){
                            	?>
                                	<img src="<?php echo isset($this->session->userdata['profile_img'])?base_url().$this->session->userdata['profile_img']:base_url().'assets/images/profile_pic.jpg';?>" alt="profile pic">
                                <?php 
                            	}
                                else{
                                ?>
                                	<div id="userprofileImage"><?php echo strtoupper(strtolower(substr($users->name, 0, 1)));?></div>
                                <?php 
                                }
                                ?>
                            </div>
                            <div class="card-right">
                                <h3 class="profile_name"><?php echo $users->name;?></h3>
                                <h4 class="profile_desig"><i class="material-icons prefix">person</i> <span><?php echo $users->is_admin;?></span></h4>
                                <h4 class="profile_desig"><i class="material-icons prefix">group</i> <span><?php echo $users->g;?></span></h4>
                                <h4 class="profile_desig"><i class="material-icons prefix">location_on</i> <span><?php echo $users->s;?></span></h4>
                                <h4 class="profile_desig"><i class="material-icons prefix">priority_high</i> <span><?php echo $users->status;?></span></h4>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- USER PROFILE SECTION END -->
                
                <!-- FOOTER SECTION START -->
                <?php $this->load->view('common/footer_view')  ?>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script>
        $(document).ready(function(){
            $('.div_analyst,.div_professional').hide();
            $('#usertype').change(function(){
                if($(this).val() == 4)
                {
                    $('.div_analyst').show();
                     $('.div_professional').hide();
                }
                else if($(this).val() == 6)
                {
                    $('.div_professional').show();
                     $('.div_analyst').hide();
                }
                else{
                    $('.div_analyst,.div_professional').hide();
                }
            });
            $('#sup_name').change(function(){
                $('#sup_id').val($(this).val());
            });

        });
        </script>
    </body>
</html>
