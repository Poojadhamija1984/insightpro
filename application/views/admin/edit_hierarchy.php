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
                            <h3 class="page-title">Hierarchy Management</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item"><span>Hierarchy Management</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Edit Information</h4> 
                              <?=$this->session->flashdata('msg');?>
                              
                          <!-- <form class="form col">  -->
                            <?php 
                                $attributes = array("class" => "form col");
                                echo form_open("update-hierarchy" ,$attributes);
                            ?>
                             
                                <div class="row mb-0 d-flex flex-wrap">
                                    <!-- LOB  -->
                                    <div class="input-field col l3 m6 s12">
                                        <select id="lob" name="lob" onchange='Checklob(this.value);' required> 
                                            <option  value="" >Select</option>
                                            <?php
                                                foreach($lob as $lob){
                                                    if($hierarchy[0]->lob == $lob['lob']){
                                                        $sel = "selected";
                                                    }else{
                                                        $sel = '';
                                                    }
                                                    echo '<option value="'.$lob['lob'].'" '.$sel.'>'.$lob['lob'].'</option>';
                                                    }
                                            ?>
                                        </select>
                                        <label for="lob" class="">LOB</label>
                                        <?=form_error('lob'); ?>                                        
                                    </div>

                                    <!-- Campaign -->
                                    <div class="input-field col l3 m6 s12">
                                        <select id="campaign" name="campaign" onchange='Checkcampaign(this.value);'  required> 
                                            <option value="" >Select</option>
                                            <?php 
                                                foreach($campaign as $campaign){
                                                    if($hierarchy[0]->campaign == $campaign['campaign']){
                                                        $sel = "selected";
                                                    }else{
                                                        $sel = '';
                                                    }
                                                    echo '<option value="'.$campaign['campaign'].'" '.$sel.'>'.$campaign['campaign'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        <label for="campaign" class="">Campaign</label>
                                    </div>
                                    <!--vendor-->
                                    <div class="input-field col l3 m6 s12">
                                        <select id="vendor" name="vendor" onchange='Checkvendor(this.value);' required>
                                            <option value="" >Select</option>
                                            <?php 
                                                foreach($vendor as $vendor){
                                                    if($hierarchy[0]->vendor == $vendor['vendor']){
                                                        $sel = "selected";
                                                    }else{
                                                        $sel = '';
                                                    }
                                                    echo '<option value="'.$vendor['vendor'].'" '.$sel.'>'.$vendor['vendor'].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <label for="vendor" class="">Vendor</label>
                                    </div>
                                    <input type="hidden" name="h_id" value="<?php echo $id;?>">
                                    <!--location-->
                                    <div class="input-field col l3 m6 s12">
                                        <select id="location" name="location" onchange='Checklocation(this.value);' required>
                                            <option value="">Select</option>
                                            <?php 
                                                foreach($location as $location){
                                                    if($hierarchy[0]->location == $location['location']){
                                                        $sel = "selected";
                                                    }else{
                                                        $sel = '';
                                                    }
                                                    echo '<option value="'.$location['location'].'" '.$sel.'>'.$location['location'].'</option>';
                                                } 
                                            ?>
                                        </select>
                                        <label for="location" class="">Location</label>
                                    </div>
                                    <!-- Form type -->
                                    <!-- <div class="input-field col l4 m6 s12">
                                        <select id="form_type" name="form_type" required> 
                                            <option value="">Select</option>
                                            <option value="1">Call</option>
                                            <option value="2">Mail</option>
                                        </select>
                                        <label for="form_type" class="">Form Type</label>
                                    </div> -->


                                     <!-- Form Name -->
                                    <!-- <div class="input-field col l4 m6 s12">
                                        <select id="form_name" name="form_name" required > 
                                            <option value="">Select</option>
                                        </select>
                                        <label for="form_name" class="">Form Name</label>
                                    </div> -->

                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit"  class="btn cyan waves-effect waves-light right">
                                            <span>Submit</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->

               

               <!-- FOOTER SECTION START -->
               <?php $this->load->view('common/footer_view')  ?>
               <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
       <?php $this->load->view('common/footer_file_view') ?>
       <script type="text/javascript">
           $(function(){
                // $('#form_type').change(function(){
                //     var response = postAjax('<?php echo site_url();?>/form_type',{'type':$('#form_type').val()});
                // })
           });

       </script>
    </body>
</html>