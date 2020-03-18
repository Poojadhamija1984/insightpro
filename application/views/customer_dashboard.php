<!DOCTYPE html>
<html>
<style type="text/css">
table, tr, td {
    border: none;
}
</style>
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
                 <!-- BREADCRUMB SECTION START -->
                 <div class="breadcrumb-section">
                    <div class="breadcrumb-inner d-flex align-items-center justify-content-between">
                        <div class="breadcrumb-left">
                            <h3 class="page-title">Dashboard</h3>
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item filter-item">
                                    <!-- <span id="tillDate"><?php echo $tilldate;?></span> -->
                                    <div class="input-field m-0">
                                        <i class="material-icons prefix">access_time</i>
                                        <select id="date_range" name="date_range">
                                            <option value="OneDay">1 day</option>
                                            <option value="Today">Today</option>
                                            <option value="OneWeek">1 week</option>
                                            <option value="TwoWeeks">2 weeks</option>                                                    
                                            <option value="PreviousMonth">Previous Month</option>
                                            <option value="CurrentMonth" selected>Current Month</option>
                                            <option value="QuartertoDate">Quarter to date</option>
                                            <option value="YearDate">Year to date</option>
                                            <option value="OneYear">1 year</option>
                                            <option value="Custom">Custom Date</option>
                                        </select>
                                        <!-- <label for="date_range">Date</label> -->
                                    </div>
                                    <div class="input-field m-0 filter_dates">
                                        <input type="text" name="filter_start_date" class="datepicker">
                                        <input type="text" name="filter_end_date" class="datepicker">
                                    </div>
                                </li>
                            </ul>
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
                                        <h5 class="stats-heading">Total Evaluations</h5>
                                        <span class="stats-count total_evulation"><?php echo (!empty($total_evulation)?$total_evulation:0); ?></span>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>10% from last month</span>
                                        </p> -->
                                    </div>
                                 </div>
                                <div class="col m4">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Overall LOB Average</h5>
                                        <span class="stats-count overall_avg"><?php echo (!empty($avg)?$avg."%":"0%"); ?></span>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>10% from last month</span>
                                        </p> -->
                                    </div>
                                </div>
                                    <div class="col m4">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Average</h5>
                                        <span class="stats-count total_avg"><?php echo (!empty($agent_total_evalution_avg)?$agent_total_evalution_avg."%":"0%"); ?></span>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>10% from last month</span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m4" style="display: none">
                                    <div class="chart_outer py-15">
                                        <h4 class="progress_title">Details</h4>
                                        <div class="row">
                                            <div class="col xs6">LOB</div>
                                            <div class="col xs6"><?php echo $agentlob;?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col xs6">Supervisor Name</div>
                                            <div class="col xs6"><?php echo $sup_name;?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col xs6">Campaign</div>
                                            <div class="col xs6"><?php echo $agentCmp;?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col xs6">Vendor</div>
                                            <div class="col xs6"><?php echo $agentvendor;?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col xs6">Location</div>
                                            <div class="col xs6"><?php echo $agentlocation;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col m4">
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
                                                    <td>LOB</td>
                                                    <td><?php echo $agentlob;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Supervisor Name</td>
                                                    <td><?php echo $sup_name;?></td>
                                                </tr>
                                                <?php 
                                                    if(!empty($agentCmp)){
                                                ?>
                                                    <tr>
                                                        <td>Campaign</td>
                                                        <td><?php echo $agentCmp;?></td>
                                                    </tr>
                                                <?php 
                                                }
                                                if(!empty($agentvendor)){
                                                ?>
                                                <tr>
                                                    <td>Vendor</td>
                                                    <td><?php echo $agentvendor;?></td>
                                                </tr>
                                                <?php 
                                                }
                                                if(!empty($agentlocation)){
                                                ?>
                                                <tr>
                                                    <td>Location</td>
                                                    <td><?php echo $agentlocation;?></td>
                                                </tr>
                                                <?php 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>                                    
                                </div>
                                <div class="col QAscore_cards m8">
                                    <div class="chart_outer">
                                        <div id="evalution_chart" style="height: 234px;"></div>
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
        <script>
            $('#date_range').change(function(){
                var dd = $(this).val();
                if(dd === "Custom"){
                    $('.filter_dates').removeClass('hide').addClass('show');
                    var sdate = $("input[name='filter_start_date']").val();
                    var edate = $("input[name='filter_end_date']").val();
                }
                else{
                    $('.filter_dates').removeClass('show').addClass('hide');
                    var sdate = '';
                    var edate = '';
                }
                var data = {'condition':dd,'sdate':sdate,'edate':edate};
                filterData(dd,sdate,edate);
            });
            $('.datepicker').change(function(){
                var sdate = $("input[name='filter_start_date']").val();
                var edate = $("input[name='filter_end_date']").val();
                var data = {'condition':$('#date_range').val(),'sdate':sdate,'edate':edate};
                filterData($('#date_range').val(),sdate,edate);
            });
            function filterData(dr,sd,ed){
                var base_url = '<?php echo site_url();?>/filter';
                if(dr === 'Custom'){
                    if(sd != '' && ed != ''){
                        var data = {'condition':dr,'sdate':sd,'edate':ed}
                        var response = postAjax_With_Loder(base_url,data);
                        $('.total_evulation').html(response.total_evulation);
                        $('.overall_avg').html(response.avg);
                        $('.total_avg').html(response.agent_total_evalution_avg);
                        agentEvulation(response.day_wise);  
                    }
                }
                else{                    
                    var data = {'condition':dr,'sdate':sd,'edate':ed}
                    var response = postAjax_With_Loder(base_url,data);
                    $('.total_evulation').html(response.total_evulation);
                    $('.overall_avg').html(response.avg);
                    $('.total_avg').html(response.agent_total_evalution_avg);
                    agentEvulation(response.day_wise);
                }
            }

            var day_wise = '<?php echo json_encode((!empty($day_wise)?$day_wise:[]));?>';
            day_wise     =   JSON.parse(day_wise);
            agentEvulation(day_wise);
            /*line-bar dual axis start*/
            function agentEvulation(day_wise){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("evalution_chart", am4charts.XYChart);
                    chart.padding(20, 0, 0, 0);
                    chart.margin(0, 0, 0, 0);
                    chart.data = day_wise;
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "year";
                        categoryAxis.renderer.minGridDistance = 15;
                        categoryAxis.renderer.grid.template.disabled = true;
                        categoryAxis.renderer.baseGrid.disabled = true;
                        categoryAxis.renderer.labels.template.fill = am4core.color("#565656");
                        categoryAxis.renderer.labels.template.fontSize = 10;
                        //categoryAxis.renderer.labels.template.horizontalCenter = "left";
                        categoryAxis.renderer.labels.template.verticalCenter = "middle";
                        categoryAxis.renderer.labels.template.rotation =360;
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.title.text = "Evaluation";
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
                        series.name = "Days";
                        series.dataFields.valueY = "total_evulation";
                        series.dataFields.categoryX = "year";
                        series.stroke = am4core.color("#8e24aa");
                        series.strokeWidth = 2;
                        series.propertyFields.strokeDasharray = "lineDash";
                        series.tooltip.label.textAlign = "middle";
                        var bullet = series.bullets.push(new am4charts.Bullet());
                            bullet.fill = am4core.color("#ffffff"); // tooltips grab fill from parent by default
                            bullet.tooltipText = "[#000 font-size: 12px]Total {name} on {categoryX}: [/][#000 font-size: 12px]{valueY}[/] [#000]{additional}[/]"
                            var circle = bullet.createChild(am4core.Circle);
                                circle.radius = 4;
                                circle.fill = am4core.color("#8e24aa");
                                circle.stroke = am4core.color("transparent");
                                circle.strokeWidth = 0;
                    chart.legend = new am4charts.Legend();
                    chart.legend.markers.template.useDefaultMarker = true;
                });
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
    </body>
</html>