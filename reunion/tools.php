<?php

function loadLocation($id)
{
	global $db;
	$sql = "SELECT * FROM locations WHERE id=$id";
	mysql_select_db("senatepages_reunion");
	$result = mysql_query($sql, $db);
	mysql_select_db("senatepages_data");

	$location['id'] = mysql_result($result, 0, "id");
	$location['name'] = mysql_result($result, 0, "name");
	$location['description'] = mysql_result($result, 0, "description");
	$location['author'] = loadPage(mysql_result($result, 0, "author_id"));
	$location['vote_for'] = mysql_result($result, 0, "vote_for");
	$location['vote_against'] = mysql_result($result, 0, "vote_against");

	$location['percent_for'] = floor(($location['vote_for'] / 30 ) * 100);
	$location['percent_against'] = floor(($location['vote_against'] / 30 ) * 100);
	$location['percent_other'] = 100 - $location['percent_for'] - $location['percent_against'];

	$location['voters'] = unserialize(mysql_result($result, 0, "voters"));

	return $location;
}

function loadTime($id)
{
	global $db;
	$sql = "SELECT * FROM times WHERE id=$id";
	mysql_select_db("senatepages_reunion");
	$result = mysql_query($sql, $db);
	mysql_select_db("senatepages_data");

	$time['id'] = mysql_result($result, 0, "id");

	$time['start'] = unserialize(mysql_result($result, 0, "start"));
	$time['end'] = unserialize(mysql_result($result, 0, "end"));
	$time['author'] = loadPage(mysql_result($result, 0, "author_id"));

	$time['vote_for'] = mysql_result($result, 0, "vote_for");
	$time['vote_against'] = mysql_result($result, 0, "vote_against");

	$time['percent_for'] = floor(($time['vote_for'] / 30 ) * 100);
	$time['percent_against'] = floor(($time['vote_against'] / 30 ) * 100);
	$time['percent_other'] = 100 - $time['percent_for'] - $time['percent_against'];

	$time['voters'] = unserialize(mysql_result($result, 0, "voters"));

	return $time;
}

function urlify($text)
{
	$text = strtolower($text);
	$text = eregi_replace("[[:punct:]]", "", $text);
	$text = eregi_replace("[ |.]", "-", $text);
	return $text;
}

?>