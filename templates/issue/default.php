<?php $this->with_envelope() ?>

<?php start_slot("breadcrumbs") ?>
<a href="../projects/">Projects</a> &raquo;
<a href="../projects/<?php echo $project_id ?>">Issues for <?php ee($project) ?></a> &raquo;
<?php ee($title) ?>
<?php end_slot() ?>

<h1><span>Issue #<?php echo $id ?> (<?php ee($project) ?>):</span> <?php ee($title) ?></h1>

<?php $this->render_each('message', $messages) ?>

<?php start_slot('sidebar') ?>
<table class="data">
	<thead>
		<tr>
			<th>Priority</th>
			<th>Resolution</th>
			<th>Last Updated</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php ee($priority) ?></td>
			<td><?php ee($resolution) ?></td>
			<td><?php ee(date('j-M-Y, H:i', strtotime($last_updated))) ?></td>
		</tr>
	</tbody>
</table>

<form method="post" action="">
<fieldset>
<legend>New Message</legend>
<table>
	<tr>
		<td colspan="2"><textarea name="message" rows="15"></textarea></td>
	</tr>
	<tr>
		<th><label for="priority">Priority</label></th>
		<td><?php select('priority', $priorities, $priority_id) ?></td>
	</tr>
	<tr>
		<th><label for="resolution">Resolution</label></th>
		<td><?php select('resolution', $resolutions, $resolution_id) ?></td>
	</tr>
	<tr>
		<th><label for="user">Owned by</label></th>
		<td>
			<select name="user" id="user">
				<?php foreach ($devs as $dev) { ?>
				<option value="<?php ee($dev->get_id()) ?>"<?php if ($dev->get_id() == $assigned_user_id) echo ' selected="selected"' ?>><?php ee($dev->get_username()) ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
</table>
<input type="submit" value="Submit Message">
</fieldset>
</form>
<?php end_slot() ?>
