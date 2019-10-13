<?php if($mobile == '') 
{  
	redirect(base_url(), 'refresh');
}?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	$system_name	=	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title	=	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	$customer_title	=	$this->db->get_where('settings' , array('type'=>'customer_title'))->row()->description;

	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Barkat-e-Khwja Customer Login" />
	<meta name="author" content="Hasim Tanerjawala" />
	
	<title>Verify OTP| <?php echo $customer_title;?></title>
	

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="apple-touch-icon" sizes="57x57" href="sampatti/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="sampatti/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="sampatti/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="sampatti/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="sampatti/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="sampatti/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="sampatti/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="sampatti/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="sampatti/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="sampatti/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="sampatti/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="sampatti/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="sampatti/favicon/favicon-16x16.png">
<link rel="manifest" href="sampatti/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="sampatti/favicon/ms-icon-144x144.png">
	
</head>
<body class="page-body login-page login-form-fall" data-url="http://hasim751.com">


<!-- This is needed when you send requests via Ajax -->
<script type="text/javascript">
var baseurl = '<?php echo base_url();?>';
</script>

<div class="login-container">
	
	<div class="login-header login-caret">
		
		<div class="login-content" style="width:100%;">
			
			<a href="<?php echo base_url();?>" class="logo">
				<img src="assets\logo\logo.png" height="60" alt="" />
			</a>
	
			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>43%</h3>
				<span>logging in...</span>
			</div>
		</div>
		
	</div>
	
	<div class="login-progressbar">
		<div></div>
	</div>
	
	<div class="login-form">
		
		<div class="login-content">
			
			<div class="form-login-error">
				<h3>Invalid login</h3>
				<p>Please enter correct e-mail and password!</p>
			</div>
			
			<form method="post" action="<?php echo base_url().'?login/otp_access'; ?>" role="form">
				
				
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						
						<input type="text" required="" class="form-control"  name="otp" id="otp" placeholder="Enter OTP to Login" autocomplete="off" />
						<input type="hidden" name="mobile" value="<?php echo $mobile;?>">
					</div>
				
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Login
					</button>
					<br>
					<a href="<?php echo base_url().'?login/resend_otp/'.$mobile?>" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Resend OTP
					</a>
				
				
				</div>
				
						
			</form>
			
			
					
				

			<div class="login-bottom-links">
				<a type="button" href="<?php echo base_url();?>"  class="btn btn-red btn-lg icon-left"><font color="white"><i class="entypo-back"></i> <?php echo get_phrase('back');?> </font></a>
				</a>
			</div>
			
		</div>
		
	</div>
	
</div>

<?php include 'toastr.php'; ?>
	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>
	<script src="assets/js/neon-custom.js"></script>


</body>
</html>