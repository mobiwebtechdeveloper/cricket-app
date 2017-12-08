<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>backend_asset/images/favicon.ico"/>
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>backend_asset/images/favicon.ico"/>
        <title><?php echo getConfig('site_name');?> | Admin Login</title>
        <link href="<?php echo base_url(); ?>backend_asset/css/logincss.css" rel="stylesheet" type="text/css" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
        
    </head>
    <body style="background-image: url('../<?php echo getConfig('login_background');?>')">
        <div class="app-cross">
            <div class=""><img width="150" src="<?php echo base_url().  getConfig('site_logo'); ?>" class="img-responsive" alt="" /></div>
            <h2>SIGN IN</h2>

            <form  class="form-horizontal m-t-20" action="<?php echo site_url('admin/login') ?>" method="post">
                <?php if (isset($message) && $message != "") { ?>
                    <div class="alert alert-danger">
                        <span style="text-align: center"><?php echo $message; ?></span>
                    </div>
                <?php } ?>
                       <?php if (isset($success) && $success != "") { ?>
                    <div class="alert alert-success">
                        <span style="text-align: center"><?php echo $success; ?></span>
                    </div>
                <?php } ?>
                <div class="form-group ">
                    <div class="col-xs-12">

                        <?php echo form_input($identity); ?>                 
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <?php echo form_input($password); ?>
                    </div>
                </div></br>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>

                            <label for="checkbox-signup" style="color:#555555">
                                Remember me

                            </label>

                        </div>
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    </div>
                </div> 
                <?php  if(strtolower(getConfig('google_captcha')) == 'on'){?>
                 <div class="form-group">
                    <div class="col-xs-12">
                       <div class="g-recaptcha" data-sitekey="<?php echo getConfig('data_sitekey'); ?>"></div>
                       <?php //echo form_error('g-recaptcha-response');?>
                    </div>
                </div>
                <?php }?>
                <div class="submit"><input type="submit" value="Sign in" ></div>
                <div class="clear"></div>
                <h3> <a href="forgot_password" class="text-info">Forgot Password?</a></h3>
            </form>

        </div>


    </body>
</html>