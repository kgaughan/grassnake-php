<?php $this->with_envelope() ?>

<?php start_slot("breadcrumbs") ?>
Projects
<?php end_slot() ?>

<h1>Projects</h1>

<?php if (empty($projects)) { ?>
	<p>No projects. Maybe you should create one?</p>
<?php } else { ?>
	<table class="data">
		<thead>
			<tr>
				<th>Project</th>
				<th width="20%">Lead</th>
				<th class="numeric" width="6%">Issues</th>
				<th class="numeric" width="5%">Open</th>
				<th class="numeric" width="9%">Suspended</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			$open = 0;
			$suspended = 0;
			?>
			<?php foreach ($projects as $r) { ?>
			<tr>
				<td><a href="<?php echo $r['id'] ?>"><?php ee($r['project']) ?></a></td>
				<td><?php ee(Users::get($r['lead_user_id'])->get_username()) ?></td>
				<td class="numeric"><?php echo $r['issues'] ?></td>
				<?php $count += $r['issues'] ?>
				<td class="numeric"><?php echo $r['open'] ?></td>
				<?php $open += $r['open'] ?>
				<td class="numeric"><?php echo $r['suspended'] ?></td>
				<?php $suspended += $r['suspended'] ?>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">Totals</th>
				<td class="numeric"><?php echo $count ?></td>
				<td class="numeric"><?php echo $open ?></td>
				<td class="numeric"><?php echo $suspended ?></td>
			</tr>
		</tfoot>
	</table>
<?php } ?>

<?php if (Users::current()->can('post')) { ?>
<?php start_slot('sidebar') ?>
<form method="post" action="">
<fieldset>
<legend>New Project</legend>
<table>
	<tr>
		<th><label for="name">Name</label></th>
		<td><input type="text" name="name" id="name" value=""></td>
	</tr>
	<tr>
		<th><label for="user">Lead</label></th>
		<td><?php $this->render('developer-select', compact('devs')) ?></td>
	</tr>
</table>
<input type="submit" value="Add">
</fieldset>
</form>
<?php end_slot() ?>
<?php } ?>
