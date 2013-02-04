<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<title>neosmart STREAM Preview</title>
	<?php
		include "setup.php";
		$nss->getHead();
	?>
</head>

<body id="nss-preview">

	<div id="nss-preview-container">
		<h1>Preview</h1>
		<div id="nss">
			<?php
				$nss->show();
			?>
		</div>
	</div>
</body>
</html>