    <!DOCTYPE html>
    <html>
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
                            <div class="col">
                                <div class="row mb-0">
                                    <div class="col m6 others_chart_outer mb-24">
                                        <h4 class="progress_title">Top 5 Audit Percentage</h4>
                                        <div class="chart_outer">
                                            <div id="top_auditor" class="other_sm_charts2"></div>
                                        </div>
                                    </div>
                                    <div class="col m6 others_chart_outer mb-24">
                                        <h4 class="progress_title">Bottom 5 Audit Percentage</h4>
                                        <div class="chart_outer">
                                            <div id="bottom_auditor" class="other_sm_charts2"></div>
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
            <!--JavaScript at end of body for optimized loading-->
            <?php $this->load->view('common/footer_file_view') ?>
            <script src="<?=base_url()?>assets/js/circle-progress.min.js"></script>
            <script src="https://www.amcharts.com/lib/4/core.js"></script>
            <script src="https://www.amcharts.com/lib/4/charts.js"></script>
            <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
            <script>
                $('.filter_submit').click(function(e){
                    e.preventDefault();
                    var s_date = $('#s_date').val();
                    var e_date = $('#e_date').val();
                    var sites = $('#sites').val();
                    var groups = $('#groups').val();
                    var templates = $('#templates').val();
                    var responseTemplate = $('#template').val();
                    var responseAttrValue = $('#temp_attr').val();
                    var responseAttrText = $("#temp_attr option:selected").text();
                    if(s_date === "" && e_date === "'"){
                        alert('Please select start date and end date');
                        return false;
                    }
                    else{
                        var data = {
                            's_date'            : s_date,
                            'e_date'            : e_date,
                            'sites'             : ((sites.length > 0)?sites:''),
                            'groups'            : ((groups.length > 0)?groups:''),
                            'templates'         : ((templates.length > 0)?templates:''),
                            'responseTemplate'  : responseTemplate,
                            'responseAttrValue' : responseAttrValue,
                            'responseAttrText'  : responseAttrText
                        };
                        var res = postAjax_With_Loder('<?php echo site_url()?>/dashboard-filter-data',data);
                        auditCount(res.all_audit.count);
                        auditCountAvg(res.all_audit.avg);
                        topAuditor("top_auditor",res.auditor.top);
                        topAuditor("bottom_auditor",res.auditor.bottom);
                        responseBreakdown(res.breakdown)
                        $('.total_count').html(res.head.total_count);
                        $('.total_avg').html(res.head.total_avg);
                        $('.total_failed').html(res.head.failed);
                    }
                });
                $('#template').change(function(){
                    var temp = $(this).val();
                    var res = postAjax('<?php echo site_url()?>/temp-opt',{'temp':temp});
                    $('#temp_attr').empty();
                    $('#temp_attr').append($("<option value=''>Select Attribute</option>"));
                    $.each(res, function( key, val ) {
                        $('#temp_attr').append($("<option></option>").attr("value",val.opt_value).text(val.opt_text)).formSelect();
                    });                    
                });
                $('#temp_attr').change(function(){
                    var attr = $(this).val();
                    if(attr === ""){
                        alert("Please select response");
                        return false;
                    }else{
                        var temp_name = $('#template').val();
                        var s_date = $('#s_date').val();
                        var e_date = $('#e_date').val();
                        var attr_text = $("#temp_attr option:selected").text();
                        var res = postAjax_With_Loder('<?php echo site_url()?>/temp-response-data',{'temp_name':temp_name,'attr_value':attr,'attr_name':attr_text,'s_date':s_date,'e_date':e_date});
                        responseBreakdown(res);

                    }
                });

                
                var ta =   '<?php echo json_encode((!empty($auditor["top"])?$auditor["top"]:[]));?>';                
                ta     =   JSON.parse(ta);
                topAuditor("top_auditor",ta);
                var ba =   '<?php echo json_encode((!empty($auditor["bottom"])?$auditor["bottom"]:[]));?>';                
                ba     =   JSON.parse(ba);
                topAuditor("bottom_auditor",ba);
                
                $('.modal-trigger').click(function(){
                    $('#chart_modal').modal({
                        backdrop: 'static'
                    });
                }); 
                

                function topAuditor(div,Retention){
                    if(Retention.length > 0){
                        am4core.ready(function() {
                            am4core.useTheme(am4themes_animated);
                            var chart = am4core.create(div, am4charts.XYChart);
                            chart.data = Retention;

                            // Create axes
                            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                                categoryAxis.dataFields.category = "evaluator_name";
                                //categoryAxis.numberFormatter.numberFormat = "#";
                                categoryAxis.renderer.inversed = true;
                                categoryAxis.renderer.grid.template.location = 0;
                                categoryAxis.renderer.minGridDistance = 20;
                                categoryAxis.renderer.grid.template.disabled = true;
                                categoryAxis.renderer.baseGrid.disabled = true;
                                categoryAxis.renderer.labels.template.fill = am4core.color("#8e24aa");
                                categoryAxis.renderer.labels.template.fontSize = 10;
                                categoryAxis.renderer.cellStartLocation = 0.1;
                                categoryAxis.renderer.cellEndLocation = 0.9;

                            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis()); 
                                valueAxis.renderer.minGridDistance = 40;
                                valueAxis.renderer.grid.template.disabled = true;
                                valueAxis.renderer.baseGrid.disabled = true;
                                valueAxis.renderer.labels.template.disabled = true;
                            // Create series
                            function createSeries(field, name) {
                                var series = chart.series.push(new am4charts.ColumnSeries());
                                    series.dataFields.valueX = field;
                                    series.dataFields.categoryY = "evaluator_name";
                                    series.name = name;
                                    series.columns.template.height = am4core.percent(100);
                                    series.sequencedInterpolation = true;
                                    series.columns.template.column.fill = am4core.color("#d41c8b");
                                    series.columns.template.strokeOpacity = 0;
                                    series.columns.template.propertyFields.stroke = "stroke";
                                    series.columns.template.propertyFields.strokeWidth = "strokeWidth";
                                    series.columns.template.propertyFields.strokeDasharray = "columnDash";
                                var valueLabel = series.bullets.push(new am4charts.LabelBullet());
                                    valueLabel.label.text = "[#8e24aa font-size: 10px]{valueX}%[/]";
                                    valueLabel.label.horizontalCenter = "left";
                                    valueLabel.label.dx = 2;
                                    valueLabel.label.hideOversized = false;
                                    valueLabel.label.truncate = false;
                            }

                            createSeries("ts", "ts");
                        });
                    }
                    else{
                        $('#top_auditor').html('No Data Found');
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
                $('#date_range').change(function(){
                    var dd = $(this).val();
                    getDate(dd)              
                });
                function getDate(dd){
                    var today = new Date();
                    $('#chart_edate').attr('disabled',true);
                    if(dd === "OneDay"){
                        var date = formatDate(today.setDate( today.getDate() - 1));
                        $('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);
                    }
                    if(dd === "Today"){
                        $('#chart_sdate').val(formatDate(today)).attr('disabled',true);
                        $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);
                    }
                    if(dd === "OneWeek"){
                        var date = formatDate(today.setDate( today.getDate() - 7));
                        /*$('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);*/
                        $('.filter_dates').addClass('show');
                    }
                    if(dd === "TwoWeeks"){
                        var date = formatDate(today.setDate( today.getDate() - 14));
                        /*$('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);*/
                        $('.filter_dates').addClass('show');
                    }
                    if(dd === "PreviousMonth"){
                        var now = new Date();
                        var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
                        var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);
                        var formatDateComponent = function(dateComponent) {
                            return (dateComponent < 10 ? '0' : '') + dateComponent;
                        };
                        /*$('#chart_sdate').val(formatDate(prevMonthFirstDate)).attr('disabled',true);
                        $('#chart_edate').val(formatDate(prevMonthLastDate)).attr('disabled',true);*/
                        $('.filter_dates').removeClass('show');
                    }
                    if(dd === "OneMonth"){
                        var makeDate    = new Date(today);
                        makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 1));
                        var date        = formatDate(makeDate);
                        /*$('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(today)).attr('disabled',true);*/
                        $('.filter_dates').removeClass('show');
                    }
                    if(dd === "QuartertoDate"){
                        var makeDate    = new Date(today);
                        makeDate.setDate(1);
                        makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 2));
                        var date        = formatDate(makeDate);
                        /*$('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(today)).attr('disabled',true);*/
                        $('.filter_dates').removeClass('show');
                    }
                    if(dd === "YearDate"){
                        var makeDate    = new Date(today);
                        makeDate.setDate(1);
                        makeDate.setMonth(0);
                        makeDate.getFullYear();
                        var date        = formatDate(makeDate);
                        /*$('#chart_sdate').val(date).attr('disabled',true);
                        $('#chart_edate').val(formatDate(today)).attr('disabled',true);*/
                        $('.filter_dates').removeClass('show');
                    }
                    if(dd === "OneYear"){
                        var makeDate    = new Date(today);
                        makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 12));
                        var date        = formatDate(makeDate);
                        /*$('#chart_sdate').val(date).attr('disabled',true);*/
                        $('.filter_dates').removeClass('show');
                    }
                    if(dd === "Custom"){
                        /*$('#chart_sdate').attr('disabled',false);
                        $('#chart_edate').attr('disabled',false);*/
                        $('.filter_dates').addClass('show');
                    }
                }

                function formatDate(date) {
                    var d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    return [year, month, day].join('-');
                }
            </script>
        </body>
    </html>