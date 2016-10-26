<?php

$secure_page = 1;
$page_name = "Home > My Account > Edit Login Info > Submit";

include("../include/php_header.inc");

$new_login = $_POST["login"];
$password = $_POST["password"];
$confirm = $_POST["password-confirm"];

if($password != $confirm)
{

?>

<font face="Helvetica, Verdana, sans-serif" size="4"><b>
Error!</b></font>
<br />
<font face="Helvetica, Verdana, sans-serif" size="2">
The passwords you entered do not match.  Please go back and try again.</font>

<?

};

if($password == $confirm)
{

$sql = "SELECT * FROM sessions WHERE session_id=$login_id";
$result = mysql_query($sql, $db);
$id = mysql_result($result, 0, "user_id");

$sql = "UPDATE pages SET login='$login', password='$password' WHERE id=$id";

mysql_query($sql, $db);

?>

<font size="4"><b>Info Updated</b></font>
<br />
<font size="2">Your login info has been successfully updated.</font>

<?php

};

include("../include/php_closing.inc");

?>


