<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo getConfig('site_name');?> | Admin Login</title>
<!-- Meta tag Keywords -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> 
 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Meta tag Keywords -->
<!-- css files -->
<link href="<?php echo base_url(); ?>backend_asset/font-awesome/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>backend_asset/css/login.css" type="text/css" media="all" /> <!-- Style-CSS --> 
<!-- //css files -->
<!-- web-fonts -->
<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700,800" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<!-- //web-fonts -->
</head>
<body>
		<!--header-->
		<div class="header-w3l">
			<h1><?php echo getConfig('site_name'); ?></h1>
		</div>
		<!--//header-->
		<!--main-->
		<div class="main-content-agile">
			<div class="sub-main-w3">	
				<h2>Sign In</h2>
				<form action="#" method="post">
					<div class=""><img width="150" src="<?php echo base_url().  getConfig('site_logo'); ?>" class="img-responsive" alt="" /></div>
					<h6>Or use your email</h6>
					<div class="icon1">
						<input placeholder="Email" name="mail" type="email" required="">
					</div>
					
					<div class="icon2">
						<input  placeholder="Password" name="Password" type="password" required="">
					</div>
					<label class="anim">
					<input type="checkbox" class="checkbox">
						<span>Remember Me</span> 
						<a href="#">Forgot Password</a>
					</label> 
						<div class="clear"></div>
					<input type="submit" value="Sign in">
				</form>
			</div>
		</div>
		<!--//main-->
		<!--footer-->
		<div class="footer">
			<p>&copy; 2017 <?php echo getConfig('site_name'); ?></p>
		</div>
		<!--//footer-->
<!-- js -->
<script type="text/javascript" src="<?php echo base_url(); ?>backend_asset/js/jquery-2.1.1.js"></script>
<!-- //js -->
</body>
</html>