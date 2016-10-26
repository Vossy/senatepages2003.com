<?php

require_once("../include/session.inc");
require_once("tools.php");

$author_id = $USER['id'];

$start['month'] = $_POST['start-month'];
$start['day'] = $_POST['start-day'];
$start['year'] = $_POST['start-year'];
$start['string'] = $_POST['start-month'] . " " . $_POST['start-day'] . ", " .$_POST['start-year'];
$start = serialize($start);

$end['month'] = $_POST['end-month'];
$end['day'] = $_POST['end-day'];
$end['year'] = $_POST['end-year'];
$end['string'] = $_POST['end-month'] . " " . $_POST['end-day'] . ", " .$_POST['end-year'];
$end = serialize($end);

$sql = "INSERT INTO times (author_id, start, end) VALUES ($author_id, '$start', '$end')";
mysql_select_db("jvoss_reunion");
mysql_query($sql, $db);

header("Location: /reunion/times.php");
die();

?>