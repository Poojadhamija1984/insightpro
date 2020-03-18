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
            <?php 
                if($this->session->flashdata('permission_denied')){
                    $this->load->view('url_access');    
                }
                else{
            ?>
            <main>
                <!-- BREADCRUMB SECTION START -->
                <div class="breadcrumb-section p-24">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Bucket</h3>
                            
                        </div>
                        <div class="breadcrumb-right"></div>
                    </div>
                </div>   
                <?php 
                    if($this->session->flashdata('message')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error success mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }   
                ?>
                <?php 
                    if($this->session->flashdata('error')){
                ?>
                    <div class="error_section px-24">
                        <div class="page_error failure mb-12">
                            <div class="alert alert-info text-center">
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        </div>
                    </div>
                <?php
                    } 
                ?>             
                <!-- FORM SECTION START -->
                
                    <!-- TABLE SECTION START -->
                <div class="table-section px-24 my-24">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-header">
                                <h4 class="card-title m-0">Bucket Summary</h4>
                            </div>
                            <table class="data_table stripe hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Version</th>
                                        <th>Lob</th>
                                        <th>Channels</th>
                                    </tr>
                                </thead>

                                <?php 
                                    foreach($forms_details as $fd){
                                        if($fd->form_status==1){
                                        echo "<tr>
                                                <td><a targrt='_blank' href='".site_url()."/form-view/{$fd->form_name}/{$fd->form_version}/fill'>{$fd->form_name}</a></td>
                                                <td>{$fd->form_version}</td>
                                                <td>{$fd->lob}</td>
                                                 <td>{$fd->channels}</td>
                                            </tr>";
                                        }
                                    }
                                ?>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              
            </main>
         <?php } ?>
           <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
</html>