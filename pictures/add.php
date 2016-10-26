<?php

$secure_page = 1;
$page_name = "Home > Share Pictures > Add A Photo";

include("../include/php_header.inc");

?>

<h2>Add A Photo</h2>

<form method="post" action="submit.php" enctype="multipart/form-data">

<p>Choose file: <input type="file" name="target_file" /></p>

<p>Caption:<br />
<textarea cols="50" rows="10" name="caption">Write a caption here...</textarea>
</p>
<p><input type="submit" value="Add Photo" /></p>
</form>

<?php

include("../include/php_closing.inc");

?>

