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
                                <h3 class="page-title">Team</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Roster Upload</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right">
                                <a class="btn_common" href="<?php echo base_url();?>/assets/download/7088698667.xlsx" download="">Download Sample</a>
                            </div>
                        </div>
                    </div>  
                    <!-- BREADCRUMB SECTION END --> 
                    <!-- PAGE ERROR START -->
                    <?php if($this->session->flashdata('message')){ ?>
                        <div class="error_section px-24">
                            <div class="page_error success mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('error')){ ?>
                        <div class="error_section px-24">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>  
                    <!-- PAGE ERROR END -->           
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4 class="card-title mb-0"></h4>
                                    <a href="#" target="_blank">Click here to see CSV Upload Instruction</a>
                                </div>
                                <!-- <form class="col"> -->
                                <?php  $attributes = array('id' => 'agentFrm', 'class' => 'col');echo form_open_multipart('add-team-roster',$attributes);?>
                                    <div class="row mb-0">
                                        <div class="col s12 m6">
                                            <div class="field-section ">
                                                <h5 class="field-heading">User Group</h5>
                                                <div class="radio_cont">
                                                    <label>
                                                        <input name="emp_group" type="radio" value="ops"  class="with-gap emp_group"/>
                                                        <span>Ops</span>
                                                    </label>
                                                    <label>
                                                        <input name="emp_group" type="radio" value="client" class="with-gap emp_group"/>
                                                        <span>Client</span>
                                                    </label>  
                                                </div>
                                                <span class="field_error"><?php  echo (!empty($this->session->flashdata('emp_group'))?$this->session->flashdata('emp_group'):''); ?></span>
                                            </div>
                                            <div class="field-section ">
                                                <h5 class="field-heading">User Type</h5>
                                                <div class="radio_cont">
                                                    <label>
                                                        <input name="emp_type" type="radio" value="agent" class="with-gap client" />
                                                        <span>Agent</span>
                                                    </label>
                                                    <label>
                                                        <input name="emp_type" type="radio" value="supervisor"  class="with-gap client"/>
                                                        <span>supervisor</span>
                                                    </label>
                                                </div>
                                                <span class="field_error"><?php  echo (!empty($this->session->flashdata('emp_type'))?$this->session->flashdata('emp_type'):''); ?></span>
                                            </div>
                                        </div>
                                        <div class="file-field input-field mt-0 col l4 m6 s12">
                                            <div class="btn">
                                                <span>File</span>
                                                <input type="file" name="userfile">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text">
                                                <small>Allowed Only xlsx,xls,csv</small>
                                            </div>                                       
                                        </div>
                                        <div class="col s12 mb-0 form_btns">
                                            <button type="submit" id="agentBtn" class="btn cyan waves-effect waves-light right">
                                                <span>Submit</span>
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                    </div>
                                <!-- </form> -->
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->
                    <!-- TABLE SECTION START -->
                   
                    <!-- TABLE SECTION END -->
                    <!-- Modal Structure -->
                        <div id="modal1" class="modal modal-fixed-footer">
                            <div class="modal-content">
                                <h4>From Deatils</h4> 
                                <hr/>
                                <table class="stripe hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Version</th>
                                        <th>Lob</th>
                                        <th>Channels</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody id="form_data">

                                </tbody>
                            </table>
                            </div>
                            <!-- loader -->
                            <!-- on add class active -->
                            <div class="preloader-wrapper">
                                <div class="spinner-layer spinner-red-only">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="gap-patch">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- End loader -->
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
        <script type="text/javascript">
            $(function(){
                var base_url = "<?php echo site_url();?>";
                $(".client").click(function(){
                    var clientValue = $(this).val();
                    var emp_group = $("input[name='emp_group']:checked").val();
                    $('#lob_data').addClass('hide');
                });
                $(".emp_group").click(function(){
                    $('#supervisor').html('<option>Select supervisor</option>').formSelect();
                    var emp_group = $(this).val();
                    var clientValue = $("input[name='client']:checked").val();
                    $('#lob_data').addClass('hide');
                });
                $('#campaign').change(function(){
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

            function Sup(base_url,emp_group){
                $.ajax({
                        url:base_url+'/get-supervisor/'+emp_group,
                        type:'get',
                        success:function(res){
                            console.log(res);
                            $('#supervisor').append(res);
                            $('#supervisor').formSelect();
                        }
                    })
            }
        </script>
    </body>
</html>