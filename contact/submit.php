<?php

include("../include/session.inc");

// no need to SQL for the page id, it's already set in $page

$page = $USER['id'];

$first = $_POST["first"];
$last = $_POST["last"];
$address = $_POST["address"];
$home_phone = $_POST["home_phone"];
$CollegeAddress = $_POST['CollegeAddress'];
$cell_phone = $_POST["cell_phone"];
$college_phone = $_POST["college_phone"];
$email = $_POST["email"];
$sn = $_POST['sn'];
$CollegeDecided = $_POST['CollegeDecided'];
$fbookURL = $_POST['fbookURL'];

$sql = "UPDATE pages SET first='$first', last='$last', address='$address', CollegeAddress='$CollegeAddress', home_phone='$home_phone', email='$email', cell_phone='$cell_phone', college_phone='$college_phone', sn='$sn', CollegeDecided='$CollegeDecided', fbookURL = '$fbookURL' WHERE id=$page";

mysql_query($sql, $db);

$sql = " ";

$sql = "SELECT * FROM pages WHERE id=$page";
$result = mysql_query($sql, $db);
$sql = " ";

$first = mysql_result($result, 0, "first");
$last = mysql_result($result, 0, "last");
$page_name = $first . " " .$last;

$page_name = "Home > Get Contact Info > $page_name > Edit > Submit";

header("Location: /contact/$page");

/*
include("/home/jvoss/public_html/include/php_header.inc");

?>

<TABLE width="500">
<TBODY>
<TR>
<TD>

<FONT face="Helvetica, Verdana, sans-serif" size="4">
<B>Info Updated</b></font><BR>
<FONT face="Helvetica, Verdana, sans-serif" size="2">
Your contact information has been updated.</font>

</td>
</tr>
</tbody>
</table>

<?php

include("/home/jvoss/public_html/include/php_closing.inc");
*/
?>

