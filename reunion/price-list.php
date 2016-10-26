<?php
require_once("../include/session.inc");
require_once("tools.php");
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
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <strong>Cost</strong>
	</div>

	<div id="content">

		<h1>Name Your Price</h1>

<?php

	require_once("dbconnect.php");
	mysql_select_db("senatepages_reunion"); 
	$sql = "SELECT * FROM prices WHERE 1";
	$result = mysql_query($sql, $reunion_db);
	$rows = 0;
	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		$total += mysql_result($result, $i, "price");
		if(mysql_result($result, $i, "price"))
			$rows++;
	}
	$avg = $total / $rows;

?>

	<p>Current Average:</strong> $<?php echo sprintf("%01.2f", $avg); ?></p>

		<table id="price-list" cellspacing="0">

<?php

for($i = 1; $i < 31; $i++)
{
	$page = loadPage($i);
	$name = $page['name'];

	mysql_select_db("senatepages_reunion"); 
	$sql = "SELECT * FROM prices WHERE user_id=$i LIMIT 1";
	$result = mysql_query($sql, $reunion_db);

	$indicator = "";
	$price = @mysql_result($result, 0, "price");

	if(@mysql_result($result, 0, "price"))
		$indicator = "<img src=\"/reunion/stock-apply.png\" />";

	if($result && ($USER['id'] == 28 || $USER['id'] == 25 || $USER['id'] == 21))
		$indicator = $price;

	if($i == $USER['id'])
	{
		$html = <<< END_HTML
<form method="post" action="price-submit.php"><input name="price" type="text" value="$price" /><input type="submit" value="update" /></form>
END_HTML;
		$indicator = $html;
	}

	$class = "";
	if(!($i % 2))
		$class = " class=\"alt\"";

	echo "\t\t\t<tr$class><td><strong>$name</strong></td><td class=\"price\">$indicator</td></tr>\n";
}

?>

		</table>

	</div>

</div>

</body>

</html>
