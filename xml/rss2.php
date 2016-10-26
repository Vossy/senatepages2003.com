<?php

include_once("../include/php_dbconnect.inc");

/*if( !isset($_SERVER['PHP_AUTH_USER']) ) {
	header("HTTP/1.1 401 Unauthorized");
	header("WWW-Authenticate: Basic realm=\"Senate Pages 2003 RSS Feed\"");
	die();
};

print_r($_SERVER);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$sql = "SELECT * FROM pages WHERE login='$user' and password='$pass' LIMIT 1";
$result = mysql_query($sql, $db);

if(!mysql_num_rows($result))
{
	//header("HTTP/1.1 401 Unauthorized");
	//header("WWW-Authenticate: Basic realm=\"Senate Pages 2003 RSS Feed\"");
	//die();
       echo $sql;
};*/

$PostLimit = 20;

header("Content-type: application/rss+xml; charset=iso-8859-1");

$InfoXML = <<< END_XML
<?xml version="1.0" ?>

<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"> 

<channel>

<title>SenatePages2003.com</title>
<link>http://www.senatepages2003.com/</link>
<description>The $PostLimit latest posts from the Fall 2003-2004 Senate Page website.</description>
<language>en-us</language>
END_XML;

$Output = $InfoXML;

$sql = "SELECT * FROM posts WHERE 1 ORDER BY id DESC LIMIT $PostLimit";
$result = mysql_query($sql, $db);

$NumPosts = mysql_num_rows($result);

for($index = 0; $index < $NumPosts; $index++)
{

$PostID = mysql_result($result, $index, "id");

// pull out the info to make the first <item> element

$PostTitle = mysql_result($result, $index, "title");
$PostAuthor = mysql_result($result, $index, "poster");
$PostText = mysql_result($result, $index, "text");
$PostDate = mysql_result($result, $index, "date");
$Timestamp = mysql_result($result, $index, "timestamp");


// $PostDate is in MM.DD.YY format:
$DateArray = explode(".", $PostDate);
// $Timestamp = mktime(12, 0, 0, $DateArray[0], $DateArray[1], "20" . $DateArray[2]); // noon of given day
$PubDate = gmdate("r", $Timestamp);

$PostDesc = $PostText;

$ItemXML = <<< END_XML
<item>
<title><![CDATA[$PostTitle]]></title>
<author>$PostAuthor</author>
<link>http://www.senatepages2003.com/PostID/$PostID</link>
<guid isPermaLink="false">$PostID</guid>
<pubDate>$PubDate</pubDate>
<content:encoded><![CDATA[$PostDesc]]></content:encoded>
</item>
END_XML;

// echo $ItemXML . "\n\n";
$Output .= $ItemXML . "\n\n";

};

$XMLFooter = <<< END_XML
</channel>
</rss>
END_XML;

$Output .= $XMLFooter;

echo $Output;

?>