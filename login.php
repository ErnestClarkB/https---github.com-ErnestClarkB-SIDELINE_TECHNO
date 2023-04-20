<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname =  "sideline";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_error = false;

		// Check if form is submitted
    if (isset($_POST['submit'])) {
        // Get form data
        $fullname = $_POST['FULLNAME'];
        $username = $_POST['USERNAME'];
        $phonenumber = $_POST['PHONENUMBER'];
        $email = $_POST['EMAIL'];
        $password = $_POST['PASSWORD'];
        $confirmpassword = $_POST['CONFIRMPASSWORD'];
        $gender = $_POST['GENDER'];
        

        $sql = "SELECT * FROM users_sideline WHERE EMAIL='$email'";
        $result = $conn->query($sql);
        if ($password != $confirmpassword){
          
          header("Location: login.php?error=password doesnt match");
        }else{
          if ($result->num_rows > 0) {
            // Email already exists
            $user_error = true;
            header("Location: login.php?error=email already exist");
          } else {
            $sql = "INSERT INTO users_sideline (FULLNAME, USERNAME, PHONENUMBER,EMAIL,PASSWORD,GENDER)
            VALUES ('$fullname', '$username', '$phonenumber','$email','$password','$gender')";
            $sql = "INSERT INTO users_profile (FULLNAME)
            VALUES ('$fullname')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
        }

        

        
    }
    if (isset($_POST['login'])) {
      if (isset($_POST['login_user']) && isset($_POST['login_password'])) {
        $login_user = $_POST['login_user'];
        $login_password = $_POST['login_password'];
      
        // Query the database for the user with the matching email and password
        $sql = "SELECT * FROM users_sideline WHERE  USERNAME='$login_user' AND PASSWORD='$login_password'";
        $result = mysqli_query($conn, $sql);

        // Check if a row was returned (i.e. the email and password matched)
        if (mysqli_num_rows($result) > 0) {
          // Login successful, redirect to the dashboard or homepage
          session_start();
          $_SESSION['username'] = $login_user;
          $_SESSION['password'] = $login_password;
          
          header("Location: home.php");
          exit();
        } else {
          // Login failed, redirect back to the login page with an error message in the URL
          header("Location: login.php?login_error=invalid_login");
          exit();
        }
      }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login new</title>
    <link rel="stylesheet" href ="login_style.css">
</head>
<body>
    <div class="container" id="container">
  
      <div class="form-container register-container">
        
        <form class = "form-register" action="login.php" method="post">
          <h1>Register here.</h1>
          <p class ="error">
          <?php 
            $current_url = $_SERVER['REQUEST_URI'];
            if (isset($_GET['error'])) {
              $error = $_GET['error'];
              // do something with the error value, like display an error message
              if (isset($error)){
                echo $error;
              }
            }?></p>
          <div class="reg_cont">
                <div class="reg_item">
                    <input class="register_input" name="FULLNAME" type="text" placeholder="Fullname" required>
                </div>
                <div class="reg_item">
                    <input class="register_input" name="USERNAME" type="text" placeholder="Username" required>
                </div>
                <div class="reg_item">
                    <input class="register_input" name="PHONENUMBER" type="text" placeholder="Phonenumber" required >
                </div>
                <div class="reg_item">
                    <input type="email" name="EMAIL" placeholder="Email" required>
                </div>
                <div class="reg_item">
                    <input type="password" name="PASSWORD" placeholder="Password" required>
                </div>
                <div class="reg_item">
                    <input type="password" name="CONFIRMPASSWORD" placeholder="Confirm Password" required>
                </div>
                <div class="reg_gender">
                    <span class="gender-title">Gender</span>
                    <div class="gender-category">
                      <input type="radio" name="GENDER" value="m" id="male">
                      <label for="male">Male</label>
                      <input type="radio" name="GENDER" value="f" id="female">
                      <label for="female">Female</label>
                      <input type="radio" name="GENDER" value="o" id="other">
                      <label for="other">Other</label>
                    </div>
                </div>
                
            </div>
            <input type="submit" name = "submit" class="register_button" value="register">
            <h6>By clicking register button your agree to our <br> <a>Terms and Conditions</a></h6>
        </form>
      </div>
  
      <div class="form-container login-container">
        <form class = "form-login" action="login.php" method="post">
          <h1>Login here.</h1>
          <p class ="error">
          <?php 
            $current_url = $_SERVER['REQUEST_URI'];
            if (isset($_GET['login_error'])) {
              $error = $_GET['login_error'];
              // do something with the error value, like display an error message
              if (isset($error)){
                echo $error;
              }
            }?></p>
          <input type="username" placeholder="Username" name ="login_user">
          <input type="password" placeholder="Password" name ="login_password">
          <div class="content">
            <div class="checkbox">
              <input type="checkbox" name="checkbox" id="checkbox">
              <label>Remember me</label>
            </div>
            <div class="pass-link">
              <a href="#">Forgot password?</a>
            </div>
          </div>
          <button type = "submit" name = "login" class="login_button">Login</button>
        </form>
      </div>
  
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1 class="title">Hello <br> there</h1>
            <p>if your already have an account, login here</p>
            <button class="ghost" id="login">Login
              <i class="lni lni-arrow-left login"></i>
            </button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1 class="title">Be one <br> of us now</h1>
            <p>if you don't have an account yet, join us and start your journey.</p>
            <button class="ghost" id="register">Register
              <i class="lni lni-arrow-right register"></i>
            </button>
          </div>
        </div>
      </div>
  
    </div>
  
    <script src="login.js"></script>
  
  </body>
</html>