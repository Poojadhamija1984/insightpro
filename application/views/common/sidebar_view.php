<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light navbar-full sidenav-active-rounded">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="<?= site_url() ?>/user-profile">
                <img src="<?= base_url() ?>assets/images/mattsen_logo_white.png" alt="materialize logo"/>
                <span class="logo-text hide-on-med-and-down">InsightsPRO</span>
            </a>
            <a class="navbar-toggler" href="javascript:void(0)"><i class="material-icons">radio_button_checked</i></a>
        </h1>
    </div>
    <?php
    $emp_group = $this->session->userdata('emp_group'); // 2 =>ops 3=>client 
    $emp_type = $this->session->userdata('usertype'); //  2=>agent 3=>supervisor 
    $emp_group = ($emp_group == '1') ? 'admin' : ( ($emp_group == '2') ? 'ops' : 'client' ); // ops->evaluator_id
    $emp_type = ($emp_type == '1') ? 'admin' : ( ($emp_type == '2') ? 'agent' : 'supervisor' );
    ?>
    
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">            
        <?php
        $industry_type = strtolower($this->session->userdata('industry_type'));
        if ($industry_type == "bpo") {
            //***************************************************Start bpo industry type********************************************************
            if (($emp_group == "client" || $emp_group == "ops") && ($emp_type == "supervisor" || $emp_type == "agent")) {
                ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'dashboard')?'active':''; ?>" href="<?php echo site_url(); ?>/dashboard">
                        <i class="flaticon-dashboard-1"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php if (($emp_group == "client" || $emp_group == "ops") && $emp_type == "agent") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'audit-history')?'active':''; ?>" href="<?php echo site_url(); ?>/audit-history">
                        <i class="flaticon-search"></i>
                        <span class="menu-title">Audit Summary</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (($emp_group == "client" || $emp_group == "ops") && ($emp_type == "agent" || $emp_type == "supervisor")) { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'dump')?'active':''; ?>" href="<?php echo site_url(); ?>/dump">
                        <i class="flaticon-download-2"></i>
                        <span class="menu-title">Dump</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($emp_group == "admin") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'hierarchy')?'active':''; ?>" href="<?php echo site_url(); ?>/hierarchy">
                        <i class="flaticon-diagram-1"></i>
                        <span class="menu-title">Hierarchy</span>
                    </a>
                </li>
            <?php } ?>
            <?php if ($emp_group == "ops" && $emp_type == "supervisor") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'orms-list')?'active':''; ?>" href="<?php echo site_url(); ?>/forms-list">
                        <i class="flaticon-notepad-1"></i>
                        <span class="menu-title">Form</span>
                    </a>
                </li>
            <?php }  ?>
            <?php if (($emp_group == "client" || $emp_group == "ops") && $emp_type == "supervisor") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'team-view')?'active':''; ?>" href="<?php echo site_url(); ?>/team-view">
                        <i class="flaticon-team-1"></i>
                        <span class="menu-title">Team View</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'escalation')?'active':''; ?>" href="<?php echo site_url(); ?>/escalation">
                        <i class="flaticon-search-1"></i>
                        <span class="menu-title">Escalation</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'calibration')?'active':''; ?>" href="<?php echo site_url(); ?>/calibration">
                        <i class="flaticon-weight"></i>
                        <span class="menu-title">Calibration</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'ata')?'active':''; ?>" href="<?php echo site_url(); ?>/ata">
                        <i class="flaticon-tick"></i>
                        <span class="menu-title">ATA</span>
                    </a>
                </li>
            <?php }  ?>
            <?php if (($emp_group == "ops") && $emp_type == "agent") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'bucket')?'active':''; ?>" href="<?php echo site_url(); ?>/bucket">
                        <i class="material-icons">settings_input_svideo</i>
                        <span class="menu-title">My Audits</span>
                    </a>
                </li>
            <?php }  ?>

            <?php if ($emp_group == "client" && $emp_type == "agent") { ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'escalation')?'active':''; ?>" href="<?php echo site_url(); ?>/escalation">
                        <i class="flaticon-search-1"></i>
                        <span class="menu-title">Escalation</span>
                    </a>
                </li>
            <?php }  ?>
            <!-- Report -->
            <?php
            if (($emp_group == "client" || $emp_group == "ops") && $emp_type == "supervisor") {
                ?>
                <li class="bold menu-item">
                    <a class="collapsible-header waves-effect waves-cyan " href="javascript:void(0)">
                        <i class="flaticon-statistics-1"></i>
                        <span class="menu-title">Report</span>
                    </a>
                    <div class="collapsible-body">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                            
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'Autofail-Report')?'active':''; ?>" href="<?php echo site_url(); ?>/Autofail-Report">
                                    <i class="material-icons">radio_button_unchecked</i><span>Autofail Report</span>
                                </a>
                            </li>
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'tag-report')?'active':''; ?>" href="<?php echo site_url(); ?>/tag-report">
                                    <i class="material-icons">radio_button_unchecked</i><span>Tag Report</span>
                                </a>
                            </li>
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'Agent-QA-Performance')?'active':''; ?>" href="<?php echo site_url(); ?>/Agent-QA-Performance">
                                    <i class="material-icons">radio_button_unchecked</i><span>Agent QA Performance</span>
                                </a>
                            </li>
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'attribute-report')?'active':''; ?>" href="<?php echo site_url(); ?>/attribute-report">
                                    <i class="material-icons">radio_button_unchecked</i><span>Attribute Report</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <?php
            }
            ?>
            <!-- End Report -->
            <!-- Team -->
            <?php
            if ($emp_group == "admin") {
                $teamArr = ['team', 'team-roster'];
            ?>
                <li class="bold menu-item <?php echo (in_array($this->uri->segment(1), $teamArr) ? 'active ' : ''); ?>">
                    <a class="collapsible-header waves-effect waves-cyan " href="javascript:void(0)">
                        <i class="flaticon-team-1"></i>
                        <span class="menu-title">Team </span>
                    </a>
                    <div class="collapsible-body">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'team')?'active':''; ?>" href="<?php echo site_url(); ?>/team">
                                    <i class="material-icons">radio_button_unchecked</i><span>Add User</span>
                                </a>
                            </li>
                            <li>
                                <a class="collapsible-body <?= ($this->uri->segment(1) == 'team-roster')?'active':''; ?>" href="<?php echo site_url(); ?>/team-roster">
                                    <i class="material-icons">radio_button_unchecked</i><span>Roster Upload</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'alert')?'active':''; ?>" href="<?php echo site_url(); ?>/alert">
                        <i class="flaticon-invoice"></i>
                        <span class="menu-title">Alert Management</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'invoice')?'active':''; ?>" href="<?php echo site_url(); ?>/invoice">
                        <i class="flaticon-invoice"></i>
                        <span class="menu-title">Invoice</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'Subscription')?'active':''; ?>" href="<?php echo site_url(); ?>/Subscription">
                        <i class="flaticon-invoice"></i>
                        <span class="menu-title">Subscription Details</span>
                    </a>
                </li>
                <?php
            }
        }
        //***************************************************End bpo industry type********************************************************
        
        
        
        
        //***************************************************Start non-bpo industry type*****************************************************
        else {
            ?>
            <?php
            if ($this->emp_group != "admin") {
                ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'dashboard')?'active':''; ?>" href="<?php echo site_url(); ?>/dashboard">
                        <i class="flaticon-dashboard-1"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <?php
            }
            ?>

            <?php if ($this->emp_group == "admin") { ?>
                
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'user-management')?'active':''; ?>" href="<?php echo site_url(); ?>/user-management">
                        <i class="flaticon-group"></i>
                        <span class="menu-title">User Management</span>
                    </a>
                </li>  
                <li class="bold menu-item">                        
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'template-list')?'active':''; ?>" href="<?php echo site_url(); ?>/template-list">
                        <i class="flaticon-notepad"></i>
                        <span class="menu-title">Form</span>
                    </a>
                </li>

                <li class="bold menu-item">                        
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'kpi')?'active':''; ?>" href="<?php echo site_url(); ?>/kpi">
                        <i class="flaticon-notepad"></i>
                        <span class="menu-title">KPI</span>
                    </a>
                </li>
                <li class="bold menu-item">

                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'alert-management')?'active':''; ?>" href="<?php echo site_url(); ?>/alert-management">
                        <i class="flaticon-tick"></i>
                        <span class="menu-title">Alert Management</span>
                    </a>
                </li>  
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'Subscription')?'active':''; ?>" href="<?php echo site_url(); ?>/Subscription">
                        <i class="flaticon-invoice"></i>
                        <span class="menu-title">Subscription Details</span>
                    </a>
                </li>

                <?php
            }
            ?>

            <?php
            if ($this->emp_group == "reviewer") {
                $repArr = ['my-history', 'audit-details', 'audit-summary', 'attribute_report'];
                ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'action-items')?'active':''; ?>" href="<?php echo site_url(); ?>/action-items">
                        <i class="flaticon-notepad-1"></i>
                        <span class="menu-title">Action Items</span>
                    </a>
                </li>

                <li class="bold menu-item <?php echo (in_array($this->uri->segment(1), $repArr) ? 'active ' : 'open'); ?>">
                    <a class="collapsible-header waves-effect waves-cyan " href="javascript:void(0)">
                        <i class="flaticon-statistics-1"></i>
                        <span class="menu-title">Report</span>
                    </a>
                    <div class="collapsible-body" style="<?php echo (in_array($this->uri->segment(1), $repArr) ? 'display: block;' : 'display: none;'); ?>">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'audit-summary')?'active':''; ?>" href="<?php echo site_url(); ?>/audit-summary">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Audit Summary Report</span>
                                </a>
                            </li>
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'audit-details')?'active':''; ?>" href="<?php echo site_url(); ?>/audit-details">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Opportunity Report</span>
                                </a>
                            </li>
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'attribute_report')?'active':''; ?>" href="<?php echo site_url(); ?>/attribute_report">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Attribute Trending Report</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>                
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'dump')?'active':''; ?>" href="<?php echo site_url(); ?>/dump">
                        <i class="flaticon-download-2"></i>
                        <span class="menu-title">Data Download</span>
                    </a>
                </li>                    

                <?php
            }
            ?>  

            <?php
            if ($this->emp_group == "auditor") {
                ?>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'bucket')?'active':''; ?>" href="<?php echo site_url(); ?>/bucket">
                        <i class="material-icons">settings_input_svideo</i>
                        <span class="menu-title">My Audits</span>
                    </a>
                </li>
                <li class="bold menu-item">
                    <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'my-history')?'active':''; ?>" href="<?php echo site_url(); ?>/my-history">
                        <i class="flaticon-search"></i>
                        <span class="menu-title">Audit Summary</span>
                    </a>
                </li>

                <?php
            }
            ?>
            <?php if ($this->emp_group == "manager") {
                $repArr = ['my-history', 'audit-details', 'audit-summary', 'attribute_report'];
            ?>
                <li class="bold menu-item <?php echo (in_array($this->uri->segment(1), $repArr) ? 'active ' : 'open'); ?>">
                    <a class="collapsible-header waves-effect waves-cyan " href="javascript:void(0)">
                        <i class="flaticon-statistics-1"></i>
                        <span class="menu-title">Report</span>
                    </a>
                    <div class="collapsible-body" style="<?php echo (in_array($this->uri->segment(1), $repArr) ? 'display: block;' : 'display: none;'); ?>">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'audit-summary')?'active':''; ?>" href="<?php echo site_url(); ?>/audit-summary">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Audit Summary Report</span>
                                </a>
                            </li>
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'audit-details')?'active':''; ?>" href="<?php echo site_url(); ?>/audit-details">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Opportunity Report</span>
                                </a>
                            </li>
                            <li class="bold menu-item">
                                <a class="waves-effect waves-cyan <?= ($this->uri->segment(1) == 'attribute_report')?'active':''; ?>" href="<?php echo site_url(); ?>/attribute_report">
                                    <i class="material-icons">radio_button_unchecked</i>
                                    <span class="menu-title">Attribute Trending Report</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>  
                <?php
            }
            ?>
            <?php
        }
        ?>
        <!-- ***************************************************End non-bpo industry type***************************************************** -->
        <!-- End Team -->

    </ul>
    
    <input type="hidden" id="csrf_token" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>">
    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
    <div class="navigation-background"></div>
    <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="javascript:void(0)" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>


