<?php

$secure_page = 1;
$page_name = "Home > Share Photos > Edit Caption";

include("../include/php_header.inc");

$caption = $_POST["caption"];

$sql = "UPDATE pictures SET caption='$caption' WHERE id=$id";
$result = mysql_query($sql, $db);

?>

<h2>CaptionUpdated</h2>


<p>Your new caption has been added to the picture.</p>


<p><a href="/pictures/view/<?php echo $id; ?>/">&laquo; Back to Photo</a></p>

<?php

include("../include/php_closing.inc");

?>



