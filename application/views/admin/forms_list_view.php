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
                                <h3 class="page-title">Form</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item">From List</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right">
                                <!-- <a class="btn_common" href="<?php echo site_url()?>/forms-add">add form</a> -->
                                <a class="btn_common" href="<?php echo site_url()?>/create-form/<?=uniqid().rand(10,10000000);?>">create form</a>
                                <div class="csv_table_btns"></div>
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
                    <div class="table-section mt-16">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Form Details</h4>
                                <table class="csv_table stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="tbl_sno">SL.</th>
                                            <th>Form Name</th>
                                            <th>Version</th>
                                            <th>Lob</th>
                                            <th>Channel Type</th>
                                            <th class="center">Attributes No.</th>
                                            <th class="center tbl_action">Status</th>
                                            <th class="center tbl_action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($form_data)) { 
                                        $i=1;
                                        foreach($form_data as $key => $value){
                                    ?>
                                        <tr>
                                            <td class="tbl_sno"><?=$i?></td>
                                            <?php
                                            if(!empty($value['form_name']))
                                            {
                                                echo '<td><a target="_blank" href="'.site_url().'/form-view/'.$value['form_name'].'/'.$value['form_version'].'/view">'.ucfirst($value['form_name']).'</a></td>';
                                            }
                                            else {
                                                echo '<td><a href="javascript:void(0)">Undefined</a></td>';
                                            }
                                            ?>
                                            
                                            <td>V<?= (!empty($value['form_version']) ? ucfirst($value['form_version']) : "----") ?>.0</td>
                                            <td><?=(!empty($value['lob']) ? ucfirst($value['lob']) : "----") ?></td>
                                            <td><?=(!empty($value['channels']) ? ucfirst($value['channels']) : "----") ?></td>
                                            <td class="center"><?=(!empty($value['form_attributes']) ? $value['form_attributes'] : "----") ?></td>
                                            <td class="center"><button class="action_btn custom_switch switch <?=$value['form_status'] == 1?'active':''?>" data-form-id="<?=$value['form_id']?>" data-form-status="<?=$value['form_status']?>"><span class="lever"></span></button></td>
                                            <td class="center tbl_action">
                                                <a class="btn_edit" href="<?php echo site_url()?>/forms-edit/<?=$value['form_name']?>/<?=$value['form_version']?>/<?=$value['form_unique_id']?>" title="Edit"><i class="material-icons">edit</i></a>
                                                <a class="btn_del delete_form_btn" form_unique_id = "<?=$value['form_unique_id']?>"  href="javascript:void(0)" title="Del"><i class="flaticon-delete-button"></i></a>
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
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view') ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
                    
    </body>
</html>

<script type="text/javascript">

$(document).ready(function(){

    $(".delete_form_btn").click(function(){
        if(confirm("All form data will be deleted.  Are you sure want to delete. ?")){
            var form_unique_id = $(this).attr('form_unique_id');
            // var form_name = $(this).attr('form_name');
            // var form_version = $(this).attr('form_version');
           // $("#delete-button").attr("href", "query.php?ACTION=delete&ID='1'");
           //alert("HI DELETE THIS FROM "+form_name+form_version);
            $(this).attr("href", "<?php echo site_url()?>/forms-delete/"+form_unique_id);
        }
        else{
           //alert("not deleted");
            return false;
        }
    });

    $('#form_name').change(function(){
        var form_name = $(this).val();
        if(form_name == 'add_new')
        {
            $('#form_version').val('v'+1+'.0');
            $('#form_name').removeAttr('name');
            $('#campaigntxt1').attr("name","form_name");

        }
        else
        {
            $.ajax({
                url:'<?php echo site_url()?>/form-version/'+form_name,
                type:'GET',
                success:function(data){
                    $('#form_version').val('v'+(1+parseInt(data))+'.0');
                }
            });
        }
    });
    

    $('.action_btn').click(function(){
        var base_url = "<?php echo site_url();?>";
        var form_id = $(this).attr('data-form-id');
        var form_status = $(this).attr('data-form-status');
        if(form_status ==1)
        {
            form_status = 0;
        }
        else
        {
            form_status = 1;
        }

        /// postAjax() this function is define in custom.js is use for ajax post request
        var ajaxRes = postAjax('<?php echo site_url();?>/form-status',{'form_id':form_id,'form_status':form_status});
        $('.log_msg').removeClass('hide');
        if(ajaxRes =='Success')
        {
            if(form_status ==0){
                $(this).removeClass('active');
                $(this).attr('data-form-status',0);
                $('#log_msg').html('Success');           
            }
            else{
                $(this).addClass('active');
                $(this).attr('data-form-status',1);
                $('#log_msg').html('Success');
            }
           // alert(ajaxRes);
        }
        else{
           $('#log_msg').html('Error'); 
        }
        setTimeout(function(){ $('.log_msg').addClass('hide'); }, 3000);
        // alert(ajaxRes);
        // console.log('ajaxRes ........................');
        // console.log(ajaxRes)
        // console.log('ajaxRes ........................End');
    });
});

function nospaces(t){

if(t.value.match(/\s/g)){

alert('Sorry, you are not allowed to enter any spaces');

t.value=t.value.replace(/\s/g,'');

}

}

</script>

 