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
                                   <li class="breadcrumb-item"><span>Autofail</span></li>
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
                                     //echo form_open(site_url().'/autofail-audit-summary', $attributes);
                                     echo form_open(site_url().'/autofail-attrubutes-summary', $attributes);?>
                                 <?php $this->load->view('common/report_filter_view') ?>
                                 <?php  echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <!-- FORM SECTION END -->

                    <!-- TABLE SECTION START Audit Summary-->
                    <div class="table-section mt-24 audit_summary_div" style="display:none">
                        <div class="card">
                            <div class="card-content audit_summary">
                                <h4 class="card-title">Report Data</h4>
                                
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->


                    <!-- TABLE SECTION START Attributes Summary-->
                    <div class="table-section mt-24 attrribute_summary_div" style="display:none">
                        <div class="card">
                            <div class="card-content attrribute_summary">
                                <h4 class="card-title">Report Data</h4>
                                
                            </div>
                        </div>
                    </div>
                    <!-- TABLE SECTION END -->


                    <!-- TABLE SECTION START Data List Summary-->
                    <div class="table-section mt-24 data_list_div" style="display:none">
                        <div class="card">
                            <div class="card-content report_list_summary">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Report Data</h4>
                                    <p class="m-0 qustion_headding"></p>
                                </div>
                                <table class="data_table  stripe hover" id="data_list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <!-- <th>Unique ID</th> -->
                                            <th>Call ID</th>
                                            <th>Agent Name</th>
                                            <th>Supervisor Name</th>
                                            <th>Campaign</th>
                                            <th>LOB</th>
                                            <th>Vendor</th>
                                            <th>Location</th>
                                            <th>Comment</th>
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
                    $('.audit_summary_div').show();
                    $('.attrribute_summary_div').show();
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
                        var reports_results_all  = postAjax('<?php echo site_url();?>/autofail-audit-summary',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents});
                        $('.audit_summary').html('<h4 class="card-title">Summary</h4>'+reports_results_all);
                    
                        var reports_results_attr  = postAjax_With_Loder('<?php echo site_url();?>/autofail-attrubutes-summary',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents});
                        $('.attrribute_summary').html('<h4 class="card-title">Attributes Summary</h4>'+reports_results_attr);
                        if(reports_results_attr)
                        {
                            $('.report_div').show();
                            $('#btl_span').html('Run');
                            $('#submit').attr('disabled',false);
                        }
                    }
                    $('html, body').animate({
                        scrollTop: $(".audit_summary_div").offset().top
                    }, 2000);
                    
                }); 
            })

            function data_list(audit_from,audit_to,date_column,campaign,vendor,location,lob,agents,form_name,attr_id,autofail_qustion)
            {
                //alert(form_version);
               // alert(audit_from+'\n'+audit_to+'\n'+date_column+'\n'+campaign+'\n'+vendor+'\n'+location+'\n'+lob+'\n'+agent_name+'\n'+agent_id);
               $('.data_list_div').show();
               $('.qustion_headding').text(autofail_qustion);
               
                var reports_response  = postAjax('<?php echo site_url();?>/autofail-report-audit-list',{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents,'form_name':form_name,'attr_id':attr_id});
                //console.log(reports_response);  
                // $('.report_list_summary').html('<h4 class="card-title">Attributes Summary</h4>'+reports_response);
                
                $('#data_list').dataTable({
                    "bDestroy": true,
                    responsive: true,
                    fixedHeader: true,
                    scrollX : true,
                    scrollY : '30vh',
                    data:reports_response,
                    "columns": [
                        // { 'data': 'unique_id' }, 
                        { 'data': 'call_id' } ,
                        { 'data': 'agent_name' },
                        { 'data': 'supervisor' },
                        { 'data': 'campaign' },
                        { 'data': 'lob' },
                        { 'data': 'vendor' },
                        { 'data': 'location' } ,                
                        { 'data': 'comment' }                   
                    ],
                    columnDefs:[{
                        targets:[0],render:function(a,b,data,d)
                        {
                            return '<a target="_blank" href="<?php echo site_url();?>/form-view/'+data.form_name+'/'+data.form_version+'/view/'+data.unique_id+'">'+data.call_id+'</a>';
                        }
                    },
                    {
                        targets:[7],render:function(a,b,data,d)
                        {
                            return data.comment == ''? ' ---- ':data.comment;
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