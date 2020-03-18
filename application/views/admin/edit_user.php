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
                            <h3 class="page-title">Admin</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">User Registration</a></li>
                                <li class="breadcrumb-item"><span>Edit User</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- PAGE ERROR -->
                <?php 
                    if($this->session->flashdata('success')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error success mb-12"><?php echo $this->session->flashdata('success');?></div>
                    </div>
                <?php 
                }
                if($this->session->flashdata('error')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error failure mb-12"><?php echo $this->session->flashdata('error');?></div>
                    </div>
                <?php 
                    }
                ?>
                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Add Role</h4>
                            <?php  
                                $attributes = array('id' => 'agentFrm','class'=>'form col','method'=>'post');
                                echo form_open_multipart('edit_user_data',$attributes);
                            ?>
                                <div class="row mb-0">
                                <div class="row mb-0">
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_01" type="text" name="user_name" id="user_name" value="<?php echo $userData[0]->name;?>">
                                        <label for="field_01" class="">Name</label>
                                    </div>
                                     <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" name="empid" id="empid" value="<?php echo $userData[0]->empid;?>" readonly>
                                        <label for="field_06" class="">Employee Id</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <select id="field_03" name="role" id="role">
                                            <option value="" disabled selected>Select</option>
                                            <?php 
                                                foreach($role as $value){

                                            ?>
                                                    <option value="<?php echo $value->id;?>" <?php if($value->id == $userData[0]->usertype) echo "selected";?>><?php echo trim($value->name);?></option>
                                            <?php    
                                            }
                                            ?>
                                        </select>
                                        <label for="field_03" class="">User Type</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_05" type="email" name="email" readonly id="email" value="<?php echo $userData[0]->user_email;?>">
                                        <label for="field_05" class="">Email</label>
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        <input id="field_06" type="text" class="datepicker" name="doj" id="doj" value="<?php echo $userData[0]->doj;?>">
                                        <label for="field_06" class="">Date of Joining</label>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $this->uri->segment(2);?>">
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" class="btn cyan waves-effect waves-light right">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                        <!-- <button type="reset" class="btn grey waves-effect waves-light right">
                                            <span>Reset</span>
                                        </button> -->
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->
                <!-- FOOTER SECTION START -->
                <footer><p class="m-0">2019 &copy; All Rights Reserved by <a href="https://www.mattsenkumar.com/" target="_blank">MattsenKumar LLC</a></p></footer>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
</html>
