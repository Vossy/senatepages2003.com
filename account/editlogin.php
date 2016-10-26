<?php

$secure_page = 1;
$page_name = "Home > My Account > Edit Login Info";

include("../include/php_header.inc");


   // pull data already in place from the database
/*
  $userId = $USER['id'];
  $sql = "SELECT * FROM sessions WHERE session_id=$userId";
  $result = mysql_query($sql, $db);
*/

  $user_id = $USER['id'];

  echo "<!-- " . $USER['id'] . " -->";

  $sql = "SELECT * FROM pages WHERE id = $user_id";
  $result = mysql_query($sql, $db);

  // $password = mysql_result($result, 0, "password");
  $login = mysql_result($result, 0, "login");

?>

<form method="post" action="edit_submit.php">

<h1>Edit Login Info</h1>

<table width="430">

<tr>
<td align="right" width="150"><font size="2">Login Name:</td>
<td><input type="text" name="login" value="<?php echo $login; ?>"></td>
</tr>

<tr>
<td align="right" width="150"><font size="2">Password:</font></td>
<td><input type="password" name="password"></td>
</td>

<tr>
<td align="right" width="150"><font size="2">Confirm Password:</font></td>
<td><input type="password" name="password-confirm"></td>
</tr>

<tr>
<td align="right" width="150"><input type="submit" value="Update"></td>
</tr>

</table>

</form>

<?php

include("../include/php_closing.inc");

?>

