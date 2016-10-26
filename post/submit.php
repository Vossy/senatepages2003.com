<?php

$secure_page = 1;
$page_name = "Home > Add A Post > Submit";

include("../include/php_header.inc");

$title = $_POST["title"];
$text = $_POST["text"];

if($text == "")
{
  echo "An error has occured!";
   include("../include/footer.inc");
  die;
};

$date = date("m.d.y");
$timestamp = time();

// $poster = $login_name;
$poster = $USER['name'];
$author_id = $USER['id'];
$title = addslashes($title);
$text = addslashes($text);

$sql = "INSERT INTO posts (title, text, timestamp, date, author_id, poster) VALUES ('$title', '$text', $timestamp, '$date', $author_id, '$poster')";

mysql_query($sql, $db);

$sql = " ";

?>

<h1>Post Added!</h1>

<p>Your post as been added.  Click <a href="/">here</a> to read it.</p>

<?php

include("../include/php_closing.inc");

?>
