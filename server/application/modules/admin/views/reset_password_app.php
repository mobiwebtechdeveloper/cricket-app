<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <title><?php echo getConfig('site_name'); ?> | Reset Password</title>
        <link href="<?php echo base_url(); ?>backend_asset/css/logincss.css" rel="stylesheet" type="text/css" />

    </head>

    <body style="background-image: url('../../<?php echo getConfig('login_background');?>')">
        <div class="app-cross">
            <div class=""><img width="150" src="<?php echo base_url() . getConfig('site_logo'); ?>" class="img-responsive" alt="" /></div>
            <h2><?php echo lang('reset_password_heading'); ?></h2>


            <?php echo form_open('admin/resetPasswordApp/' . $code); ?>
            <div id="infoMessage">
            <?php if(!empty($message) && isset($message)){?>
            <div class="alert alert-danger">
                <span style="text-align: center"><?php echo $message; ?></span>
            </div>
            <?php }?>
             <?php if(!empty($success) && isset($success)){?>
            <div class="alert alert-success">
                <span style="text-align: center"><?php echo $success; ?></span>
            </div>
            <?php }?>
            </div>
            <p>
                <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label> <br />
                <?php echo form_input($new_password); ?>
            </p>

            <p>
                <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
                <?php echo form_input($new_password_confirm); ?>
            </p>

            <?php echo form_input($user_id); ?>
            <?php echo form_hidden($csrf); ?>

            <p><?php echo form_submit('submit', lang('reset_password_submit_btn')); ?></p>

            <?php echo form_close(); ?>


        </div>


    </body>
</html>
