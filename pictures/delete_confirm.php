<?php

$secure_page = 1;
$page_name = "Home > Share Photos > Delete Photo";

include("../include/php_header.inc");

$id = $_GET['id'];

?>

<h2>Delete This Photo?</h2>

<p>Are you sure you want to delete this photo?</p>

<p><a href="./view.php?id=<?php echo $id; ?>">No</a></p>

<p><a href="./delete_action.php?id=<?php echo $id; ?>">Yes</a></p>

<?php

include("../include/php_closing.inc");

?>



