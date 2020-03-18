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
                                <h3 class="page-title"><?=$title;?></h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><a href="<?php echo site_url().'/create_form'; ?>">Dashboard</a></li>
                                    <li class="breadcrumb-item"><span><?=$title;?></span></li>
                                
                                </ul>
                            </div>
                            <div class="breadcrumb-right">
                                <a class="btn_common" href="<?php echo site_url().'/forms-list'; ?>">form list</a>
                                <a class="btn_common" href="<?php echo base_url();?>/assets/download/forms.xlsx" download="">Download Sample</a>
                            </div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR START -->
                    <?php if($this->session->flashdata('message')){ ?>
                    <div class="error_section">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('message'); ?>
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
                <!-- FORM SECTION START -->
                <div class="form-section mt-24">
                    <div class="card">
                        <div class="card-content">
                            <h4 class="card-title">Download Sample CSV</h4>
                             <?php
                                if(validation_errors()){
                                ?>
                                <div class="alert alert-info text-center">
                                    <?php echo validation_errors(); ?>
                                </div>
                                <?php
                                }
                            ?>
                      <?php
                        
                       ?>
                            <?php
                                $attributes = array("id" => "uploadformcreate", "name" => "uploadformcreate", "class" => "col");
                                echo form_open_multipart(site_url().'/create-form-upload', $attributes);
                            ?>
                           
                            <div class="row mb-0 d-flex flex-wrap">
                                <div class="input-field col s12 m4 xl3">
                                    <select id="form_name" name="form_name" onchange='Checkcampaign(this.value);'   required> 
                                        <option value="" >Select</option>
                                        <?php 
                                        foreach($form_name as $form_name){
                                            echo '<option value="'.$form_name['form_name'].'">'.ucwords($form_name['form_name']).'</option>';
                                        }
                                        ?>
                                        <option value="add_new">Add New</option>
                                    </select>
                                     <label for="field_05" class="">Form Name </label>
                                </div>

                                <div class="input-field col s12 m4 xl3" id="campaigntxt" style="display:none">
                                    <input id="campaigntxt1"  placeholder="e.g.  Form_qa"  type="text" onkeyup="nospaces(this)" title="space not allowed">
                                    <label for="campaigntxt1" class="">Form Name </label>
                                    <span class="field_error"><?php echo (!empty(form_error('form_name')) ?  form_error('form_name'):'');?></span>
                                </div>
                                <div class="input-field col s12 m4 xl3">
                                    <input id="form_version" name="form_version" placeholder="e.g.  Form Version"  type="text" readonly>
                                    <label for="form_version" class="">Form Version</label>
                                    <span class="field_error"><?php echo (!empty(form_error('form_version')) ?  form_error('form_version'):'' );?></span>
                                </div>
                                <div class="input-field col s12 m4 xl3">
                                    <input id="pass_rate" name="pass_rate" placeholder="e.g.  Pass Rate"  type="number" min="0" requried>
                                    <label for="pass_rate" class="">Pass Rate</label>
                                    <span class="field_error"><?php echo (!empty(form_error('pass_rate')) ?  form_error('pass_rate'):'' );?></span>
                                </div>

                                <div class="input-field col s12 m4 xl3">
                                    <select id="lob" name="lob"   required> 
                                        <option value="" >Select</option>
                                        <?php 
                                        foreach($lob as $lob){
                                            echo '<option value="'.$lob['lob'].'">'.ucwords($lob['lob']).'</option>';
                                        }
                                        ?>
                                    </select>
                                     <label for="field_05" class="">Lob</label>
                                </div>
                                <div class="input-field col s12 m4 xl3">
                                    <select id="channels" name="channels"   required> 
                                        <option value="" >Select</option>
                                        <?php 
                                        foreach($channels as $key=>$value){
                                            echo '<option value="'.$key.'">'.ucwords($value).'</option>';
                                        }
                                        ?>
                                    </select>
                                     <label for="field_05" class="">Channel Type</label>
                                </div>
                                
                                <div class="input-field col s12 m4 xl3">
                                    <input id="form_attributes" name="form_attributes" placeholder="Max 30 attributes" title="max 30 attribtes allowed"  type="number" max="30" min="10">
                                    <label for="form_attributes" class="">Attributes</label>
                                </div>

                                <div class="file-field input-field col s12 m4 xl3">
                                    <div class="btn">
                                        <span>File</span>
                                        <input type="file" name="userfile">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder=".xlsx file only"> 
                                    </div>
                                    <span class="field_error">  <?php  echo isset($error['error']) ? $error['error'] : ''; ?></span>
                                    
                                </div>
                                
                                <div class="input-field col s12 mb-0 form_btns">
                                    <button type="submit" name="importfile" value="Import" class="btn cyan waves-effect waves-light right">
                                        <span>Submit</span>
                                        <i class="material-icons right">send</i>
                                    </button>
                                    <!-- <button type="reset" class="btn grey waves-effect waves-light right">
                                        <span>Reset</span>
                                    </button> -->
                                </div>
                            </div>
                            <?php echo form_close();?><!-- </form> -->
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->
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
   
    $('#form_name').change(function(){
        var form_name = $(this).val();
        if(form_name == 'add_new')
        {
            $('#form_version').val('v'+1+'.0');
            $('#form_name').removeAttr('name');
            $('#campaigntxt1').attr("name","form_name");
            var ajaxRes = postAjax('<?php echo site_url();?>/form-details',{'form_name':'add_new_form'});
            console.log(ajaxRes);
            $('#lob').empty();
            $('#lob').append($("<option>select</option>")).formSelect(); 
            $.each( ajaxRes.lob, function( key, value ) {
                //alert(value.lob);
                $('#lob').append($("<option></option>").attr("value",value.lob).text(value.lob)).formSelect(); 
            });

        }
        else
        {
            if(!$(this).attr("name"))
            {
                $('#campaigntxt1').removeAttr('name');
                $(this).attr("name","form_name");   
            }
            var ajaxRes = postAjax('<?php echo site_url();?>/form-version',{'form_name':form_name});
            console.log(ajaxRes);
             $('#lob').empty();
            $('#lob').append($("<option></option>").attr("value",'').text('Select')); 
            $.each( ajaxRes.lob, function( key, value ) {
                $('#lob').append($("<option></option>").attr("value",value.lob).text(value.lob)).formSelect(); 
            });
            $('#form_version').val('v'+(1+parseInt(ajaxRes.version))+'.0');
            
            // $.ajax({
            //     url:'/form-version/'+form_name,
            //     type:'GET',
            //     success:function(data){
            //        // alert(data);
            //         $('#form_version').val('v'+(1+parseInt(data))+'.0');
            //     }
            // });
        }
    });
   
});

function nospaces(t){
if(t.value.match(/\s/g)){

alert('Sorry, you are not allowed to enter any spaces');

t.value=t.value.replace(/\s/g,'');

}

}

</script>

 