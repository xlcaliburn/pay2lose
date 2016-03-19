<?php
	include('../conn_local.php');
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>File API</title>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
	<div id="page-wrapper">

		<h1>CSV File Reader</h1>
		<div>
			Select a text file: 
			<input type="file" id="fileInput">
			<button type="button" id="submit" onclick="submit()">Submit</button>
		</div>

		<br>
		<pre id="fileDisplayArea"></pre>
			<div id="canvas-holder">
		</div>

	</div>

	<script>
		var dbUsers = <?php $query = mysqli_query($conn,"SELECT * FROM USER"); if (!$query) { die('Invalid query: ' . mysqli_error($conn)); } $rows = array(); if ($query->num_rows > 0) { while($row = $query->fetch_assoc()) { $rows[] = $row;    } } echo json_encode($rows); ?>;

		function submit() {

			//AJAX code to submit form.
			$.ajax({
				type: "POST",
				url: "includes/submit.php",
				data: {warInfo: warInfo, warAttackInfo: warAttackInfo},
				headers : { 'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8' },
				success: function(html) {
					console.log(html);
					
				},
				error: function(e) {
					console.log(e);
				}
			});
		
			return false;
		}
	</script>
	<script src="includes/parsefile.js"></script>

</body>
</html>

