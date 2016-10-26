<!-- NAVIGATION MENU -->
<ul>
	<li><a href="/">home</a></li>
	<li><a href="/reunion/">reunion</a></li>
	<li><a href="/account/">my account</a></li>
	<li><a href="/contact/">get contact info</a></li>
<?php if($user_id < 50){ ?>
	<li><a href="/post/add-new.php">add a post</a></li>
<?php }; ?>
	<li><a href="/pictures/">share pictures</a></li>
	<li><a href="/search/">search</a></li>
	<li><a href="/logout/">logout</a></li>
</ul>
