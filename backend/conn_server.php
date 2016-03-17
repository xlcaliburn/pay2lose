<?php 
	$servername = "xlcaliburncom.ipagemysql.com";
	$username = "caliburn";
	$password = "Michael5";
	$dbname = "pay2lose";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
		
?>