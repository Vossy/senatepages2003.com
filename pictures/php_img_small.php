<?php

// see if the cached image exists

$id = $_GET['id'];

$bytes = @filesize("cache/small/img_" . $id . ".jpg");

if($bytes)
{
    // send the cached image
    header('Content-Type: image/jpeg');
    readfile("cache/small/img_" . $id . ".jpg");
    exit();
}
else
{

//@  $original_img = imagecreatefromjpeg("images/img_" . $id);
if(!$original_img)
   $original_img = imagecreatefromjpeg("images/img_" . $id . ".jpg");

  $old_width = ImageSx($original_img);
  $old_height = ImageSy($original_img);

  if($old_width > 100 && $old_width >= $old_height)
  {
    $scale = 100 / $old_width;
    $new_width = 100;
    $new_height = $scale * $old_height;

    $new_img = ImageCreateTrueColor($new_width, $new_height);

    ImageCopyResampled($new_img, $original_img, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

    // send and save

    $cache_dir = "cache/small/img_" . $id . ".jpg";

    @ImageJPEG($new_img, $cache_dir);

    header('Content-Type: image/jpeg');
    ImageJPEG($new_img);
    //ImageJPEG($new_img, $cache_dir);
    exit();
  }
  else
  if($old_height > 100 && $old_height > $old_width)
  {
    $scale = 100 / $old_height;
    $new_height = 100;
    $new_width = $scale * $old_width;

    $new_img = ImageCreateTrueColor($new_width, $new_height);

    ImageCopyResampled($new_img, $original_img, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

   $cache_dir = "cache/small/img_" . $id . ".jpg";

    @ImageJPEG($new_img, $cache_dir);

    header('Content-Type: image/jpeg');
    ImageJPEG($new_img);
    //ImageJPEG($new_img, $cache_dir);
  }
  else
  {
    $cache_dir = "cache/small/img_" . $id . ".jpg";
    header('Content-Type: image/jpeg');
    ImageJPEG($original_img);
    @ImageJPEG($original_img, $cache_dir);
  };

};

?>

