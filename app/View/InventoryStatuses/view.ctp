<div class="container">
<h3><?= __('Inventory Status'); ?></h3>
	<dl class="dl-horizontal">

		<dt><?= __('Name'); ?></dt>
		<dd>
			<?= h($inventoryStatus['InventoryStatus']['name']); ?>

		</dd>
		<dt><?= __('Comment'); ?></dt>
		<dd>
			<?= h($inventoryStatus['InventoryStatus']['comment']); ?>

		</dd>
	</dl>
</div>

<div class="container">
	<h3><?= __('Related Labels'); ?></h3>
	<?php if (!empty($inventoryStatus['Label'])): ?>

        <table class="table table-bordered table-condensed table-striped table-responsive">
	<tr>
		<th><?= __('Id'); ?></th>
		<th><?= __('Item'); ?></th>
		<th><?= __('Description'); ?></th>
		<th><?= __('Best Before'); ?></th>
		<th><?= __('Gtin14'); ?></th>
		<th><?= __('Qty'); ?></th>
		<th><?= __('Pl Ref'); ?></th>
		<th><?= __('Sscc'); ?></th>
		<th><?= __('Batch'); ?></th>
		<th><?= __('Print Date'); ?></th>
		<th><?= __('Production Line'); ?></th>

		<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	<?php foreach ($inventoryStatus['Label'] as $label): ?>
		<tr>
			<td><?= $label['id']; ?></td>
			<td><?= $label['item']; ?></td>
			<td><?= $label['description']; ?></td>
			<td><?= $label['best_before']; ?></td>
			<td><?= $label['gtin14']; ?></td>
			<td><?= $label['qty']; ?></td>

			<td><?= $label['pl_ref']; ?></td>
			<td><?= $label['sscc']; ?></td>
			<td><?= $label['batch']; ?></td>

			<td><?= $label['print_date']; ?></td>
			<td><?= $label['production_line']; ?></td>

			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'labels', 'action' => 'view', $label['id']]); ?>

			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
