<?php $projects = Projects::get_active() ?>
<?php if (isset($pid) || count($projects) > 0) { ?>
<form method="post" action="<?php ee($ctx->application_root()) ?>issues/">
<?php if (isset($pid)) { ?>
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<?php } ?>
<fieldset>
<legend>New Issue</legend>
<table>
<?php if (!isset($pid)) { ?>
	<tr>
		<th><label for="pid">Project</label></th>
		<td><?php select_box('pid', $projects) ?></td>
	</tr>
<?php } ?>
	<tr>
		<th><label for="title">Title</label></th>
		<td><input type="text" name="title" id="title" value=""></td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="message" rows="15">
What steps will reproduce the problem?
1.
2.
3.

What is the expected output? What do you see instead?


What version of the product are you using? On what operating system?


Please provide any additional information below.
</textarea></td>
	</tr>
	<tr>
		<th>Type/Priority</th>
		<td>
			<label><input type="radio" name="priority" value="4" checked="checked"> Bug (Defaults to Medium Priority)</label><br>
			<label><input type="radio" name="priority" value="1"> Enhancement</label>
		</td>
	</tr>
</table>
<input type="submit" value="Submit Issue">
</fieldset>
</form>
<?php } ?>
