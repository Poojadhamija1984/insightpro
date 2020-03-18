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
                                    <li class="breadcrumb-item"><span>Alert Management</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR -->
                    <div class="error_section mb-12">
                    <?php
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message'); 
                        }
                    ?>
                    </div>
                    <!-- PAGE ERROR END -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title m-0">Alert List</h4>
                                    <div class="alert_temp_select">
                                        <span>Choose Template :</span>
                                        <select id="alertTemplate">
                                            <option value="">Choose Template</option>
                                            <?php 
                                                foreach ($template as $key => $value) {
                                                    echo "<option value='".$value->tb_name."'>".$value->tmp_name."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col s6 m4 input-field m-0">
                                        
                                        <select id="alertTemplate">
                                            <option value="">Choose Template</option>
                                            <?php 
                                                /*foreach ($template as $key => $value) {
                                                    echo "<option value='".$value->tmp_name."'>".$value->tb_name."</option>";
                                                }*/
                                            ?>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="alert_table_cont">
                                    <div class="CT alert">
                                        <div class="CT_head">
                                            <div class="CT_row">
                                                <div class="CT_th">S.No.</div>
                                                <div class="CT_th">Question</div>
                                                <div class="CT_th">Answer</div>
                                                <div class="CT_th">View Users</div>
                                                <div class="CT_th">Enable Alert</div>
                                                <div class="CT_th">Add Users</div>
                                            </div>
                                        </div>
                                        <div class="CT_body">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div id="alert_choose_modal" class="modal">
                                    <button type="button" class="users_modal_close modal-close"></button>
                                    <div class="modal-content">
                                        <h4>Notification</h4>
                                        <?php /*
                                        <div class="row">
                                            <div class="col s12">
                                                <ul class="tabs">
                                                    <li class="tab col s3"><a class="active" href="#test1">Sites</a></li>
                                                    <li class="tab col s3"><a  href="#test2">Groups</a></li>
                                                    <li class="tab col s3"><a href="#test4">Custom</a></li>
                                                </ul>
                                            </div>
                                            <div id="test1" class="col s12">
                                                <select multiple id="sites">
                                                    <option value="" disabled>Select Sites</option>
                                                    <?php 
                                                        foreach ($site as $key => $value) {
                                                            echo "<option value='".$value->s_id."'>".$value->s_name."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div id="test2" class="col s12">
                                                <select multiple id="group">
                                                    <option value="" disabled>Select Groups</option>
                                                    <?php 
                                                        foreach ($group as $key => $value) {
                                                            echo "<option value='".$value->g_id."'>".$value->g_name."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div id="test4" class="col s12">
                                                <input type="text" name="custome_emails" id="custome_emails" placeholder="Enter email comma seprated">
                                            </div>
                                        </div>
                                        */ ?>
                                        <div class="form col">
                                            <div class="row mb-0">
                                                <div class="col s12 m4">
                                                    <select multiple id="sites">
                                                        <option value="" disabled>Select Sites</option>
                                                        <?php 
                                                            foreach ($site as $key => $value) {
                                                                echo "<option value='".$value->s_id."'>".$value->s_name."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col s12 m4">
                                                    <select multiple id="group">
                                                        <option value="" disabled>Select Groups</option>
                                                        <?php 
                                                            foreach ($group as $key => $value) {
                                                                echo "<option value='".$value->g_id."'>".$value->g_name."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col s12 m4">
                                                    <input type="text" name="custome_emails" id="custome_emails" placeholder="Enter email comma seprated">
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col s12 hide " id="list_box">
                                                    <div class="input-field col s12 m4">
                                                        <label><input type="checkbox" class="checkAll" /><span>Select All</span></label>
                                                    </div>
                                                    <div class="input-field col s12 m8"><input type="text" id="search" onkeyup="myFunction()" placeholder="search emails"></div>
                                                    <span class="user_list" id="employeeList"></span>
                                                </div>
                                                <div class="col s12 msg_body_area">
                                                     <lable>Write alert description[Optional]</lable>       
                                                    <textarea class="materialize-textarea msg_body" placeholder="Write here"></textarea>
                                                    <input type="hidden" name="question_response_text" id="question_response_text" value="">
                                                    <input type="hidden" name="question_response_val" id="question_response_val" value="">
                                                </div>

                                        
                                            <button type="submit" class="modal-close alert_submit_btn">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <script>
            $(document).ready(function(){
                $('.modal').modal({dismissible:false});
                $(".notify_temp_opt").on("change", function(){
                    if($(this).val() == "custom") {
                        $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont").css("display", "block");
                    } else {
                        $(this). closest(".notify_temp_opt-cont").siblings(".notify_custom_opt-cont").css("display", "none");
                    }
                })
                $('#alertTemplate').change(function(){
                    var alertTemplate = $(this).val();
                    if(alertTemplate === ""){
                        alertBox('Please Select Template');
                        return false;
                    }
                    else{
                        var response = postAjax('<?php echo site_url();?>/template-details',{'temp_name':alertTemplate});
                        // console.log(response)
                        $('.CT_body').html(response)
                        $('.question_response').formSelect();
                        $('.notify_btn').each(function(index, obj){
                            //($(this).text()==="Notified")?$(this).css({'border':'1px solid green','color':'green'}):$(this).css('border','1px solid var(--custom-secondary-color);')
                            (($(this).text()==="Disable")?$(this).addClass('active'):'')
                        });
                    }
                });
                $('#sites').change(function(){
                    var sites = $('#sites').val();
                    if(sites.length > 0){
                        data={'sites':sites};
                        userList(data);
                    }
                    else{
                        // $('#list_box').removeClass('show').addClass('hide')
                        $('#employeeList').html('');
                    }
                });
                $('#group').change(function(){
                    var group = $('#group').val();
                    if(group.length > 0){
                        data={'group':group};
                        userList(data);
                    }
                    else{
                        // $('#list_box').removeClass('show').addClass('hide')
                        $('#employeeList').html('');
                    }
                });

                $(".checkAll").change(function () {
                    $(".user_email").prop('checked', $(this).prop("checked"));
                });

                $(document).delegate('.question_response','change',function(){

                    $(this).closest(".CT_row").find('.notify_btn').addClass(' modal-trigger open_modal').attr('href','#alert_choose_modal')
                    // alert($(this).val())
                }); 
                $(document).delegate('.notifyStatus','click',function(){
                    var status  = $(this).attr('value');
                    var id = $(this).attr('notifyResponseId');
                    if(status === "1"){
                        var res = notifyActive(id);
                        if(res ==="not updated"){
                            alertBox('Please set the Notification');
                            $(this).removeClass('active');
                            return false;
                        }
                        else{
                            $(this).attr('value','0')
                            alertBox('Notify Disable Successfully!');
                        }
                    }
                    else{
                        var res = notifyInactive(id);
                        if(res ==="not updated"){
                            $(this).removeClass('active')
                            alertBox('Please set the Notification');
                            return false;
                        }
                        else{
                            $(this).attr('value','1')
                            alertBox('Notify Enable Successfully!');
                        }
                    }
                    //console.log({'status':status,'id':id})
                    // alert($(this).val())
                });
                $(document).delegate('.notify_btn','click',function(){
                    
                    if($(this).closest(".CT_row").find('.options_value select option:selected').val() == ""){
                        alertBox('Please select response');
                        return false;
                    }

                    else{
                     //   alert("AA");
                        $("#sites,#groups option:selected").prop("selected", false);
                        // $('#sites,#groups').formSelect();
                        $('#list_box').addClass('hide');
                        $('.user_list').html('');
                        $('#sites,#groups').val('').formSelect();
                        $('#question_response_text,#question_response_val,#custome_emails,.msg_body').val('');
                        var question_response_txt = $(this).closest(".CT_row").find('.options_value select option:selected').text();
                        var question_response_val = $(this).closest(".CT_row").find('.options_value select option:selected').val();
                        $('#question_response_text').val(question_response_txt)
                        $('#question_response_val').val(question_response_val)
                        var res_details = postAjax('<?php echo site_url();?>/notify-response-details',{'response_id':question_response_val,'question_response_txt':question_response_txt});
                        if(res_details != ''){
                            var emails      = res_details.emails;
                            var site        = res_details.site;
                            var group       = res_details.group;
                            var email_body  = res_details.email_body;
                            var custome     = res_details.custome;
                            $('.msg_body').val(email_body);
                            $('#custome_emails').val(custome);
                            emails = emails.split(',');
                            //emails=''; //
                            site = site.split(',');
                            group = group.split(',');


                            if (site && site.length > 0) {
                               //  console.log('site is not empty.');
                                 $("#sites option[value='']").remove();   // remove blank value option
                            }

                            $.each(site,function(key,val){                                
                                $('#sites').find('option[value="'+val+'"]').prop('selected', true);
                            });

                            

                            $.each(group,function(key,val){
                                $('#group').find('option[value="'+val+'"]').prop('selected', true);
                            });
                            $('#sites,#groups').formSelect();
                            // var user_email_html = '<ul id="employeeList">';
                            var user_email_html = '';
                            $.each(emails,function(key,val){
                                /*user_email_html +=`<li>
                                    <label><input type='checkbox' class='user_email' onchange='check_uncheck()' value='`+val+`'><span>`+val+`</span></label>
                                </li>`;*/
                                user_email_html +=`<div class='col s4 target_list'>
                                    <label><input type='checkbox' class='user_email' onchange='check_uncheck()' value='`+val+`'><span>`+val+`</span></label>
                                </div>`;
                            });
                            // user_email_html +="</ul>";
                            $('#list_box').removeClass('hide').addClass('show');
                            $('.user_list').html(user_email_html);
                            $(".user_email").prop('checked', true);
                        }
                    }
                });

                $('.alert_submit_btn').click(function(){
                    var msg_body = $('.msg_body').val();
                    if(msg_body === ""){
                        alertBox('Please Enter Message');
                        return false;
                    }
                    else{
                        var user_email = $('.user_email').val();
                        var custome_emails = $('#custome_emails').val();
                        var sites = (($('#sites').val().length > 0)?$('#sites').val():'');
                        var group = (($('#group').val().length > 0)?$('#group').val():'');
                        var emailList = '';
                        $('.user_email:checked').each(function(){        
                            var values = $(this).val()+',';
                            emailList += values;
                        });
                        emailList = emailList.concat(custome_emails).replace(/,(?=\s*$)/, '');
                        if(emailList === ""){
                            alert('PLease enter user emails');
                            return false;
                        }
                        else{
                            var question_response_text = $('#question_response_text').val();
                            var question_response_val = $('#question_response_val').val();
                            var data = {
                                'user_email':emailList,
                                'opt_text':question_response_text,
                                'opt_val':question_response_val,
                                'site':sites,
                                'group':group,
                                'custome_emails':custome_emails,
                                'msg_body':msg_body
                            };
                            postAjax('<?php echo site_url();?>/notify-response',data);
                            
                            alertBox('Notify updated Successfully');
                        }
                    }
                })
                

            });
            function notifyActive(id) {
                return postAjax('<?php echo site_url();?>/notify-status',{'id':id,'status':'0'});
                //alert('Employee Inactive Successfully!');
            }
            function notifyInactive(id) {
                return postAjax('<?php echo site_url();?>/notify-status',{'id':id,'status':'1'});                
                //alert('Employee Active Successfully!');
            }
            function userList(data){
                var response = postAjax('<?php echo site_url();?>/user-list',data);
                $('#list_box').removeClass('hide').addClass('show');
                $('.user_list').html(response);
                if($('.checkAll').is(':checked')){
                    $(".checkAll").prop('checked', true);
                    $(".user_email").prop('checked', true);
                }
            }
            function check_uncheck(){
                if($(".user_email").length==$(".user_email:checked").length)
                    $(".checkAll").prop('checked', true);
                else
                    $(".checkAll").prop('checked', false);
            }
            function myFunction() {
                var input = document.getElementById("search");
                var filter = input.value.toLowerCase();
                var nodes = document.getElementsByClassName('target_list');
                for (i = 0; i < nodes.length; i++) {
                    if (nodes[i].innerText.toLowerCase().includes(filter)) {
                        nodes[i].style.display = "block";
                    } else {
                        nodes[i].style.display = "none";
                    }
                }
            }

        </script>
    </body>
</html>
