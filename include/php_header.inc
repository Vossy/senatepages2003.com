<?php

include_once("php_dbconnect.inc");

include_once("session.inc");

if($secure_page && $user_id <= 0)
  $page_name = "Home > Access Denied";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>
	<title>US Senate Pages | Fall 2003</title>

	<!-- Stylesheets -->
	<link rel="alternate stylesheet" title="Original Blue" media="screen" type="text/css" href="/css/original.css" />
	<link rel="stylesheet" title="Gloss Finish" media="screen" type="text/css" href="/css/gloss.css" />
	<link rel="stylesheet" media="print" type="text/css" href="/css/print.css" />

	<!-- XML Feed -->
	<link rel="alternate" type="application/rss+xml" href="/xml/index.rss" title="Latest Posts" />

	<!-- Other Goodies -->
	<link rel="Shortcut Icon" type="image/png" href="/images/seal-favicon.png" />
	<script type="text/javascript" language="javascript" src="/include/prototype-1.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="/include/moo.fx.js"></script>
	<script src="/include/ticker.js" type="text/javascript"></script>
	<script src="/include/pictures.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="/include/currently-online.js"></script>


	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	<script type="text/javascript">
		_uacct = "UA-52245-2";
		urchinTracker();
	</script>

</head>

<body>

<!-- MAIN LAYOUT DIV -->
	<div id="TopLevel">

	<div id="Header">

		<h1>SenatePages2003.com</h1>

		<span id="PageName"><?php echo $page_name; ?></span>
		<span id="LoginName"><?php echo $USER['name']; ?></span>

	</div><!-- END HEADER -->

<div id="Navigation" class="NoPrint">
<?php include("nav.inc"); ?>
</div>

<div id="Content">

<div id="CurrentlyOnline" onmouseup="ToggleCurrentlyOnline()" class="NoPrint">

<h3>currently online</h3>

<div id="CurrentlyOnlineInner">
<ul>
<?php
	$now = time();
	$onlineTimeLimit = 60*5;
	$sql = "SELECT * FROM pages WHERE ($now - LastRequest) < $onlineTimeLimit AND id < 31 ORDER BY id ASC";
	$result = mysql_query($sql, $db);
	$numOnline = mysql_num_rows($result);
	for($i = 0; $i < $numOnline; $i++)
	{
		$OnlineName = mysql_result($result, $i, "first") . " " . mysql_result($result, $i, "last");
		echo "<li>$OnlineName</li>\n";
	};
?>
</ul>
</div><!-- INNER -->

</div><!-- ONLINE -->

