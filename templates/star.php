<?php if ($assigned_user_id == AFK_User::get_logged_in_user()->get_id()) { ?>
<img src="<?php ee($ctx->application_root()) ?>assets/images/star-owned.png" width="13" height="13" alt="Owned" title="Owned">
<?php } elseif ($watched) { ?>
<form class="remoted" method="post" action="<?php ee($ctx->application_root()) ?>watches/<?php echo $id ?>"><input type="image" src="<?php ee($ctx->application_root()) ?>assets/images/star-watched.png" title="Unwatched"><input type="hidden" name="_method" value="delete"></form>
<?php } else { ?>
<form class="remoted" method="post" action="<?php ee($ctx->application_root()) ?>watches/"><input type="image" src="<?php ee($ctx->application_root()) ?>assets/images/star-unwatched.png" name="id" value="<?php echo $id ?>" title="Unwatched"><input type="hidden" name="_method" value="post"></form>
<?php } ?>
