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
                                <h3 class="page-title">ATA </h3>
                                
                            </div>
                            <div class="breadcrumb-right">
                                <a href="javascript:void(0)" class="filter_btn">Filter <span class="filter_btn0"></span></a>
                            </div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- TEMP CODE -->
                    <!--<div class="filter-section">
                        <form class="filter_form">
                            <h4 class="filter_heading">Search Records</h4>
                            <div class="col filter_inner2 gradient-45deg-purple-deep-orange">
                                <div class="row mb-0">
                                    <div class="col s6 m4 xl3">
                                        <div class="input-field custom-input--field">
                                            <input type="text" name="start_date" id="start_date" class="datepicker" placeholder="Choose From">
                                            <label for="start_date">From</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m4 xl3">
                                        <div class="input-field custom-input--field">
                                            <input id="end_date" type="text" name="end_date" class="datepicker" placeholder="Choose To">
                                            <label for="end_date">To</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m4 xl3">
                                        <div class="input-field custom-input--field">
                                            <select id="end_date" name="lob_data">
                                                <option value="">Choose Lob</option>
                                                <option value="Trust and Safety">Trust and Safety</option>
                                                <option value="CareTouch">CareTouch</option>
                                            </select>
                                            <label for="lob_data">Lob</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m12 xl3">
                                        <button type="submit" class="filter_submit">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="filter-section mt-24">
                        <form class="filter_form">
                            <h4 class="filter_heading">Search Records</h4>
                            <div class="col filter_inner">
                                <div class="row mb-0">
                                    <div class="col s6 m4 xl2">
                                        <div class="input-field custom-input--field">
                                            <input type="text" name="start_date" id="start_date" class="datepicker" placeholder="Choose From">
                                            <label for="start_date">From</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m4 xl2">
                                        <div class="input-field custom-input--field">
                                            <input id="end_date" type="text" name="end_date" class="datepicker" placeholder="Choose To">
                                            <label for="end_date">To</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m4 xl2">
                                        <div class="input-field custom-input--field">
                                            <select id="end_date" name="lob_data">
                                                <option value="">Choose Lob</option>
                                                <option value="Trust and Safety">Trust and Safety</option>
                                                <option value="CareTouch">CareTouch</option>
                                            </select>
                                            <label for="lob_data">Lob</label>
                                        </div>
                                    </div>
                                    <div class="col s6 m12 xl6">
                                        <button type="submit" class="filter_submit">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>-->
                    <!-- TEMP CODE -->
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4>
                            
                                    <div class="row mb-0">
                                        <div class="input-field col s12 l4 xl3">
                                            <input id="fromDate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>">
                                            <label for="fromDate" class="">From</label>
                                        </div>
                                        <div class="input-field col s12 l4 xl3">
                                            <input id="toDate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>">
                                            <label for="toDate" class="">To</label>
                                        </div>
                                        <div class="input-field col s12 l4 xl3">
                                            <select id="lob" >
                                                <!--<option value="" disabled selected>Select</option>-->
                                                <?php 
                                                    $lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($lob as $key => $value) {
                                                        echo "<option value='{$value}'>{$value}</option>";
                                                    }
                                                ?>
                                                    
                                            </select>
                                            <label for="lob" class="">Lob</label>
                                        </div>
                                        <div class="input-field col s12 l4 xl3 mb-0 form_btns">
                                            <button type="submit" class="btn cyan waves-effect waves-light right" id="submit_button">
                                                <span>Run Report</span>
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                    </div>
                            
                            
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->
                    <!-- TABLE SECTION START -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">ATA Summary</h4>
                                <table class="stripe hover" id="callibration_data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Unique ID</th>
                                            <th>Agent Score</th>
                                            <th>ATA Score</th>
                                            <!--<th>Status</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
<script>
$(document).ready(function() {

    $(".filter_btn").on("click", function(){
        $(this).toggleClass("active");
        $(".filter_form").slideToggle("fast");
    })
    // $.fn.dataTable.ext.errMode = 'none';
    var reports_response  = postAjax('<?php echo site_url();?>/ata/getlist',{'fromDate':$('#fromDate').val(),'tomDate':$('#toDate').val(),'lob':$('#lob').val()});
        //console.log(reports_response);
        $('#callibration_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
            //scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' }, 
                        { 'data': 'agent_score' } ,
                        { 'data': 'ata_score' },
                        { 'data': 'action' }               
                    ]
         });
///oncliclik submit button 
    $('#submit_button').click(function(e){
        e.preventDefault();
        var reports_response  = postAjax('<?php echo site_url();?>/ata/getlist',{'fromDate':$('#fromDate').val(),'tomDate':$('#toDate').val(),'lob':$('#lob').val()});
       // console.log(reports_response);
        $('#callibration_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
           // scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' }, 
                        { 'data': 'agent_score' } ,
                        { 'data': 'ata_score' },
                        { 'data': 'action' }               
                    ]
         });
   });

});
</script>