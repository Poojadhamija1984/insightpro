<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
    <body class="content_loading">
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php $this->load->view('common/sidebar_view') ?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <div class="page_loader">
                    <div id="loading-center-absolute">
                        <div class="object" id="object_four"></div>
                        <div class="object" id="object_three"></div>
                        <div class="object" id="object_two"></div>
                        <div class="object" id="object_one"></div>
                    </div>
                    <!-- <div id="loader"></div> -->
                </div>
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section mb-12">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Form</h3>
                                <ul class="breadcrumb-list">
                                   
                                    <li class="breadcrumb-item"><span>Form Update</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if($this->session->flashdata('success')){ ?>
                    <div class="error_section">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')){ ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="error_section_ajax" style="display: none">
                        <div class="page_error failure mb-12">
                            <div class="alert alert-info text-center error_div">
                            </div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <div class="table-section mt-16">
                        <div class="card">
                            <?php
                                $attributes = array("id" => "uploadformcreate", "name" => "uploadformcreate", "class" => "col old_ver_form");
                                echo form_open_multipart(site_url().'/forms-update', $attributes);
                            ?>
                            <input class="form_unique_id" name="form_unique_id" type="hidden" value="<?=$form_unique_id;?>">
                            <div class="card-content">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Form Details</h4>
                                    <a href="javascript:void(0)" class="version_btn btn_common"  new_version="<?=($last_form_version[0]['form_version'] + 1)?>" >New Version</a>
                                    <input type="hidden" name="old_form_version" value="<?=$current_form_version;?>"/>
                                </div>
                                <div class="col">
                                    <div class="row mb-0 d-flex flex-wrap">
                                        <div class="input-field col s12 m4">
                                            <input id="form_version" name="form_version" value="V<?=$form_info[0]['form_version'];?>.0" placeholder="e.g. Form Version"  type="text" readonly required>
                                            <label for="form_version" class="">Form Version</label>
                                            <span class="field_error"><?php echo (!empty(form_error('form_version')) ?  form_error('form_version'):'' );?></span>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <input id="form_name" name="form_name" value="<?=ucfirst($form_info[0]['form_name']);?>" placeholder=""  type="text" readonly required>
                                            <label for="form_name" class="">Form Name</label>
                                            <span class="field_error"><?php echo (!empty(form_error('form_name')) ?  form_error('form_name'):'' );?></span>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <input id="form_attributes" name="form_attributes" value="<?=$form_info[0]['form_attributes'];?>" placeholder="Max 30 attributes" title="max 30 attribtes allowed"  type="number" max="30" min="10" readonly required>
                                            <label for="form_attributes" class="">Attributes</label>
                                        </div>
                                        
                                        <div class="input-field col s12 m4">
                                            <select id="lob" name="lob" required > 
                                                <?php 
                                                //foreach($lob as $lob){
                                                    echo '<option value="'.$form_info[0]['lob'].'" selected>'.ucwords($form_info[0]['lob']).'</option>';
                                                //}
                                                ?>
                                            </select>
                                            <label for="lob" class="">Lob</label>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <select id="channels" name="channels"   required > 
                                                <?php 
                                                echo '<option value="'.$form_info[0]['channels'].'" selected>'.ucwords($form_info[0]['channels']).'</option>';
                                                // foreach($channels as $key=>$value){
                                                //     if($key == $form_info[0]['channels'])
                                                //     {
                                                //         echo '<option value="'.$key.'" selected>'.ucwords($value).'</option>';
                                                //     }
                                                //     else {
                                                //         echo '<option value="'.$key.'">'.ucwords($value).'</option>';
                                                //     }
                                                // }
                                                ?>
                                            </select>
                                            <label for="channels" class="">Channel Type</label>
                                        </div>
                                        
                                        <div class="input-field col s12 m4" readonly required>
                                            <input id="pass_rate" name="pass_rate" value="<?=$form_info[0]['pass_rate'];?>" placeholder="e.g. Pass Rate"  type="number" min="0" required  readonly> 
                                            <label for="pass_rate" class="">Pass Rate</label>
                                            <span class="field_error"><?php echo (!empty(form_error('pass_rate')) ?  form_error('pass_rate'):'' );?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="attributes-card-header mt-12">
                                    <table class="attributes_table">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Attributes</th>
                                                <th class="rating-field">Rating<a class="modal-trigger" href="#rating_modal">Custom</a></th>
                                                <th>Weightage</th>
                                                <th>Scorable</th>
                                                <th>KPI Metrics</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="attributes-card-content">
                                    
                                    <?php
                                   $table_data = []; $html_data = '';
                                   $cat_flag = 0; $flag = 0;$check_cat = '';$att_flag = 0;$kpi_flag = 0;
                                    foreach($form_data as $each_data){
                                        $rating_array = explode('|',$each_data['rating']);
                                        $rating_attr_name_array = explode('|',$each_data['rating_attr_name']);
                                        // echo '<pre>';
                                        // print_r($rating_attr_name_array);
                                        $scorable_array = explode('|',$each_data['scorable']);
                                        $kpi_metrics = explode('|',$each_data['kpi_metrics']);
                                        if($check_cat != $each_data['category'])
                                        {
                                            $cat_flag++; $check_cat = $each_data['category'];
                                            $att_flag = 0;
                                            $kpi_flag = 0;
                                        }
                                        // echo "<pre>";
                                        // print_r($last_form_version);die;
                                        $html_row_data = '<tr>
                                            <td>
                                                <input type="text" name="category[cat'.$cat_flag.'][]" id="" placeholder="Category" value="'.$each_data['category'].'" readonly required>
                                            </td>
                                            <td>
                                                <textarea name="attribute[cat'.$cat_flag.'][]" id="" class="materialize-textarea" placeholder="Attribute" required>'.$each_data['attribute'].'</textarea>
                                            </td>
                                            <td class="rating-field">
                                                <select class="custom_rating" name="rating[cat'.$cat_flag.']['.$att_flag++.'][]" id="" multiple>
                                                    <option value="YES" selected >'.(!empty($rating_attr_name_array[0]) ? $rating_attr_name_array[0] : 'YES').'</option>
                                                    <option value="NO" selected >'.(!empty($rating_attr_name_array[1]) ? $rating_attr_name_array[1] : 'NO').'</option>
                                                    <option value="NA" '. ((in_array("NA", $rating_array)) ? "selected" : "") .' >'.(!empty($rating_attr_name_array[2]) ? $rating_attr_name_array[2] : 'NA').'</option>
                                                    <option value="FATAL" '.((in_array("FATAL", $rating_array))? "selected":"").'>'.(!empty($rating_attr_name_array[3]) ? $rating_attr_name_array[3] : 'FATAL').'</option>
                                                </select>
                                            </td>
                                            <td class="weightage">
                                                <input type="text" name="weightage[cat'.$cat_flag.'][]" value="'.$each_data['weightage'].'"  placeholder="eg: 3" required >
                                            </td>
                                            <td>
                                                <select name="scorable[cat'.$cat_flag.'][]" id="" class="scorable">
                                                    <option value="yes" '.((in_array("yes", $scorable_array))? "selected":"").'>YES</option>
                                                    <option value="no" '.((in_array("no", $scorable_array))? "selected":"").'>No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kpi_metrics[cat'.$cat_flag.']['.$kpi_flag++.'][]" id="" multiple>
                                                    <option value=""'. ((in_array("", $kpi_metrics)) ? "selected" : "") .'  disabled>Select</option>
                                                    <option value="1" '. ((in_array("1", $kpi_metrics)) ? "selected" : "") .'>CSAT</option>
                                                    <option value="2" '. ((in_array("2", $kpi_metrics)) ? "selected" : "") .'>RESO</option>
                                                    <option value="3" '. ((in_array("3", $kpi_metrics)) ? "selected" : "") .'>SALE</option>
                                                    <option value="4" '. ((in_array("4", $kpi_metrics)) ? "selected" : "") .'>RETR</option>
                                                </select>
                                                <button class="del_row" ></button>
                                            </td>
                                        </tr>';


                                        if (array_key_exists($each_data['category'],$table_data))
                                        {
                                            $table_data[$each_data['category']]['table_row_data'] .= $html_row_data;
                                            $table_data[$each_data['category']]['table_end'] = '</tbody></table>
                                                    <div class="text-right">
                                                        <button type="button" class="add_attributes" cat_flag="'.$cat_flag.'" att_flag="'.($att_flag).'" kpi_flag="'.($kpi_flag).'" cat_name="'.$each_data['category'].'" new_version="'.($last_form_version[0]['form_version'] + 1).'"><i class="material-icons">add</i> <span>Add New</span></button>
                                                    </div>
                                                </div>';
                                        }
                                        else
                                        {
                                            $table_data[$each_data['category']]['table_start'] =  '<div class="card-content-category"><table class="attributes_table"><tbody>';
                                            $table_data[$each_data['category']]['table_row_data'] = $html_row_data;
                                            $table_data[$each_data['category']]['table_end'] = '</tbody></table>
                                                    <div class="text-right">
                                                        <button type="button" class="add_attributes" cat_flag="'.$cat_flag.'" att_flag="'.($att_flag).'" kpi_flag="'.($kpi_flag).'" cat_name="'.$each_data['category'].'" new_version="'.($last_form_version[0]['form_version'] + 1).'"><i class="material-icons">add</i> <span>Add New</span></button>
                                                    </div>
                                                </div>';
                                               
                                        }
                                    }
                                    foreach($table_data as $each_table_data)
                                    {
                                        echo $each_table_data['table_start'];
                                        echo $each_table_data['table_row_data'];
                                        echo $each_table_data['table_end'];
                                    }

                                    ?>
                                </div>
                                <div class="mt-12 form_btns text-right">
                                    <button type="button" class="add_more_btn btn grey waves-effect waves-light" cat_flag_add_more_btn="<?=$cat_flag;?>"  new_version="<?= ($last_form_version[0]['form_version'] + 1);?>">
                                        <span>Add More</span>
                                    </button>
                                    <button type="submit" class="btn cyan waves-effect waves-light">
                                        <span>Submit</span>
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                            <?php echo form_close();?><!-- </form> -->
                        </div>
                    </div>
                    <!-- Modal Structure -->
                    <div id="rating_modal" class="modal rating_modal">
                        <div class="modal-content">
                            <h4 class="gradient-45deg-purple-deep-orange">Rating Customization <a href="javascript:void(0)" class="modal-close"></a></h4> 
                            <!-- <form class="form col"> -->
                            <?php
                                $attributes = array("name" => "custon_reating", "class" => "form col", "id"=>"rating_form");
                                echo form_open_multipart(site_url().'/custom-rating-update', $attributes);
                               // echo form_open_multipart(site_url().'/forms-update', $attributes);
                            ?>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input class="form_unique_id" name="form_unique_id" type="hidden" value="<?=$form_unique_id;?>">
                                        <input id="form_version_reating" name="form_version_reating" type="hidden" value="<?=$form_info[0]['form_version'];?>">
                                        
                                        <input placeholder="Rating value" class="rating_attr" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">Yes</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" class="rating_attr" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">No</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" class="rating_attr" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">Fail</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" class="rating_attr" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">NA</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class='rating_msg'></span>
                                    <button type="submit" id="custum_rating_btn" class="btn cyan waves-effect waves-light ">
                                        <span>Save</span>
                                    </button>
                                </div>
                            <?php echo form_close();?><!-- form modal </form> -->
                        </div>
                    </div>
                    <!-- End Modal Structure -->
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

    var rating_attr_name = '<?php echo (!empty($form_info[0]["rating_attr_name"])?$form_info[0]["rating_attr_name"]:"YES|NO|FATAL|NA")?>';
    rating_attr_name = rating_attr_name.split("|");
    rating_opt(rating_attr_name);
    
    $('#custum_rating_btn').click(function(e){
        e.preventDefault();
        $('#custum_rating_btn').prop('disabled',true)
        //console.log($('#rating_form').serialize());
        var response = postAjax('<?php echo site_url();?>/custom-rating-update',$('#rating_form').serialize());
        //console.log(response);
        $('#custum_rating_btn').prop('disabled',false);
        if(response.status === "success"){
            $('.rating_msg').html('Rating customized successfully  ....').css('color',"green");
        }else{
            $('.rating_msg').html('Rating not customize try again  ....').css('color',"red");
        }
        rating_attr_name = response.rating_attr_name;
        rating_attr_name = rating_attr_name.split("|");
        rating_opt(rating_attr_name);
        setTimeout(function(){
            $('#rating_form')[0].reset();
            $('.rating_msg').html('');
        },2000);
    });

    $('#rating_modal').modal({dismissible:false});
    $(document).on('change', '.scorable', function() {
        var attr = $(this).closest("td").prev('td').find('input').attr('required');
        if($(this).val() == 'no'){
            if(typeof attr !== undefined && attr !== false) {
                $(this).closest("td").prev('td').find('input').prop('required',false);
            }
        }
        if($(this).val() == 'yes'){
            if(typeof attr !== undefined && attr !== false) {
                $(this).closest("td").prev('td').find('input').prop('required',true);
            }
        }     
    });

    $('.scorable').each(function() {
        var attr = $(this).closest("td").prev('td').find('input').attr('required');
        if($(this).val() == 'no'){
            if(typeof attr !== undefined && attr !== false) {
                $(this).closest("td").prev('td').find('input').prop('required',false);
            }
        }
        if($(this).val() == 'yes'){
            if(typeof attr !== undefined && attr !== false) {
                $(this).closest("td").prev('td').find('input').prop('required',true);
            }
        }     
    });

    // for non alocate lob in droup down
    //  var ajaxResLob = postAjax('/form-details',{'form_name':'add_new_form'});
    //     //console.log(ajaxResLob);
    //     //$('#lob').empty();
    //     //$('#lob').append($("<option>select</option>")).formSelect(); 
    //     $('#lob').formSelect(); 
    //     $.each( ajaxResLob.lob, function( key, value ) {
    //         //alert(value.lob);
    //         $('#lob').append($("<option></option>").attr("value",value.lob).text(value.lob)).formSelect(); 
    //     });

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
    $(document).on("click", ".del_row", function(){
        //$('#form_version').val('V'+$(this).attr('new_version')+'.0');
        $('#form_attributes').val($('#form_attributes').val() - 1);
        if($(this).closest("tr").is(':last-child') && $(this).closest("tr").is(':first-child')) {
            $(this).closest(".card-content-category").remove();
        } else {
            $(this).closest("tr").remove();
        }
    })
    
    
    $(document).on("click", ".add_more_btn", function(){
        if(parseInt($('#form_attributes').val()) >= 30){
            alert("max no of attribute could be 30");   return flase;
        }
        var cat_flag_add_more_btn = 1 + parseInt($(this).attr('cat_flag_add_more_btn'));
        $(this).attr('cat_flag_add_more_btn',cat_flag_add_more_btn);
       // alert($(this).attr('cat_flag_add_more_btn'));
        var new_version = $(this).attr('new_version');
        //$('#form_version').val('V'+new_version+'.0');
        $('#form_attributes').val(parseInt($('#form_attributes').val()) + 1);
        
        var complete_newsection = `<div class="card-content-category">
                                <table class="attributes_table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="category[cat`+cat_flag_add_more_btn+`][]" id="" placeholder="Category new_more" value="" required>
                                            </td>
                                            <td>
                                                <textarea name="attribute[cat`+cat_flag_add_more_btn+`][]" id="" class="materialize-textarea" placeholder="Attribute" required></textarea>
                                            </td>
                                            <td class="rating-field">
                                                <select class="custom_rating" name="rating[cat`+cat_flag_add_more_btn+`][0][]" id="" multiple>
                                                    <option value="YES" selected >YES</option>
                                                    <option value="NO" selected >NO</option>
                                                    <option value="FATAL">FATAL</option>
                                                    <option value="NA">NA</option>
                                                </select>
                                            </td>
                                            <td class="weightage">
                                                <input type="text" name="weightage[cat`+cat_flag_add_more_btn+`][]"  placeholder="eg: 3" required>
                                            </td>
                                            <td>
                                                <select name="scorable[cat`+cat_flag_add_more_btn+`][]" id="" class="scorable">
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kpi_metrics[cat`+cat_flag_add_more_btn+`][0][]" id="" multiple>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="1" >CSAT</option>
                                                    <option value="2" >RESO</option>
                                                    <option value="3" >SALE</option>
                                                    <option value="4" >RETR</option>
                                                </select>
                                                <button class="del_row"></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-right">
                                    <button type="button" class="add_attributes" cat_flag="`+cat_flag_add_more_btn+`" att_flag="1" kpi_flag="1" cat_name=""><i class="material-icons">add</i> <span>Add New</span></button>
                                </div>
                            </div>`; 
                           
        $(".attributes-card-content").append(complete_newsection).find("select").formSelect();
         rating_opt(rating_attr_name);
        
    })
    $(document).on("click", ".add_attributes", function(){
        // if(parseInt($('#form_attributes').val()) >= 30){
        //     alert("max no of attribute could be 30");    return  false;
        // }
        var cat_name = $(this).attr('cat_name');
        if (cat_name=="" || cat_name==null) {
            cat_name = $(this).closest(".card-content-category").find("tr:first-child td:first-child input").val();
        }
        var new_version = $(this).attr('new_version');
        var cat_flag = $(this).attr('cat_flag');
        var att_flag = $(this).attr('att_flag');
        $(this).attr('att_flag',(parseInt(att_flag)+1))
        var kpi_flag = $(this).attr('kpi_flag');
        $(this).attr('kpi_flag',(parseInt(kpi_flag)+1))
        //alert(att_flag);
        //$('#form_version').val('V'+new_version+'.0');
        $('#form_attributes').val(parseInt($('#form_attributes').val()) + 1);
        // RRR
       // alert(cat_name);
        var new_row = `<tr>
                        <td>
                            <input type="text" name="category[cat`+cat_flag+`][]" value="`+cat_name+`" id="" placeholder="Category"  readonly required>
                        </td>
                        <td>
                            <textarea name="attribute[cat`+cat_flag+`][]" id="" class="materialize-textarea" placeholder="Attribute" required></textarea>
                        </td>
                        <td class="rating-field">
                            <select class="custom_rating" name="rating[cat`+cat_flag+`][`+att_flag+`][]" id="" multiple>
                                <option value="YES" selected >YES</option>
                                <option value="NO" selected >NO</option>
                                <option value="FATAL">FATAL</option>
                                <option value="NA">NA</option>                                
                            </select>
                        </td>
                        <td class="weightage">
                            <input type="text" name="weightage[cat`+cat_flag+`][]"  placeholder="eg: 3" required >
                        </td>
                        <td>
                            <select name="scorable[cat`+cat_flag+`][]" id="" class="scorable">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                        <td>
                            <select name="kpi_metrics[cat`+cat_flag+`][`+kpi_flag+`][]" id="" multiple>
                                <option value="" selected disabled>Select</option>
                                <option value="1" >CSAT</option>
                                <option value="2" >RESO</option>
                                <option value="3" >SALE</option>
                                <option value="4" >RETR</option>
                            </select>
                            <button class="del_row"></button>
                        </td>
                    </tr>`;
        $(this).parents(".card-content-category").find("tbody").append(new_row).find("select").formSelect();
         rating_opt(rating_attr_name);
        //$(this).parents(".card-content-category").find("select").formSelect();
    })
    $(".version_btn").click(function(){
        var ajaxRes = postAjax('<?php echo site_url();?>/Sub-varsion-count-check');
        if(ajaxRes != 'success'){
            $('.error_section_ajax').show();
            $('.error_div').html(ajaxRes);
            return false;
        }
        else{
            if($(this).closest("#uploadformcreate").hasClass("old_ver_form")) {
                $(this).closest("#uploadformcreate").removeClass("old_ver_form").addClass("new_ver_form");
                $(this).text("Old Version");
                var new_version = $(this).attr('new_version');
                $('#form_version').val('V'+new_version+'.0');
                $('#form_version_reating').val(new_version);

                var form_unique_id = '<?php echo uniqid().rand(10,10000000) ?>';
                $('.form_unique_id').val(form_unique_id);
                

                //$('#pass_rate').removeAttr('readonly');
                // for non alocate lob in droup down
            //  var ajaxResLob = postAjax('<?php echo site_url();?>/form-details',{'form_name':'add_new_form'});
            //     //console.log(ajaxResLob);
            //     //$('#lob').empty();
            //     //$('#lob').append($("<option>select</option>")).formSelect(); 
            //     $('#lob').formSelect(); 
            //     $.each( ajaxResLob.lob, function( key, value ) {
            //         //alert(value.lob);
            //         $('#lob').append($("<option></option>").attr("value",value.lob).text(value.lob)).formSelect(); 
            //     });
            } else {
                location.reload(true);
            }
        }
    });

    {
        var select_count = 0;
        $(".bi_attr_class select").each(function(){
            if($(this).val() != "" || $(this).val() != null) {
                select_count++;
            }
        })
        if(select_count >= 4) {
            $(".bi_attr_class select").each(function(){
                if($(this).val() == "" || $(this).val() == null) {
                    $(this).attr('disabled',"true").formSelect();
                }
            })
        }
    }
});

function nospaces(t){
    if(t.value.match(/\s/g)){
        alert('Sorry, you are not allowed to enter any spaces');
        t.value=t.value.replace(/\s/g,'');
    }
}
function rating_opt(rating_attr_name){
    $.each(rating_attr_name,function(key,val){
        if(key === 0)
            $('.custom_rating option[value=YES]').text(val);
        if(key === 1)
            $('.custom_rating option[value=NO]').text(val);
        if(key === 3)
            $('.custom_rating option[value=NA]').text(val);
        if(key === 2)
            $('.custom_rating option[value=FATAL]').text(val);
        $('.custom_rating').formSelect();
    });
}
</script>

 