<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="<?php echo getConfig('site_meta_description'); ?>">
        <meta name="keywords" content="<?php echo getConfig('site_meta_title'); ?>">
        <title><?php echo getConfig('site_name'); ?> User Verification</title>
        
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        
        <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet">
    </head>
    <body class="login-content">
        <!-- Login -->

        <div class="lc-block toggled" id="l-login">
            <form id="login_form">
                <div class="lcb-float"><img src="<?php echo base_url().  getConfig('site_logo');?>"></div>
	            <strong style="font-size: 15px;"><?php echo $this->session->flashdata('user_verify'); ?></strong>
	            
        	</form>
        </div>
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/functions.js"></script>
    </body>
</html>