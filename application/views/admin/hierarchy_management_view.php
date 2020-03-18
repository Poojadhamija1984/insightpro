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
            <main id="main_id">
                
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Hierarchy</h3>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    
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
      
                    <div id="hierarchy_ajax">
                        <!-- FORM SECTION START -->
                        <div class="form-section mt-24">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Add Details</h4> 
                                    <!-- <form class="form col">  -->
                                    <?php $attributes = array("class" => "form col", "id" => "hierarchy_form");
                                    echo form_open("" ,$attributes);
                                    ?>
                                        <div class="row mb-0 d-flex flex-wrap">
                                            <!-- LOB  -->
                                            <div class="input-field col s12 m4 xl3">
                                                <select class="selectbox" id="lob" name="lob" onchange='Checklob(this.value);' required> 
                                                        <option  value="" >Select</option>
                                                        <?php
                                                        foreach($lob as $lob){
                                                        echo '<option value="'.$lob['lob'].'">'.$lob['lob'].'</option>';
                                                        }
                                                        ?>
                                                        <option value="add_new">Add New</option>
                                                </select>
                                                <input id="lobtxt" name="lobtxt" type="text"  style="display:none" title="special character and space not allowed">
                                                <label for="lob" >LOB <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- CAMPAIGN -->
                                            <div class="input-field col s12 m4 xl3">
                                                <select class="selectbox" id="campaign" name="campaign" onchange='Checkcampaign(this.value);'  required> 
                                                    <option value="" >Select</option>
                                                    <?php 
                                                    foreach($campaign as $campaign){
                                                        echo '<option value="'.$campaign['campaign'].'">'.$campaign['campaign'].'</option>';
                                                    }
                                                    ?>
                                                    <option value="add_new">Add New</option>
                                                </select>
                                                <input id="campaigntxt" name="campaigntxt" type="text" style="display:none">
                                                <label for="field_05" class="">Campaign <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- VENDOR -->
                                            <div class="input-field col s12 m4 xl3">
                                                <select class="selectbox" id="vendor" name="vendor" onchange='Checkvendor(this.value);' required>
                                                        <option value="" >Select</option>
                                                        <?php 
                                                        foreach($vendor as $vendor){
                                                            echo '<option value="'.$vendor['vendor'].'">'.$vendor['vendor'].'</option>';
                                                        }
                                                        ?>
                                                        <option value="add_new">Add New</option>
                                                </select>
                                                <input id="vendortxt" name="vendortxt" type="text" style="display:none"  style="display:none" title="special character and space not allowed">
                                                <label for="vendor" class="">Vendor <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- LOCATION -->
                                            <div class="input-field col s12 m4 xl3">
                                                <select class="selectbox" id="location" name="location" onchange='Checklocation(this.value);' required>
                                                        <option value="">Select</option>
                                                    <?php 
                                                    foreach($location as $location){
                                                    echo '<option value="'.$location['location'].'">'.$location['location'].'</option>';
                                                    } 
                                                    ?>
                                                        <option value="add_new">Add New</option>
                                                </select>
                                                <input id="locationtxt" name="locationtxt" type="text" style="display:none"  style="display:none" title="special character and space not allowed">
                                                <label for="location" class="">Location <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- SUBMIT BUTTON -->
                                            <div class="input-field col s12 mb-0 form_btns">
                                                <input type="hidden" name="hdn_save" value="<?php echo encode('save_hierarchy')?>">
                                                <button type="button"  class="btn cyan waves-effect waves-light right" id="btn_submit" onclick="save_hierarchy()">
                                                    <span>Submit</span>
                                                    <i class="material-icons right">send</i>
                                                </button>
                                                <button type="reset" id="reset_button" class="hide"></button>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                        <!-- FORM SECTION END -->

                        <!-- TABLE SECTION START -->
                        <div class="table-section mt-24">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h4 class="card-title m-0">Hierarchy List</h4>
                                        <div class="card-btns"></div>
                                    </div>
                                    <table class="csv_table stripe hover" style="width:100%" id="hierarchy_table">
                                        <thead>
                                            <tr>
                                                <th>LOB</th>
                                                <th>Campaign</th>
                                                <th>Vendor</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hierarchy_tbody">
                                            <?php foreach($hierarchies as $key=> $value){ ?>
                                                <tr>
                                                    <td><?php echo $value['lob'];?></td>
                                                    <td><?php echo $value['campaign'];?></td>
                                                    <td><?php echo $value['vendor'];?></td>
                                                    <td><?php echo $value['location'];?></td>
                                                    <td class="center">
                                                    <!--<a href="<?php echo $value['hierarchy_id'];?>">
                                                        <i class="material-icons">edit</i>
                                                    </a>-->
                                                        <a class="btn_del" hierarchy_id= "<?= encode($value['hierarchy_id'])?>"  href="javascript:void(0)" title="Del" onclick="delete_hierarchy($(this).attr('hierarchy_id'))"><i class="flaticon-delete-button"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- TABLE SECTION END -->
                    </div>
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        
        <!--JavaScript at end of body for optimized loading-->
       <?php $this->load->view('common/footer_file_view') ?>
       <script type="text/javascript">
           
            //LOB TEXT BOX SHOW WHEN SELECT VALUE OTHERS
            function Checklob(val) {
                if(val=='add_new'){
                    $('#lobtxt').show();
                }else{
                    $('#lobtxt').hide();
                }
            }

            //CAMPAIGN TEXT BOX SHOW WHEN SELECT OTHERS
            function Checkcampaign(val) {
                if(val=='add_new'){
                    $('#campaigntxt').show();
                } else {
                    $('#campaigntxt').hide();
                }
            }

            //VENDOR TXT BOX SHOW WHEN SELECT OTHERS
            function Checkvendor(val) {
                if(val == 'add_new'){
                    $('#vendortxt').show();
                } else {
                    $('#vendortxt').hide();
                }
            }

            //LOCATION TXT BOX SHOW WHEN SELECT OTHERS
            function Checklocation(val) {
                if(val == 'add_new'){
                    $('#locationtxt').show();
                } else {
                    $('#locationtxt').hide();
                }
            }
            
            //SAVE HIERARCHY FROM AJAX
            function save_hierarchy() {
                var base_url = BASEURL+'/hierarchy';
                var data = $('#hierarchy_form').serialize();
                var response = saveAjax(base_url,data);
                
                if(response.status == 'success') {
                    $('#success_section').removeClass('hide');
                    $('#success_msg').text(response.message);
                    
                    $("#reset_button").click();
                    
                    //REFRESH THE PAGE WITHOUT RELOADING
                    var base_url = BASEURL+'/get-hierarchy';
                    $.ajax({url: base_url, success: function(result){
                        $("#hierarchy_ajax").html(result);
                    }});
                    
                } else {
                    $('#failure_section').removeClass('hide');
                    $('#failure_msg').html(response.message);
                }
            }
            
            //DELETE HIERARCHY FROM AJAX
            function delete_hierarchy(hierarchyId) {
                var message = "Delete Hierarchy | Are you sure want to delete ?";
                var url = BASEURL+"/delete-hierarchy";
                var response = deleteAjax(message, url, hierarchyId);
                
                if(response.status == 'success') {
                    $('#success_section').removeClass('hide');
                    $('#success_msg').text(response.message);

                    //REFRESH THE PAGE WITHOUT RELOADING
                    var base_url = BASEURL+'/get-hierarchy';
                    $.ajax({url: base_url, success: function(result){
                        $("#hierarchy_ajax").html(result);
                    }});

                } else {
                    $('#failure_section').removeClass('hide');
                    $('#failure_msg').html(response.message);
                }
            }
       </script>
    </body>
</html>