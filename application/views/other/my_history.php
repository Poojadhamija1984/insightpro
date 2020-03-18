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
                                <h3 class="page-title">Audit</h3>
                                <ul class="breadcrumb-list">
                                <!-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li>-->
                                    <li class="breadcrumb-item"><span>Audit Summary</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div> 
                  <!-- FORM SECTION START -->
                  <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4>
                                <div class="row mb-0">
                                    <!-- Start Date  -->
                                    <div class="input-field col s12 m4 l3">
                                    <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) )); ?>">
                                            <label for="fromdate" class="">From</label>
                                        </div>
                                        <!-- End Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="todate" name="todate" type="text" class="datepicker" value="<?php echo date('Y-m-d'); ?>">
                                            <label for="todate" class="">To</label>
                                        </div>
                                       <!-- Site  -->
                                        <div class="input-field col s12 m4 l3">
                                            <select id="site" name="site[]"    multiple class="selectbox"> 
                                                <option value="" disabled>All</option>
                                                <?php
                                                foreach($sites as $key => $site_value){
                                                       

                                              echo "<option   value='{$site_value->s_id}'>{$site_value->s_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">Site</label>
                                        </div>
                                     <!-- Template -->
                                      <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="groups" name="groups[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($groups as $key => $g_value){
                                                
                                                echo "<option  value='{$g_value->g_id}'>{$g_value->g_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Groups</label>
                                        </div>
                                    
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="button" id="submit" class="btn cyan waves-effect waves-light right" onclick="searchFormData()">
                                            <span>Search</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                 

                  <!-- TABLE SECTION START -->
                    <div class="table-section mt-24">
                        <div class="card">
                            <div class="card-content others_datatable_cont">
                                <div class="card-header">
                                    <!-- <h4 class="card-title m-0">Audit Summary</h4> -->
                                    <h4 class="card-title m-0">Audit Forms</h4>
                                </div>
                                <table id="template_data" class="audit_summary_table others_datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>Template Name</th> -->
                                            <th>Form Name</th>
                                            <th>Created Date</th>
                                            <th>Audit Average Score</th>
                                            <th>Audit Average Time</th>
                                            <th>Status</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
                    <!-- TABLE SECTION START -->
                    <div class="table-section mt-24 audit_history_data hide">
                        <div class="card">
                            <div class="card-content others_datatable_cont">
                                <!-- <h4 class="card-title">List of Audits by <span id="aeid"></span> between <span id="dd"></span></h4> -->
                                <table class="emp_audit_table others_datatable" id="emp_audit_data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="disabled_td">Unique ID</th>
                                            <!-- <th>Auditor</th> -->
                                            <th>Audit Score(%)</th>
                                            <th>Audit Time</th>
                                            <th>Audit Date & time</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
    <!-- jai code --> 
        <script type="text/javascript">
            $(document).ready(function(){
            searchFormData();
             });
            function searchFormData()
            {
                //alert('jai');
                 var base_url  = '<?php echo site_url();?>/getFromData';
                //console.log(reports_response);
                var data = {'fromdate':$('#fromdate').val(),'todate':$('#todate').val(),'site':$('#site').val(),'groups':$('#groups').val()};
                var reports_response = postAjax_With_Loder(base_url,data);
                $('#template_data').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    //scrollY : '30vh',
                    data:reports_response,
                            "columns": [
                                { 'data': 'tmp_name' }, 
                                { 'data': 'created_date' },
                                { 'data': 'avg_score' },
                                { 'data': 'avg_audit_time' },
                                { 'data': 'status' },
                                { 'data': 'total_count'}             
                            ]
                });   
            }
        
            function getHdata($tmpNmae){
                //alert('hee');
                var did = $tmpNmae;
                data = {'did':did}
                var response = postAjax("<?php echo site_url();?>/my-history-data",data);
                $('.audit_history_data').removeClass('hide').addClass('show');
                var audit_data = response;
                var singleArray = [];
                for (i=0; i<audit_data.length; i++) { 
                        var dd = {};
                        <?php  if($this->emp_group == 'auditor'){ ?>
                        var a  = "<?php echo site_url();?>/template/"+audit_data[i].tmp_unique_id+"/view/"+audit_data[i].unique_id;
                            <?php } else { ?>
                            var a  = "<?php echo site_url();?>/template/"+audit_data[i].tmp_unique_id+"/review/"+audit_data[i].unique_id;     
                            <?php }  ?>   
                        dd.unique_id     =  '<a href="'+a+'" target="_blank">'+audit_data[i].unique_id+'</a>';
                        dd.eval_name     =  audit_data[i].evaluator_name;
                        dd.lob           =  audit_data[i].total_score;
                        dd.call_id       =  audit_data[i].submit_time;
                        dd.audit_counter =  audit_data[i].audit_counter;
                        singleArray.push(dd);  
                };
                //console.log(singleArray);
                // $('#aeid').html(emp_id);
                //$('#dd').html(response.between);
                $('#emp_audit_data tbody').html('');
                $('#emp_audit_data').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    // scrollY : '30vh',
                    data:singleArray,
                    "columns": [
                        { 'data': 'unique_id' },
                        /*{ 'data': 'eval_name' }, */  
                        { 'data': 'lob' },
                        { 'data': 'audit_counter'},
                        { 'data': 'call_id' }
                                            
                    ],
                    columnDefs: [
                        {  
                            orderable: false,
                            targets: [ 0, 2 ]
                        }
                    ]
                });
            
            }
        </script>
    </body>
</html>