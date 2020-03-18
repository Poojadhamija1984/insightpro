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
                                <h3 class="page-title"><?=$title?></h3>
                                
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- FORM SECTION START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4>
                                <div class="row mb-0">
                                    <div class="input-field col s12 m4 xl3">
                                        <input id="fromDate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>">
                                        <label for="field_01" class="">From</label>
                                    </div>
                                    <div class="input-field col s12 m4 xl3">
                                        <input id="toDate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>">
                                        <label for="field_02" class="">To</label>
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
                                   
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="button" id="submit" class="btn cyan waves-effect waves-light right">
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
                                <h4 class="card-title">Escalattion Summary</h4>
                                <table class="stripe hover" id="escalation_data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Unique ID</th>
                                            <th>Lob</th>
                                            <th>Call ID</th>
                                            <th>Agent</th>
                                            <th>Issue Type</th>
                                            <th>Total Score</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
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
    // $.fn.dataTable.ext.errMode = 'none';
    var reports_response  = postAjax('<?php echo site_url();?>/escalation/auditData',{'fromDate':$('#fromDate').val(),'toDate':$('#toDate').val(),'lob':$('#lob').val()});
        //console.log(reports_response);
        $('#escalation_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
            //scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' }, 
                        { 'data': 'lob' }, 
                        { 'data': 'call_id' } ,
                        { 'data': 'agent_id' },
                         { 'data': 'issue_type' },
                        { 'data': 'total_score' },
                        { 'data': 'status' }               
                    ]
         });
///oncliclik submit button 
    $('#submit').click(function(e){
        e.preventDefault();
        var reports_response  = postAjax('<?php echo site_url();?>/escalation/auditData',{'fromDate':$('#fromDate').val(),'toDate':$('#toDate').val(),'lob':$('#lob').val()});
       // console.log(reports_response);
        $('#escalation_data').dataTable({
            "bDestroy": true,
            responsive: true,
            fixedHeader: true,
            scrollX : true,
           // scrollY : '30vh',
            data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' },
                        { 'data': 'lob' },  
                        { 'data': 'call_id' } ,
                        { 'data': 'agent_id' },
                        { 'data': 'issue_type' },
                        { 'data': 'total_score' },
                        { 'data': 'status' }               
                    ]
         });
   });

});
</script>