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
                                <h3 class="page-title">Form </h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Form Create</span></li>
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
                    <!-- BREADCRUMB SECTION END -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <?php
                                $attributes = array("id" => "uploadformcreate", "name" => "uploadformcreate", "class" => "col");
                                echo form_open_multipart(site_url().'/create-form-save', $attributes);
                               // echo form_open_multipart(site_url().'/forms-update', $attributes);
                            ?>
                            <div class="card-content">
                                
                                <div class="col">
                                    <div class="row mb-0 d-flex flex-wrap">
                                        
                                        <div class="input-field col s12 m4">
                                            <input class="" name="form_unique_id" type="hidden" value="<?=$form_unique_id;?>">
                                            <input id="form_name" name="form_name" placeholder="e.g.  Form_qa" value="<?php echo (!empty($form_unique_id_data->form_name) ?  $form_unique_id_data->form_name :'' );?>"  type="text" onkeyup="nospaces(this)" title="space not allowed" required>
                                            <label for="form_name" class="">Form Name</label>
                                            <span class="field_error form_name"><?php echo (!empty(form_error('form_name')) ?  form_error('form_name'):'' );?></span>
                                        </div>
                                        
                                        
                                        <div class="input-field col s12 m4">
                                            <select id="lob" name="lob" required >
                                                <option value="">Select</option> 
                                                <?php 
                                                foreach($lob as $lob){
                                                    $selected = !empty($form_unique_id_data->lob) && $lob == $form_unique_id_data->lob ? "selected" :'';
                                                   echo '<option value="'.$lob.'" '.$selected.'>'.ucwords($lob).'</option>';
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">Lob</label>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <select id="channels" name="channels"   required > 
                                                <?php 
                                                echo '<option value="">Select</option>';
                                                foreach($channels as $key=>$value){
                                                    $selected = !empty($form_unique_id_data->channels) && $key == $form_unique_id_data->channels ? "selected" :'';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.ucwords($value).'</option>'; 
                                                }
                                                ?>
                                            </select>
                                            <label for="channels" class="">Channel Type</label>
                                        </div>
                                        <div class="input-field col s12 m4"  required>
                                            <input id="pass_rate" name="pass_rate" value="<?php echo (!empty($form_unique_id_data->pass_rate) ?  $form_unique_id_data->pass_rate :'' );?>" placeholder="e.g. Pass Rate"  type="number" min="0" required > 
                                            <label for="pass_rate" class="">Pass Rate</label>
                                            <span class="field_error"><?php echo (!empty(form_error('pass_rate')) ?  form_error('pass_rate'):'' );?></span>
                                        </div>
                                        <div class="input-field col s12 m4">
                                            <input id="form_version" name="form_version" value="v1.0" placeholder="e.g. Form Version"  type="text" readonly required>
                                            <label for="form_version" class="">Form Version</label>
                                            <span class="field_error"><?php echo (!empty(form_error('form_version')) ?  form_error('form_version'):'' );?></span>
                                        </div>
                                        
                                        <div class="input-field col s12 m4">
                                            <input id="form_attributes" name="form_attributes" value="1" placeholder="Max 30 attributes" title="max 30 attribtes allowed"  type="number" max="30" min="10" readonly required>
                                            <label for="form_attributes" class="">Attributes</label>
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
                                    <div class="card-content-category">
                                    <?php 
                                    // echo '<pre>';
                                    // print_r($rating_attr_details);
                                    // foreach($rating_attr_details as $rating_options)
                                    // {
                                    //     print_r($rating_options);

                                    // }
                                    // echo '</pre>';
                                    ?>
                                        <table class="attributes_table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="category[cat1][]"  id="" placeholder="Category" value="" required/>
                                                    </td>
                                                    <td>
                                                        <textarea name="attribute[cat1][]" id="" class="materialize-textarea" placeholder="Attribute" required></textarea>
                                                    </td>
                                                    <td class="rating-field">
                                                        <select class="custom_rating" name="rating[cat1][0][]" id="rating0" multiple>
                                                        </select>
                                                    </td>
                                                    <td class="weightage">
                                                        <input type="text" name="weightage[cat1][]"  min="0"  id="" placeholder="eg: 3" required>
                                                    </td>
                                                    <td>
                                                        <select name="scorable[cat1][]" id="scorable0" class="scorable">
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="kpi_metrics[cat1][0][]" id="" multiple>
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
                                            <button type="button" class="add_attributes" cat_flag="1" att_flag="1" kpi_flag="1" cat_name=""><i class="material-icons">add</i> <span>Add New</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-12 form_btns text-right">
                                    <button type="button" class="add_more_btn btn grey waves-effect waves-light" cat_flag_add_more_btn="1"  new_version="">
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
                                echo form_open_multipart(site_url().'/custom-rating-save', $attributes);
                               // echo form_open_multipart(site_url().'/forms-update', $attributes);
                            ?>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input class="" name="form_unique_id" type="hidden" value="<?=$form_unique_id;?>">
                                        <!-- <input class="form_version_reating" name="form_version_reating" type="hidden" value="1"> -->
                                        <input class="form_name_rating" name="form_name_rating" type="hidden" value="">
                                        <input class="lob_rating" name="lob_rating" type="hidden" value="">
                                        <input class="channel_rating" name="channel_rating" type="hidden" value="">
                                        <input class="passrate_rating" name="passrate_rating" type="hidden" value="">
                                        <input placeholder="Rating value" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">Yes</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">No</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" name="rating_attr[]" type="text">
                                    </div>
                                    <div class="input-field col s5 m-0">
                                        <label class="fixed_table">Fail</label>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="input-field col s7 m-0">
                                        <input placeholder="Rating value" name="rating_attr[]" type="text">
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
var rating_details = JSON.parse('<?php echo json_encode(!empty($rating_attr_details)?$rating_attr_details:[]);?>');
var rating_opt = '';
var scorable_opt = '';
var rating_count = 1;
var score_count = 1;
var rating_attr_name = '';
if(Object.keys(rating_details).length > 0){
    $.each(rating_details,function(key,val){
        var sel = ((key === "YES" || key === "NO" )?'selected':'');
        // if(key === "YES" || key === "NO" ){
        //     scorable_opt += " <option value='"+key.toLowerCase()+"'>"+val+"</option>";
        // }
        rating_opt += " <option value='"+key+"' "+sel+">"+val+"</option>";
    });
}else{
    rating_opt += " <option value='YES' selected>YES</option>";
    rating_opt += " <option value='NO' selected>NO</option>";
    rating_opt += " <option value='NA'>NA</option>";
    rating_opt += " <option value='FATAL'>FATAL</option>";
    // scorable_opt += " <option value='yes'>Yes</option>";    
    // scorable_opt += " <option value='no'>No</option>";    
}
$('#rating0').append(rating_opt);
scorable_opt += " <option value='yes'>Yes</option>";    
scorable_opt += " <option value='no'>No</option>"; 
$('#scorable0').append(scorable_opt);
$(document).ready(function(){
    $('#custum_rating_btn').click(function(e){
        e.preventDefault();
        $('#custum_rating_btn').prop('disabled',true)
        console.log($('#rating_form').serialize());
        var response = postAjax('<?php echo site_url();?>/custom-rating-save',$('#rating_form').serialize());
        $('#custum_rating_btn').prop('disabled',false);
        if(response.status === "success"){
            $('.rating_msg').html('Rating customized successfully  ....').css('color',"green");
        }else{
            $('.rating_msg').html('Rating not customize try again  ....').css('color',"red");
        }
        rating_attr_name = response.rating_attr_name;
        rating_attr_name = rating_attr_name.split("|");
        rating_opt_new(rating_attr_name);
        setTimeout(function(){
            $('#rating_form')[0].reset();
            $('.rating_msg').html('');
        },2000);
    });

    $('#lob').change(function(){
        $('.lob_rating').val($(this).val());
    });
    $('#channels').change(function(){
        $('.channel_rating').val($(this).val());
    });
    $('#pass_rate').keyup(function(){
       // alert($(this).val());
        $('.passrate_rating').val($(this).val());
    });

    $('#rating_modal').modal({dismissible:false});
    var count = 0;
    $(document).on("change", ".rating_select", function(){
        var current_value = $(this).val();
        var flag = 0;
        $(".rating_select").each(function(index){
            if ($(this).has('option:selected')){
                if(current_value === $(this).val()){
                    flag++;
                }
                if(flag > 1){
                    flag == 0;
                    $(this).prop('selectedIndex',0).formSelect();
                    alert('Attribute must be unique');
                    return false;
                }
            }
        });       
    });
    
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
       // $('#form_version').val('V'+$(this).attr('new_version')+'.0');
        $('#form_attributes').val($('#form_attributes').val() - 1);
        if($(this).closest("tr").is(':last-child') && $(this).closest("tr").is(':first-child')) {
            $(this).closest(".card-content-category").remove();
        } else {
            $(this).closest("tr").remove();
        }
    });
    
    
    $(document).on("click", ".add_more_btn", function(){
        if(parseInt($('#form_attributes').val()) >= 30){
            alert("max no of attribute could be 30");   return flase;
        }
        var cat_flag_add_more_btn = 1 + parseInt($(this).attr('cat_flag_add_more_btn'));
        $(this).attr('cat_flag_add_more_btn',cat_flag_add_more_btn);
       // alert($(this).attr('cat_flag_add_more_btn'));
        //var new_version = $(this).attr('new_version');
        //$('#form_version').val('V'+new_version+'.0');
        $('#form_attributes').val(parseInt($('#form_attributes').val()) + 1);
        
        var complete_newsection = `<div class="card-content-category">
                                <table class="attributes_table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="category[cat`+cat_flag_add_more_btn+`][]"  id="" placeholder="Category new_more" value="" required>
                                            </td>
                                            <td>
                                                <textarea name="attribute[cat`+cat_flag_add_more_btn+`][]" id="" class="materialize-textarea" placeholder="Attribute" required></textarea>
                                            </td>
                                            <td class="rating-field">
                                                <select class="custom_rating" name="rating[cat`+cat_flag_add_more_btn+`][0][]" id="rating`+rating_count+`" multiple>
                                                    `+rating_opt+`
                                                </select>
                                            </td>
                                            <td class="weightage">
                                                <input type="text" name="weightage[cat`+cat_flag_add_more_btn+`][]" min="0"  id="" placeholder="eg: 3" required>
                                            </td>
                                            <td>
                                                <select name="scorable[cat`+cat_flag_add_more_btn+`][]" id="scorable`+score_count+`" class="scorable">`+scorable_opt+`</select>
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
        rating_count++;
        score_count++;
        $(".attributes-card-content").append(complete_newsection).find("select").formSelect();
        rating_opt_new(rating_attr_name);        
    });
    $(document).on("click", ".add_attributes", function(){
        // if(parseInt($('#form_attributes').val()) >= 30){
        //     alert("max no of attribute could be 30");    return  false;
        // }
        var cat_name = $(this).attr('cat_name');
        if (cat_name=="" || cat_name==null) {
            cat_name = $(this).closest(".card-content-category").find("tr:first-child td:first-child input").val();
        }
       // var new_version = $(this).attr('new_version');
        var cat_flag = $(this).attr('cat_flag');
        var att_flag = $(this).attr('att_flag');
        $(this).attr('att_flag',(parseInt(att_flag)+1))
        var kpi_flag = $(this).attr('kpi_flag');
        $(this).attr('kpi_flag',(parseInt(kpi_flag)+1))
        //alert(att_flag);
       // $('#form_version').val('V'+new_version+'.0');
        $('#form_attributes').val(parseInt($('#form_attributes').val()) + 1);
        
       // alert(cat_name);
        var new_row = `<tr>
                        <td>
                            <input type="text" name="category[cat`+cat_flag+`][]" value="`+cat_name+`"  id="" placeholder="Category" required>
                        </td>
                        <td>
                            <textarea name="attribute[cat`+cat_flag+`][]" id="" class="materialize-textarea" placeholder="Attribute" required></textarea>
                        </td>
                        <td class="rating-field">
                            <select class="custom_rating" name="rating[cat`+cat_flag+`][`+att_flag+`][]" id="rating`+rating_count+`" multiple>`+rating_opt+`</select>
                        </td>
                        <td class="weightage">
                            <input type="text" name="weightage[cat`+cat_flag+`][]" min="0"   id="" placeholder="eg: 3" required>
                        </td>
                        <td>
                            <select name="scorable[cat`+cat_flag+`][]" id="scorable`+score_count+`" class="scorable">`+scorable_opt+`</select>
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
        rating_count++;
        score_count++;
        $(this).parents(".card-content-category").find("tbody").append(new_row).find("select").formSelect();
        rating_opt_new(rating_attr_name);
        //$(this).parents(".card-content-category").find("select").formSelect();
    });
});

// for check form name formet
function nospaces(t){
    if(t.value.match(/\s/g)){
        alert('Sorry, you are not allowed to enter any spaces');
        t.value=t.value.replace(/\s/g,'');
    }
     var ajaxRes = postAjax('<?php echo site_url();?>/Get-Unique-Form',{'form_name':t.value});
     if(ajaxRes == 'error'){
        $('.form_name').text('The Form Name is already taken');
     }
     else{
          $('.form_name').text('');
         // $('.form_name_reating').val(t.value);
        $('.form_name_rating').val(t.value);
     }
    
}

function rating_opt_new(rating_attr_name){
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

 