<?php

$secure_page = 1;
$page_name = "Home > My Account";

include("../include/php_header.inc");

$login_id = $_COOKIE['login-id'];
$sql = "SELECT * FROM sessions WHERE session_id=$login_id";
$result = mysql_query($sql, $db);

$id = mysql_result($result, 0, "user_id");

?>

<h2>My Account</h2>

<p>You can manage your account information from here.</p>
<p><a href="editlogin.php">Edit Login Info</a></p>
<p><a href="/contact/edit/">Edit Contact Info</a></p>
<p><a href="/logout/">Log Out</a></p>

<?php

include("../include/php_closing.inc");

?>
