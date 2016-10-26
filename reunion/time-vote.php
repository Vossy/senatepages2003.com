<?php

require_once("../include/session.inc");
include("tools.php");

$time = loadTime($id);

$voters = $time['voters'];

if($voters[$USER['id']] == 1)
{
	// echo "voters[" . $USER['id'] . "] is == 1!";
	header("Location: /reunion/times.php");
	die();
}

$voters[$USER['id']] = 1;
$voters = serialize($voters);

$vote_for = $time['vote_for'];
$vote_against = $time['vote_against'];

if($v == 1)
	$vote_for++;

if($v == 0)
	$vote_against++;

if($vote_against == 0)
	$vote_against = '0';

if($vote_for == 0)
	$vote_for = '0';

$sql = "UPDATE times SET voters=\"$voters\", vote_for=$vote_for, vote_against=$vote_against WHERE id = $id LIMIT 1";

// echo $sql;

mysql_select_db("senatepages_reunion");
mysql_query($sql, $db);

header("Location: /reunion/times.php");

?>