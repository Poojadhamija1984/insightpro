<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Reset Password :: InsightsPRO</title>
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
        $attributes = array('id' => 'reset_form','class' => 'reset form-card user-forgot z-depth-4','method'=>'POST');
        echo form_open(site_url().'/resetPassword', $attributes);
        ?>
            <div class="form-card-header center">
                <h2 class="form-title">Reset Password</h2>
                <?php if($this->session->flashdata('message')){ ?>
                    <span class="form_message"><?php echo $this->session->flashdata('message'); ?></span>
                <?php } ?>
            </div>
            <div class="form-card-content">
                <div class="input-field">
                    <!--[if lt IE 9]><label for="password_field">Password</label><![endif]-->
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="password_field" type="password" name="client_password">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="password_field">Password</label><!--<![endif]-->
                    <span class="field_error"><?php if($this->session->flashdata('client_password')){ echo $this->session->flashdata('client_password'); } ;?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="newpassword_field">Confirm Password</label><![endif]-->
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="newpassword_field" type="password" name="confirm_password">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="newpassword_field">Confirm Password</label><!--<![endif]-->
                    <span class="field_error"><?php if($this->session->flashdata('confirm_password')){ echo $this->session->flashdata('confirm_password'); } ;?></span>
                </div>
            </div>
            <div class="form-card-footer">
                <button class="btn waves-effect waves-light border-round btn-gradient">Submit</button>
                <div class="d-flex align-items-center justify-content-center">
                    <a href="<?php echo site_url().'/login'; ?>">Login</a>
                    <a href="<?php echo site_url().'/register'; ?>">Register</a>
                </div>
            </div>
        <?php echo form_close();?>
        <!--EXTERNAL JAVASCRIPT LINKS-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#reset_form").validate({
                    rules: {
                        client_password: {
                            required: true,
                            minlength: 7
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password_field"
                        },
                    },
                    //For custom messages
                    messages: {
                        client_password:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            minlength: "<?php echo $this->lang->line('field_minlength2'); ?>"
                        },
                        confirm_password:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            equalTo: "<?php echo $this->lang->line('confirm_pwd'); ?>"
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
            })
        </script>
    </body>
</html>