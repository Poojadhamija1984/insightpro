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

<script>
$(document).ready(function() {
    $('.csv_table').DataTable();
    $('.selectbox').formSelect();
});
</script>