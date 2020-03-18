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
                                <h3 class="page-title">Dashboard</h3>
                                <ul class="breadcrumb-list">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <!-- <li class="breadcrumb-item"><span>Admin</span></li> -->
                                </ul>
                            </div>
                            <div class="breadcrumb-right"></div>
                        </div>
                    </div>
                    <!-- BREADCRUMB SECTION END -->
                    <!-- PAGE ERROR START -->
                    <?php 
                        if($this->session->flashdata('success')){
                    ?>
                        <div class="error_section">
                            <div class="page_error success mb-12"><?php echo $this->session->flashdata('success');?></div>
                        </div>
                    <?php 
                    }
                    if($this->session->flashdata('error')){
                    ?>
                        <div class="error_section">
                            <div class="page_error failure mb-12"><?php echo $this->session->flashdata('error');?></div>
                        </div>
                    <?php 
                        }
                    ?>
                    <!-- PAGE ERROR END -->
                    <!-- CARDS CONTAINER START -->
                    <div class="form-section mt-24">
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title"></h4>
                                <?php  
                                    $attributes = array('class' => '','method'=>'POST');
                                    echo form_open(site_url().'/dashboard', $attributes);
                                    $this->load->view('common/report_filter_view');
                                    echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="cards-section top mt-24">
                        <div class="col">
                            <div class="row mb-0">
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Overall QA</h4>
                                        <div id="chart_area1" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Section Wise Data</h4>
                                        <div id="chart_area2" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Arrtibute Wise Data</h4>
                                        <div class="chart-filter input-field">
                                            <select name="" id="categoryQA">
                                                <option value="" selected>Choose Option</option>
                                            </select>
                                        </div>
                                        <div id="chart_area3" class="charts_cont" style="height:136px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Auto-fail/fatal%(<small>With total evalution count</small>)</h4>
                                        <div id="chart_area4" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Pass Rate</h4>
                                        <div id="chart_area5" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Dispute/Escalation</h4>
                                        <div id="chart_area6" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Feedback</h4>
                                        <div id="chart_area7" class="charts_cont" style="height:160px;"></div>
                                    </div>
                                </div>

                                <!-- <div class="col s12 m6 l4">
                                    <div class="card">
                                        <h4 class="card-title">Lorem ipsum dolor</h4>
                                        <div id="chart_area4" class="charts_cont" style="height:220px;"></div>
                                    </div>
                                </div> -->
                                <!-- <div class="col s12 l6">
                                    <div class="card">
                                        <h4 class="card-title">Lorem ipsum dolor sit amet, consectetur</h4>
                                        <div id="chart_area6" class="charts_cont" style="height:240px;"></div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- CARDS CONTAINER END -->
                    <!-- TOP RESULTS SECTION START -->
                    <div class="results-section col">
                        <div class="row mb-0 d-flex flex-wrap">
                            <div class="col s12 l6">
                                <div class="card m-0">
                                    <div class="card-content table-section">
                                        <table class="attribute_table">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Top Attributes</th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0; 
                                                foreach ($rank['top'] as $key => $value) {
                                                    $count = ++$count;
                                                    echo "<tr><td>{$count}</td><td>{$value['name']}</td><td>{$value['avg']}</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 l6">
                                <div class="card m-0">
                                    <div class="card-content table-section">
                                        <table class="attribute_table">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Bottom Attributes </th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0; 
                                                foreach ($rank['bottom'] as $key => $value) {
                                                    $count = ++$count;
                                                    echo "<tr><td>{$count}</td><td>{$value['name']}</td><td>{$value['avg']}</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TOP RESULTS SECTION START -->
                    
                </div>
                <!-- MAIN CONTENTS START -->
            </main>
            <!-- MAIN SECTION END -->
            <!-- FOOTER SECTION START -->
            <?php $this->load->view('common/footer_view') ?>
            <!-- FOOTER SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php $this->load->view('common/footer_file_view') ?>

        <script type="text/javascript">
            var success = false;
            var overallqadata   =   '<?php echo json_encode($qa) ?>';
            var sectionqadata   =   '<?php echo json_encode($sqa) ?>';
            var arrtibuteqadata =   '';
            var autofailfatal   =   '<?php echo json_encode($affs) ?>';
            var passrate        =   '<?php echo json_encode($pr) ?>';
            var esc             =   '<?php echo json_encode($esc) ?>';
            var feed            =   '<?php echo json_encode($feed) ?>';
            overallqadata       =   JSON.parse(overallqadata);
            sectionqadata       =   JSON.parse(sectionqadata);
            autofailfatal       =   JSON.parse(autofailfatal);
            passrate            =   JSON.parse(passrate);
            esc                 =   JSON.parse(esc);
            feed                =   JSON.parse(feed);
            getCategory($('#lob').val());
            arrtibuteqadata1     =   attributes($('#categoryQA').val());
            console.log(arrtibuteqadata1);
            console.log('autofailfatal');
            console.log(autofailfatal);
            var no_data = '<div class="d-flex justify-content-center align-items-center" style="height:100%">No Data found </div>';
            if(overallqadata){
                overallqa(overallqadata);
            }
            if(sectionqadata){
                barCharts('chart_area2',sectionqadata);
            }            
            if(autofailfatal){
                picCharts('chart_area4',autofailfatal);
            }
            if(passrate){
                picCharts('chart_area5',passrate);
            }
            if(esc){
                picCharts('chart_area6',esc);
            }
            if(feed){
                picCharts('chart_area7',feed);
            }
            /* over All QA Grahp*/
            function overallqa(overallqadata){
                if(overallqadata !== null){
                    AmCharts.makeChart("chart_area1", {
                        "type": "serial",
                        "theme": "none",
                        "categoryField": "evaluator_name",
                        "rotate": false,
                        "startDuration": 1,
                        "categoryAxis": {
                            "gridPosition": "start",
                            "titleColor": "#565656",
                            "titleFontSize": 12,
                            "gridColor": "transparents",
                            "dashLength": 0,
                            "color": "#565656",
                            "fontSize": 9,
                            "axisColor": "transparents",
                            "axisThickness": 0,
                            "labelRotation":45,
                            "labelFunction": trimLabel,
                        },
                        "trendLines": [],
                        "graphs": [                    
                            {
                                "balloonText": "Evalution count for \n[[evaluator_name]]:[[value]]",
                                "id": "AmGraph-2",
                                "fillAlphas": 1,
                                "fillColors": "#ff6e40",
                                "lineAlpha": 0,
                                "lineThickness": 0,
                                "title": "Expenses",
                                "type": "column",
                                "valueField": "count"
                            },
                            {
                                "balloonText": "Avg Evalution score for \n[[evaluator_name]]:[[value]]%",
                                "id": "AmGraph-1",
                                "fillAlphas": 1,
                                "fillColors": "#8e24aa",
                                "lineAlpha": 0,
                                "lineThickness": 0,
                                "title": "Income",
                                "type": "column",
                                "valueField": "avg"
                            }
                        ],
                        "guides": [],
                        "valueAxes": [
                            {
                                "axisAlpha": 0,
                                "titleColor": "#565656",
                                "titleFontSize": 12,
                                "gridColor": "transparents",
                                "dashLength": 0,
                                "color": "#565656",
                                "fontSize": 9,
                                "axisColor": "transparents",
                                "axisThickness": 0,
                            }
                        ],
                        "allLabels": [],
                        "balloon": {},
                        "titles": [],
                        "dataProvider": overallqadata,
                        "export": {
                            "enabled": true
                        }
                    });
                }
                else{
                    $('#chart_area3').html(no_data);
                }
            }
            /* End over All QA Grahp*/

            function barCharts(div,sectionqadata){
                if(sectionqadata !== null){
                    AmCharts.makeChart( div, {
                        "type": "serial",
                        "theme": "none",
                        "dataProvider": sectionqadata,
                        "valueAxes": [ {
                            //"title": "Axis title",
                            "titleColor": "#565656",
                            "titleFontSize": 12,
                            "gridColor": "transparents",
                            "dashLength": 0,
                            "color": "#565656",
                            "fontSize": 9,
                            "axisColor": "transparents",
                            "axisThickness": 0,
                        } ],
                        "gridAboveGraphs": true,
                        "startDuration": 1,
                        "graphs": [ {
                            "balloonText": "[[category]]: <b>[[avg]]</b>",
                            "fillAlphas": 1,
                            "fillColors": "#8e24aa",
                            //"fillColorsField": "color",
                            "lineAlpha": 0,
                            "lineThickness": 0,
                            "type": "column",
                            "valueField": "avg"
                        } ],
                        "chartCursor": {
                            "categoryBalloonEnabled": false,
                            "cursorAlpha": 0,
                            "zoomable": false
                        },
                        "categoryField": "name",
                        "categoryAxis": {
                            //"title": "Axis title 2",
                            "titleColor": "#565656",
                            "titleFontSize": 12,
                            "gridColor": "transparents",
                            "dashLength": 0,
                            "color": "#565656",
                            "fontSize": 9,
                            "axisColor": "transparents",
                            "axisThickness": 0,
                            "labelRotation":45,
                            "labelFunction": trimLabel,
                        },
                        "export": {
                            "enabled": true
                        }
                    });
                }
                else{
                    $('#chart_area2').html(no_data);
                }
            }

            
            function picCharts(divId,passrate){
                if(passrate != undefined){
                    // add a handler that we will trigger before the chart is created
                    AmCharts.addInitHandler(function(chart) {
                        // find out the biggest value
                        var maxValue = 0;
                        for (var x in chart.dataProvider) {
                            var value = chart.dataProvider[x][chart.valueField];
                            if (value > maxValue)
                                maxValue = value;
                        }
                        // set valueWidth according to the biggest value
                        if (1000000000 <= maxValue)
                            chart.legend.valueWidth = 100;
                        else if (1000000 <= maxValue)
                            chart.legend.valueWidth = 70;
                        else if (1000 <= maxValue)
                            chart.legend.valueWidth = 40;
                    }, ['pie']);
                    var chart = AmCharts.makeChart(divId, {
                        "type": "pie",
                        "theme": "none",
                        "radius": 30,
                        // "depth3D": 15,
                          // "angle": 25,
                        "legend": {
                            "align": "center",
                            "markerType": "circle",
                            "position": "bottom",
                            "marginRight": 10,
                            "autoMargins": true
                        },
                        "export": {
                            "enabled": true
                        },
                        "fillAlphas"  : 0,
                        "dataProvider"  : passrate,
                        "colorField" :'color',
                        "valueField": "score",
                        "titleField": "category",
                        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>"
                    });



                    // AmCharts.makeChart("chart_area4",{
                    //     "type": "pie",
                    //     "radius": 40 ,
                    //     "titleField"  : "category",
                    //     "valueField"  : "score",
                    //     "dataProvider"  : passrate,
                    //     "colorField": "color",
                    //     "balloon": {
                    //         "fixedPosition": true
                    //     }
                    // });
                }
                else{
                    $('#chart_area4').html(no_data);
                }
            }
            
            function trimLabel(label, item, axis) {
                var chartWidth = axis.chart.realWidth;
                var maxLabelLength = 15; // not counting the dots...
                // trim when the width of the chart is smalled than 300px
                if (chartWidth <= 300 && label.length > 5)
                    return label.substr(0, 5) + "...";                
                // trim when the width of the chart is smalled than 500px
                if (chartWidth <= 500 && label.length > 10)
                    return label.substr(0, 10) + "...";
                // trim when label is longer than maxLabelLength regardless of chart width
                return label.length >= 15 ? label.substr(0, 14) + "...": label;
            }

            $(function(){
                $('#submit').click(function(e){
                    e.preventDefault();
                    var audit_from  = $('#audit_from').val();
                    var audit_to    = $('#audit_to').val();
                    var date_column = $('#date_column').val();
                    var lob         = $('#lob').val();
                    var campaign    = $('#campaign').val();
                    var vendor      = $('#vendor').val();
                    var location    = $('#location').val();
                    var agents      = $('#agents').val();
                    var base_url    = "<?php echo site_url();?>/dashboard";
                    if(lob != ""){
                        var response = postAjax(base_url,{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents});
                        console.log('----------QA------------')
                        console.log(response.qa);
                        console.log('----------QA------------')
                        console.log('----------SQA------------')
                        console.log(response.sqa);
                        console.log('----------SQA------------')
                        console.log('----------AFFS------------')
                        console.log(response.affs);
                        console.log('----------AFFS------------')
                        console.log('----------PR------------')
                        console.log(response.pr);
                        console.log('----------PR------------')
                        overallqa(response.qa);

                        // picCharts('chart_area1',response.affs);
                        barCharts('chart_area2',response.sqa);
                        picCharts('chart_area4',response.affs);
                        picCharts('chart_area5',response.pr);
                        picCharts('chart_area6',response.esc);
                        picCharts('chart_area7',response.feed);
                        setTimeout(function(){ attributes($('#categoryQA').val()); }, 3000);
                        
                    }
                    else{
                        alert('Please select LOB');
                        return false;
                    }
                });
                $('#lob').change(function(){
                    var response = getCategory($(this).val());
                });
                $('#categoryQA').change(function(){
                    var response = attributes($(this).val());
                });


            });

            function getCategory(lob){
                var response = postAjax("<?php echo site_url();?>/get-cat",{'lob':lob});
                var opt = '';
                $.each(response.lob, function(key,val){
                    if(key == 0)
                        opt +="<option value='"+val.category+"' selected>"+val.category+"</option>";
                    else
                    opt +="<option value='"+val.category+"'>"+val.category+"</option>";

                });
                $('#categoryQA').html("<option>Choose Option</option>");
                $('#categoryQA').append(opt);
                $('#categoryQA').formSelect();
                success = true;
            }

            function attributes(catId){
                if(success){
                    var audit_from      = $('#audit_from').val();
                    var audit_to        = $('#audit_to').val();
                    var date_column     = $('#date_column').val();
                    var lob             = $('#lob').val();
                    var campaign        = $('#campaign').val();
                    var vendor          = $('#vendor').val();
                    var location        = $('#location').val();
                    var agents          = $('#agents').val();
                    var categoryQA      = catId;
                    var base_url        = "<?php echo site_url();?>/get-attribute-data";
                    var response = postAjax(base_url,{'audit_from':audit_from,'audit_to':audit_to,'date_column':date_column,'lob':lob,'campaign':campaign,'vendor':vendor,'location':location,'agents':agents,'cat':categoryQA});
                    console.log('----------attributes------------')
                    console.log(response);
                    console.log('----------attributes------------')
                    barCharts('chart_area3',response);
                }
            }
        </script>
        
    </body>
</html>
