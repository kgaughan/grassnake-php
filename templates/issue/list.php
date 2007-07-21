<?php $this->with_envelope() ?>

<?php start_slot("breadcrumbs") ?>
All Issues
<?php end_slot() ?>

<h1>All Issues</h1>

<?php if (empty($issues)) { ?>
	<p>There are no issues recorded.</p>
<?php } else { ?>
	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th width="13">&nbsp;</th>
				<th width="18%">Assigned to</th>
				<th width="10%">Priority</th>
				<th width="10%">Resolution</th>
				<th>Title</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($issues as $r) { ?>
			<tr>
				<td class="numeric"><?php echo $r['id'] ?></td>
				<td><?php $this->render('star', $r) ?></td>
				<td><?php echo_username($r['assigned_user_id']) ?></td>
				<td><?php ee($r['priority']) ?></td>
				<td><?php ee($r['resolution']) ?></td>
				<td><a href="<?php echo $r['id'] ?>"><strong><?php ee($r['project']) ?>:</strong> <?php ee($r['title']) ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
