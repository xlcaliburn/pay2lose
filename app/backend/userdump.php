<?php
	require_once "ClashAPI/API.class.php";

	include('conn_server.php');

	$pay2lose = new CoC_Clan("#YUJCLQ8");

	$query = mysqli_query($conn,"SELECT * FROM user"); 
	if (!$query) { 
		die('Invalid query: ' . mysqli_error($conn)); 
	} 
	$existing = array(); 
	if ($query->num_rows > 0) { 
		while($row = $query->fetch_assoc()) { 
			$existing[] = $row['username'];
		} 
	} 
	
	foreach ($pay2lose->getAllMembers() as $clanmember) 
	{
		$member = new CoC_Member($clanmember);
		$name = $member->getName();

		if( !in_array($name, $existing))
		{
			$query = mysqli_query($conn,"INSERT INTO user (username) VALUES ('$name')");
			if (!$query) {
				die('Invalid query: ' . mysqli_error($conn));
			}			
		}
	}
?>

	