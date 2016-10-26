<?php

include("../include/php_dbconnect.inc");

$sql = "SELECT * FROM pictures WHERE 1";
$result = mysql_query($sql, $db);

$num_rows = mysql_num_rows($result);

for($index = 0; $index < $num_rows; $index++)
{

$id = mysql_result($result, $index, "id");

if(!file_exists("images/img_" . $id))
{
   echo "skipping file img_$id...<br />\n";
   continue;
};

$original_img = ImageCreateFromJPEG("images/img_" . $id);

$old_width = ImageSx($original_img);
$old_height = ImageSy($original_img);

if($old_width > 500)
{
  $scale = 500 / $old_width;
  $new_width = 500;
  $new_height = $scale * $old_height;

  $new_img = ImageCreateTrueColor($new_width, $new_height);

  ImageCopyResampled($new_img, $original_img, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

  ImageJPEG($new_img, "images/img_" . $id . ".jpg");
}
else
{
  ImageJPEG($original_img, "images/img_" . $id . ".jpg");
};

unlink("images/img_" . $id);

};

?>
