var file;
var warInfo, teamInfo, enemyInfo, warAttackInfo;

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
			warAttackInfo = consolidateInfo(teamInfo, enemyInfo);

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

function consolidateInfo(teamInfo, enemyInfo) {
	for (var i = 0; i < teamInfo.length; i++) {
		var enemyRank = teamInfo[i]['enemyRank'];

		teamInfo[i]['enemyWeight'] = enemyRank ? enemyInfo[enemyRank-1]['warWeight'] : 0;
	}
	return teamInfo;
}

function parseTeamInfo(input) {
	var rank, player, warWeight, enemyRank, stars, percentage, loot, notes;
	var teamInfo = [];

	var lines = input.split('\n');
	var data = lines[2].split(',');

	for(var i = 2; i < lines.length; i++) {
		var data = lines[i].split(',');
		if (data[0] != '')
		{
			// Find player
			var playerid = '';		
			for (var j = 0; j < dbUsers.length; j++) {

				if (data[1] == dbUsers[j]['username'])
				{
					playerid = dbUsers[j]['userid'];
					break;
				}
			}
			rank = parseInt(data[0]);
			player = parseInt(playerid);
			warWeight = parseInt(data[2]);

			enemyRank1 = parseInt(data[3]);
			stars1= parseInt(data[4]);
			percentage1 = parseFloat(data[5]);
			loot1 = data[6] == '' ? 0 : parseInt(data[6]);
			notes1= data[7];
			
			enemyRank2 = parseInt(data[8]);
			stars2= parseInt(data[9]);
			percentage2 = parseFloat(data[10]);
			loot2 = data[11] == '' ? 0 : parseInt(data[11]);
			notes2= data[12];	

			var attack1 = {
				"rank": rank, 
				"playerid": player, 
				"warWeight": warWeight,
				"enemyRank": enemyRank1,
				"attackNumber": 1,
				"stars": stars1,
				"percentage": percentage1,
				"loot": loot1,
				"notes": notes1
			}

			var attack2 = {
				"rank": rank, 
				"playerid": player, 
				"warWeight": warWeight,
				"enemyRank": enemyRank2,
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