<?php
/************************************************************************************************************************************
 *	neosmart STREAM - core class
 *
 *	@copyright:			neosmart GmbH
 *	@licence:			https://neosmart-stream.de/legal/license-agreement/
 *	@documentation:		https://neosmart-stream.de/docs/
 *	@version:			1.0.0
 *	
 ************************************************************************************************************************************/

NSS_DEBUG ? error_reporting(E_ALL) : error_reporting(0);

class NeosmartStream{
	
	private $config = array(
		'version_major'				=> 1,
		'version_minor'				=> 0,
		'version_revision'			=> 0,
		'admin_password'			=> '21232f297a57a5a743894a0e4a801fc3',
		'nss_root'					=> '',
		'debug_mode'				=> true,
		'cache_time'				=> 60,
		'date_time_format'			=> 'd F Y, G:i',
		'theme'						=> 'base',
		'error_no_data'				=> 'No data found. Please check your configuration.',
		'default_limit'				=> 5,
		'license_name'				=> false,
		'license_version'			=> '',
		'license_owner'				=> '',
		'license_key'				=> '',
		'license_sites'				=> '',
		'license_status'			=> '',
		'license_message'			=> '',
		'license_code'				=> false
	);
	private $channel_list 			= array();
	private $CACHE_FOLDER 			= 'nss-content/cache/';
	private $CACHE_FOLDER_INTERNAL 	= '../nss-content/cache/';
	private $CACHE_FILE_NAME 		= 'stream.html';	
	private $NSS_WEBSITE			= 'https://neosmart-stream.de/';	
	
/**************************************************************************
 * Construct
 **************************************************************************/
 
	function __construct() {
		$this->set('https',array_key_exists("HTTPS",$_SERVER));
	}
   
/**************************************************************************
 * Get / Set
 **************************************************************************/
 
	function set($parameter,$value){
		$this->config[$parameter] = $value;
	}
	
	function get($parameter){
		if($parameter=='channel_count'){
			return count($this->channel_list);
		}
		elseif($parameter=='channel_list'){
			return $this->channel_list;
		}
		elseif($parameter=='version'){
			return $this->config['version_major'].'.'.$this->config['version_minor'].'.'.$this->config['version_revision'];
		}
		elseif($parameter=='nss_website'){
			return $this->NSS_WEBSITE;
		}
		return array_key_exists($parameter,$this->config)?$this->config[$parameter]:false;
	}
	
	function getPath(){
		//return getcwd();	
		return get_include_path();
	}

/**************************************************************************
 * Current Host is Part of Base-Url?
 **************************************************************************/
 	
	function hostIsPartOfBaseURL(){
		$protocol = (array_key_exists('HTTPS',$_SERVER)) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$site = $protocol.$host;
		$baseURL = substr($this->get('nss_root'),0,strlen($site));
		return $site===$baseURL;
	}

	
	
/**************************************************************************
 * Add Channel
 **************************************************************************/
 	
	function addChannel($a,$b,$c='',$d=3,$e='true',$f=0){
		$new_channel = array();
		switch(strtolower($a)){
			case 'facebook':
				$new_channel['type'] 					= 'facebook';
				$new_channel['id']			 			= $b;
				$new_channel['access_token'] 			= $c;
				$new_channel['limit'] 					= $d;
				$new_channel['show_all']			 	= $e;
				$new_channel['access_token_expires'] 	= $f;
				
			break;
			case 'twitter':
				$new_channel['type'] 			= 'twitter';
				$new_channel['id'] 				= $b;
				$new_channel['limit'] 			= $c;
			break;
			default: //nss
				$new_channel['type'] 			= 'nss';

				
				$tmp = substr($b,strrpos($b,"/")+1);
				$tmp = urlencode($tmp);
			
				$new_channel['id']				= $tmp;
				$new_channel['url'] 			= $b;
			break;
		}
		array_push($this->channel_list,$new_channel);
	}

/**************************************************************************
 * Init
 **************************************************************************/
 	
	function initStream(){
		return $this->updateRequired() ? $this->updateCache() : $this->show();
	}
 
 
/**************************************************************************
 * Update
 **************************************************************************/
 
	function updateRequired(){
		$now = time();
		$update = false;
		$cache_file = NSS_ABSPATH."nss-content/cache/stream.html";
		
		if(!is_dir(NSS_ABSPATH."nss-content/cache/")){
			mkdir(NSS_ABSPATH."nss-content/cache/",0755);
			$update = true;
		}
		elseif(!file_exists($cache_file)){
			$update = true;
		}
		elseif($now-filemtime($cache_file) >= $this->get('cache_time')){
			$update = true;
		}
		elseif(filemtime(NSS_ABSPATH.'nss-config/nss-config.php')-filemtime($cache_file)>0
			|| filemtime(NSS_ABSPATH.'nss-config/nss-channels.php')-filemtime($cache_file)>0
			|| filemtime(NSS_CONFIG_BASE_URL)-filemtime($cache_file)>0
			|| filemtime(NSS_ABSPATH.'nss-config/nss-translate.php')-filemtime($cache_file)>0
		){
			$update = true;
		}
		
		return $update;
	}
	
	function getLastUpdate(){
		$cache_file = $this->CACHE_FOLDER_INTERNAL.$this->CACHE_FILE_NAME;
		$ft = @filemtime($cache_file);
		if(!$ft) return "Never";
		return date($this->get('date_time_format'), $ft);
	}


/**************************************************************************
 * Read Cache
 **************************************************************************/
 
	function show($echo = true){
		$html = '';
		$cache_handle = '';
		$error = '';
		$debug = '';
		$chancel = '';
		$admin_link = $this->htmlWrap('admin_link','Admin');
		$pre = "<div style='color:#000;background-color:#ff7800;display:block;width:auto;padding:2px 10px;overflow:hidden;'>";
		$suff = "</div>";
		$pre_fff = "<span style='color:#fff'>";
		$suff_fff = "</span>";
		
		//Error
		if($this->get('license_owner')==''){
			$chancel .= $pre.$pre_fff.'neosmart STREAM'.$suff_fff.' - add your license in the admin area!'.$suff;
			if($echo){
				echo $chancel;
				return;
			}
			else return $chancel;
		}
		
		//Cache
		if($this->get('channel_count')!=0){
			$cache_handle .= @file_get_contents(NSS_ABSPATH.$this->CACHE_FOLDER.'stream.html');
		}
		
		//Debug
		if($this->get('debug_mode')){
			
			$debug .= "<a href='".$this->get('nss_website')."' title='neosmart STREAM - Social Plugin' target='_blank' style='color:#190d03;font-size:12px;overflow:visible!important;display:block!important;visibility:visible!important;text-decoration:none;'>".$pre.$pre_fff."neosmart STREAM".$suff_fff." - DEBUG MODE".$suff."</a>";
			
			if(!$this->hostIsPartOfBaseURL()){
				$debug .= $this->htmlWrap('notice','Base URL is wrong. Please update your configuration!');
				$admin_link = '';
			}elseif($this->get('channel_count')==0){
				$debug .= $this->htmlWrap('notice','No Channels to display. <a href="'.$this->get('nss_root').'">Login</a> and add a channel!');
				$this->cleanDir(NSS_CONTENT_CACHE);
			}else{
				if($this->updateRequired()){
					$debug .= $this->htmlWrap('notice','The cache is being rebuilt ... Refresh this page to see the changes.');
				}
			}			
		}
		
		//$ad = "<a href='".$this->get('nss_website')."' title='Stream your favorite Social Networks directly to your website.' target='_blank' style='color:#190d03;font-size:12px;overflow:visible!important;display:block!important;visibility:visible!important;text-decoration:none;'>".$pre.$pre_fff."neosmart STREAM".$suff_fff." - Social Media for your Website".$suff."</a>";
		$ad = "";

		if(!$this->get('debug_mode') && $this->get('license_version')!='pro') $html .= $ad;
		$html .= $error;
		if($this->get('debug_mode')) $html .= $debug;
		if($error=='') $html .= $cache_handle;
		$html .= $admin_link;
		
		if($echo){
			echo $html;
			return;
		}
		else return $html;
	}
	
	function readFile($filename){
		$cache_handle = @file_get_contents($this->CACHE_FOLDER_INTERNAL.$filename);
		return $cache_handle;
	}
	
/**************************************************************************
 * Clean Cache
 **************************************************************************/
 	 
function cleanDir($dir=false) {
    $mydir = @opendir($dir);
	if(!$mydir) return false;
	
	while(false !== ($file = readdir($mydir))) {
		if($file != "." && $file != "..") {
			chmod($dir.$file, 0777);
			if(is_dir($dir.$file)) {
				chdir('.');
				$this->cleanDir($dir.$file.'/');
				rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
			}
			else
				unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
		}
	}
	closedir($mydir);
	return true;
}

	
/**************************************************************************
 * Wrap HTML
 **************************************************************************/
	
	function htmlWrap($type,$content){
		$notice="display:block;padding:5px;padding:5px 10px;font-size:13px;border-bottom:1px solid #d8d8a4;background-color:#ffffe0;color:#555;";
		$error="display:block;padding:5px;padding:5px 10px;font-size:13px;border-bottom:1px solid #d8d8a4;background-color:#c00;color:#FFFFFF;;";
		switch($type){
			case 'notice':
				//$html = '<div style="'.$notice.'">'.$content.'</div>';
				$html = '';
			break;
			case 'error':
				$html = '<div style="'.$error.'">'.$content.'</div>';
			break;
			case 'admin_link':
				//$html = '<div class="nss-admin-link"><a href="'.$this->get('nss_root').'">'.$content.'</a></div>';
				$html = '';
			break;
			default:
				$html = $content;
			break;
		}
		return $html;
	}
	
	
/**************************************************************************
 * Update Channel
 **************************************************************************/
 	
	function updateChannel($k){
		switch($this->channel_list[$k]['type']){
			case 'facebook':
				$response = $this->readFacebookChannel($this->channel_list[$k]['id'],$this->channel_list[$k]['access_token'],$this->channel_list[$k]['limit'],$this->channel_list[$k]['show_all']);
			break;
			case 'twitter':
				$response  = $this->readTwitterChannel($this->channel_list[$k]['id'],$this->channel_list[$k]['limit']);
			break;
			default:
				$response = $this->readChannel($this->channel_list[$k]['url']);
			break;
		}
		return $response;
	}


/**************************************************************************
 * Update Cache
 **************************************************************************/
 	
	function updateCache(){
		$data = '';
		for($k=0;$k<count($this->channel_list);$k++){
			switch($this->channel_list[$k]['type']){
				case 'facebook':
					$this->readFacebookChannel($this->channel_list[$k]['id'],$this->channel_list[$k]['access_token'],$this->channel_list[$k]['limit'],$this->channel_list[$k]['show_all']);
					if($response != 'error') $data .= $response;
				break;
				case 'twitter':
					$data .= $this->readTwitterChannel($this->channel_list[$k]['id']);
				break;
				default:
					$data .= $this->readChannel($this->channel_list[$k]['url']);
				break;
			}
		}
		return $data=='' ? $this->show(): $this->sortData($data);
	}

/**************************************************************************
 * Save Status of a Channel to local file
 **************************************************************************/
 	
	function saveChannelTestToFile($type,$id,$status){
		$file = NSS_ABSPATH."nss-content/cache/".$type.'_'.$id.'_status.xml';
		$fh = fopen($file, 'w');
		$data = $status=='success' ? '<span class="status active">active</span>' : '<span class="status inactive">inactive</span>';
		fwrite($fh, $data);
		fclose($fh);
		return $data;
	}
	
/**************************************************************************
 * Merge and Sort Data
 **************************************************************************/
	
	function mergeChannels(){
		$data = '';
		for($k=0;$k<count($this->channel_list);$k++){
			$file = $this->readFile($this->channel_list[$k]['type'].'_'.$this->channel_list[$k]['id'].'.xml');
			if($file){
				$file = preg_replace("/<\?xml version='1.0'\?>/","",$file);
				$start = strpos($file,"<nss>")+5;
				$end = strpos($file,"</nss>")-$start;
				$file = substr($file,$start,$end);
				$data .= $file;
			}
		}
		return $this->sortData($data);
	}
	
	function sortData($data){
		
		function filter_xml($matches) { 
			return trim(htmlspecialchars($matches[1])); 
		} 
		$data = preg_replace_callback('/<!\[CDATA\[(.*)\]\]>/', 'filter_xml', $data);
		$xmlObj = simplexml_load_string("<?xml version='1.0'?><nss>".$data."</nss>");
		
		$arrXml = $this->changeObjectsToArrays($xmlObj);
		
		$item = $arrXml['item'];		
		if(isset($item['channel'])){$item = array($item);}
		
		//If more than one
		if(!@array_key_exists('created',$item)){
			foreach($item as $c=>$key) {
				$sort_created[] = $key['created'];
			}
		}
		
		array_multisort($sort_created, SORT_DESC,$item );
		return $this->insertDataIntoTemplate($item);
	}
	
	function changeObjectsToArrays($data, $skip = array()){
		$arrayData = array();
		if (is_object($data)) $data = get_object_vars($data);
		if (is_array($data)) {
			foreach ($data as $index => $value) {
				if (is_object($value) || is_array($value)) {
					$value = $this->changeObjectsToArrays($value, $skip);
				}
				if (in_array($index, $skip)) {
					continue;
				}
				$arrayData[$index] = $value;
			}
		}
		return $arrayData;
	}
	
	
/**************************************************************************
 * Insert data into template
 **************************************************************************/
 
	function insertDataIntoTemplate($item){
		$out = '';
		for($position=0;$position<count($item);$position++){
			$nss = $item[$position];
			
			$channel = $nss['channel'];
			$is_facebook = $channel=='facebook';
			$is_twitter = $channel=='twitter';
			$is_default = !$is_facebook && !$is_twitter;
						
			$id = $nss['id'];
			$created = $this->transformDate($nss['created']);
			$updated = $this->transformDate($nss['updated']);
			$content = is_array($nss['content']) ? '' : $this->autoLink($nss['content']);
			
			$author = $nss['author'];
			$author_id = $nss['author']['id'];
			$author_name = $nss['author']['name'];
			$author_link = $nss['author']['link'];
			$author_avatar = $nss['author']['avatar'];
			
			$location_address = isset($nss['location']['address']) ? $nss['location']['address'] : '';
			$location_latitude = isset($nss['location']['latitude']) ? $nss['location']['latitude'] : '';
			$location_longitude = isset($nss['location']['longitude']) ? $nss['location']['longitude'] : '';
			$extras_facebook_type = $is_facebook ? $nss['extras']['facebook']['type'] : '';
			$extras_facebook_source = !$is_facebook || is_array($nss['extras']['facebook']['source']) ? '' : str_replace('autoplay=1','autoplay=0',$nss['extras']['facebook']['source']);
			$extras_facebook_description = !$is_facebook || is_array($nss['extras']['facebook']['description']) ? '' : $this->autoLink($nss['extras']['facebook']['description']);
			$extras_facebook_caption = !$is_facebook || is_array($nss['extras']['facebook']['caption']) ? '' : $nss['extras']['facebook']['caption'];
			$extras_facebook_picture = !$is_facebook || is_array($nss['extras']['facebook']['picture']) ? '' : $nss['extras']['facebook']['picture'];
			$extras_facebook_link = !$is_facebook || is_array($nss['extras']['facebook']['link']) ? '' : $nss['extras']['facebook']['link'];
			$extras_facebook_name = !$is_facebook || is_array($nss['extras']['facebook']['name']) ? '' : $nss['extras']['facebook']['name'];
			$extras_facebook_message = !$is_facebook || is_array($nss['extras']['facebook']['message']) ? '' : $this->autoLink($nss['extras']['facebook']['message']);
			
			$extras_facebook_privacy_description = !$is_facebook || is_array($nss['extras']['facebook']['privacy']['description']) ? '' : $nss['extras']['facebook']['privacy']['description'];
			$extras_facebook_privacy_value = !$is_facebook || is_array($nss['extras']['facebook']['privacy']['value']) ? '' : $nss['extras']['facebook']['privacy']['value'];
			
			$extras_facebook_count_comments =  !$is_facebook || is_array($nss['extras']['facebook']['count']['comments']) ? '' : $nss['extras']['facebook']['count']['comments'];
			$extras_facebook_count_likes = !$is_facebook || is_array($nss['extras']['facebook']['count']['likes']) ? '' : $nss['extras']['facebook']['count']['likes'];
			$extras_facebook_count_shares = !$is_facebook || is_array($nss['extras']['facebook']['count']['shares']) ? '' : $nss['extras']['facebook']['count']['shares'];
			
			$extras_facebook_story = !$is_facebook || is_array($nss['extras']['facebook']['story']) ? '' : $nss['extras']['facebook']['story'];
			$extras_facebook_icon = !$is_facebook || is_array($nss['extras']['facebook']['icon']) ? '' : $nss['extras']['facebook']['icon'];
			$extras_facebook_object_id = !$is_facebook || is_array($nss['extras']['facebook']['object_id']) ? '' : $nss['extras']['facebook']['object_id'];
			
			$extras_facebook_application_name = !$is_facebook || is_array($nss['extras']['facebook']['application']['name']) ? '' : $nss['extras']['facebook']['application']['name'];
			$extras_facebook_application_id = !$is_facebook || is_array($nss['extras']['facebook']['application']['id']) ? '' : $nss['extras']['facebook']['application']['id'];
			
			$extras_facebook_comments_datacount = !$is_facebook ? 0 : count($nss['extras']['facebook']['comments']);
			if($extras_facebook_comments_datacount>0){
				$tmp = $nss['extras']['facebook']['comments'];
				if(isset($tmp['comment'][0])) $extras_facebook_comments_datacount = count($tmp['comment']);				
			}
			
			//Comments
			if($extras_facebook_comments_datacount>1){
				$comment = '';
				for($d=0;$d<$extras_facebook_comments_datacount;$d++){
					$extras_facebook_comments_author_name = $tmp['comment'][$d]['author']['name'];
					$extras_facebook_comments_author_id = $tmp['comment'][$d]['author']['id'];
					$extras_facebook_comments_author_link = $tmp['comment'][$d]['author']['link'];
					$extras_facebook_comments_author_avatar = $tmp['comment'][$d]['author']['avatar'];
					$extras_facebook_comments_content = $tmp['comment'][$d]['content'];
					$extras_facebook_comments_created = $this->transformDate($tmp['comment'][$d]['created']);
					include '../nss-content/themes/'.$this->get('theme').'/template-comment.php';
				}
				$extras_facebook_comments = $comment;
			}else if($extras_facebook_comments_datacount==1){
				$comment = '';
				$extras_facebook_comments_author_name = $tmp['comment']['author']['name'];
				$extras_facebook_comments_author_id = $tmp['comment']['author']['id'];
				$extras_facebook_comments_author_link = $tmp['comment']['author']['link'];
				$extras_facebook_comments_author_avatar = $tmp['comment']['author']['avatar'];
				$extras_facebook_comments_content = $tmp['comment']['content'];
				$extras_facebook_comments_created = $this->transformDate($tmp['comment']['created']);
				 
				include '../nss-content/themes/'.$this->get('theme').'/template-comment.php';
				$extras_facebook_comments = $comment;
			}else{
				$extras_facebook_comments = '';
			}
			
			
			$tmp = false;
			include '../nss-content/themes/'.$this->get('theme').'/template-post.php';
		}
		$out = "<div class='nss-stream'>\n".$out."\n</div>";
		return $this->saveCache($out);
	}
	
/**************************************************************************
 * Save Cache
 **************************************************************************/
	
	function saveCache($out){
		$cache_file = $this->CACHE_FOLDER_INTERNAL.$this->CACHE_FILE_NAME;
		$fh = fopen($cache_file, 'w');
		fwrite($fh, $out);
		fclose($fh);
		return $out;
	}
	
	function saveFile($filename,$content){
		$cache_file = $this->CACHE_FOLDER_INTERNAL.$filename;
		$fh = fopen($cache_file, 'w');
		fwrite($fh, $content);
		fclose($fh);
	}
	
/**************************************************************************
 * Read Data
 **************************************************************************/
 
 	function readData($url){
 		$parsedUrl = parse_url($url);
		$data = null;

		//CURL
		if  (in_array  ('curl', get_loaded_extensions())){
				
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$data = curl_exec ($ch);
			curl_close ($ch);
			//print_r($data);
			return $data;
		}

		//fsockopen
		$fp = @fsockopen ('ssl://'.$parsedUrl['host'] , 443, $errno, $errstr, 30);  
		if ($fp){
			fputs($fp, "GET /".$parsedUrl['path']."?".$parsedUrl['query']."/ HTTP/1.1\r\n"); 
			fputs($fp, "Host: ".$parsedUrl['host']."\r\n");
			fputs($fp, "Referer: ".$parsedUrl['host']."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			while (!feof($fp)){
				$data = fgets($fp);
			}
			fclose($fp);
			return $data;	
		} 

		//file_get_contents
		$data = @file_get_contents($url);
		if($data) return $data;

		//Anymore alternatives?
		
		//Error
		return 'error';
		
	}
	 
	function readFacebookChannel($id,$access_token,$limit=false,$show_all='true'){
		if(!$limit) $limit = $this->get('default_limit');
		$binding = $show_all=='false' ? 'posts' : 'feed';
		$url = "https://graph.facebook.com/".$id."/".$binding."?limit=".$limit."&access_token=".$access_token;
		$data = $this->readData($url);
		
		$error = false;
		
		if($data == 'error') $error = true;
		$fbdata = json_decode($data);
		
		if(isset($fbdata->{'error'})) $error = true;
		
		if($error){
			$cached_data = $this->readFile('facebook_'.$id.'.xml');
			if($cached_data){
				$this->saveChannelTestToFile('facebook',$id,'error');
				return 'cache';
			}
			else{
				$this->saveChannelTestToFile('facebook',$id,'error');
				return 'error';
			}
		}else{		
			return $this->convertFacebookChannel($id,$fbdata);
		}
	}	
	
	function convertFacebookChannel($id,$fbdata){ 
	
		$posts = $fbdata->{'data'};
		$output = "";

		for($k=0;$k< count($posts);$k++){
			$p = $posts[$k];
			
			$output .= "<item>";
			$output .= "\n\t<channel>facebook</channel>";	
			$output .= "\n\t<id>"; if(isset($p->id)) $output .= $p->id; $output .= '</id>';
			$output .= "\n\t<created>".$p->created_time.'</created>';
			$output .= "\n\t<updated>"; if(isset($p->updated_time)) $output .= $p->updated_time; $output .='</updated>';
			$output .= "\n\t<content></content>";
			$output .= "\n\t<author>";
				$output .= "\n\t\t<id>"; if(isset($p->from->id)) $output .= $p->from->id; $output .='</id>';
				$output .= "\n\t\t<name>"; if(isset($p->from->name)) $output .= $p->from->name; $output .='</name>';
				$output .= "\n\t\t<link>"; if(isset($p->from->id)) $output .= "http://www.facebook.com/".$p->from->id; $output .='</link>';
				$output .= "\n\t\t<avatar>"; if(isset($p->from->id)) $output .= "https://graph.facebook.com/".$p->from->id.'/picture'; $output .='</avatar>';		 			
			$output .= "\n\t</author>";
			$output .= "\n\t<location></location>";
			$output .= "\n\t<extras>";
				$output .= "\n\t\t<facebook>";
					$output .= "\n\t\t\t<type>"; if(isset($p->type)) $output .= $p->type; $output .= '</type>';	
					$output .= "\n\t\t\t<source>"; if(isset($p->source)) $output .= $this->cdata($p->source); $output .= '</source>';	
					$output .= "\n\t\t\t<caption>"; if(isset($p->caption)) $output .= $this->cdata($p->caption); $output .= '</caption>';	
					$output .= "\n\t\t\t<description>"; if(isset($p->description)) $output .= $this->cdata($p->description); $output .= '</description>';
					$output .= "\n\t\t\t<picture>"; if(isset($p->picture)) $output .= $this->cdata($p->picture); $output .= '</picture>';
					$output .= "\n\t\t\t<link>"; if(isset($p->link)) $output .= $this->cdata($p->link); $output .= '</link>';
					$output .= "\n\t\t\t<name>"; if(isset($p->name)) $output .= $this->cdata($p->name); $output .= '</name>';	
					$output .= "\n\t\t\t<message>"; if(isset($p->message)) $output .= $this->cdata($p->message); $output .= '</message>';						
					$output .= "\n\t\t\t<privacy>";
						$output .= "\n\t\t\t\t<description>"; if(isset($p->privacy->description)) $output .= $p->privacy->description; $output .='</description>';
						$output .= "\n\t\t\t\t<value>"; if(isset($p->privacy->value)) $output .= $p->privacy->value; $output .='</value>';
					$output .= "\n\t\t\t</privacy>";
					$output .= "\n\t\t\t<count>";
						$output .= "\n\t\t\t\t<comments>"; $output .= isset($p->comments->count) ? $p->comments->count : '0'; $output .='</comments>';
						$output .= "\n\t\t\t\t<likes>"; $output .= isset($p->likes->count) ? $p->likes->count : '0'; $output .='</likes>';
						$output .= "\n\t\t\t\t<shares>"; $output .= isset($p->shares->count) ? $p->shares->count : '0'; $output .='</shares>';
					$output .= "\n\t\t\t</count>";
					$output .= "\n\t\t\t<story>"; if(isset($p->story)) $output .= $this->cdata($p->story); $output .= '</story>';			
					$output .= "\n\t\t\t<icon>"; if(isset($p->icon)) $output .= $p->icon; $output .='</icon>';
					$output .= "\n\t\t\t<object_id>"; if(isset($p->object_id)) $output .= $p->object_id; $output .='</object_id>';
					$output .= "\n\t\t\t<application>";
						$output .= "\n\t\t\t\t<name>"; if(isset($p->application->name)) $output .= $p->application->name; $output .='</name>';
						$output .= "\n\t\t\t\t<id>"; if(isset($p->application->id)) $output .= $p->application->id; $output .='</id>';
					$output .= "\n\t\t\t</application>";
					$output .= "\n\t\t\t<comments>";
					
						if(isset($p->comments->count) && intval($p->comments->count)>0){
							for($c=0;$c<count($p->comments->data);$c++){
								$output .= "\n\t\t\t\t<comment>";
								$output .= "\n\t\t\t\t\t<author>";
									$output .= "\n\t\t\t\t\t\t<id>".$p->comments->data[$c]->from->id."</id>";
									$output .= "\n\t\t\t\t\t\t<name>".$p->comments->data[$c]->from->name."</name>";
									$output .= "\n\t\t\t\t\t\t<link>http://www.facebook.com/profile.php?id=".$p->comments->data[$c]->from->id."</link>";
									$output .= "\n\t\t\t\t\t\t<avatar>https://graph.facebook.com/".$p->comments->data[$c]->from->id."/picture</avatar>";
								$output .= "\n\t\t\t\t\t</author>";
								$output .= "\n\t\t\t\t\t<content>".$this->cdata($p->comments->data[$c]->message)."</content>";
								$output .= "\n\t\t\t\t\t<created>".$p->comments->data[$c]->created_time."</created>";
								$output .= "\n\t\t\t\t</comment>";
							}
						}
					
					$output .= "\n\t\t\t</comments>";
				$output .= "\n\t\t</facebook>";
			$output .= "\n\t</extras>";
			$output .= "\n</item>\n";	
		}

		$output = "<?xml version='1.0'?>\n<nss>\n".$output."</nss>";
		
		$this->saveFile('facebook_'.$id.'.xml',$output);
		$this->saveChannelTestToFile('facebook',$id,'success');
		return 'success';
	}
	
	
/**************************************************************************
 * Read Twitter Channel
 * TODO: ID hinzufügen
 **************************************************************************/
 
 	function readTwitterChannel($id,$limit=false){
		
		if(!$limit) $limit = $this->get('default_limit');
		$tweet = @simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline.xml?include_rts=true&screen_name=".$id."&count=".$limit);
		
		if(!isset($tweet[0]->status)){
			$tweet = @simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline.xml?include_rts=true&id=".$id."&count=".$limit);
		}
		
		if(!isset($tweet[0]->status)){
			return 'error';
		}
		
		$output = '';
		
		foreach($tweet as $t){	
			if($this->get('https')){	$avatar = $this->cdata("https://api.twitter.com/1/users/profile_image?screen_name=".strtolower($t->user->screen_name)."&size=normal");}
			else{						$avatar = $this->cdata($t->user->profile_image_url);}		
			$output .= "\t<item>
			<channel>twitter</channel>
			<id>".$t->id."</id>
			<created>".$this->transformDate($t->created_at,'c')."</created>
			<updated>false</updated>
			<content>".$this->cdata($this->escapeString($this->autoLink($t->text)))."</content>
			<author>
				<id>".$t->user->id."</id>
				<name>".$t->user->name."</name>
				<link>".$this->cdata("https://twitter.com/".$t->user->screen_name)."</link>
				<avatar>".$avatar."</avatar>
			<location>
				<adress></adress>
				<latitude></latitude>
				<longitude></longitude>
			</location>
			</author>
			<extra>
				<twitter>
					<retweeted>".$t->retweeted."</retweeted>
					<count>
						<retweet_count>".$t->retweet_count."</retweet_count>
						<friends_count>".$t->user->friends_count."</friends_count>
						<followers_count>".$t->user->followers_count."</followers_count>
						<statuses_count>".$t->user->statuses_count."</statuses_count>
					</count>
					<lang>".$t->user->lang."</lang>
				</twitter>
			</extra>
		</item>";
		}
				
		$output = "<?xml version='1.0'?>\n<nss>\n".$output."</nss>";
	
		$this->saveFile('twitter_'.$id.'.xml',$output);
		$this->saveChannelTestToFile('twitter',$id,'success');
		return 'success';
			
	}
	
/**************************************************************************
 * Read NSS Channel
 **************************************************************************/
 
 	function readChannel($url){
		$xml = @file_get_contents($url);
		if(!$xml) return 'error';
		$name = substr($url,strrpos($url,"/")+1);
		$name = urlencode($name);
		$this->saveFile('nss_'.$name.'.xml',$xml);
		$this->saveChannelTestToFile('nss',$name,'success');
		return 'success';
	}
	
/**************************************************************************
 * Include JS and CSS
 **************************************************************************/
 
 	function getHead($echo=true,$jquery=true){
		$data = "\n<link href='".$this->get('nss_root')."nss-content/themes/".$this->get('theme')."/style.css' type='text/css' rel='stylesheet' />";
		if($jquery) $data .= "\n<script type='text/javascript' src='".$this->get('nss_root')."nss-includes/jquery.js'></script>";
		$data .= "\n<script type='text/javascript' src='".$this->get('nss_root')."nss-core/jquery.neosmart.stream.js'></script>";
		$data .= "\n<script type='text/javascript'>\$(function(){\$('#nss').neosmartStream({path:'".$this->get('nss_root')."'});});</script>\n";
		
		if($echo) echo $data;
		else return $data;
	}
	
/**************************************************************************
 * Test NSS
 **************************************************************************/
 
 	function testNSS(){
		$l = @file_get_contents(NSS_CONFIG_CODE);
		if($l!=md5('nss'.$this->get('license_key').$this->get('license_version').$this->get('license_status'))){
			//die('STOP');
			@unlink(NSS_CONFIG_LICENSE);
			@unlink(NSS_CONFIG_CODE);
			
			$fh = fopen(NSS_CONFIG_ERROR, 'w');	
			fwrite($fh, '1');
			fclose($fh);
			return false;
		}else{
			return true;	
		}
	}
	
/**************************************************************************
 * Little Helpers ...
 **************************************************************************/
 
	function transformDate($date,$format='auto') {
		$time = strtotime($date);
		if($format=='auto') $format = $this->get('date_time_format');
		if($format=='iso'){
			return $date;
		}else{
			return date($format, $time);
		}
	}
	
	function autoLink($string) {
		$pattern = "/(((http[s]?:\/\/)|(www\.))(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
		$string = preg_replace($pattern, " <a href='$1' target='_blank'>$1</a>", $string);
		$string = preg_replace("/href='www/", "href='http://www", $string);
		return $string;
	}
	
	function escapeString($str){
		return htmlspecialchars($str);
	}
	
	function cdata($string){
		if(strlen($string)==0) return '';
		$string = $this->escapeString($string);
		$nl = array('/\r\n/',"/\n/", "/\r/");
		$re = '<br/>';
		return "<![CDATA[".preg_replace($nl,$re,$string)."]]>";
	}
}
?>