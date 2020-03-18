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
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Alert</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Alert  Summary</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                     <!-- PAGE ERROR START -->
                    <?php if($this->session->flashdata('message')){ ?>
                        <div class="error_section">
                            <div class="page_error success mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')){ ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- PAGE ERROR END -->
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Add Details</h4> 
                                <!-- <form class="form col">  -->
                                <?php $attributes = array("class" => "form col");
                                echo form_open("" ,$attributes);
                                ?>
                                
                                    <div class="row mb-0 d-flex flex-wrap">
                                        <!-- LOB  -->
                                        <div class="input-field col s12 m4 xl3">
                                            <input id="alert_name" name="alert_name" type="text" value="<?=(!empty($editData[0]->alert_name) ? $editData[0]->alert_name :' ')?>">
                                            <label for="lob" class="">Alert Name</label>
                                            
                                        </div>

                                        <div class="input-field col s12 m4 xl3">
                                            <select id="alert_type" name="alert_type"  required> 
                                                <option value="" >Select</option>
                                                <?php 
                                                 $alertType = getAlertType();
                                                 $selected = ''; 
                                                foreach($alertType as $k =>$value){
                                                 if($id){
                                                 ($editData[0]->alert_type == $k ? $selected='selected' :  $selected='');   
                                                    }
                                                    echo '<option '.$selected.' value="'.$k.'">'.$value.'</option>';
                                                }

                                                ?>
                                            </select>
                                           
                                            <label for="alert_type" class="">Alert Type</label>
                                        </div>
                                        <!--vendor-->
                                        <div class="input-field col s12 m4 xl3">
                                            <select id="lob" name="lob" required>
                                                    <option value="" >Select</option>
                                                    <?php 
                                                    foreach($lob as $lobs){
                                                  if($id){
                                                  ($editData[0]->lob == $lobs['lob'] ? $selected='selected' :  $selected='');   
                                                    }
                                                        echo '<option '.$selected.' value="'.$lobs['lob'].'">'.$lobs['lob'].'</option>';
                                                    }
                                                    ?>
                                                   
                                            </select>
                                            <label for="lob" class="">Lob</label>
                                        </div>
                                        <!--members-->
                                        <div class="input-field col s12 m4 xl3">
                                            <select  id="members" name="members[]" multiple required> 	
                                             
                                              <?php
                                              if($id){
                                              	$selected = '';
                                              	foreach ($lobdata as $key => $values) {
                                              	$members = explode(',', $editData[0]->members);	
                                              	if(in_array($values->user_email, $members)){
                                              		$selected = 'selected';
                                              	} else {
                                                    $selected = '';
                                                }
                                                echo '<option '.$selected.' value="'.$values->user_email.'">'.$values->name.'</option>';
                                                }
                                              } else {
                                              	echo '<option value="" disabled="">Select</option>';
                                              }
                                                
                                              ?>
                                            </select>
                                            <label for="members" class="">Members</label>
                                        </div>

                                        <div class="input-field col s12 m8 l9" >
                                            <textarea name="msg_template" class="materialize-textarea"  placeholder="Write your Message"><?=(!empty($editData[0]->msg_template) ? $editData[0]->msg_template :' ')?></textarea>
                                            <label for="msg_template">Message Template</label>
                                        </div>
                                        

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
                    <!-- TABLE SECTION START -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title m-0">Alert List</h4>
                                    <div class="card-btns"></div>
                                </div>
                                <table class="csv_table stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Alert Name</th>
                                            <th>Alert Type</th>
                                            <th>Lob</th>
                                            <th>Status</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($allData as $key=> $value){ 
                                        ?>
                                                <tr>
                                                    <td><?php echo $value['alert_name'];?></td>
                                                    <td><?php echo $value['alert_type'];?></td>
                                                    <td><?php echo $value['lob'];?></td>
                                                    <td><button class="action_btn custom_switch switch <?=($value['status'] == 1) ? 'active' : ''?>" data-form-id="<?=$value['id']?>" data-form-status="<?=$value['status']?>"><span class="lever"></span></button></td>
                                                    <td>
                                                     <a  class="btn_common"  href="<?=site_url()?>/alert/index/<?php echo $value['id'];?>">EDIT</a>
                                                    </td>
                                                </tr>
                                        <?php 
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->                      
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
           $(function(){
                $('#form_type').change(function(){
                    var response = postAjax('<?php echo site_url();?>/form_type',{'type':$('#form_type').val()});
                })
           });
       </script>
    </body>
</html>


<script>
 $(document).ready(function(){   
 $('#lob').change(function(){
            //$('#form_name,#form_version').html($("<option></option>").attr("value","").text('Select')).formSelect();
            var lob = $(this).val();
            //var lobtxt = $("#lob option:selected").text();  
            var ajaxRes = postAjax('<?php echo site_url();?>/alert/get_members',{'lob':lob});
          // console.log(ajaxRes.data[2].name);

            $('#members').empty();
            $('#members').append($("<option disabled></option>").attr("value",'').text('Select')); 
            $.each(ajaxRes.data, function( key, value ) {
            	// console.log(value.name);
                $('#members').append($("<option></option>").attr("value",value.user_email).text(value.name)).formSelect();
             });
            //console.log(ajaxRes);
        });	


  $('.action_btn').click(function(){
        var base_url = "<?php echo site_url();?>";
        var id = $(this).attr('data-form-id');
        var status = $(this).attr('data-form-status');
        if(status ==1)
        {
            status = 0;
        }
        else
        {
            status = 1;
        }

        /// postAjax() this function is define in custom.js is use for ajax post request
        var ajaxRes = postAjax('<?php echo site_url();?>/alert/change_status',{'id':id,'status':status});
        
    
    });
 });
</script>