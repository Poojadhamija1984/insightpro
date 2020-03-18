    <!DOCTYPE html>
    <html>
    <?php $this->load->view('common/head_view') ?>
        <body class="content_loading dashboard_page nonbpo">
            <div class="page-wrapper">
                <!-- HEADER SECTION START-->
                <?php $this->load->view('common/header_view') ?>
                <!-- HEADER SECTION END-->
                <!-- SIDEBAR SECTION START -->
                <?php $this->load->view('common/sidebar_view') ?>
                <!-- SIDEBAR SECTION END -->
                <!-- MAIN SECTION START -->
                <main>
                    <!-- BREADCRUMB SECTION START -->
                    <div class="breadcrumb-section">
                        <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                            <div class="breadcrumb-left">
                                <h3 class="page-title">Dashboard</h3>                            
                            </div>
                            <div class="breadcrumb-right">
                                <a href="javascript:void(0)" class="btn_common filter_btn">Filter</a>
                            </div>       
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- MAIN CONTENTS START -->
                    <div class="main-contents">
                    <?php $this->load->view('other/common_filter')?>
                        <!-- CARDS CONTAINER START -->
                        <div class="cards-section">
                            <!-- <div class="heading-area d-flex align-items-center justify-content-between">
                                <h3 class="heading-title">Overall Score</h3>
                                <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                            </div> -->
                            <div class="col">
                                <div class="row mb-0">
                                    <div class="col m4">
                                        <div class="status-card card gradient-45deg-purple-deep-orange">
                                            <h5 class="stats-heading">Audit Conducted</h5>
                                            <span class="total_count stats-count"><?php //echo ((!empty($head['total_count']))?$head['total_count']:0);?></span>                                            
                                        </div>
                                    </div>
                                    <div class="col m4">
                                        <div class="status-card card gradient-45deg-purple-deep-orange">
                                            <h5 class="stats-heading">Audit Score</h5>
                                            <span class="total_avg stats-count">
                                                <?php
                                                    // echo (!empty($head['total_avg'])?$head['total_avg']."%":0);
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col m4">
                                        <div class="status-card card gradient-45deg-purple-deep-orange">
                                            <h5 class="stats-heading">Audits Reviewed </h5>
                                            <span class="total_failed stats-count">
                                                <?php
                                                    // echo (!empty($head['failed'])?$head['failed']:0);
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- <div class="col m3">
                                        <div class="status-card card gradient-45deg-purple-deep-orange">
                                            <h5 class="stats-heading">Best Group Performance</h5>
                                            <span class="stats-count">
                                                <?php
                                                    //echo (!empty($escalationRate['esc_rate_count']['escavg'])?$escalationRate['esc_rate_count']['escavg']:0)."%";
                                                ?>
                                            </span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col">
                                <div class="row mb-0">
                                    <!-- <div class="col m6 others_chart_outer mb-24">
                                        <h4 class="progress_title"> Audit Count</h4>  
                                        <div class="chart_outer">                                          
                                            <div id="audit_count" class="other_sm_charts others_charts"></div>
                                        </div>
                                    </div> -->
                                    <div class="col m12 others_chart_outer mb-24">
                                        <h4 class="progress_title">Audit Performance</h4>
                                        <div class="chart_outer">
                                            <div id="audit_count" class="other_sm_charts"></div>
                                        </div>
                                    </div>
                                    <div class="col m6 others_chart_outer mb-24">
                                        <h4 class="progress_title">Response Breakdown</h4>
                                        <div class="chart_outer">
                                            <div class="chart_selects">
                                               
                                               
                                                <select id="temp_attr">
                                                <option value="">Select Attribute</option>
                                                    <?php 
                                                        $selected = '';
                                                        foreach ($response_option as $key => $value) {
                                                            $opt_text = str_replace("|", ",", $value->opt_text);
                                                            if($value->opt_value == $template_response_details->opt_value){
                                                                echo "<option value='$value->opt_value' selected>$opt_text</option>";
                                                            }
                                                            else{
                                                                echo "<option value='$value->opt_value'>$opt_text</option>";
                                                            }                                                      
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div id="response_breakdown" class="other_sm_charts"></div>
                                        </div>
                                    </div>
                                    <div class="col m6 others_chart_outer mb-24">
                                        <h4 class="progress_title">Category Performance</h4>
                                        <div class="chart_outer">
                                            <div class="chart_selects chart_selects_failed_action">
                                               
                                               
                                            </div>
                                            <div id="category_chart" class="other_sm_charts" style="height: 270px;"></div>
                                        </div>
                                    </div>
                                    <div class="col m6 others_chart_outer">
                                        <h4 class="progress_title">Fatal Attributes</h4>
                                        <div class="chart_outer">
                                            <div class="chart_selects chart_selects_failed_action">
                                                
                                            </div>
                                            <div id="top_failed_attr" class="other_sm_charts others_charts"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="col m6 others_chart_outer  mb-24">
                                        <h4 class="progress_title">Action Items</h4>
                                        <div class="chart_outer">
                                            <div class="chart_selects chart_selects_failed_action">
                                                
                                                
                                            </div>
                                            <div id="action_items" class="other_sm_charts"></div>
                                        </div>
                                    </div>
                                    <!--<div class="col m4 others_chart_outer  mb-24">
                                        <div class="mb-24">
                                            <h4 class="progress_title">Top 5 Audit Percentage</h4>
                                            <div class="chart_outer">
                                                <div id="top_auditor" class="other_sm_charts2"></div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <h4 class="progress_title">Bottom 5 Audit Percentage</h4>
                                            <div class="chart_outer">
                                                <div id="bottom_auditor" class="other_sm_charts2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m6 others_chart_outer">
                                        <h4 class="progress_title">Top 5 Failed Template Audit</h4>
                                        <div class="chart_outer">
                                            <div id="bottom_failed_attr" class="other_sm_charts others_charts"></div>
                                        </div>
                                    </div>-->
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- CARDS CONTAINER END -->

                        
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
            <script src="<?=base_url()?>assets/js/circle-progress.min.js"></script>
            <script src="https://www.amcharts.com/lib/4/core.js"></script>
            <script src="https://www.amcharts.com/lib/4/charts.js"></script>
            <!--<script src="https://www.amcharts.com/lib/4/maps.js"></script>
            <script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>-->
            <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
            <script>
            // code by jai
            $(document).ready(function()
            {
                onchangeReviewer();
                
            });
            function onchangeReviewer()
            {
                
                    var user_type = '<?php echo $this->emp_group;?>';
                    var rangeValue = $('#date_range1').val();
                    var rangeValue_other = $('#date_range').val();
                    if(rangeValue=='Daily')
                    {
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();  
                    }else{
                        s_date = "";
                        e_date = "";
                    }
                    var rangeValue_other = $('#date_range').val();
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();
                    var sites = $('#sites').val();
                    var groups = $('#groups').val();
                    var templates = $('#templates').val();
                    var responseTemplate = $('#template').val();
                    var responseAttrValue = $('#temp_attr').val();
                    var responseAttrText = $("#temp_attr option:selected").text();
                    var data = {
                            'rangeValue'        : rangeValue,
                            'rangeValue_other'  : rangeValue_other,
                            's_date'            : s_date,
                            'e_date'            : e_date,
                            // 'sites'             : ((sites.length > 0)?sites:''),
                            // 'groups'            : ((groups.length > 0)?groups:''),
                            //'templates'         : ((templates.length > 0)?templates:''),
                            'templates'         : templates,
                            'responseTemplate'  : responseTemplate,
                            'responseAttrValue' : responseAttrValue,
                            'responseAttrText'  : responseAttrText
                        };
                        
                        var res = postAjax_With_Loder('<?php echo site_url()?>/dashboard-filter-data',data);
                        if(res != "error"){
                            $('.total_count').html(res.head.total_count);
                            $('.total_avg').html(res.head.total_avg+"%");
                            $('.total_failed').html(res.reviewedcount);
                            
                           var cat=(res.category[0] !="" || res.category[0]!="")?res.category:"";
                           categoryListGraph(cat);
                            actionItemsCharts(res.actionitems);
                            auditCount(res.all_audit);
                            //auditCountAvg(res.all_audit.avg);
                           // breakDownAttr(templates);
                            //topAuditor("top_auditor",res.auditor.top);
                            //topAuditor("bottom_auditor",res.auditor.bottom);
                            responseBreakdown(res.breakdown);
                            //if(user_type === 'manager'){
                                var failedres = (res.failed !="")?res.failed.top:res.failed;
                                failedPercentage("top_failed_attr",failedres);
                             // failedPercentage("bottom_failed_attr",res.failed.bottom);
                             
                            //}
                            
                            
                        }
                        statusChange();  
                        

            }
            function statusChange(template)
            {
                var data = {'template':template}
                var res = postAjax_With_Loder('<?php echo site_url()?>/statusChangeAccTat',data);
            }
            </script>
            <script>
               $('#templates').change(function(){
                    var temp = $(this).val();
                    var res = postAjax_With_Loder('<?php echo site_url()?>/temp-opt',{'temp':temp});
                    $('#temp_attr').empty();
                    $('#temp_attr').append($("<option value='' disabled>Select Attribute</option>"));
                    $.each(res, function( key, val ) {
                        var opt_text = val.opt_text;
                        var newchar = ','
                        opt_text = opt_text.split('|').join(newchar);
                        console.log(opt_text);
                        $('#temp_attr').append($("<option></option>").attr("value",val.opt_value).text(opt_text)).formSelect();
                    });                    
                });

                $('#action_template').change(function(){
                    var temp = $(this).val();
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();
                    var sites = $('#sites').val();
                    var groups = $('#groups').val();
                    var data = {
                            's_date'            : s_date,
                            'e_date'            : e_date,
                            'templates'         : ((temp.length > 0)?temp:''),
                        };
                    var res = postAjax('<?php echo site_url()?>/action-items-filter',data);
                    if(res === "error"){
                        alertBox('Please Select Templates');
                    }
                    else{
                        actionItemsCharts(res.actionitems)
                    }
                    return false;                   
                });
                $('#failed_template').change(function(){
                    var temp = $(this).val();
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();
                    var data = {
                            's_date'            : s_date,
                            'e_date'            : e_date,
                            'templates[]'         : ((temp.length > 0)?temp:''),
                        };
                    var res = postAjax('<?php echo site_url()?>/top-templates-filter',data);
                    if(res === "error"){
                        alertBox('Please Select Templates');
                    }
                    else{
                        // console.log(res.length);return false;
                        failedPercentage("top_failed_attr",res.top);
                    }
                    return false;                   
                });
                $('#temp_attr').change(function(){
                    var attr = $(this).val();
                    var rangeValue = $('#date_range1').val();
                    var rangeValue_other = $('#date_range').val();
                    if(rangeValue=='Daily')
                    {
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();  
                    }else{
                        s_date = "";
                        e_date = "";
                    }
                    if(attr === ""){
                        alert("Please select response");
                        return false;
                    }else{
                        var temp_name = $('#templates').val();
                        var attr_text = $("#temp_attr option:selected").text();
                        var res = postAjax_With_Loder('<?php echo site_url()?>/temp-response-data',{'temp_name':temp_name,'attr_value':attr,'attr_name':attr_text,'s_date':s_date,'e_date':e_date,'rangeValue':rangeValue,'rangeValue_other':rangeValue_other});
                        responseBreakdown(res);

                    }
                });

                var kpiRetention =   '<?php echo json_encode((!empty($all_audit["count"])?$all_audit["count"]:[]));?>';
                kpiRetention     =   JSON.parse(kpiRetention);
                //auditCount(kpiRetention);
                
                var kpicsat =   '<?php echo json_encode((!empty($all_audit["avg"])?$all_audit["avg"]:[]));?>';
                kpicsat     =   JSON.parse(kpicsat);
               // auditCountAvg(kpicsat);

                var ta =   '<?php echo json_encode((!empty($auditor["top"])?$auditor["top"]:[]));?>';                
                ta     =   JSON.parse(ta);
                /*topAuditor("top_auditor",ta);*/
                var ba =   '<?php echo json_encode((!empty($auditor["bottom"])?$auditor["bottom"]:[]));?>';                
                ba     =   JSON.parse(ba);
                /*topAuditor("bottom_auditor",ba);*/
                var rbd =   '<?php echo json_encode((!empty($breakdown)?$breakdown:[]));?>';                
                rbd     =   JSON.parse(rbd);
                //responseBreakdown(rbd);
                var failedTop =   '<?php echo json_encode((!empty($failed["top"])?$failed["top"]:[]));?>';                
                failedTop     =   JSON.parse(failedTop);
               // failedPercentage("top_failed_attr",failedTop);
                var failedBottom =   '<?php echo json_encode((!empty($failed["bottom"])?$failed["bottom"]:[]));?>';
                failedBottom     =   JSON.parse(failedBottom);                
                /*failedPercentage("bottom_failed_attr",failedBottom);*/
                var actionitems =   '<?php echo json_encode((!empty($actionitems)?$actionitems:[]));?>';                
                actionitems     =   JSON.parse(actionitems);
                //actionItemsCharts(actionitems);

                $('.modal-trigger').click(function(){
                    $('#chart_modal').modal({
                        backdrop: 'static'
                    });
                }); 
                

                function auditCountAvg(kpicsat){
                    if(kpicsat != ""){
                        am4core.ready(function() {
                            am4core.useTheme(am4themes_animated);
                            var chart = am4core.create("audit_avg", am4charts.XYChart);
                            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                            chart.padding(20, 20, 20, 20);
                            chart.data = kpicsat;
                            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                                categoryAxis.dataFields.category = "day";
                                categoryAxis.renderer.grid.template.strokeWidth = 0;
                                categoryAxis.renderer.labels.template.location = 0.5;
                                categoryAxis.renderer.tooltipLocation = 0.5;
                                categoryAxis.renderer.minGridDistance = 30;
                                categoryAxis.renderer.labels.template.fill = am4core.color("#333333");
                                categoryAxis.renderer.labels.template.fontSize = 9;
                                categoryAxis.renderer.labels.template.disabled = false;
                                categoryAxis.renderer.labels.template.horizontalCenter = "center";
                                categoryAxis.renderer.labels.template.verticalCenter = "middle";
                                categoryAxis.renderer.labels.template.rotation = 10;
                                categoryAxis.renderer.ticks.template.disabled = true; 
                                categoryAxis.renderer.labels.template.tooltipText = "[font-size: 10px]{day}[/]";
                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                valueAxis.title.text = "Average(%)";
                                valueAxis.title.fill = am4core.color("#8e24aa");
                                valueAxis.title.fontSize = 12;
                                valueAxis.tooltip.disabled = true;
                                valueAxis.renderer.grid.template.strokeWidth = 0;
                                valueAxis.renderer.baseGrid.disabled = true;
                                valueAxis.renderer.labels.template.disabled = true;
                                valueAxis.renderer.grid.template.disabled = true;
                            var series = chart.series.push(new am4charts.LineSeries());
                                series.name = "Average";
                                series.dataFields.valueY = "avg";
                                series.dataFields.categoryX = "day";
                                series.stroke = am4core.color("#8e24aa");
                                series.strokeWidth = 2;
                                series.propertyFields.strokeDasharray = "lineDash";
                                series.tooltip.label.textAlign = "middle";
                                var bullet = series.bullets.push(new am4charts.Bullet());
                                    bullet.fill = am4core.color("#8e24aa"); // tooltips grab fill from parent by default
                                    bullet.tooltipText = "[#fff font-size: 12px]{name} on {day} : [/][#fff font-size: 12px]{valueY}% [/] [#000]{additional}[/]"
                                var circle = bullet.createChild(am4core.Circle);
                                    circle.radius = 4;
                                    circle.fill = am4core.color("#8e24aa");
                                    circle.stroke = am4core.color("transparent");
                                    circle.strokeWidth = 0;
                            chart.exporting.menu = new am4core.ExportMenu();
                        });
                    }
                    else{
                        $('#cset_chart').empty();
                        $('#cset_chart').append('<center>No Data Found</center>');
                    }
                }

                        function actionItemsCharts(kpicsat){
                            if(kpicsat !=""){
                            var datac = generateChartData(kpicsat);
                            
                            
                            am4core.ready(function() {

// Themes begin
                            am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
                            var chart = am4core.create("action_items", am4charts.XYChart);


// Add data
                            chart.data = datac;


// Create axes
                            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category = "date";
                            categoryAxis.renderer.grid.template.location = 0;
                            categoryAxis.renderer.labels.template.fontSize = 9;

                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                            valueAxis.renderer.inside = true;
                            valueAxis.renderer.labels.template.disabled = true;
                            valueAxis.min = 0;

// Create series
                            function createSeries(field, name) {
                            
                            // Set up series
                            var series = chart.series.push(new am4charts.ColumnSeries());
                            series.name = name;
                            series.dataFields.valueY = field;
                            series.dataFields.categoryX = "date";
                            series.sequencedInterpolation = true;
  
  // Make it stacked
                            series.stacked = true;
                            
                            // Configure columns
                            series.columns.template.width = am4core.percent(60);
                            series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:9px]{categoryX}: {valueY}%";
                            
                            // Add label
                            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                            labelBullet.label.text = "{valueY}%";
                            labelBullet.locationY = 0.5;
                            labelBullet.label.hideOversized = true;
                            
                            return series;
                            }

                        createSeries("Closed", "Closed");
                        createSeries("Overdue", "Overdue");
                        createSeries("Pending", "Pending");



// Legend
                        chart.legend = new am4charts.Legend();
                            });
                            }
                    else{
                        $('#action_items').empty();
                        $('#action_items').append('<center>No Data Found</center>');
                    }
                }

                function kpiResolutionGraph(kpiResolution){
                    if(kpiResolution.length > 0){
                        am4core.ready(function() {
                            am4core.useTheme(am4themes_animated);
                            var chart = am4core.create("resolution_chart", am4charts.XYChart);
                            chart.hiddenState.properties.opacity = 0; 
                            chart.data = kpiResolution;
                            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                                categoryAxis.renderer.grid.template.location = 0;
                                categoryAxis.dataFields.category = "month";
                                categoryAxis.renderer.minGridDistance = 20;
                                categoryAxis.renderer.grid.template.disabled = true;
                                categoryAxis.renderer.baseGrid.disabled = true;
                                categoryAxis.renderer.labels.template.fill = am4core.color("#8e24aa");
                                categoryAxis.renderer.labels.template.fontSize = 10;

                            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                                valueAxis.renderer.minGridDistance = 20;
                                valueAxis.renderer.grid.template.disabled = true;
                                valueAxis.renderer.baseGrid.disabled = true;
                                valueAxis.renderer.labels.template.disabled = true;

                            var series = chart.series.push(new am4charts.ColumnSeries());
                                series.name = "Resolution";
                                series.dataFields.categoryX = "month";
                                series.dataFields.valueY = "avg";
                                series.columns.template.strokeOpacity = 0;
                                series.columns.template.fillOpacity = 0.75;
                                series.columns.template.fill = am4core.color("#6191fe");
                                series.columns.template.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 12px]{valueY}[/] [#fff]{additional}[/]"
                                series.columns.template.propertyFields.stroke = "stroke";
                                series.columns.template.propertyFields.strokeWidth = "strokeWidth";
                                series.columns.template.propertyFields.strokeDasharray = "columnDash";
                                var hoverState = series.columns.template.states.create("hover");
                                    hoverState.properties.fillOpacity = 1;
                                    hoverState.properties.tension = 0.4;
                            chart.exporting.menu = new am4core.ExportMenu();
                        });
                    }
                    else{
                        $('#resolution_chart').append('No Data Found');
                    }
                }

               
        function failedPercentage(divId,response){
                  
                    if(response != ""){
                        am4core.ready(function() {
                            am4core.useTheme(am4themes_animated);
                            var chart = am4core.create(divId, am4charts.XYChart);
                            chart.hiddenState.properties.opacity = 0;
                            chart.data = response;
                            chart.padding(20, 15, 20, 15); 
                            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                                categoryAxis.dataFields.category = "question";
                                categoryAxis.renderer.inside = true;
                                categoryAxis.renderer.minGridDistance = 20;
                                categoryAxis.renderer.grid.template.disabled = true;
                                categoryAxis.renderer.grid.template.strokeWidth = 0;
                                categoryAxis.renderer.labels.template.location = 0.5;
                                categoryAxis.numberFormatter.numberFormat = "#";
                                categoryAxis.renderer.tooltipLocation = 0.5;
                                categoryAxis.renderer.cellStartLocation = 0.1;
                                categoryAxis.renderer.cellEndLocation = 0.9;
                                categoryAxis.renderer.labels.template.fill = am4core.color("#333333");
                                categoryAxis.renderer.labels.template.fontSize = 10;
                                categoryAxis.renderer.ticks.template.disabled = true;
                                let labelTemplate = categoryAxis.renderer.labels.template;
                                    labelTemplate.rotation = 0;
                                    labelTemplate.horizontalCenter = "left";
                                    labelTemplate.verticalCenter = "middle";
                                    labelTemplate.dy = 0; // moves it a bit down;
                            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                                valueAxis.title.text = "Average(%)";
                                valueAxis.title.fill = am4core.color("#8e24aa");
                                valueAxis.title.fontSize = 12;
                                valueAxis.tooltip.disabled = true;
                                valueAxis.renderer.minGridDistance = 10;
                                valueAxis.renderer.grid.template.strokeWidth = 0;
                                valueAxis.renderer.labels.template.fill = am4core.color("#333333");
                                valueAxis.renderer.labels.template.fontSize = 10;
                                valueAxis.renderer.labels.template.horizontalCenter = "center";
                                valueAxis.renderer.labels.template.verticalCenter = "middle";
                                valueAxis.renderer.labels.template.disabled = true;
                            var series = chart.series.push(new am4charts.ColumnSeries());
                                series.name = "Audits";
                                series.dataFields.categoryY = "question";
                                series.dataFields.valueX = "avg_score";
                                series.strokeWidth = 0;
                                series.columns.template.height = am4core.percent(100);
                                series.columns.template.fill = am4core.color("#fb8d8d");
                                series.columns.template.tooltipText = "[font-size: 12px]{valueX}% [/]";
                                series.sequencedInterpolation = true;
                            chart.exporting.menu = new am4core.ExportMenu();
                        });
                    }
                    else{
                        $('#'+divId).empty();
                        $('#'+divId).append('<center>No Data Found</center>');
                    }
                }

               function responseBreakdown(optresponse){
                   
                    if(optresponse == ""){
                        $('#response_breakdown').empty();
                        $('#response_breakdown').append('<center>No Data Found</center>');
                    }else{
                    am4core.ready(function() {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("response_breakdown", am4charts.PieChart);
                        var pieSeries = chart.series.push(new am4charts.PieSeries());
                        pieSeries.dataFields.value = "litres";
                        pieSeries.dataFields.category = "country";
                        chart.innerRadius = am4core.percent(30);
                        pieSeries.slices.template.stroke = am4core.color("#fff");
                        pieSeries.slices.template.strokeWidth = 2;
                        pieSeries.slices.template.strokeOpacity = 1;
                        pieSeries.slices.template.cursorOverStyle = [{"property": "cursor","value": "pointer"}];
                        pieSeries.ticks.template.disabled = true;
                        pieSeries.labels.template.disabled = true;
                        var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
                        shadow.opacity = 0;
                        var hoverState = pieSeries.slices.template.states.getKey("hover"); 
                        var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
                        hoverShadow.opacity = 0.7;
                        hoverShadow.blur = 5;
                        /*chart.legend = new am4charts.Legend();
                        chart.legend.useDefaultMarker = true;
                        chart.legend.labels.template.text = "[bold]{country}[/]";
                        chart.legend.labels.template.fontSize = 12;
                        let marker = chart.legend.markers.template.children.getIndex(0);
                            marker.cornerRadius(12, 12, 12, 12);
                            marker.strokeWidth = 2;
                            marker.strokeOpacity = 1;
                            marker.stroke = am4core.color("#ccc");
                        let markerTemplate = chart.legend.markers.template;
                            markerTemplate.width = 16;
                            markerTemplate.height = 16;*/
                        chart.data = optresponse;
                        chart.exporting.menu = new am4core.ExportMenu();
                    });
                    }
                }

                function categoryListGraph(category){
                    
                     if(category !="")
                     {
                    am4core.ready(function() {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("category_chart", am4charts.XYChart);
                        chart.exporting.menu = new am4core.ExportMenu();
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                        chart.data = category;
                        chart.padding(20, 20, 20, 20);
                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category = "name";
                            categoryAxis.renderer.grid.template.strokeWidth = 0;
                            categoryAxis.renderer.labels.template.location = 0.5;
                            categoryAxis.renderer.tooltipLocation = 0.5;
                            categoryAxis.renderer.minGridDistance = 30;
                            categoryAxis.renderer.labels.template.fill = am4core.color("#333333");
                            categoryAxis.renderer.labels.template.fontSize = 9;
                            categoryAxis.renderer.labels.template.disabled = false;
                            categoryAxis.renderer.labels.template.horizontalCenter = "center";
                            categoryAxis.renderer.labels.template.verticalCenter = "middle";
                            categoryAxis.renderer.labels.template.rotation = 10;
                            categoryAxis.renderer.ticks.template.disabled = true; 
                            categoryAxis.renderer.labels.template.tooltipText = "[font-size: 10px]{name}[/]";
                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                            valueAxis.tooltip.disabled = true;
                            valueAxis.title.text = "Percentage(%)";
                            valueAxis.title.fill = am4core.color("#8e24aa");
                            valueAxis.title.fontSize = 12;
                            valueAxis.tooltip.disabled = true;
                            valueAxis.renderer.grid.template.strokeWidth = 0;
                            valueAxis.renderer.baseGrid.disabled = true;
                            valueAxis.renderer.labels.template.disabled = true;
                            valueAxis.renderer.grid.template.disabled = true;
                        var series1 = chart.series.push(new am4charts.ColumnSeries());
                            series1.columns.template.tooltipText = "[font-size: 12px]{name}: {valueY.value}% [/]";
                            series1.columns.template.width = am4core.percent(60);
                            series1.name = "Series 1";
                            series1.dataFields.categoryX = "name";
                            series1.dataFields.valueY = "avg";
                            series1.stacked = true;
                            series1.columns.template.column.cornerRadiusTopLeft = 10;
                            series1.columns.template.column.cornerRadiusTopRight = 10;
                            series1.columns.template.adapter.add("fill", function(fill, target) {
                                return chart.colors.getIndex(target.dataItem.index);
                            });
                            series1.columns.template.adapter.add("stroke", function(stroke, target) {
                                return chart.colors.getIndex(target.dataItem.index);
                            })
                        var sumBullet = series1.bullets.push(new am4charts.LabelBullet());
                            sumBullet.label.text = "{valueY}%";
                            sumBullet.label.fill = am4core.color("#333333");
                            sumBullet.label.fontSize = 9;
                            sumBullet.verticalCenter = "bottom";
                            sumBullet.dy = -8;
                        chart.seriesContainer.zIndex = -1;
                    });
                     }else{
                            $('#category_chart').empty();
                            $('#category_chart').append('<center>No Data Found</center>');
                     }
                }

                var bcrumb_top = $("header").outerHeight();
                $(document).ready(function(){
                    if($(window).scrollTop() > bcrumb_top) {
                        $(".breadcrumb-section").addClass("sticky");
                    }
                });
                $(window).on("scroll",function(){
                    if($(window).scrollTop() > bcrumb_top) {
                        $(".breadcrumb-section").addClass("sticky");
                    }
                    else {$(".breadcrumb-section").removeClass("sticky");}
                });
                

                // chart first jai
                function auditCount(audit_count){
                        //console.log(day_wise);
                       
                        if(audit_count != "")
                        {
                    am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("audit_count", am4charts.XYChart);
                    chart.padding(20, 0, 0, 0);
                    chart.margin(0, 0, 0, 0);
                    chart.data = audit_count;
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "day";
                        categoryAxis.renderer.minGridDistance = 15;
                        categoryAxis.renderer.grid.template.disabled = true;
                        categoryAxis.renderer.baseGrid.disabled = true;
                        categoryAxis.renderer.labels.template.fill = am4core.color("#565656");
                        categoryAxis.renderer.labels.template.fontSize = 10;
                        //categoryAxis.renderer.labels.template.horizontalCenter = "left";
                        categoryAxis.renderer.labels.template.verticalCenter = "middle";
                        categoryAxis.renderer.labels.template.rotation = 10;
                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        // valueAxis.title.text = "Evaluation";
                        valueAxis.title.fill = am4core.color("#363636");
                        valueAxis.title.fontSize = 12;
                        valueAxis.title.fontWeight = "bold";
                        valueAxis.renderer.minGridDistance = 30;
                        valueAxis.renderer.grid.template.disabled = true;
                        valueAxis.renderer.baseGrid.disabled = false;
                        valueAxis.renderer.labels.template.fill = am4core.color("#565656");
                        valueAxis.renderer.labels.template.fontSize = 10;
                        valueAxis.min = 0;
                    var series = chart.series.push(new am4charts.LineSeries());
                        series.name = "Audit Performance";
                        series.dataFields.valueY = "count";
                        series.dataFields.categoryX = "day";
                        series.dataFields.avg_score = "tscore";
                        series.stroke = am4core.color("#8e24aa");
                        series.strokeWidth = 2;
                        series.propertyFields.strokeDasharray = "lineDash";
                        series.tooltip.label.textAlign = "middle";
                        var bullet = series.bullets.push(new am4charts.Bullet());
                            bullet.fill = am4core.color("#ffffff"); // tooltips grab fill from parent by default
                            bullet.tooltipText = "[#000 font-size: 12px]Total {name} on {categoryX}: [/][#000 font-size: 12px] {valueY} [/] [#000 font-size: 12px] {avg_score}%[/] [#000]{additional}[/]"
                            var circle = bullet.createChild(am4core.Circle);
                                circle.radius = 4;
                                circle.fill = am4core.color("#8e24aa");
                                circle.stroke = am4core.color("transparent");
                                circle.strokeWidth = 0;
                    chart.legend = new am4charts.Legend();
                    chart.legend.markers.template.useDefaultMarker = true;
                    chart.exporting.menu = new am4core.ExportMenu();
                });
                        }else{
                            $('#audit_count').empty();
                            $('#audit_count').append('<center>No Data Found</center>');
                        }
            } 
            function generateChartData(data) {
            var chartData = [],
            categories = {};
            for ( var i = 0; i < data.length; i++ ) {
            var newdate = data[ i ].time;
            var visits =  data[i].avg;
            var country = data[ i ].status;
            // add new data point
            if ( categories[ newdate ] === undefined ) {
             categories[ newdate ] = {
             date: newdate
            };
            chartData.push( categories[ newdate ] );
             }
    // add value to existing data point
            categories[ newdate ][ country ] = visits;
            }
            return chartData;
            }
            </script>
           
        </body>
    </html>