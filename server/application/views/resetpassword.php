<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">


        <meta name="description" content="<?php echo getConfig('site_meta_description'); ?>">
        <meta name="keywords" content="<?php echo getConfig('site_meta_title'); ?>">
        <title><?php echo getConfig('site_name'); ?> Forgot Password</title>
        
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        
        <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet">
    </head>
    <body class="login-content">
        <!-- Login -->

        <div class="lc-block toggled" id="l-login">
            <form id="login_form" class="hidden">
                <div class="lcb-float"><img src="<?php echo base_url().getConfig('site_logo');?>"></div>
                <strong style="font-size: 15px;" class="forgot_msg"></strong>
                
            </form>
            <form id="change-passowrd">
                <div class="lcb-float"><img src="<?php echo base_url().getConfig('site_logo');?>"></div>
                    <strong>Forgot Password</strong>
	            <div class="form-group">
	            	<p class="show_error danger" style="display:none"></p>
	            </div>
	            <input type="hidden" value="<?php echo $this->input->get('token'); ?>" name="user_token">
                <label class="error_form user_token"></label>
	            <div class="form-group">
	                <input type="password" class="form-control input" id="new_password" name="new_password" placeholder="New Password">
                    <label class="error_form new_password"></label>
	            </div>

                <div class="form-group">
                    <input type="password" class="form-control input" id="cnfm_password" name="cnfm_password" placeholder="Confirm Password">
                    <label class="error_form cnfm_password"></label>
                </div>
	            
	            <div class="clearfix"></div>
	            <a href="javascript:void(0)" class="btn btn-block btn-primary btn-float m-t-25 send_btn">Submit</a>
        	</form>
        </div>
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/functions.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/custom/login.js"></script>
    	<script type="text/javascript">
            function get_url()
            {
                var url = "<?php echo base_url(); ?>";
                return url;
            }

            $('document').ready(function(){

              $("body").on('click','.send_btn',function() {
                  var form_data = new FormData($('#change-passowrd')[0]);
                  $.ajax({
                      url  : "<?php echo base_url(); ?>user/do_forgot_password",
                      type : "POST",
                      data : form_data,   
                      dataType : "JSON",   
                      cache: false,
                      contentType: false,
                      processData: false,   
                      beforeSend:function(){
                        $('.send_btn').attr('disabled',true).text('Loading....');
                      },       
                      success: function(resp){
                         $('.error_form').html("");
                         if(resp.type == "validation_err"){
                           var errObj = resp.msg;
                           var keys   = Object.keys(errObj);
                           var count  = keys.length;
                           for (var i = 0; i < count; i++) {
                               $('.'+keys[i]).html(errObj[keys[i]]);
                           };
                        }
                        else if(resp.type == "failed")
                        {
                            alert(resp.msg);
                            return false;
                        }
                        else if(resp.type == "success")
                        {
                            $('#change-passowrd').remove();
                            $('#login_form').removeClass('hidden');
                            $('.forgot_msg').html(resp.msg);
                        }
                        $('.send_btn').attr('disabled',false).text('Submit');
                      },
                      error:function(error)
                      {
                          $('.send_btn').attr('disabled',false).text('Submit');
                      }
                  });
              });        

            });

        </script> 
    </body>
</html>