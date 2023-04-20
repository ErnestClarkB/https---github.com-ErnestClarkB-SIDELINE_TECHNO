<?php 
    include 'functions.php';
    session_start();
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname =  "sideline";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_data = check_login($conn);
    $fullname = $user_data['FULLNAME'];

    $query = "select * from users_profile where FULLNAME = '$fullname' limit 1";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $image_data = $row['PROFILE_PIC'];

    if ($image_data) {
        // Convert the image data into a format that can be displayed in HTML
        $image_data_base64 = base64_encode($image_data);
        $image_src = "data:image/jpeg;base64," . $image_data_base64;
    } else {
        // Output a local image URL
        $image_src = "assets\img\user-svgrepo-com.svg";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="assets\img\logo.ico">
<title>SideLine</title>
<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<!-- Fonts -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/css/mediumish.css" rel="stylesheet">
</head>
<body>

<!-- Begin Nav
================================================== -->
<nav class="navbar navbar-toggleable-md navbar-dark bg-dark fixed-top mediumnavigation">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="container">
		<!-- Begin Logo -->
		<a class="navbar-brand" href="index.html">
		<img src="./assets/img/logo.png" alt="logo" style="height: 100px; width: 70px;"class="d-inline-block align-top" alt="">
		SideLine 
		</a>
		<!-- End Logo -->
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<!-- Begin Menu -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
				<a class="nav-link" href="home.php">Home<span class="sr-only">(current)</span></a>
				</li>
	
				<li class="nav-item">
				<a class="nav-link" href="jobs.html">Jobs</a>
				</li>
	
				<li class="nav-item">
					<a class="nav-link" href="about.html">About</a>
				</li>
	
				<li class="nav-item">
				<a class="nav-link" href="accounts.php">Account</a>
				</li>
	
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
					</li>
			</ul>
			<!-- End Menu -->
			<!-- Begin Search -->
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="text" placeholder="Search">
				<span class="search-icon"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M20.067 18.933l-4.157-4.157a6 6 0 1 0-.884.884l4.157 4.157a.624.624 0 1 0 .884-.884zM6.5 11c0-2.62 2.13-4.75 4.75-4.75S16 8.38 16 11s-2.13 4.75-4.75 4.75S6.5 13.62 6.5 11z"></path></svg></span>
			</form>
			<!-- End Search -->
		</div>
	</div>
	</nav>
	<!-- End Nav
	================================================== -->
	
<!-- Begin Top Author Page
================================================== -->
<div class="container">
	<div class="row">
        <div class="col-12">
        <section class="col-12">
                    <div class="container col-12">
                        <h1 class="text-center">Profile</h1>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-10 profile-card card rounded-lg shadow p-4 p-xl-5 mb-4 text-center position-relative overflow-hidden" style="margin:auto;">
                                    <div class="banner col-md-10 "></div>
                                    <img src="assets\img\user-svgrepo-com.svg" alt="" class="img-circle mx-auto mb-3" style ="width:100px; height:100px;">
                                    <h3 class="mb-4"><?php echo "{$user_data['FULLNAME']}" ?> </h3>
                                    <div class="text-left mb-4">
                                        <p class="mb-2"><i class="fa fa-envelope mr-2"></i> <?php echo "{$user_data['EMAIL']}" ?></p>
                                        <p class="mb-2"><i class="fa fa-phone mr-2"></i> <?php echo "{$user_data['PHONENUMBER']}" ?></p>
                                        <p class="mb-2"><i class="fa fa-globe mr-2"></i> kiranworkspace.com</p>
                                        <p class="mb-2"><i class="fa fa-map-marker-alt mr-2"></i> <?php
                            // Check if the "Edit" button was clicked
                            if (isset($_GET['edit'])) {
                                // Show the form
                                echo '<h1>Edit Form</h1>';
                                echo '<form method="post" action="process.php">';
                                echo '<label for="description">Description:</label><br>';
                                echo '<input type="text" id="description" name="description"><br>';
                                echo '<input type="submit" name = "edit_description" value="Submit">';
                                echo '</form>';
                            } else {
                                // Show the "Edit" button
                                if(isset($description)){
                                    echo "<span class='author-description'>{$description}/span>";
                                     echo '<a href="?edit">Edit</a>';
                                }else{
                                    echo '<span class="author-description">No description yet</span>';
                                    echo '<a href="?edit">Edit</a>';
                                }
                                
                            }
                            ?> </p>
                                    </div>
                                    <div class="social-links d-flex justify-content-center">
                                        <a href="#!" class="mx-2"><img src="img/social/dribbble.svg" alt="Dribbble"></a>
                                        <a href="#!" class="mx-2"><img src="img/social/facebook.svg" alt="Facebook"></a>
                                        <a href="#!" class="mx-2"><img src="img/social/linkedin.svg" alt="Linkedin"></a>
                                        <a href="#!" class="mx-2"><img src="img/social/youtube.svg" alt="Youtube"></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
	</div>
</div>
<!-- End Top Author Meta
================================================== -->

<!-- Begin Author Posts
================================================== -->
<div class="graybg authorpage">

</div>
<!-- End Author Posts
================================================== -->

<!-- Begin Twitter Timeline
================================================== -->
<div class="container margtop3rem">
<a class="twitter-grid" href="https://twitter.com/TwitterDev/timelines/539487832448843776">WowThemesNet Tweets</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
<!-- End Twitter Timeline
================================================== -->

<!-- Begin Footer
================================================== -->
<div class="container">
	<div class="footer">
	  <p class="pull-left">
	    Copyright &copy; 2017 Your Website Name
	  </p>
	  <p class="pull-right">
	    Mediumish Theme by <a target="_blank" href="https://www.wowthemes.net">WowThemes.net</a>
	  </p>
	<div class="clearfix"></div>
	</div>
</div>
<!-- End Footer
================================================== -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
