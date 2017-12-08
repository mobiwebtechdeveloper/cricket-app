<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <title><?php echo getConfig('site_name'); ?> | Admin Forgot Password</title>
        <link href="<?php echo base_url(); ?>backend_asset/css/logincss.css" rel="stylesheet" type="text/css" />

    </head>

    <body style="background-image: url('../<?php echo getConfig('login_background');?>')">
        <div class="app-cross">
            <div class=""><img width="150" src="<?php echo base_url() . getConfig('site_logo'); ?>" class="img-responsive" alt="" /></div>
            <h2><?php echo lang('forgot_password_heading'); ?></h2>

            

            <?php echo form_open("admin/forgot_password"); ?>
            <div id="infoMessage">
            <?php if(!empty($message)){?>
            <div class="alert alert-danger">
                <span style="text-align: center"><?php echo $message; ?></span>
            </div>
            <?php }?>
            </div>
            <h4><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></h4>
            <br>

            <div class="form-group ">
                 <label for="identity"><?php //echo (($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); ?></label> <br />
                    <div class="col-xs-12">

                      <?php echo form_input($identity); ?>              
                    </div>
            </div>
            <br>
            
            <p><?php echo form_submit('submit', lang('forgot_password_submit_btn')); ?></p>
            <div class="clear"></div>
             <h3> <a href="login" class="text-info">Login</a></h3>
            <?php echo form_close(); ?>
             
        </div>


    </body>
</html>
