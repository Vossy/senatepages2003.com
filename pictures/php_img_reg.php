<?php

$id = $_GET['id'];

@ $original_img = ImageCreateFromJPEG("images/img_" . $id . ".jpg");

if(!$original_img)
   $original_img = ImageCreateFromJPEG("images/img_" . $id);

header('Content-Type: image/jpeg');
ImageJPEG($original_img);

?>
