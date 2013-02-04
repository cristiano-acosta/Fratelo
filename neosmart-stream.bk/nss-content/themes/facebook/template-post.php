<?php
$out .= <<<EOD
	<article id="nss-item-$position" class="nss-item nss-$channel">
		<div id="time-stamp">
					<h1><span>$created h</span></h1>
		</div>
		<div id="content">
			$content
EOD;

switch($extras_facebook_type){
	case 'photo':
		//$out .= "<a href='$extras_facebook_link' target='_blank'><img class='nss-facebook-picture' src='$extras_facebook_picture' alt='' border='0'></a>";
		//$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		//$out .= "<div class='nss-facebook-caption'>$extras_facebook_caption</div>";
		//$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		$out .= "
		<div class='nss-facebook-message'>
			<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_message, 0, 50)."</a>
		</div>";

		$out .= "
			<div class='nss-facebook-question nss-facebook-story'>
				<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_story, 0, 50)."</a>
			</div>";
	break;
	case 'video':
		//$out .= "<iframe class='nss-facebook-video' width='400' height='300' src='$extras_facebook_source'></iframe>";
		//$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		$out .= "
			<div class='nss-facebook-message'>
				<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_message, 0, 50)."</a>
			</div>";
	break;
	case 'link':
		$out .= "
			<div class='nss-facebook-message'>
				<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_message, 0, 50)."</a>
			</div>";
		//$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		//$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		//if($extras_facebook_picture) $out .= "<a href=\"$extras_facebook_link\" target='_blank'><img class='nss-facebook-picture' src='$extras_facebook_picture' alt=\"$extras_facebook_link\" border='0'></a>";
		//else $out .= "<a class='nss-facebook-link' href='$extras_facebook_link'	target='_blank'>$extras_facebook_link</a>";
	break;
	case 'status':
		//$out .= "<div class='nss-facebook-status nss-facebook-story'>$extras_facebook_story</div>";
		//$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		$out .= "
			<div class='nss-facebook-message'>
				<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_message, 0, 50)."</a>
			</div>";
	break;
	case 'question':
		$out .= "
		<div class='nss-facebook-question nss-facebook-story'>
			<a href='$extras_facebook_link' target='_blank'>".substr($extras_facebook_story, 0, 50)."</a>
			</div>";
	break;
}

if($extras_facebook_count_comments>0){
$out .= <<<EOD
		<div class="clear"></div>
	</div>
EOD;
}

$out .= <<<EOD
			\n\t</article>\n\t
EOD;

?>