</div><!-- END CONTENT -->

	<div id="Footer">
<?php
$sql = "SELECT * FROM posts WHERE 1";
$result = mysql_query($sql, $db);
$num_posts = mysql_num_rows($result);

$sql = "SELECT * FROM pictures WHERE 1";
$result = mysql_query($sql, $db);
$num_pics = mysql_num_rows($result);

?>
		<p>SenatePages2003.com: serving up <?php echo $num_posts; ?> posts and <?php echo $num_pics; ?> pictures, hot and fresh everyday!</p>
	</div><!-- END FOOTER -->

</div><!-- END TOPLEVEL -->

</body>

</html>
