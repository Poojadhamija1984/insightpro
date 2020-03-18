<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Complete Registration :: InsightsPRO</title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/mattsenkumar-insightspro-32x32.png" sizes="32x32">
        <link rel="icon" href="<?php echo base_url(); ?>assets/images/mattsenkumar-insightspro-192x192.png" sizes="192x192">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/mattsenkumar-insightspro-180x180.png">
        <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/images/mattsenkumar-insightspro-270x270.png">
        <!--GOOGLE FONTS & ICONS LINKS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700">
        <!--EXTERNAL JS FILES-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <!--[if (gte IE 6)&(lte IE 8)]>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/selectivizr-min.js"></script>
        <![endif]-->
        <!--[if lt IE 9]>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <!--EXTERNAL CSS FILES-->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize.min.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie-onlyscreen.css" />
        <!--[if IE 9]>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie-9.css" />
        <![endif]-->
        <!--[if lt IE 9]>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie-lt9.css" />
        <![endif]-->
    </head>
    <body class="body_bg custom-scrollbar">
        <?php
            $attributes = array('id' => 'reg_step2_form', 'class' => 'form-card user-complete-register z-depth-4','method'=>'POST');
            echo form_open(site_url().'/user/profile', $attributes); ?>  
            <?php
            if(!empty($client_data)){
                $client_status = $client_data[0]->client_status;
                $client_username = $client_data[0]->client_username;
                $client_phone_no = $client_data[0]->client_phone_no;
                $client_location = $client_data[0]->client_location;
                $industry_type   = $client_data[0]->industry_type;
                $client_plan_type = $client_data[0]->client_plan_type;
            } 
            else{
                $client_status      =   '';
                $client_username    =   '';
                $client_phone_no    =   '';
                $client_location    =   '';
                $industry_type      =   '';
                $client_plan_type   =   '';
            } ?>
            <div class="form-card-header center">
            <?php if($this->session->flashdata('message')){ ?>
                <span class="form_message">
                    <?php echo $this->session->flashdata('message'); ?>
                </span>
            <?php } ?>
            <?php if(!empty($client_data) && $client_data[0]->client_status == 0){?>
                <h2 class="form-title center green-text text-darken-3">Thankyou for Email Verification</h2>
            <?php } ?>
                <p class="form-sub-title center">Please complete your Profile</p>
            </div>
            <div class="form-card-content">
                <div class="row">
                    <div class="input-field col m6">
                        <i class="material-icons prefix">person_outline</i>
                        <input id="fname_field" type="text" value="<?php if($this->session->userdata('client_first_name')){echo $this->session->userdata('client_first_name');}?>" readonly>
                        <label for="fname_field">First Name</label>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">person_outline</i>
                        <input id="lname_field" type="text" value="<?php if($this->session->userdata('client_last_name')){echo $this->session->userdata('client_last_name');}?>" readonly>
                        <label for="lname_field">Last Name</label>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">language</i>
                        <input id="comp_field" type="text" value="<?php if($this->session->userdata('client_company')){echo $this->session->userdata('client_company');}?>" readonly>
                        <label for="comp_field">Company</label>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">mail_outline</i>
                        <input id="email_field" type="email" value="<?php if($this->session->userdata('client_email')){echo $this->session->userdata('client_email');}?>" readonly>
                        <label for="email_field">Email</label>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">person_outline</i>
                        <input id="uname_field" name="client_username" type="text" value="<?php echo set_value('client_username');?>" placeholder="">
                        <!-- <label for="uname_field">Account Name <sup>(Req. to create URL)</sup></label> -->
                        <label for="uname_field">Account Name <span class="tooltip_custom"><span class="tooltip_text"><strong>abc</strong>.URL</span></span></label>
                        <span class="field_error agent_name domain_error">
                            <?php  echo (!empty($this->session->flashdata('domain'))?$this->session->flashdata('domain'):''); ?>
                        </span>
                        <span class="field_error suggestion"></span>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">lock_outline</i>
                        <input id="pwd_field" name="client_password" type="password" autocomplete="new-password ">
                        <label for="pwd_field">Password</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('password'))?$this->session->flashdata('password'):''); ?>
                        </span>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">lock_outline</i>
                        <input id="cpwd_field" name="confirm_password" type="password" autocomplete="new-password" >
                        <label for="cpwd_field">Confirm Password</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('confirm_password'))?$this->session->flashdata('confirm_password'):''); ?>
                        </span>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">phone</i>
                        <input id="contact_field" name="client_phone_no" type="text" value="<?php echo (!empty($client_phone_no)?$client_phone_no:set_value('client_phone_no'));?>" maxlength="10">
                        <label for="contact_field">Contact</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('client_phone_no'))?$this->session->flashdata('client_phone_no'):''); ?>
                        </span>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">place</i>
                        <input id="location_field" name="client_location" type="text" value="<?php echo (!empty($client_location)?$client_location:set_value('client_location'));?>">
                        <label for="location_field">Location</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('location'))?$this->session->flashdata('location'):''); ?>
                        </span>
                    </div>
                    <div class="input-field col m6">
                        <i class="material-icons prefix">business</i>
                        <input type="text" id="industry_type" name="industry_type" value="<?php echo (!empty($industry_type)?$industry_type:set_value('industry_type'));?>" readonly>
                        <label for="industry_type">Industry Types/Function</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('industry_type'))?$this->session->flashdata('industry_type'):''); ?>
                        </span>
                    </div>
                    <div class="input-field col m6 ml-0">
                        <i class="material-icons prefix">queue</i>
                        <select id="plan_field" name="client_plan" >
                            <option value="" disabled >Select Plan</option>
                            <?php 
                                foreach ($plan as $key => $value) {
                            ?>
                                    <option value="<?php echo $value['sd_id'];?>" <?php if($value['sd_id'] == $client_plan_type) echo "selected"; ?>><?php echo $value['sd_name'];?></option>
                            <?php
                                
                            }
                            ?>
                        </select>
                        <label for="plan_field">Choose Plan</label>
                        <span class="field_error agent_name">
                            <?php  echo (!empty($this->session->flashdata('client_plan'))?$this->session->flashdata('client_plan'):''); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-card-footer center">
                <button type="submit" class="btn waves-effect waves-light border-round btn-gradient">Submit</button>
            </div>
        <?php echo form_close();?>
        <!--JavaScript at end of body for optimized loading-->
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function(){
                $('select').formSelect();

                jQuery.validator.addMethod("alphanum", function(value, element) {
                    // allow any non-whitespace characters as the host part
                    return this.optional( element ) || /^[a-zA-Z0-9]+$/.test( value );
                }, 'Please enter only letters.');
                $("#reg_step2_form").validate({
                    rules: {
                        client_username: {
                            required: true,
                            minlength: 4,
                            maxlength: 30,
                            alphanum: true
                        },
                        client_password: {
                            required: true,
                            minlength: 7,
                            maxlength: 30
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#pwd_field"
                        },
                        client_phone_no: {
                            /*required: true,*/
                            digits: true,
                            minlength: 10,
                            maxlength: 10
                        },
                        client_location: {
                            required: true,
                            maxlength: 40
                        },
                        client_plan: {
                            required: true
                        },
                    },
                    //For custom messages
                    messages: {
                        client_username: {
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            minlength: "<?php echo $this->lang->line('field_minlength2'); ?>",
                            maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>",
                            alphanum: "<?php echo $this->lang->line('field_alpha_num'); ?>",
                        },
                        client_password:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            minlength: "<?php echo $this->lang->line('field_minlength2'); ?>",
                            maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>",
                        },
                        confirm_password:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            equalTo: "<?php echo $this->lang->line('confirm_pwd'); ?>"
                        },
                        client_phone_no: {
                            /*required: "<?php echo $this->lang->line('field_required'); ?>",*/
                            digits: "<?php echo $this->lang->line('field_numberonly'); ?>",
                            maxlength: "<?php echo $this->lang->line('field_maxlengthphone'); ?>"
                           
                        },
                        client_location: {
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            maxlength: "<?php echo $this->lang->line('field_maxlength3'); ?>"
                        },
                        client_plan: {
                            required: "<?php echo $this->lang->line('field_required'); ?>"
                        },
                        curl: "Enter your website",
                    },
                    errorElement : 'span',
                    errorPlacement: function(error, element) {
                        var placement = $(element).data('error');
                        if (placement) {
                            $(placement).append(error)
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });

                $('#uname_field').blur(function(){
                    var domain = $(this).val();
                    var url = '<?php echo site_url();?>/valid-domain/'+domain;
                    $.ajax({
                        url:url,
                        type:'get',
                        success:function(res){
                            if(res.length > 0){
                                $('.domain_error').html('That domain already taken. Try another');
                                $('.suggestion').html('Example: '+res).css('color',"green");
                            }
                            else{
                                $('.domain_error').html('That domain already taken. Try another').hide();
                                $('.suggestion').html('Example: '+res).css('color',"green").hide();
                            }
                            return false;
                        }
                    });
                })
            });
        </script>
    </body>
</html>
