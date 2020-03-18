<!DOCTYPE html>
<html>
<?php $this->load->view('common/head_view') ?>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/circle.css" />
<script src="<?=base_url()?>assets/js/jQuery-plugin-progressbar.js"></script>

    <body class="content_loading">
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
                    <div class="cards-section mt-24">
                        <div class="card top-card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Overall Score</h3>
                                <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                            </div>
                            <div class="row mb-0">
                                <div class="col s12 m5 xl4">
                                    <h4 class="card-title text-lg center">QA Score</h4>
                                    
                                    <div id="chart_011" class="charts_cont">
                                        <div class="progress-bar position" data-percent="<?php echo (!empty($overall_qa[0]['avg'])?$overall_qa[0]['avg']:0);?>" data-duration="3000" data-color="#ccc,#8e24aa"></div>
                                        
                                    </div>
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
                                        % from last month
                                            </span>
                                        </p>
                                </div>
                                <div class="col s12 m7 xl8">
                                    <div class="stats-cards d-flex justify-content-between">
                                        <div class="stats-card sm-card">
                                            <h5 class="stats-heading">Pass Rate</h5>
                                            <span class="stats-count">
                                                <?php
                                                    echo (!empty($pass_rate['avg'])?$pass_rate['avg']:0)."%";
                                                ?>
                                            </span>
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
                                        <div class="stats-card sm-card">
                                            <h5 class="stats-heading">Evaluations</h5>
                                            <span class="stats-count">
                                                <?php
                                                    echo (!empty($total_overall_evulation)?$total_overall_evulation:0);
                                                ?>
                                            </span>
                                        </div>
                                        <div class="stats-card sm-card">
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
                                                            ".(!empty($pre_fatal['ne'][0])?$pre_pass_rate['ne'][0]:0)."
                                                        </span>";
                                            }
                                            else{
                                                echo "<p class='progress_status'><span class='symbol'></span>
                                                        <span>
                                                            ".(!empty($pre_fatal['eq'][0])?$pre_pass_rate['eq'][0]:0)."
                                                        </span>";
                                            }
                                        ?>
                                         from last month</span></p>
                                        </div>
                                    </div>
                                    <h4 class="card-title">Overall QA Score</h4>
                                    <div id="chart_02" class="charts_cont" style="height: 200px "></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cards-section mt-24">
                        <div class="card progress_cards">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Overall Score</h3>
                                <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                            </div>
                            <div class="row mb-0">
                                <div class="col s6 l3">
                                    <div id="chart_001" class="charts_cont">
                                        <div class="progress-bar position" data-percent="<?php  echo (!empty($kpi['CSAT'])?$kpi['CSAT']:0);?>" data-duration="3000" data-color="#ccc,#8e24aa"></div>
                                    </div>
                                    <p class='progress_status'>
                                        <span><b>CSAT</b></span>
                                    </p>
                                </div>
                        
                                <div class="col s6 l3">
                                    <div id="chart_002" class="charts_cont">
                                        <div class="progress-bar position" data-percent="<?php echo (!empty($kpi['Resolution'])?$kpi['Resolution']:0);?>" data-duration="3000" data-color="#ccc,#8e24aa"></div>
                                    </div>
                                    <p class='progress_status'>
                                        <span><b>Resolution</b></span>
                                    </p>
                                </div>
                                <div class="col s6 l3">
                                    <div id="chart_003" class="charts_cont">
                                        <div class="progress-bar position" data-percent="<?php echo (!empty($kpi['Sales'])?$kpi['Sales']:0);?>" data-duration="3000" data-color="#ccc,#8e24aa"></div>
                                    </div>
                                    <p class='progress_status'>
                                        <span><b>Sales</b></span>
                                    </p>
                                </div>
                                <div class="col s6 l3">
                                    <div id="chart_004" class="charts_cont">
                                        <div class="progress-bar position" data-percent="<?php echo (!empty($kpi['Retention'])?$kpi['Retention']:0);?>" data-duration="3000" data-color="#ccc,#8e24aa"></div>
                                    </div>
                                    <p class='progress_status'>
                                        <span><b>Retention & Rate</b></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cards-section mt-24">
                        <div class="card progress_cards">
                            <div class="row mb-0">
                                <div id="chart_03" class="charts_cont" style="height: 300px "></div>
                            </div>
                        </div>
                    </div>

                    <div class="cards-section mt-24">
                        <div class="card progress_cards">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Rank</h3>
                                <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                            </div>
                            <div class="row mb-0">
                                <div class="col s6 l6 center-align">
                                    <span style="font-size: 16px;font-weight: bold;">Top Attribute</span>
                                    <div id="topchart" class="charts_cont"  style="height: 300px;">No Data Found</div>
                                </div>                            
                                <div class="col s6 l6 center-align">
                                    <span style="font-size: 16px;font-weight: bold;">Bottom Attribute</span>
                                    <div id="bottomchart" class="charts_cont"  style="height: 300px;">No Data Found</div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="cards-section mt-24">
                        <div class="card progress_cards">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title">Rank</h3>
                                <a class="filter_btn modal-trigger mr-12" href="#chart_modal"><i class="flaticon-settings-gears"></i></a>
                            </div>
                            <div class="row mb-0">
                                <div class="col s6 l6 center-align">
                                    <table class="rank">
                                        <thead>
                                            <tr>
                                                <th>Rank</th>
                                                <th>Top Attribute</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($rank['top'])){
                                                    $count = 1;
                                                    foreach ($rank['top'] as $key => $value) {
                                                        echo "<tr><td>{$count}</td><td>{$value['name']}</td><td>{$value['avg']}</td></tr>";
                                                        $count++;
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>                            
                                <div class="col s6 l6 center-align">
                                     <table class="rank">
                                        <thead>
                                            <tr>
                                                <th>Rank</th>
                                                <th>Bottom Attribute</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($rank['bottom'])){
                                                    $count = 10;
                                                    foreach ($rank['bottom'] as $key => $value) {
                                                        echo "<tr><td>{$count}</td><td>{$value['name']}</td><td>{$value['avg']}</td></tr>";
                                                        $count--;
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARDS CONTAINER END -->
                   
                   
                        <!-- Modal Structure -->
                        <div id="chart_modal" class="modal chart_modal">
                            <div class="modal-content">
                                <h5 class="modal-heading">Chart Setting</h5>
                                <form id="filter_frm">
                                    <input type="hidden" name="chart_id" id="chart_id" value="">
                                    <div class="row mb-0">
                                        <div class="col m5 p-0">
                                            <div class="chart-title">
                                                <h6 class="chart_modal_title">Chart Name</h6>
                                                <div class="chart-field">
                                                    <input id="chart_title" type="text" name="chart_title">
                                                    <label for="chart_type">Title</label>
                                                </div>
                                            </div>
                                            <div class="chart-date">
                                                <h6 class="chart_modal_title">Date Range</h6>
                                                <div class="chart-field">
                                                    <select id="date_column" name="date_column">
                                                        <option value="submit_time">Evaluation Date</option>
                                                        <option value="call_date">Call Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Type</label>
                                                </div>
                                                <div class="chart-field">
                                                    <select id="date_range" name="date_range">
                                                        <option value="OneDay">1 day</option>
                                                        <option value="Today">Today</option>
                                                        <option value="OneWeek">1 week</option>
                                                        <option value="TwoWeeks">2 weeks</option>                                                    
                                                        <option value="PreviousMonth">Previous Month</option>
                                                        <option value="OneMonth" selected>One Month</option>
                                                        <option value="QuartertoDate">Quarter to date</option>
                                                        <option value="YearDate">Year to date</option>
                                                        <option value="OneYear">1 year</option>
                                                        <option value="Custom">Custom Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Range</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_sdate" name="chart_sdate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>" disabled>
                                                    <label for="chart_sdate">From</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_edate" name="chart_edate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>" disabled>
                                                    <label for="chart_edate">To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m7 p-0">
                                            <div class="chart-search">
                                                <h6 class="chart_modal_title">Fill Choice</h6>
                                                <div class="chart-field">
                                                    <select id="search_type" name="search_type">
                                                        <option value="lob">LOB</option>
                                                        <option value="campaign">Campagin</option>
                                                        <option value="vendor">Vendor</option>
                                                        <option value="location">Location</option>
                                                        <option value="agents">Agents</option>
                                                    </select>
                                                    <label for="search_type">Search</label>
                                                </div>
                                                <h6 class="chart_modal_title">Select from</h6>
                                                <div class="chart_search_result">
                                                    <div class="search_result_pagination">
                                                        <div id="page1" class="search_page">
                                                            <?php 
                                                                $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                                foreach ($sup_lob as $key => $value) {
                                                                    echo "<p class='m-0'>
                                                                            <label>
                                                                                <input type='checkbox' name='search_result' class='filled-in' value='{$value}'/>
                                                                                <span>{$value}</span>
                                                                                <input type='text' name='favcolor' value=''>
                                                                            </label>
                                                                        </p>";
                                                                }
                                                            ?>                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 btn-cont">
                                            <span class="error_modal_msg"></span>
                                            <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button>
                                            <button type="subbmit" id="filter_submit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Section Wise model -->
                        <div id="section_chart_modal" class="modal chart_modal">
                            <div class="modal-content">
                                <h5 class="modal-heading">Chart Setting</h5>
                                <form id="filter_frm">
                                    <input type="hidden" name="chart_id" value="chart_area2">
                                    <div class="row mb-0">
                                        <div class="col m5 p-0">
                                            <div class="chart-title">
                                                <h6 class="chart_modal_title">Chart Name</h6>
                                                <div class="chart-field">
                                                    <input id="chart_title" type="text" name="chart_title">
                                                    <label for="chart_type">Title</label>
                                                </div>
                                            </div>
                                            <div class="chart-date">
                                                <h6 class="chart_modal_title">Date Range</h6>
                                                <div class="chart-field">
                                                    <select id="date_column" name="date_column">
                                                        <option value="submit_time">Evaluation Date</option>
                                                        <option value="call_date">Call Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Type</label>
                                                </div>
                                                <div class="chart-field">
                                                    <select id="date_range" name="date_range">
                                                        <option value="OneDay">1 day</option>
                                                        <option value="Today">Today</option>
                                                        <option value="OneWeek">1 week</option>
                                                        <option value="TwoWeeks">2 weeks</option>                                                    
                                                        <option value="PreviousMonth">Previous Month</option>
                                                        <option value="OneMonth" selected>One Month</option>
                                                        <option value="QuartertoDate">Quarter to date</option>
                                                        <option value="YearDate">Year to date</option>
                                                        <option value="OneYear">1 year</option>
                                                        <option value="Custom">Custom Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Range</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_sdate" name="chart_sdate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>" disabled>
                                                    <label for="chart_sdate">From</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_edate" name="chart_edate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>" disabled>
                                                    <label for="chart_edate">To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m7 p-0">
                                            <div class="chart-search">
                                                <h6 class="chart_modal_title">Fill Choice</h6>
                                                <div class="chart-field">
                                                    <select id="section_search_type" name="search_type">
                                                        <option value="" selected="">Select Lob</option>
                                                        <?php
                                                            $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                            foreach ($sup_lob as $key => $value) {
                                                                echo "<option value='{$value}'>{$value}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <label for="search_type">Search</label>
                                                </div>
                                                <div class="chart-field flex-wrap">
                                                    <div class="chart-field-inner">
                                                        <select name="section_campaign" id="section_campaign"  multiple>
                                                            <option value="" selected>Select Campaign</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="section_vendor" id="section_vendor" multiple>
                                                            <option value="" selected>Select Vendor</option>
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="section_loc" id="section_loc" multiple>
                                                            <option value="" selected>Select Location</option>         
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="section_agents" id="section_agents" multiple>
                                                            <option value="" selected>Select Agent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <h6 class="chart_modal_title">Select from</h6>
                                                <div class="chart_search_result">
                                                    <div class="search_result_pagination">
                                                        <div id="page1" class="search_page custom_scrollbar">
                                                            <?php 
                                                                // $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                            $sup_lob = array("Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota");
                                                                foreach ($sup_lob as $key => $value) {
                                                                    echo "<p class='m-0'>
                                                                            <label>
                                                                                <input type='checkbox' name='search_result' class='filled-in' value='{$value}'/>
                                                                                <span>{$value}</span>
                                                                                <input type='color' class='right' name='favcolor' value='' >
                                                                            </label>
                                                                        </p>";
                                                                }

                                                            ?>                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    <!-- Modal Structure -->
                    <div id="chart_modal" class="modal chart_modal">
                        <div class="modal-content">
                            <h5 class="modal-heading">Chart Setting</h5>
                            <div class="row mb-0">
                                <div class="col m5 p-0">
                                    <div class="chart-title">
                                        <h6 class="chart_modal_title">Chart Name</h6>
                                        <div class="chart-field">
                                            <input id="chart_title" type="text">
                                            <label for="chart_type">Title</label>
                                        </div>
                                    </div>
                                    <div class="chart-date">
                                        <h6 class="chart_modal_title">Date Range</h6>
                                        <div class="chart-field">
                                            <select id="chart_type" name="">
                                                <option value="evaluation date">Evaluation Date</option>
                                                <option value="call date">Call Date</option>
                                            </select>
                                            <label for="chart_type">Date Type</label>
                                        </div>
                                        <div class="chart-field">
                                            <input id="chart_sdate" type="text" class="datepicker">
                                            <label for="chart_sdate">From</label>
                                        </div>
                                        <div class="chart-field">
                                            <input id="chart_edate" type="text" class="datepicker">
                                            <label for="chart_edate">To</label>
                                        </div>
                                        <div class="col s12 btn-cont">
                                            <span class="error_modal_msg"></span>
                                            <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button>
                                            <button type="subbmit" id="filter_submit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Section Wise model -->
                        
                        <!-- attribute wise modal -->
                        <div id="attribte_chart_modal" class="modal chart_modal">
                            <div class="modal-content">
                                <h5 class="modal-heading">Chart Setting</h5>
                                <form id="filter_frm">
                                    <input type="hidden" name="chart_id"  value="chart_area3">
                                    <div class="row mb-0">
                                        <div class="col m5 p-0">
                                            <div class="chart-title">
                                                <h6 class="chart_modal_title">Chart Name</h6>
                                                <div class="chart-field">
                                                    <input id="chart_title" type="text" name="chart_title">
                                                    <label for="chart_type">Title</label>
                                                </div>
                                            </div>
                                            <div class="chart-date">
                                                <h6 class="chart_modal_title">Date Range</h6>
                                                <div class="chart-field">
                                                    <select id="date_column" name="date_column">
                                                        <option value="submit_time">Evaluation Date</option>
                                                        <option value="call_date">Call Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Type</label>
                                                </div>
                                                <div class="chart-field">
                                                    <select id="date_range" name="date_range">
                                                        <option value="OneDay">1 day</option>
                                                        <option value="Today">Today</option>
                                                        <option value="OneWeek">1 week</option>
                                                        <option value="TwoWeeks">2 weeks</option>                                                    
                                                        <option value="PreviousMonth">Previous Month</option>
                                                        <option value="OneMonth" selected>One Month</option>
                                                        <option value="QuartertoDate">Quarter to date</option>
                                                        <option value="YearDate">Year to date</option>
                                                        <option value="OneYear">1 year</option>
                                                        <option value="Custom">Custom Date</option>
                                                    </select>
                                                    <label for="chart_type">Date Range</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_sdate" name="chart_sdate" type="text" class="datepicker" value="<?php echo date('Y-m-d',(strtotime ( '-30 day' , strtotime ( date('Y-m-d')) ) ));?>" disabled>
                                                    <label for="chart_sdate">From</label>
                                                </div>
                                                <div class="chart-field">
                                                    <input id="chart_edate" name="chart_edate" type="text" class="datepicker" value="<?php echo date('Y-m-d');?>" disabled>
                                                    <label for="chart_edate">To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m7 p-0">
                                            <div class="chart-search">
                                                <h6 class="chart_modal_title">Fill Choice</h6>
                                                <!-- <div class="chart-field">
                                                    <select id="search_type" name="search_type">
                                                        <option value="lob">LOB</option>
                                                        <option value="campaign">Campagin</option>
                                                        <option value="vendor">Vendor</option>
                                                        <option value="location">Location</option>
                                                        <option value="agents">Agents</option>
                                                    </select>
                                                    <label for="search_type">Search</label>
                                                </div> -->
                                                <div class="chart-field flex-wrap">
                                                    <div class="chart-field-inner">
                                                       <select id="attr_search_type" name="search_type">
                                                        <option value="" selected="">Select Lob</option>
                                                        <?php
                                                            $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                            foreach ($sup_lob as $key => $value) {
                                                                echo "<option value='{$value}'>{$value}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="attr" id="arrt">
                                                            <option value="" selected>Select Attribute</option>
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="attr_camp" id="arrt_camp" multiple>
                                                            <option value="" selected>Select Campaign</option>
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="attr_vandor" id="attr_vandor" multiple>
                                                            <option value="" selected>Select Vendor</option>
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="attr_loc" id="attr_loc" multiple>
                                                            <option value="" selected>Select Location</option>
                                                        </select>
                                                    </div>
                                                    <div class="chart-field-inner">
                                                        <select name="attr_agent" id="attr_agent" multiple>
                                                            <option value="" selected>Select Agent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <h6 class="chart_modal_title">Select from</h6>
                                                <div class="chart_search_result">
                                                    <div class="search_result_pagination">
                                                        <div id="page1" class="search_page custom_scrollbar">
                                                            <?php 
                                                                // $sup_lob = explode('|||', $this->session->userdata('lob'));
                                                            $sup_lob = array("Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota","Volvo", "BMW", "Toyota");
                                                                foreach ($sup_lob as $key => $value) {
                                                                    echo "<p class='m-0'>
                                                                            <label>
                                                                                <input type='checkbox' name='search_result' class='filled-in' value='{$value}'/>
                                                                                <span>{$value}</span>
                                                                                <input type='color' class='right' name='favcolor' value='' >
                                                                            </label>
                                                                        </p>";
                                                                }

                                                            ?>                                                        
                                                        </div>
                                                    </div>
                                </div>
                                <div class="col m7 p-0">
                                    <div class="chart-search">
                                        <h6 class="chart_modal_title">Fill Choice</h6>
                                        <div class="chart-field">
                                            <select id="search_type" name="">
                                                <option value="enterprise">Enterprise</option>
                                                <option value="campagin">Campagin</option>
                                                <option value="vendor">Vendor</option>
                                                <option value="location">Location</option>
                                                <option value="lob">LOB</option>
                                            </select>
                                            <label for="search_type">Search</label>
                                        </div>
                                        <h6 class="chart_modal_title">Select from</h6>
                                        <div class="chart_search_result">
                                            <div class="search_result_pagination">
                                                <div id="page1" class="search_page">
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Virgin Mobile</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Mobile Compliance</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Virgin Media</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Repeat Contacts</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Virgin Mobile</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Mobile Compliance</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Virgin Media</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Repeat Contacts</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Mobile Compliance</span>
                                                        </label>
                                                    </p>
                                                    <p class="m-0">
                                                        <label>
                                                            <input type="checkbox" class="filled-in"/>
                                                            <span>Virgin Media</span>
                                                        </label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 btn-cont">
                                            <span class="error_modal_msg"></span>
                                            <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button>
                                            <button type="subbmit" id="filter_submit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- attribute wise modal -->
                                </div>
                                <div class="col s12 btn-cont">
                                    <button type="reset" class="btn modal-close waves-effect waves-light">Cancel</button>
                                    <button type="subbmit" class="btn modal-action modal-close cyan waves-effect waves-light">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $(".progress-bar").loading();
            
            var overallqadatanew    =   '<?php echo json_encode($overall_qa) ?>';
            overallqadatanew        =   JSON.parse(overallqadatanew);
            
            var dayWiseOverallData  =   '<?php echo json_encode($day_wise) ?>';
            dayWiseOverallData      =   JSON.parse(dayWiseOverallData);
            
            var fef                 =   '<?php echo json_encode($fef) ?>';
            fef                     =   JSON.parse(fef);

            var topRank             =   '<?php echo json_encode($rank['top']) ?>';
            topRank                 =   JSON.parse(topRank);

            var bottomRank          =   '<?php echo json_encode($rank['bottom']) ?>';
            bottomRank              =   JSON.parse(bottomRank);
            
            /*
                overallqadatanewAvg = overallqadatanew[0].avg;
                AmCharts.makeChart("chart_01", {
                    "type": "pie",
                    "theme": "none",
                    "innerRadius": "65%",
                    "radius": "42%",
                    "dataProvider": overallqadatanew,
                    "balloonText": "[[value]]",
                    "valueField": "avg",
                    "titleField": "name",
                    "balloon": {
                        "drop": true,
                        "cornerRadius": 5,
                        "maxWidth":27,
                        "adjustBorderColor": false,
                        "color": "#FFFFFF",
                        "fontSize": 16
                    },
                    "allLabels": [{
                        "y": "47%",
                        "align": "center",
                        "size": 20,
                        "bold": true,
                        "color": "#555",
                        "text": overallqadatanewAvg+'%'
                    }],
                    // "colorField" :'color',
                    "labelText":'',
                        "export": {
                            "enabled": true
                    }
                });
            */

            lineBar('chart_02',dayWiseOverallData);
            fefGraph('chart_03',fef);
            /*attributeGraph('topchart','Top',topRank);*/
            attributeGraph('bottomchart','Bottom',bottomRank);



var chart = AmCharts.makeChart("topchart", {
  "type": "funnel",
  "labelText": "[[value]]%",
  /*"legend": {
    "valueText": "[[value]] ([[percents]]%)",
    "valueWidth": 75
  },*/
  "dataProvider": topRank,
  "titleField": "name",
  "marginRight": 160,
  "marginLeft": 15,
  "labelPosition": "right",
  "funnelAlpha": 0.9,
  "valueField": "avg",
  "startX": 0,
  "neckWidth": "40%",
  "startAlpha": 0,
  "labelPosition": "center",
  "outlineThickness": 1,
  "neckHeight": "30%",
  "balloonText": "[[title]]:<b>[[value]]</b>",
  "export": {
    "enabled": true
  }
});
            
           
            var dashboard_filter_data   =   '<?php echo (!empty($dashboard)?json_encode($dashboard):'') ?>';
            if(dashboard_filter_data.length > 0)
                dashboard_filter_data       =   JSON.parse(dashboard_filter_data);
            $('.all_setting').click(function(){
                $('#filter_frm')[0].reset();
                var chart_id = $(this).attr('chart_id');
                $('#chart_id').val(chart_id);
                $.each(dashboard_filter_data,function(key,val){
                    if(val.chart_id === chart_id){
                        $('#chart_title').val(val.chart_name);
                        $('#date_column').val(val.call_type).attr("selected", true).formSelect();
                        $('#date_range').val(val.date_range).attr("selected", true).formSelect();
                        if(val.date_range === "Custom"){
                            $('#chart_sdate').val(val.start_date).attr('disabled',false);
                            $('#chart_edate').val(val.end_date).attr('disabled',false);    
                        }else{
                            $('#chart_sdate').val(val.start_date).attr('disabled',true);
                            $('#chart_edate').val(val.end_date).attr('disabled',true);    
                        }
                        $('#search_type').val(val.search).change().attr("selected", true).formSelect();
                        var search_res_data = val.sr.split(",");
                        var ss = $('.search_result');
                        $.each(ss, function(key1,val1){
                            $.each(search_res_data, function(key2,val2){
                                setTimeout(function(){
                                    $('#color_'+key2).val(val.coloum_color[val2]);
                                },500)
                                if(val1.attributes.value.value === val2){
                                    setTimeout(function(){
                                        $('input[name="search_result"]')[key1].checked = true;
                                    },500)
                                }
                            });
                        });                        
                    }
                })
            });
            $('#date_range').change(function(){
                var dd = $(this).val();
                getDate(dd)              
            });
            $('#search_type').change(function(){
                var dd = $(this).val();
                var response = postAjax("<?php echo site_url();?>/get-lob-data",{'search_type':dd});
                var op= '';
                $.each(response.data, function(key,val){
                    op +="<p class='m-0'>"+
                            "<label>"+
                                "<input type='checkbox' name='search_result' class='filled-in search_result' value='"+((val.id != undefined)?val.id:val.name)+"'/>"+
                                "<span>"+val.name+"</span>"+
                            "</label><input type='color' id='color_"+key+"' name='colcolor' class='colcolor' value='' style='float:right'>"+
                        "</p>";
                });
                $('.search_page').html(op);
            });
            $('#section_search_type').change(function(){
                var dd = $(this).val();
                var response = postAjax("<?php echo site_url();?>/get-lob-data",{'search_type':dd,'section':true});
                setDropDownValue(response,'section_campaign','section_vendor','section_loc','section_agents','search_page');
                return false;
            });
            
            $('#attr_search_type').change(function(){
                var dd = $(this).val();
                var response = postAjax("<?php echo site_url();?>/get-lob-data",{'search_type':dd,'section':true});
                setDropDownValue(response,'arrt_camp','attr_vandor','attr_loc','attr_agent','arrt');
                return false;
            });
            $('#arrt').change(function(){
                var dd = $(this).val();
                var attr_search_type = $('#attr_search_type').val();
                var response = postAjax("<?php echo site_url();?>/get-lob-data",{'search_type':dd,'attr_search_type':attr_search_type,'attribute':true});
                var op= '';
                $.each(response.att, function(key,val){
                    op +="<p class='m-0'>"+
                            "<label>"+
                                "<input type='checkbox' name='search_result' class='filled-in search_result' value='"+((val.id != undefined)?val.id:val.name)+"'/>"+
                                "<span>"+val.name+"</span>"+
                            "</label><input type='color' id='color_"+key+"' name='colcolor' class='colcolor' value='' style='float:right'>"+
                        "</p>";
                });
                $('.search_page').html(op);
                
                return false;
            });
            $('#filter_submit').click(function(e){
                e.preventDefault();                
                var chart_title = $('#chart_title').val();
                var chart_id    = $('#chart_id').val();
                var date_column = $('#date_column').val();
                var date_range = $('#date_range').val();
                var chart_sdate = $('#chart_sdate').val();
                var chart_edate = $('#chart_edate').val();
                var search_type = $('#search_type').val();
                var search_result = [];
                var coloum_color = $("input[name='search_result']:checked").map(function() {
                    return $(this).closest(".m-0").find(".colcolor").val();
                }).get();
                $.each($("input[name='search_result']:checked"), function(key,val){
                    search_result.push($(this).val());
                });
                if(chart_title.length > 0 && date_column.length > 0 && date_range.length > 0 && chart_sdate.length > 0 && chart_edate.length > 0 && search_type.length > 0 && search_result.length > 0){
                    var data = {'chart_title':chart_title,'chart_id':chart_id,'date_column':date_column,'date_range':date_range,'chart_sdate':chart_sdate,'chart_edate':chart_edate,'search_type':search_type,'search_result':search_result,'coloum_color':coloum_color}
                    console.log(data);
                    var response = postAjax("<?php echo site_url();?>/filter",data);
                    // return false;
                    dashboard_filter_data = response.dashboard;
                    console.log(response);
                    $('#name_'+chart_id).html(chart_title);
                    $('#title_'+chart_id).html(chart_sdate+' To '+chart_edate);
                    var chart_head_title = ((date_column === "submit_time")?'Evaluation Date':'Call Date');
                    if(chart_id === "chart_area1"){
                        barCharts(chart_id,response.overAll,chart_head_title);
                    }
                    if('chart_area4' === chart_id){
                        barCharts('chart_area4',response.fatel,chart_head_title);
                    }
                    if('chart_area5' === chart_id){
                        barCharts('chart_area5',response.pass,chart_head_title);
                    }
                }
                else{
                    $('.error_modal_msg').html('all fields are requried').css({'float': 'left','text-transform': 'capitalize','color': 'red'});
                    setTimeout(function(){
                        $('.error_modal_msg').html('');
                    },5000)
                    return false;
                }
            });
            $('#chart_modal').modal({
                dismissible: false 
            });

            function setDropDownValue(response,cmp_id,ven_id,loc_id,agents_id,result){
                var cmp = '';
                var van = '';
                var loc = '';
                var agents = '';
                var op= '';
                $.each(response.c, function(key,val){
                    cmp += "<option value='"+val.id+"'>"+val.name+"</option>";
                });
                $.each(response.v, function(key,val){
                    van += "<option value='"+val.id+"'>"+val.name+"</option>";
                });
                $.each(response.l, function(key,val){
                    loc += "<option value='"+val.id+"'>"+val.name+"</option>";
                });
                $.each(response.e, function(key,val){
                    agents += "<option value='"+val.id+"'>"+val.name+"</option>";
                });
                if(agents_id === "attr_agent"){
                    $.each(response.att, function(key,val){
                        op += "<option value='"+val.id+"'>"+val.name+"</option>";
                    });
                    $('#'+result).append(op).formSelect();
                }
                if(agents_id === "section_agents"){
                    $.each(response.att, function(key,val){
                         op +="<p class='m-0'>"+
                                "<label>"+
                                    "<input type='checkbox' name='search_result' class='filled-in search_result' value='"+((val.id != undefined)?val.id:val.name)+"'/>"+
                                    "<span>"+val.name+"</span>"+
                                "</label><input type='color' id='color_"+key+"' name='colcolor' class='colcolor' value='' style='float:right'>"+
                            "</p>";
                    });
                    $('.'+result).html(op);
                }
                $('#'+cmp_id).append(cmp).formSelect();
                $('#'+ven_id).append(van).formSelect();
                $('#'+loc_id).append(loc).formSelect();
                $('#'+agents_id).append(agents).formSelect();
            }

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
                    $('#chart_sdate').val(date).attr('disabled',true);
                    $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);
                }
                if(dd === "TwoWeeks"){
                    var date = formatDate(today.setDate( today.getDate() - 14));
                    $('#chart_sdate').val(date).attr('disabled',true);
                    $('#chart_edate').val(formatDate(new Date())).attr('disabled',true);
                }
                if(dd === "PreviousMonth"){
                    var now = new Date();
                    var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
                    var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);
                    var formatDateComponent = function(dateComponent) {
                        return (dateComponent < 10 ? '0' : '') + dateComponent;
                    };
                    $('#chart_sdate').val(formatDate(prevMonthFirstDate)).attr('disabled',true);
                    $('#chart_edate').val(formatDate(prevMonthLastDate)).attr('disabled',true);
                }
                if(dd === "OneMonth"){
                    var makeDate    = new Date(today);
                    makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 1));
                    var date        = formatDate(makeDate);
                    $('#chart_sdate').val(date).attr('disabled',true);
                    $('#chart_edate').val(formatDate(today)).attr('disabled',true);
                }
                if(dd === "QuartertoDate"){
                    var makeDate    = new Date(today);
                    makeDate.setDate(1);
                    makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 2));
                    var date        = formatDate(makeDate);
                    $('#chart_sdate').val(date).attr('disabled',true);
                    $('#chart_edate').val(formatDate(today)).attr('disabled',true);
                }
                if(dd === "YearDate"){
                    var makeDate    = new Date(today);
                    makeDate.setDate(1);
                    makeDate.setMonth(0);
                    makeDate.getFullYear();
                    var date        = formatDate(makeDate);
                    $('#chart_sdate').val(date).attr('disabled',true);
                    $('#chart_edate').val(formatDate(today)).attr('disabled',true);
                }
                if(dd === "OneYear"){
                    var makeDate    = new Date(today);
                    makeDate        = new Date(makeDate.setMonth(makeDate.getMonth() - 12));
                    var date        = formatDate(makeDate);
                    $('#chart_sdate').val(date).attr('disabled',true);
                }
                if(dd === "Custom"){
                    $('#chart_sdate').attr('disabled',false);
                    $('#chart_edate').attr('disabled',false);
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
            
            
            

            /*Graph */
                /* dual bar Grahp*/
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
                /* End dual bar Grahp*/

                function barCharts(div,sectionqadata,title){
                    if(sectionqadata !== null){
                        AmCharts.makeChart( div, {
                            "type": "serial",
                            "theme": "none",
                            "dataProvider": sectionqadata,
                            "valueAxes": [ {
                                "title": title,
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
                                "fillAlphas": 0.8,
                                "lineAlpha": 0.2,
                                "fillColorsField": "color",
                                "fillColors": "#CC0000",
                                //"fillColorsField": "color",
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

                function lineBar(divId,data){
                    var chart = AmCharts.makeChart(divId, {
                                    "type": "serial",
                                    "theme": "light",
                                    "startDuration": 1,   
                                    "valueAxes": [{
                                        "id": "v1",
                                        "title": "Total Evulation",
                                        "position": "left",
                                        "autoGridCount": false,
                                        "gridAlpha": 0,
                                        "gridColor": "#FFFFFF",
                                        "gridAlpha": 0,
                                        "axisColor": "#555555",
                                    }, 
                                    {
                                        "id": "v2",
                                        "title": "Average",
                                        "position": "right",
                                        "autoGridCount": false,
                                        "gridAlpha": 0,
                                        "gridColor": "#FFFFFF",
                                        "gridAlpha": 0,
                                        "axisColor": "#555555",
                                    }],
                                    "graphs": [{
                                        "id": "g4",
                                        "valueAxis": "v1",
                                        "lineColor": "#3B7610",
                                        "fillColors": "#3B7610",
                                        "fillAlphas": 1,
                                        "type": "column",
                                        "title": "Total Evulation",
                                        "valueField": "total_evulation",
                                        "clustered": false,
                                        "columnWidth": 0.3,
                                        "topRadius":0.95,
                                        // "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                                        "balloonText": "<span style='font-size:14px;'>[[title]] :<b>[[value]]</b></span>",
                                        }, {
                                        "id": "g1",
                                        "valueAxis": "v2",
                                        "bullet": "round",
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#FFFFFF",
                                        "bulletSize": 5,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 2,
                                        "lineColor": "#20acd4",
                                        "type": "smoothedLine",
                                        "title": "Overall QA Average",  
                                        "topRadius":0.95,
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "avg",
                                        //"balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                                        "balloonText": "<span style='font-size:14px;'>[[title]] :<b>[[value]]%</b></span>",
                                    }],     
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": false,
                                        "cursorAlpha": 0,
                                        "valueLineAlpha": 0.2
                                    },
                                    "categoryField": "year",
                                    categoryAxis: {
                                        autoGridCount: false,
                                        gridCount: 50,
                                        gridAlpha: 0,
                                        gridColor: "#FFFFFF",
                                        axisColor: "#555555",
                                        labelRotation:45,                                      
                                    },
                                    "legend": { "horizontalGap": 5,
                                    "maxColumns": 30,
                                    "useGraphSettings": true,
                                    "markerSize": 10,
                                    "leftMargin": 0,
                                    "valueText": ""
                                },
                                "balloon": {
                                    "borderThickness": 1,
                                    "shadowAlpha": 0,
                                    "color": "#000000",
                                    "fillColor": "#FFFFFF"
                                },
                                "export": {
                                    "enabled": true
                                },
                                "dataProvider": data
                    });
                }

                function fefGraph(divId,data){
                    var chart = AmCharts.makeChart(divId, {
                                    type: "serial",
                                    theme: "light",
                                    dataProvider: data,
                                    synchronizeGrid:true,
                                    addClassNames: true,
                                    startDuration: 1,
                                    color: "#000000",
                                    marginLeft: 0,
                                    categoryField: "day",
                                    categoryAxis: {
                                        autoGridCount: false,
                                        gridCount: 50,
                                        gridAlpha: 0,
                                        gridColor: "#FFFFFF",
                                        axisColor: "#555555",
                                        labelRotation:45,                                      
                                    },
                                    valueAxes: [
                                        {
                                            id: "a1",
                                            title: "Total Evulation",
                                            "axisThickness": 0.5,
                                            "axisAlpha": 1,
                                            "position": "left",
                                            "dashLength":0,
                                            "gridAlpha": 0,
                                            "gridColor": "#FFFFFF",
                                        },{
                                            id: "a2",
                                            title: "Average",
                                            "axisThickness": 0.5,
                                            "axisAlpha": 1,
                                            "position": "right",
                                            "dashLength":0,
                                            "gridAlpha": 0,
                                            "gridColor": "#FFFFFF",
                                        }
                                        // ,{
                                        //     id: "a3",
                                        //     "axisThickness": 2,
                                        //     "gridAlpha": 0,
                                        //     "offset": 50,
                                        //     "axisAlpha": 1,
                                        //     "position": "left"                                           
                                        // },
                                        // {
                                        //     id: "a4",
                                        //     "axisThickness": 2,
                                        //     "gridAlpha": 0,
                                        //     "offset": 50,
                                        //     "axisAlpha": 1,
                                        //     "position": "right"                                           
                                        // }

                                    ],
                                    graphs: [
                                        {
                                            id: "g1",
                                            valueField:  "total_evulation",
                                            title: "Total Evulation",
                                            type:  "column",
                                            fillAlphas:  0.9,
                                            valueAxis:  "a1",
                                            balloonText:  "Total Evulation: [[value]]",
                                            legendValueText:  "[[value]]",
                                            legendPeriodValueText:  "total: [[value.sum]]",
                                            lineColor:  "#3B7610",
                                            alphaField:  "alpha",
                                        },
                                        {
                                            id: "g2",
                                            valueField: "escavg",
                                            title: "Escalation",
                                            type: "line",
                                            valueAxis: "a2",
                                            lineColor: "#786c56",
                                            balloonText: "Escalation: [[value]]%",
                                            lineThickness: 1,
                                            legendValueText: "[[value]]",
                                            bullet: "triangleUp",
                                            bulletBorderColor: "#786c56",
                                            bulletBorderAlpha: 1,
                                            bulletColor: "#000000",
                                            // classNameField: "bulletClass",
                                            // descriptionField: "townName",
                                            // bulletSizeField: "townSize",
                                            // bulletBorderThickness: 2,
                                            // labelText: "[[townName2]]",
                                            labelPosition: "right",
                                            showBalloon: true,
                                            animationPlayed: true,
                                        },
                                        {
                                            id: "g3",
                                            valueField: "fatelavg",
                                            title: "fatel",
                                            type: "line",
                                            valueAxis: "a2",
                                            lineColor: "#ef634f",
                                            balloonText: "Fatal: [[value]]%",
                                            lineThickness: 1,
                                            legendValueText: "[[value]]",
                                            bullet: "square",
                                            bulletBorderColor: "#ef634f",
                                            bulletBorderThickness: 1,
                                            bulletBorderAlpha: 1,
                                            dashLengthField: "dashLength",
                                            animationPlayed: true
                                        },
                                        {
                                            id: "g4",
                                            valueField: "feedbackavg",
                                            title: "Feedback",
                                            type: "line",
                                            valueAxis: "a2",
                                            lineColor: "#9126a7",
                                            balloonText: "Feedback: [[value]]%",
                                            lineThickness: 1,
                                            legendValueText: "[[value]]",
                                            bullet: "square",
                                            bulletBorderColor: "#9126a7",
                                            bulletBorderThickness: 1,
                                            bulletBorderAlpha: 1,
                                            dashLengthField: "dashLength",
                                            animationPlayed: true
                                        }
                                    ],
                                    chartCursor: {
                                        zoomable: false,
                                        categoryBalloonDateFormat: "DD",
                                        cursorAlpha: 0,
                                        valueBalloonsEnabled: false
                                    },
                                    legend: {
                                        bulletType: "round",
                                        equalWidths: false,
                                        valueWidth: 120,
                                        useGraphSettings: true,
                                        color: "#000000"
                                    }
                                });
                }
                function attributeGraph(divId,title,data){
                    AmCharts.makeChart(divId, {
                        "type": "serial",
                        "theme": "none",
                        "handDrawScatter":3,
                        "legend": {
                            "useGraphSettings": true,
                            "markerSize":12,
                            "valueWidth":0,
                            "verticalGap":0
                        },
                        "dataProvider": data,
                        "valueAxes": [{
                            "minorGridAlpha": 0.08,
                            "minorGridEnabled": true,
                            "position": "bottom",
                            "axisAlpha":0,
                            "gridAlpha": 0,
                            "gridColor": "#FFFFFF",
                            autoGridCount:false,
                            gridCount:10,
                            axisFrequency:10,
                            baseValue:0,
                            maximum:100,
                            minimum:0
                        }],
                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": "<span style='font-size:13px;'>[[category]]:<b>[[value]]</b></span>",
                            "title": title,
                            "type": "column",
                            "fillAlphas": 0.8,
                            "valueField": "avg"
                        }],
                        "rotate": true,
                        "categoryField": "name",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "labelFunction": trimLabel,
                            "gridAlpha": 0,
                            "gridColor": "#FFFFFF"
                        },
                        "export": {
                            "enabled": true
                         }
                    });
                }

                function lineBar1(divId,data){
                    var chart = AmCharts.makeChart(divId, {
                        "type": "serial",
                        "theme": "none",
                        "legend": {
                            "useGraphSettings": false,
                            "markerSize":12,
                            "valueWidth":0,
                            "verticalGap":0
                        },
                        "dataProvider": data,
                        "balloon": {
                            "cornerRadius": 6,
                            "horizontalPadding": 15,
                            "verticalPadding": 10
                        },
                        "valueAxes": [{
                            "gridColor": "transparents",
                            "axisColor": "transparents",
                            "axisThickness": 0,
                            "position": "left",
                        }],

                        "startDuration": 1,
                        "graphs": [{
                            "balloonText": "<span style='font-size:10px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                            "title": "Total Evulation",
                            "type": "column",
                            "fillAlphas": 1,
                            "fillColorsField": "color",
                            "valueField": "total_evulation"
                            }, 
                            {
                                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>",
                                "bullet": "round",
                                "bulletBorderAlpha": 1,
                                "bulletBorderThickness": 1,
                                "fillAlphas": 0,
                                "bulletColor": "#FFFFFF",
                                "useLineColorForBulletBorder": true,
                                // "lineColorField": "color", 
                                "lineThickness": 2,
                                "lineAlpha": 1,
                                "bulletSize": 7,
                                "title": "Average",
                                "valueField": "avg"
                            }
                        ],
                        "categoryField": "year",
                        "categoryAxis": {
                            "minPeriod": "mm",
                            "autoGridCount": false,
                            "gridCount": 1000,
                            "gridPosition": "start",
                            "labelRotation":45,
                            "gridColor": "transparents",
                            "axisColor": "transparents",
                        },
                        "export": {
                            "enabled": true
                        }
                    });
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
                    return label.length >= 15 ? label.substr(0, 5) + "...": label;
                }
            /*End Graph */
                
            
            
            

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
