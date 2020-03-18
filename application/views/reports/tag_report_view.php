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
                                <h3 class="page-title">Reports</h3>
                                <ul class="breadcrumb-list">
                                   <li class="breadcrumb-item"><span>Tag</span></li>
                                </ul>
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
                                <?php   $attributes = array('class' => '','method'=>'POST');
                                     //echo form_open(site_url().'/tag-report-list', $attributes);?>
                                 <?php $this->load->view('common/report_filter_view') ?>
                                 <?php  //echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <div class="rrr">
                        
                    </div>
                    <!-- FORM SECTION END -->

                    <!-- TABLE SECTION START -->
                    <div class="table-section mt-24 report_div" style="display:none">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Report Data</h4>
                                <table class="data_table  stripe hover" id="reportOne" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tags</th>
                                            <th>Total Calls</th>
                                            <th>Applicable Calls</th>
                                            <th>Applicable %</th>
                                            <th>Tag Score %</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
                     <!-- TABLE SECTION START -->
                    <div class="table-section mt-24 data_list_div" style="display:none">
                        <div class="card">
                            <div class="card-content ">
                                <h4 class="card-title"> Data List</h4>
                                 <table class="stripe hover" id="data_list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Unique ID</th>
                                            <th>Agent Name</th>
                                            <th>Supervisor Name</th>
                                            <th>Vendor</th>
                                            <th>Location</th>
                                            <th>Campaign</th>
                                            <th>LOB</th>
                                            <th>QA Score</th>
                                        </tr>
                                    </thead>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
                     <!-- TABLE SECTION START -->
                    <div class="table-section mt-24 data_list_kpi_div" style="display:none">
                        <div class="card">
                            <div class="card-content ">
                                <h4 class="card-title"> Data List</h4>
                                 <table class="stripe hover" id="data_list_kpi" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>LOB</th>
                                            <th>Version</th>
                                            <th>Average</th>
                                        </tr>
                                    </thead>
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



        <script type="text/javascript">
            $(function(){
                $('#submit').click(function(e){
                    $('.report_div').show();
                    $('.data_list_div').css('display','none');
                    e.preventDefault();
                    var audit_from      = $('#audit_from').val();
                    var audit_to        = $('#audit_to').val();
                    var date_column     = $('#date_column').val();
                    var lob             = $('#lob').val();
                    var campaign        = $('#campaign').val();
                    var vendor          = $('#vendor').val();
                    var location        = $('#location').val();
                    var agents          = $('#agents').val();
                    if((audit_from == null))
                    {
                        alert('Date from fields is mandatory');
                        return false;
                    }
                    else if((audit_to == null)){
                        alert('Date to fields is mandatory');
                        return false;
                    }else if((date_column == '')){
                        alert('Call Date fields is mandatory');
                        return false;
                    }else if((lob == '')){
                        alert('LOB fields is mandatory');
                        return false;
                    }
                    else{
                        var reports_response  = postAjax_With_Loder('<?php echo site_url();?>/tag-report-list',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents});
                        //    for (var i=0; i<reports_response.length; i++){
                        //         reports_response[i].qa_renk = i+1;
                        //         reports_response[i].qa_score = (reports_response[i].qa_score).toFixed(2);
                        //     }
                        console.log(reports_response);
                        // return false;
                        if(reports_response)
                        {
                            $('.report_div').show();
                            $('#btl_span').html('Run');
                            $('#submit').attr('disabled',false);
                        } 
                        $('.data_table').dataTable({
                            "bDestroy": true,
                            responsive: true,
                            fixedHeader: true,
                            scrollX : true,
                            scrollY : '30vh',
                            data:reports_response,
                            "columns": [
                                { 'data': 'KpiAttrName' } ,
                                { 'data': 'TOTAL_CALL' },
                                { 'data': 'TOTAL_KPI_EVALUTION' },
                                { 'data': 'AVG' },                         
                                { 'data': 'TagScore' },                         
                                { 'defaultContent': 'Button' }                         
                            ],
                            columnDefs:[{
                                targets:[2],render:function(a,b,data,d)
                                {
                                    return '<a href="javascript:void(0)" onclick="data_list(`'+audit_from+'`,`'+audit_to+'`,`'+date_column+'`,`'+campaign+'`,`'+vendor+'`,`'+location+'`,`'+lob+'`,`'+agents+'`,`'+data.unique_id+'`)">'+data.TOTAL_KPI_EVALUTION+'</a>';
                                }
                            },
                            
                            {
                                targets:[5],render:function(a,b,data,d)
                                {
                                    //return '<a href="javascript:void(0)" onclick="data_list_kpi(`'+data.KpiAttrName+'`,`'+data.form_version+'`,`'+audit_from+'`,`'+audit_to+'`,`'+date_column+'`,`'+campaign+'`,`'+vendor+'`,`'+location+'`,`'+lob+'`,`'+agents+'`,`'+data.unique_id+'`)">view</a>';
                                    return '<span class="viewtagdata" kpiName="'+data.KpiAttrName+'">view</span>';
                                }
                            }]
                        });  
                    }
                    $('html, body').animate({
                        scrollTop: $(".report_div").offset().top
                    }, 2000);
                    
                }); 
            });

            $(document).on('click','.viewtagdata',function(){
                var kpiname = $(this).attr('kpiname');
                var audit_from = $('#audit_from').val();
                var audit_to = $('#audit_to').val();
                var date_column = $('#date_column').val();
                var lob = $('#lob').val();
                var campaign = $('#campaign').val();
                var vendor = $('#vendor').val();
                var location = $('#location').val();
                var agents = $('#agents').val();
                var data = {
                   'audit_from':audit_from,
                   'audit_to':audit_to,
                   'date_column':date_column,
                   'lob':lob,
                   'campaign':campaign,
                   'vendor':vendor,
                   'location':location,
                   'agents':agents,
                   'kpi_name':kpiname
                };
                console.log('data',data)
                var reports_response  = postAjax('<?php echo site_url();?>/tag-report-audit-list-kpi',data);
                 console.log(reports_response); 
                  $('.data_list_kpi_div').show();
                 $('#data_list_kpi').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    scrollY : '55vh',
                    data:reports_response,
                    "columns": [
                        { 'data': 'attributeName' }, 
                        { 'data': 'lob' },
                        { 'data': 'form_version' },
                        { 'data': 'avg' }
                    ]
                });
                $('html, body').animate({
                        scrollTop: $(".data_list_kpi_div").offset().top
                    }, 2000); 
                 return false;
            });

            function data_list(audit_from,audit_to,date_column,campaign,vendor,location,lob,agents,unique_id,data_list_type = ''){
                //alert(form_version);
               // alert(audit_from+'\n'+audit_to+'\n'+date_column+'\n'+campaign+'\n'+vendor+'\n'+location+'\n'+lob+'\n'+agent_name+'\n'+agent_id);
               $('.data_list_div').show();
                var reports_response  = postAjax('<?php echo site_url();?>/tag-report-audit-list',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents,'unique_id':unique_id,'data_list_type':data_list_type});
                 //console.log(responsiveports_response);  
                $('#data_list').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    scrollY : '30vh',
                    data:reports_response,
                    "columns": [
                        { 'data': 'unique_id' }, 
                        { 'data': 'agent_name' } ,
                        { 'data': 'supervisor' },
                        { 'data': 'vendor' },
                        { 'data': 'location' },
                        { 'data': 'campaign' },
                        { 'data': 'lob' },
                        { 'data': 'total_score' }                 
                    ],
                    columnDefs:[{
                        targets:[0],render:function(a,b,data,d)
                        {
                            return '<a target="_blank" href="<?php echo site_url();?>/form-view/'+data.form_name+'/'+data.form_version+'/view/'+data.unique_id+'">'+data.unique_id+'</a>';
                        }
                    }]
                });  
                
                $('html, body').animate({
                        scrollTop: $(".data_list_div").offset().top
                    }, 2000);  
            }
        </script>
    </body>
</html>