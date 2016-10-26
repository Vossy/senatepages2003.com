<?php

$PostLimit = 200;

$page_name = "Home > Search > Results";

include_once("../include/php_header.inc");
include_once("../include/posts.inc");

echo "<h1>Search Results</h1>\n";

$SearchKeywords = $_GET['q'];

$SearchKeywords = explode(" ", $SearchKeywords);

$sql = "SELECT * FROM posts WHERE 1 ORDER BY id DESC LIMIT $PostLimit";
$result = mysql_query($sql, $db);

for($PostIndex = 0; $PostIndex < $PostLimit; $PostIndex++)
{

$PostID = mysql_result($result, $PostIndex, "id");
$PostTitle = mysql_result($result, $PostIndex, "title");
$PostText = mysql_result($result, $PostIndex, "text");

for($KeywordIndex = 0; $KeywordIndex < sizeof($SearchKeywords); $KeywordIndex++)
{
   if(eregi($SearchKeywords[$KeywordIndex], $PostTitle . $PostText))
      $ResultSet[] = $PostID;
};

};

$NumResults = sizeof($ResultSet);

echo "<p>$NumResults results within the $PostLimit latest posts:</p>\n<hr />\n";

for($PrintIndex = 0; $PrintIndex < $NumResults; $PrintIndex++)
{
   echo posts_getbyid($ResultSet[$PrintIndex]);
};

include_once("../include/php_closing.inc");

?>
