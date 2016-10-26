<?php

require_once("../include/session.inc");
require_once("tools.php");

$location = loadLocation($id);

$voters = $location['voters'];

if($voters[$USER['id']] == 1)
{
	// echo "voters[" . $USER['id'] . "] is == 1!";
	header("Location: /reunion/locations.php");
	die();
}

$voters[$USER['id']] = 1;
$voters = serialize($voters);

$vote_for = $location['vote_for'];
$vote_against = $location['vote_against'];

if($v == 1)
	$vote_for++;

if($v == 0)
	$vote_against++;

$sql = "UPDATE locations SET voters=\"$voters\", vote_for=$vote_for, vote_against=$vote_against WHERE id = $id LIMIT 1";

mysql_select_db("jvoss_reunion");
mysql_query($sql, $db);

header("Location: /reunion/locations.php");

?>