<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Registration :: InsightsPRO</title>
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
            <noscript><link rel="stylesheet" href="[fallback css]" /></noscript>
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
        $attributes = array('id' => 'registration_form', 'class' => 'register form-card user-register z-depth-4','method'=>'POST');
        echo form_open(site_url().'/user/register', $attributes);
        ?>
            <div class="form-card-header center">
                <h2 class="form-title">Register</h2>
                <p class="form-sub-title m-0">Join to our community now !</p>
                <?php if($this->session->flashdata('info')) { ?>
                    <span class="form_message error">
                        <?php echo $this->session->flashdata('info'); ?>
                    </span>
                <?php } 
                    if($this->session->flashdata('success')) { ?>
                    <span class="form_message">
                        <?php echo $this->session->flashdata('success'); ?>
                    </span>
                <?php } ?>
            </div>
            <div class="form-card-content">
                <div class="input-field">
                    <!--[if lt IE 9]><label for="fname_field">First Name</label><![endif]-->
                    <i class="material-icons prefix">person_outline</i>
                    <input name="client_first_name" id="fname_field" type="text" value="<?=set_value('client_first_name')?>">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="fname_field">First Name</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_first_name')) ?  form_error('client_first_name'):'' );?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="lname_field">Last Name</label><![endif]-->
                    <i class="material-icons prefix">person_outline</i>
                    <input name="client_last_name" id="lname_field" type="text" value="<?=set_value('client_last_name')?>">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="lname_field">Last Name</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_last_name')) ?  form_error('client_last_name'):'' );?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="uname_field">Company</label><![endif]-->
                    <i class="material-icons prefix">language</i>
                    <input name="client_company" id="uname_field" type="text" value="<?=set_value('client_company')?>">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="uname_field">Company</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_company')) ?  form_error('client_company'):'' );?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="email_field">Email</label><![endif]-->
                    <i class="material-icons prefix">mail_outline</i>
                    <input name="client_email" id="email_field" type="email" value="<?=set_value('client_email')?>">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="email_field">Email</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_email')) ?  form_error('client_email'):'' );?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="industry_type">Industry Types/Function</label><![endif]-->
                    <i class="material-icons prefix">business</i>
                    <select id="industry_type" name="industry_type" required>
                        <option <?php echo (set_value('industry_type') === 'BPO' ? 'selected': '' );?> value="BPO" >BPO</option>
                        <option <?php echo (set_value('industry_type') === 'HR/Admin' ? 'selected': '' );?> value="HR/Admin">HR/Admin</option>
                        <option <?php echo (set_value('industry_type') === 'IT' ? 'selected': '' );?> value="IT">IT</option>
                        <option <?php echo (set_value('industry_type') === 'Retail' ? 'selected': '' );?> value="Retail" >Retail</option>
                        <option <?php echo (set_value('industry_type') === 'Facility Management' ? 'selected': '' );?> value="Facility Management" >Facility Management</option>
                        <option <?php echo (set_value('industry_type') === 'Healthcare services' ? 'selected': '' );?> value="Healthcare services" > Healthcare services</option>
                        <option <?php echo (set_value('industry_type') === 'Hospitality' ? 'selected': '' );?> value="Hospitality" >Hospitality (hotels) & Restaurants</option>
                        <option <?php echo (set_value('industry_type') === 'others' ? 'selected': '' );?> value="others" >Others</option>
                    </select>
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="industry_type">Industry Types/Function</label><!--<![endif]-->
                    <span class="field_error agent_name">
                        <?php  echo (!empty($this->session->flashdata('industry_type'))?$this->session->flashdata('industry_type'):''); ?>
                    </span>
                </div>
            </div>
            <div class="form-card-footer center">
                <button class="btn waves-effect waves-light border-round btn-gradient" type="submit">Register</button>
            </div>
        <?php echo form_close();?>
        <!--EXTERNAL JAVASCRIPT LINKS-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('select').formSelect();
            });

            jQuery(function() {
                $("form").submit(function() {
                    // submit more than once return false
                    $(this).submit(function() {
                        return false;
                    });
                    // submit once return true
                    return true;
                });
            });
            
            jQuery.validator.addMethod("lettersonly", function(value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional( element ) || /^[a-zA-Z]+$/.test( value );
            }, 'Please enter only letters.');

            $("#registration_form").validate({
                rules: {
                    client_first_name: {
                        required: true,
                        maxlength: 30,
                        lettersonly: true
                    },
                    client_last_name: {
                        required: true,
                        maxlength: 30, 
                        lettersonly: true
                    },
                    client_company: {
                        required: true,
                        maxlength: 30
                    },
                    client_email: {
                        required: true,
                        email: true
                    },
                    industry_type: {
                        required: true
                    }
                },
                //For custom messages
                messages: {
                    client_first_name:{
                        required: "<?php echo $this->lang->line('field_required'); ?>",
                        maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>",
                        lettersonly: "<?php echo $this->lang->line('field_lettersonly'); ?>"
                    },
                    client_last_name:{
                        required: "<?php echo $this->lang->line('field_required'); ?>",
                        maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>",
                        lettersonly: "<?php echo $this->lang->line('field_lettersonly'); ?>"
                    },
                    client_company:{
                        required: "<?php echo $this->lang->line('field_required'); ?>",
                        maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>"
                    },
                    client_email:{
                        required: "<?php echo $this->lang->line('field_required'); ?>",
                        email: "<?php echo $this->lang->line('valid_email'); ?>"
                    },
                    industry_type:{
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
        </script>
    </body>
</html>
