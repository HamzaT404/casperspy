<?php
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$customer_title       =	$this->db->get_where('settings' , array('type'=>'customer_title'))->row()->description;
	
	$account_type       =	$this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;


	

	?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>
	
	<title><?php echo $page_title;?> | <?php echo $customer_title;?></title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Casper Spy" />
	<meta name="author" content="Hamza" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
	
	<?php include 'includes_top.php';?>
	
</head>
<body class="page-body" >
	<div class="page-container" >
		<?php include $account_type.'/navigation.php';?>	
		<div class="main-content">
		
			<?php include 'header.php';?>

           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				<?php echo $page_title;?>
           </h3>

			<?php include $account_type.'/'.$page_name.'.php';?>

			<?php include 'footer.php';?>

		</div>
		<?php //include 'chat.php';?>
        	
	</div>
    <?php include 'modal.php';?>
    <?php include 'includes_bottom.php';?>

	
    
</body>
</html>