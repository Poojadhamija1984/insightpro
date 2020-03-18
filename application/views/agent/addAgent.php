<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php $this->load->view('common/sidebar_view') ?>
            <main>
                <!-- BREADCRUMB SECTION START -->
                <?php
                    if($this->uri->segment_array()[1] == 'edit_agent'){
                        $e = "Edit";
                ?>
                        <div class="breadcrumb-section p-24">
                            <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                                <div class="breadcrumb-left">
                                    <h3 class="page-title">Edit Agent</h3>
                                    <ul class="breadcrumb-list">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item"><span>Agents</span></li>
                                        <li class="breadcrumb-item"><span>Edit Agent</span></li>
                                    </ul>
                                </div>
                                <div class="breadcrumb-right"></div>
                            </div>
                        </div>
                <?php
                    }else{
                        $e = "Add";
                ?>
                        <div class="breadcrumb-section p-24">
                            <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                                <div class="breadcrumb-left">
                                    <h3 class="page-title">Add Agent</h3>
                                    <ul class="breadcrumb-list">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item"><span>Agents</span></li>
                                        <li class="breadcrumb-item"><span>Add Agent</span></li>
                                    </ul>
                                </div>
                                <div class="breadcrumb-right"></div>
                            </div>
                        </div>
                <?php
                    }
                ?>
                <!-- BREADCRUMB SECTION END -->
                <?php 
                    if($this->session->flashdata('message')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }   
                ?>
                <?php 
                    if($this->session->flashdata('error')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error failure mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                    if(validation_errors()){
                        ?>
                        <div class="alert alert-info text-center">
                            // <?php //echo validation_errors('agent_id'); ?>
                        </div>
                        <?php
                    }
                ?>
                <?php
                    if($e == "Edit" && count($agent_data) == 0){
                ?>
                    <div class="form-section px-24 mb-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Agent Id Is Invalid</h4>
                            </div>
                        </div>
                    </div>

                <?php                
                }
                else{    
                ?>

                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title"><?php echo $e;?> Agent Information</h4>
                            <?php  $attributes = array('id' => 'agentFrm', 'class' => 'col');echo form_open_multipart('addAgent',$attributes);?>
                                <div class="row mb-0 d-flex flex-wrap">
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_01" type="text" name="agent_id" value="<?php echo (!empty($agent_data->agent_id)?$agent_data->agent_id:''); ?>" <?php echo (($e=="Edit")?'readonly':'');?>>
                                        <label for="field_01" class="">Agent ID</label>
                                        <span class="field_error agent_id"><?php  echo (!empty($this->session->flashdata('agent_id'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_02" type="text" name="agent_name" value="<?php echo (!empty($agent_data->agent_name)?$agent_data->agent_name:''); ?>">
                                        <label for="field_02" class="">Agent Name</label>
                                        <span class="field_error agent_name"><?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    <?php /*
                                    <div class="input-field col l3 m6 s12">
                                        <select id="field_03" name="campaign">
                                            <option value="" selected="selected" disabled>Select</option>
                                            <?php 
                                                foreach ($client_hierarchy as $key => $value) {
                                                    if($value['campaign'] == (!empty($agent_data->companion)?$agent_data->companion:''))
                                                        $selected = 'selected';
                                                    echo "<option value=".$value['campaign']." ".(!empty($selected)?$selected:'').">".$value['campaign']."</option>";
                                                }
                                            ?>                                           
                                        </select>
                                        <label for="field_03" class="">Campaign</label>
                                        <span class="field_error campaign">
                                            <?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?>
                                            </span>
                                    </div>
                                    */?>
                                    <div class="input-field col l3 m6 s12">
                                        <select id="field_04" name="lob">
                                            <option value="" selected="selected" disabled>Select</option>
                                            <?php 
                                                foreach ($client_hierarchy as $key => $value) {
                                                    if($value['lob'] == (!empty($agent_data->lob)?$agent_data->lob:''))
                                                        $selected = 'selected';
                                                    echo "<option value=".$value['lob']." ".(!empty($selected)?$selected:'').">".$value['lob']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="field_04" class="">LOB</label>
                                        <span class="field_error lob"><?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    <?php /*
                                    <div class="input-field col l3 m6 s12">
                                        <select id="field_05" name="vendor">
                                            <option value="" selected="selected" disabled>Select</option>
                                            <?php 
                                                foreach ($client_hierarchy as $key => $value) {
                                                    if($value['vendor'] == (!empty($agent_data->vendor)?$agent_data->vendor:''))
                                                        $selected = 'selected';
                                                    echo "<option value=".$value['vendor']." ".(!empty($selected)?$selected:'').">".$value['vendor']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="field_05" class="">Vendor</label>
                                        <span class="field_error vendor"><?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    */ ?>
                                    <div class="input-field col l3 m6 s12">
                                        <select id="field_06" name="location">
                                            <option value="" selected="selected" disabled>Select</option>
                                             <?php 
                                                foreach ($client_hierarchy as $key => $value) {
                                                    if($value['location'] == (!empty($agent_data->location)?$agent_data->location:''))
                                                        $selected = 'selected';
                                                    echo "<option value=".$value['location']." ".(!empty($selected)?$selected:'').">".ucfirst($value['location'])."</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="field_06" class="">Location</label>
                                        <span class="field_error location"><?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_07" type="text" class="datepicker" name="agent_doj" value="<?php echo (!empty($agent_data->agent_name)?$agent_data->doj:''); ?>">
                                        <label for="field_07" class="">Agent DOJ</label>
                                        <span class="field_error agent_doj"><?php  echo (!empty($this->session->flashdata('agent_name'))?$this->session->flashdata('agent_id'):''); ?></span>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_08" type="text" name="supervisor" id="supervisor" value="<?php echo (!empty($agent_data->first_level_reporting)?$agent_data->first_level_reporting:''); ?>">
                                        <label for="field_08" class="">Supervisor</label>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_09" type="text" name="supervisor_id" id="supervisor_id" value="<?php echo (!empty($agent_data->first_level_reporting_id)?$agent_data->first_level_reporting_id:''); ?>">
                                        <label for="field_09" class="">Supervisor ID</label>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_10" type="text" name="manager" id="Manager" value="<?php echo (!empty($agent_data->first_level_reporting)?$agent_data->first_level_reporting:''); ?>"> 
                                        <label for="field_10" class="">Manager</label>
                                    </div>
                                    <div class="input-field col l3 m6 s12">
                                        <input id="field_11" type="text" name="manager_id" id="manager_id" value="<?php echo (!empty($agent_data->second_level_reporting_id)?$agent_data->second_level_reporting_id:''); ?>">
                                        <label for="field_11" class="">Manager ID</label>
                                    </div>
                                    
                                    <div class="input-field col l3 m6 s12">
                                        <select id="field_12" name="agent_status" id="agent_status">
                                            <option value="active" <?php echo (!empty($agent_data->agent_status) && $agent_data->agent_status == "1"?'selected':'') ?>>Active</option>
                                            <option value="inactive" <?php echo (!empty($agent_data->agent_status) && $agent_data->agent_status == "0"?'selected':'') ?>>Inactive</option>
                                        </select>
                                        <label for="field_12" class="">Status</label>
                                    </div>
                                    <input type="hidden" name="agent_invalid_status" value="<?php echo (isset($agent_data->agent_valid) ? $agent_data->agent_valid : '1'); ?>" >
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" id="agentBtn" class="btn cyan waves-effect waves-light right">
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
                <?php 
                    }
                ?>
            </main>
            <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
        <script type="text/javascript">
            $(function(){
                $('#agentBtn').click(function(e){
                    e.preventDefault();
                    if($('#field_01').val()== ""){
                        $('.agent_id').html('Please Enter Agent ID')
                        return false;
                    }
                    else if($('#field_02').val()== ""){
                        $('.agent_name').html('Please Enter Agent Name');
                        return false;
                    }
                    else if($('#field_03').val()== null){
                        $('.campaign').html('Please Select Campaign')
                        return false;
                    }
                    else if($('#field_04').val()== null){
                        $('.lob').html('Please Select lob')
                        return false;
                    }
                    else if($('#field_05').val()== null){
                        $('.vendor').html('Please Select Vendor')
                        return false;
                    }
                    else if($('#field_06').val()== null){
                        $('.location').html('Please Select Location')
                        return false;
                    }
                    else if($('#field_07').val()== ""){
                        $('.agent_doj').html('Please Enter Agent DOJ')
                        return false;
                    }
                    else{
                        $('#agentFrm').submit();
                    }

                })
            })
        </script>
    </body>
</html>