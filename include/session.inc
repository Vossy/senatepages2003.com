<?php

include_once("php_dbconnect.inc");

// check and process login info

if(!isset($_COOKIE['login-id']))
{
  include_once("login.php");
  die();
};

if(isset($_COOKIE['login-id']))
{
  $login_id = $_COOKIE['login-id'];
  $result = mysql_query("SELECT * FROM sessions WHERE session_id=$login_id");

  if(@mysql_numrows($result) == 0)
  {
    include_once("login.php");
    die();
  }
  else
  {

  $user_id = mysql_result($result, 0, "user_id");

  $sql = "SELECT * FROM pages WHERE id=$user_id";
  $result = mysql_query($sql, $db);

  $first = mysql_result($result, 0, "first");
  $last = mysql_result($result, 0, "last");
  $login_name = $first . " " . $last;
/*
  $USER['id'] =$user_id;
  $USER['first'] = $first;
  $USER['last'] = $last;
  $USER['name'] = $first . " " . $last;
  $USER['LastPost'] = mysql_result($result, 0, "LastPost");
*/
  $USER = loadPage($user_id);

  $sql = "UPDATE pages SET LastRequest = " . time() . " WHERE id = $user_id";
  mysql_query($sql, $db);


  };

};

function loadPage($id)
{
  global $db;
  mysql_select_db("senatepages_data"); 
  $sql = "SELECT * FROM pages WHERE id = $id LIMIT 1";
  $result = mysql_query($sql, $db);

  if(!$result)
    return null;

  $PAGE['id'] = $id;
  $PAGE['first'] = mysql_result($result, 0, "first");
  $PAGE['last'] = mysql_result($result, 0, "last");
  $PAGE['name'] = $PAGE['first'] . " " . $PAGE['last'];
  $PAGE['LastPost'] = mysql_result($result, 0, "LastPost");
  $PAGE['LastRequest'] = mysql_result($result, 0, "LastRequest");
  $PAGE['address']['home'] = mysql_result($result, 0, "address");
  $PAGE['address']['college'] = mysql_result($result, 0, "CollegeAddress");
  $PAGE['email'] = mysql_result($result, 0, "email");
  $PAGE['college'] = mysql_result($result, 0, "CollegeDecided");
  $PAGE['fbookURL'] = mysql_result($result, 0, "fbookURL");

  $USER['LastPost'] = mysql_result($result, 0, "LastPost");
  $USER['LastRequest'] = mysql_result($result, 0, "LastRequest");
  if((time() - $USER['LastRequest']) < 60*5)
    $USER['currentlyOnline'] = TRUE;

  $sn['aim'] = mysql_result($result, 0, "sn");
  $PAGE['screenName'] = $sn;

  $phone['home'] = mysql_result($result, 0, "home_phone");
  $phone['cell'] = mysql_result($result, 0, "cell_phone");
  $phone['college'] = mysql_result($result, 0, "college_phone");
  $PAGE['phone'] = $phone;

  return $PAGE;

};

?>
