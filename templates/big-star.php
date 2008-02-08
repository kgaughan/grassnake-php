<?php if (!Users::current()->can('post')) { ?>
<img src="<?php ee($ctx->application_root()) ?>assets/images/big-star-unwatched.png" width="52" height="52" alt="Unwatched" title="Unwatched">
<?php } elseif ($assigned_user_id == Users::current()->get_id()) { ?>
<img src="<?php ee($ctx->application_root()) ?>assets/images/big-star-owned.png" width="52" height="52" alt="Owned" title="Owned">
<?php } elseif ($watched) { ?>
<form class="remoted" method="post" action="<?php ee($ctx->application_root()) ?>watches/<?php echo $id ?>"><input type="image" src="<?php ee($ctx->application_root()) ?>assets/images/big-star-watched.png" title="Unwatched"><input type="hidden" name="_method" value="delete"></form>
<?php } else { ?>
<form class="remoted" method="post" action="<?php ee($ctx->application_root()) ?>watches/"><input type="image" src="<?php ee($ctx->application_root()) ?>assets/images/big-star-unwatched.png" name="iid" value="<?php echo $id ?>" title="Unwatched"><input type="hidden" name="_method" value="post"></form>
<?php } ?>
