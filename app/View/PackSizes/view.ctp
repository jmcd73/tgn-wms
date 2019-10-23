<div class="container">
<h3><?= __('Pack Size'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Pack Size'); ?></dt>
		<dd>
			<?= h($packSize['PackSize']['pack_size']); ?>

		</dd>
		<dt><?= __('Comment'); ?></dt>
		<dd>
			<?= h($packSize['PackSize']['comment']); ?>

		</dd>
		<dt><?= __('Created'); ?></dt>
		<dd>
			<?= h($packSize['PackSize']['created']); ?>

		</dd>
		<dt><?= __('Modified'); ?></dt>
		<dd>
			<?= h($packSize['PackSize']['modified']); ?>

		</dd>
	</dl>
</div>

<div class="row">
	<h3><?= __('Related Items'); ?></h3>
	<?php if (!empty($packSize['Item'])): ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<tr>
		<th><?= __('Id'); ?></th>
		<th><?= __('Active'); ?></th>
		<th><?= __('Code'); ?></th>
		<th><?= __('Description'); ?></th>
		<th><?= __('Quantity'); ?></th>
		<th><?= __('Trade Unit'); ?></th>
		<th><?= __('Consumer Unit'); ?></th>
		<th><?= __('Brand'); ?></th>
		<th><?= __('Variant'); ?></th>
		<th><?= __('Unit Net Contents'); ?></th>
		<th><?= __('Unit Of Measure'); ?></th>
		<th><?= __('Days Life'); ?></th>
		<th><?= __('Created'); ?></th>
		<th><?= __('Modified'); ?></th>
		<th><?= __('Pack Size Id'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($packSize['Item'] as $item): ?>
		<tr>
			<td><?= $item['id']; ?></td>
			<td><?= $item['active']; ?></td>
			<td><?= $item['code']; ?></td>
			<td><?= $item['description']; ?></td>
			<td><?= $item['quantity']; ?></td>
			<td><?= $item['trade_unit']; ?></td>
			<td><?= $item['consumer_unit']; ?></td>
			<td><?= $item['brand']; ?></td>
			<td><?= $item['variant']; ?></td>
			<td><?= $item['unit_net_contents']; ?></td>
			<td><?= $item['unit_of_measure']; ?></td>
			<td><?= $item['days_life']; ?></td>
			<td><?= $item['created']; ?></td>
			<td><?= $item['modified']; ?></td>
			<td><?= $item['pack_size_id']; ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'items', 'action' => 'view', $item['id']]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'items', 'action' => 'edit', $item['id']]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'items', 'action' => 'delete', $item['id']], [], __('Are you sure you want to delete # %s?', $item['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __('Related Machines Standard Rates'); ?></h3>
	<?php if (!empty($packSize['MachinesStandardRate'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?= __('Id'); ?></th>
		<th><?= __('Machine Id'); ?></th>
		<th><?= __('Pack Size Id'); ?></th>
		<th><?= __('Standard Rate'); ?></th>
		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($packSize['MachinesStandardRate'] as $machinesStandardRate): ?>
		<tr>
			<td><?= $machinesStandardRate['id']; ?></td>
			<td><?= $machinesStandardRate['machine_id']; ?></td>
			<td><?= $machinesStandardRate['pack_size_id']; ?></td>
			<td><?= $machinesStandardRate['standard_rate']; ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'machines_standard_rates', 'action' => 'view', $machinesStandardRate['id']]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'machines_standard_rates', 'action' => 'edit', $machinesStandardRate['id']]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'machines_standard_rates', 'action' => 'delete', $machinesStandardRate['id']], [], __('Are you sure you want to delete # %s?', $machinesStandardRate['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Machines Standard Rate'), ['controller' => 'machines_standard_rates', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
