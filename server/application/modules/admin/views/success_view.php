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
             <?php $success = $this->session->flashdata('success');
             if(!empty($success) && isset($success)){?>
            <div class="alert alert-success">
                <span style="text-align: center;color:#FFFFFF"><?php echo $success; ?></span>
            </div>
            <?php }?>
        </div>
    </body>
</html>
