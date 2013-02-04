<?php
	//error_reporting(E_ALL);
	if(!isset($_SESSION)){session_start();}


/****************************************************************************
* Includes
*****************************************************************************/
	
	include '../define.php';
	include "functions.php";
	include NSS_ABSPATH."nss-core/NeosmartStream.php";
	
/****************************************************************************
* Config
*****************************************************************************/
	
	$nss = new NeosmartStream();
	
	@include NSS_CONFIG_CONFIG;
	@include NSS_CONFIG_CHANNELS;
	@include NSS_CONFIG_TRANSLATE;
	@include NSS_CONFIG_LICENSE;
	@include NSS_CONFIG_BASE_URL;
	@include NSS_CONFIG_PASSWORD;
	
/****************************************************************************
* Login/Logout
*****************************************************************************/
	
	if(array_key_exists('logout',$_REQUEST)){
		$_SESSION['nss_admin_password'] = false;
	}
	
	if(!is_logged_in($nss)){
		header('Location: '.getNssRoot().'?error=1');
		die;
	}
	cl($nss);


/****************************************************************************
* Global Vars
*****************************************************************************/
	
	
	//Password
	$admin_password = $nss->get('admin_password');
	
	//Abspath
	$protocol = array_key_exists('HTTPS',$_SERVER) ? "https://" : "http://";
	$absolute_path = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/nss-admin/')+1);
	
	//Config
	$nss_root = $nss->get('nss_root');
	$cache_time = $nss->get('cache_time');
	$debug_mode = $nss->get('debug_mode');
	$date_time_format = $nss->get('date_time_format');
	$theme = $nss->get('theme');
	$error_no_data = $nss->get('error_no_data');
	$channel_count = $nss->get('channel_count');
	
	//Uupdate available?
	$update_available = is_update_available($nss);
	
	//License
	$license_name = $nss->get('license_name');
	$license_owner = $nss->get('license_owner');
	$license_key = $nss->get('license_key');
	$license_sites_array = explode(',',$nss->get('license_sites'));
	$license_sites = preg_replace('/,/',',<br>',$nss->get('license_sites'));
	
	$license_code = $nss->get('license_code');
	$license_limit = intval($nss->get('license_limit'));
	$license_status = $nss->get('license_status');
	$current_site = $_SERVER['HTTP_HOST'];
	
	if($license_name=='') $license_name = '<span class="error">Missing license key</span>';
	if($license_status=='') $license_status = '<span class="error">Missing license key</span>';
	if($license_status=='valid'){
		if(strpos($license_sites,$current_site)===false){
			
			if(count($license_sites_array)<$license_limit){
				$license_status = '<span class="error">Activation is missing</span>';
			}else{
				$license_status = '<span class="error">Invalid</span> - You have activated the maximum limit of sites for this license key.<br>Please get a new license key or deactivate a site for this key.<br>You can do this within <a href="'.NSS_WEBSITE_URL.'/log-in/?redirect_to=my-account" target="_blank">Your Account</a>.';
			}
		}
	}

	
/****************************************************************************
* Actions
*****************************************************************************/

	if(array_key_exists('action',$_POST)){
		switch($_POST['action']){
			case 'update_base_url':
				saveBaseURL('../');
			break;
			case 'update_config':
				updateConfig();
			break;
			case 'update_password':
				$passwordError = updatePassword();
			break;
			case 'update_translation':
				updateTranslation();
			break;
			case 'update_channels':
				updateChannels();
			break;
			case 'total_reset':
				$total_reset = totalReset();
			break;
		}
	}
	
	if(array_key_exists('delete',$_GET) && $_GET['delete']=='key'){
		removeLicenseKey();
	}

/****************************************************************************
* Template > Header
*****************************************************************************/
	
?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>neosmart STREAM Admin</title>
	<link href='reset.css' type='text/css' rel='stylesheet' />
	<link href='style.css' type='text/css' rel='stylesheet' />
	<script type='text/javascript' src='../nss-includes/jquery.js'></script>
	<script type='text/javascript' src='jquery.neosmart.stream.admin.js'></script>
	<script type="text/javascript">
		$(function(){
			$('#nss-admin').neosmartStreamAdmin();
		});
	</script>
</head>
<body>
	<div id="nss-admin">
		<div class="nss-admin-header">
			<div class="center">
				
				<h1><a href="<?php echo NSS_WEBSITE_URL; ?>" target="_blank"><img src="neosmart-stream-logo.png" alt="neosmart STREAM"></a></h1>			
				<?php if(!isset($hide_menu)){ ?>
				<div class="nss-admin-menu">
					<a href="index.php" class="button">Overview</a>
					<a href="config.php" class="button">Configuration</a>
					<a href="channels.php" class="button">Channels</a>
					<a href="license.php" class="button">License</a>
					<a href="password.php" class="button">Password</a>
					<?php if(!is_default_password($admin_password)){ ?><a class="nss-admin-logout button" href="index.php?logout=1">Logout</a><?php } ?>
				</div>
				<?php } ?>
				
			</div><!--/.center-->
		</div>
		
		<div class="center">
			<?php if(is_default_password($admin_password) || ($channel_count===0 && !isset($no_channel_warning))){ ?>
				<h2>Warning</h2>
			<?php } ?>
			<?php if(is_default_password($admin_password)){ ?>
				<div class="nss-admin-container warning">
					<div class="row"><b><a href="password.php">Set admin password</a></b> as soon as possible!</div>
				</div>
			<?php } ?>
			<?php if($channel_count===0 && !isset($no_channel_warning)){ ?>
			<div class="nss-admin-container warning">
				<div class="row">There is no data to display. <a href="channels.php"><b>Add a channel</b></a>.</div>
			</div>
			<?php } ?>