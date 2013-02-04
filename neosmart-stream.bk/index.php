<?php
	
	if(!isset($_SESSION)){session_start();}
	
/****************************************************************************
* Includes
*****************************************************************************/

	include 'define.php';
	include NSS_ABSPATH."nss-core/NeosmartStream.php";
	include NSS_ABSPATH."nss-admin/functions.php";
	
	$nss = new NeosmartStream();
	
	$permissionError 	= testFilePermissions();
	$serverError 		= testServerSettings();
	
	@include NSS_CONFIG_BASE_URL;
	@include NSS_CONFIG_LICENSE;
	@include NSS_CONFIG_PASSWORD;
	
	$nss_root = $nss->get('nss_root');
	
	
/****************************************************************************
* Auto-Fill Base URL
*****************************************************************************/
	
	if(!$nss_root && !$permissionError){
		saveBaseURL();
	};

/****************************************************************************
* Globals
*****************************************************************************/
	
	//Password
	$admin_password = $nss->get('admin_password');
	
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
* Action Handler
*****************************************************************************/

	if(array_key_exists('action',$_POST)){
		switch($_POST['action'])
		{
			case 'update_base_url':
				saveBaseURL();
			break;
			case 'add_license_key':
				$status_license_key = addLicenseKey($_POST['license_key']);
			break;
			case 'login':
				$login_error = adminLogin($nss);
			break;
		}
	}
	

/****************************************************************************
* Begin Template
*****************************************************************************/

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>neosmart STREAM Admin</title>
	<link href='nss-admin/reset.css' type='text/css' rel='stylesheet' />
	<link href='nss-admin/style.css' type='text/css' rel='stylesheet' />
	<script type='text/javascript' src='nss-includes/jquery.js'></script>
	<script type='text/javascript' src='nss-admin/jquery.neosmart.stream.admin.js'></script>
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
				<h1><a href="<?php echo NSS_WEBSITE_URL; ?>" target="_blank"><img src="nss-admin/neosmart-stream-logo.png" alt="neosmart STREAM"></a></h1>			
			</div><!--/.center-->
		</div>
		
		<div class="center">
		
		<?php /*************************************************************************************************************/
			if(getNssRoot()===false){?>
				<h2>URL Error</h2>
				<div class="nss-admin-container error">
					<div class="row">All files of neosmart STREAM must be within a folder <b>neosmart-stream</b></div>
					<div class="todo">Rename folder <b><?php echo getLastFolder(); ?></b> to <b>neosmart-stream</b></div>
				</div>
	
		<?php } elseif($serverError){ /***********************************************/ ?>
				<h2>Server error</h2>
				<div class="nss-admin-container error">
					<div class="row"><?php echo $serverError[0]; ?></div>
					<div class="todo"><?php echo $serverError[1]; ?></div>
				</div>
				
		<?php } elseif($permissionError){ /***********************************************/ ?>
				<h2>Permission error</h2>
				<?php foreach($permissionError as $pErr){ ?>
				<div class="nss-admin-container error">
					<div class="row"><?php echo $pErr[0]; ?></div>
					<div class="todo"><?php echo $pErr[1]; ?></div>
				</div>
				<?php } ?>
				
		<?php } elseif($nss_root!=getNssRoot()){ /***********************************************/ ?>
				<h2>URL conflict</h2>
				<div class="nss-admin-container error">
					<div class="row"><b><?php echo $nss_root; ?></b> and current url <br><b><?php echo getNssRoot(); ?></b> doesn't match</div>
					<div class="todo">
						<form method="post" style="float:left;">
							<input type="hidden" name="action" value="update_base_url">
							<input type="submit" class="submit" value="Update">
						</form>
						Click update to fix that issue
					</div>
				</div>
				
		<?php } elseif($nss_root!=getNssRoot()){ /***********************************************/ ?>
				<h2>Add base url</h2>
				<form class="nss-admin-form" method="post">
					<input type="hidden" name="action" value="update_base_url">
					<div class='row '>
						<label>Base-url</label>
						<?php if($nss_root==''){ ?>
							<span class="error">Base-url is missing!</span>
						<?php } elseif($nss_root!=getNssRoot()){ ?>
							<span class="error">Base-url is wrong! <input type="submit" class="submit" value="Update"></span>
						<?php } else { ?>
							<input disabled="disabled" type='text' class='text' value='<?php echo $nss_root; ?>'>
						<?php } ?>
					</div>
					<?php if($nss_root!=getNssRoot()){ ?>
					<div class='row hl'>
						<input class='submit' type='submit' value='Auto-fill'>
					</div>
					<?php } ?>
				</form>
				
		<?php } elseif(!empty($license_key) && $nss_root==getNssRoot()){ /***********************************************/ ?>
			<h2>Installation successful!</h2>
			<form class="nss-admin-form" method="post">
				<div class="row">
					<label>Software</label><span class="info">neosmart STREAM (Version: <?php echo $nss->get('version'); ?>)</span>
				</div>
				<div class='row '>
					<label>Preview</label>
					<span class="info"><a href="preview.php" target="_blank">Preview</a></span>
				</div>
				<div class="row hl">
					<label>License</label><span class="info"><?php echo $license_name; ?></span>
				</div>
				<div class="row">
					<label>Licensee</label><span class="info"><?php echo $license_owner; ?></span>
				</div>	
				<div class='row '>
					<label>Software url</label>
					<span class="info"><?php echo $nss_root; ?></span>
				</div>
							
			</form>
			
			<h2>Login</h2>
			<?php if(isset($login_error)){ ?>
				<div class="nss-admin-container error">
						<div class="row">This password is wrong!</div>
					</div>
			<?php } ?>
			<?php if(isset($_GET['error']) && $_GET['error']=='1'){ ?>
				<div class="nss-admin-container error">
						<div class="row">You have to login.</div>
					</div>
			<?php } ?>
			<?php if(is_default_password($admin_password)){ ?>
				<div class="nss-admin-container warning">
					<div class="row"><b><a href="nss-admin/password.php">Set admin password</a></b> as soon as possible!</div>
				</div>
			<?php } ?>
			<?php if(is_logged_in($nss)){ ?>
				<form class="nss-admin-form" method="post" action="nss-admin/">
					<div class='row'>
						You are logged in!
					</div>
					<div class='row hl'>
						<a href="nss-admin/?logout=1" class="button">Logout</a>
						<input class='submit' type='submit' value="Show admin area">
					</div>
				</form>
			<?php } else {?>
				<form class="nss-admin-form" method="post" action="index.php">
					<input type="hidden" name="action" value="login">
					<div class='row'>
						<label>Admin password</label><input name='admin_password' type='password' class='text' value=''>
					</div>
					<div class='row hl'>
						<input class='submit' type='submit' value='Login'>
					</div>
	
				</form>
			<?php } ?>
			
		<?php /*************************************************************************************************************/
			} else {
		?>			
			<h2>Add License Key</h2>
			<?php if(isset($_GET['error']) && $_GET['error']=='2'){ ?>
				<div class="nss-admin-container error">
						<div class="row">A file has been manually adjusted and caused a serious error. Please provide your license key again.</div>
					</div>
			<?php } ?>
			<?php if(isset($_GET['error']) && $_GET['error']=='3'){ ?>
				<div class="nss-admin-container error">
						<div class="row">Please enter your license key.</div>
					</div>
			<?php } ?>
			<?php if(isset($status_license_key)){ ?>
					<div class="nss-admin-container error">
						<div class="row"><?php echo $status_license_key; ?></div>
					</div>
			<?php }
				
			if(empty($license_key)){
					
				if(array_key_exists('license_key',$_POST)) $license_key = $_POST['license_key'];
			?>
			
				<form class="nss-admin-form" method="post">
					<input type="hidden" name="action" value="add_license_key">
					<div class='row'>
						<label>License key</label>
						<div class="field-area">
							<input name='license_key' type='text' class='text' value='<?php echo $license_key; ?>'>
							<div class="field-info">You find your license key on <a href="<?php echo NSS_WEBSITE_URL;?>my-account/" target="_blank"><?php echo NSS_WEBSITE_URL;?>my-account/</a></div>
						</div>
					</div>
					<div class='row'>
						<input class='submit' type='submit' value='Activate site'>
					</div>
					
				</form>
			<?php }else{ ?>
				<form class="nss-admin-form" method="post">
					<div class="row">
						<label>License</label><span class="info"><?php echo $license_name; ?></span>
					</div>
					<div class="row">
						<label>Status</label><span class="info"><?php echo $license_status; ?></span>
					</div>
					<div class="row">
						<label>Licensee</label><span class="info"><?php echo $license_owner; ?></span>
					</div>
									
				</form>
			<?php } ?>
		<?php /*************************************************************************************************************/
			} 
		?>
		</div><!--/.center-->
	</div><!--#nss-admin-->
</body>
</html>