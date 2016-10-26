<?php
require_once("../include/session.inc");

function loadLocation($id)
{
	global $db;
	$sql = "SELECT * FROM locations WHERE id=$id";
	mysql_select_db("jvoss_reunion");
	$result = mysql_query($sql, $db);
	mysql_select_db("jvoss_pagedata");

	$location['id'] = mysql_result($result, 0, "id");
	$location['name'] = mysql_result($result, 0, "name");
	$location['description'] = mysql_result($result, 0, "description");
	$location['author'] = loadPage(mysql_result($result, 0, "author_id"));
	$location['vote_for'] = mysql_result($result, 0, "vote_for");
	$location['vote_against'] = mysql_result($result, 0, "vote_against");

	$location['percent_for'] = floor(($location['vote_for'] / 30 ) * 100);
	$location['percent_against'] = floor(($location['vote_agsinst'] / 30 ) * 100);
	$location['percent_other'] = 100 - $location['percent_for'] - $location['percent_against'];

	$location['voters'] = unserialize(mysql_result($result, 0, "voters"));

	return $location;
}

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
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <a href="/reunion/locations.php">Locations</a> &gt; <strong>Suggest A Location</strong>
	</div>

	<div id="content">

		<h1>Suggest A Location</h1>

		<form enctype="multipart/form-data" method="post" action="location-submit.php" id="location-suggest">
		<fieldset>

			<p><label for="name">Location Name</label>
			<input type="text" name="name" /></p>

			<p><label for="description">Description</label>
			<textarea name="description"></textarea></p>

			<p><label for="image">Upload An Image</label>
			<input type="file" name="image" /></p>

			<p><input type="submit" value="Suggest" /></p>

		</fieldset>
		</form>

	</div>

</div>

</body>

</html>
