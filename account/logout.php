<?php

$temp = $_COOKIE['login-id'];
setcookie("login-id", "0", 10, "/");

include("../include/php_dbconnect.inc");

$sql = "UPDATE sessions SET session_id=NULL WHERE session_id=$temp";
mysql_query($sql, $db);

header("Location: /");

?>
