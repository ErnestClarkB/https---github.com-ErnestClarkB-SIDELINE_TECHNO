
<!DOCTYPE html>
<html>
<head>
	<title>Profile Picture</title>
</head>
<body>
	<h1>Profile Picture</h1>
	<?php
		// Include the PHP file that contains the database connection code
		include 'dbconnect.php';

		// Get the full name from the URL parameter
		$fullname = 'Bea Obias';

		// Query the database to check if there is a profile picture for this full name
		$query = "SELECT PROFILE_PIC FROM users_profile WHERE FULLNAME = '$fullname'";
		$result = mysqli_query($conn, $query);

		// If there is a profile picture, display it; otherwise, display the default image
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo '<img src="' . $row['PROFILE_PIC'] . '" alt="Profile Picture">';
		} else {
			echo '<img src="assets\img\default-img.jpg" alt="Default Profile Picture">';
		}
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="fullname" value="<?php echo $fullname ?>">
		<input type="file" name="picture">
		<input type="submit" value="Upload">
	</form>
</body>
</html>
