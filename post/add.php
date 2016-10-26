<?php

$secure_page = 1;
$page_name = "Home > Add A Post";

include("../include/php_header.inc");

?>

<font face="Helvetica, Verdana, sans-serif" size="4"><b>Add A Post</b></font>
<br />
<br />
<font face="Helvetica, Verdana, sans-serif" size="2">
<form method="POST" action="submit.php">
Title:<br />
<input type="text" name="title" size="40" value="Untitled" />
<br />
Main Text:<br />
<textarea cols="50" rows="20" name="text">Write your post here...</textarea>
<br />
<input type="submit" value="Add Post" />
</form>
</font>

<?php

include("../include/php_closing.inc");

?>
