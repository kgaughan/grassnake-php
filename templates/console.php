<?php $this->with_envelope() ?>

<?php if (!empty($issues)) { ?>
	<h1>Open Issues Assigned to You</h1>

	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th>Title</th>
				<th width="10%">Priority</th>
				<th width="15%">Last Updated</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($issues as $r) { ?>
			<tr>
				<td class="numeric"><?php echo $r['id'] ?></td>
				<td><a href="projects/<?php echo $r['project_id'] ?>"><?php ee($r['project']) ?></a>: <a href="issues/<?php echo $r['id'] ?>"><?php ee($r['title']) ?></a></td>
				<td><?php ee($r['priority']) ?></td>
				<td><?php ee(date('j-M-Y, H:i', strtotime($r['last_updated']))) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>

<?php if (!empty($watches)) { ?>
	<h1>Your Watches</h1>

	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th>Title</th>
				<th width="10%">Status</th>
				<th width="10%">Priority</th>
				<th width="15%">Last Updated</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($watches as $r) { ?>
			<tr>
				<td class="numeric"><?php echo $r['id'] ?></td>
				<td><a href="projects/<?php echo $r['project_id'] ?>"><?php ee($r['project']) ?></a>: <a href="issues/<?php echo $r['id'] ?>"><?php ee($r['title']) ?></a></td>
				<td><?php ee($r['status']) ?></td>
				<td><?php ee($r['priority']) ?></td>
				<td><?php ee(date('j-M-Y, H:i', strtotime($r['last_updated']))) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>

<?php if (empty($issues) && empty($watches)) { ?>
	<div class="encouragement">
	<p>Welcome to <strong>GrassSnake</strong>, the issue tracker that sucks a
	little less.</p>

	<p>You don&rsquo;t seem to be working on anything, and you&rsquo;re not
	watching the progress of any issues, so you might want to look through
	the <a href="projects/">projects</a>, or take a look through the
	<a href="issues/">issues already in the system</a>.</p>

	<p>Alternatively, you could always add a new one.</p>

	<p class="illustration"><img src="assets/images/blue-arrow.png"
		width="240" height="180" alt=""></p>
	</div>
<?php } ?>

<?php
if (Users::current()->can('post')) {
	start_slot('sidebar');
	$this->render('new-issue');
	$this->render('new-project');
	end_slot();
}
?>
