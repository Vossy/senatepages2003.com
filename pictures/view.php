<?php

$secure_page = 1;
$page_name = "Home > Share Photos > Browse Photos > View Photo";

include("../include/php_header.inc");
include_once("../include/pictures.inc");

$id = $_GET['id'];

$sql = "SELECT * FROM pictures WHERE id=$id";
$result = mysql_query($sql, $db);
$poster_id = mysql_result($result, 0, "submitter");
$caption = mysql_result($result, 0, "caption");
$people = mysql_result($result, 0, "people");

$sql = "SELECT * FROM pages WHERE id=$poster_id";
$result = mysql_query($sql, $db);

$poster = mysql_result($result, 0, "first") . " " . mysql_result($result, 0, "last");

?>

<font face="Helvetica, Verdana, sans-serif" size="2"><b>
Posted By <?php echo $poster; ?></b></font><br /><br />

<!-- <font face="Helvetica, Verdana, sans-serif" size="2"><b>Caption: </b><?php echo $caption; ?></font><br /><br /> -->

<center><a class="ImageLink" href="/pictures/php_img_reg.php?id=<?php echo $id; ?>">
<img border="0" src="/pictures/php_img_med.php?id=<?php echo $id; ?>"></a></center>
<br />

<p><small>In this picture: 
<?php

for($i = 1; $i < 31; $i++)
{
if(eregi("\[$i\]", $people))
{
$PAGE = loadPage($i);
$inThisPicture[] = "<a href=\"/contact/$i/\">$PAGE[name]</a>";
}
}
if(isset($inThisPicture))
   echo implode($inThisPicture, ", ");

?></small></p>

<div id="pictureCaptionContainer" <?php if($poster_id == $user_id){ ?>ondblclick="beginCaptionEdit()"<?php }; ?>><p><strong>Caption:</strong> <span id="pictureCaptionText"><?php echo $caption; ?></span></p></div>

<?php

if($poster_id == $user_id)
{
$ActionsHTML = <<< END_HTML
<p id="pictureCaptionActions" style="font-size: small;">
<a href="/pictures/tag/$id/">Tag Photo</a>
<a href="/pictures/edit.php?id=$id" onclick="beginCaptionEdit($id);return false;"><img src="/images/stock-edit.png" alt="" />Edit Caption</a>
<a href="/pictures/delete_confirm.php?id=$id" onclick="deletePic($id);return false;"><img src="/images/stock-delete.png" alt="" />Delete Photo</a>
</p>
END_HTML;
echo $ActionsHTML;

    // echo "<a href='/pictures/edit.php?id=$id'>Edit Caption</a><br /><a href='/pictures//delete_confirm.php?id=$id'>Delete Photo</a>";

};

?>
<h3>Comments</h3>

<?php echo pictures_getComments($id); ?>

<?php if($USER['id'] < 50) { ?>
<form method="post" action="/pictures/add-comment.php">
	<input type="hidden" name="picture_id" value="<?php echo $id; ?>" />
	<textarea name="text" style="font-family: sans-serif; width: 100%; height: 200px; border: 1px solid #aaa" onclick="if(this.value=='Add a comment'){this.value=''};">Add a comment</textarea>
	<br />
	<input type="submit" value="add" />
</form>
<?php } ?>

<?php

include("../include/php_closing.inc");

?>