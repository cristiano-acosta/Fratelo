<?php
	include "header.inc.php";
?>

<h2 id="marker-translation">Password</h2>
<?php if(isset($passwordError)){ ?>
<div class="nss-admin-container error">
	<div class="row">Unsafe password - Please use a stronger one!</div>
</div>
<?php } ?>
<form class="nss-admin-form" method="post">
	<input type="hidden" name="action" value="update_password">
	<?php if(!is_default_password($nss->get('admin_password'))){ ?>
	<div class='nss-admin-form-row'>
		<label>Password</label>
		<input name='old_password' type='password' disabled="disabled" class='text' value='<?php echo $admin_password; ?>'>
	</div>
	<?php } ?>
	<div class='nss-admin-form-row'>
		<label>New password</label>
		<div class="field-area">
			<input name='admin_password' type='password' class='text' value=''>
			<div class="field-info">Use a strong password with letters and numbers. Use more than four characters!</div>
		</div>
	</div>
	<div class='nss-admin-form-row'>
		<input class='submit' type='submit' value='Update Password'>
	</div>
</form>

<?php
	include "footer.inc.php";
?>