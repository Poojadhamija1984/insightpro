<div class="row mb-0">
    <div class="input-field col s12 m4 xl3">
        <input id="audit_from" name="audit_from" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>" required>
        <label for="field_01" class="">From*</label>
    </div>
    <div class="input-field col s12 m4 xl3">
        <input id="audit_to" name="audit_to" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>" required>
        <label for="field_02" class="">To*</label>
    </div>
    
    <div class="input-field col s12 m4 xl3">
        <select id="date_column" name="date_column" required>
            <option value="submit_time" selected>Evaluation Date</option>
            <option value="call_date" >Call Date</option>
        </select>
        <label for="field_03" class="">Date Type*</label>
    </div>
    <div class="input-field col s12 m4 xl3">
        <select id="lob" name="lob" required  class="LOBB">
            <?php 
                $url = $this->uri->uri_string();
                $sup_lob = explode('|||',$this->session->userdata('lob'));
                $selected = '';
                if(($url != 'attribute-report')){
                    echo '<option value="all" selected>All</option>';
                }
                if(($url == 'attribute-report')){
                    echo '<option value="" selected>Select</option>';
                }
                foreach($sup_lob as $key => $lob_value){
                    echo "<option value='{$lob_value}' $selected>{$lob_value}</option>";
                }
            ?>                                            
        </select>
        <label for="field_04">LOB*</label>
    </div>
    <?php if(($url == 'attribute-report')){ ?>
    <div class="input-field col s12 m4 xl3" required>
        <select id="form_version" name="form_version">
            <option value="" disabled>Select</option>
        </select>
        <label for="form_version" class="">Form Version</label>
    </div>
    <?php } ?>
    <div class="input-field col s12 m4 xl3">
        <select id="campaign" name="campaign">
            <option value="" disabled>Select</option>
        </select>
        <label for="campaign" class="">Campaign</label>
    </div>
    
    <div class="input-field col s12 m4 xl3">
        <select id="vendor" name="vendor">
            <option value="" disabled>Select</option>
        </select>
        <label for="vendor" class="">Vendor</label>
    </div>
    <div class="input-field col s12 m4 xl3">
        <select id="location" name="location">
            <option value="" disabled>Select</option>
        </select>
        <label for="location" class="">Location</label>
    </div>

    <?php if(($url == 'attribute-report')){ ?>
    <div class="input-field col s12 m4 xl3" required>
        <select id="form_category" name="form_version">
            <option value="" disabled>Select</option>
        </select>
        <label for="form_version" class="">Category</label>
    </div>
    <div class="input-field col s12 m8 xl9" required>
        <select id="form_attributes" name="form_version">
            <option value="" disabled>Select</option>
        </select>
        <label for="form_version" class="">Attributes</label>
    </div>
    <?php } ?>

    <div class="input-field col s12 m4 xl3">
        <select id="agents" name="agents">
            <option value="">Select</option>
            <?php 
            $agent =$this->common->getDistinctWhere('user','empid,name',['sup_id'=>$this->session->userdata('empid'),'usertype'=>'2','status'=>'1']);
                foreach($agent as $agents_value){
                    echo "<option value='{$agents_value->empid}' >{$agents_value->name}</option>";
                }
            ?>                                            
        </select>
        <label for="agents">Agents</label>
    </div>
    
   
    
    <div class="input-field col s12 mb-0 form_btns">
        <button type="button" id="submit" name="submit_btn" class="btn cyan waves-effect waves-light right">
        <!-- <button type="submit" id="submit" name="submit_btn" class="btn cyan waves-effect waves-light right"> -->
            <span id="btl_span">Run</span>
            <i class="material-icons right">send</i>
        </button>
    </div>
</div>

<script type="text/javascript">
    // $(document).ready(function(){
    //     if( $('#faild_attributes').length )         // use this if you are using id to check
    //     {
    //         $('.LOBB').change(function(){
    //             alert($(this).val());
    //            //var ajaxRes = postAjax('<?php echo site_url();?>/get_faild_attributes',{'lob':lob,'form_version':form_version});  
    //         });
    //     }
    // });
    $(function(){
        var base_url = "<?php echo site_url();?>";
        $('#form_category').change(function(){
            var form_category = $(this).val();
            var form_version = $('#form_version').val();
            var lob          = $('#lob').val();
            var ajaxRes = postAjax('<?php echo site_url();?>/get-attributes',{'lob':lob,'form_version':form_version,'form_category':form_category});
            console.log(ajaxRes);
            $('#form_attributes').empty();
            $('#form_attributes').append($("<option></option>").attr("value",'').text('Select')); 
            $.each( ajaxRes.attribute, function( key, value ) {
                $('#form_attributes').append($("<option></option>").attr("value",value.attr_id).text(value.attribute));
            });
            $('#form_attributes').formSelect();
        });

        $('#form_version').change(function(){
            var form_version = $(this).val();
            var lob          = $('#lob').val();
            var ajaxRes = postAjax('<?php echo site_url();?>/get-category',{'lob':lob,'form_version':form_version});
            console.log(ajaxRes);
            // $('#form_category').empty();
            // $('#form_category').html('<option value="">Select</option>').formSelect();

            $('#form_category').empty();
            $('#form_category').append($("<option></option>").attr("value",'').text('Select')); 
            $.each( ajaxRes.category, function( key, value ) {
                $('#form_category').append($("<option></option>").attr("value",value.category).text(value.category));
            });
            $('#form_category').formSelect();
            $('#form_attributes').empty();
            $('#form_attributes').append($("<option></option>").attr("value",'').text('Select')).formSelect();
            //alert(form_version +'----'+lob);
        });

        $('#lob').change(function(){
            $('#campaign').html('<option value="">Select</option>').formSelect();
            $('#vendor').html('<option value="">Select</option>').formSelect();
            $('#location').html('<option value="">Select</option>').formSelect();
            $('.campaign,.vendor,.location').val('');
            var lobtxt = $("#lob option:selected").text();  
            var ajaxRes = postAjax('<?php echo site_url();?>/Get-Versions',{'post_column_name':'lob','post_column_value':lobtxt});
            $('#form_category').empty();
            $('#form_category').append($("<option></option>").attr("value",'').text('Select')).formSelect(); 
            $('#form_attributes').empty();
            $('#form_attributes').append($("<option></option>").attr("value",'').text('Select')).formSelect(); 
            $('#form_version').empty();
            $('#form_version').append($("<option></option>").attr("value",'').text('Select'));
            if(ajaxRes.version.length > 0){ 
                $.each( ajaxRes.version, function( key, value ) {
                    $('#form_version').append($("<option></option>").attr("value",value.form_version).text(ajaxRes.form_name+' ( V'+value.form_version+'.0)')).formSelect();
                });
            }
            else{
                alertBox('Please create form for this LOB');
                return false;
            }
            console.log(ajaxRes);
           // alert(lobtxt); 
            $.ajax({
                url:base_url+'/ah/lob/'+lobtxt,
                type:'get',
                success:function(res){
                    $('#campaign').append(res);
                    $('#campaign').formSelect();
                }
            });                    
        });
        $('#campaign').change(function(){
            $('#vendor').html('<option value="">Select</option>').formSelect();
            $('#location').html('<option value="">Select</option>').formSelect();
            $('.vendor,.location').val('');
            var campaigntxt = $("#campaign option:selected").text();   
            $.ajax({
                url:base_url+'/ah/campaign/'+campaigntxt,
                type:'get',
                success:function(res){
                    $('#vendor').append(res);
                    $('#vendor').formSelect();
                }
            });                    
        });
        $('#vendor').change(function(){
            $('#location').html('<option value="">Select</option>').formSelect();
            $('.location').val('');
            var vendortxt = $("#vendor option:selected").text();  
            $.ajax({
                url:base_url+'/ah/vendor/'+vendortxt,
                type:'get',
                success:function(res){
                    $('#location').append(res);
                    $('#location').formSelect();
                }
            });                    
        });
        $('#location').change(function(){
            var locationtxt = $("#location option:selected").text();                   
            $('.location').val(locationtxt).focus();
        });
        
    })
</script>