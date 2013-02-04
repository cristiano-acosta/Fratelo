<?php
	include "../setup.php";
	$update = $nss->updateRequired() ? 'true' : 'false';
	echo '{"cache_time":'.$nss->get('cache_time').',"channel_count":'.$nss->get('channel_count').',"update":"'.$update.'"}';
?>