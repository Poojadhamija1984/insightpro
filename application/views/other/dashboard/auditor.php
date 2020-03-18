<!DOCTYPE html>
<html>
<!-- <style type="text/css">
table, tr, td {
    border: none;
}
</style> -->
<?php $this->load->view('common/head_view') ?>
    <body class="content_loading dashboard_page">
        <div class="page-wrapper">
            <!-- HEADER SECTION START-->
            <?php $this->load->view('common/header_view') ?>
            <!-- HEADER SECTION END-->
            <!-- SIDEBAR SECTION START -->
            <?php $this->load->view('common/sidebar_view') ?>
            <!-- SIDEBAR SECTION END -->
            <!-- MAIN SECTION START -->
            <main>
                <!-- Dashboard Filter Section Start -->
                <div class="dfilter-section">
                    <div class="dfilter-header"></div>
                    <div class="dfilter-contents col">
                        <div class="dfilter-inner row mb-0">
                            <div class="dfliter-item col m4 l3">
                                <select id="FormId" name="form_data" onchange="showAuditonchange()">
                                <?php if(!empty($form_details)) {
                                    foreach($form_details as $forms) { ?>
                                        <option value="<?php echo $forms->tmp_unique_id; ?>"><?php echo $forms->tmp_name; ?></option>
                                    <?php }
                                } ?>
                                </select>
                            </div>
                            <div class="dfliter-item col m4 l3">
                                <select id="date_range1" name="date_range" onchange="dependentData('date_range1')">
                                    <option value="Daily" selected>Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="dfliter-item filter_other col m4 l3">
                                <select id="date_range" name="date_range" onchange="showAuditonchange()">
                                </select>
                            </div>
                            <div class="dfliter-item filter_dates col m8 l6">
                                <div class="row mb-0">
                                    <div class="col m6"><input type="text" name="filter_start_date" class="datepicker" placeholder="Start Date"></div>
                                    <div class="col m6"><input type="text" name="filter_end_date" class="datepicker" onchange="showAuditonchange('Custom')" placeholder="End Date"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dashboard Filter Section End -->
                 <!-- BREADCRUMB SECTION START -->
                 <div class="breadcrumb-section">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Dashboard</h3>
                            </div>
                        <div class="breadcrumb-right filter_outer"></div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- CARDS CONTAINER START -->
                    <div class="cards-section">
                        <div class="col">
                            <div class="row mb-0">
                                <div class="col m4">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Total Audits</h5>
                                        <span class="stats-count total_evulation"><?php //echo (!empty($head['total_evulation'])?$head['total_evulation']:0); ?></span>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>10% from last month</span>
                                        </p> -->
                                    </div>
                                 </div>
                                <!-- <div class="col m4">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Groups & Sites Average</h5>
                                        <span class="stats-count overall_avg"><?php //echo (!empty($head['g_s_avg'])?$head['g_s_avg']:0); ?>%</span>
                                    </div>
                                </div> -->
                                <div class="col m4">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Form Average</h5>
                                        <span class="stats-count total_avg"><?php //echo (!empty($head['total_evulation_avg'])?$head['total_evulation_avg']:0); ?>%</span>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>10% from last month</span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col m4">
                                     <div class="chart_outer py-15">
                                        <table cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <h4 class="progress_title">Details</h4>
                                                    </td>
                                                </tr>    
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Group</td>
                                                    <td><?php //echo $groups;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Sites</td>
                                                    <td><?php //echo $sites;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Role</td>
                                                    <td><?php //echo $role;?></td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>                                    
                                </div> -->
                                <div class="col others_chart_outer QAscore_cards m12">
                                    <div class="chart_outer bg_white">
                                        <div id="evalution_chart" style="height: 234px;"></div>
                                    </div>
                                </div>
                                <!---start  Attribute chart -->
                                <div class="col m12 others_chart_outer mt-24">
                                    <h4 class="progress_title">Attribute Trending</h4>
                                    <div class="chart_outer bg_white">
                                        <div id="top_failed_attr" class="others_charts" style="height: 234px;"></div>
                                    </div>
                                        
                                </div>
                                <!--failed chart -->
                                <div class="col m12 others_chart_outer mt-24">
                                    <h4 class="progress_title">Owned Site wise Comparison</h4>
                                    <div class="chart_outer bg_white">
                                        <div id="chartdivsite" class="others_charts" style="height: 234px;"></div>
                                    </div>
                                </div>
                                <div class="col m12 others_chart_outer mt-24">
                                    <h4 class="progress_title">Owned Group wise Comparison</h4>
                                    <div class="chart_outer bg_white">
                                        <div id="chartdivgroup" class="others_charts" style="height: 234px;"></div>
                                    </div>
                                </div>
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
        <?php $this->load->view('common/footer_file_view') ?>
        <script src="https://www.amcharts.com/lib/4/core.js"></script>
        <script src="https://www.amcharts.com/lib/4/charts.js"></script>
        <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
        <script src='https://cdn.jsdelivr.net/lodash/4.17.2/lodash.min.js'></script>
        
        <script>
            // $('#date_range').change(function(){
            //     var dd = $(this).val();
                
                // if(dd === "Custom"){
                //     $('.filter_dates').removeClass('hide').addClass('show');
                //     var sdate = $("input[name='filter_start_date']").val();
                //     var edate = $("input[name='filter_end_date']").val();
                // }
                // else{
                //     $('.filter_dates').removeClass('show').addClass('hide');
                //     var sdate = '';
                //     var edate = '';
                // }
            //     var data = {'condition':dd,'sdate':sdate,'edate':edate};
            //     filterData(dd,sdate,edate);
            // });
            // $('.datepicker').change(function(){
            //     var sdate = $("input[name='filter_start_date']").val();
            //     var edate = $("input[name='filter_end_date']").val();
            //     var data = {'condition':$('#date_range').val(),'sdate':sdate,'edate':edate};
            //     filterData($('#date_range').val(),sdate,edate);
            // });
            // function filterData(dr,sd,ed){
            //     var base_url = '<?php echo site_url();?>/auditor-filter';
            //     if(dr === 'Custom'){
            //         if(sd != '' && ed != ''){
            //             var data = {'condition':dr,'sdate':sd,'edate':ed}
            //             var response = postAjax_With_Loder(base_url,data);
            //             //console.log(response);return false;
            //             $('.total_evulation').html(response.total_evulation);
            //             $('.overall_avg').html(response.g_s_avg);
            //             $('.total_avg').html(response.total_evulation_avg);
            //             agentEvulation(response.day_wise_audit);  
            //         }
            //     }
            //     else{                    
            //         var data = {'condition':dr,'sdate':sd,'edate':ed}
            //         var response = postAjax_With_Loder(base_url,data);
            //         //console.log(response);return false;
            //         $('.total_evulation').html(response.total_evulation);
            //             $('.overall_avg').html(response.g_s_avg);
            //             $('.total_avg').html(response.total_evulation_avg);
            //             agentEvulation(response.day_wise_audit);
            //     }
            // }
            // code write by jai for dashboard 
            $(document).ready(function(){
            //depTimeFilter ={"Today":"Today","Custom":"Custom Date"};
            $('.filter_other').removeClass('show').addClass('hide');
            $('.filter_dates').removeClass('hide').addClass('show');
            // var html ="";
            // for(var key in depTimeFilter)
            // {
            // html += "<option value='"+key+"'>"+depTimeFilter[key]+"</option>";
            // }
            // $("#date_range").append(html).formSelect();
            });
            $(document).ready(function(){
                var formId =$('#FormId').val();
                var dateRange   =  $('#date_range1').val();
                if(dateRange=="Daily")
                {
                    var dateRange_other = "Today"; 
                }else{
                    var dateRange_other =  $('#date_range').val();
                }
                
                var base_url = '<?php echo site_url();?>/auditor-filter';
                var sdate = $("input[name='filter_start_date']").val();
                var edate = $("input[name='filter_end_date']").val();
                var data = {'formId':formId,'condition':dateRange,'condition_other':dateRange_other,'sdate':sdate,'edate':edate};
                var response = postAjax_With_Loder(base_url,data);
                
                //console.log(response[0].total_evulation);return false;
                $('.total_evulation').html(response.form_wise_data[0]['total_evulation']);
                $('.overall_avg').html(response.g_s_avg);
                if(Math.round(response.form_wise_data[0]['total_evulation_avg'])!=0)
                {
                $('.total_avg').html(Math.round(response.form_wise_data[0]['total_evulation_avg'])+'%');
                }else{
                    $('.total_avg').html(0+'%'); 
                }
                agentEvulation(response.day_wise_audit);
                var faildata = (response.failed!="") ? response.failed.top :[];
                failedPercentage("top_failed_attr",faildata);
                sitecompChart(response.site_wise_data);
                groupwisechart(response.group_wise_data);
                });
            // var day_wise = '<?php // echo json_encode((!empty($head['day_wise_audit'])?$head['day_wise_audit']:[]));?>';
            // day_wise     =   JSON.parse(day_wise);
            // agentEvulation(day_wise);
            /*line-bar dual axis start*/
            function showAuditonchange(cus_val)
            {
               
                var formId =$('#FormId').val();
                
                var dateRange_other = '';
                var dateRange ='';
                var base_url = '<?php echo site_url();?>/auditor-filter';
                var sdate ='';
                var edate ='';
                if(cus_val=='Custom')
                {
                     dateRange_other = cus_val;
                     sdate = $("input[name='filter_start_date']").val();
                     edate = $("input[name='filter_end_date']").val();
                }else{
                    
                    dateRange   =  $('#date_range1').val();
                    dateRange_other = (dateRange=='Daily')?'Today':$('#date_range').val();
                   }
                
                var data = {'formId':formId,'condition':dateRange,'condition_other':dateRange_other,'sdate':sdate,'edate':edate};
                var response = postAjax_With_Loder(base_url,data);
                
                //console.log(response[0].total_evulation);return false;
                $('.total_evulation').html(response.form_wise_data[0]['total_evulation']);
                $('.overall_avg').html(response.g_s_avg);
                if(Math.round(response.form_wise_data[0]['total_evulation_avg'])!=0)
                {
                $('.total_avg').html(Math.round(response.form_wise_data[0]['total_evulation_avg'])+'%');
                }else{
                    $('.total_avg').html(0+'%'); 
                }
                agentEvulation(response.day_wise_audit);
                var faildata = (response.failed!="") ? response.failed.top :[];
                failedPercentage("top_failed_attr",faildata);
                sitecompChart(response.site_wise_data);
                groupwisechart(response.group_wise_data);
            }
                    function agentEvulation(day_wise){
                        //console.log(day_wise);
                        if(day_wise != "")
                        {
                    am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("evalution_chart", am4charts.XYChart);
                    chart.padding(20, 0, 0, 0);
                    chart.margin(0, 0, 0, 0);
                    chart.data = day_wise;
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
                        series.name = "Audit-QA Trending";
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
                            $('#evalution_chart').empty();
                            $('#evalution_chart').append('<center>No Data Found</center>');
                        }
            } 
            /*linebar dual axis end*/
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
        </script>
        <script>
        function dependentData(id)
        {
            
            var textVal = $('#'+id).val();
            var depTimeFilter ={};
            $("#date_range").empty();
            if(textVal=='Daily')
            {
                $('.filter_other').removeClass('show').addClass('hide');
                $('.filter_dates').removeClass('hide').addClass('show');
                 depTimeFilter ={"Today":"Today","Custom":"Custom Date"};
                location.reload(true);
                   
            }else{
                $('.filter_other').removeClass('hide').addClass('show');
                $('.filter_dates').removeClass('show').addClass('hide');
            }
            var html ="";
            
            if(textVal=='Weekly')
            {
                depTimeFilter ={'':'Select Week' ,"1_Weeks":"1 Week","3_Weeks":"3 Weeks","4_Weeks":"4 Weeks"};
            }else if(textVal=='Monthly')
            {
                depTimeFilter ={'':'Select Month',"1_Months":"1 Month","3_Months":"3 Months","6_Months":"6 Months","12_Months":"12 Months"};
            }else if(textVal=='Yearly')
            {
                depTimeFilter ={"1Year":"1 Year","3Year":"3 Year","6Year":"6 Year"}; 
            }
            for(var key in depTimeFilter)
            {
            html += "<option value='"+key+"'>"+depTimeFilter[key]+"</option>";
            }
            
            $("#date_range").append(html).formSelect();
           
        }
       // Attribute chart 
        function failedPercentage(divId,response){
                    if(response == ""){
                        $('#'+divId).empty();
                        $('#'+divId).append('<center>No Data Found</center>');
                    }else{
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
                                categoryAxis.renderer.labels.template.rotation = 10;
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
                    
                }
 function sitecompChart(data)
 {
    
    showChart('chartdivsite',data)
}   
 function groupwisechart(groupdata)
    {
    showChart('chartdivgroup',groupdata); 
    }          
function showChart(c_ids="",datas)
{
   if(datas !="")
   {
am4core.ready(function() {
am4core.useTheme(am4themes_animated);
var chart = am4core.create(c_ids, am4charts.XYChart);
chart.paddingBottom = 50;
chart.cursor = new am4charts.XYCursor();
chart.scrollbarX = new am4core.Scrollbar();
var colors = {};
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "category";
categoryAxis.renderer.minGridDistance = 60;
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.labels.template.rotation = 10;
categoryAxis.dataItems.template.text = "";
categoryAxis.adapter.add("tooltipText", function(tooltipText, target){
  return categoryAxis.tooltipDataItem.dataContext.realName;
})
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.tooltip.disabled = true;
valueAxis.min = 0;
var columnSeries = chart.series.push(new am4charts.ColumnSeries());
columnSeries.columns.template.width = am4core.percent(80);
columnSeries.tooltipText = "{provider}: {realName},Audit Count:{valueY},Avg Score:{avg_score}";
columnSeries.dataFields.categoryX = "category";
columnSeries.dataFields.valueY = "value";
// second value axis for quantity
var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis2.renderer.opposite = true;
valueAxis2.syncWithAxis = valueAxis;
valueAxis2.tooltip.disabled = true;
// quantity line series
var lineSeries = chart.series.push(new am4charts.LineSeries());
lineSeries.tooltipText = "{valueY}";
lineSeries.dataFields.categoryX = "category";
lineSeries.dataFields.valueY = "quantity";
lineSeries.yAxis = valueAxis2;
lineSeries.bullets.push(new am4charts.CircleBullet());
lineSeries.stroke = chart.colors.getIndex(13);
lineSeries.fill = lineSeries.stroke;
lineSeries.strokeWidth = 2;
lineSeries.snapTooltip = true;
// when data validated, adjust location of data item based on count
lineSeries.events.on("datavalidated", function(){
lineSeries.dataItems.each(function(dataItem){
// if count divides by two, location is 0 (on the grid)
if(dataItem.dataContext.count / 2 == Math.round(dataItem.dataContext.count / 2)){
dataItem.setLocation("categoryX", 0);
}
// otherwise location is 0.5 (middle)
else{
    dataItem.setLocation("categoryX", 0.5);
   }
 })
})

// fill adapter, here we save color value to colors object so that each time the item has the same name, the same color is used
columnSeries.columns.template.adapter.add("fill", function(fill, target) {
 var name = target.dataItem.dataContext.realName;
 if (!colors[name]) {
   colors[name] = chart.colors.next();
 }
 target.stroke = colors[name];
 return colors[name];
})


var rangeTemplate = categoryAxis.axisRanges.template;
rangeTemplate.tick.disabled = false;
rangeTemplate.tick.location = 0;
rangeTemplate.tick.strokeOpacity = 0.6;
rangeTemplate.tick.length = 60;
rangeTemplate.grid.strokeOpacity = 0.5;
rangeTemplate.label.tooltip = new am4core.Tooltip();
rangeTemplate.label.tooltip.dy = -10;
rangeTemplate.label.cloneTooltip = false;
///// DATA
var chartData = [];
var lineSeriesData = [];
var datac = generateChartData(datas);
//console.log(datac);
var data = _.mapValues(_.groupBy(datac, 'date'),
                          clist => clist.map(car => _.omit(car, 'date')));
                          //console.log(data);
    // process data ant prepare it for the chart
    
for (var providerName in data) {
 var providerData = data[providerName];
 var pd =providerData.toString();
 // add data of one provider to temp array
 var tempArray = [];
 var count = 0;
 // add items
 //console.log(providerData[0]);

 for (var itemName in providerData[0]) {
     //console.log(providerData[0][itemName]);
     var result=providerData[0][itemName].split(',');
     
   if(itemName != "quantity"){
   count++;
   // we generate unique category for each column (providerName + "_" + itemName) and store realName
   tempArray.push({ category: providerName + "_" + itemName, realName: itemName, value: result[0], provider: providerName,avg_score:result[1]})
   }
 }
 // sort temp array
 tempArray.sort(function(a, b) {
   if (a.value > b.value) {
   return 1;
   }
   else if (a.value < b.value) {
   return -1
   }
   else {
   return 0;
   }
 })

 // add quantity and count to middle data item (line series uses it)
 var lineSeriesDataIndex = Math.floor(count / 2);
 tempArray[lineSeriesDataIndex].quantity = providerData.quantity;
 tempArray[lineSeriesDataIndex].count = count;
 // push to the final data
 am4core.array.each(tempArray, function(item) {
   chartData.push(item);
 })

 // create range (the additional label at the bottom)
 var range = categoryAxis.axisRanges.create();
 range.category = tempArray[0].category;
 range.endCategory = tempArray[tempArray.length - 1].category;
 range.label.text = tempArray[0].provider;
 range.label.dy = 45;
 range.label.Rotation =270;
 range.label.truncate = true;
 range.label.fontWeight = "";
 range.label.tooltipText = tempArray[0].provider;

 range.label.adapter.add("maxWidth", function(maxWidth, target){
   var range = target.dataItem;
   var startPosition = categoryAxis.categoryToPosition(range.category, 0);
   var endPosition = categoryAxis.categoryToPosition(range.endCategory, 1);
   var startX = categoryAxis.positionToCoordinate(startPosition);
   var endX = categoryAxis.positionToCoordinate(endPosition);
   return endX - startX;
 })
}

chart.data = chartData;


// last tick
var range = categoryAxis.axisRanges.create();
range.category = chart.data[chart.data.length - 1].category;
range.label.disabled = true;
range.tick.location = 1;
range.grid.location = 1;


}); // end am4core.ready()
   }else{
    $('#chartdivgroup').empty();
    $('#chartdivgroup').append('<center>No Data Found</center>');
    $('#chartdivsite').empty();
    $('#chartdivsite').append('<center>No Data Found</center>');
   }
            }
function generateChartData(data) {
    var chartData = [],
    categories = {};
    for ( var i = 0; i < data.length; i++ ) {
    var newdate = data[ i ].date;
    var visits = parseInt(data[ i ].visits);
    var country = data[ i ].site_group;
    var avg_score = Math.round(data[i].avg_score);
    // add new data point
    if ( categories[ newdate ] === undefined ) {
        categories[ newdate ] = {
        date: newdate
      };
      chartData.push( categories[ newdate ] );
    }
    // add value to existing data point
    categories[ newdate ][ country ] = visits+','+avg_score;
  }
  return chartData;
}
                
        </script>
    </body>
</html>