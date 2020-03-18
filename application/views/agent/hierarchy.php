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
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Agent</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item"><span>Hierarchy</span></li>
                                <li class="breadcrumb-item"><span>Hierarchy</span></li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>                
                <!-- FORM SECTION START -->
                <div class="form-section px-24 mb-24">
                    <div class="card">
                        <div class="card-content">
                            <div class="row mb-0 d-flex flex-wrap">
                                <div class="input-field col l5 m6 s12">
                                    <select id="lob">
                                        <option value="" selected="">Select LOB</option>
                                        <?php 
                                            foreach($lob as $lob_value){
                                                echo "<option value='{$lob_value->lob}' >{$lob_value->lob}</option>";
                                            }
                                        ?>                                            
                                    </select>
                                    <label for="field_04">LOB</label>
                                </div>
                                <div class="input-field col l3 m6 s12">
                                    <input type="text" class="lobtxt">
                                    <label for="field_04" class="">LOB Name</label>
                                </div>
                                <div class="input-field col l5 m6 s12">
                                    <select id="campaign">
                                        <option value="" selected="selected" disabled>Select Campaign</option>
                                    </select>
                                    <label for="field_04" class="">Campaign</label>
                                </div>
                                <div class="input-field col l3 m6 s12">
                                    <input type="text" class="campaign">
                                    <label for="field_04" class="">Campaign Name</label>
                                </div>
                                <div class="input-field col l5 m6 s12">
                                    <select id="vendor">
                                        <option value="" selected="selected" disabled>Select Vendor</option>
                                    </select>
                                    <label for="field_04" class="">Vendor</label>
                                </div>
                                <div class="input-field col l3 m6 s12">
                                    <input type="text" class="vendor">
                                    <label for="field_04" class="">Vendor Name</label>
                                </div>
                                <div class="input-field col l5 m6 s12">
                                    <select id="location" name="lob">
                                        <option value="" selected="selected" disabled>Select Location</option>
                                    </select>
                                    <label for="field_04" class="">Location</label>
                                </div>
                                <div class="input-field col l3 m6 s12">
                                    <input type="text" class="location">
                                    <label for="field_04" class="">Location Name</label>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FORM SECTION END -->
                <!-- FOOTER SECTION START -->
                <footer><p class="m-0">2019 &copy; All Rights Reserved by <a href="https://www.mattsenkumar.com/" target="_blank">MattsenKumar LLC</a></p></footer>
                <!-- FOOTER SECTION END -->
            </main>
            <!-- MAIN SECTION END -->
        </div>
            <!--JavaScript at end of body for optimized loading-->
            <?php $this->load->view('common/footer_file_view') ?>
        <script type="text/javascript">
            $(function(){
                var base_url = "<?php echo site_url();?>";
                $('#lob').change(function(){
                    $('#campaign').html('<option selected>Select Campaign</option>').formSelect();
                    $('#vendor').html('<option selected>Select Vendor</option>').formSelect();
                    $('#location').html('<option selected>Select Location</option>').formSelect();
                    $('.campaign,.vendor,.location').val('');
                    var lobtxt = $("#lob option:selected").text();                   
                    $('.lobtxt').val(lobtxt).focus();
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
                    $('#vendor').html('<option selected>Select Vendor</option>').formSelect();
                    $('#location').html('<option selected>Select Location</option>').formSelect();
                    $('.vendor,.location').val('');
                    var campaigntxt = $("#campaign option:selected").text();                   
                    $('.campaign').val(campaigntxt).focus();
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
                    $('#location').html('<option selected>Select Location</option>').formSelect();
                    $('.location').val('');
                    var vendortxt = $("#vendor option:selected").text();                   
                    $('.vendor').val(vendortxt).focus();
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
            });
        </script>
    </body>
</html>