<?php
	require_once "ClashAPI/API.class.php";

	include('conn.php');

	$pay2lose = new CoC_Clan("#YUJCLQ8");

	foreach ($pay2lose->getAllMembers() as $clanmember) 
	{
		$member = new CoC_Member($clanmember);
		$name = $member->getName();
		$query = mysqli_query($conn,"INSERT INTO user (username) VALUES ('$name')");
		if (!$query) {
			die('Invalid query: ' . mysqli_error($conn));
		}
	}
?>

	