<?php
	// Include the PHP file that contains the database connection code
	include 'dbconnect.php';
    var_dump($_FILES);

	// Get the full name and uploaded picture from the form data
	$fullname = 'Bea Obias';
	$picture = $_FILES['picture']['name'];

	// Upload the picture to the server and get its file path
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($picture);
	move_uploaded_file($_FILES['picture']['tmp_name'], $target_file);
	$picture_path = $target_file;

	// Update the database with the new picture path
	$query = "UPDATE users_profile SET PROFILE_PIC = '$picture_path' WHERE FULLNAME = '$fullname'";
	if (mysqli_query($conn, $query)) {
		echo "Profile picture uploaded successfully.";
	} else {
		echo "Error uploading profile picture: " . mysqli_error($conn);
        
	}

    
?>
