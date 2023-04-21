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
    $description = $row['DESCRIPTION'];
    $email = $user_data['EMAIL'];
    $phonenumber = $user_data['PHONENUMBER'];

    if ($image_data) {
        // Convert the image data into a format that can be displayed in HTML
        $image_data_base64 = base64_encode($image_data);
        $image_src = "data:image/jpeg;base64," . $image_data_base64;
    } else {
        // Output a local image URL
        $image_src = "assets\img\user-svgrepo-com.svg";
    }

    if (isset($_POST['logout'])) {
        // destroy the session
        session_destroy();
    
        // redirect the user to the login page
        header("Location: login.php");
        exit;
    }

    if (isset($_POST['edit_description'])) {
        // destroy the session
        $new_description = $_POST['description'];

        // Prepare an SQL statement to update the description column
        $sql = "UPDATE `users_profile` SET `DESCRIPTION`='$new_description' WHERE FULLNAME = '$fullname'";

        // Execute the SQL statement
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // If the update was successful, display a success message
            $description = $new_description;
        } else {
            // If the update failed, display an error message
            echo "Error updating description: " . mysqli_error($conn);
        }
        
    }

    if (isset($_POST['edit_contact'])) {
        // destroy the session
        $new_phonenumber = $_POST['number'];
        $new_email = $_POST['email'];

        // Prepare an SQL statement to update the description column
        $sql = "UPDATE `users_sideline` SET `PHONENUMBER`='$new_phonenumber',`EMAIL`='$new_email' WHERE FULLNAME = '$fullname'";

        // Execute the SQL statement
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // If the update was successful, display a success message
            $phonenumber = $new_phonenumber;
            $email = $new_email;

            header("Location: account.php?update=email and phone ");
            exit;
        } else {
            // If the update failed, display an error message
            echo "Error updating description: " . mysqli_error($conn);
        }
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
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
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
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-10 profile-card card rounded-lg shadow p-4 p-xl-5 mb-4 text-center position-relative overflow-hidden" style="margin:auto;">
                                    <div class="banner col-md-10 "></div>
                                    <img src="assets\img\user-svgrepo-com.svg" alt="" class="img-circle mx-auto mb-3" style ="width:100px; height:100px;">
                                    <h3 class="mb-4"><?php echo "{$user_data['FULLNAME']}" ?> </h3>
                                    <div class="text-center mb-4">
                                        <hr class="border">
                                        <div>
                                            <?php
                                                if (isset($_GET['edit_contact'])) 
                                                {
                                                    // Show the form
                                                    echo "<form method='post' action='account.php'>";
                                                    echo "<input type='email' placeholder='email' name='email'>";
                                                    echo "<input type='number' placeholder='number' name='number'>";
                                                    echo "<input type='submit' name='edit_contact' value='edit'>";
                                                    echo '</form>';
                                                    
                                                } else {
                                                    if(isset($user_data['EMAIL']) && $user_data['PHONENUMBER']){
                                                    echo "<p class='inline border-left border-right' style='display: inline-block; margin:10px'><i class='fa fa-envelope'></i> {$user_data['EMAIL']}</p>";
                                                    echo '<a class="float-right mr-4 mb-10" style ="font-size:10px;"  href="?edit_contact" > <i class="fa fa-pencil"></i></a><br>';
                                                    echo "<p class='inline' style='display: inline-block; margin:10px'><i class='fa fa-phone '></i> {$user_data['PHONENUMBER']}</p>";
                                                    echo '<a class="float-right mr-4 mb-10" style ="font-size:10px;"  href="?edit_contact"> <i class="fa fa-pencil"></i></a><br>';
                                                }else{
                                                        echo '<span class="author-description">No description yet</span>';
                                                        echo '<a class="float-right mr-4 mb-10" style ="font-size:10px;"  href="?edit_contact"> <i class="fa fa-pencil"></i></a><br>';
                                                    }

                                                }
                                            ?>
                                        </div>
                                        <hr class="border">
                                        <div class="user_description" 
                                        style ="
                                                background: #E4DCCF;
                                                padding:10px;
                                                border-radius:20px;

                                            "><?php
                            // Check if the "Edit" button was clicked
                            if (isset($_GET['edit'])) {
                                // Show the form
                                echo '<form method="post" action="account.php">';
                                echo '<label for="description" style="text-align:left;">About Me:</label><br>';
                                echo '<textarea style="width:80%;margin:20px 20px;"rows="5" id="description" name="description"></textarea><br>';
                                echo '<input type="submit" name="edit_description" value="Submit">';
                                echo '</form>';
                                
                            } else {
                                // Show the "Edit" button
                                if(isset($description)){
                                    echo "<p> About Me: </p>";
                                    echo "<span style='font-size: 20px;'class='author-description font-italic'>{$description}</span><br>";
                                    echo '<a class="float-right mr-4 mb-10" style ="font-size:10px;"  href="?edit">Edit <i class="fa fa-pencil"></i></a><br>';
                                }else{
                                    echo '<span class="author-description">No description yet</span>';
                                    echo '<a class = "edit_des" href="?edit">Edit</a><br>';
                                }
                                
                            }
                            ?> </div>
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

<div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true" style = "" >
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4>Log Out <i class="fa fa-lock"></i></h4>
      </div>
      <div class="modal-body">
        <p><i class="fa fa-question-circle"></i> Are you sure you want to log-off? <br /></p>
        <div class="actionsBtns">
            <form action="account.php" method="POST">
                <input type="hidden" name="logout" value="1">
                <button type="submit" class="btn red lighten-2" style ="color:#fff;">Logout</button>
                <a href="#!" class="btn modal-close" style ="color:#fff;">Cancel</a>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

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
