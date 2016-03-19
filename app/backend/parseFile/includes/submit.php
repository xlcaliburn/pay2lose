<?php
	include('../../conn_local.php');

	$warInfo = $_POST['warInfo'];
	$date = date('Y-m-d', strtotime(str_replace('/', '-', $warInfo['date'])));

	$dateCheck = mysqli_query($conn,"SELECT * FROM war WHERE date = $date"); 
	if (!$dateCheck) { 
		die('Invalid query: ' . mysqli_error($conn)); 
	} 
	if ($query->num_rows = 0) { 
		$sql = "INSERT INTO war (enemyTag, teamStars, enemyStars, teamPercentage, enemyPercentage, result, date) 
					VALUES ('$warInfo[enemyTag]','$warInfo[teamStars]','$warInfo[enemyStars]','$warInfo[teamPercentage]','$warInfo[enemyPercentage]','$warInfo[result]', '$date')";
		if ( mysqli_query($conn,$sql) ) {
			$warId = mysqli_insert_id($conn);
		}
		else {
			die('Invalid query: ' . mysqli_error($conn));
		}
	} 
	else  {
		die('Error: war record already exists for this day');
	}

	$attackInfo = $_POST['warAttackInfo'];

	foreach($attackInfo as $player) {
		$query = mysqli_query($conn,"INSERT INTO warattack (warid, userid, warWeight, attackNumber, enemyWarWeight, stars, percentage, loot, notes) 
					VALUES ('$warId','$player[playerid]','$player[warWeighct]','$player[attackNumber]','$player[enemyWeight]','$player[stars]', '$player[percentage]', '$player[loot]', '$player[notes]')");
		if (!$query) {
			die('Invalid query: ' . mysqli_error($conn));
		}
	}
?>

	