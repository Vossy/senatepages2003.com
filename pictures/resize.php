<?php

$MAX_WIDTH = 500;

$original_img = ImageCreateFromJPEG("images/img_" . $id);

if(!$original_img)
   die("no image!");

$old_width = ImageSx($original_img);
$old_height = ImageSy($original_img);

if($old_width > $MAX_WIDTH)
{
  $scale = $MAX_WIDTH / $old_width;
  $new_width = $MAX_WIDTH;
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

?>