<?php

$secure_page = 1;
$page_name = "Home > Share Pictures > Add A Picture > Submit";

include("../include/php_header.inc");

$sql = "SELECT * FROM pictures ORDER BY id DESC LIMIT 1";
$result = mysql_query($sql, $db);
$sql = " ";

if(mysql_num_rows($result) == 0)
  $counter = -1;
if(mysql_num_rows($result) != 0)
  $counter = mysql_result($result, 0, "id");
$counter++;

$dir = "/images/img_" . $counter;

if(move_uploaded_file($_FILES['target_file']['tmp_name'], "/home/jvoss/public_html/pictures" . $dir))
{
  $success = "TRUE";

  $sql = "INSERT INTO pictures (id, submitter, caption) VALUES($counter, $user_id, '$caption')";
  $result = mysql_query($sql, $db);

  $fname = $_FILES['target_file']['name'];

  $html = <<< END_HTML
<h2>Picture Added</h2>

<p>Your picture ($fname) was uploaded successfully.</p>

<p><span style="color: #f00">New!</span> Who's in this picture?  Add them by <a href="/pictures/tag/$counter/">tagging this photo</a>.</p>

<div align="right">
<a href="add.php">Add Another Photo &raquo;</a>
<br />
<a href="/pictures/view/$counter/">View Photo &raquo;</a>
<br />
<a href="/pictures/">Browse Photos &raquo;</a>
</div>
END_HTML;

  echo $html;

   // resize the photo....

  $id = $counter;
   include("resize.php");
};

if($success != "TRUE")
{
  $error =  $_FILES['target_file']['error'];

  $html = <<< END_HTML
<h2>Error Adding Picture</h2>

<p>There was an error adding your picture:</p>

<p>$error</p>

END_HTML;

  echo $html;
}

include("../include/php_closing.inc");

?>
