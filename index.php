<?php

$secure_page = "1";
$page_name = "Home";
$PageType = "index";

include_once("./include/session.inc");
include_once("./include/posts.inc");

$recent = $_GET['recent'];

if(isset($recent))
   $tmp = posts_top($recent);
if(isset($all))
   $tmp = posts_getall();

if(!isset($tmp))
   $tmp = posts_getnew();

include("./include/php_header.inc");

$sql = "SELECT * FROM pages WHERE id < 31 ORDER BY id ASC";
$result = mysql_query($sql, $db);

for($index = 0; $index < 30; $index++)
{
$NameList[] = "\"" . mysql_result($result, $index, "first") . " " . mysql_result($result, $index, "last") . "\"";
$CollegeList[] = "\"" . mysql_result($result, $index, "CollegeDecided") . "\"";
}



$sql = "SELECT * FROM pictures WHERE 1 ORDER BY id DESC LIMIT 1";
$result = mysql_query($sql, $db);

$PictureTopID = mysql_result($result, 0, "id");

$PictureAlertHTML = <<< END_HTML
<a href="/pictures/" style="margin: 5px; padding: 5px; border: 1px solid #444; background-color: #ffe; font-weight: bold; font-size: small; display: block;">
New Picture(s)!
</a>
END_HTML;

if($_COOKIE['LastPictureID'] < $PictureTopID)
   echo $PictureAlertHTML;

echo $tmp;

include("./include/php_closing.inc");

?>
