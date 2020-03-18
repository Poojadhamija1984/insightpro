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
                                    <li class="breadcrumb-item"><span>Attribute</span></li>
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
                                <?php  //$attributes = array('class' => '','method'=>'POST');
                                    //echo form_open(site_url().'/ReportsController/scorecard_performance_report', $attributes);?>
                                 <?php $this->load->view('common/report_filter_view') ?>
                                 <?php //echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->
                    <!-- REPORT SECTION START -->
                    <!-- <div class="report-section mt-24">
                        <h3 class="attr-title">Lob wise attributes report</h3>
                        <div class="lob-category-card">
                            <span>LOB</span>
                            <span>CareTouch</span>
                        </div>
                        <ul class="attributes-list">
                            <li class="active" title="Process 1" data-target="process_1">Process 1</li>
                            <li title="Process 2" data-target="process_2">Process 2</li>
                            <li class="all" title="Process All" data-target="all">All</li>
                        </ul>
                        <div class="card attributes-card" data-ref="process_1" style="display:block;">
                            <div class="card-content">
                                <h4 class="card-title">Process 1</h4>
                                <ul class="collapsible cat-collapsible">
                                    <li>
                                        <div class="collapsible-header">Question 1 Used Standard Call Greeting</div>
                                        <div class="collapsible-body table-section">
                                            <table class="attr_dtable stripe hover" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor</th>
                                                        <th>Location</th>
                                                        <th>Total Evaluation</th>
                                                        <th>Applicability</th>
                                                        <th>Score</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TP</td>
                                                        <td>Indore</td>
                                                        <td>13</td>
                                                        <td>46.15%</td>
                                                        <td>83.33%</td>
                                                        <td>
                                                            <span>YYYY (5)</span>
                                                            <span>NNNN (1)</span>
                                                            <span>NNAA (7)</span>
                                                            <span>FFATAL (0)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">Question 2 Used Standard Call Greeting</div>
                                        <div class="collapsible-body table-section">
                                            <table class="attr_dtable stripe hover" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor</th>
                                                        <th>Location</th>
                                                        <th>Total Evaluation</th>
                                                        <th>Applicability</th>
                                                        <th>Score</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TP</td>
                                                        <td>Indore</td>
                                                        <td>13</td>
                                                        <td>46.15%</td>
                                                        <td>83.33%</td>
                                                        <td>
                                                            <span>YYYY (5)</span>
                                                            <span>NNNN (1)</span>
                                                            <span>NNAA (7)</span>
                                                            <span>FFATAL (0)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card attributes-card" data-ref="process_2">
                            <div class="card-content">
                                <h4 class="card-title">Process 2</h4>
                                <ul class="collapsible cat-collapsible">
                                    <li>
                                        <div class="collapsible-header">Question 1 Used Standard Call Greeting</div>
                                        <div class="collapsible-body table-section">
                                            <table class="attr_dtable stripe hover" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor</th>
                                                        <th>Location</th>
                                                        <th>Total Evaluation</th>
                                                        <th>Applicability</th>
                                                        <th>Score</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TP</td>
                                                        <td>Indore</td>
                                                        <td>13</td>
                                                        <td>46.15%</td>
                                                        <td>83.33%</td>
                                                        <td>
                                                            <span>YYYY (5)</span>
                                                            <span>NNNN (1)</span>
                                                            <span>NNAA (7)</span>
                                                            <span>FFATAL (0)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">Question 2 Used Standard Call Greeting</div>
                                        <div class="collapsible-body table-section">
                                            <table class="attr_dtable stripe hover" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Vendor</th>
                                                        <th>Location</th>
                                                        <th>Total Evaluation</th>
                                                        <th>Applicability</th>
                                                        <th>Score</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TP</td>
                                                        <td>Indore</td>
                                                        <td>13</td>
                                                        <td>46.15%</td>
                                                        <td>83.33%</td>
                                                        <td>
                                                            <span>YYYY (5)</span>
                                                            <span>NNNN (1)</span>
                                                            <span>NNAA (7)</span>
                                                            <span>FFATAL (0)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                    <!-- REPORT SECTION END -->

                    <!-- TABLE SECTION START -->
                    <div class="mt-24 report_div report-section" style="display:none">
                        <div class="card">
                            <div class="card-content table_data_div">
                                <h4 class="card-title">Lob Wise Attributes Summary</h4>
                                <?php if(!empty($table))
                                {
                                    echo $table;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->
                    <!-- TABLE SECTION Second Start -->
                    <div class="table-section mt-24 data_list_div" style="display:none">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Report Data</h4>
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
                     <!-- TABLE SECTION Second end -->
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
            $(document).ready(function(){
                //$('.cat-collapsible').collapsible();
                $('.attr_dtable').DataTable(
                    {
                        scrollX : true,
                        autoWidth: true,
                    }
                );
                $(document).on('click', '.attributes-list li:not(.active)', function(){
                    if($(this).hasClass('all')) {
                        $('.report-section').find('.attributes-card').slideDown(300);
                        $(this).addClass('all_active').siblings().removeClass('active').addClass('all_active');
                    } else {
                        var target_div = $(this).attr("data-target");
                        $('.report-section').find('.attributes-card[data-ref="'+target_div+'"]').slideDown(300).siblings('.attributes-card').slideUp(300);
                        $(this).addClass('active').siblings().removeClass('active all_active');
                    }
                })
            })
            $(function(){
                $('#submit').click(function(e){
                    e.preventDefault();
                    // $('#btl_span').html('Loading');
                    // $('#submit').attr('disabled',true);
                   
                   // $('.data_list_div').css('display','none');
                    var audit_from      = $('#audit_from').val();
                    var audit_to        = $('#audit_to').val();
                    var date_column     = $('#date_column').val();
                    var lob             = $('#lob').val();
                    var campaign        = $('#campaign').val();
                    var vendor          = $('#vendor').val();
                    var location        = $('#location').val();
                    var agents          = $('#agents').val();
                    var form_category   = $('#form_category').val();
                    var form_attributes = $('#form_attributes').val();
                    var form_version    = $('#form_version').val();
                    if((audit_from == null))
                    {
                        alert('Date from field is mandatory');
                        return false;
                    }
                    else if((audit_to == null)){
                        alert('Date to field is mandatory');
                        return false;
                    }else if((date_column == '')){
                        alert('Call Date field is mandatory');
                        return false;
                    }else if((lob == '')){
                        alert('Lob field is mandatory');
                        return false;
                    }else if((form_version == '')){
                        alert('Form version field is mandatory');
                        return false;
                    }
                    else{
                        $('#btl_span').html('Loading');
                        $('#submit').attr('disabled',true);
                        var reports_response  = postAjax_With_Loder('<?php echo site_url();?>/Scorecard-Performance-Report',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents,'form_version':form_version,'form_category':form_category,'form_attributes':form_attributes});
                        //console.log();
                        //$('.table_data_div').html(JSON.stringify(reports_response));
                        $('.table_data_div').html('<h4 class="card-title">Lob Wise Attributes Summary</h4>'+reports_response);
                        //console.log(reports_response);
                        //$('#submit').prop('disabled', false);
                        if(reports_response)
                        {
                            $('.report_div').show();
                            $('#btl_span').html('Run');
                            $('#submit').attr('disabled',false);
                        }  
                    }
                    // $('html, body').animate({
                    //     scrollTop: $(".report_div").offset().top
                    // }, 2000);
                    
                }); 
            });
            function data_list(form_name,attr_name,attr_value,audit_vander,audit_location)
            {
                $('.data_list_div').show();
                var audit_from      = $('#audit_from').val();
                var audit_to        = $('#audit_to').val();
                var date_column     = $('#date_column').val();
                var lob             = $('#lob').val();
                var campaign        = $('#campaign').val();
                var vendor          = $('#vendor').val();
                var location        = $('#location').val();
                var agents          = $('#agents').val();
                var form_category   = $('#form_category').val();
                var form_attributes = $('#form_attributes').val();
                var form_version    = $('#form_version').val();
                vendor = (vendor != '' ? vendor :audit_vander);
                location = (location != '' ? location :audit_location);
                
                var reports_response  = postAjax('<?php echo site_url();?>/Scorecard-Performance-Report-list',{'audit_from':audit_from,'audit_to':audit_to,
                                                    'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agent_id':agents,
                                                    'form_attributes':form_attributes,'form_category':form_category,'form_version':form_version,
                                                    'attr_name':attr_name,'attr_value':attr_value,'form_name':form_name});

                console.log(reports_response);
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
                            return '<a target="_blank" href="<?php echo site_url();?>/form-view/'+data.form_name+'/'+form_version+'/view/'+data.unique_id+'">'+data.unique_id+'</a>';
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