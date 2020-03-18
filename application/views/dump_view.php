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
                                <h3 class="page-title">Dump</h3>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR -->
                    <div class="error_section">
                    <?php
                        if($this->session->flashdata('message')){
                            echo $this->session->flashdata('message'); 
                        }
                    ?>
                    </div>
                    <!-- PAGE ERROR END -->
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-16">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4> 
                                <?=$this->session->flashdata('msg');?>
                                
                            <!-- <form class="form col">  -->
                                <?php $attributes = array("class" => "form col",'method'=>'POST');
                                echo form_open(site_url().'/dump', $attributes);
                                ?>
                                
                                    <div class="row mb-0">
                                        <!-- Start Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>">
                                            <label for="fromdate" class="">From</label>
                                        </div>
                                        <!-- End Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="todate" name="todate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>">
                                            <label for="todate" class="">To</label>
                                        </div>
                                        <!-- LOB -->
                                        <div class="input-field col s12 m4 l3">
                                            <select id="lob" name="lob" required > 
                                                <option value="">Select</option>
                                                <?php
                                                $sup_lob = explode('|||',$this->session->userdata('lob'));
                                                foreach($sup_lob as $key => $lob_value){
                                                    echo "<option value='{$lob_value}'>{$lob_value}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">LOB</label>
                                        </div>
                                         <!-- Channel -->
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="channels" name="channels"   required> 
                                                <option value="" >Select</option>
                                                <?php 
                                                $channels = channels();
                                                foreach($channels as $key=>$value){
                                                    echo '<option value="'.$key.'">'.ucwords($value).'</option>';
                                                }
                                                ?>
                                            </select>
                                            <label for="channels" class="">Channel Type</label>
                                        </div>
                                        <!-- Version -->
                                        <div class="input-field col s12 m4 l3 mb-0">
                                            <select id="form_version" name="form_version" required> 
                                                <option value="" >Select</option>
                                            </select>
                                            <label for="form_version" class="">Form Version</label>
                                        </div>
                                       
                                        <div class="input-field col s12 m4 l9 form_btns mb-0">
                                            <button type="submit" id="submit_btn"  class="btn cyan waves-effect waves-light right">
                                                <span>Download</span>
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <?php $this->load->view('common/footer_view') ?>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>               
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#submit_btn').click(function(e){//
            if($('#lob').val() != '' && $('#channels').val() != '' && $('#form_name').val() != '' && $('#form_version').val() != '')
            {
                setTimeout(() => {
                    location.reload();    
                }, 3000);
            }
        });
        // $('#submit_btn').click(function(e){
        //     e.preventDefault();
        //     var fromdate        = $('#fromdate').val();
        //     var todate          = $('#todate').val();
        //     var lob             = $('#lob').val();
        //     var channels        = $('#channels').val();
        //     var form_name       = $('#form_name').val();
        //     var form_version    = $('#form_version').val();
        //     if(fromdate == null){
        //         alert('Date from fields is mandatory');
        //         return false;
        //     }
        //     else if(todate == null){
        //         alert('Date to fields is mandatory');
        //         return false;
        //     }else if(lob == ''){
        //         alert('LOB fields is mandatory');
        //         return false;
        //     }else if(channels == ''){
        //         alert('Channels fields is mandatory');
        //         return false;
        //     }else if(form_name == ''){
        //         alert('Form Name fields is mandatory');
        //         return false;
        //     }else if(form_version == ''){
        //         alert('Form Version fields is mandatory');
        //         return false;
        //     }
        //     else{
        //          var Ajax_response  = postAjax('<?php echo site_url();?>/get-dump',{'fromdate':fromdate,'todate':todate,'lob':lob,'channels':channels,'form_name':form_name,'form_version':form_version});
        //         alert(Ajax_response);
        //     }
        // });
        $('#lob').change(function(){
            //$('#form_name,#form_version').html($("<option></option>").attr("value","").text('Select')).formSelect();
            var lob = $(this).val();
            //var lobtxt = $("#lob option:selected").text();  
            var ajaxRes = postAjax('<?php echo site_url();?>/Get-Versions',{'post_column_name':'lob','post_column_value':lob});
            $('#form_version , #channels').empty();
            $('#form_version,#channels').append($("<option></option>").attr("value",'').text('Select')); 
            $.each( ajaxRes.version, function( key, value ) {
                $('#form_version').append($("<option></option>").attr("value",ajaxRes.form_name+'_V_'+value.form_version).text(ajaxRes.form_name+' ( V'+value.form_version+'.0)')).formSelect();
             });
            $.each( ajaxRes.channels, function( key, value ) {
                $('#channels').append($("<option></option>").attr("value",value.channels).text(value.channels.substr(0,1).toUpperCase()+value.channels.substr(1))).formSelect();
            });
            //console.log(ajaxRes);
        });
        // $('#lob').change(function(){
        //     $('#form_name,#form_version').html($("<option></option>").attr("value","").text('Select')).formSelect();
        //     var lob = $(this).val();
        //     var ajaxRes = postAjax('<?php echo site_url();?>/Get-details',{'post_column_name':'lob','post_column_value':lob,'get_detail_column_name':'form_name'});
        //     //console.log(ajaxRes);
        //     // $('#form_name,#form_version').empty();
        //     //$('#form_name').append($("<option></option>").attr("value",'').text('Select')); 
        //     $.each( ajaxRes.get_column_name, function( key, value ) {
        //         $('#form_name').append($("<option></option>").attr("value",value.form_name).text(value.form_name)).formSelect(); 
        //     });
        //     $.each( ajaxRes.version, function( key, value ) {
        //         $('#form_version').append($("<option></option>").attr("value",value.form_version).text('V'+value.form_version+'.0')).formSelect();
        //     });
        // });
        // $('#form_name').change(function(){
        //     var form_name = $(this).val();
        //     var ajaxRes = postAjax('<?php echo site_url();?>/form-details',{'form_name':form_name});
        //     $('#lob,#form_version').empty();
        //     $('#lob').append($("<option></option>").attr("value",'').text('Select')); 
        //     $.each( ajaxRes.lob, function( key, value ) {
        //         $('#lob').append($("<option></option>").attr("value",value.lob).text(value.lob)).formSelect(); 
        //     });
        //     $.each( ajaxRes.version, function( key, value ) {
        //         $('#form_version').append($("<option></option>").attr("value",value.form_version).text('V'+value.form_version+'.0')).formSelect();
        //     });
        // });
    });
</script>
 