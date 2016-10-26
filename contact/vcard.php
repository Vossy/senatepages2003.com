<?php

include("../include/php_dbconnect.inc");

$sql = "SELECT * FROM pages WHERE id=$page LIMIT 1";

$result = mysql_query($sql, $db);

$First = mysql_result($result, 0, "first");
$Last = mysql_result($result, 0, "last");
$Address = mysql_result($result, 0, "address");
$Address = ereg_replace("\r\n", " " , $Address);
$sn = mysql_result($result, 0, "sn");
$Email = mysql_result($result, 0, "email");
$HomePhone = mysql_result($result, 0, "home_phone");
$CellPhone = mysql_result($result, 0, "cell_phone");

$FullName = $First . " " . $Last;

$VCard = <<< END_VCARD_TEMPLATE
BEGIN:VCARD
VERSION:3.0
FN:$FullName
N:$Last;$First;;;
EMAIL:$Email
TEL;TYPE=HOME:$HomePhone
TEL;TYPE=CELL:$CellPhone
ADR;TYPE=HOME:$Address;
END:VCARD
END_VCARD_TEMPLATE;

header("Content-type: text/x-vcard");

echo $VCard;

?>
