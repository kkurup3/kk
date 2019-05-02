<?php 
session_start();

$recipient =  $_POST['recipient'];
$message =  $_POST['message'];

if( $recipient != null  )
{
  	// Create connection
	$conn = mysqli_connect("localhost", "root", "", "website");
	$username = $_SESSION['user_id'];
	$sent = date("M-d-Y h:i:s A"); 
	$sent_reformat = date("MdYhisA"); 
	$message_id = $username.$recipient.$sent_reformat;
	$query = "INSERT INTO user_messages (message_id, user_id, sender_id, message_content, sent, thread) VALUES ('$message_id', '$recipient', '$username', '$message', '$sent', '$message')";
	

	
	if (mysqli_query($conn, $query)) {
		header( "Location:messages.php" );
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($conn);
	}


	exit();
} else {
	header( "Location:messages.php" );
	exit();
}
?>