<?php
	//include('../../conn_local.php');

	$warInfo = $_POST['warInfo'];
	$date = date('Y-m-d', strtotime(str_replace('/', '-', $warInfo['date'])));

	// $query = mysqli_query($conn,"INSERT INTO war (enemyTag, teamStars, enemyStars, teamPercentage, enemyPercentage, result, date) 
	// 			VALUES ('$warInfo[enemyTag]','$warInfo[teamStars]','$warInfo[enemyStars]','$warInfo[teamPercentage]','$warInfo[enemyPercentage]','$warInfo[result]', '$date')");
	// if (!$query) {
	// 	die('Invalid query: ' . mysqli_error($conn));
	// }
	
	$teamInfo = $_POST['teamInfo'];
	$enemyInfo = $_POST['enemyInfo'];

	$query = mysqli_query($conn,"SELECT * FROM USER");
	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}

	$userTable = array();

	if ($query->num_rows > 0)
	{
		while($row = $query->fetch_assoc()) {
			$userTable[] = $row;
   		}
	}

	$userMatchedTable = array();

	foreach($teamInfo as $player){
		foreach($userTable as $userPlayer) {
			if ($player['player'] == $userPlayer['username']){
				echo $userPlayer['username'];
				$userMatchedTable[$player['rank']] = $userPlayer['userid'];
				break;
			} 

		}
	}
			foreach($userMatchedTable as $p) {
				echo $p.": ".$userTable[$p['id']]."\n";
		}

	// $query = mysqli_query($conn,"INSERT INTO war (enemyTag, teamStars, enemyStars, teamPercentage, enemyPercentage, result, date) 
	// 			VALUES ('$warInfo[enemyTag]','$warInfo[teamStars]','$warInfo[enemyStars]','$warInfo[teamPercentage]','$warInfo[enemyPercentage]','$warInfo[result]', '$date')");
	// if (!$query) {
	// 	die('Invalid query: ' . mysqli_error($conn));
	// }

?>

	