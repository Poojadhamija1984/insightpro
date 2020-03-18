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
                            <ul class="breadcrumb-list">
                                <li class="breadcrumb-item filter-item">
                                    <!-- <span id="tillDate"><?php //echo $tilldate;?></span> -->
                                    <?php  
                                        $attributes = array('id' => 'datefilterFrm', 'class' => 'col');
                                        echo form_open_multipart('dashboard',$attributes);
                                    ?>
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
                                    <?php echo form_close();?>
                                </li>
                            </ul>
                        </div>
                        <div class="breadcrumb-right filter_outer">
                            <a class="btn_common filter_btn" href="javascript:void(0)" data-target="custom_filter">Filter</a>
                            <div id="custom_filter" class="custom_filter">
                                <h5 class="modal-heading">Chart Setting</h5>
                                <?php  
                                    $attributes = array('id' => 'agentFrm', 'class' => 'col','onsubmit'=>"return validateForm()");
                                    echo form_open_multipart('dashboard',$attributes);
                                ?>
                                    <div class="chart-search">
                                        <div class="chart-field">
                                            <select id="lob_type" class="search_type" name="lob[]" multiple required>
                                                <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($sup_lob as $key => $value) {
                                                        echo "<option value='{$value}'>$value</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="lob_type">Lob</label>
                                        </div>
                                        <div class="chart-field">
                                            <select id="campaign_type" class="search_type" name="campaign[]" multiple required="required">
                                                <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($campaign as $key => $value) {
                                                        echo "<option value='{$value->campaign}'>$value->campaign</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="campaign_type">Campaign</label>
                                        </div>
                                        <div class="chart-field">
                                            <select id="vendor_type" class="search_type" name="vendor[]" multiple required="required">
                                                <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($vendor as $key => $value) {
                                                        echo "<option value='{$value->vendor}'>$value->vendor</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="vendor_type">Vendor</label>
                                        </div>
                                        <div class="chart-field">
                                            <select id="location_type" class="search_type" name="location[]" multiple required="required">
                                                <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($location as $key => $value) {
                                                        echo "<option value='{$value->location}'>$value->location</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="location_type">Location</label>
                                        </div>
                                        <div class="chart-field">
                                            <select id="agent_type" class="search_type" name="agents[]" multiple required="required">
                                                <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($agent as $key => $value) {
                                                        echo "<option value='{$value->empid}'>$value->name</option>";
                                                    }
                                                ?>
                                            </select>
                                            <label for="agent_type">Agent</label>
                                        </div>
                                    </div>
                                    <div class="btn-cont">
                                        <span class="error_modal_msg"></span>
                                        <!-- <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button> -->
                                        <button type="subbmit" id="filter_submit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</button>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BREADCRUMB SECTION END -->
                <!-- MAIN CONTENTS START -->
                <div class="main-contents">
                    <!-- CARDS CONTAINER START -->
                    <div class="cards-section">
                        <!-- <div class="heading-area d-flex align-items-center justify-content-between">
                            <h3 class="heading-title">Overall Score</h3>
                            <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                        </div> -->
                        <div class="col">
                            <div class="row mb-0">
                                <div class="col m3">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Pass Rate</h5>
                                        <span class="stats-count"><?php echo ((!empty($pass_rate['avg']))?$pass_rate['avg']:0);?>%</span>
                                        <?php 
                                            if(!empty($pre_pass_rate['pe'])){
                                                echo "<p class='progress_status positive'><span class='symbol'></span>
                                                        <span>
                                                            {$pre_pass_rate['pe'][0]}
                                                        </span>";
                                            }
                                            else if(!empty($pre_pass_rate['ne'])){
                                                echo "<p class='progress_status negative'><span class='symbol'></span>
                                                        <span>
                                                            {$pre_pass_rate['ne'][0]}
                                                        </span>";
                                            }
                                            else{
                                                echo "<p class='progress_status'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($pre_overall['eq'][0])?$pre_pass_rate['eq'][0]:0)."
                                                        </span>";
                                            }
                                        ?>
                                        % from last month</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col m3">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Evaluations</h5>
                                        <span class="stats-count">
                                            <?php
                                                echo (!empty($total_overall_evulation)?$total_overall_evulation:0);
                                            ?>
                                        </span>
                                        <!-- <p class='progress_status negative'>
                                            <span class='symbol'></span>
                                            <span>10% From Last Month</span>
                                        </p> -->
                                    </div>
                                </div>
                                <div class="col m3">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Auto Fail</h5>
                                        <span class="stats-count">
                                                <?php
                                                    echo (!empty($fatal['total_evulation'])?$fatal['total_evulation']:0)."(".(!empty($fatal['avg'])?$fatal['avg']:0)."%)";
                                                ?>
                                            </span>
                                            <?php 
                                            if(!empty($pre_fatal['pe'])){
                                                echo "<p class='progress_status positive'><span class='symbol'></span>
                                                        <span>
                                                            {$pre_fatal['pe'][0]}
                                                        </span>";
                                            }
                                            else if(!empty($pre_fatal['ne'])){
                                               echo "<p class='progress_status negative'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($pre_fatal['ne'][0])?$pre_fatal['ne'][0]:0)."
                                                        </span>";
                                            }
                                            else{
                                                echo "<p class='progress_status'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($pre_fatal['eq'][0])?$pre_fatal['eq'][0]:0)."
                                                        </span>";
                                            }
                                        ?>
                                        % from last month</span></p>
                                    </div>
                                </div>
                                <div class="col m3">
                                    <div class="status-card card gradient-45deg-purple-deep-orange">
                                        <h5 class="stats-heading">Esclation Rate</h5>
                                        <span class="stats-count">
                                                <?php
                                                    echo (!empty($EscRate['esc_rate_count']['escavg'])?$EscRate['esc_rate_count']['escavg']:0)."%";
                                                ?>
                                            </span>
                                            <?php 
                                            if(!empty($EscRate['pre_esc_rate']['pe'])){
                                                echo "<p class='progress_status positive'><span class='symbol'></span>
                                                        <span>
                                                            {$EscRate['pre_esc_rate']['pe'][0]}
                                                        </span>";
                                            }
                                            else if(!empty($EscRate['pre_esc_rate']['ne'])){
                                               echo "<p class='progress_status negative'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($EscRate['pre_esc_rate']['ne'][0])?$EscRate['pre_esc_rate']['ne'][0]:0)."
                                                        </span>";
                                            }
                                            else{
                                                echo "<p class='progress_status'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($EscRate['pre_esc_rate']['eq'][0])?$EscRate['pre_esc_rate']['eq'][0]:0)."
                                                        </span>";
                                            }
                                        ?>
                                        % from last month</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col QAscore_cards mb-24" style="display:none;">
                            <div class="row mb-0">
                                <div class="col m6 l4">
                                    <div class="progress_circle_outer toggle_chart_outer">
                                        <div class="center">
                                            <h4 class="progress_title">QA Score</h4>
                                            <div class="toggle_chart_btns">
                                                <button type="button" class="toggle_chart_btn active">Top</button>
                                                <button type="button" class="toggle_chart_btn">Bottom</button>
                                            </div>
                                        </div>
                                        <!-- <div class="progress_circle progress_circle_lg">
                                            <strong></strong>
                                        </div> -->
                                        <div id="qa_score_guage222" class="guage_cont toggle_chart active" style="height:160px"></div>
                                        <div id="qa_score_guage22222" class="guage_cont toggle_chart" style="height:160px"></div>
                                        <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>18.63% From Last Month</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col m6 l8">
                                    <div class="chart_outer gradient-45deg-purple-deep-orange">
                                        <div id="chartdiv" style="height: 224px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col QAscore_cards mb-24">
                            <div class="row mb-0">
                                <div class="col m6 l4">
                                    <div class="progress_circle_outer toggle_chart_outer">
                                        <div class="center">
                                            <h4 class="progress_title">QA Score</h4>
                                            <div class="toggle_chart_btns">
                                                <button type="button" class="toggle_chart_btn tabbable active">Overall</button>
                                                <button type="button" class="toggle_chart_btn tabbable">Lob</button>
                                            </div>
                                        </div>
                                        <!-- <div class="progress_circle progress_circle_lg">
                                            <strong></strong>
                                        </div> -->
                                        <div id="qa_score_guage2" class="guage_cont toggle_chart active" style="height:160px"></div>
                                        <div id="qa_score_guage" class="guage_cont toggle_chart" style="height:160px"></div>
                                        <span class="qa_last_month_data">
                                         <?php 
                                            if(!empty($pre_overall['pe'])){
                                                echo "<p class='progress_status positive'><span class='symbol'></span>
                                                        <span>
                                                            {$pre_overall['pe'][0]}
                                                        </span>";
                                            }
                                            else if(!empty($pre_overall['ne'])){
                                                echo "<p class='progress_status negative'><span class='symbol'></span>
                                                        <span>
                                                            {$pre_overall['ne'][0]}
                                                        </span>";
                                            }
                                            else{
                                                echo "<p class='progress_status'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($pre_overall['eq'][0])?$pre_overall['eq'][0]:0)."
                                                        </span>";
                                            }
                                        ?>
                                        % from last month</span>
                                    </div>
                                </div>
                                <div class="col m6 l8">
                                    <div class="chart_outer">
                                        <div id="chartdiv2" style="height: 224px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-0">
                                <div class="col m6 l3">
                                    <div class="progress_circle_outer">
                                        <h4 class="progress_title">CSAT</h4>
                                        <div class="progress_circle progress_circle_sm cset_bar">
                                            <strong></strong>
                                        </div>
                                        <div id="cset_chart" class="sm_charts"></div>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>18.63% From Last Month</span>
                                        </p> -->
                                    </div>
                                </div>
                                <div class="col m6 l3">
                                    <div class="progress_circle_outer">
                                        <h4 class="progress_title">Resolution</h4>
                                        <div class="progress_circle progress_circle_sm resolution_bar">
                                            <strong></strong>
                                        </div>
                                        <div id="resolution_chart" class="sm_charts"></div>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>18.63% From Last Month</span>
                                        </p> -->
                                    </div>
                                </div>
                                <div class="col m6 l3">
                                    <div class="progress_circle_outer">
                                        <h4 class="progress_title">Sales</h4>
                                        <div class="progress_circle progress_circle_sm sales_bar">
                                            <strong></strong>
                                        </div>
                                        <div id="sales_chart" class="sm_charts"></div>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>18.63% From Last Month</span>
                                        </p> -->
                                    </div>
                                </div>
                                <div class="col m6 l3">
                                    <div class="progress_circle_outer">
                                        <h4 class="progress_title">Retention Rate</h4>
                                        <div class="progress_circle progress_circle_sm retention_bar">
                                            <strong></strong>
                                        </div>
                                        <div id="retention_chart" class="sm_charts"></div>
                                        <!-- <p class='progress_status positive'>
                                            <span class='symbol'></span>
                                            <span>18.63% From Last Month</span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CARDS CONTAINER END -->

                    <!-- CARDS CONTAINER START -->
                    <div class="cards-section mt-24">
                        <!-- <div class="heading-area d-flex align-items-center justify-content-between">
                            <h3 class="heading-title">Overall Score Section 3</h3>
                            <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                        </div> -->
                        <div class="col">
                            <div class="row">
                                <div class="col m6">
                                    <div class="chart_outer toggle_chart_outer">
                                        <div class="d-flex justify-content-between align-items-center mb-12">
                                            <h4 class="progress_title mb-0">Attributes List</h4>
                                            <div class="attr-list-select">
                                                <select name="attr_lob" id="attr_lob">
                                                    <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($sup_lob as $key => $value) {
                                                        echo "<option value='{$value}' ".(($currentLob == $value)?'selected':'').">$value</option>";
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="toggle_chart_btns">
                                                <button type="button" class="toggle_chart_btn active">Top</button>
                                                <button type="button" class="toggle_chart_btn ">Bottom</button>
                                            </div>
                                        </div>
                                        <div id="funnel_chart_top" class="toggle_chart att_funnel active"></div>
                                        <div id="funnel_chart_bottom" class="toggle_chart att_funnel"></div>
                                        <!-- <div class="center"><span class="currentLob"><?php //echo $currentLob ?></span></div> -->
                                    </div>
                                </div>
                                <div class="col m6">
                                    <div class="chart_outer toggle_chart_outer">
                                        <div class="d-flex justify-content-between align-items-center mb-12">
                                            <h4 class="progress_title mb-0"><span class="attr_cat">Attributes</span> List</h4>
                                            <div class="attr-list-select">
                                                <select name="attr_lob" id="cat_lob">
                                                    <?php 
                                                    $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                    foreach ($sup_lob as $key => $value) {
                                                        echo "<option value='{$value}' ".(($currentLob == $value)?'selected':'').">$value</option>";
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="toggle_chart_btns">
                                                <button type="button" class="toggle_chart_btn atta_cat_tab active">Attribute</button>
                                                <button type="button" class="toggle_chart_btn atta_cat_tab">Category</button>
                                            </div>
                                        </div>
                                        <div id="radar_chart_attr" class="toggle_chart att_funnel active" style="height:300px"></div>
                                        <div id="radar_chart_cat" class="toggle_chart att_funnel" style="height:300px"></div>
                                        <!-- <div class="center"><span class="currentLob"><?php //echo $currentLob ?></span></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mt-24">
                            <div class="chart_outer" style="display: none;">
                                <div id="map_chart" class="" style="height:320px"></div>
                            </div>
                        </div>
                    </div>
                    <!-- CARDS CONTAINER END -->
                    <!-- Modal Structure -->
                    <div id="chart_modal" class="modal chart_modal">
                        <div class="modal-content">
                            <h5 class="modal-heading">Chart Setting</h5>
                            <?php  $attributes = array('id' => 'agentFrm', 'class' => 'col');echo form_open_multipart('dashboard',$attributes);?>
                                <div class="chart-search">
                                    <h6 class="chart_modal_title">Fill Choice</h6>
                                    <div class="chart-field">
                                        <select id="search_type" class="search_type" name="lob[]" multiple required="required">
                                            <?php 
                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($sup_lob as $key => $value) {
                                                    echo "<option value='{$value}'>$value</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="search_type">Search</label>
                                    </div>
                                </div>
                                <div class="chart-search">
                                    <h6 class="chart_modal_title">campaign</h6>
                                    <div class="chart-field">
                                        <select id="search_type" class="search_type" name="lob[]" multiple required="required">
                                            <?php 
                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($campaign as $key => $value) {
                                                    echo "<option value='{$value->campaign}'>$value->campaign</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="search_type">Search</label>
                                    </div>
                                </div>
                                <div class="chart-search">
                                    <h6 class="chart_modal_title">vendor</h6>
                                    <div class="chart-field">
                                        <select id="search_type" class="search_type" name="lob[]" multiple required="required">
                                            <?php 
                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($vendor as $key => $value) {
                                                    echo "<option value='{$value->vendor}'>$value->vendor</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="search_type">Search</label>
                                    </div>
                                </div> 
                                <div class="chart-search">
                                    <h6 class="chart_modal_title">location</h6>
                                    <div class="chart-field">
                                        <select id="search_type" class="search_type" name="lob[]" multiple required="required">
                                            <?php 
                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($location as $key => $value) {
                                                    echo "<option value='{$value->location}'>$value->location</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="search_type">Search</label>
                                    </div>
                                </div>
                                <div class="chart-search">
                                    <h6 class="chart_modal_title">Agents</h6>
                                    <div class="chart-field">
                                        <select id="search_type" class="search_type" name="lob[]" multiple required="required">
                                            <?php 
                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                foreach ($agent as $key => $value) {
                                                    echo "<option value='{$value->empid}'>$value->name</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="search_type">Search</label>
                                    </div>
                                </div>
                                <div class="chart-date">
                                    <h6 class="chart_modal_title">Date Range</h6>
                                    <div class="chart-field">
                                        <input id="chart_sdate" name="chart_sdate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>">
                                        <label for="chart_sdate">From</label>
                                    </div>
                                    <div class="chart-field">
                                        <input id="chart_edate" name="chart_edate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>">
                                        <label for="chart_edate">To</label>
                                    </div>
                                </div>
                                <div class="btn-cont">
                                    <span class="error_modal_msg"></span>
                                    <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button>
                                    <button type="subbmit" id="filter_submit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</button>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
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
            var date_range_picker = '<?php echo $date_range;?>';
            if(date_range_picker === "Custom"){
                $('.filter_dates').removeClass('hide').addClass('show');
                var daterangeto = '<?php echo $daterangeto;?>';
                $("input[name='filter_start_date']").val(daterangeto);
                var daterangefr = '<?php echo $daterangefr;?>';
                $("input[name='filter_end_date']").val(daterangefr);
            }
            $('#date_range option[value="'+date_range_picker+'"]').attr("selected", "selected");
            $('#attr_lob').change(function(){
                var lob = $(this).val();
                dd = $('#date_range').val();
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
                var response = singleLobfilter(dd,sdate,edate,lob,'attribute-filter');
                setTimeout(function(){ 
                    attributeRankGraph('funnel_chart_top',response.top);
                    $('.toggle_chart_btn')[5].click();
                    setTimeout(function(){ 
                        attributeRankGraph('funnel_chart_bottom',response.bottom);
                    }, 1000);
                }, 1000);
                
                
                $('#attr_lob option[value="'+response.currentLob+'"]').attr("selected", "selected");
            });
            $('#cat_lob').change(function(){
                var lob = $(this).val();
                dd = $('#date_range').val();
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
                var response = singleLobfilter(dd,sdate,edate,lob,'category-filter');
                // $('.toggle_chart_btn')[6].click();
                setTimeout(function(){ 
                    attributeListGraph(response.attribute);
                    $('.toggle_chart_btn')[6].click();
                    setTimeout(function(){ 
                        categoryListGraph(response.category);
                    }, 1000);
                }, 1000);
                
                $('#attr_lob option[value="'+response.currentLob+'"]').attr("selected", "selected");
            });
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
                        $('#datefilterFrm').submit();    
                    }
                }
                else{                    
                    $('#datefilterFrm').submit();
                }
            }
            function singleLobfilter(dr,sd,ed,lob,url){ 
                var base_url = '<?php echo site_url();?>/'+url;
                var data = {'date_range':dr,'filter_start_date':sd,'filter_end_date':ed,'lob':lob}
                if(dr === 'Custom'){
                    if(sd != '' && ed != ''){
                        return postAjax_With_Loder(base_url,data);                        
                    }
                }
                else{                    
                    return postAjax_With_Loder(base_url,data);
                }
            }

            function validateForm() {
                var x = $('#lob_type').val();
                if (x.length === 0) {
                    alert("Lob must be filled out");
                    return false;
                }
            }
            dashboard_filter_details = JSON.parse('<?php echo $dashboard_filter_details;?>');
            $.each(dashboard_filter_details,function(key,val){
                var lob = val.lob;
                lob = lob.split(",");
                $.each(lob, function(key2,val2){
                    $('#lob_type option[value="'+val2+'"]').attr("selected", "selected");
                });
                var campaign    =   val.campaign;
                campaign = campaign.split(",");                
                $.each(campaign, function(key5,val5){
                    $('#campaign_type option[value="'+val5+'"]').attr("selected", "selected");
                });
                var vendor      =   val.vendor;
                vendor = vendor.split(",");
                $.each(vendor, function(key4,val4){
                    $('#vendor_type option[value="'+val4+'"]').attr("selected", "selected");
                });
                var location    =   val.location;
                location = location.split(",");
                $.each(location, function(key3,val3){
                    $('#location_type option[value="'+val3+'"]').attr("selected", "selected");
                });
                var agent = val.agent;
                agent = agent.split(",");
                $.each(agent, function(key1,val1){
                    $('#agent_type option[value="'+val1+'"]').attr("selected", "selected");
                });
            })
            console.log(dashboard_filter_details);
            var toDate          =   '<?php echo $totilldate;?>';
            var formDate        =   '<?php echo $fromtilldate;?>';
            $('#chart_sdate').val(toDate);
            $('#chart_edate').val(formDate);

            var allLob =   JSON.parse('<?php echo (!empty($allLob)?json_encode($allLob):json_encode([]));?>');
            $.each(allLob, function(key,val){
                $('#search_type option[value="'+val+'"]').attr("selected", "selected");
            });
            var Overalleaefdata =   '<?php echo (!empty($fef)?json_encode($fef):0);?>';
            Overalleaefdata     =   JSON.parse(Overalleaefdata);
            qaEvalutiongraph(Overalleaefdata);

            var overallqaavg =   '<?php echo (!empty($overall_qa[0]["avg"])?json_encode($overall_qa[0]["avg"]):0);?>';
            overallqaavg     =   JSON.parse(overallqaavg);
            ovelallQAScore(overallqaavg);

            var overallqaavglobwise =   '<?php echo (!empty($overallqalobwise)?json_encode($overallqalobwise):json_encode([]));?>';
            overallqaavglobwise     =   JSON.parse(overallqaavglobwise);
            overallQALobGraph(overallqaavglobwise);

            var CSAT            =   '#8e24aa';
            var Resolution      =   '#6191fe';
            var Sales           =   '#68bb59';
            var Retention       =   '#d41c8b';
            var cset_bar        =   parseInt('<?php echo (!empty($kpi["CSAT"])?$kpi["CSAT"]:0);?>');
            var resolution_bar  =   parseInt('<?php echo (!empty($kpi["Resolution"])?$kpi["Resolution"]:0);?>');
            var sales_bar       =   parseInt('<?php echo (!empty($kpi["Sales"])?$kpi["Sales"]:0);?>');
            var retention_bar   =   parseInt('<?php echo (!empty($kpi["Retention"])?$kpi["Retention"]:0);?>');

            progress_bar(".cset_bar",cset_bar,CSAT);
            progress_bar(".resolution_bar",resolution_bar,Resolution);
            progress_bar(".sales_bar",sales_bar,Sales);
            progress_bar(".retention_bar",retention_bar,Retention);

            var kpicsat =   '<?php echo (!empty($kpiYear["CSAT"])?json_encode($kpiYear["CSAT"]):json_encode([]));?>';
            kpicsat     =   JSON.parse(kpicsat);
            kpiCSETGraph(kpicsat);

            var kpiResolution =   '<?php echo (!empty($kpiYear["Resolution"])?json_encode($kpiYear["Resolution"]):json_encode([]));?>';
            kpiResolution     =   JSON.parse(kpiResolution);
            kpiResolutionGraph(kpiResolution);

            var kpiSales =   '<?php echo (!empty($kpiYear["Sales"])?json_encode($kpiYear["Sales"]):json_encode([]));?>';
            kpiSales     =   JSON.parse(kpiSales);
            kpiSalesGraph(kpiSales);

            var kpiRetention =   '<?php echo ( isset($kpiYear["Retention"]) && !empty($kpiYear["Retention"])?json_encode($kpiYear["Retention"]):json_encode([]));?>';
            kpiRetention     =   JSON.parse(kpiRetention);
            kpiRetentionGraph(Retention);

            var topattributerank = '<?php echo (!empty($rank["top"])?json_encode($rank["top"],JSON_HEX_APOS):json_encode([]));?>';
            topattributerank     = JSON.parse(topattributerank);
             var topabottomttributerank   =   '<?php echo (!empty($rank["bottom"])?json_encode($rank["bottom"],JSON_HEX_APOS):json_encode([]));?>';
            topabottomttributerank        =   JSON.parse(topabottomttributerank);
            attributeRankGraph('funnel_chart_top',topattributerank);
            attributeRankGraph('funnel_chart_bottom',topabottomttributerank);

            var attribute   =   '<?php echo (!empty($attribute)?json_encode($attribute,JSON_HEX_APOS):json_encode([]));?>';
            attribute       =   JSON.parse(attribute);
            attributeListGraph(attribute);

            var category   =   '<?php echo (!empty($category)?json_encode($category):json_encode([]));?>';
            category       =   JSON.parse(category);
            categoryListGraph(category);

            /*var agentlocation   =   '<?php echo (!empty($awte)?json_encode($awte):json_encode([]));?>';
            agentlocation       =   JSON.parse(agentlocation);
            agentLocationGraph(agentlocation);*/

            $(document).ready(function() {
                $('select').formSelect();
                $('select.search_type').siblings('ul').prepend('<li id=sm_select_all><span>Select All</span></li>');
                $('li#sm_select_all').on('click', function () {
                    var jq_elem = $(this), 
                    jq_elem_span = jq_elem.find('span'),
                    select_all = jq_elem_span.text() == 'Select All',
                    set_text = select_all ? 'Select None' : 'Select All';
                    jq_elem_span.text(set_text);
                    jq_elem.siblings('li').filter(function() {
                        return $(this).find('input').prop('checked') != select_all;
                    }).click();
                });
                $('#filter_submit').click(function(e){
                    e.preventDefault();
                    var lob = $("#search_type").val();
                    var chart_sdate = $('#chart_sdate').val();
                    var chart_edate = $('#chart_edate').val();
                    if(lob.length > 0 && chart_sdate != '' && chart_edate != ''){
                        $('#agentFrm').submit();
                        return true;
                    }
                    else{
                        return false;
                    }
                    //
                });
            });

            $('.tabbable').click(function(){
                //alert($(this).text());
                //overallQALobGraph(overallqaavglobwise);
            });
            $('.modal-trigger').click(function(){
                $('#chart_modal').modal({
                    backdrop: 'static'
                });
            }); 
            /*$('#chart_modal').modal({
                dbackdrop: 'static',
                keyboard: false
            });*/
            $('.atta_cat_tab').click(function(){
                $('.attr_cat').html($(this).text());
            });
            
            
            
            function progress_bar(bar_class,value,colors) {
                $(bar_class).circleProgress({
                    startAngle: -Math.PI / 4 * 2,
                    value: (value === 100)?value:"0." + value,
                    thickness: 14,
                    size: 110,
                    fill: {color: colors}
                }).on('circle-animation-progress', function(event, progress) {
                    $(this).find('strong').html(value + '<i>%</i>');
                });
            }
            (function($) {
                $('.progress_circle_lg').circleProgress({
                    startAngle: -Math.PI / 4 * 2,
                    value: 0.86,
                    thickness: 16,
                    size: 200,
                    fill: {gradient: ['#8e24aa', '#ff6e40']}
                }).on('circle-animation-progress', function(event, progress) {
                    $(this).find('strong').html('86' + '<i>%</i>');
                });
            })(jQuery);
            
            function qaEvalutiongraph(Overalleaefdata){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create('chartdiv2', am4charts.XYChart);
                    chart.exporting.menu = new am4core.ExportMenu();
                    var gradient = new am4core.LinearGradient();
                        gradient.addColor(am4core.color("#8e24aa"));
                        gradient.addColor(am4core.color("#ff6e40"));
                    var fillModifier = new am4core.LinearGradientModifier();
                        fillModifier.opacities = [1, 1];
                        fillModifier.offsets = [1, 1];
                        fillModifier.gradient.rotation = 45;
                    var data = Overalleaefdata;
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "day";
                        categoryAxis.renderer.minGridDistance = 30;
                        categoryAxis.renderer.grid.template.disabled = true;
                        categoryAxis.renderer.baseGrid.disabled = true;
                        categoryAxis.renderer.labels.template.horizontalCenter = "right";
                        categoryAxis.renderer.labels.template.verticalCenter = "middle";
                        categoryAxis.renderer.labels.template.rotation = 270;
                        categoryAxis.renderer.labels.template.fill = am4core.color("#363636");
                        categoryAxis.renderer.labels.template.fontSize = 9;
                    var evaluationAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        evaluationAxis.title.text = "Evaluation";
                        evaluationAxis.title.fill = am4core.color("#363636");
                        evaluationAxis.title.fontSize = 12;
                        evaluationAxis.title.fontWeight = "bold";
                        evaluationAxis.renderer.grid.template.disabled = true;
                        evaluationAxis.renderer.labels.template.fill = am4core.color("#363636");
                        evaluationAxis.renderer.labels.template.fontSize = 9;
                    var averageAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        averageAxis.title.text = "Average";
                        averageAxis.title.fill = am4core.color("#363636");
                        averageAxis.title.fontSize = 12;
                        averageAxis.title.fontWeight = "bold";
                        averageAxis.renderer.grid.template.disabled = true;
                        averageAxis.renderer.baseGrid.disabled = true;
                        averageAxis.renderer.opposite = true;
                        averageAxis.renderer.labels.template.fill = am4core.color("#363636");
                        averageAxis.renderer.labels.template.fontSize = 9;
                    var escalationAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        escalationAxis.title.text = "";
                        escalationAxis.renderer.grid.template.disabled = true;
                        escalationAxis.renderer.baseGrid.disabled = true;
                        escalationAxis.renderer.labels.template.disabled = true;
                    var fatalAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        fatalAxis.title.text = "";
                        fatalAxis.renderer.grid.template.disabled = true;
                        fatalAxis.renderer.baseGrid.disabled = true;
                        fatalAxis.renderer.labels.template.disabled = true;
                    var evaluationSeries = chart.series.push(new am4charts.ColumnSeries());
                        evaluationSeries.name = "Evaluation";
                        evaluationSeries.yAxis = evaluationAxis;
                        evaluationSeries.dataFields.valueY = "total_evulation";
                        evaluationSeries.dataFields.categoryX = "day";
                        evaluationSeries.tooltip.getFillFromObject = false;
                        evaluationSeries.tooltip.background.fill = am4core.color("#bababa");
                        evaluationSeries.columns.template.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 16px]{valueY}[/] [#fff]{additional}[/]"
                        evaluationSeries.columns.template.propertyFields.stroke = "stroke";
                        evaluationSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
                        evaluationSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
                        evaluationSeries.columns.template.column.fill = am4core.color("#bababa");
                        evaluationSeries.columns.template.column.strokeWidth = 0;
                        evaluationSeries.tooltip.label.textAlign = "middle";
                    var averageSeries = chart.series.push(new am4charts.LineSeries());
                        averageSeries.name = "Feedback";
                        averageSeries.yAxis = averageAxis;
                        averageSeries.dataFields.valueY = "feedbackavg";
                        averageSeries.dataFields.categoryX = "day";
                        averageSeries.stroke = am4core.color("#68bb59");
                        averageSeries.strokeWidth = 1;
                        averageSeries.propertyFields.strokeDasharray = "lineDash";
                        averageSeries.tooltip.label.textAlign = "middle";
                        var bullet = averageSeries.bullets.push(new am4charts.Bullet());
                            bullet.fill = am4core.color("#68bb59");
                            bullet.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 16px]{valueY}[/] [#fff]{additional}[/]"
                            var circle = bullet.createChild(am4core.Circle);
                                circle.radius = 4;
                                circle.strokeWidth = 0;
                        var escalationSeries = chart.series.push(new am4charts.LineSeries());
                            escalationSeries.name = "Escalation";
                            escalationSeries.yAxis = averageAxis;
                            escalationSeries.dataFields.valueY = "escavg";
                            escalationSeries.dataFields.categoryX = "day";
                            escalationSeries.stroke = am4core.color("#6191fe");
                            escalationSeries.strokeWidth = 1;
                            escalationSeries.propertyFields.strokeDasharray = "lineDash";
                            escalationSeries.tooltip.label.textAlign = "middle";
                        var escalationBullet = escalationSeries.bullets.push(new am4charts.Bullet());
                            escalationBullet.fill = am4core.color("#6191fe");
                            escalationBullet.horizontalCenter = "middle";
                            escalationBullet.verticalCenter = "middle";
                            escalationBullet.width = 7;
                            escalationBullet.height = 7;
                            escalationBullet.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 16px]{valueY}[/] [#fff]{additional}[/]"
                            var escalationRectangle  = escalationBullet.createChild(am4core.Rectangle);
                                escalationRectangle.width = 7;
                                escalationRectangle.height = 7;
                                escalationRectangle.stroke = am4core.color("transparent");
                                escalationRectangle.strokeWidth = 0;
                        var fatalSeries = chart.series.push(new am4charts.LineSeries());
                            fatalSeries.name = "Fatal";
                            fatalSeries.yAxis = averageAxis;
                            fatalSeries.dataFields.valueY = "fatelavg";
                            fatalSeries.dataFields.categoryX = "day";
                            fatalSeries.stroke = am4core.color("#d41c8b");
                            fatalSeries.strokeWidth = 1;
                            fatalSeries.propertyFields.strokeDasharray = "lineDash";
                            fatalSeries.tooltip.label.textAlign = "middle";
                        var bullet = fatalSeries.bullets.push(new am4charts.Bullet());
                            bullet.fill = am4core.color("#d41c8b");
                            bullet.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 16px]{valueY}[/] [#fff]{additional}[/]"
                            var circle = bullet.createChild(am4core.Circle);
                                circle.radius = 4;
                                circle.strokeWidth = 0;
                    chart.legend = new am4charts.Legend();
                    chart.legend.markers.template.useDefaultMarker = true;
                    chart.data = data;
                });
            }

            function ovelallQAScore(overallqaavg){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("qa_score_guage2", am4charts.GaugeChart);
                    chart.innerRadius = am4core.percent(80);
                    var gradient = new am4core.LinearGradient();
                        gradient.addColor(am4core.color("#8e24aa"));
                        gradient.addColor(am4core.color("#ff6e40"));
                    var axis = chart.xAxes.push(new am4charts.ValueAxis());
                        axis.min = 0;
                        axis.max = 100;
                        axis.strictMinMax = true;
                        axis.renderer.radius = am4core.percent(72);
                        axis.renderer.inside = true;
                        axis.renderer.line.strokeOpacity = 1;
                        axis.renderer.ticks.template.strokeOpacity = 1;
                        axis.renderer.ticks.template.length = 10;
                        axis.renderer.grid.template.disabled = true;
                        axis.renderer.labels.template.radius = 24;
                        axis.renderer.labels.template.fontSize = 8;
                        axis.renderer.labels.template.adapter.add("text", function(text) {return text + "%";})
                    var colorSet = new am4core.ColorSet();
                    var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
                        axis2.min = 0;
                        axis2.max = 100;
                        axis2.renderer.innerRadius = 10
                        axis2.strictMinMax = true;
                        axis2.renderer.labels.template.disabled = true;
                        axis2.renderer.ticks.template.disabled = true;
                        axis2.renderer.grid.template.disabled = true;
                        axis.renderer.minGridDistance = 10000;
                        var range0 = axis2.axisRanges.create();
                            range0.value = 0;
                            range0.endValue = overallqaavg;
                            range0.axisFill.fillOpacity = 1;
                            range0.axisFill.fill = gradient;
                        var range1 = axis2.axisRanges.create();
                            range1.value = overallqaavg;
                            range1.endValue = 100;
                            range1.axisFill.fillOpacity = 1;
                            range1.axisFill.fill = am4core.color("#dcdcdc");
                    var label = chart.radarContainer.createChild(am4core.Label);
                        label.isMeasured = false;
                        label.fontSize = 16;
                        label.x = am4core.percent(50);
                        label.y = am4core.percent(100);
                        label.horizontalCenter = "middle";
                        label.verticalCenter = "center";
                        label.marginBottom = 0;
                        label.text = overallqaavg+"%";
                    var hand = chart.hands.push(new am4charts.ClockHand());
                        hand.axis = axis2;
                        hand.innerRadius = am4core.percent(12);
                        hand.startWidth = 8;
                        hand.pin.disabled = true;
                        hand.value = overallqaavg;
                }); 
            }

            function overallQALobGraph(overallqaavglobwise){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("qa_score_guage", am4charts.XYChart);
                    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                    chart.data = overallqaavglobwise;
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.renderer.grid.template.location = 0;
                        categoryAxis.dataFields.category = "lob";
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
                        series.name = "Average";
                        series.dataFields.categoryX = "lob";
                        series.dataFields.valueY = "avg";
                        series.tooltip.getFillFromObject = false;
                        series.tooltip.background.fill = am4core.color("#68bb59");
                        series.columns.template.strokeOpacity = 0;
                        series.columns.template.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 12px]{valueY}[/] [#fff]{additional}[/]"
                        series.columns.template.propertyFields.stroke = "stroke";
                        series.columns.template.propertyFields.strokeWidth = "strokeWidth";
                        series.columns.template.propertyFields.strokeDasharray = "columnDash";
                        series.columns.template.column.fill = am4core.color("#68bb59");
                });
            }

            function kpiCSETGraph(kpicsat){
                if(kpicsat.length > 0){
                    am4core.ready(function() {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("cset_chart", am4charts.XYChart);
                        chart.data = kpicsat;
                        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category = "month";
                            categoryAxis.renderer.minGridDistance = 15;
                            categoryAxis.renderer.grid.template.disabled = true;
                            categoryAxis.renderer.baseGrid.disabled = true;
                            categoryAxis.renderer.labels.template.fill = am4core.color("#8e24aa");
                            categoryAxis.renderer.labels.template.fontSize = 10;
                            /*categoryAxis.renderer.labels.template.horizontalCenter = "left";
                            categoryAxis.renderer.labels.template.verticalCenter = "middle";
                            categoryAxis.renderer.labels.template.rotation = 270;*/
                        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                            valueAxis.renderer.minGridDistance = 30;
                            valueAxis.renderer.grid.template.disabled = true;
                            valueAxis.renderer.baseGrid.disabled = true;
                            valueAxis.renderer.labels.template.fill = am4core.color("#ffffff");
                            valueAxis.renderer.labels.template.fontSize = 10;
                            valueAxis.renderer.labels.template.disabled = true;
                        var series = chart.series.push(new am4charts.LineSeries());
                            series.name = "CSET";
                            series.dataFields.valueY = "avg";
                            series.dataFields.categoryX = "month";
                            series.stroke = am4core.color("#8e24aa");
                            series.strokeWidth = 2;
                            series.propertyFields.strokeDasharray = "lineDash";
                            series.tooltip.label.textAlign = "middle";
                            var bullet = series.bullets.push(new am4charts.Bullet());
                                bullet.fill = am4core.color("#ffffff"); // tooltips grab fill from parent by default
                                bullet.tooltipText = "[#000 font-size: 12px]{name} : [/][#000 font-size: 12px]{valueY}[/] [#000]{additional}[/]"
                                var circle = bullet.createChild(am4core.Circle);
                                    circle.radius = 4;
                                    circle.fill = am4core.color("#8e24aa");
                                    circle.stroke = am4core.color("transparent");
                                    circle.strokeWidth = 0;
                    });
                }
                else{
                    $('#cset_chart').html('No Data Found');
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

                        var series = chart.series.push(new am4charts.CurvedColumnSeries());
                            series.name = "Resolution";
                            series.dataFields.categoryX = "month";
                            series.dataFields.valueY = "avg";
                            series.columns.template.strokeOpacity = 0;
                            series.columns.template.fillOpacity = 0.75;
                            series.columns.template.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 12px]{valueY}[/] [#fff]{additional}[/]"
                            series.columns.template.propertyFields.stroke = "stroke";
                            series.columns.template.propertyFields.strokeWidth = "strokeWidth";
                            series.columns.template.propertyFields.strokeDasharray = "columnDash";
                            series.columns.template.fill = am4core.color("#6191fe");
                            var hoverState = series.columns.template.states.create("hover");
                                hoverState.properties.fillOpacity = 1;
                                hoverState.properties.tension = 0.4;
                    });
                }
                else{
                    $('#resolution_chart').html('No Data Found');
                }
            }

            function kpiSalesGraph(kpiSales){
                if(kpiSales.length > 0){
                    am4core.ready(function() {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("sales_chart", am4charts.XYChart);
                        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                        chart.data = kpiSales;
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
                            series.name = "Sales";
                            series.dataFields.categoryX = "month";
                            series.dataFields.valueY = "avg";
                            series.columns.template.strokeOpacity = 0;
                            series.columns.template.tooltipText = "[#fff font-size: 12px]{name} : [/][#fff font-size: 12px]{valueY}[/] [#fff]{additional}[/]"
                            series.columns.template.propertyFields.stroke = "stroke";
                            series.columns.template.propertyFields.strokeWidth = "strokeWidth";
                            series.columns.template.propertyFields.strokeDasharray = "columnDash";
                            series.columns.template.column.fill = am4core.color("#68bb59");
                    });
                }
                else{
                    $('#sales_chart').html('No Data Found');
                }
            }

            function kpiRetentionGraph(Retention){
                if(kpiRetention.length > 0){
                    am4core.ready(function() {
                        am4core.useTheme(am4themes_animated);
                        var chart = am4core.create("retention_chart", am4charts.XYChart);
                        chart.data = kpiRetention;

                        // Create axes
                        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                            categoryAxis.dataFields.category = "month";
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
                                series.dataFields.categoryY = "month";
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

                        createSeries("avg", "avg");
                    });
                }
                else{
                    $('#retention_chart').html('No Data Found');
                }
            }

            function attributeRankGraph(divid,attributeData){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    let chart = am4core.create(divid, am4charts.SlicedChart);
                    chart.data = attributeData;
                    let series = chart.series.push(new am4charts.FunnelSeries());
                    series.dataFields.value = "avg";
                    series.dataFields.category = "name";

                    var fillModifier = new am4core.LinearGradientModifier();
                    fillModifier.brightnesses = [-0.5, 1, -0.5];
                    fillModifier.offsets = [0, 0.5, 1];
                    series.slices.template.fillModifier = fillModifier;
                    //series.alignLabels = false;
                    //series.labels.template.text = "[font-size: 10px]{category}: [/][bold]{value}[/]";
                    series.labels.template.disabled = true;
                });
            }


            function attributeListGraph(attribute){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("radar_chart_attr", am4charts.RadarChart);
                    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                    chart.data = attribute;
                    chart.padding(20, 20, 20, 20);
                    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                        categoryAxis.dataFields.category = "name";
                        categoryAxis.renderer.labels.template.location = 0.5;
                        categoryAxis.renderer.tooltipLocation = 0.5;
                        categoryAxis.renderer.labels.template.fill = am4core.color("#333333");
                        categoryAxis.renderer.labels.template.fontSize = 10;
                        categoryAxis.renderer.labels.template.disabled = true;
                        categoryAxis.renderer.ticks.template.disabled = true;  
                        /*var label = categoryAxis.renderer.labels.template;
                            label.wrap = true;
                            label.truncate = true;
                            label.maxWidth = 90;
                            label.tooltipText = "{name}";*/
                    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                        valueAxis.tooltip.disabled = true;
                        valueAxis.renderer.labels.template.fill = am4core.color("#333333");
                        valueAxis.renderer.labels.template.fontSize = 10;
                        valueAxis.renderer.labels.template.horizontalCenter = "left";
                        valueAxis.min = 0;
                        valueAxis.max = 100;
                    var series1 = chart.series.push(new am4charts.RadarColumnSeries());
                        series1.columns.template.tooltipText = "[font-size: 12px]{name}: {valueY.value}[/]";
                        series1.columns.template.width = am4core.percent(80);
                        series1.name = "Series 1";
                        series1.dataFields.categoryX = "name";
                        series1.dataFields.valueY = "avg";
                        series1.stacked = true;
                    chart.seriesContainer.zIndex = -1;
                });
            }
            function categoryListGraph(category){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var chart = am4core.create("radar_chart_cat", am4charts.RadarChart);
                    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
                    chart.data = category;
                    // Make chart not full circle
                    chart.startAngle = -90;
                    chart.endAngle = 180;
                    chart.innerRadius = am4core.percent(20);
                    // Set number format
                    chart.numberFormatter.numberFormat = "#.#'%'";
                    // Create axes
                    var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                    categoryAxis.dataFields.category = "name";
                    categoryAxis.renderer.grid.template.location = 0;
                    categoryAxis.renderer.grid.template.strokeOpacity = 0;
                    categoryAxis.renderer.labels.template.horizontalCenter = "right";
                    categoryAxis.renderer.labels.template.fontSize = 11;
                    categoryAxis.renderer.labels.template.fontWeight = 500;
                    categoryAxis.renderer.labels.template.adapter.add("fill", function(fill, target) {
                    return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
                    });
                    categoryAxis.renderer.minGridDistance = 10;
                    var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                    valueAxis.renderer.grid.template.strokeOpacity = 0;
                    valueAxis.renderer.labels.template.fontSize = 10;
                    valueAxis.min = 0;
                    valueAxis.max = 100;
                    valueAxis.strictMinMax = true;
                    // Create series
                    var series1 = chart.series.push(new am4charts.RadarColumnSeries());
                    series1.dataFields.valueX = "full";
                    series1.dataFields.categoryY = "name";
                    series1.clustered = false;
                    series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
                    series1.columns.template.fillOpacity = 0.08;
                    series1.columns.template.cornerRadiusTopLeft = 20;
                    series1.columns.template.strokeWidth = 0;
                    series1.columns.template.radarColumn.cornerRadius = 20;
                    var series2 = chart.series.push(new am4charts.RadarColumnSeries());
                    series2.dataFields.valueX = "avg";
                    series2.dataFields.categoryY = "name";
                    series2.clustered = false;
                    series2.columns.template.strokeWidth = 0;
                    series2.columns.template.tooltipText = "[font-size: 12px]{name}: [/][font-size: 12px bold]{avg}[/]";
                    series2.columns.template.radarColumn.cornerRadius = 20;
                    series2.columns.template.adapter.add("fill", function(fill, target) {
                    return chart.colors.getIndex(target.dataItem.index);
                    });
                });
            }

            

            /*function agentLocationGraph(agentlocation){
                am4core.ready(function() {
                    am4core.useTheme(am4themes_animated);
                    var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
                    var chart = am4core.create("map_chart", am4maps.MapChart);
                    chart.geodata = am4geodata_worldLow;
                    chart.projection = new am4maps.projections.Miller();
                    var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                    polygonSeries.exclude = ["AQ"];
                    polygonSeries.useGeodata = true;
                    var polygonTemplate = polygonSeries.mapPolygons.template;
                    polygonTemplate.strokeOpacity = 0.5;
                    polygonTemplate.nonScalingStroke = true;
                    var imageSeries = chart.series.push(new am4maps.MapImageSeries());
                    var imageSeriesTemplate = imageSeries.mapImages.template;
                    var circle = imageSeriesTemplate.createChild(am4core.Sprite);
                    circle.scale = 0.4;
                    circle.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
                    circle.path = targetSVG;
                    imageSeriesTemplate.propertyFields.latitude = "latitude";
                    imageSeriesTemplate.propertyFields.longitude = "longitude";
                    imageSeriesTemplate.horizontalCenter = "middle";
                    imageSeriesTemplate.verticalCenter = "middle";
                    imageSeriesTemplate.align = "center";
                    imageSeriesTemplate.valign = "middle";
                    imageSeriesTemplate.width = 8;
                    imageSeriesTemplate.height = 8;
                    imageSeriesTemplate.nonScaling = true;
                    imageSeriesTemplate.tooltipText = "Total Evalution:{total_evalution} in {title}";
                    imageSeriesTemplate.fill = am4core.color("#000");
                    imageSeriesTemplate.background.fillOpacity = 0;
                    imageSeriesTemplate.background.fill = am4core.color("#ffffff");
                    imageSeriesTemplate.setStateOnChildren = true;
                    imageSeriesTemplate.states.create("hover");
                    imageSeries.data = agentlocation;
                });
            }*/
            
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