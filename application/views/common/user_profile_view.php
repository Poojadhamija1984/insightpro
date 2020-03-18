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
                            <h3 class="page-title">Profile</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><span>Profile Summary</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->
                
                <!-- USER PROFILE SECTION START -->
                <div class="profile-section px-24 mb-24 col">
                    
                    <!-- PAGE ERROR START -->
                    <div class="hide" id="success_section">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center" id="success_msg"></div>
                        </div>
                    </div>
                    <div class="hide" id="failure_section">
                        <div class="page_error failure mb-12">
                            <div class="alert alert-info text-center" id="failure_msg">
                            </div>
                        </div>
                    </div>
                    <!-- PAGE ERROR END -->
                    
                    <div class="profile-card card">
                        <div class="card-top d-flex">
                            <div class="card-left profile_img">
                                <img class="profile_pic" src="<?php echo isset($this->session->userdata['profile_img'])?base_url().$this->session->userdata['profile_img']:base_url().'assets/images/profile_pic.jpg';?>" alt="profile pic">
                            </div>
                            <div class="card-right">
                                <h3 class="profile_name"><?php echo isset($this->session->userdata['name'])?$this->session->userdata['name']:'';?></h3>
                                <h4 class="profile_desig"><i class="material-icons prefix">work</i> <span><?php echo get_user_type($this->session->userdata('usertype'), $this->session->userdata('emp_group'));?>
                                </span></h4>
                                <div class="change_pic">
                                    <?php
                                    $attributes = array("id" => "uploadform");
                                    echo form_open_multipart(site_url().'/profile-image-change', $attributes);
                                    ?>
                                        <div class="row mb-0">
                                            <div class="file-field input-field col m8 l6 s12">
                                                <div class="btn">
                                                    <input type="file" name="profile_img" accept="image/*">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text">
                                                </div>
                                            </div>
                                            <div class="input-field col m4 l6 s12 form_btns">
                                                <button type="button" name="upload_btn" class="btn cyan waves-effect waves-light" onclick="change_profilePic()">Upload Photo</button>
                                                <button type="reset" id="reset_button_pic" class="hide"></button>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-btm d-flex">
                            <div class="card-left profile-details gradient-135deg-purple-deep-orange">
                                <p>User ID <span><?php echo isset($this->session->userdata['empid'])?$this->session->userdata['empid']:'--- -- ----';?></span></p>
                                <p>User Email <span title="<?php echo isset($this->session->userdata['user_email'])?$this->session->userdata['user_email']:'';?>"><?php echo isset($this->session->userdata['user_email'])?$this->session->userdata['user_email']:'';?></span></p>
                                <p>User DOJ <span><?php echo isset($this->session->userdata['doj'])?date('d-F-Y',strtotime($this->session->userdata['doj'])):'-- -- ----';?></span></p>
                                <?php
                                    if($this->industry_type != "bpo"){
                                        $user_group = "'".$this->session->userdata('u_group')."'";
                                        $user_site = "'".$this->session->userdata('site')."'";
                                        $sql = "SELECT GROUP_CONCAT(DISTINCT g_name ) as g FROM `groups` WHERE find_in_set(g_id,$user_group)";
                                        $day_wise_query = $this->db->query($sql);
                                        $groups = $day_wise_query->result();
                                        $g = $groups[0]->g;
                                        if(!empty($g))
                                            echo "<p>Group <span>$g</span></p>";

                                        $site_sql = "SELECT GROUP_CONCAT(DISTINCT s_name ) as s FROM `sites` WHERE find_in_set(s_id,$user_site)";
                                        $day_wise_query = $this->db->query($site_sql);
                                        $groups = $day_wise_query->result();
                                        $s = $groups[0]->s;
                                        if(!empty($s))
                                            echo "<p>Site <span>$s</span></p>";
                                    }
                                ?>
                            </div>
                            
                            <div class="card-right">
                                <div class="change_pwd">
                                    <h5>Change Password</h5>
                                    <?php
                                        $attributes = array('method'=>'POST', 'id'=>'pwd_frm');
                                        echo form_open(site_url().'/change-password', $attributes);    
                                    ?>
                                        <div class="input-field">
                                            <input id="cur_pass" name="cur_pass" type="password">
                                            <label for="cur_pass">Current Password</label>
                                        </div>
                                        <div class="input-field">
                                            <input id="new_pass" name="new_pass" type="password">
                                            <label for="new_pass">New Password</label>
                                        </div>
                                        <div class="input-field">
                                            <input id="cnf_pass" name="cnf_pass" type="password">
                                            <label for="cnf_pass">Confirm New Password</label>
                                        </div>
                                        <div class="input-field form_btns">
                                            <button type="button" class="btn cyan waves-effect waves-light ml-0" onclick="change_password()"> Change Password</button>
                                            <button type="reset" id="reset_button" class="hide"></button>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
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
            //CHANGE PASSWORD
            function change_password() {
                var data = $('#pwd_frm').serialize();
                var response = saveAjax(BASEURL+'/change-password',data);
                
                if(response.status == 'success') {
                    $('#success_section').removeClass('hide');
                    $('#success_msg').text(response.message);
                    $("#reset_button").click();
                } else {
                    $('#failure_section').removeClass('hide');
                    $('#failure_msg').html(response.message);
                }
            }
            
            //CHANGE PROFILE PIC
            function change_profilePic() {
                var form = $('#uploadform')[0];
                var data = new FormData(form);
                var response = postAjaxFileUpload(BASEURL+'/profile-image-change',data);
                
                if(response.status == 'success') {
                    $('#success_section').removeClass('hide');
                    $('#success_msg').text(response.message);
                    $('.profile_pic').attr('src',response.image);
                    $("#reset_button_pic").click();
                } else {
                    $('#failure_section').removeClass('hide');
                    $('#failure_msg').html(response.message);
                }
            }
        </script>
    </body>
</html>
