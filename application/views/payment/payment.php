<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../assets/css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../assets/css/owl.carousel.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../assets/css/owl.theme.default.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="../assets/css/theme.css" media="screen,projection"/>
        <title>InsightsPRO</title>
    </head>
    <body>
        <div class="page-wrapper">
            <!-- MAIN SECTION START -->
            <div class="main">
                <!-- PACKAGES SECTION START -->
                <div class="packages-section py-24">
                    <div class="container">
                        <h2 class="package-heading">Only pay for what you use</h2>
                        <div class="packages-table">
                            <div class="packages-table--left">
                                <div class="package-card d-flex flex-column">
                                    <div class="card_header gradient-45deg-purple-deep-orange">
                                        <span class="package_amount">Compare All Packages</span>
                                    </div>
                                    <div class="card_content">
                                        <ul>
                                            <!-- <li>Licences</li> -->
                                            <li class="multi_col">Agents</li>
                                            <li>Media size limit (monthly)</li>
                                            <li>Calibration</li>
                                            <li>Dispute/Escalation</li>
                                            <li>Online Chat Support/ Help</li>
                                            <li>Priority Email Support/ Help ( within 2-8 hours)</li>
                                            <li>Email Support/ Help (within 24 hours) </li>
                                            <li>Real Time Performance Alerts</li>
                                            <li>Suite of Reports</li>
                                            <li>Customizable Evaluation Forms</li>
                                            <li>PCI and Recording Encryption</li>
                                            <li>Centralized administration and reporting</li>
                                            <li>Agent acknowledgement through e-signature</li>
                                            <li>Media Embedding (Audio Recording, Chat Transcript & Email)</li>
                                            <li>Real Time Reporting</li>
                                            <li>Regional Hosting</li>
                                            <li>Custom reports (charged as per development effort cost)</li>
                                            <li class="multi_col">Development Effort Cost (Monthly)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="packages-table--right">
                                <div class="owl-carousel owl-theme">
                                    <div class="item">
                                        <div class="package-card d-flex flex-column <?php if($cinfo->client_plan_type == 1){ echo 'featured'; } ?>">
                                            <div class="card_header gradient-45deg-purple-deep-orange">
                                                <span class="package_label">Starter Pack</span>
                                                <span class="package_amount">Free</span>
                                                <span class="package_licences">Upto 3 Users</span>
                                            </div>
                                            <div class="card_content">
                                                <ul>
                                                    <li class="multi_col"><span>50 agents at no cost</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span>2 Evaluation Forms</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li class="multi_col"><span>None</span></li>
                                                </ul>
                                            </div>
                                            <!-- <div class="card_footer">
                                                <button class="btn waves-effect waves-light">Get package</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="package-card d-flex flex-column <?php if($cinfo->client_plan_type == 2){ echo 'featured'; } ?>">
                                            <div class="card_header gradient-45deg-purple-deep-orange">
                                                <span class="package_label">Small Team</span>
                                                <div class="package_amount"><sup>$</sup><span><?php echo $pinfo[1]['sd_price'];?></span><sub>/mo</sub></div>
                                                <span class="package_licences">Upto 3 Users</span>
                                            </div>
                                            <div class="card_content">
                                                <ul>
                                                    <li class="multi_col"><span>50 agents at no cost</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span>2 Evaluation Forms</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li class="multi_col"><span>None</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="package-card d-flex flex-column <?php if($cinfo->client_plan_type == 3){ echo 'featured'; } ?>">
                                            <div class="card_header gradient-45deg-purple-deep-orange">
                                                <span class="package_label">Large Team</span>
                                                <div class="package_amount"><sup>$</sup><span><?php echo $pinfo[2]['sd_price'];?></span><sub>/mo</sub></div>
                                                <span class="package_licences">Upto 3 Users</span>
                                            </div>
                                            <div class="card_content">
                                                <ul>
                                                    <li class="multi_col"><span>50 agents at no cost</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span>2 Evaluation Forms</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li class="multi_col"><span>None</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="package-card d-flex flex-column <?php if($cinfo->client_plan_type == 4){ echo 'featured'; } ?>">
                                            <div class="card_header gradient-45deg-purple-deep-orange">
                                                <span class="package_label">Enterprise</span>
                                                <div class="package_amount"><sup>$</sup><span><?php echo $pinfo[3]['sd_price'];?></span><sub>/mo</sub></div>
                                                <span class="package_licences">Upto 3 Users</span>
                                            </div>
                                            <div class="card_content">
                                                <ul>
                                                    <li class="multi_col"><span>50 agents at no cost</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span>2 Evaluation Forms</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons clear">clear</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li><span class="material-icons checked">check</span></li>
                                                    <li class="multi_col"><span>None</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="package_btns mt-24 center">
                            <button class="back_btn btn waves-effect waves-light" onclick="window.history.back();">Back</button>
                            <?php 
	                            if($cinfo->client_plan_type == 1){
	                            	$price = $pinfo[0]['sd_price'];;
	                            }
	                            if($cinfo->client_plan_type == 2){
	                            	$price = $pinfo[1]['sd_price'];;
	                            }
	                            if($cinfo->client_plan_type == 3){
	                            	$price = $pinfo[2]['sd_price'];;
	                            }
	                            if($cinfo->client_plan_type == 4){
	                            	$price = $pinfo[3]['sd_price'];;
	                            }
                            ?>
                            <a href="<?php echo site_url('paymet/'.$price.'/'.$cinfo->client_id); ?>">
                            <button class="pay_btn btn cyan waves-effect waves-light ml-24"><span>Pay</span> <i class="material-icons right">send</i></button>
                    			
                			</a>
                        </div>
                    </div>
                </div>
                <!-- PACKAGES SECTION END -->
            </div>
            <!-- MAIN SECTION END -->
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="../assets/js/custom.js"></script>
        <script>
        $(document).ready(function() {
            $('.packages-table .owl-carousel').owlCarousel({
            loop: false,
            margin: 0,
            responsiveClass: true,
            responsive: {
                0: {
                items: 1,
                nav: true
                },
                768: {
                items: 2,
                nav: true
                },
                1280: {
                items: 4
                }
            }
            })
        })
        </script>
    </body>
</html>