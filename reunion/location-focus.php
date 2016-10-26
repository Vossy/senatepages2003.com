<?php

require_once("../include/session.inc");
require_once("dbconnect.php");

function loadLocation($id)
{
	global $db;
	$sql = "SELECT * FROM locations WHERE id=$id";
	mysql_select_db("jvoss_reunion");
	$result = mysql_query($sql, $db);
	mysql_select_db("jvoss_pagedata");

	$location['name'] = mysql_result($result, 0, "name");
	$location['description'] = mysql_result($result, 0, "description");
	$location['author'] = loadPage(mysql_result($result, 0, "author_id"));
	$location['vote_for'] = mysql_result($result, 0, "vote_for");
	$location['vote_against'] = mysql_result($result, 0, "vote_against");

	$location['percent_for'] = floor(($location['vote_for'] / 30 ) * 100);
	$location['percent_against'] = floor(($location['vote_agsinst'] / 30 ) * 100);
	$location['percent_other'] = 100 - $location['percent_for'] - $location['percent_against'];

	return $location;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>

	<title>SenatePages2003 - Reunion Planning</title>

	<link rel="stylesheet" type="text/css" href="style.css" />

	<script type="text/javascript" language="javascript">

var loggedIn = false;

function vote(id, decision)
{
	voteBox = document.getElementById("vote");
	voteBox.innerHTML = "<p>Voting...</p>";
	setTimeout("voteUI()", 2000);
	return false;
}

function voteUI()
{
	voteBox = document.getElementById("vote");
	voteBox.innerHTML = "<p><strong>Thanks!</strong></p>";
}

	</script>

</head>

<body>

<div id="wrapper">

	<div id="nav">
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <a href="/reunion/locations.php">Locations</a> &gt; <strong><?= $location['name']; ?></strong>
	</div>

	<div id="content">

		<div id="idea">
			<h2>Location Idea: <?= $location['name']; ?></h2>

			<p><strong>Suggested By:</strong> <?= $location['author']['name']; ?></p>

			<p><strong>Description:</strong> <?= $location['description']; ?></p>

		</div>

		<div class="comment dark">
			<p class="comment-info"><strong>Justin Voss</strong></p>
			<p>DC sounds good:  what do you want to do while we're there?</p>
		</div><!-- .comment -->

		<div class="comment light">
			<p class="comment-info"><strong>Chelsea McMaster</strong></p>
			<p>Some comment goes here.</p>
			<p>And another paragraph, for good measure.</p>
		</div><!-- .comment -->

		<form id="comment-form" action="#" method="post">
		<div class="comment dark">
			<p class="comment-info"><strong><?= $USER['name']; ?></strong></p>
			<p><textarea></textarea></p>
			<p><input type="submit" value="Submit" />
		</div><!-- .comment -->
		</form>

	</div>

	<div id="sidebar">

		<img class="location" src="DC.jpg" />

		<p class="results">
			<span class="for" style="width: <?= $location['percent_for']; ?>%"><?= $location['percent_for']; ?>%</span>
			<span class="against" style="width: <?= $location['percent_against']; ?>%"><?= $location['percent_against']; ?>%</span>
			<span class="undecided" style="width: <?= $location['percent_other']; ?>%"><?= $location['percent_other']; ?>%</span>
		</p>

		<p id="vote">
			<a class="for" href="/12345/vote/for/" onclick="return vote(<?= $location['id']; ?>, true)">Vote For</a>
			<a class="against" href="/12345/vote/against/" onclick="return vote(<?= $location['id']; ?>, false)">Vote Against</a>
		</p>

	</div>

</div>

</body>

</html>
