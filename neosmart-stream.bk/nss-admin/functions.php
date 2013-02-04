<?php

/*****************************************************************************************
 * Installation
 *****************************************************************************************/
 
	function getLastFolder(){
		$url 	= $_SERVER['SCRIPT_NAME'];
		$pos 	= strrpos($url,'/index.php');
		$path 	= substr($url,0,$pos);
		$sPos	= strrpos($path,'/')+1;
		$folder = substr($path,$sPos);
		return $folder;
	}
	
/****************************************************************************
* Dateizugriffsrechte überprüfen
*****************************************************************************/

	function testFilePermissions(){
		
		$errors = array();
		
		if(!is_dir(NSS_ABSPATH.NSS_CONFIG)){ 	mkdir(NSS_ABSPATH.NSS_CONFIG, 0775);}
		if(!is_dir(NSS_CONTENT_CACHE)){ 		mkdir(NSS_CONTENT_CACHE, 0775);}
		
		if(!is_writable(NSS_ABSPATH.NSS_CONFIG)){
			array_push($errors,
				array(	'<b>'.NSS_ABSPATH.NSS_CONFIG.'</b> is not writeable',
						'Set permission for <b>nss-config</b> to <b>0755</b> (chmod)'
				)
			);
		}
		
		if(!is_writable(NSS_CONTENT_CACHE)){
			array_push($errors,
				array(	'<b>'.NSS_CONTENT_CACHE.'</b> is not writeable',
						'Set permission for <b>cache</b> to <b>0755</b> (chmod)'
				)
			);
		}
		
		if(count($errors)) return $errors;
		
		$files = array(
			NSS_CONFIG_BASE_URL,
			NSS_CONFIG_CHANNELS,
			NSS_CONFIG_CONFIG,
			NSS_CONFIG_LICENSE,
			NSS_CONFIG_PASSWORD,
			NSS_CONFIG_TRANSLATE
		);

		foreach($files as $f){
			if(!file_exists($f)){
				$fh = fopen($f, 'w');
				if($fh){
					fwrite($fh, '');
					fclose($fh);
					chmod($f, 0775);
				}else{
					//Error
				}
			}
			$perm = substr(sprintf('%o', fileperms($f)), -4);
			if($perm!='0775'){
				chmod($f,0755);
			}
		}
		return false;
	}
	

/****************************************************************************
* Dateizugriffsrechte überprüfen
*****************************************************************************/

	function testServerSettings(){
		if(ini_get('allow_url_fopen')!=1)
			return array('allow_url_fopen is disabled','Enable <b>allow_url_fopen</b> in your <b>php.ini</b>');
		//if(ini_get('openssl')!=1)
			//return array('openssl is disabled','Enable <b>openssl</b> in your <b>php.ini</b>');
		return false;
	}

 
 
/*****************************************************************************************
 * Functions
 *****************************************************************************************/
 	
	function saveBaseURL(){
		$fh = @fopen(NSS_CONFIG_BASE_URL, 'w');
		$data = '<?php ';
		$data .= "if(!isset($"."nss))die;";
		$data .= "\n$"."nss->set('nss_root','".getNssRoot()."');";
		$data .= "\n?>";
		if($fh){
			fwrite($fh, $data);
			fclose($fh);
			reload();
		}else{
			reload('?error=file_permissions');
		}
	}
	

	function getNssRoot($type=false){
		$protocol = (array_key_exists('HTTPS',$_SERVER)) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$pos = strrpos($_SERVER['SCRIPT_NAME'],'/neosmart-stream/');
		$path = substr($_SERVER['SCRIPT_NAME'],0,$pos+17);
		if($pos===false) return false;
		if($type=='host') return $host;
		else return $protocol.$host.$path;
	}
	
	
	function removeLicenseKey(){
		@unlink(NSS_CONFIG_LICENSE);
		@unlink(NSS_CONFIG_ERROR);
		@unlink(NSS_CONFIG_CODE);
		unset($_SESSION['nss_admin_password']);
		redirectTo('?error=3');
	}
	
	function redirectTo($path){
		global $nss;
		header('Location: '.$nss->get('nss_root').$path);
		die;
	}

	function updateConfig(){
		$config_file = NSS_ABSPATH."nss-config/nss-config.php";
		$debug_mode = $_POST['debug_mode']=='on' ? 'true' : 'false';
		$fh = fopen($config_file, 'w');
		$data = '<?php ';
		$data .= "if(!isset($"."nss)) die;";
		$data .= "\n$"."nss->set('debug_mode',".$debug_mode.");";
		$data .= "\n$"."nss->set('cache_time','".$_POST['cache_time']."');";
		$data .= "\n$"."nss->set('date_time_format','".$_POST['date_time_format']."');";
		$data .= "\n$"."nss->set('theme','".$_POST['theme']."');";
		$data .= "\n?>";
		fwrite($fh, $data);
		fclose($fh);
		reload();
	}
	
	function updatePassword(){
		
		$password = $_POST['admin_password'];
		if(strlen($password)<3){
			return 'Unsafe password';
		}
		

		$config_file = "../nss-config/nss-password.php";
		$fh = fopen($config_file, 'w');
		$data = '<?php ';
		$data .= "if(!isset($"."nss)) die;";
		$data .= "\n//DON'T EDIT THIS FILE";
		$data .= "\n$"."nss->set('admin_password','".md5($password)."');";
		$data .= "\n?>";
		fwrite($fh, $data);
		fclose($fh);
		$_SESSION['nss_admin_password'] = $_POST['admin_password'];
		reload();
	}
	
	function updateChannels(){
		$config_file = "../nss-config/nss-channels.php";
		$fh = fopen($config_file, 'w');
		$data = "<?php \n";
		$data .= "if(!isset($"."nss)) die;";
		$data .= stripslashes($_POST['channels']);
		$data .= "?>";
		fwrite($fh, $data);
		fclose($fh);
		//die($_POST['channels']);
		die('CHANNELS_SAVED');
	}
	
	function updateTranslation(){
		$file = "../nss-config/nss-translate.php";
		$fh = fopen($file, 'w');
		$data = '<?php ';
		$data .= "if(!isset($"."nss)) die;";
		$data .= "\n$"."nss->set('error_no_data','".$_POST['error_no_data']."');";
		$data .= "\n?>";
		fwrite($fh, $data);
		fclose($fh);
		reload();
	}
	
	function is_logged_in($nss){
		if(empty($_SESSION['nss_admin_password'])){
			if(is_default_password($nss->get('admin_password'))){
				$_SESSION['nss_admin_password'] = 'admin';			
			}else{

				return false;	
			}
		} 
		$state = md5($_SESSION['nss_admin_password']) == $nss->get('admin_password');
		return $state;
	}
	
	function is_default_password($admin_password){
		return $admin_password == '21232f297a57a5a743894a0e4a801fc3';	
	}
	
	function reload($params=''){
		header('Location: '.$_SERVER['PHP_SELF'].$params);
		die;
	}
	
	function cl($nss){
		if(!$nss->testNSS()){
			apiRequest('file_conflict');
			header('Location: '.getNssRoot().'?error=2');
			die;
		}else{
			return false;	
		}
	}
	
	function afl(){
		if(filemtime("../nss-config/nss-license.php")	== intval(file_get_contents(NSS_CONFIG_CODE))) return true;
		else false;
	}

/****************************************************************************
* Check for Updates once a week
*****************************************************************************/
	
	function is_update_available($nss){
		$file = "../nss-content/cache/latest_version.txt";
		$ft = @filemtime($file);
		$week = 60*60*24*7;
		$current_version = $nss->get('version');
		$output = '(Version '.$current_version.')';

		
		if(!$ft || $ft+$week<time()){
			//Erstelle Datei
			$license = apiRequest('latest_version');
			
			if($license[0]->type=='latest_version'){
				$version = $license[0]->message;
				
				//Save Data
				$fh = fopen($file, 'w');
				fwrite($fh, $version);
				fclose($fh);
			}else{
				//TODO error	
			}
		}else{
			$version = @file_get_contents($file);
		}
		if(isset($version) && $current_version!=$version){
			$output .= '<br><br><span class="warning status">An Update is available: <a target="_blank" href="'.$nss->get('nss_website').'downloads/">Download Version '.$version.'</a></span>';	
		}
		return $output;
	}
	
/****************************************************************************
* Get Channel Status
*****************************************************************************/
	
	function getChannelStatus($type,$id){
		$status = @file_get_contents("../nss-content/cache/".$type.'_'.$id.'_status.xml');
		if(!$status) return '<span class="warning status">untested</span>';
		return $status;
	}

/****************************************************************************
* Admin Login
*****************************************************************************/
	
	function adminLogin($nss){
		$_SESSION['nss_admin_password'] = $_POST['admin_password'];
		if(is_logged_in($nss)){
			header('Location: nss-admin/');
			die;
		}else{
			return 'Wrong Password';	
		}
	}
	
/****************************************************************************
* Add Licence Key
*****************************************************************************/

	function apiRequest($action,$key=false){
		global $nss;
		if(!$key) $key = $nss->get('license_key');
		$query = NSS_API_URL.'index.php?key='.$key
			.'&site='.$_SERVER['HTTP_HOST'].'&action='.$action
			.'&return_url='.urlencode($nss->get('nss_root'));
		$response = simplexml_load_file($query);
		return $response;
	}
	
	function addLicenseKey($key){
		if(strlen($key)!=19){
			return 'Error: This license key is invalid';
		}

		$license = apiRequest('validate_key',$key);	
	
		//Success
		if(!empty($license) && $license->type=='license'){
			
			$file = "nss-config/nss-license.php";
			$fh = fopen($file, 'w');
			
			$data = '<?php ';
			$data .= "if(!isset($"."nss))die;";
			$data .= "\n//DON'T EDIT THIS FILE";
			$data .= "\n$"."nss->set('license_status','".$license->status."');";
			$data .= "\n$"."nss->set('license_name','".$license->name."');";
			$data .= "\n$"."nss->set('license_owner','".$license->owner."');";
			$data .= "\n$"."nss->set('license_key','".$license->key."');";
			$data .= "\n$"."nss->set('license_limit','".$license->limit."');";
			$data .= "\n$"."nss->set('license_sites','".$license->sites."');";
			$data .= "\n$"."nss->set('license_code','".$license->code."');";
			$data .= "\n$"."nss->set('license_message','".$license->message."');";
			$data .= "\n$"."nss->set('license_version','".$license->version."');";
			$data .= "\n?>";
			
			fwrite($fh, $data);
			fclose($fh);
			
			$fh = fopen(NSS_CONFIG_CODE, 'w');
			fwrite($fh, $license->code);
			fclose($fh);
			
			@unlink(NSS_CONFIG_ERROR);
			
			reload();
		}
		
		//Error
		if(!empty($license) && $license->type=='error'){
			return 'Error: '.$license->message;
		}
		
		//No Connection
		return 'Error: The API is not available yet or the settings on your server are wrong. Please read the documentation or try again later.';
		
	}


/****************************************************************************
* Total Reset
*****************************************************************************/

	function totalReset(){
		global $nss;
		$nss->cleanDir();
		$nss->cleanDir(NSS_ABSPATH.NSS_CONFIG);
		removeLicenseKey();
	}
	
?>