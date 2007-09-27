<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html lang="en"><head>

	<title><?php echo_title($page_title, 'GrassSnake') ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php ee($ctx->application_root()) ?>favicon.ico">
	<?php stylesheets() ?>

</head><body>

<div id="nav" align="right">
<span style="float:left">
<a href="<?php ee($ctx->application_root()) ?>">GrassSnake</a>
<?php if (has_slot('breadcrumbs')) { ?> &raquo; <?php } ?>
<?php get_slot('breadcrumbs') ?>
</span>

<?php
$user = Users::current();
if (!is_null($user)) {
	ee($user->get_username(), ' | ');
}
?>
<a href="<?php ee($ctx->application_root()) ?>about">About</a> |
<a href="<?php ee($ctx->application_root()) ?>projects/">Projects</a> |
<a href="<?php ee($ctx->application_root()) ?>issues/">Issues</a>
</div>

<div id="body">
<div id="sidebar">
<?php /*
<form method="post" action="<?php ee($ctx->application_root()) ?>issues/">
<fieldset>
<legend>Search</legend>

<select name="criterion">
<option value="all">All Issues</option>
<option value="open">Open Issues</option>
<option value="mine">My Issues</option>
<option value="watches">My Watches</option>
<option value="new">New Issues</option>
<option value="triage">Issues to Triage</option>
</select>
for
<input type="text" name="q" value="">

<input type="submit" value="Search">
</fieldset>
</form>
 */ ?>
<?php get_slot('sidebar') ?>
</div>

<?php echo $generated_content ?>
</div>

<address>
Copyright &copy; <a href="http://talideon.com/">Keith Gaughan</a>, 2007.
All Rights Reserved.
</address>

</body></html>
