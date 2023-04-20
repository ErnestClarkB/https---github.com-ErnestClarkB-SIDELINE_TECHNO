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
    echo "{$user_data['FULLNAME']}";
?>