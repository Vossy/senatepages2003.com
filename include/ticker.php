<?php

include_once("php_dbconnect.inc");

$sql = "SELECT * FROM pages WHERE id < 31 ORDER BY id ASC";
$result = mysql_query($sql, $db);

for($index = 0; $index < 30; $index++)
{
	$NameList[] = "\"" . mysql_result($result, $index, "first") . " " . mysql_result($result, $index, "last") . "\"";
	$CollegeList[] = "\"" . mysql_result($result, $index, "CollegeDecided") . "\"";
}

?>

var NamesArray = new Array(<?php echo implode(", ", $NameList); ?>);
var CollegesArray = new Array(<?php echo implode(", ", $CollegeList); ?>);
var TickerCounter = 0;

function InjectTicker()
{
	CollegeTicker = document.createElement("div");
	CollegeTicker.className = "NoPrint";
	CollegeTicker.id = "CollegeTicker";

	TickerLabel = document.createElement("div");
	TickerLabel.id = "TickerLabel";
	TickerLabel.innerHTML = "College Ticker&trade;";

	TickerName = document.createElement("div");
	TickerName.id = "TickerName";
	TickerName.appendChild(document.createTextNode("Loading"));

	TickerCollege = document.createElement("div");
	TickerCollege.id = "TickerCollege";
	TickerCollege.appendChild(document.createTextNode("Please Wait..."));

	CollegeTicker.appendChild(TickerLabel);
	CollegeTicker.appendChild(TickerName);
	CollegeTicker.appendChild(TickerCollege);

	document.body.appendChild(CollegeTicker);

	UpdateTicker();
}
	
function UpdateTicker()
{
	if(document.getElementById("TickerName") == null)
	{
		TickerTimeout = setTimeout("UpdateTicker();", 2000);
		return;
	}

	document.getElementById("TickerName").childNodes[0].nodeValue = NamesArray[TickerCounter];
	document.getElementById("TickerCollege").childNodes[0].nodeValue = CollegesArray[TickerCounter];

	TickerCounter += 1;
	if(TickerCounter == NamesArray.length)
		TickerCounter = 0;

	TickerTimeout = setTimeout("UpdateTicker()", 2000);
}

window.onload = function(){
InjectTicker();
}