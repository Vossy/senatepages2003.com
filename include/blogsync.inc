<?php

function LoadBlogData($id)
{
	global $db;

	$sql = "SELECT BlogData FROM pages WHERE id = $id LIMIT 1";
	$result = mysql_query($sql, $db);

	if(!$result)
		return false;

	$BlogData = mysql_result($result, 0, "BlogData");

	if($BlogData == "")
		return false;

	$BlogDataItems = explode("\n", $BlogData);

	foreach($BlogDataItems as $Item)
	{
		$tmp = explode(": ", $Item);
		$BlogDataArray[$tmp[0]] = $tmp[1];
	};

	return $BlogDataArray;
};

function SaveBlogData($id, $BlogDataArray)
{
	global $db;

	$BlogDataKeys = array_keys($BlogDataArray);

	$tmp = "";

	foreach($BlogDataKeys as $Key)
		$tmp .= $Key . ": " . $BlogDataArray[$Key] . "\n";

	$sql = "UPDATE pages SET BlogData = '$tmp' WHERE id = $id LIMIT 1";
	$result = mysql_query($sql, $db);
};

function CreateBlog($id, $URL)
{
	global $db;
	include_once("/home/jvoss/public_html/include/rss_fetch.inc");

	$BlogData['URL'] = $URL;

	$rss = fetch_rss($URL);

	if(!$rss)
		return 0;

	foreach($rss->items as $item)
	{
		if(isset($item['msn']) && $item['msn']['type'] != "blogentry")
			continue;

		if(isset($item['guid']))
			$GUID = $item['guid'];
		else
			$GUID = $item['link'];

		$BlogData['PrevItemList'] .= " " . $GUID;

	}; // end foreach($rss->items)

	$BlogData['ChannelTitle'] = $rss->channel['title'];

	SaveBlogData($id, $BlogData);

};

function FindBloggerFeed($UserName)
{
	include_once("/home/jvoss/public_html/include/rss_fetch.inc");

	$AtomUrl = "http://" . $UserName . ".blogspot.com/atom.xml";
	$RssUrl = "http://" . $UserName . ".blogspot.com/rss/" . $UserName . ".xml";

	if(@!fetch_rss($AtomUrl))
		return $RssUrl;
	if(@!fetch_rss($RssUrl))
		return $AtomUrl;

	// if we're still here, then both are valid.
	// now what?
	// return "false" and let some other function worry about it

	return false;
};

function AskBloggerForm($UserName)
{
	include_once("/home/jvoss/public_html/include/rss_fetch.inc");

	// both Atom and RSS urls must be valid
	$AtomUrl = "http://" . $UserName . ".blogspot.com/atom.xml";
	$RssUrl = "http://" . $UserName . ".blogspot.com/rss/" . $UserName . ".xml";

	AskFeedForm($AtomUrl);

	AskFeedForm($RssUrl);

};

function AskFeedForm($Url)
{
	include_once("/home/jvoss/public_html/include/rss_fetch.inc");

	$html = <<< END_HTML
<div class="SelectFeed" style="border: 1px solid #ddd; padding: 10px; margin: 5px;">
<form action="blogsync.php" method="post">
<input type="hidden" name="form" value="blogsync.confirm" />
<input type="hidden" name="url" value="$Url" />
<input type="submit" value="Use This Feed">
END_HTML;

	echo $html;

	$rss = fetch_rss($Url);

	echo "<p><strong>Title:</strong> " . $rss->channel['title'] . "</p>";

	echo "<p><strong>Latest Post:</strong> " . $rss->items[0]['title'] . "</p>";

	echo "</div>";
};

function CheckForNewItems($ID)
{
	if(!$BlogData = LoadBlogData($ID))
		return false;

	include_once($_SERVER['DOCUMENT_ROOT'] . "/include/rss_fetch.inc");

	if(!$rss = fetch_rss($BlogData['URL']))
		return false;

	for($i = 0; $i < sizeof($rss->items); $i++)
	{
		if($rss->items[$i]['guid'])
			$guid = $rss->items[$i]['guid'];
		else
			$guid = $rss->items[$i]['link'];

		if(ereg($guid, $BlogData['PrevItemList']))
			unset($rss->items[$i]);
	};

	return $rss;
};

?>
