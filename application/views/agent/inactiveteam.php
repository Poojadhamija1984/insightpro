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
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item"><span>Team</span></li>
                                    <li class="breadcrumb-item"><span>Team Hierarchy</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div> 
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
                    <!-- PAGE ERROR END -->
                    <!-- TABLE SECTION START -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <h4 class="card-title m-0">Agent Information</h4>
                                </div>
                                <table class="data_table stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Agent ID</th>
                                            <th>Agent Name</th>
                                            <th>LOB</th>
                                            <th>Group</th>
                                            <th>Emp Type</th>
                                            <th class="center">Status</th>
                                            <th class="center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(!empty($team)){
                                                foreach ($team as $key => $value) {
                                        ?>
                                                    <tr>
                                                        <td><a class="form-data waves-effect waves-light modal-trigger" id="<?php echo implode(',',explode('|||',$value->lob));?>" href="#modal1"><?php echo $value->empid; ?></a></td>
                                                        <td><?php echo $value->name; ?></td>
                                                        <td><?php echo implode(',',explode('|||',$value->lob));?></td>
                                                        <td><?php echo (($value->is_admin == 2)?'Ops':'Client');?></td>
                                                        <td><?php echo (($value->usertype == 2)?'Agent':'supervisor');?></td>
                                                        <td class="center">
                                                            <?php if($value->status == 1){?>
                                                                <span class="status active badge green darken-1">Active</span>
                                                            <?php } else{?>
                                                                <span class="status active badge red darken-1">Inactive</span>
                                                            <?php }?>
                                                        </td>
                                                        <td class="center">
                                                            <a href="<?php echo site_url();?>/edit-team/<?php echo encode($value->user_id);?>">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <?php if($value->status == 1){?>
                                                                <button class="custom_switch switch active agentStatus" value="1" agent="<?php echo $value->user_id;?>">
                                                                    <span class="lever"></span>
                                                                </button>
                                                            <?php } else{?>
                                                                    <button class="custom_switch switch agentStatus" value="0" agent="<?php echo $value->user_id;?>">
                                                                    <span class="lever"></span>
                                                                    <span class="lever"></span>
                                                                </button>
                                                            <?php } ?>                                                    
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
                    <!-- FORM SECTION END -->
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
                $('.agentStatus').click(function() {
                    var aid = $(this).attr('agent');
                    $(this).val() == "1" ? play_int(aid) : play_pause(aid);
                });
            });
            function play_int(id) {
                $('.agentStatus').val("1");                
                postAjax('<?php echo site_url();?>/updateStatus',{'id':id,'status':'0'});
                alert('Employee Inactive Successfully!');
            }
            function play_pause(id) {
                $('.agentStatus').val("0");
                postAjax('<?php echo site_url();?>/updateStatus',{'id':id,'status':'1'});
                alert('Employee Active Successfully!');
            }
        </script>
    </body>
</html>