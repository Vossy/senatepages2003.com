<?php

require_once("../include/session.inc");
require_once("tools.php");

$author_id = $USER['id'];

/************************

STUB WARNING!

Do image handling here...

************************/

// what kind of image do we have?

// echo $_FILES['image']['type'];

$img =  $_FILES['image']['name'] . " [" . $_FILES['image']['type'] . "]";

if(eregi("jpeg$", $_FILES['image']['type'])) // JPEG
	$image = imagecreatefromjpeg($_FILES['image']['tmp_name']);

if(eregi("png$", $_FILES['image']['type'])) // PNG
	$image = imagecreatefrompng($_FILES['image']['tmp_name']);

// resize it to 144x108

$new_image = imagecreatetruecolor(144, 108);

imagecopyresampled($new_image, $image,
				0, 0, // dst.
				0, 0, // src.
				144, 108,
				imagesx($image), imagesy($image)
				);

// and save it to disk

imagejpeg($new_image, "img/" . urlify($name) . ".jpg");

/************************/

$sql = "INSERT INTO locations (author_id, name, description, img) VALUES ($author_id, '$name', '$description', '$img')";
mysql_select_db("senatepages_reunion");
mysql_query($sql, $db);

header("Location: /reunion/locations.php");
die();

?>