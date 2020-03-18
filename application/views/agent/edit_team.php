<div class="form-section mt-24">
    <?php
    $attributes = array('id' => 'editAgentFrm', 'class' => 'col');
    echo form_open('add-team', $attributes);
    ?>
        <!-- PAGE ERROR START -->
        <div class="hide" id="edit_success_section">
            <div class="page_error success mb-12">
                <div class="alert alert-info text-center" id="edit_success_msg"></div>
            </div>
        </div>
        <div class="hide" id="edit_failure_section">
            <div class="page_error failure mb-12">
                <div class="alert alert-info text-center" id="edit_failure_msg"></div>
            </div>
        </div>
        <div id="team_ajax">
        <!-- PAGE ERROR END -->
                    
            <div class="row mb-0">

                <!-- USER GROUP -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User Group</h5>
                    <span><?= ($team[0]->is_admin == 3) ? 'client' : 'ops' ?></span>
                    <input type="hidden" name="user_group" value="<?= ($team[0]->is_admin == 3) ? 'client' : 'ops' ?>">
                </div>

                <!-- USER TYPE -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User Type</h5>
                    <span><?= ($team[0]->usertype == 3) ? 'supervisor' : 'agent' ?></span>
                    <input type="hidden" name="user_type" value="<?= ($team[0]->usertype == 3) ? 'supervisor' : 'agent' ?>">
                </div>

                <!-- USER LOB -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">Select Lob</h5>
                    <?php if ($team[0]->is_admin == 3 && $team[0]->usertype == 2) { ?>
                        <span id="agent_lob_client">
                            <select name="lob[]" id="edit_client_lob" class="selectbox">
                                <option value="" disabled selected>Choose your option</option>
                                <?php
                                foreach ($all_lob as $key => $value) {
                                    $team_lob = explode('|||', $team[0]->lob);
                                    if (in_array($value->lob, $team_lob)) {
                                        $selected = 'selected readonly';
                                    } else {
                                        $selected = '';
                                    }
                                    echo "<option value='{$value->lob}' {$selected} >{$value->lob}</ooption>";
                                }
                                ?>
                            </select>  
                        </span>
                    <?php } else { ?>
                        <span id="ops_lob_client">
                            <select name="lob[]" multiple id="ops_lob" class="selectbox">
                                <option value="" disabled>Choose your option</option>
                                <?php
                                foreach ($all_lob as $key => $value) {
                                    $team_lob = explode('|||', $team[0]->lob);
                                    if (in_array($value->lob, $team_lob)) {
                                        $selected = 'selected style="pointer-events:none"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo "<option value='{$value->lob}' {$selected}>{$value->lob}</ooption>";
                                }
                                ?>
                            </select>
                        </span>
                    <?php } ?>
                </div>

                <!-- LOB HIERARCHY DATA -->
                <div class="field-section col s12 m6 l12 <?php echo (($team[0]->is_admin == 3 && $team[0]->usertype == 2)?'':'hide') ?>" id="edit_lob_data">
                    <?php echo (!empty($lob_hierarchy_data)?$lob_hierarchy_data:'');?>
                </div>

                <!-- SUPERVISOR ID, NAME, EMAIL -->
                <div class="<?php echo (($team[0]->is_admin == 2 || $team[0]->is_admin == 3) && $team[0]->usertype == 2)?'':'hide' ?>" id="supData">
                    <div class="clearfix">&nbsp;</div>
                    <!-- SUPERVISOR ID -->
                    <div class="field-section col s12 m6 l4">
                        <h5 class="field-heading">Supervisor</h5>
                        <select id="edit_supervisor_id" name="supervisor_id" class="selectbox">
                            <option value="" disabled>Supervisor</option>
                            <?php echo $supervisor_data;?>
                        </select>
                    </div>

                    <div class="edit_sup_detail_data <?php echo (($team[0]->is_admin == 2 || $team[0]->is_admin == 3) && $team[0]->usertype == 2)?'':'hide' ?>">    
                        <!-- SUPERVISOR NAME -->
                        <div class="field-section col s12 m6 l4">
                            <h5 class="field-heading">Supervisor Name</h5>
                            <input id="edit_supervisor_name" type="text" name="supervisor_name" value="<?php echo (!empty($sup_name)?$sup_name:'');?>" readonly>
                        </div>

                        <!-- SUPERVISOR EMAIL -->
                        <div class="field-section col s12 m6 l4">
                            <h5 class="field-heading">Supervisor Email</h5>
                            <input id="edit_supervisor_email" type="text" name="supervisor_email" value="<?php echo (!empty($sup_email)?$sup_email:'');?>" title="<?php echo (!empty($sup_email)?$sup_email:'');?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>
                <!-- USERNAME -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User Name</h5>
                    <input id="user_name" type="text" name="user_name" value="<?php echo $team[0]->name;?>">
                </div>

                <!-- USERID -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User Id</h5>
                    <span><?php echo $team[0]->empid;?></span>
                </div>

                <!-- USER EMAIL -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User Email</h5>
                    <span><?php echo $team[0]->user_email;?></span>
                </div>

                <div class="clearfix">&nbsp;</div>
                <!-- USER DOJ -->
                <div class="field-section col s12 m6 l4">
                    <h5 class="field-heading">User DOJ</h5>
                    <span><?php echo date('F d, Y',strtotime($team[0]->doj));?></span>
                </div>

                <div class="col s12 mb-0 form_btns">
                    <button type="button" id="agentBtn" class="btn cyan waves-effect waves-light right"  onclick="update_user()">
                        <span>Submit</span>
                        <i class="material-icons right">send</i>
                    </button>
                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                    <button type="reset" id="edit_reset_button" class="hide"></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
<script>
$(document).ready(function() {
    $('.selectbox').formSelect();
});

//ON SELECTION OF CLIENT >> AGENT >> LOB 
//GETTING DETAILS OF HIERARCHY (VENDOR, LOCATION, CAMPAIGN)
$(document).on('change', '#edit_client_lob', function() {
    var clientLob_val = $(this).val();
    
    if (clientLob_val == '') {
        $('#edit_lob_data').addClass('hide');
    } else {
        $.ajax({
            url:BASEURL+'/lob-data/'+clientLob_val,
            type:'get',
            success:function(res){
                $('#edit_lob_data').removeClass('hide');
                $('#edit_lob_data').html(res);
            }
        });
    }
});


//GETTING THE DETAILS OF SUPERVISOR
$(document).on('change', '#edit_supervisor_id', function() {
    var supervisorId = $(this).val();
    if(supervisorId == '') {
        $('.edit_sup_detail_data').addClass('hide');
        $('#edit_supervisor_name').val('');
        $('#edit_supervisor_email').val('');
    } else {
        $.ajax({
            url:BASEURL+'/get-supervisor-details/'+supervisorId,
            type:'get',
            success:function(res){
                res = JSON.parse(res);
                $('.edit_sup_detail_data').removeClass('hide');
                $('#edit_supervisor_name').val(res[0].employee_id);
                $('#edit_supervisor_email').val(res[0].supervisor_email);
            }
        });
    }
});

//Save hierarchy from Ajax
function update_user() {   
    var data = $('#editAgentFrm').serialize();
    var modal_id = 'edit_modal';
    var response = editAjax(BASEURL+'/update-team',data, modal_id);
    
    if(response.status == 'success') {
        $('#edit_success_section').removeClass('hide');
        $('#edit_success_msg').text(response.message);
        
        //Refresh the page without reloading 
        $(".page_loader").fadeIn("slow");
        $("body").addClass("content_loading");

        $.ajax({url: BASEURL+'/team-ajax', success: function(result){

            $('body').css({overflow: 'visible'});

            $('#edit_modal').modal('close');
            $('#edit_modal').modal();

            //remove loading icon
            $(".page_loader").fadeOut("slow");
            $("body").removeClass("content_loading");

            $("#team_ajax").html(result);
        }});

    } else {
        $('#edit_failure_section').removeClass('hide');
        $('#edit_failure_msg').html(response.message);
    }
}
</script>