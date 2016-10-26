<?php
require_once("../include/session.inc");
require_once("tools.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>

	<title>SenatePages2003 - Reunion Planning</title>

	<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>

<div id="wrapper">

	<div id="nav">
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <strong>Times</strong>
	</div>

	<div id="content">

		<h1>Time Ideas</h1>

<?php

require_once("dbconnect.php");

$sql = "SELECT * FROM times WHERE 1 ORDER BY id DESC";
mysql_select_db("senatepages_reunion"); 
$result = mysql_query($sql, $reunion_db);
mysql_select_db("senatepages_data"); 

$numTimes = mysql_num_rows($result);

for($i = 0; $i < $numTimes; $i++)
{
	$id = mysql_result($result, $i, "id");

	$time = loadTime($id);
?>
		<div id="idea">
		<p class="results">
			<span class="for" style="width: <?= $time['percent_for']; ?>%"><?= $time['percent_for']; ?>%</span>
			<span class="against" style="width: <?= $time['percent_against']; ?>%"><?= $time['percent_against']; ?>%</span>
			<span class="undecided" style="width: <?= $time['percent_other']; ?>%"><?= $time['percent_other']; ?>%</span>
		</p>

<?php if(!$time['voters'][$USER['id']] && $USER['id'] < 50){ ?>
		<p id="vote">
			<a class="for" href="/reunion/time-vote.php?id=<?= $time['id']; ?>&v=1">Vote For</a>
			<a class="against" href="/reunion/time-vote.php?id=<?= $time['id']; ?>&v=0">Vote Against</a>
		</p>
<?php }; ?>
			<h2><?= $time['start']['string']; ?> - <?= $time['end']['string']; ?></h2>
			<p><strong>Suggested By:</strong> <?= $time['author']['name']; ?></p>
		</div>
		<hr />
<?php
	echo $HTML;
}

?>

	<p><a class="step" href="time-suggest.php">Suggest A Time</a></p>

	</div>

</div>

</body>

</html>
