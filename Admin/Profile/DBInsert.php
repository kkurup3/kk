<?php
$servername = 'localhost';
$username = 'root';
$password = '';

// Create connection
error_reporting(0);
$con = new mysqli($servername, $username, $password, "website");
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
if($_POST['EditUserInfo']){	
	$name=$_POST['Name'];
	$userid=$_POST['userid'];
	$dob = $_POST['DOB'];
	$gender = $_POST['gender'];
	
	$sql = "UPDATE users SET Name='$name', Birthday_Date='$dob', Gender='$gender' WHERE user_id='$userid'";
	$result=mysqli_query($con,$sql);
	if ($result == false) {
		echo "false";
	} else {
		echo "true";
	}
}

?>