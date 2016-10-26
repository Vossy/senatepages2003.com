<?php
require_once("../include/session.inc");
require_once("tools.php");

//$tmp['25'] = 1;
// echo serialize($tmp);

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
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <strong>Locations</strong>
	</div>

	<div id="content">

		<h1>Location Ideas</h1>

		<table id="sort">
		<tr><td><strong>Sort By:</strong></td><td><a href="locations.php?sort=pop-desc">Popularity</a></td><td><a href="locations.php">Time Added</a></td></tr></table>

<?php

require_once("dbconnect.php");

$sql = "SELECT * FROM locations WHERE 1 ORDER BY id DESC";

if($_GET['sort'] == "pop-desc")
   $sql = "SELECT * FROM locations WHERE 1 ORDER BY (vote_for - vote_against) DESC";

if($_GET['sort'] == "pop-asc")
   $sql = "SELECT * FROM locations WHERE 1 ORDER BY (vote_against - vote_for) DESC";

mysql_select_db("senatepages2003_reunion"); 
$result = mysql_query($sql, $reunion_db);
mysql_select_db("senatepages2003_data"); 

$numLocations = mysql_num_rows($result);

for($i = 0; $i < $numLocations; $i++)
{
	$id = mysql_result($result, $i, "id");

	$location = loadLocation($id);
?>
		<div id="idea">
			<img class="location" src="img/<?= urlify($location['name']); ?>.jpg" width="144" height="108" />
			<p class="results">
				<span class="for" style="width: <?= $location['percent_for']; ?>%"><?= $location['percent_for']; ?>%</span>
				<span class="against" style="width: <?= $location['percent_against']; ?>%"><?= $location['percent_against']; ?>%</span>
				<span class="undecided" style="width: <?= $location['percent_other']; ?>%"><?= $location['percent_other']; ?>%</span>
			</p>

<?php echo "<!-- "; print_r($location['voters']); echo "-->"; ?>

<?php if(!$location['voters'][$USER['id']] && $USER['id'] < 50){ ?>
			<p id="vote">
				<a class="for" href="/reunion/location-vote.php?id=<?= $location['id']; ?>&v=1">Vote For</a>
				<a class="against" href="/reunion/location-vote.php?id=<?= $location['id']; ?>&v=0">Vote Against</a>
			</p>
<?php }; ?>
			<h2><?= $location['name']; ?></h2>
			<p><strong>Suggested By:</strong> <?= $location['author']['name']; ?></p>
			<p><?= $location['description']; ?></p>
		</div>
		<hr />
<?php
	echo $HTML;
}

?>

	<p><a class="step" href="location-suggest.php">Suggest A Location</a></p>

	</div>

</div>

</body>

</html>
