<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body>
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css"></style>
        <style rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"></style>
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php $this->load->view('common/sidebar_view') ?>
            
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <!--<div class="breadcrumb-left">
                                <h3 class="page-title">User Management</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>User List</span></li>
                                </ul>
                            </div>
                            -->
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- FORM SECTION START -->
                    <div class="table-section mt-24">
                        <div class="col">
                            <div class="row mb-0 flex_col">
                                <?php if($this->emp_group == "admin"){?>
                                <div class="col m6 mb-24">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h4 class="card-title m-0">Sites</h4>
                                                <a href="#users_modal" class="btn_new_site add_newone modal-trigger open_modal">Add Site</a>
                                            </div>
                                            <div id="sites" class="CT sites">
                                                <div class="CT_head">
                                                    <div class="CT_row">
                                                        <div class="CT_th">Site Name</div>
                                                        
                                                        <div class="CT_th action-sm">Action</div>
                                                    </div>
                                                </div>
                                                <div class="CT_body" id="sites_data">
                                                <?php foreach ($site as $key => $value) {?>
                                                    <div class="CT_row" id='<?php echo "site_".$key ?>'>
                                                        <div class="CT_td" id='<?php echo "site_data_".$value->s_id; ?>'><?php echo $value->s_name ?></div>
                                                        <div class="CT_td action-sm">
                                                            <a href="#users_modal" id="test_id" class="btn_edit_site add_newone modal-trigger open_modal" site_edit_val='<?php echo $value->s_name ?>' did='<?php echo $value->s_id; ?>'>Edit</a>
                                                        </div>
                                                        <div class="CT_td action-sm"><a href="javascript:void(0)" class="CT_del_btn flaticon-delete-button delete_site" did='<?php echo $value->s_id; ?>'></a></div>
                                                        
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- section loader start -->
                                        <div class="section_loader">
                                            <div class="loading-center-absolute">
                                                <div class="object object_four"></div>
                                                <div class="object object_three"></div>
                                                <div class="object object_two"></div>
                                            </div>
                                        </div>
                                        <!-- section loader end -->
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if($this->emp_group == "admin" || $this->emp_group =="auditor"){?>
                                <div class="col m6 mb-24">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h4 class="card-title m-0">Groups</h4>
                                                <a href="javascript: void(0)" style="display:none;" id="add_new_group" class="btn_new_group add_newone modal-trigger open_modal">Add Group</a>
                                            </div>
                                            <div id="groups" class="CT groups">
                                                <div class="CT_head">
                                                    <div class="CT_row">
                                                        <div class="CT_th">Group Name</div>
                                                        <div class="CT_th">Site Name</div>
                                                        <div class="CT_th action-sm">Action</div>
                                                    </div>
                                                </div>
                                                <div class="CT_body" id="groups_data">
                                                    <?php foreach ($group as $key => $value) { ?>
                                                    <div class="CT_row" id='<?php echo "group_".$key; ?>'>
                                                        <div class="CT_td" id='<?php echo "group_data_".$value->g_id; ?>'><?php echo $value->g_name; ?></div>
                                                        <div class="CT_td"><?php echo $value->s ?></div>

                                                        <div class="CT_td action-sm">
                                                            <a href="#users_modal" class="btn_edit_group add_newone modal-trigger open_modal" group_edit_val='<?php echo $value->g_name ?>' did='<?php echo $value->g_id; ?>'>Edit</a>
                                                        </div>

                                                        <div class="CT_td action-sm"><a href="javascript:void(0)" class="delete_group CT_del_btn flaticon-delete-button" did='<?php echo $value->g_id; ?>'></a></div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- section loader start -->
                                        <div class="section_loader">
                                            <div class="loading-center-absolute">
                                                <div class="object object_four"></div>
                                                <div class="object object_three"></div>
                                                <div class="object object_two"></div>
                                            </div>
                                        </div>
                                        <!-- section loader end -->
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if($this->emp_group == "admin"){?>
                        <div class="col">
                            <div class="card">
                                <div class="card-content others_datatable_cont">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h4 class="card-title m-0">Users</h4>
                                        <!-- <a  class="bulk_user_upload modal-trigger open_modal" href="#users_modal" data-ref="user_popup_data">Bulk User Upload</a> -->
                                        <a href="#users_modal" class="btn_new_user add_newone modal-trigger open_modal" data-ref="user_popup_data">Add User</a>
                                    </div>
                                    <table class="users_datatable others_datatable" style="width:100%;" id="users_datatable">
                                        <thead>
                                            <tr>
                                                <th class="sno_td disabled_td center">S.No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Site</th>
                                                <th>Group</th>
                                                <th class="center">Status</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $key => $value) { ?>
                                            <tr id="<?php echo 'user_'.$key; ?>">
                                                <td class="sno_td center"><?php echo ++$key; ?></td>
                                                <td><?php echo $value->name; ?></td>
                                                <td><?php echo $value->user_email; ?></td>
                                                <td><?php echo $value->is_admin; ?></td>
                                                <td><?php echo $value->s; ?></td>
                                                <td><?php echo ltrim(str_replace($this->lang->line('default_group'),$this->lang->line('default_group_replace'),$value->g),','); ?></td>
                                                <td class="center status_td">
                                                    <?php echo (($value->status == 'Active')?"<button class='status_btn active agentStatus' value='1' agent='".$value->user_id."'>Active</button>":"<button class='status_btn agentStatus' value='0' agent='".$value->user_id."'></button>"); ?>
                                                </td>
                                                <td class="center action_td">
                                                    <a href="#users_modal" class="tda_edit btn_new_user modal-trigger open_modal" data-ref="user_popup_data" user_id="<?php echo $value->user_id; ?>">
                                                        <i class='material-icons'>edit</i></a>
                                                    <!--<a class="tda_view" href="<?php //echo site_url()."/user-management/users/view/".$value->user_id; ?>"><i class='material-icons'>remove_red_eye</i></a>-->
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- FORM SECTION END -->
                    <!-- Modal Structure -->
                    <div id="users_modal" class="modal">
                        <button type="button" class="users_modal_close modal-close"></button>
                        <div class="modal-content">
                            <h4>Sites</h4>
                            <form method="POST" action="javascript:void(0)"></form>
                        </div>
                    </div>
                    <!-- Modal Structure -->
                    <div id="group_modal1" class="modal">
                        <div class="modal-content">
                            <h4>Groups</h4>
                            <div class="input-field col s4">
                                <i class="material-icons prefix">group</i>
                                <input id="add_group" type="text" class="validate">
                                <label for="add_group">Add Group</label>
                                <span class="add_group_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light waves-green save_group">Save<i class="material-icons right">send</i></a>
                        </div>
                    </div>
                    <div id="bulk_user_upload" class="modal">
                        <div class="modal-content">
                            <h4>Groups</h4>
                            <div class="input-field col s4">
                                <i class="material-icons prefix">group</i>
                                <input id="add_group" type="text" class="validate">
                                <label for="add_group">Add Group</label>
                                <span class="add_group_error"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light waves-green save_group">Save<i class="material-icons right">send</i></a>
                        </div>
                    </div>

                    <div id="site_modal1" class="modal">
                        <div class="modal-content">
                            <h4>Sites</h4>
                            <div class="input-field col s4">
                                <i class="material-icons prefix">my_location</i>
                                <input id="add_site" type="text" class="validate" placeholder="Site Name">
                                <span class="add_site_error"></span>
                            </div>
                            <input id="add_site_id" type="hidden">
                            <input type="hidden" id="currentRow"/>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light waves-green save_site">Save<i class="material-icons right">send</i></a>
                        </div>
                    </div>
                    <!-- Modal Structure -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
                <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDPIDt4IcQXSQAhS-dyux-3ZNO4Lzx8H5E&libraries=places&callback=initAutocomplete" async defer></script> -->

    <script type="text/javascript">
        $(document).ready(function(){

            //btn_new_group 
            
            //if($("#site_0").length){
            if($('#sites_data').children().length > 0){
                $("#add_new_group").removeAttr("style");
                $("#add_new_group").attr("href", '#users_modal');
            }
            
            $('.tabs').tabs();
            $('.modal').modal({dismissible:false});
            $('select').formSelect();
            $('#save_user').click(function(){
                var data = {'add_group':add_group,'status':1}
                var response = postAjax("<?php echo site_url();?>/add-user",data);
                // console.log(response);
            });

            $(document).on('click', '.edit_site',function(){
               
                var edit_site_id = $('#edit_site_id').val();
                    var edit_site_val = $('#edit_site_val').val();                    
                    if(edit_site_val == ""){
                        alertBox('Please enter site name');
                        return false;
                    }
                    var lid = $('#sites_data .CT_row:parent').attr('id');
                   // site_data_".$key   site_data_0
                   //alert("site_data_"+edit_site_id);
                  
                    var did = $(this).attr('did');
                   var s_name = $(this).attr('site_edit_val');
                   if(s_name == ""){
                        alertBox('Please enter site name');
                        return false;
                    }
                   
                    data = {'edit_site_id':edit_site_id,'edit_site_val':edit_site_val}
                    
                    var response = postAjax("<?php echo site_url();?>/edit-site",data);
                    var toastElement = document.querySelector('.toast');
                    if(response.status == "error"){
                        alertBox(response.msg);
                        // alert(response.msg);
                        return false;
                    }
                    if(response.status == "success"){
                        alertBox(response.msg);
                        $("#site_data_"+edit_site_id).text(edit_site_val);
                        //$("#site_data_"+edit_site_id).children('div:first-child').text(edit_site_val);
                        location.reload();
                       return false;
                    }
                    //after success request--> 
                    
                    //site_data_29

            });
            
            // edit_group start
            
            $(document).on('click', '.edit_group',function(){
               
                var edit_group_id = $('#edit_group_id').val();
                var edit_group_val = $('#edit_group_val').val();   
                   if(edit_group_val == ""){
                       alertBox('Please enter site name');
                       return false;
                   }

                   data = {'edit_group_id':edit_group_id,'edit_group_val':edit_group_val}
                   
                   var response = postAjax("<?php echo site_url();?>/edit-group",data);
                   var toastElement = document.querySelector('.toast');
                   if(response.status == "error"){
                       alertBox(response.msg);
                       return false;
                   }
                   if(response.status == "success"){
                       alertBox(response.msg);
                       $("#group_data_"+edit_group_id).text(edit_group_val);
                       location.reload();
                      return false;
                   }

           });
            //edit_group closed


            // Start Add Delete Site data
                $(document).on('click', '.save_site',function(){
                    //alert("sdss");
                    var add_site = $('#add_site').val();
                    var add_site_id = $('#add_site_id').val();                    
                    if(add_site == ""){
                        alertBox('Please enter site name');
                        return false;
                    } 
                                       
                    var data = {'add_site':add_site,'status':1,'add':true}
                    var response =site(data);
                    if(response.status === "success"){
                       
                         //alert("last_insert_id--"+response.id); 

                        var lid = $('#sites_data .CT_row:last').attr('id');
                        var count = 0;
                        if(lid != undefined){
                            count = count+parseInt(lid.split('_')[1]);
                        }
                        count++;
                        var html = `
                                    <div class="CT_row" id='site_`+count+`'>
                                        <div class="CT_td" id='site_data_`+response.id+`'>`+add_site+`</div>
                                        <div class="CT_td action-sm"><a href="#users_modal" id="test_id" class="btn_edit_site add_newone modal-trigger open_modal" site_edit_val='`+add_site+`' did='`+response.id+`'>Edit</a></div>
                                        <div class="CT_td action-sm"><a href="javascript:void(0)" class="delete_site CT_del_btn flaticon-delete-button" did='`+response.id+`'></a></div>
                                    </div>
                                `;
                        $('#sites_data').append(html);

                         // do
                        //enable add group

                        if($('#sites_data').children().length > 0){
                            $("#add_new_group").removeAttr("style");
                            $("#add_new_group").attr("href", '#users_modal');
                        }else{
                            $("#add_new_group").attr("style", "display: none;");
                            $("#add_new_group").attr("href", 'javascript: void(0)');
                        }
                        
                        alertBox('Site added Successfully');
                        location.reload();
                    }
                    else{
                        alertBox('Site name already exist');
                        // $('.add_site_error').html('Site name already exist').css('color','red');
                        return false;
                    }
                });
                $(document).delegate('.delete_site','click',function(){
                    var did = $(this).attr('did');
                    data = {'did':did}
                    var response = postAjax("<?php echo site_url();?>/del-site",data);
                    var toastElement = document.querySelector('.toast');
                    // $('#'+$(this).closest('tr').attr('id')).remove(); 
                    if(response.status == "error"){
                        alertBox(response.msg);
                        // alert(response.msg);
                        return false;
                    }
                    if(response.status == "success"){
                        // alert(response.msg);
                        alertBox(response.msg);
                        $('#'+$(this).closest('.CT_row').attr('id')).remove(); 
                        // enable disable add group button
                        if($('#sites_data').children().length > 0){
                            $("#add_new_group").removeAttr("style");
                            $("#add_new_group").attr("href", '#users_modal');
                        }else{
                            $("#add_new_group").attr("style", "display: none;");
                            $("#add_new_group").attr("href", 'javascript: void(0)');
                        }
                        return false;
                    }
                });
            // End Add Delete Site data


            // Start Group add and delete data
                $(document).on('click', '.save_group', function(){
                    var add_group = $('#add_group').val();
                    var site_group = $('.new_site_group').val()
                    if(add_group == ""){
                        // $('.add_group_error').html('Please enter group name').css('color','red');
                        alertBox('Please enter group name');
                        return false;
                    }
                    else if(site_group.length === 0){
                        alertBox('Please select Site');
                        return false;
                    }
                    var data        =   {'add_group':add_group,'sites':site_group,'status':1,'add':true}
                    var response    =   group(data);
                    if(response.status === "success"){
                        var lid = $('#groups_data .CT_row:last').attr('id');
                        var gcount = 0;
                        if(lid != undefined){
                            gcount = gcount+parseInt(lid.split('_')[1]);
                        }
                        gcount++;
                        var option_all = $(".new_site_group option:selected").map(function () {
                            return $(this).text();
                        }).get().join(',');
                        var html = `
                                    <div class="CT_row" id='group_`+gcount+`'>
                                        <div class="CT_td" id='group_data_`+response.id+`'>`+add_group+`</div>
                                        <div class="CT_td">`+option_all+`</div>
                                        <div class="CT_td action-sm">
                                            <a href="#users_modal" class="btn_edit_group add_newone modal-trigger open_modal" group_edit_val=`+add_group+` did='`+response.id+`'>Edit</a>
                                        </div>
                                        <div class="CT_td action-sm"><a href="javascript:void(0)" class="delete_group CT_del_btn flaticon-delete-button" did='`+response.id+`'></a></div>
                                    </div>
                                `;
                        $('#groups_data').append(html)
                        alertBox('Group Created Successfully');
                        //$('.new_user_group').append(groupopthtml);
                        //$(".new_user_group").formSelect();
                        location.reload();
                    }
                    else{
                        alertBox('Group name already exist')
                        // $('.add_group_error').html('Group name already exist').css('color','red');
                        return false;
                    }
                });
                $(document).delegate('.delete_group','click',function(){
                    
                    var did = $(this).attr('did');
                    data = {'did':did}
                    var response = postAjax("<?php echo site_url();?>/del-group",data);
                    var toastElement = document.querySelector('.toast');
                    if(toastElement){
                        var toastInstance = M.Toast.getInstance(toastElement);
                        toastInstance.dismiss();
                    }
                    if(response.status == "error"){
                        alertBox(response.msg);
                        // alert(response.msg);
                        return false;
                    }
                    if(response.status == "success"){
                        $(".new_user_group option[value='"+did+"']").remove();
                        $(".new_user_group").formSelect();
                        // alert(response.msg);
                        alertBox(response.msg);
                        $('#'+$(this).closest('.CT_row').attr('id')).remove(); 
                        return false;
                    }
                });
            // End Group add and delete data
            // User Active Inactive
            $('.agentStatus').click(function() {
                var aid = $(this).attr('agent');
                var question_response_txt = $(this).closest(".status_td").find('button').attr('value');
                if(question_response_txt === "1"){
                    $(this).closest(".status_td").find('button').attr('value','0')
                    $(this).removeClass("active").text("Inactive");
                    userActive(aid)
                }
                else{
                    $(this).closest(".status_td").find('button').attr('value','1')
                    $(this).addClass("active").text("Active");
                    userInactive(aid)
                }
                // $(this).val() == "1" ? userActive(aid) : userInactive(aid);
            });

            // Start Bulk User Upload
                $(document).on('click','.save_bulk_user_upload',function(){
                    var file_data = $('#csv_bulk_user_upload').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('csrf_test_name', $('#csrf_token').val());
                    alertBox(form_data);
                    var base_url = '<?php echo site_url();?>/user-bulk-upload';
                    $.ajax({
                        url: base_url,
                        async: false,
                        type: 'post',
                        processData : false,
                        contentType: false,
                        dataType: 'json',
                        data: form_data,
                        beforeSend: function () {            
                            $(".page_loader").fadeIn("slow");
                            $("body").addClass("content_loading");
                        },
                        success: function (res) {
                            $('input[name="csrf_test_name"]').val(res.csrfHash);
                            $(".page_loader").fadeOut("slow");
                            $("body").removeClass("content_loading");
                            alertBox(res.data);
                        }
                    });
                });
            // End Bulk User Upload
        });
        function site(data){
            return postAjax("<?php echo site_url();?>/add-site",data);
        }
        function group(data){
            return postAjax("<?php echo site_url();?>/add-group",data);
        }
       
        

        var autocomplete;
        var componentForm = {locality: 'long_name',administrative_area_level_1: 'long_name',postal_code: 'long_name',country: 'long_name'};
        function initAutocomplete(){
            autocomplete = new google.maps.places.Autocomplete((document.getElementById('add_site')),{types:['geocode']});autocomplete.addListener('place_changed', fillInAddress);
        }
        function fillInAddress(){
            var place = autocomplete.getPlace();
            for (var component in componentForm) {
                document.getElementById(component).value = '';
            }
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }
        function userActive(id) {
            // $('.agentStatus').val("1"); 
            postAjax('<?php echo site_url();?>/del-user',{'id':id,'status':'0'});
            alertBox('Inactive Successfully!');
            //alert('Employee Inactive Successfully!');
        }
        function userInactive(id) {
            // $('.agentStatus').val("0");
            postAjax('<?php echo site_url();?>/del-user',{'id':id,'status':'1'});
            alertBox('Active Successfully!');
            //alert('Employee Active Successfully!');
        }
        $(document).ready(function(){

            var group = '<?php echo json_encode((!empty($group)?$group:[])); ?>';
            group = JSON.parse(group);
            var groupopthtml = '';
            $.each(group,function(key,val){
                groupopthtml += "<option value='"+val.g_id+"'>"+val.g_name+"</option>";
            });
            
            // var site = '<?php //echo json_encode((!empty($site)?$site:[])); ?>';
            // site = JSON.parse(site);
            // var siteopthtml = '';
            // $.each(site,function(key,val){
            //     siteopthtml += "<option value='"+val.s_id+"'>"+val.s_name+"</option>";
            // });
            var site_ref_data = `<input id="add_site_id" type="hidden">
                                <input type="hidden" id="currentRow"/>
                                <div class="changeable_content">
                                    <input id="add_site" name="site_name" type="text" placeholder="Site Name">
                                    <span class="add_site_error"></span>                                    
                                    <button type="submit" class="create_site_btn save_site">Create</button>
                                </div>`;

                

            var group_ref_data = `<div class="changeable_content">
                                    <input id="add_group" name="group_name" type="text" placeholder="Group Name">
                                    <span class="add_group_error"></span>
                                    <div class="input-field m-0">
                                        <select class="new_site_group" name="user_group" placeholder="">
                                            <option value="" disabled>Sites</option>
                                            
                                        </select>
                                    </div>
                                    <button type="submit" class="create_group_btn save_group">Create</button>
                                </div>`;
            var user_ref_data = `<div class="user_changeable_content">
                                    <input id="user_id" name="id" type="hidden" value="">
                                    <div class="input-field m-0">
                                        <input id="new_user_name" name="user_name" type="text" placeholder="User Name" requried>
                                    </div>
                                    <div class="input-field m-0">
                                        <input id="new_user_email" name="user_email" type="text" placeholder="Email ID">
                                    </div>
                                    <div class="input-field m-0">
                                        <select id="new_user_role" name="user_role" placeholder="">
                                            <option value="" selected>Assign Role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Auditor</option>
                                            <option value="3">Reviewer</option>
                                            <option value="4">Manager</option>
                                        </select>
                                    </div>
                                    <div class="input-field m-0">
                                        <select class="new_user_site" onchange="getSiteData(this);" name="user_site" placeholder="" multiple>
                                            <option value="" disabled>Assign Site</option>
                                        </select>
                                    </div>
                                    
                                   
                                    <div class="input-field m-0">
                                        <select id="user_group_id" class="new_user_group" name="user_group" placeholder="Select group" multiple disabled>
                                            <option value="" disabled>Assign groups</option>
                                        </select>
                                    </div>
                                   
                                    
                                    <button type="button" id="create_user" class="create_user_btn">Create</button>
                                    
                                </div>`;
            var bulk_user_upload = `<div class="changeable_content">
                                        <a href="<?php echo base_url();?>assets/download/user.xlsx" download>Download CSV</a>
                                        <input type="file" name="csv_bulk_user_upload" id="csv_bulk_user_upload">
                                        <span class="csv_bulk_user_upload_error"></span>

                                        <button type="submit" class="create_site_btn save_bulk_user_upload">Create</button>
                                    </div>`;
            
            $(".btn_new_group").click(function(){
                var site = postAjax('<?php echo site_url();?>/get-sites-data',{'status':'0'});
                console.log(site);
                var siteopthtml = '';
                siteopthtml += "<option value='' selected>Select Site</option>";
                $.each(site,function(key,val){
                    var selected = ((key == 0)?'selected':'');
                    siteopthtml += "<option value='"+val.id+"'>"+val.site_name+"</option>";
                   // siteopthtml += "<option value='"+val.id+"' "+selected+">"+val.site_name+"</option>";
                });
                $("#users_modal").find("h4").html("Add New Group");
                $("#users_modal").find("form").html(group_ref_data);
                $('.new_site_group').append(siteopthtml);
                $("#users_modal").find("select").formSelect();
            });
            $(".btn_new_site").click(function(){
                $("#users_modal").find("h4").html("Add New Site");
                $("#users_modal").find("form").html(site_ref_data);
            });
            $('.btn_edit_site').on('click', function() {
           //     alert("edit button");
                $("#users_modal").find("h4").html("Edit Site");
                var did = $(this).attr('did');
                //var s_name = $(this).attr('site_edit_val');
                var s_name = $('#site_data_'+did).text();

              //  alert("did--"+did+"s_name--"+s_name);
            var site_edit_data ="<input id='edit_site_id' value='"+did+"' type='hidden'>";
            site_edit_data +='<div class="changeable_content">';
            site_edit_data +="<input id='edit_site_val' name='edit_site_val' type='text'  value='"+s_name+"' >";
            site_edit_data +='<span class="add_site_error"></span>';                                    
            site_edit_data +='<button type="submit" class="create_site_btn edit_site">Update</button>';
            site_edit_data +='</div>'; 

                $("#users_modal").find("form").html(site_edit_data);
            });

            // edit group  start 

            $('.btn_edit_group').on('click', function() {
           //     alert("edit button");
                $("#users_modal").find("h4").html("Edit Group");
                var did = $(this).attr('did');
              //  var g_name = $(this).attr('group_edit_val');
                var g_name = $('#group_data_'+did).text();
                

              //  alert("did--"+did+"s_name--"+s_name);
            var group_edit_data ="<input id='edit_group_id' value='"+did+"' type='hidden'>";
            group_edit_data +='<div class="changeable_content">';
            group_edit_data +="<input id='edit_group_val' name='edit_group_val' type='text'  value='"+g_name+"' >";
            group_edit_data +='<span class="add_group_error"></span>';                                    
            group_edit_data +='<button type="submit" class="create_site_btn edit_group">Update</button>';
            group_edit_data +='</div>'; 

                $("#users_modal").find("form").html(group_edit_data);
            });
            // edit group closed


            $(".bulk_user_upload").click(function(){
                $("#users_modal").find("h4").html("Bulk User Upload");
                $("#users_modal").find("form").html(bulk_user_upload);
            });
            $(".btn_new_user").click(function(){
               // alert("AAA");
                var group = postAjax('<?php echo site_url();?>/get-group-data',{'status':'0'});                
                var groupopthtml = '';
                $.each(group,function(key,val){
                   /* var selected = ((key == 0)?'selected':'');
                    groupopthtml += "<option value='"+val.id+"' "+selected+">"+val.group_name+"</option>";
                    */
                   
                    groupopthtml += "<option value='"+val.id+"'>"+val.group_name+"</option>";

                });

                //get-sites-data
                var site = postAjax('<?php echo site_url();?>/get-sites-data',{'status':'0'});                
                var siteopthtml = '';
                $.each(site,function(key,val){
                   /* var selected = ((key == 0)?'selected':'');
                    siteopthtml += "<option value='"+val.id+"' "+selected+">"+val.site_name+"</option>"; */
                   // var selected = ((key == 0)?'selected':'');
                    siteopthtml += "<option value='"+val.id+"'>"+val.site_name+"</option>";
                });
               // alert("siteopthtml--"+siteopthtml);    
                //return false;

                $("#users_modal").find("h4").html("Add New User");
                $("#users_modal").find("form").html(user_ref_data);
                $('.new_user_group').append(groupopthtml);
                $('.new_user_site').append(siteopthtml);
                $("#users_modal").find("select").formSelect();
            });

           
            $('.users_datatable').DataTable(
                {
                    "scrollX": true,
                    columnDefs: [
                        {  
                            orderable: false,
                            targets: [ 0, 5, 6 ]
                        }
                    ],
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true
                }
            );

            $(document).delegate('#create_user','click',function(){
               
                var new_user_name = $('#new_user_name').val();
                var new_user_email = $('#new_user_email').val();
                var new_user_role = $('#new_user_role').val();
                var new_user_group = $('.new_user_group').val();
                var new_user_site = $('.new_user_site').val();
                //alert("new_user_site-"+new_user_site);
               // alert("new_user_site-"+new_user_site);
             //  return false;
               // die;
                
                if(new_user_name == ""){
                    // alert("Please enter User name");
                    alertBox('Please enter User name');
                    return false;
                }
                else if(new_user_email == ""){
                    // alert("Please enter User email");
                    alertBox('Please enter User email');
                    return false;
                }
                else if(!validateEmail(new_user_email)){
                    // alert('Please enter valid emailid');
                    alertBox('Please enter valid emailid');
                    return false;
                }
                else if(new_user_role == ""){
                    // alert("Please select role");
                    alertBox('Please select role');
                    
                    return false;
                }else if(new_user_group == ""){
                    // alert("Please select groups");
                    alertBox('Please select groups');
                    
                    return false;
                }
                else if(new_user_site == ""){
                    alertBox('Please select sites');                    
                    return false;
                }
                else{
                    var data = {
                        'name'  :new_user_name,
                        'email' :new_user_email,
                        'group' :new_user_group,
                        'site'  :new_user_site,
                        'role'  :new_user_role,
                        'id'    :$('#user_id').val(),
                        'method':(($('#user_id').val() !== "")?"edit":'add')
                    }
                    var response = postAjax('<?php echo site_url();?>/add-user',data);
                     //   console.log(response);
                    //    return false;

                    if(response.massage === "Email already exist"){
                        alertBox(response.massage);
                        return false
                    }
                    else if(response.massage === "User Update Successfully"){
                        alertBox(response.massage);
                        location.reload();
                    }
                    else{
                        $('#users_modal').find('form')[0].reset();
                        location.reload();
                    }


                }
                // $("#add_site")
            });
            $(document).delegate('.tda_edit','click',function(){
                
                $("#users_modal").find("h4").html("Edit User");
                $("#create_user").text("Update");
                var user_id = $(this).attr('user_id')
                $('#user_id').val(user_id);
                $.ajax({
                    url : '<?php echo site_url();?>/user-management/users/edit/'+user_id,
                    type:'get',
                    async: false,
                    success:function(res){
                        console.log(res)
                        res = JSON.parse(res)
                        var userdata = res.data.user;
                        console.log(userdata)
                        $('#new_user_name').val(userdata.name);
                        $('#new_user_email').val(userdata.email).prop('disabled',true);
                        var site_id = (userdata.site).split(',')
                        //var site_id = (userdata.site);
                        //alert(userdata.site);
                       // var group_id = (userdata.group);
                        //alert("group_id--"+group_id);
                       
                        var group_id = (userdata.group).split(',')
                        $.each(group_id,function(key,val){
                            $('.new_user_group').find('option[value="'+val+'"]').prop('selected', true);
                           // alert("AA");
                          
                        });
                        
                        
                        $.each(site_id,function(key,val){
                            $('.new_user_site').find('option[value="'+val+'"]').prop('selected', true);
                            //alert("new_user_site--"+val);
                        });
                        
                      //  $('.new_user_site').find('option[value="'+site_id+'"]').prop('selected', true);
                       // $('.new_user_group').find('option[value="'+group_id+'"]').prop('selected', true);

                        $('#new_user_role').find('option[value="'+userdata.role+'"]').prop('selected', true);
                        $('.new_user_group,.new_user_site,#new_user_role').formSelect();
                    }
                })
                // var response = postAjax('<?php echo site_url();?>/add-user',data);
                // console.log(response)
            });
        });

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function getSiteData(id){
        var new_user_site = $('.new_user_site').val(); 
        if(new_user_site==""){
            return false;
        }
        data = {'new_user_site':new_user_site}
        
        var response = postAjax("<?php echo site_url();?>/group-by-site",data);
      if(response.status == "nodata"){
            return false;
        }   
        var groupopthtml ="<option value='' disabled=''>Assign groups</option>";
        $.each(response,function(key,val){
                    groupopthtml += "<option value='"+val.g_id+"'>"+val.g_name+"</option>";
                });
           $("#user_group_id").html(groupopthtml); 
           $("#user_group_id").prop("disabled", false);

         //   $("#testing_id").html("<select id='user_group_id' class='new_user_group' name='user_group'><option value='AA'>HELLO JACK</option></select>"); 
            $("#users_modal").find("select").formSelect();
        }

    function udpdateUserTable(){
        $('#users_datatable tbody').html('');
                $('#users_datatable').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    // scrollY : '30vh',
                    data:singleArray,
                    "columns": [
                        { 'data': 'unique_id' },
                        { 'data': 'eval_name' },   
                        { 'data': 'lob' },
                        { 'data': 'call_id' }
                                           
                    ]
                });
    }

	

        
    </script>
</html>