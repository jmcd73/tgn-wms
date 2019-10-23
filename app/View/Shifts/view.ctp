<div class="container">
<h3><?= __('Shift'); ?></h3>
	<dl class="dl-horizontal">

                <dt><?= __('Active'); ?></dt>
		<dd>
			<?= h($shift['Shift']['active']); ?>

		</dd>
                <dt><?= __('Id'); ?></dt>
		<dd>
			<?= h($shift['Shift']['id']); ?>

		</dd>
		<dt><?= __('Name'); ?></dt>
		<dd>
			<?= h($shift['Shift']['name']); ?>

		</dd>
                 <dt><?= __('Start Time'); ?></dt>
		<dd>
			<?= h($shift['Shift']['start_time']); ?>

		</dd>
                <dt><?= __('Stop Time'); ?></dt>
		<dd>
			<?= h($shift['Shift']['stop_time']); ?>

		</dd>

		<dt><?= __('Shift Minutes'); ?></dt>
		<dd>
			<?= h($shift['Shift']['shift_minutes']); ?>

		</dd>
		<dt><?= __('Comment'); ?></dt>
		<dd>
			<?= h($shift['Shift']['comment']); ?>

		</dd>
		<dt><?= __('Created'); ?></dt>
		<dd>
			<?= h($shift['Shift']['created']); ?>

		</dd>
		<dt><?= __('Modified'); ?></dt>
		<dd>
			<?= h($shift['Shift']['modified']); ?>

		</dd>
	</dl>
</div>

<div class="row">
	<h3><?= __('Related Report Dates'); ?></h3>
	<?php if (!empty($shift['ReportDate'])): ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<tr>
		<th><?= __('Id'); ?></th>
		<th><?= __('Date'); ?></th>
		<th><?= __('Shift Id'); ?></th>
		<th><?= __('Head Count'); ?></th>
		<th><?= __('Sick'); ?></th>
		<th><?= __('Annual Leave'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($shift['ReportDate'] as $reportDate): ?>
		<tr>
			<td><?= $reportDate['id']; ?></td>
			<td><?= $reportDate['date']; ?></td>
			<td><?= $reportDate['shift_id']; ?></td>
			<td><?= $reportDate['head_count']; ?></td>
			<td><?= $reportDate['sick']; ?></td>
			<td><?= $reportDate['annual_leave']; ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'report_dates', 'action' => 'view', $reportDate['id']]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'report_dates', 'action' => 'edit', $reportDate['id']]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'report_dates', 'action' => 'delete', $reportDate['id']], [], __('Are you sure you want to delete # %s?', $reportDate['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Report Date'), ['controller' => 'report_dates', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
