<?php 
	$no_channel_warning = true;
	include "header.inc.php";
?>

<h2 id="marker-channels">Channels</h2>
<div class="nss-admin-container warning not-saved" style="display:none">
	<div class="row">Your changes are not saved, yet.</div>
</div>
<form id="channels" class="nss-admin-form" method="post">
	<input type="hidden" name="action" value="update_channels">

<?php
$k = 0;
foreach ($nss->get('channel_list') as $channelArray => $channel){
	$type = $channel['type'];
	echo '<div class="nss-admin-channel channel-id-'.$k.'" data-channel="'.$type.'"><h3>'.$type.'</h3>';
	switch($type){
		case 'facebook': /******************************************************************************/ ?>
			<div class='nss-admin-form-row'>
				<label>Id</label>
				<div class="field-area">
					<input type="text" value='<?php echo $channel['id']; ?>' name="id" class="text">
					<div class="field-info">Your Facebook ID</div>
				</div>
			</div>
			<div class='nss-admin-form-row'>
				<label>Access token</label>
				<div class="field-area">
					<input type="text" value="<?php echo $channel['access_token']; ?>" name="access_token" class="text">
					<div class="field-info">To access your Facebook data you have to enter a valid access token.<?php if($nss->get('license_version')=='pro'){ ?>If you have a pro license just use the Access Token Creator.</div>
					<div><a class="button atc-button" data-id="<?php echo $k; ?>" href="javascript://">Open Access Token Creator</a><?php } ?></div>
				</div>
			</div>
			
			<div class='nss-admin-form-row' <?php if(!intval($channel['access_token_expires'])>0){ echo " style='display:none;' "; } ?>>
				<label>Access Token expires</label>
				<div class="field-area">
					<input type="hidden" value="<?php echo $channel['access_token_expires']; ?>" name="access_token_expires">
					<span class="expires_in_real_time"></span>
				</div>
			</div>
			
			<div class='nss-admin-form-row'>
				<label>Limit</label>
				<div class="field-area">
					<input type='text' class='text' name='limit' value='<?php echo $channel['limit'] ?>' style="width:200px;">
					<div class="field-info">How many posts you want to show?</div>
				</div>
			</div>
			<div class='nss-admin-form-row'>
				<label>Show all posts</label>
				<div class="field-area">
					<select name="show_all">
						<option value="true" <?php if($channel['show_all']=='true') echo " selected " ?>>Yes, show all posts!</option>
						<option value="false" <?php if($channel['show_all']!='true') echo " selected " ?>>No, show only my posts!</option>
					</select>
				</div>
			</div>
			<div class='nss-admin-form-row'>
				<label>Status</label>
				<div class="field-area channel-status">
					<?php echo getChannelStatus('facebook',$channel['id']); ?>
				</div>
			</div>
		<?php break;
		case 'twitter': /******************************************************************************/ ?>
			<div class='nss-admin-form-row'>
				<label>Id</label>
				<div class="field-area">
					<input type='text' class='text' name='id' value='<?php echo $channel['id']; ?>'>
					<div class="field-info">Your Twitter ID or screenname</div>
				</div>
			</div>
			<div class='nss-admin-form-row'>
				<label>Limit</label>
				<div class="field-area">
					<input type='text' class='text' name='limit' value='<?php echo $channel['limit'] ?>' style="width:200px;">
					<div class="field-info">How many posts you want to show?</div>
				</div>
			</div>
			<div class='nss-admin-form-row'>
				<label>Status</label>
				<div class="field-area channel-status">
					<?php echo getChannelStatus('twitter',$channel['id']); ?>
				</div>
			</div>
		<?php break;
		case 'nss': /************************************************************************************/ ?>
			<div class='nss-admin-form-row'>
				<label>URL</label>
				<input type='text' class='text' name='url' value='<?php echo $channel['url']; ?>'>
			</div>
			<div class='nss-admin-form-row'>
				<label>Status</label>
				<div class="field-area channel-status">
					<?php
						$id = substr($channel['url'],strrpos($channel['url'],"/")+1);
						$id = urlencode($id);
						echo getChannelStatus('nss',$id);
					?>
				</div>
			</div>
		<?php break;
	}?>
	
		<div class="nss-admin-form-row">
			<span class="nss-admin-test button">Test</span>
			<span class="nss-admin-remove button">Remove</span>
		</div>
	</div>
<?php
$k++;
}
?>
	<div id="add-channel-error" class="nss-admin-container error"></div>
	<div id="nss-admin-add-channel" class="nss-admin-channel <?php echo "channel-id-".$k; ?>" data-channel="new">
		<h3>Add new channel</h3>
		<div class='nss-admin-form-row'>
			<label>Choose channel</label>
			<select id="new-channel-type" name="new_channel_type" class="nss-admin-new-channel-type">
				<option value="">- choose -</option>
				<option value="facebook">Facebook</option>
				<option value="twitter">Twitter</option>
				<option value="nss">NSS</option>
			</select>
			
		</div>
		<div id="nss-admin-add-channel-facebook" class="new-channel-container">
			<input type="hidden" name="limit" value="3">
			<input type="hidden" name="show_all" value="true">
			<div class="nss-admin-form-row hl">
				<label>Id</label>
				<div class="field-area">
					<input type="text" value="" name="id" class="text">
					<div class="field-info">Your Facebook Id</div>
				</div>
			</div>
			<div class="nss-admin-form-row">
				<label>Access token</label>
				<div class="field-area">
					<input type="text" value="" name="access_token" class="text">
					<div class="field-info">To access your facebook data you have to enter a valid access token.<?php if($nss->get('license_version')=='pro'){ ?>If you have a pro license just use the Access Token Creator.</div>
					<div><a class="button atc-button" data-id="<?php echo $k; ?>" href="javascript://">Open Access Token Creator</a><?php } ?></div>
				</div>
			</div>
			<div class="nss-admin-form-row" style="display:none">
				<label>Access token expires</label>
				<div class="field-area">
					<input type="hidden" name="access_token_expires" class="text"> <span class="expires_in_real_time"></span>
				</div>
			</div>
			
			<div class="nss-admin-form-row hl">
				<span class="nss-admin-add-channel button">Add channel</span>
			</div>
		</div>
		
		<div id="nss-admin-add-channel-twitter" class="new-channel-container">
			<input type="hidden" name="limit" value="3">
			<div class="nss-admin-form-row hl">
				<label>Id</label>
				<div class="field-area">
					<input type="text" value="" name="id" class="text">
					<div class="field-info">Your Twitter ID or screenname</div>
				</div>
			</div>			
			<div class="nss-admin-form-row hl">
				<span class="nss-admin-add-channel button">Add channel</span>
			</div>
		</div>
		
		<div id="nss-admin-add-channel-nss" class="new-channel-container">
			<input type="hidden" name="limit" value="3">
			<div class="nss-admin-form-row hl">
				<label>URL</label>
				<div class="field-area">
					<input type="text" value="" name="url" class="text">
					<div class="field-info">Absolute URL to your NSS channel</div>
				</div>
			</div>			
			<div class="nss-admin-form-row hl">
				<span class="nss-admin-add-channel button">Add channel</span>
			</div>
		</div>
		
		
	</div>
	<div class='nss-admin-form-row'>
		<a id="cancel-3" href='?cancel=3#marker-channels' class='cancel button'>Cancel changes</a>
		<a id='save-channels' class='submit' href='#channel-start'>Save channels</a>
	</div>
</form>

<?php include "footer.inc.php"; ?>