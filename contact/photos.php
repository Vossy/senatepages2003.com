<?php

include_once("../include/session.inc");

$page = $_GET['page'];
$PAGE = loadPage($page);
$name = $PAGE['name'];

$page_name = "Home > Get Contact Info > $name > Photos";

$secure_page = 1;

$PageType = "contact.page";

include("../include/php_header.inc");

/*******************************************/

$sql = "SELECT * FROM pictures WHERE people LIKE '%[$page]%' ORDER BY id DESC";
$result = mysql_query($sql, $db);

if($result){
	echo "<h2>Photos of " . $PAGE['first'] . "</h2>\n\n<table><tr>";
	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		$img = mysql_result($result, $i, "id");
		// echo $img . " ";
		echo "<td><a class=\"ImageLink\" href=\"/pictures/view/$img/\"><img src=\"/pictures/php_img_small.php?id=$img\" /></td>";
		if($i && !(($i + 1) % 4))
			echo "</tr><tr>";
	}
	echo "</tr></table>\n\n";
}
else
	echo "<h2>No Photos</h2>";

/*******************************************/

include("../include/php_closing.inc");

?>

