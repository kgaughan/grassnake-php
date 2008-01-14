<form method="post" action="<?php ee($ctx->application_root()) ?>projects/">
<fieldset>
<legend>New Project</legend>
<table>
	<tr>
		<th><label for="name">Name</label></th>
		<td><input type="text" name="name" id="name" value=""></td>
	</tr>
	<tr>
		<th><label for="user_id">Lead</label></th>
		<td><?php $this->render('developer-select', array('devs' => Users::get_developers())) ?></td>
	</tr>
</table>
<input type="submit" value="Add">
</fieldset>
</form>
