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
                                <h3 class="page-title">Report</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><span>Attribute</span></li>
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- FORM SECTION START -->
                    <form action="" method="post">
                   <?php $attributes = array("id" => "form col",'class'=>'formview');
                    echo form_open_multipart("",$attributes);
                    ?>  
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Filters</h4>
                                <div class="row mb-0">
                                    <!-- Start Date  -->
                                    <div class="input-field col s12 m4 l3">
                                            <input id="fromdate" name="fromdate" type="text" class="datepicker"  value="<?php if($fromdate) { echo $fromdate; } else { echo date('Y-m-d',strtotime(date('Y-m-01'))); } ?>">
                                            <label for="fromdate" class="">From</label>
                                        </div>
                                        <!-- End Date  -->
                                        <div class="input-field col s12 m4 l3">
                                            <input id="todate" name="todate" type="text" class="datepicker" value="<?php 
                                            if($todate) { echo $todate; }else{ echo date('Y-m-d'); }?>">
                                            <label for="todate" class="">To</label>
                                        </div>
                                       <!-- Site  -->
                                       <?php /* ?>
                                        <div class="input-field col s12 m4 l3">
                                            <select id="site" name="site[]"    multiple class="selectbox"> 
                                                <option value="" disabled>All</option>
                                                <?php
                                                foreach($sites as $key => $site_value){
                                                    if(in_array($site_value->s_id,$sitePost)){
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }        

                                                    echo "<option  ".$selected." value='{$site_value->s_id}'>{$site_value->s_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="lob" class="">Site</label>
                                        </div>
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="groups" name="groups[]" multiple class="selectbox"> 
                                                <option value="" disabled >All</option>
                                                <?php
                                                foreach($groups as $key => $g_value){
                                                    if(in_array($g_value->g_id, $groupPost)){
                                                    $selected = 'selected';
                                                    } else {
                                                    $selected = '';
                                                    }
                                                   echo "<option ". $selected." value='{$g_value->g_id}'>{$g_value->g_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Groups</label>
                                        </div>
                                        <?php */ ?>
                                        <div class="input-field col s12 m4 l3 md-mb-0">
                                            <select id="template" name="tempaltes[]" class="selectbox">
                                                <?php
                                                foreach($tempaltes as $key => $g_value){
                                                     if(in_array($g_value->tn,$postTemplates)){
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                   echo "<option $selected value='{$g_value->tn}'>{$g_value->template_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="groups" class="">Team</label>
                                        </div>
                                    
                                    <div class="input-field col s12 mb-0 form_btns">
                                        <button type="submit" id="submit" class="btn cyan waves-effect waves-light right">
                                            <span>Run Report</span>
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- FORM SECTION END -->
                  
                    <!-- CARD SECTION START -->
                    <div class="col mt-24">
                        <div class="row mb-0">
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Total Audit Conducted</h5>
                                    <span class="total_count stats-count">
                                        <?php 
                                            echo ((!empty($total_audit))?$total_audit:0);
                                        ?>
                                    </span>                                            
                                </div>
                            </div>
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Average Score</h5>
                                    <span class="total_avg stats-count">
                                        <?php
                                            echo (!empty($avg)?$avg."%":0);
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col m4">
                                <div class="status-card card gradient-45deg-purple-deep-orange">
                                    <h5 class="stats-heading">Failed Percentage </h5>
                                    <span class="total_failed stats-count">
                                        <?php
                                            echo (!empty($failed_avg)?$failed_avg:0);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CARD SECTION END -->

                    <!-- TABLE SECTION START -->
                    <div class="table-section">
                        <div class="card">
                            <div class="card-content">
                        	    <?php 
                                    echo $content;
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->

                    <!-- ATTRIBUTE WISE TABLE SECTION START -->
                    <div class="table-section mt-24 audit_history_data hide">
                        <div class="card">
                            <div class="card-content others_datatable_cont">
                               <h4 class="card-title">Attribute Details</h4>
                                <table class="emp_audit_table others_datatable" id="emp_audit_data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="disabled_td">Unique ID</th>
                                            <th>Auditor</th>
                                            <th>Total Score</th>
                                            <th>Submit Date</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ATTRIBUTE WISE TABLE SECTION END -->

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
    <script type="text/javascript">
        $(function(){
            $(document).on('click','.attr_count',function(){
                var attr_value = $(this).attr('attr_value');
                var attr = $(this).attr('attr');
                var tb = $(this).attr('tb');
                var fromdate = $('#fromdate').val();
                var todate = $('#todate').val();
                var data = {
                    'attr_value':attr_value,
                    'attr':attr,
                    'tb':tb,
                    'fromdate':fromdate,
                    'todate':todate
                };
                var res = postAjax('<?php echo site_url();?>/attribute-report-details',data);
                console.log(res);
                getHdata(res)
            })
        });
        function getHdata(res){
                $('.audit_history_data').removeClass('hide').addClass('show');
                var audit_data = res;
                var singleArray = [];
                for (i=0; i<audit_data.length; i++) { 
                        var dd = {};
                        var a  = "<?php echo site_url();?>/template/"+audit_data[i].tmp_unique_id+"/view/"+audit_data[i].unique_id;
                        dd.unique_id     =  '<a href="'+a+'" target="_blank">'+audit_data[i].unique_id+'</a>';
                        dd.eval_name     =  audit_data[i].evaluator_name;
                        dd.lob           =  audit_data[i].total_score;
                        dd.call_id       =  audit_data[i].submit_time;
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
                        { 'data': 'eval_name' },   
                        { 'data': 'lob' },
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
</html>