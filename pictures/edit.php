<?php

$secure_page = 1;
$page_name = "Home > Share Photos > Edit Caption";

include("../include/php_header.inc");

$id = $_GET['id'];

$sql = "SELECT * FROM pictures WHERE id=$id";
$result = mysql_query($sql, $db);

$caption = mysql_result($result, 0, "caption");

?>

<form action="edit_submit.php?id=<?php echo $id; ?>" method="post">
<p><strong>New Caption:</strong>
<br />
<textarea cols="40" rows="10" name="caption"><?php echo $caption; ?></textarea>
</p>
<p><input type="submit" value="Update" /></p>
</form>

<?php

include("../include/php_closing.inc");

?>



