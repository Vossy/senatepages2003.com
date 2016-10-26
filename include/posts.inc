<?php

include_once("php_dbconnect.inc");

$PostTemplate = <<< END_TEMPLATE
<div class="Post">
<h3 class="PostTitle"><a class="PostLink" href="/PostID/<#ID#>"><#TITLE#></a></h3>
<p class="PostInfo"><#AUTHOR#> on <#DATE#></p>
<#BODY#>
</div>

<hr class="PostSeparator" />


END_TEMPLATE;

$OptionsTemplate = <<< END_XHTML

<p class="ExtraOption"><a href="/Recent/30">30 Most Recent &raquo;</a></p>
<!-- <p class="ExtraOption"><form action="index.php" method="get" style="float: right"><input type="text" size="4" name="recent" /><input type="submit" value=" most recent &raquo;" /></p>-->
<p class="ExtraOption"><a href="/search/">Search &raquo;</a></p>

END_XHTML;

// this file contains useful functions used to manage the posts database

function posts_top($num)
{
	global $db;
	global $PostTemplate;

	$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $num";
	$result = mysql_query($sql, $db);

	$num_posts = mysql_num_rows($result);

	for($index = 0; $index < $num_posts; $index++)
	{
		$id = mysql_result($result, $index, "id");
		$title = mysql_result($result, $index, "title");
		$date = mysql_result($result, $index, "date");
		$timestamp = mysql_result($result, $index, "timestamp");
		$poster = mysql_result($result, $index, "poster");
		$text = mysql_result($result, $index, "text");

		if($timestamp == 0)
			$date = $date; // redundant, I know
		else
			$date = date("M. jS, g:ia", $timestamp);

		if($id < 1622)
			$text = ereg_replace("\n", "<br />", $text);

		if($title == "")
			$title = "[No Title]";

		$new_html = $PostTemplate;
		$new_html = ereg_replace("<#ID#>", $id, $new_html);
		$new_html = ereg_replace("<#AUTHOR#>", $poster, $new_html);
		$new_html = ereg_replace("<#DATE#>", $date, $new_html);
		$new_html = ereg_replace("<#TITLE#>", $title, $new_html);
		$new_html = ereg_replace("<#BODY#>", $text, $new_html);

		$post_html = $post_html . $new_html;

	}; // end output loop

	$extra_html = <<< END_HTML
<p class="ExtraOption"><a href="/search/">Search &raquo;</a></p>
END_HTML;

	$post_html = $post_html; //. $extra_html;

	return $post_html;

};  // end function

////////////////////////////////////////////////////////////////////////

function posts_getnew()
{
	global $db;
	global $PostTemplate;
	global $OptionsTemplate;
	global $USER;

/*
   if(!isset($_COOKIE['last-post']))
   {
      // set a cookie for future reference
      $sql = "SELECT id FROM posts WHERE 1 ORDER BY id DESC LIMIT 1";
      $result = mysql_query($sql, $db);
      $top_post_id = mysql_result($result, 0, "id");
      setcookie("last-post", $top_post_id, (time()+60*60*24*14), "/");

      // return the top 30 posts
      return posts_top(30);
   }
   else
   {
      // retrive that variable
      $last_post = $_COOKIE['last-post'];

      // retrive our posts!
      $sql = "SELECT * FROM posts WHERE id > $last_post ORDER BY id DESC";
      $result = mysql_query($sql, $db);

      $num_posts = mysql_num_rows($result);

      if($num_posts == 0)
      {

          $error = <<< ERROR_HTML
<h3 class="PostTitle">No New Posts Since Last Visit</h3>
ERROR_HTML;

          $error .= $OptionsTemplate;

          return $error;
       };

      // set a cookie for future reference
     $top_post_id = mysql_result($result, 0, "id");
     setcookie("last-post", $top_post_id, (time()+60*60*24*14), "/");

      $post_html = <<< END_HTML
<h3 class="PostTitle">$num_posts Posts Since Last Visit:</h3>
END_HTML;

      for($index = 0; $index < $num_posts; $index++)
      {
         $title = mysql_result($result, $index, "title");
         $date = mysql_result($result, $index, "date");
         $poster = mysql_result($result, $index, "poster");
         $text = mysql_result($result, $index, "text");
      $id = mysql_result($result, $index, "id");
     if($id < 1622)
       $text = ereg_replace("\n", "<br />", $text);

	if($title == "")
		$title = "[No Title]";

	$new_html = $PostTemplate;
	$new_html = ereg_replace("<#ID#>", $id, $new_html);
	$new_html = ereg_replace("<#AUTHOR#>", $poster, $new_html);
	$new_html = ereg_replace("<#DATE#>", $date, $new_html);
	$new_html = ereg_replace("<#TITLE#>", $title, $new_html);
	$new_html = ereg_replace("<#BODY#>", $text, $new_html);

        $post_html = $post_html . $new_html;
      }; // end output loop

       $extra_html = <<< EXTRA_HTML
<div align="right">
<font face="Helvetica, Verdana, sans-serif" size="2"><a href="/Recent/30">30 Most Recent &raquo;</a>
<br />
<a href="/index.php?all=1">All Posts &raquo;</a>
</font>
</div>
<br />
EXTRA_HTML;

     $post_html = $post_html . $extra_html;

     return $post_html;

   }; // end case for cookie processing
*/

	if(isset($_COOKIE['last-post']))
	{
		// grab the variable
		$LastPost = $_COOKIE['last-post'];

		// delete the cookie
		setcookie("last-post", "", 5, "/");

	}
	else if(isset($USER['LastPost']))
		$LastPost = $USER['LastPost'];
	else
		$LastPost = -1;

	if($LastPost == 0)
		$LastPost = -1;

	if($LastPost != -1)
		$sql = "SELECT * FROM posts WHERE id > $LastPost ORDER BY id DESC";
	else
		$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 30";
	$result = mysql_query($sql, $db);

	if(!$result)
		return "<!-- LastPost: $LastPost -->\n" . "<strong>Error: </strong>" . mysql_error();

	$NumNewPosts = mysql_num_rows($result);

	if($NumNewPosts == 0)
	{
		$error = <<< ERROR_HTML
<h3 class="PostTitle">No New Posts Since Last Visit</h3>
ERROR_HTML;

		return $error . $OptionsTemplate;
	};

	$UserID = $USER['id'];
	$LatestPost = mysql_result($result, 0, "id");
	$sql = "UPDATE pages SET LastPost='$LatestPost' WHERE id=$UserID LIMIT 1";
	$result =  mysql_query($sql, $db);

	$HtmlPrefix = <<< END_HTML
<h3 class="PostTitle">$NumNewPosts Posts Since Last Visit:</h3>
END_HTML;

	return $HtmlPrefix . posts_top($NumNewPosts) . $OptionsTemplate;

}; // end function

////////////////////////////////////////////////////////////////////////

function posts_getall()
{
   global $db;

   $sql = "SELECT * FROM posts WHERE 1 ORDER BY id DESC";
   $result = mysql_query($sql, $db);


   $num_posts = mysql_num_rows($result);

   for($index = 0; $index < $num_posts; $index++)
   {
      $title = mysql_result($result, $index, "title");
      $date = mysql_result($result, $index, "date");
      $poster = mysql_result($result, $index, "poster");
      $text = mysql_result($result, $index, "text");

      $id = mysql_result($result, $index, "id");
     if($id < 1622)
       $text = ereg_replace("\n", "<br />", $text);

	if($title == "")
		$title = "[No Title]";

      $new_html = <<< END_HTML
<FONT face="Helvetica, Verdana, sans-serif" size="4">
<b><a class="PostLink" href="/PostID/$id">$title</a></b></font>
<br />
<font face="Helvetica, Verdana, sans-serif" size="1" color="#aaaaff">
Posted $date by $poster
</font>
<br /><br />
<font face="Helvetica, Verdana, sans-serif" size="2">
$text
</font>
<br /><br />
END_HTML;

     $post_html = $post_html . $new_html;

   }; // end output loop

   return $post_html;

};  // end function

function posts_getbyid($id)
{
global $db;
global $PostTemplate;

   $sql = "SELECT * FROM posts WHERE id=$id ORDER BY id DESC";
   $result = mysql_query($sql, $db);

      $title = mysql_result($result, 0, "title");
      $date = mysql_result($result, 0, "date");
      $poster = mysql_result($result, 0, "poster");
      $text = mysql_result($result, 0, "text");
      $id = mysql_result($result, 0, "id");

	if($id < 1622)
		$text = ereg_replace("\n", "<br />", $text);

	if($title == "")
		$title = "[No Title]";

	$post_html = $PostTemplate;
	$post_html = ereg_replace("<#ID#>", $id, $post_html);
	$post_html = ereg_replace("<#AUTHOR#>", $poster, $post_html);
	$post_html = ereg_replace("<#DATE#>", $date, $post_html);
	$post_html = ereg_replace("<#TITLE#>", $title, $post_html);
	$post_html = ereg_replace("<#BODY#>", $text, $post_html);

   return $post_html;

};  // end function

function posts_object($id)
{
	global $db;

	$sql = "SELECT * FROM posts WHERE id = $id LIMIT 1";
	$result = mysql_query($sql, $db);

	$post['id'] = $id;
	$post['title'] = mysql_result($result, 0, "title");
	$post['text'] = mysql_result($result, 0, "text");
	$post['authorID'] = mysql_result($result, 0, "author_id");
	$post['authorName'] = mysql_result($result, 0, "poster");
	$post['timestamp'] = mysql_result($result, 0, "timestamp");
	$post['date'] = mysql_result($result, 0, "date");

	return $post;
};

?>