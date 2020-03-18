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
                                <h3 class="page-title">Invoice</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item"><span>Invoice</span></li>
                                    <li class="breadcrumb-item"><span>Invoice</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
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
                    <?php }   
                    if($this->session->flashdata('error')){
                    ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12">
                                <div class="alert alert-info text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- PAGE ERROR END -->
                    <!-- INVOICE SECTION START -->
                    <div class="invoice-section mt-24">
                        <div class="card invoice_card">
                            <div class="card-content">
                                <div class="card-header d-flex flex-wrap justify-content-between">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INVOICE SECTION END -->
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">
                                    Insight Pro <span style="float: right;">Date:<?php echo date('d F Y',strtotime($pd));?></span>
                                </h4>
                                <div class="row mb-0 d-flex flex-wrap">
                                    <div class="input-field col l4 m6 s12">
                                        From<br>
                                        Insight Pro.<br>
                                        518 Akshar Avenue<br>
                                        Gandhi Marg<br>
                                        New Delhi<br>
                                        Email: hello@vali.com
                                    </div>
                                    <div class="input-field col l4 m6 s12">
                                        To<br>
                                        <?php echo $cname."<br>".$cloc."<br>Phone: ".$cpno."<br>Email: ".$cemail;?>
                                    </div>
                                    
                                    <div class="input-field col l4 m6 s12">
                                        Payment Due Date: <?php echo date('d F Y',strtotime($lpd));?>
                                    </div>
                                </div>
                                <?php  $attributes = array('id' => 'agentFrm');echo form_open_multipart('addAgent',$attributes);?>
                                    <div class="row mb-0 d-flex flex-wrap">
                                    <table>
                                            <thead>
                                                <th>Total Agent</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $agent;?></td>
                                                    <td>$1</td>
                                                    <td><?php echo "$".$agent * 1;?></td>
                                                </tr>
                                            </tbody>
                                    </table>
                                    <?php 
                                    if($lpd <= date('Y-m-d')){
                                    ?>
                                        <div class="input-field col s12 mb-0 form_btns">
                                            <button type="submit" id="agentBtn" class="btn cyan waves-effect waves-light right">
                                                <span>Pay</span>
                                                <i class="material-icons right">send</i>
                                            </button>
                                            <!-- <button type="reset" class="btn grey waves-effect waves-light right">
                                                <span>Reset</span>
                                            </button> -->
                                        </div>
                                        <?php 
                                        }
                                        ?>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->
                </div>
                <!-- MAIN CONTENTS END -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view')  ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>
    </body>
</html>