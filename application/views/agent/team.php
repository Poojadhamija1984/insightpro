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
                                <h3 class="page-title">User Management</h3>
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
                    
                    <div id="team_ajax">
                        <!-- FORM SECTION START -->
                        <div class="form-section mt-24">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title">Add User</h4>
                                    <?php  
                                    $attributes = array('id' => 'agentFrm', 'class' => 'col');
                                    echo form_open('add-team',$attributes);
                                    ?>
                                        <div class="row mb-0">
                                            <!-- USER GROUP -->
                                            <div class="field-section col s12 m6 l4">
                                                <h5 class="field-heading">User Group <span class="mandatory">*</span></h5>
                                                <div class="radio_cont">
                                                    <label>
                                                        <input name="user_group" type="radio" value="ops"  class="with-gap userGroup_class"/>
                                                        <span>Operation</span>
                                                    </label>
                                                    <label>
                                                        <input name="user_group" type="radio" value="client" class="with-gap userGroup_class"/>
                                                        <span>Client</span>
                                                    </label>  
                                                </div>
                                            </div>

                                            <!-- USER TYPE -->
                                            <div class="field-section col s12 m6 l4">
                                                <h5 class="field-heading">User Type <span class="mandatory">*</span></h5>
                                                <div class="radio_cont">
                                                    <label>
                                                        <input name="user_type" type="radio" value="supervisor" class="with-gap userType_class"/>
                                                        <span>Supervisor</span>
                                                    </label>
                                                    <label>
                                                        <input name="user_type" type="radio" value="agent" class="with-gap userType_class" />
                                                        <span>Agent</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- LOB -->
                                            <div class="col m4 l4 input-field">
                                                <div class="custom_input_field hide" id="agent_lob_client">
                                                    <select name="lob[]" id="client_lob">
                                                        <option value="" selected disabled>Choose your option</option>
                                                        <?php echo $lob;?>
                                                    </select>  
                                                    <label for="client_lob">Select LOB</label>
                                                </div>
                                                <div class="custom_input_field" id="ops_lob_client">
                                                    <select name="lob[]" multiple id="ops_lob" class="selectbox">
                                                        <option value="" selected disabled>Choose your option</option>
                                                        <?php echo $lob;?>
                                                    </select>
                                                    <label for="ops_lob">Select LOB <span class="mandatory">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col s12 hide" id="lob_data"></div>

                                            <!-- SUPERVISOR ID -->
                                            <div class="col m4 l3 input-field hide" id="supData">
                                                <select id="supervisor_id" name="supervisor_id">
                                                    <option value="" disabled>Supervisor</option>
                                                </select> 
                                                <label for="supervisor_id">Supervisor <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- SUPERVISOR NAME -->
                                            <div class="col m4 l3 sup_detail_data input-field hide">
                                                <input id="supervisor_name" type="text" name="supervisor_name" readonly>
                                                <label for="supervisor_name">Supervisor Name <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- SUPERVISOR EMAIL -->
                                            <div class="col m4 l3 sup_detail_data input-field hide">
                                                <input id="supervisor_email" type="text" name="supervisor_email" readonly>
                                                <label for="supervisor_email">Supervisor Email <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- USERNAME -->
                                            <div class="col m4 l3  input-field">
                                                <input id="user_name" type="text" name="user_name">
                                                <label for="user_name">User Name <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- USERID -->
                                            <div class="col m4 l3  input-field">
                                                <input id="user_id" type="text" name="user_id">
                                                <label for="user_id">User ID <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- USER EMAIL -->
                                            <div class="col m4 l3  input-field">
                                                <input id="user_email" type="text" name="user_email">
                                                <label for="user_email">User Email <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- USER DOJ -->
                                            <div class="col m4 l3  input-field">
                                                <input id="user_doj" type="text" class="datepicker" name="user_doj">
                                                <label for="user_doj">User DOJ <span class="mandatory">*</span></label>
                                            </div>

                                            <!-- SUBMIT BUTTON -->
                                            <div class="col s12 mb-0 form_btns">
                                                <button type="button" id="agentBtn" class="btn cyan waves-effect waves-light right"  onclick="add_user()">
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
                                    <div class="card-header">
                                        <h4 class="card-title m-0">User Information</h4>
                                    </div>
                                    <table class="data_table stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Unique ID</th>
                                                <th>Name</th>
                                                <th>LOB</th>
                                                <th>User Group</th>
                                                <th>User Type</th>
                                                <th class="center">User Status</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(!empty($team)){
                                                    foreach ($team as $key => $value) {
                                            ?>
                                                        <tr>
                                                            <td><a class="form-data waves-effect waves-light modal-trigger" id="<?php echo implode(',',explode('|||',$value->lob));?>" href="#modal1"><?php echo $value->empid; ?></a></td>
                                                            <td><?php echo $value->name; ?></td>
                                                            <td><?php echo ltrim(implode(', ',explode('|||',$value->lob)),', ');?></td>
                                                            <td><?php echo (($value->is_admin == 2)?'Ops':'Client');?></td>
                                                            <td><?php echo (($value->usertype == 2)?'Agent':'Supervisor');?></td>
                                                            <td class="center">    
                                                                <?php if($value->status == 1){?>
                                                                    <button class="custom_switch switch active agentStatus" value="1" agent="<?php echo $value->user_id;?>">
                                                                        <span class="lever"></span>
                                                                    </button>
                                                                <?php } else{?>
                                                                        <button class="custom_switch switch agentStatus" value="0" agent="<?php echo $value->user_id;?>">
                                                                        <span class="lever"></span>
                                                                    </button>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="center">
                                                                <a class="user-view modal-trigger" id="<?php echo encode($value->user_id);?>" href="#view_modal">
                                                                    <i class="material-icons">View</i>
                                                                </a>
                                                                
                                                                <a class="user-edit modal-trigger" id="<?php echo encode($value->user_id);?>" href="#edit_modal">
                                                                    <i class="material-icons">edit</i>
                                                                </a>                                                
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- TABLE SECTION END -->

                        <!-- FORM LIST MODAL START -->
                        <div id="modal1" class="modal modal-fixed-footer">
                            <div class="modal-content">
                                <h4>From Details</h4> 
                                <hr/>
                                <table class="stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Version</th>
                                            <th>Lob</th>
                                            <th>Channels</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="form_data"></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- FORM LIST MODAL END -->
                        
                        <!-- USER DETAILS MODAL START -->
                        <div id="view_modal" class="modal modal-fixed-footer">
                            <div class="modal-content">
                                <h4>User Details</h4> 
                                <hr/>
                                <table class="stripe hover" style="width:100%">
                                    <tbody id="user_data"></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- USER DETAILS MODAL END -->
                        
                        <!-- EDIT MODAL START -->
                        <div id="edit_modal" class="modal modal-large modal-fixed-footer">
                            <div class="modal-content">
                                <h4>Edit User</h4> 
                                <hr/>
                                <div id="edit_data"></div>
                            </div>
                        </div>
                        <!-- EDIT MODAL END -->
                    </div>
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
        <script type="text/javascript">
            $(function(){
                
                //USER TYPE (SUPERVISOR/AGENT) CLICK EVENT
                $(document).on('click', '.userType_class', function() {
                    var userGroup = $("input[name='user_group']:checked").val();
                    var userType = $(this).val();
                    
                    //SHOW ERROR MESSAGE WHEN USER GROUP NOT SELECTED
                    if (userGroup === undefined) {
                        alertBox('Please select User Group first.');
                        return false;
                    }
                    
                    //CHECK SUPERVISOR IS CREATED OR NOT
                    if(userType == "agent"){
                        var res = postAjax('<?php echo site_url();?>/isSupervisor');
                        if(res < 1){
                            $("input[name='user_type']").prop('checked',false);
                            alertBox('Please first create Supervisor');
                            return false;
                        }
                    }
                    
                    //SHOW & HIDE SUPERVISOR DROPDOWN
                    $('#supervisor_id').html('<option value="">Select Supervisor</option>').formSelect();
                    if(userGroup == "client" && userType == "agent"){
                        $('#ops_lob_client').addClass('hide');
                        $('#agent_lob_client').removeClass('hide');
                        //$('#client_lob').prepend('<option value="" selected>Choose your option</option>').formSelect();
                        $('#ops_lob').val('');
                        $('#ops_lob').prop('selectedIndex', 0);
                        $('#ops_lob').formSelect();
                    }
                    else{
                        $('#ops_lob_client').removeClass('hide');
                        $('#agent_lob_client').addClass('hide');
                        $('#client_lob').prop('selectedIndex', 0);
                        $('#client_lob').formSelect();
                    }
                    
                    //GETTING THE LIST OF SUPERVISOR OF (OPS OR CLIENT)
                    if((userGroup == "client" || userGroup == "ops") && (userType == "agent")){
                        $.ajax({
                            url:BASEURL+'/get-supervisor/'+userGroup,
                            type:'get',
                            success:function(res){
                                $('#supervisor_id').append(res);
                                $('#supervisor_id').formSelect();
                            }
                        });
                        $('#supData').removeClass('hide');
                    }
                    else{
                        $('#supData').addClass('hide');
                        $('.sup_detail_data').addClass('hide');
                    }
                    $('#lob_data').addClass('hide');
                });
                
                //USER GROUP (OPS/CLIENT) CLICK EVENT
                $(document).on('click', '.userGroup_class', function() {
                    //RESET USER TYPE & SUPERVISOR NAME
                    $("input[name='user_type']").prop('checked',false);
                    $('#supervisor_id').html('<option>Select Supervisor</option>').formSelect();
                    
                    //HIDE SUPERVISOR NAME & ID
                    $('#supData').addClass('hide');
                    $('.sup_detail_data').addClass('hide');
                    
                    //SHOW HIDE LOB DROPDOWN
                    $('#ops_lob_client').removeClass('hide');
                    $('#agent_lob_client').addClass('hide');
        
                    $('#lob_data').addClass('hide');
                });
                
                //DESELECT FIRST OPTION OF OPS LOB
                $(document).on('change', '#ops_lob', function() {
                    $('#ops_lob option:eq(0)').prop('selected',false);
                });
                
                //ON SELECTION OF CLIENT >> AGENT >> LOB 
                //GETTING DETAILS OF HIERARCHY (VENDOR, LOCATION, CAMPAIGN)
                $(document).on('change', '#client_lob', function() {
                    var clientLob_val = $(this).val();
                    if (clientLob_val == '') {
                        $('#lob_data').addClass('hide');
                    } else {
                        $.ajax({
                            url:BASEURL+'/lob-data/'+clientLob_val,
                            type:'get',
                            success:function(res){
                                $('#lob_data').removeClass('hide');
                                $('#lob_data').html(res);
                                $('.lob_data').focus();
                            }
                        });
                    }
                });
                
                //GETTING THE DETAILS OF SUPERVISOR
                $(document).on('change', '#supervisor_id', function() {
                    var supervisorId = $(this).val();
                    if(supervisorId == '') {
                        $('.sup_detail_data').addClass('hide');
                        $('#supervisor_name').val('');
                        $('#supervisor_email').val('');
                    } else {
                        $.ajax({
                            url:BASEURL+'/get-supervisor-details/'+supervisorId,
                            type:'get',
                            success:function(res){
                                res = JSON.parse(res);
                                
                                $('.sup_detail_data').removeClass('hide');
                                $('#supervisor_name').val(res[0].employee_id);
                                $('#supervisor_email').val(res[0].supervisor_email);
                            }
                        });
                    }
                });
                
                // FORM DEATILS
                $(document).on('click', '.form-data', function () {
                    $('#form_data').html('');
                    var id = $(this).attr('id');
                    var res = postAjax(BASEURL+'/user-form-data',{'userid':id});
                    var tbl = '';
                    if(res.length > 0){
                        $.each(res, function(key,val) {
                        tbl += '<tr><td><a targrt="_blank" href="'+BASEURL+'/form-view/'+val.form_name+'/'+val.form_version+'/fill">'+val.form_name+'</a></td><td>'+val.form_version+'</td><td>'+val.lob+'</td><td>'+val.channels+'</td><td>'+val.form_status+'</td></tr>';
                        });
                    }
                    else{
                        tbl += '<tr><td colspan="5" style="text-align: center">No Data Found</td></tr>';
                    }
                    $('#form_data').html(tbl);
                });
                
                // VIEW USER
                $(document).on('click', '.user-view', function() {
                    $('#user_data').html('');
                    var id = $(this).attr('id');
                    var res = postAjax(BASEURL+'/user-details',{'userId':id});
                    $('#user_data').html(res);
                });
                
                // EDIT USER
                $(document).on('click', '.user-edit', function() {
                    var id = $(this).attr('id');
                    $.ajax({url: BASEURL+'/edit-team/'+id, success: function(result){
                        $("#edit_data").html(result);
                    }});
                });
                
                //USER STATUS ACTIVE/IN ACTIVE
                $(document).delegate('.agentStatus','click',function() {
                    var aid = $(this).attr('agent');
                    var status = $(this).val();
                    if(status ==1){
                        status = 0;
                    } else {
                        status = 1;
                    }
                    var res = postAjax('<?php echo site_url();?>/updateStatus',{'id':aid,'status':status});
                    if(status == 0){
                        $(this).attr('value',0);
                        alertBox('User ID has been deactivated!');
                    } else {
                        $(this).attr('value',1);
                        alertBox('User ID has been activated!');
                    }
                });
            });

            //Save hierarchy from Ajax
            function add_user() {
                var data = $('#agentFrm').serialize();
                var response = saveAjax(BASEURL+'/add-team',data);
                
                if(response.status == 'success') {
                    $('#success_section').removeClass('hide');
                    $('#success_msg').text(response.message);

                    $("#reset_button").click();

                    //Refresh the page without reloading 
                    $.ajax({url: BASEURL+'/team-ajax', success: function(result){
                        $("#team_ajax").html(result);
                    }});

                } else {
                    $('#failure_section').removeClass('hide');
                    $('#failure_msg').html(response.message);
                }
            }
        </script>
    </body>
</html>