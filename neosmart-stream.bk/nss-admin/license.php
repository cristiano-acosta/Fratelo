<?php
	include "header.inc.php";
?>
	<h2 id="marker-translation">License</h2>	
	
	<form class="nss-admin-form" method="post">
		<input type="hidden" name="action" value="refresh_license_key">
		<input type="hidden" name="license_key" value="<?php echo $license_key; ?>">
		<div class="row">
			<label>License</label><span class="info"><?php echo $license_name; ?></span>
		</div>
		<!--div class="row">
			<label>Status</label><span class="info"><?php echo $license_status; ?></span>
		</div-->
		<div class="row">
			<label>Licensee</label><span class="info"><?php echo $license_owner; ?></span>
		</div>
		<div class="row">
			<label>License key</label><span class="info"><?php echo $license_key; ?></span>
		</div>
		<div class='nss-admin-form-row'>
			<a href='?delete=key' class='cancel button'>Remove key</a>
		</div>
	</form>
	
<?php
	include "footer.inc.php";
?>