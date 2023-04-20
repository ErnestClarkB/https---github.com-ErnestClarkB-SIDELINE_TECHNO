<!-- test.php -->
<?php
$myCondition = true;

if ($myCondition) {
	$style = "background-color: green;";
} else {
	$style = "background-color: red;";
}
?>

.default-style {
	<?php echo $style; ?>
}
