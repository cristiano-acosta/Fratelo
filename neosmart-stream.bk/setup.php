<?php
	include 'define.php';		
	include NSS_ABSPATH."nss-core/NeosmartStream.php";
	
	$nss = new NeosmartStream();
	
	@include NSS_ABSPATH."nss-config/nss-config.php";
	@include NSS_ABSPATH."nss-config/nss-channels.php";
	@include NSS_ABSPATH."nss-config/nss-translate.php";
	@include NSS_ABSPATH."nss-config/nss-license.php";
	@include NSS_CONFIG_BASE_URL;
?>