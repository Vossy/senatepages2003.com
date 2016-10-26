<?php

$secure_page = 1;
$page_name = "Home > Add A Post";

include("../include/php_header.inc");
/*
?>

<font face="Helvetica, Verdana, sans-serif" size="4"><b>Add A Post</b></font>
<br />
<br />
<font face="Helvetica, Verdana, sans-serif" size="2">
<form method="POST" action="submit.php">
Title:<br />
<input type="text" name="title" size="40" value="Untitled" />
<br />
Main Text:<br />
<textarea cols="50" rows="20" name="text">Write your post here...</textarea>
<br />
<input type="submit" value="Add Post" />
</form>
</font>

<?php
*/

    $width=430;
    $height=220;
    $content=addslashes('');
    $wysiwyg_path='/post';
    $posted_field_name='text';

?>

   <div>
<font size="4"><b>Add A Post</b></font>
    <form method="post" onsubmit="ProcessInfo()" action="submit.php">

Title:<br />
<input type="text" name="title" size="40" value="Untitled" />
<br />
<br />

     <script type="text/javascript" src="<?php echo $wysiwyg_path ?>/browserdetect.js"></script>
     <script type="text/javascript" src="<?php echo $wysiwyg_path ?>/editor.js"></script>
     <script type="text/javascript">
      Display('<?php echo $posted_field_name ?>','<?php echo $wysiwyg_path ?>',<?php echo $width ?>,<?php echo $height ?>,'<?php echo $content ?>')
     </script>
     <noscript>
      <p style="notSupported">Your browser does not support the WYSIWYG editor. The textarea below may have HTML code, and the script you are posting to will expect HTML as well.</p>
      <textarea name="html_content" rows="30" cols="100"><?php echo $content ?></textarea>
     </noscript>
     <input type="submit" value="Submit" name="update" /><br /><br />
    </form>
   </div>

<?php
include("../include/php_closing.inc");

?>

