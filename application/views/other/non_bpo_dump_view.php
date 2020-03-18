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
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Download Dump</span></li>
                                </ul>
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
                                            <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php echo date('Y-m-d',strtotime(date('Y-m-01')));?>">
                                            <label for="fromdate" class="">From</label>
                                        </div>
                                        <!-- End Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="todate" name="todate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>">
                                            <label for="todate" class="">To</label>
                                        </div>
                                        <!-- Site -->
                                        <div class="input-field col s12 m4 l3">
                                            <select id="sitedd" name="site" required > 
                                                <option value="">Select</option>
                                                <?php
                                                foreach($sites as $key => $site_value){
                                                    echo "<option value='{$site_value->s_id}'>{$site_value->s_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="sitedd" class="">Site</label>
                                        </div>
                                         <!-- Tempaltes -->
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="tepmlates" name="tepmlates" required> 
                                                <option value="" >Select</option>
                                            </select>
                                            <label for="tepmlates" class="">Templates</label>
                                        </div>
                                        
                                       
                                        <div class="input-field col s12 form_btns mb-0">
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
            if($('#sitedd').val() != '')
            {
                setTimeout(() => {
                    location.reload();    
                }, 3000);
            }
        });
    
        $('#sitedd').change(function(){
            var site_id = $(this).val();
            var ajaxRes = postAjax('<?php echo site_url();?>/get-templates',{'site_id':site_id});
            $('#tepmlates').empty();
            $('#tepmlates').append($("<option></option>").attr("value",'').text('Select')); 
            $.each(ajaxRes.tempDetails, function( key, value ) {
                $('#tepmlates').append($("<option></option>").attr("value",value.tb_name).text(value.tmp_name)).formSelect();
             });
          
        });
       
    });
</script>
 