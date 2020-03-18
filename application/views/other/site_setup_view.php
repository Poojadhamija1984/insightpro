<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="setup_body">
        <div class="page-wrapper">
            <?php $this->load->view('common/header_view') ?>
            <?php //$this->load->view('common/sidebar_view') ?>
            <input type="hidden" id="csrf_token" name="csrf_test_name" value="<?=$this->security->get_csrf_hash();?>">
            <main>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents custom-flex">
                    <div class="setup-section">
                        <div class="setup-header">
                            <div class="progress-steps">
                                <div class="single_step completed">
                                    <span class="step-counter">1</span>
                                    <span class="step-text">Choose Form</span>
                                </div>
                                <div class="single_step">
                                    <span class="step-counter">2</span>
                                    <span class="step-text">User Management</span>
                                </div>
                                <div class="single_step">
                                    <span class="step-counter">3</span>
                                    <span class="step-text">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="setup-contents">
                            <div class="user_management_section">
                                <div class="user_management_header d-flex flex-wrap align-items-center justify-content-between">
                                    <a class="um_tab_item active" href="javascript:void(0)" data-target="um_site">Create New Site</a>
                                    <a class="um_tab_item" href="javascript:void(0)" data-target="um_group">Create New Group</a>
                                    <a class="um_tab_item" href="javascript:void(0)" data-target="um_user">Create New Users</a>
                                </div>
                                <div class="user_management_contents">
                                    <div id="um_site" class="um_tab_contents active">
                                        <div class="um_tab_inner d-flex align-items-center justify-content-center">
                                            <div>
                                                <input id="add_site" name="site_name" type="text" placeholder="Site Name">
                                                <span class="add_site_error"></span> 
                                                <div class="center"><button type="submit" class="create_site_btn save_site" next="1" pre="0">Next</button></div>                                   
                                            </div>
                                        </div>
                                    </div>
                                    <div id="um_group" class="um_tab_contents">
                                        <div class="um_tab_inner d-flex align-items-center justify-content-center">
                                            <div class="row mb-0">
                                                <div class="col m6 pl-0">
                                                    <input id="add_group" name="group_name" type="text" placeholder="Group Name">
                                                    <span class="add_group_error"></span>
                                                </div>
                                                <div class="col m6 pr-0 input-field m-0">
                                                    <select class="new_site_group" name="user_group" placeholder="" multiple>
                                                        <option value="" disabled="">Assign Sites</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="create_group_btn save_group" next="2" pre="1">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="um_user" class="um_tab_contents">
                                        <div class="um_tab_inner d-flex align-items-center justify-content-center">
                                            <div class="row mb-0">
                                                <div class="col m6 pl-0">
                                                    <input id="new_user_name" name="user_name" type="text" placeholder="User Name" requried>
                                                    <span class="add_group_error"></span>
                                                </div>
                                                <div class="col m6 pr-0 input-field m-0">
                                                    <input id="new_user_email" name="user_email" type="text" placeholder="Email ID">
                                                </div>
                                                <div class="col m6 input-field m-0 pl-0">
                                                    <select id="new_user_role" name="user_role" placeholder="">
                                                        <option value="" selected>Assign Role</option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">Auditor</option>
                                                        <option value="3">Reviewer</option>
                                                        <option value="4">Manager</option>
                                                    </select>
                                                </div>
                                                <div class="col m6 pr-0 input-field m-0">
                                                    <select class="new_user_group" name="user_group" placeholder="" multiple>
                                                        <option value="" disabled="">Assign groups</option>
                                                    </select>
                                                </div>
                                                <button type="button" id="create_user" class="create_user_btn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setup-footer d-flex flex-wrap justify-content-between align-items-center">
                            <a class="back_btn2" href="<?= site_url();?>//welcome-setup-skip/1">Back</a>
                            <a class="skip_btn" href="<?= site_url();?>/welcome-setup-skip/5">Skip</a>
                        </div>
                    </div>
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
                <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDPIDt4IcQXSQAhS-dyux-3ZNO4Lzx8H5E&libraries=places&callback=initAutocomplete" async defer></script> -->

    <script type="text/javascript">
        $(document).ready(function(){
            //Sliding effect 
            $(document).on('click', '.um_tab_item:not(.completed)', function(){
                return false;
                var target;
                target = '#'+$(this).attr("data-target");
                $(this).siblings().removeClass("active");
                $(this).prev().addClass("completed");
                $(this).addClass("active");
                $(target).siblings().removeClass("active");
                $(target).prev().addClass("completed");
                $(target).addClass("active");
            })
            // Start Add Delete Site data
            $(document).on('click', '.save_site',function(){
                var add_site = $('#add_site').val();
                var add_site_id = $('#add_site_id').val();                
                var data = {'add_site':((add_site != '') ? add_site : 'Default Site'),'status':1,'add':true}
                var response =site(data);
                if(response.status === "success"){
                    var lid = $('#sites_data .CT_row:last').attr('id');
                    var count = 0;
                    if(lid != undefined){
                        count = count+parseInt(lid.split('_')[1]);
                    }
                    count++;
                    var html = `
                                <div class="CT_row" id='site_`+count+`'>
                                    <div class="CT_td">`+add_site+`</div>
                                    <div class="CT_td action-sm"><a href="javascript:void(0)" class="delete_site CT_del_btn flaticon-delete-button" did='`+response.id+`'></a></div>
                                </div>
                            `;
                    $('#sites_data').append(html);
                    if(add_site != ''){
                        alertBox('Site added Successfully');
                    }
                    var site_data = postAjax('<?php echo site_url();?>/get-sites-data',{'status':'0'});
                    console.log(site_data);
                    var siteopthtml = '';
                    $.each(site_data,function(key,val){
                        var selected = ((key == 0)?'selected':'')
                        siteopthtml += "<option value='"+val.id+"' "+ selected+">"+val.site_name+"</option>";
                    });
                    $('.new_site_group').append(siteopthtml);
                    $("#um_group").find("select").formSelect();
                    activeTabs(0,1,'um_group');
                    
                    
                }
                else{
                    alertBox('Site name already exist');
                    // $('.add_site_error').html('Site name already exist').css('color','red');
                    return false;
                }
            });

            $(document).on('click', '.save_group', function(){
                var add_group = $('#add_group').val();
                var site_group = $('.new_site_group').val()
                var data        =   {'add_group':((add_group != '') ? add_group : 'Default Group'),'sites':site_group,'status':1,'add':true}
                var response    =   group(data);
                if(response.status === "success"){
                    var lid = $('#groups_data .CT_row:last').attr('id');
                    var gcount = 0;
                    if(lid != undefined){
                        gcount = gcount+parseInt(lid.split('_')[1]);
                    }
                    gcount++;
                    var html = `
                                <div class="CT_row" id='group_`+gcount+`'>
                                    <div class="CT_td">`+add_group+`</div>
                                    <div class="CT_td action-sm"><a href="javascript:void(0)" class="delete_group CT_del_btn flaticon-delete-button" did='`+response.id+`'></a></div>
                                </div>
                            `;
                    $('#groups_data').append(html);
                    if(add_group != ''){
                        alertBox('Group Created Successfully');
                    }
                    var group_data = postAjax('<?php echo site_url();?>/get-group-data',{'status':'0'});
                    var groupopthtml = '';
                    $.each(group_data,function(key,val){
                        var selected = ((key == 0)?'selected':'')
                        groupopthtml += "<option value='"+val.id+"' "+selected+">"+val.group_name+"</option>";
                    });
                    $('.new_user_group').append(groupopthtml);
                    $("#um_user").find("select").formSelect();
                    activeTabs(1,2,'um_user');
                }
                else{
                    alertBox('Group name already exist')
                    return false;
                }
            });

            $(document).on('click','#create_user',function(){
                var new_user_name = $('#new_user_name').val();
                var new_user_email = $('#new_user_email').val();
                var new_user_role = $('#new_user_role').val();
                var new_user_group = $('.new_user_group').val();
                //var new_user_site = $('#new_user_site').val();
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
                }
                // else if(new_user_group == ""){
                //     alertBox('Please select groups');                    
                //     return false;
                // }
                else{
                    var data = {
                        'name'  :new_user_name,
                        'email' :new_user_email,
                        'group' :((new_user_group != '')?new_user_group:''),
                        'role'  :new_user_role,
                        'method':'add'
                    }
                    var response = postAjax('<?php echo site_url();?>/add-user',data);
                    if(response.massage === "Email already exist"){
                        alertBox(response.massage);
                        return false
                    }
                    else{
                        alertBox(response.massage);
                        setTimeout(function(){ location.replace('<?php echo site_url();?>/welcome-setup/complated'); }, 1000);
                    }
                }
            });
            // $(document).on('click','.user_skip_btn',function(){
            //     var next = $(this).attr('next');
            //     var pre  = $(this).attr('pre');
            //     var nextclass = ((next === '1') ? 'um_group':'um_user');
            //     activeTabs(pre,next,nextclass)
            // });
        });

        function site(data){
            return postAjax("<?php echo site_url();?>/add-site",data);
        }
        function group(data){
            return postAjax("<?php echo site_url();?>/add-group",data);
        }

        
        function activeTabs(pre,next,divId){
            // $('.um_tab_item').removeClass('active')
            $('#um_site').addClass('completed').removeClass('active');
            $('.um_tab_item').eq(pre).addClass('completed');
            $('.um_tab_contents').eq(pre).removeClass('active').addClass('completed');
            $('.um_tab_item').eq(next).addClass('active')
            //$('#'+divId).addClass('active')
            $('#'+divId).addClass('active')
        }
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

    </script>
</html>