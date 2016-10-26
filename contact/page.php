<?php

include_once("../include/php_dbconnect.inc");

$page = $_GET['page'];

$sql = "SELECT * FROM pages WHERE id=$page LIMIT 1";

$result = mysql_query($sql, $db);

$first = mysql_result($result, 0, "first");
$last = mysql_result($result, 0, "last");
$addressRaw = mysql_result($result, 0, "address");
$address = ereg_replace("\n", "<br />", $addressRaw);
$addressLink = ereg_replace("\r\n", " ", $addressRaw);
$sn = mysql_result($result, 0, "sn");
$email = mysql_result($result, 0, "email");
$home_phone = mysql_result($result, 0, "home_phone");
$cell_phone = mysql_result($result, 0, "cell_phone");
$CollegeDecided = mysql_result($result, 0, "CollegeDecided");

$name = $first . " " . $last;

$page_name = "Home > Get Contact Info > $name";

$secure_page = 1;

$PageType = "contact.page";

include("../include/php_header.inc");

  $sql = "SELECT * FROM posts WHERE author_id = $page";
  $result = mysql_query($sql, $db);
  if($result)
     $TotalPostCount = mysql_num_rows($result);
  else
     $TotalPostCount = "<!-- " . mysql_error() . " -->0";

  $sql = "SELECT * FROM pictures WHERE submitter = $page";
  $result = mysql_query($sql, $db);
  if($result)
     $TotalPicCount = mysql_num_rows($result);
  else
     $TotalPicCount = "<!-- " . mysql_error() . " -->0";

$PAGE = loadPage($page);

$fbook = false;
if(strlen($PAGE['fbookURL']) > 1)
{
	$fbook = true;
	ereg("id=([0-9]+)", $PAGE['fbookURL'], $regs);
	$fbookID = $regs[1];
}

?>

<div id="ContactInfo">

<?php if($USER['id'] == $page) { echo "<a href=\"/contact/edit/\" class=\"EditLink\">Edit &raquo;</a>"; }; ?>

<h2><?php echo $name; ?></h2>

<?php if($fbook){ ?>

<div class="fbook">
	<ul>
		<li><a href="<?= $PAGE['fbookURL']; ?>"><?= $PAGE['first']; ?>'s Profile</a></li>
		<li><a href="http://www.facebook.com/photo_search.php?id=<?= $fbookID; ?>">Photos of <?= $PAGE['first']; ?></a></li>
		<li><a href="http://www.facebook.com/message.php?id=<?= $fbookID; ?>">Send <?= $PAGE['first']; ?> a Message</a></li>
		<li><a href="http://www.facebook.com/poke.php?id=<?= $fbookID; ?>">Poke <?= $PAGE['first']; ?></a></li>
	</ul>
</div>

<?php } ?>

<div id="Etc">
	<h3>Essentials</h3>
	<p class="phone phone-cell">cell: <?php echo $PAGE['phone']['cell']; ?></p>
	<p class="email">email: <a href="mailto:<?php echo $PAGE['email']; ?>"><?php echo $PAGE['email']; ?></a></p>
	<p class="im">AIM: <?php if($PAGE['screenName']['aim'] != ""){ ?>
<img src="http://big.oscar.aol.com/<?php echo $PAGE['screenName']['aim']; ?>?on_url=http://www.senatepages2003.com/images/aim-online.png&off_url=http://www.senatepages2003.com/images/aim-offline.png" alt="AIM Status" title="AIM Status" /><?php }; ?>
<a href="aim:goim?Screenname=<?php echo $PAGE['screenName']['aim']; ?>"><?php echo $PAGE['screenName']['aim']; ?></a></p>
</div>

<div id="Home">
	<h3>Home</h3>
	<p class="address"><?php echo ereg_replace("\n", "<br />", $PAGE['address']['home']); ?></p>
	<p class="phone phone-home"><?php echo $PAGE['phone']['home']; ?></p>
</div>

<div id="College">
	<h3>College</h3>
	<p><strong><?php echo $PAGE['college']; ?></strong></p>
	<p class="address"><?php echo ereg_replace("\n", "<br />", $PAGE['address']['college']); ?></p>
	<p class="phone phone-home"><?php echo $PAGE['phone']['college']; ?></p>
</div>

<div id="Stats">
	<h3>Stats</h3>
	<p><strong><?php echo $TotalPostCount; ?></strong> posts</p>
	<p><strong><?php echo $TotalPicCount; ?></strong> pictures</p>
</div>

<?php

$sql = "SELECT * FROM pictures WHERE people LIKE '%[$page]%' ORDER BY id DESC LIMIT 4";
$result = mysql_query($sql, $db);

if($result){
	echo "<p><strong>Photos of " . $PAGE['first'] . "</strong></p>\n\n<table><tr>";
	for($i = 0; $i < mysql_num_rows($result); $i++)
	{
		$img = mysql_result($result, $i, "id");
		// echo $img . " ";
		echo "<td><a class=\"ImageLink\" href=\"/pictures/view/$img/\"><img src=\"/pictures/php_img_small.php?id=$img\" /></td>";
	}
	echo "</tr></table>\n\n";
	echo "<p><a href=\"/contact/$page/photos/\">more photos &raquo;</a></p>";
	if($fbook)
		echo "<p><a href=\"http://www.facebook.com/photo_search.php?id=$fbookID\">Facebook photos &raquo;</a></p>";
}
else
	echo "<p><strong>No Photos</strong></p>";

?>

</div><!-- #ContactInfo -->

<?php

include("../include/php_closing.inc");

?>

