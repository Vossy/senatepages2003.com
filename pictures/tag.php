<?php

include_once("../include/session.inc");

if(isset($_POST['picture-id']))
{

	$id = $_POST['picture-id'];
	$people = "";

	for($i = 1; $i < 31; $i++)
	{
		if($_POST['page-' . $i])
			$people .= "[$i] ";
	}

	// echo "<!-- "; print_r($_POST); echo " -->";
	// echo "<!-- $people -->";

	$sql = "UPDATE pictures SET people = '$people' WHERE id = $id LIMIT 1";
	mysql_query($sql, $db);

	header("Location: /pictures/view/$id/");
	die();

}

$secure_page = 1;
$page_name = "Home > Share Photos > Browse Photos > Tag Photo";

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

<h2>Tag This Photo</h2>

<p><center><a class="ImageLink" href="/pictures/php_img_reg.php?id=<?php echo $id; ?>">
<img border="0" src="/pictures/php_img_med.php?id=<?php echo $id; ?>"></a></center></p>

<div id="pictureCaptionContainer" <?php if($poster_id == $USER['id']){ ?>ondblclick="beginCaptionEdit()"<?php }; ?>><p><strong>Caption:</strong> <span id="pictureCaptionText"><?php echo $caption; ?></span></p></div>

<?php

if($poster_id == $USER['id'])
{

?>

<form action="/pictures/tag/<?= $id ?>/" method="post">
<fieldset>

<p><strong>Who's in this picture?</strong></p>

<input type="hidden" name="picture-id" value="<?= $id ?>" />

<?php

for($i = 1; $i < 31; $i++)
{
$PAGE = loadPage($i);
$checked = "";
if(eregi("\[$i\]", $people)) $checked = " checked=\"checked\"";
echo "\t<p><input type=\"checkbox\" name=\"page-$i\"$checked><label for=\"page-$i\">$PAGE[first] $PAGE[last]</label></p>\n";
}

?>

<input type="submit" value="submit" />

</fieldset>
</form>

<?

};

include("../include/php_closing.inc");

?>