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

<script>
$(document).ready(function() {
    $('.modal').modal();
    $('.data_table').DataTable();
    $('.selectbox').formSelect();
    $('.datepicker').datepicker({format : 'yyyy-mm-dd', maxDate: new Date()});
});
</script>