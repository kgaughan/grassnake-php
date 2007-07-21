<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html><head>

	<title><?php echo_title($page_title, 'GrassSnake') ?></title>
	<?php stylesheets() ?>

</head><body>

<div id="nav" align="right">
<span style="float:left">
<a href="<?php ee($ctx->application_root()) ?>">GrassSnake</a>
<?php if (has_slot('breadcrumbs')) { ?>
	&raquo; <?php get_slot('breadcrumbs') ?>
<?php } ?>
</span>

<?php ee(AFK_User::get_logged_in_user()->get_username()) ?> |
<a href="<?php ee($ctx->application_root()) ?>about">About</a> |
<a href="<?php ee($ctx->application_root()) ?>projects/">Projects</a> |
<a href="<?php ee($ctx->application_root()) ?>issues/">Issues</a>
</div>

<div id="body">
<div id="sidebar">
<form method="post" action="<?php ee($ctx->application_root()) ?>issues/">
<fieldset>
<legend>Search</legend>

<select name="criterion" disabled="disabled">
<option value="1">All Issues</option>
<option value="2">Open Issues</option>
<option value="3">My Issues</option>
<option value="4">My Watches</option>
<option value="5">New Issues</option>
<option value="6">Issues to Verify</option>
</select>
for
<input type="text" name="q" disabled="disabled" value="Not written yet."/>

<input type="submit" value="Search" disabled="disabled"/>
</fieldset>
</form>
<?php get_slot('sidebar') ?>
</div>

<?php echo $generated_content ?>
</div>

</body></html>
