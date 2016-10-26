<?php

$page_name = "Home > Get Contact Info";
$secure_page = 1;

include("../include/php_header.inc");

$sql = "SELECT * FROM pages WHERE id<50 ORDER BY id ASC";
$result = mysql_query($sql, $db);
$sql = " ";

$num_pages = mysql_num_rows($result);

?>

<h1>Contact Info</h1>
<p>Click on a name below to get contact information.  Clicking on your own name will allow you to <a href="/contact/edit/">edit your contact information</a>.  An AIM icon (<img src="/images/aim-online.gif" alt="AIM" />) will appear by your name when you're signed on to AIM.</p>

<?php

for($index = 0; $index < $num_pages; $index++)
{
    $first = mysql_result($result, $index, "first");
    $last = mysql_result($result, $index, "last");
    $page_id = mysql_result($result, $index, "id");
    $AIM = mysql_result($result, $index, "sn");

    if($AIM != "")
        $AIMStatus = "<img style=\"vertical-align: middle;\" src=\"http://big.oscar.aol.com/$AIM?on_url=http://www.senatepages2003.com/images/aim-online.gif&off_url=http://www.senatepages2003.com/images/1px.gif\" alt=\"AIM Status\" />";
    else
      $AIMStatus = "";

    if($page_id == 31)
       echo "<hr />";

    // $LinkName = strtolower($first . "-" . $last . ".html");

    $link_html = <<< END_HTML
<p class="Contact"><a href="/contact/$page_id/$LinkName">$first $last</a>$AIMStatus</p>

END_HTML;

    echo $link_html;

}; // end link generation loop

?>


<?php

//}; // end if(isset($a))

include("../include/php_closing.inc");

?>

