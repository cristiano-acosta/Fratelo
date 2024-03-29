<?php
$out .= <<<EOD
	<div id="nss-item-$position" class="nss-item nss-$channel">
		<div class="nss-head">
			<a href="$author_link" class="nss-author-avatar" target="_blank"><img src="$author_avatar" alt="$author_name" width="32" height="32"></a>
			<a href="$author_link" class="nss-author-name" target="_blank">$author_name</a>
			<span class="nss-created">$created</span>	
		</div>
		<div class="nss-body">
			<div class="nss-content">$content
EOD;

switch($extras_facebook_type){
	case 'photo':
		$out .= "<a href='$extras_facebook_link' target='_blank'><img class='nss-facebook-picture' src='$extras_facebook_picture' alt='' border='0'></a>";
		$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		$out .= "<div class='nss-facebook-caption'>$extras_facebook_caption</div>";
		$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		$out .= "<div class='nss-facebook-message'>$extras_facebook_message</div>";
		$out .= "<div class='nss-facebook-question nss-facebook-story'>$extras_facebook_story</div>";
	break;
	case 'video':
		$out .= "<iframe class='nss-facebook-video' width='400' height='300' src='$extras_facebook_source'></iframe>";
		$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		$out .= "<div class='nss-facebook-message'>$extras_facebook_message</div>";
	break;
	case 'link':
		$out .= "<div class='nss-facebook-message'>$extras_facebook_message</div>";
		$out .= "<div class='nss-facebook-name'>$extras_facebook_name</div>";
		$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		if($extras_facebook_picture) $out .= "<a href=\"$extras_facebook_link\" target='_blank'><img class='nss-facebook-picture' src='$extras_facebook_picture' alt=\"$extras_facebook_link\" border='0'></a>";
		else $out .= "<a class='nss-facebook-link' href='$extras_facebook_link' target='_blank'>$extras_facebook_link</a>";
	break;
	case 'status':
		$out .= "<div class='nss-facebook-status nss-facebook-story'>$extras_facebook_story</div>";
		$out .= "<div class='nss-facebook-description'>$extras_facebook_description</div>";
		$out .= "<div class='nss-facebook-message'>$extras_facebook_message</div>";
	break;
	case 'question':
		$out .= "<div class='nss-facebook-question nss-facebook-story'>$extras_facebook_story</div>";
	break;
}

if($extras_facebook_count_comments>0){
$out .= <<<EOD
	<div class="nss-facebook-comments">
		<div class="nss-facebook-count-comments">Comments: $extras_facebook_count_comments</div>
		$extras_facebook_comments
	</div>
EOD;
}

$out .= <<<EOD
			</div>
		</div>
		<div class="nss-clean"></div>
	</div>
EOD;

?>