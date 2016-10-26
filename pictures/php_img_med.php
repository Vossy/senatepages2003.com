<?php

$id = $_GET['id'];

@ $original_img = ImageCreateFromJPEG("images/img_" . $id . ".jpg");

if(!$original_img)
  $original_img = ImageCreateFromJPEG("images/img_" . $id);

$old_width = ImageSx($original_img);
$old_height = ImageSy($original_img);

if($old_width > 430)
{
  $scale = 430 / $old_width;
  $new_width = 430;
  $new_height = $scale * $old_height;

  $new_img = ImageCreateTrueColor($new_width, $new_height);

  //imageantialias($new_img, true);

  ImageCopyResampled($new_img, $original_img, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

  //header('Content-Type: image/jpeg');
  ImageJPEG($new_img);
}
else
{
  //header('Content-Type: image/jpeg');
  ImageJPEG($original_img);
};

?>
