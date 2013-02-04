<?php
	
	include "../setup.php";
	include "functions.php";
	if(!is_logged_in($nss)){ die;}
	
	$channel = array_key_exists('channel',$_REQUEST) ? $_REQUEST['channel'] : '';
	$url = array_key_exists('url',$_REQUEST) ? $_REQUEST['url'] : '';
	$id = array_key_exists('id',$_REQUEST) ? $_REQUEST['id'] : '';
	$token = array_key_exists('token',$_REQUEST) ? $_REQUEST['token'] : '';
	
	switch($channel){
		case 'facebook': /*****************************************************************************/
			$graph = "https://graph.facebook.com/".$id."/posts?limit=1&access_token=".$token;
			
			$data = $nss->readData($graph);
			
			if($data == 'error') saveChannelTestToFile('facebook',$id,'error');
			$fbdata = @json_decode($data);
			if(isset($fbdata->{'error'})) saveChannelTestToFile('facebook',$id,'error');
			
			saveChannelTestToFile('facebook',$id,'success');
			
		break;
		case 'twitter': /*****************************************************************************/
			
			$tweet = @simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline.xml?include_rts=true&screen_name=".$id."&count=1");
			if($tweet || count($tweet)>0){
				if(isset($tweet->status) && $tweet->status->user->screen_name == $id)
					saveChannelTestToFile('twitter',$id,'success');
			}
			
			$tweet = @simplexml_load_file("http://api.twitter.com/1/statuses/user_timeline.xml?include_rts=true&id=".$id."&count=1");
			if($tweet || count($tweet)>0){
				if(isset($tweet->status) && $tweet->status->user->id == $id)
					saveChannelTestToFile('twitter',$id,'success');
			}
			saveChannelTestToFile('twitter',$id,'error');
			
		break;
		case 'nss': /*****************************************************************************/
			
			$nss_file = @simplexml_load_file($url);
			$id = substr($url,strrpos($url,"/")+1);
			$id = urlencode($id);
			if(isset($nss_file[0]->item[0]->channel)){
				saveChannelTestToFile('nss',$id ,'success');
			}else{
				saveChannelTestToFile('nss',$id ,'error');
			}
			
		break;	
	}
	
	function saveChannelTestToFile($type,$id,$status){
		global $nss;
		$data = $nss->saveChannelTestToFile($type,$id,$status);
		
		die($data);
	}
	
?>