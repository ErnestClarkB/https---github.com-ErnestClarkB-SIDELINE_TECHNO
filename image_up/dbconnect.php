<?php
	// Replace with your database credentials
	$dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname =  "sideline";


	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
