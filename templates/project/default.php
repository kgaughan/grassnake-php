<?php $this->with_envelope() ?>

<?php start_slot('breadcrumbs') ?>
<a href=".">Projects</a> &raquo;
Issues for <?php ee($name) ?>
<?php end_slot() ?>

<h1>Issues for <?php ee($name) ?></h1>

<?php if (empty($issues)) { ?>
	<p>This project has no open issues. Maybe you should create one?</p>
<?php } else { ?>
	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th width="13">&nbsp;</th>
				<th>Title</th>
				<th width="10%">Priority</th>
				<th width="10%">Resolution</th>
				<th width="18%">Assigned to</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($issues as $r) { ?>
			<tr>
				<td class="numeric"><?php echo $r['id'] ?></td>
				<td><?php $this->render('star', $r) ?></td>
				<td><a href="../issues/<?php ee($r['id']) ?>"><?php ee($r['title']) ?></a></td>
				<td><?php ee($r['priority']) ?></td>
				<td><?php ee($r['resolution']) ?></td>
				<td><?php echo_username($r['assigned_user_id']) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>

<?php if (AFK_User::get_logged_in_user()->can('post')) { ?>
<?php start_slot('sidebar') ?>
<form method="post" action="">
<fieldset>
<legend>New Issue</legend>
<table>
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
		<th>Type</th>
		<td>
			<label><input type="radio" name="priority" value="4" checked="checked"> Bug</label>
			<label><input type="radio" name="priority" value="1"> Enhancement</label>
		</td>
	</tr>
</table>
<input type="submit" value="Submit Issue">
</fieldset>
</form>
<?php end_slot() ?>
<?php } ?>
