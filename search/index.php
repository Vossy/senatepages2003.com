<?php

$page_name = "Home > Search";

include_once("../include/php_header.inc");

?>

<h1>Search</h1>

<!-- <p>Search within the 200 latest posts.</p> -->

<form action="results.php" method="get">

<p><input type="search" name="q" value="Search the latest 200 posts" onclick="if(this.value=='Search the latest 200 posts'){this.value=''}" style="width: 70%" /></p>

<p><input type="submit" value="Search" />

</form>

<?php

include_once("../include/php_closing.inc");

?>


