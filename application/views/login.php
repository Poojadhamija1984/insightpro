<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Login :: InsightsPRO</title>
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
        <?php $attributes = array('id' => 'login_form', 'class' => 'login form-card user-login z-depth-4','method'=>'POST');
        echo form_open(site_url().'/user/login', $attributes); ?>
            <div class="form-card-header center">
                <h2 class="form-title">Sign in</h2>
                <?php if($this->session->flashdata('error')) { ?>
                    <span class="form_message error"><?php echo $this->session->flashdata('error'); ?></span>
                <?php
                } 
                if($this->session->flashdata('success')) {
                ?>
                    <span class="form_message"><?php echo $this->session->flashdata('success'); ?></span>
                <?php } ?>
            </div>
            <div class="form-card-content">
                <div class="input-field">
                    <!--[if lt IE 9]><label for="uname_field">Username as Email ID</label><![endif]-->
                    <i class="material-icons prefix">person_outline</i>
                    <input id="uname_field" name="client_email" type="text">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="uname_field">Username as Email ID</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_email')) ?  form_error('client_email'):'' );?></span>
                </div>
                <div class="input-field">
                    <!--[if lt IE 9]><label for="pwd_field">Password</label><![endif]-->
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="pwd_field" name="client_password" type="password">
                    <!--[if (gt IE 8)|!(IE)]><!--><label for="pwd_field">Password</label><!--<![endif]-->
                    <span class="field_error"><?php echo (!empty(form_error('client_password')) ?  form_error('client_password'):'' );?></span>
                </div>
                <!-- <label class="remember-label">
                    <input type="checkbox" />
                    <span>Remember Me</span>
                </label> -->
            </div>
            <div class="form-card-footer center">
                <button class="btn waves-effect waves-light border-round btn-gradient">Login</button>
                <?php
                    $subdomin = explode('//',explode('.',site_url())[0])[1];
                    $check_subdomin = $this->common->getWhereSelectDistinctCount('client',['client_username'],['client_username'=>$subdomin],'client_username');
                    if($check_subdomin == 0){
                        echo "<a href='".site_url()."/register'>Register Now!</a>";
                    }
                    /*$info = parse_url($_SERVER['SERVER_NAME']);
                    $sd = explode('.',$info['path'])[0];
                    if($sd == "insightspro-dev" || $sd == "localhost"){
                        echo "<a href='".site_url()."/register'>Register Now!</a>";
                    }*/
                ?>
                <a class="small_text" href="<?php echo site_url().'/forgot'; ?>">Forgot password?</a>
            </div>
        <?php echo form_close();?>

        <!--EXTERNAL JAVASCRIPT LINKS-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#login_form").validate({
                    rules: {
                        client_email: {
                            required: true,
                            email: true
                        },
                        client_password: {
                            required: true,
                            minlength: 3,
                            maxlength: 30
                        },
                    },
                    //For custom messages
                    messages: {
                        client_email:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            email: "<?php echo $this->lang->line('valid_email'); ?>"
                        },
                        client_password:{
                            required: "<?php echo $this->lang->line('field_required'); ?>",
                            minlength: "<?php echo $this->lang->line('field_minlength'); ?>",
                            maxlength: "<?php echo $this->lang->line('field_maxlength'); ?>"
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
