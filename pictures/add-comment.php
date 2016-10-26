<?php

include_once("../include/session.inc");
include_once("../include/pictures.inc");

if(!isset($_POST['picture_id']))
{
	header("Location: /pictures/");
	die();
};

$picture_id = $_POST['picture_id'];
$author_id = $USER['id'];
$text = $_POST['text'];

pictures_addComment($picture_id, $author_id, $text);

header("Location: /pictures/view/" . $picture_id);

?>
