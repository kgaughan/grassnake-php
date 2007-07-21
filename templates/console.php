<?php $this->with_envelope() ?>

<h1>Open Issues Assigned to You</h1>

<?php if (!empty($issues)) { ?>
	<table class="data">
		<thead>
			<tr>
				<th class="numeric" width="5%">#</th>
				<th>Title</th>
				<th width="15%">Project</th>
				<th width="10%">Priority</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($issues as $r) { ?>
			<tr>
				<td class="numeric"><?php echo $r['id'] ?></td>
				<td><a href="issues/<?php echo $r['id'] ?>"><?php ee($r['title']) ?></a></td>
				<td><a href="projects/<?php echo $r['project_id'] ?>"><?php ee($r['project']) ?></a></td>
				<td><?php ee($r['priority']) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else { ?>
	<p>You have no issues assigned to you.</p>
<?php } ?>

<h1>Your Watches</h1>

<?php if (!empty($watches)) { ?>
	<ul>
	<?php foreach ($watches as $r) { ?>
	<li><?php ee($r['title']) ?></li>
	<?php } ?>
	</ul>
<?php } else { ?>
	<p>You have no watches.</p>
<?php } ?>
