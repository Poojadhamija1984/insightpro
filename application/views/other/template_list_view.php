<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css"></style>
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"></style>
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
                                <h3 class="page-title">Form</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item">Form List</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right">
                                <!-- <a class="btn_common" href="<?php echo site_url()?>/forms-add">add form</a> -->
                                <!-- <a class="btn_common" href="<?php //echo site_url()?>/template-details">Create Template</a> -->
                                <!-- <div class="csv_table_btns"></div> -->
                            </div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR START -->
                    <div class="log_msg error_section hide">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <span id='log_msg'></span>
                            </div>
                        </div>
                    </div>
                    <div class="rrr"> 
                    </div>
                    <?php if($this->session->flashdata('message') || $this->session->flashdata('success')) { ?>
                        <div class="error_section">
                            <div class="page_error success mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('message'); ?>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')) { ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>  
                    <!-- PAGE ERROR END -->
                    <!-- CARDS START -->
                    <div class="card-section mt-16">
                        <div class="d-flex flex-wrap align-items-center">
                            <a class="new_temp_btn btn-gradient" href="<?php echo site_url()?>/template-details"><i class="flaticon-edit"></i><span>Create Form</span></a>
                            <a class="temp_list_btn" href="<?php echo site_url()?>/other-template-list"><i class="flaticon-notepad"></i><span>Choose Form</span></a>
                        </div>
                        <!-- <div class="temp_cards_list">
                            <div class="temp_card">
                                <h3>Create New</h3>
                                <a href="<?php //echo site_url()?>/template-details">Create</a>
                            </div>
                            <?php //foreach($template_details_pre as $each_card) { ?>
                            <div class="temp_card">
                                <h3><?php echo $each_card['template_type'] ?></h3>
                                <a href="<?= site_url().'/template-edit/'.$each_card['tmp_unique_id'].'/selected';?>">Select</a>
                            </div>
                            <?php //} ?>
                        </div> -->
                    </div>
                    <!-- CARDS END -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content others_datatable_cont">
                                <h4 class="card-title">Form List</h4>
                                <table class="templates_table others_datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="sno_td disabled_td center">S.No.</th>
                                            <th>Form</th>
                                            <th class="center">Questions</th>
                                            <th class="center status_td">Created Date</th>
                                            <th class="center status_td">Status</th>
                                            <th class="center action_td">Actions</th>
                                            <th class="center share_td">Assign Form</th>
                                            <th class="center share_td">Copy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($template_data)) { 
                                        $i=1;
                                        foreach($template_data as $key => $value){
                                    ?>
                                        <tr class="template-list">
                                            <td class="sno_td center"><?=$i?></td>
                                            <?php
                                            if(!empty($value['tmp_name']))
                                            {
                                                echo '<td><a  href="'.site_url().'/template/'.$value['tmp_unique_id'].'">'.ucfirst($value['tmp_name']).'</a></td>';
                                            }
                                            else {
                                                echo '<td><a href="javascript:void(0)">Undefined</a></td>';
                                            }
                                            ?>
                                            
                                            <td class="center"><?=(!empty($value['tmp_attributes']) ? $value['tmp_attributes'] : "----") ?></td>
                                            <td class="center"><?=(!empty($value['created_date']) ? Date('Y-m-d',strtotime($value['created_date'])) : "----") ?></td>
                                            <td class="center status_td">
                                                <!-- <button class="action_btn custom_switch switch <?=$value['temp_status'] == 1?'active':''?>" data-temp-id="<?=$value['tmp_unique_id']?>" data-temp-status="<?=$value['temp_status']?>"><span class="lever"></span></button> -->
                                                <button class="action_btn status_btn <?=$value['temp_status'] == 1?'active':''?>" data-temp-id="<?=$value['tmp_unique_id']?>" data-temp-status="<?=$value['temp_status']?>"><?=$value['temp_status'] == 1?'Active':'Inactive'?></button>
                                            </td>
                                            <td class="center action_td">
                                                <?php echo (check_audits($value['tb_name']) == 0) ? 
                                                '<a class="btn_edit" href="'.site_url().'/template-edit/'.$value['tmp_unique_id'].'" title="Edit"><i class="material-icons">edit</i></a>' 
                                                : '<span class="badge live_badge">Live</span>';?>
                                                
                                                <a class="btn_del delete_temp_btn " tmp_unique_id = "<?=$value['tmp_unique_id']?>"  href="javascript:void(0)" title="Del" ><i class="flaticon-delete-button"></i></a>
                                            </td>
                                            <td class="center share_td">

                                                <a class="share_with_btn notify_btn modal-trigger open_modal" href="<?=$value['temp_status'] == 1?'#alert_choose_modal':'#'?>" tmp_unique_id = "<?=$value['tmp_unique_id']?>">Assign</a>
                                            </td>
                                            <td class="center share_td">

                                                <a class="share_with_btn notify_btn" href="<?php echo site_url('template-edit/').$value['tmp_unique_id'].'/'.'copy'; ?>">Copy</a>
                                            </td>
                                        </tr>
                                    <?php 
                                            $i++;
                                        }
                                    }
                                    ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="alert_choose_modal" class="modal temp_alert_modal" style="height:70vh;width:70vw;max-height:70vh;max-width:70vw;">
                    <button type="button" class="users_modal_close modal-close"></button>
                    <div class="modal-content">
                        <h4>Assign Form</h4>
                        <form class="col">
                            <input type="hidden" id="tmp_unique_id" name="tmp_unique_id" value="">
                            <div class="row mb-0">
                                 <div class="col s6 notify_custom_opt-cont2">
                                    <div class="input-field m-0">
                                          <select multiple id="sites">
                                            <option value="" disabled>Select Sites</option>
                                            <?php 
                                            
                                                foreach ($sites as $key => $value) {
                                                    //$sel = (($key == 0)?'selected':'');
                                                    echo "<option value='$value->s_id' $sel>$value->s_name</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col s6 notify_custom_opt-cont2">
                                    <div class="input-field m-0">
                                        <select multiple id="groups">
                                            <option value="" disabled>Select Groups</option>
                                            <?php 
                                                foreach ($groups as $key => $value) {
                                                    //$sel = (($key == 0)?'selected':'');
                                                    echo "<option value='$value->g_id' $sel>$value->g_name</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                            <!-- <div class="rrr"> </div> -->
                                <div class="log_msg error_section hide">
                                    <div class="page_error success mb-12">
                                        <div class="alert alert-info text-center">
                                            <span id='log_msg_modal'></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                 <div class="col s12 notify_custom_opt-cont2">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="CT groups"> 
                                                <div class="CT_head">
                                                    <div class="CT_row">
                                                        <div class="CT_th">Name</div>
                                                        <div class="CT_th">Email</div>
                                                    </div>
                                                </div>                                               
                                                <div class="CT_body share_user_list">  
                                                <?php
                                                foreach ($user_list as $key => $value) {
                                                    echo  "<div class='CT_row'>
                                                    <div class='CT_td'>{$value['name']}</div>
                                                    <div class='CT_td'>{$value['user_email']}</div></div>";
                                                }
                                                ?>                                                 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="center notify_custom_opt-cont2">
                                <button type="button" class="btn btn-primary assign_submit_btn" <?php echo (count($sites) == 0 && count($groups) == 0 && count($user_list) == 0)? 'disabled': ''; ?> >Submit</button>
                            </div>
                        </form>
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
        <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
                    
    </body>
</html>
<script>
    $(document).ready(function(){
        $('.modal').modal({dismissible:false});
        $('.templates_table').DataTable(
            {
                "scrollX": true,
                columnDefs: [
                    {  
                        orderable: false,
                        targets: [ 0, 3, 4, 5 ]
                    }
                ],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            }
        );
        //$('.share_with_btn').click(function(){
        $(document).on('click',".share_with_btn",function(){
            if($(this).closest('.template-list').find('.action_btn').attr('data-temp-status') == '0'){
                // $(this).closest('.template-list').find('.action_btn').attr('href','#')
                alertBox('Activate the Form');
                return false
            }
            else{
                var tmp_unique_id = $(this).attr('tmp_unique_id');
                $('#tmp_unique_id').val(tmp_unique_id);
                var role =[];
                var ajaxRes = postAjax('<?php echo site_url();?>/template-share-list',{'tmp_unique_id':tmp_unique_id});
                if(ajaxRes['share'].site_id != null && ajaxRes['share'].group_id != null){
                    var site_id = (ajaxRes['share'].site_id).split(',')
                    var group_id = (ajaxRes['share'].group_id).split(',')
                    $.each(site_id,function(key,val){
                        $('#sites').find('option[value="'+val+'"]').prop('selected', true);
                    });
                    $.each(group_id,function(key,val){
                        $('#groups').find('option[value="'+val+'"]').prop('selected', true);
                    });
                    $('#sites,#groups').formSelect();
                    var html = "";
                    $.each(ajaxRes.user,function(key,val){
                        role.push(val.role);
                        html +='<div class="CT_row">';
                        html +='<div class="CT_td">'+val.name+'</div>'; 
                        html +='<div class="CT_td">'+val.email+'</div>'; 
                        //html +="<li>"+val.name+"</li>" 
                        html +='</div>';
                    });
                    // html +="</ul>";
                    // code by jai..............
                    html +='<input type="hidden" id="user_role_id" value="'+role+'">'
                    $('.share_user_list').html(html);
                }
                // $('.share_user_list').html('No data found');
            }
        });
         $('#sites,#groups').change(function(){
            var ajaxRes = postAjax('<?php echo site_url();?>/template-share-list',{'sites':$('#sites').val(),'groups':$('#groups').val(),'change':true});
            var html = "";
           var role =[];
            $.each(ajaxRes.user,function(key,val){
                role.push(val.role);
               
                html +='<div class="CT_row">';
                html +='<div class="CT_td">'+val.name+'</div>'; 
                html +='<div class="CT_td">'+val.email+'</div>'; 
                
                //html +="<li>"+val.name+"</li>" 
                html +='</div>'; 
            });
             // code by jai..............
            html +='<input type="hidden" id="user_role_id" value="'+role+'">'
           // html +="</ul>";
            $('.share_user_list').html(html);
        });
        //$('.assign_submit_btn').click(function(){
        $(document).on('click',".assign_submit_btn",function(){
            var data =[];
            data['tmp_unique_id'] = $('#tmp_unique_id').val();
            data['role'] =$('#user_role_id').val();
            if(typeof($('#groups').val())  !== "undefined" && $('#groups').val() != '')
            {
                data['group_id'] = $('#groups').val().toString();
                //alert($('#groups').val());
                //alert($('#groups').val());
            }
            if(typeof($('#sites').val())  !== "undefined" && $('#sites').val() != '')
            {
                data['site_id'] = $('#sites').val().toString();
                //alert($('#sites').val());
                //alert($('#groups').val());
            }
            data = $.extend({}, data);
            var ajaxRes = postAjax('<?php echo site_url();?>/template-share',data);
            $('.log_msg').removeClass('hide');
            //$('.rrr').html(JSON.stringify(ajaxRes));
            if(ajaxRes === 'Success')
            { 
                $('#log_msg_modal').html('Form Assign successfully'); 
                         
            }else if(ajaxRes==='Fail_Check_Role')
            {
               // $('#log_msg_modal').html('Manager And Reviewer are Required.'); 
               // code by jai
               $('.log_msg').addClass('hide');
               alertBox('Manager And Reviewer are Required');
            }
            else{
                $('#log_msg_modal').html('Form  Not Assign try again ....'); 
            }
            setTimeout(function(){ $('.log_msg').addClass('hide'); }, 3000);
        });

       


        $(".notify_temp_opt").on("change", function(){
            if($(this).val() == "group") {
                $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont2").css("display", "none").find('select').val('').formSelect();
                 $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont").css("display", "block");
            } else {
                $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont").css("display", "none").find('select').val('').formSelect();
                 $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont2").css("display", "block");
            }
        })

      
        $(document).on('click',".action_btn",function(){
            var base_url = "<?php echo site_url();?>";
            var tmp_unique_id = $(this).attr('data-temp-id');
            var temp_status = $(this).attr('data-temp-status');
            if(temp_status ==1)
            {
                temp_status = 0;
            }
            else
            {
                temp_status = 1;
            }

            /// postAjax() this function is define in custom.js is use for ajax post request
            var ajaxRes = postAjax('<?php echo site_url();?>/template-status',{'tmp_unique_id':tmp_unique_id,'temp_status':temp_status});
            $('.log_msg').removeClass('hide');
            if(ajaxRes =='Success')
            {
                if(temp_status ==0){
                    $(this).removeClass('active');
                    $(this).attr('data-temp-status',0).text("Inactive");
                    $(this).closest('.template-list').find('.share_with_btn').attr('href','#');
                    
                    //$('#log_msg').html('Status has been changed successfully');   
                    alertBox('Inactive  successfully'); 
                  
                }
                else{
                    $(this).addClass('active');
                    $(this).attr('data-temp-status',1).text("Active");
                    $(this).closest('.template-list').find('.share_with_btn').attr('href','#alert_choose_modal');
                    //$('#log_msg').html('Status has been changed successfully');
                    alertBox('Active  successfully');   
                }
            }
            else{
                //$('#log_msg').html('Status not change, try again...'); 
                alertBox('Status not change, try again...');  
            }
            setTimeout(function(){ $('.log_msg').addClass('hide'); }, 3000);
        });

        $(document).on('click',".delete_temp_btn",function(){
            if(confirm("All Form data will be deleted.  Are you sure want to delete. ?")){
                var tmp_unique_id = $(this).attr('tmp_unique_id');
                 $(this).attr("href", "<?php echo site_url()?>/template-delete/"+tmp_unique_id);
                // $('.rrr').html(JSON.stringify(ajaxRes));
                // $('.log_msg').removeClass('hide');
                // if(ajaxRes =='Success')
                // {
                //     $('#log_msg').html('Template and data has been deleted');       
                // }
                // else{
                //     $('#log_msg').html('Template not deleted try again.....'); 
                // }
               // setTimeout(function(){ $('.log_msg').addClass('hide'); }, 3000);
            }
            else{
                return false;
            }
        });
    });
</script>



 