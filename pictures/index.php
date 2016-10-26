<?php

@include_once("../include/pictures.inc");

$secure_page = 1;
$page_name = "Home > Share Pictures > Browse Photos";

$sql = "SELECT * FROM pictures ORDER BY id DESC";
$result = mysql_query($sql, $db);
$total_num_pictures = mysql_num_rows($result);

$PictureTopID = mysql_result($result, 0, "id");

setcookie("LastPictureID", $PictureTopID, time()+60*60*24*30, "/", ".senatepages2003.com");

include_once("../include/php_header.inc");

if(!isset($_GET['start']))
   $start = -1;
else
   $start = $_GET['start'];

echo PicturesIndex($start);

include("../include/php_closing.inc");

?>
