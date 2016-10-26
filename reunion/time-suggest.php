<?php
require_once("../include/session.inc");
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
		<a href="/">SenatePages2003.com</a> &gt; <a href="/reunion/">Reunion</a> &gt; <a href="/reunion/times.php">Times</a> &gt; <strong>Suggest A Time</strong>
	</div>

	<div id="content">

		<h1>Suggest A Time</h1>

		<form method="post" action="time-submit.php" id="suggest">
		<fieldset>

			<p><strong>Start:</strong> <select name="start-month">
				<option>January</option>
				<option>February</option>
				<option>March</option>
				<option>April</option>
				<option>May</option>
				<option>June</option>
				<option>July</option>
				<option>August</option>
				<option>September</option>
				<option>October</option>
				<option>November</option>
				<option>December</option>
			</select>
			<select name="start-day">
			<?php
			for($i = 1; $i < 31; $i++)echo "<option>$i</option>\n";
			?>
			</select>
			<select name="start-year">
				<option>2006</option>
				<option>2007</option>
				<option>2008</option>
			</select></p>

			<p><strong>End:</strong> <select name="end-month">
				<option>January</option>
				<option>February</option>
				<option>March</option>
				<option>April</option>
				<option>May</option>
				<option>June</option>
				<option>July</option>
				<option>August</option>
				<option>September</option>
				<option>October</option>
				<option>November</option>
				<option>December</option>
			</select>
			<select name="end-day">
			<?php
			for($i = 1; $i < 31; $i++)echo "<option>$i</option>\n";
			?>
			</select>
			<select name="end-year">
				<option>2006</option>
				<option>2007</option>
				<option>2008</option>
			</select></p>

			<p><input type="submit" value="Suggest" /></p>

		</fieldset>
		</form>

	</div>

</div>

</body>

</html>
