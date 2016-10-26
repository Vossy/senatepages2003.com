<?php

include_once("../include/session.inc");

$page_name = "Home > Get Contact Info > $login_name > Edit";
$secure_page = 1;

include("../include/php_header.inc");

$sql = "SELECT * FROM pages WHERE id=$user_id";
$result = mysql_query($sql, $db);

$first = mysql_result($result, 0, "first");
$last = mysql_result($result, 0, "last");
$address = mysql_result($result, 0, "address");
$home_phone = mysql_result($result, 0, "home_phone");
$cell_phone = mysql_result($result, 0, "cell_phone");
$email = mysql_result($result, 0, "email");
$sn = mysql_result($result, 0, "sn");
$CollegeDecided = mysql_result($result, 0, "CollegeDecided");

$PAGE = loadPage($user_id);

?>

<h1>Edit Contact Info</h1>

<form method="post" action="/contact/edit/submit/">

<div id="ContactInfo">

<fieldset id="Etc">
	<legend>Essentials</legend>
	<p><label for="first">first name:</label> <input name="first" value="<?php echo $first; ?>" type="text" id="first" /></p>
	<p><label for="last">last name:</label> <input name="last" value="<?php echo $last; ?>" type="text" id="last" /></p>
	<p><label for="cell_phone">cell:</label> <input name="cell_phone" id="cell_phone" value="<?php echo $cell_phone; ?>" type="text" /></p>
	<p><label for="email">email:</label> <input name="email" id="email" value="<?php echo $email; ?>" type="text" /></p>
	<p><label for="sn">AIM:</label> <input name="sn" id="sn" value="<?php echo $sn; ?>" type="text" /></p>
	<p><label for="fbookURL">Facebook Profile URL:</label> <input name="fbookURL" id="fbookURL" value="<?php echo $PAGE['fbookURL']; ?>" type="text" /></p>
</fieldset>

<fieldset id="Home">
	<legend>Home</legend>
	<p><label for="address">address:</label> <textarea cols="30" rows="5" name="address" id="address"><?php echo $address; ?></textarea></p>
	<p><label for="home_phone">home phone:</label> <input name="home_phone" id="home_phone" value="<?php echo $home_phone; ?>" type="text" /></p>
</fieldset>

<fieldset id="College">
	<legend>College</legend>

	<p><label for="CollegeDecided">college:</label> <input name="CollegeDecided" id="CollegeDecided" value="<?php echo $CollegeDecided; ?>" type="text" /></p>
	<p><label for="CollegeAddress">address:</label> <textarea cols="30" rows="5" name="CollegeAddress" id="CollegeAddress"><?php echo $PAGE['address']['college']; ?></textarea></p>
	<p><label for="college_phone">college phone:</label> <input name="college_phone" id="college_phone" value="<?php echo $PAGE['phone']['college']; ?>" type="text"></p>
</fieldset>

</div><!-- #ContactInfo -->


<p><input type="submit" value="Update"></p>

<!--
<table>
<tr><td align="right" width="150">
First Name:</td><TD align="left"><input type="text"name="first" value="<?php echo $first; ?>"></td></tr>

<TR><TD align="right" width="150">
Last Name:</td><TD align="left"><INPUT type="text" name="last" value="<?php echo $last; ?>"></td></tr>
</table>

<div id="Etc">
<table>
<td><td align="right" width="150">
Cell Phone:</td><td align="left"><INPUT type="text" name="cell_phone" value="<?php echo $cell_phone; ?>"></td></tr>

<tr><td align="right" width="150">
Email:</td><TD align="left"><INPUT type="text" name="email" value="<?php echo $email; ?>"></td></tr>

<tr><td align="right" width="150">
AIM Screen Name:</td><TD align="left"><INPUT type="text" name="sn" value="<?php echo $sn; ?>"></td></tr>
</table>
</div>

<div id="Home">
<tr><td align="right" width="150">
Home Address:</td><TD align="left"><textarea cols="30" rows="5" name="address"><?php echo $address; ?></textarea></td></tr>

<tr><td align="right" width="150">
Home Phone:</td><td align="left"><input type="text" name="home_phone" value="<?php echo $home_phone; ?>"></td></tr>
</div>

<div id="College">
<tr><td align="right" width="150">
College:</td><td align="left"><input type="text" name="CollegeDecided" value="<?php echo $CollegeDecided; ?>"></td></tr>

<tr><td align="right" width="150">
College Address:</td><td align="left"><textarea cols="30" rows="5" name="CollegeAddress"><?php echo $PAGE['address']['college']; ?></textarea></td></tr>

<TR><TD align="right" width="150">
College Phone:</td><TD align="left"><INPUT type="text" name="college_phone" value="<?php echo $PAGE['phone']['college']; ?>"></td></tr>
</div>

<TR><TD align="right" width="150">
<INPUT type="submit" value="Update">
</td><td></td></tr>

</table>

</div> -->

<?php

include("../include/php_closing.inc");


?>


