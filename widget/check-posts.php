<?php

if(isset($_GET['l']))
{
   $LastPost = $_GET['l'];
   $sql = "SELECT * FROM posts WHERE id > $LastPost ORDER BY id DESC LIMIT 5";
}
else
   $sql = "SELECT * FROM posts WHERE 1 ORDER BY id DESC LIMIT 5";

include_once("/home/jvoss/public_html/include/php_dbconnect.inc");

// $sql = "SELECT * FROM posts WHERE id > $LastPost ORDER BY id DESC LIMIT 5";
$result = mysql_query($sql, $db);

if(!$result)
   echo mysql_error();

$NumPosts = mysql_num_rows($result);

$OutputXML = "<newPosts>\n\n";

for($i = 0; $i < $NumPosts; $i++)
{
   $id = mysql_result($result, $i, "id");
   $author = mysql_result($result, $i, "poster");
   $title = mysql_result($result, $i, "title");

   $buffer = <<< END_XML
<post id="$id" author="$author" title="$title" />

END_XML;

   $OutputXML .= $buffer;

};

$OutputXML .= "\n\n</newPosts>";

header("Content-type: text/xml");

echo $OutputXML;

?>


