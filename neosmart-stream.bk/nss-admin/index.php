<?php
	include "header.inc.php";		
?>	
	<h2>Overview</h2>
	<form class="nss-admin-form" method="post">
		<input type="hidden" name="action" value="update_base_url">
		
		<div class="row">
			<label>Software</label>
			<span class="info">neosmart STREAM <?php echo $update_available; ?></span>
		</div>
		<div class='row'>
			<label>Software url</label>
			<?php if($nss_root==''){ ?>
				<span class="error">Software url is missing! <input type="submit" class="submit" value="Auto-Fill"></span>
			<?php } elseif($nss_root!=getNssRoot()){ ?>
				<span class="error">Software url is wrong! <input type="submit" class="submit" value="Update"></span>
			<?php } else { ?>
				<span class="info"><?php echo $nss_root; ?></span>
			<?php } ?>
		</div>
		<div class="row hl">
			<label>Channels</label><span class="info"><?php echo $channel_count; ?></span>
		</div>
		<div class="row">
			<label>Last cache refresh</label><span class="info"><?php echo $nss->getLastUpdate(); ?></span>
		</div>
		<?php if($channel_count>0){ ?>
		<div class='row '>
			<label>Preview</label>
			<span class="info"><a href="../preview.php" target="_blank">Preview</a></span>
		</div>
		<?php } ?>
		<div class="row hl">
			<label>License</label><span class="info"><?php echo $license_name; ?></span>
		</div>
		<!--div class='row'>
			<label>Status</label><span class="info"><span class="active status"><?php echo $license_status; ?></span></span>
		</div-->
		
		<div class="row">
			<label>Licensee</label><span class="info"><?php echo $license_owner; ?></span>
		</div>
		<div class="row">
			<label>License key</label><span class="info"><?php echo $license_key; ?></span>
		</div>	
		
		<div class="row hl">
			<label>Current site</label><span class="info"><?php echo $_SERVER['HTTP_HOST'];  ?></span>
		</div>
		
		
	</form>
<?php
	include "footer.inc.php";
?>