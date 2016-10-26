<?php

$secure_page = 1;
$page_name = "Home > Share Photos > Delete Photo";

include("../include/php_header.inc");

$id = $_GET['id'];

// remove the database entry
$sql = "DELETE FROM pictures WHERE id=$id LIMIT 1";
$result = mysql_query($sql, $db);

// and remove the comments associated with it
$sql = "DELETE FROM picture_comments WHERE picture_id=$id";
$result = mysql_query($sql, $db);

// ...and the actual files
unlink("images/img_" . $id . ".jpg");
// which includes the cache
unlink("cache/small/img_" . $id . ".jpg");

?>

<h2>Photo Deleted</h2>


<p>Your photo has been removed from the database.</p>

<p style="text-align: right">
<a href="/pictures/">Browse Photos &raquo;</a>
</p>

<?php

include("../include/php_closing.inc");

?>
