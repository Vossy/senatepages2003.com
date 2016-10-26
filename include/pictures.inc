<?php

include_once("php_dbconnect.inc");
include_once("session.inc");

function PicturesIndex($start=-1)
{

global $db;
global $USER;

$sql = "SELECT * FROM pictures ORDER BY id DESC";
$result = mysql_query($sql, $db);
$total_num_pictures = mysql_num_rows($result);

$PictureTopID = mysql_result($result, 0, "id");

if($start == -1)
  $start = $highest_id = mysql_result($result, 0, "id");

// now, divide that into 24-photo segments

//$page_dividers[];
$page_count = ceil($total_num_pictures / 24);

for($index = 0; $index < $page_count; $index++)
{
    $page_dividers[] = mysql_result($result, 24*$index, "id");
};


// the next step is to figure out which page were on

$current_page = 0;

while($page_dividers[$current_page] > $start)
    $current_page++; 

// finally, set the previous and next starting id's

if($start != $highest_id)
    $prev = $page_dividers[$current_page - 1];

if($current_page != $page_count)
    $next = $page_dividers[$current_page + 1];


$ResultHTML  = <<< END_HTML
<table width="420" cellspacing="0"><!-- PICTURE TABLE -->

END_HTML;

if($USER['id'] < 50) $ResultHTML .= <<< END_HTML
<tr><td colspan="4"><a href="/pictures/add.php">Add a Picture</a></td></tr>

END_HTML;

$end = $start + 24;

// get photos from the database

$sql = "SELECT * FROM pictures WHERE id <= $start ORDER BY id DESC LIMIT 24";
$result = mysql_query($sql, $db);
if(!$result)
{
$ResultHTML .= "<strong>Database Error:</strong> " . mysql_error();
return $ResultHTML;
};
$num_pics = mysql_num_rows($result);

if(!mysql_num_rows($result))
{
   $ResultHTML .= "<strong><b>No Photos!</strong>";
};
if(mysql_num_rows($result))
{

$index = 0;

for($col = 0 ; $col < ceil($num_pics / 4); $col++)
{
  $ResultHTML .= "<tr>\n";
  for($row = 0; $row < 4; $row++)
  {
    if(($col * 4 + $row) >= $num_pics)
      break;

    $img_id = mysql_result($result, $col * 4 + $row, "id");

    $img_html = <<< END_HTML
<td align="center"><a class="ImageLink" href="view/$img_id/"><img src="php_img_small.php?id=$img_id" /></a></td>

END_HTML;

    $ResultHTML .= $img_html;
  }; // end row
  $ResultHTML .= "</tr>";
  if(($col * 4 + $row) >= $num_pics)
    break;
}; // end column
 
}; // end if photos


if($USER['id'] < 50) $ResultHTML .= <<< END_HTML
<tr><td colspan="4"><a href="/pictures/add.php">Add a Picture</a></td></tr>
END_HTML;

$tmp = <<< END_HTML
<tr><!-- Photo Navigation row -->
<td align="left" colspan="2">
END_HTML;
$ResultHTML .= $tmp;

if($current_page != 0)
    $ResultHTML .= "<a href='./index.php?start=$prev'>&laquo; Previous Page</a>";

$tmp = <<< END_HTML
</td>
<td align="right" colspan="2">
END_HTML;
$ResultHTML .= $tmp;

if($current_page != $page_count - 1)
    $ResultHTML .= "<a href='./index.php?start=$next'>Next Page &raquo;</a>";

$tmp = <<< END_HTML
</td>
</tr>
</table>
END_HTML;
$ResultHTML .= $tmp;

return $ResultHTML;

}; // end function

////////////////////////////////////////////////////////////////////////////////

function pictures_getComments($picture_id)
{
	global $db;
	$sql = "SELECT * FROM picture_comments WHERE picture_id = $picture_id ORDER BY timestamp ASC";
	$result = mysql_query($sql, $db);

	if(!$result)
		return "<strong>No Comments</strong><!-- mySQL Error: " . mysql_error() . " -->\n\n";

	$numComments = mysql_num_rows($result);

	if(!$numComments)
		return "<strong>No Comments</strong>";

	$output = "";

	for($i = 0; $i < $numComments; $i++)
	{
		$author_id = mysql_result($result, $i, "author_id");
		$timestamp = mysql_result($result, $i, "timestamp");
		$Text = mysql_result($result, $i, "text");

		$Date = date("M. jS, g:ia", $timestamp);
		$AuthorObj = loadPage($author_id);
		$AuthorName = $AuthorObj['name'];

		//if($i % 2)
		//	$Class = "PictureComment PictureCommentAlt";
		//else
			$Class = "PictureComment";

		$buffer = <<< END_HTML
<div class="$Class">
<p class="Author">$AuthorName</p>
<p class="Date">$Date</p>
<p>$Text</p>
</div><!-- comment -->
END_HTML;

		$output .= $buffer;
	};

	return $output;
};

////////////////////////////////////////////////////////////////////////////////

function pictures_addComment($picture_id, $author_id, $text)
{
	global $db;
	$timestamp = time();

	$sql = "INSERT INTO picture_comments (picture_id, author_id, timestamp, text) VALUES ($picture_id, $author_id, $timestamp, '$text')";

	$result = mysql_query($sql, $db);
};

?>
