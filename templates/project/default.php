<?php $this->with_envelope() ?>

<?php start_slot('breadcrumbs') ?>
<a href=".">Projects</a> &raquo;
Issues for <?php ee($name) ?>
<?php end_slot() ?>

<h1>Issues for <strong><?php ee($name) ?></strong></h1>

<?php if (empty($issues)) { ?>
	<p>This project has no open issues. Maybe you should create one?</p>
<?php } else { ?>
	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th width="13"><img src="../assets/images/eye.png" width="13" height="13" alt="Watches" title="Watches"></th>
				<th>Title</th>
				<th width="10%">Priority</th>
				<th width="17%">Status</th>
				<th width="18%">Assigned to</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($issues as $r) { ?>
			<tr>
				<td class="numeric"><a href="../issues/<?php ee($r['id']) ?>"><?php echo $r['id'] ?></a></td>
				<td><?php $this->render('star', $r) ?></td>
				<td><a href="../issues/<?php ee($r['id']) ?>"><?php ee($r['title']) ?></a></td>
				<td><?php ee($r['priority']) ?></td>
				<td><?php ee($r['status']) ?></td>
				<td><?php echo_username($r['assigned_user_id']) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>

<?php if (Users::current()->can('post')) { ?>
<?php start_slot('sidebar') ?>
<?php $this->render('new-issue') ?>
<?php end_slot() ?>
<?php } ?>
