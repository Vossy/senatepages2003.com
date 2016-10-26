<?php

require_once("../include/session.inc");
require_once("tools.php");

$user_id = $USER['id'];
$time = time();
$price = $_POST['price'];

$sql = "UPDATE prices SET timestamp=$time, price='$price' WHERE user_id=$user_id";
mysql_select_db("jvoss_reunion");
mysql_query($sql, $db);

header("Location: /reunion/price-list.php");
die();

?>