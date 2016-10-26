<?php

include("../include/php_dbconnect.inc");

$login = $_POST["login"];
$password = $_POST["password"];
$ref_url = $_POST["ref-url"];
// $remember = $_POST['remember']; 

$sql = "SELECT * FROM pages WHERE login='$login' AND password='$password'";

$result = mysql_query($sql, $db);

if(!mysql_num_rows($result))
{
  // no data returned, bad login
   header("Location: /");
   die();
};

// assign a session ID
srand((double)microtime()*1000000);
$login_id = rand();
//$login_id = md5(uniqid(rand(), true));

// register new ID with the login database

$user_id = mysql_result($result, 0, "id");
$time = date("g:i A M d, Y");
$name = mysql_result($result, 0, "first") . " " . mysql_result($result, 0, "last");

$sql = "INSERT INTO sessions (user_id, session_id, time, name) VALUES ($user_id, $login_id, '$time', '$name')";
mysql_query($sql, $db);

if($remember)
   $time = time()+60*60*24*7; // one week
else
   $time = time()+60*60*2; // two hours

setcookie("login-id", $login_id, $time, "/");

header("Location: " . $ref_url);

?>