<?php
$firstName = $_POST['fullName'];
$username = $_POST['username'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$phoneNumber = $_POST['phoneNumber'];
$confirmPassword = $_POST['confirmPassword'];
//Database connection

$conn = new mysqli('localhost', 'root', '' , 'test_sideline')
if($conn->connect_error){
	die('Connection Failed : ' .$conn->connect_error);
}else{
		$stmt = $conn->prepare("insert into registartion (fullName, username, gender, email, password, confirmPassword, phoneNumber)
			values(?,?,?,?,?,?,?)");
		$stmt->bind_param("ssssssi", $fullName, $username, $gender, $email, $password, $confirmPassword, $phoneNumber);
		$stmt->execute();
		echo "registration Successfully.... ";
		$stmt->close();
		$conn->close();
	}

?>