<?php
	include "header.inc.php";
	
	//Themes
	$themes = scandir('../nss-content/themes');
	
?>

	<h2 id="marker-config">Configuration</h2>
	<form class="nss-admin-form" method="post">
		<input type="hidden" name="action" value="update_config">
		<input type='hidden' name='nss_root' value='<?php echo getNssRoot(); ?>'>
		<div class='row'>
			<label>Debug mode</label>
			<div class="field-area">
				<select name='debug_mode'>
					<option value="on" <?php if($debug_mode===true) echo "selected='selected'"; ?>>On</option>
					<option value="off" <?php if($debug_mode!==true) echo "selected='selected'"; ?>>Off</option>
				</select>
				<div class="field-info">If debug mode is on, you see warnings and errors on top of your neosmart STREAM implementation.</div>
			</div>
		</div>
		<div class='row hl'>
			<label>Cache time</label>
			<div class="field-area">
				<input name='cache_time' type='text' class='text' value='<?php echo $cache_time; ?>'>
				<div class="field-info">Time to wait in seconds, before neosmart STREAM trys to refresh the cache.</div>
			</div>
		</div>
		<div class='row hl'>
			<label>Date format</label>
			<div class="field-area">
				<input name='date_time_format' type='text' class='text' value='<?php echo $date_time_format; ?>'>
				<div class="field-info">Here you can change the date/time format. Check out the <a href="http://php.net/manual/de/function.date.php" target="_blank">PHP date manual</a>.</div>
			</div>
		</div>
		<div class='row hl'>
			<label>Theme</label>
			<div class="field-area">
				<select name='theme'>
				<?php
					foreach ($themes as $key => $value){
						if($value!='.'&&$value!='..'){
							$selected = $value == $theme ? ' selected="selected"' : '';
							echo "<option $selected value='".$value."'>".$value."</option>";	
						}
					}
				?>
				</select>
				<div class="field-info">The theme of your NSS implementation.</div>
			</div>
		</div>
		<div class='row hl'>
			<a id='cancel-1' href='<?php echo $_SERVER['PHP_SELF']; ?>' class='cancel button'>Cancel changes</a>
			<input class='submit' type='submit' value='Save Configuration'>
		</div>
	</form>
	
	<h2 id="marker-reset">Total reset</h2>
	<form class="nss-admin-form" method="post">
		<input type="hidden" name="action" value="total_reset">
		<div class='row'>
			<label>Action</label>
			<div class="field-area">
				Deactivate license key for this site, delete all configuration files, all channels and all cache files (delivery status)
				<div class="field-info">CAUTION: Process can not be undone!</div>
			</div>
		</div>
		<div class='row hl'>
			<input class='submit' type='submit' value='Total Reset'>
		</div>
	</form>
	
<?php
	include "footer.inc.php";
?>