var file;
var warInfo, teamInfo, enemyInfo;
window.onload = function() {

	var fileInput = document.getElementById('fileInput');
	var fileDisplayArea = document.getElementById('fileDisplayArea');

	fileInput.addEventListener('change', function(e) {
		file = fileInput.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			var sections = reader.result.split(/@War.+|@Clan.+|@Enemy.+/);

			warInfo = parseWarInfo(sections[1]);
			teamInfo = parseTeamInfo(sections[2]);
			enemyInfo = parseEnemyInfo(sections[3]);

			fileDisplayArea.innerHTML = parseFile(sections[1]) + parseFile(sections[2]) + parseFile(sections[3]);
		}	

		reader.readAsText(file);	
	});
}

function parseFile(input) {
	var lines = input.split('\n');
	var header = lines[1].split(',');
	
	var tableHead = '';
	for (var k = 0; k < header.length; k++) {
			tableHead += '<td>'+header[k]+'</td>';
	}

	var tableBody = '';
	for(var i = 2; i < lines.length; i++) {
		var col = lines[i].split(',');
		if (col[0] != '')
		{
			tableBody += '<tr>';
			for (var j = 0; j < col.length; j++)
			{
				tableBody += '<td>' + col[j] + '</td>';
			}
			tableBody += '</tr>';
		}
	}

	var table = '<table class="table"><thead>'+tableHead+'</thead><tbody>' + tableBody + '</tbody></table>';

	return table;
}

function parseWarInfo(input) {
	var date, result, teamStars, teamPercentage, enemyStars, enemyPercentage, warSize, enemyTag;
	var warInfo = {};

	var lines = input.split('\n');
	var data = lines[2].split(',');
	date = data[0];
	if (data[1] == "Win") {result = 1;}
	else if (data[1] == "Loss") {result = 0;}
	else if (data[1] == "Tie") {result = -1; }

	teamStars = parseInt(data[2]);
	teamPercentage = parseFloat(data[3]);
	enemyStars = parseInt(data[4]);
	enemyPercentage = parseFloat(data[5]);
	warSize = parseInt(data[6]);
	enemyTag = data[7];

	if (data[0] != '')
	{
		warInfo = {
			"date": date,
			"result": result,
			"teamStars": teamStars,
			"teamPercentage": teamPercentage,
			"enemyStars": enemyStars,
			"enemyPercentage": enemyPercentage,
			"warSize": warSize,
			"enemyTag": enemyTag
		}
	}

	return warInfo;
}

function parseTeamInfo(input) {

    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() {

    	console.log(this);

    };
    oReq.open("get", "index.php", true);
    //                               ^ Don't block the rest of the execution.
    //                                 Don't wait until the request finishes to 
    //                                 continue.
    oReq.send();




	var rank, player, warWeight, enemyRank, stars, percentage, loot, notes;
	var teamInfo = [];

	var lines = input.split('\n');
	var data = lines[2].split(',');

	for(var i = 2; i < lines.length; i++) {
		var data = lines[i].split(',');
		if (data[0] != '')
		{
			rank = parseInt(data[0]);
			player = data[1];
			warWeight = parseInt(data[2]);
			enemyRank = parseInt(data[3]);

			stars1= parseInt(data[4]);
			percentage1 = parseFloat(data[5]);
			loot1 = parseInt(data[6]);
			notes1= data[7];
			
			stars2= parseInt(data[8]);
			percentage2 = parseFloat(data[9]);
			loot2 = parseInt(data[10]);
			notes2= data[11];	

			var attack1 = {
				"rank": rank, 
				"player": player, 
				"warWeight": warWeight,
				"enemyRank": enemyRank,
				"attackNumber": 1,
				"stars": stars1,
				"percentage": percentage1,
				"loot": loot1,
				"notes": notes1
			}

			var attack2 = {
				"rank": rank, 
				"player": player, 
				"warWeight": warWeight,
				"enemyRank": enemyRank,
				"attackNumber": 2,
				"stars": stars2,
				"percentage": percentage2,
				"loot": loot2,
				"notes": notes2
			}

			teamInfo.push(attack1);
			teamInfo.push(attack2);
		}
	}
	return teamInfo;
}

function parseEnemyInfo(input) {
	var rank, warWeight
	var enemyInfo = [];

	var lines = input.split('\n');
	for(var i = 2; i < lines.length; i++) {
		var data = lines[i].split(',');

		if (data[0] != '')
		{
			rank = parseInt(data[0]);
			warWeight = parseInt(data[1]);

			var playerInfo = {
				"rank": rank,
				"warWeight": warWeight
			}
		}
		enemyInfo.push(playerInfo);
	}
	return enemyInfo;
}