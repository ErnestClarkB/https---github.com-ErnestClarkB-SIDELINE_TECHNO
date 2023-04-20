<!DOCTYPE html>
<html>
<head>
	<title>Change Style with PHP</title>
	<style>
		.default-style {
			<?php
			$myCondition = true;

			if ($myCondition) {
				echo "background-color: green;";
			} else {
				echo "background-color: red;";
			}
			?>
		}
	</style>
</head>
<body>
	<div class="default-style">
		This is a div element with a dynamically changed style.
	</div>
</body>
</html>
