<?php //debug($pallets); ?>
<div class="labels index container-fluid">
	<h3><?= __('Labels'); ?></h3>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?= $this->Paginator->sort('id'); ?></th>
			<th><?= $this->Paginator->sort('item_id'); ?></th>
			<th><?= $this->Paginator->sort('description'); ?></th>
			<th><?= $this->Paginator->sort('best_before'); ?></th>
			<th><?= $this->Paginator->sort('gtin14'); ?></th>
			<th><?= $this->Paginator->sort('qty'); ?></th>
			<th><?= $this->Paginator->sort('pl_ref'); ?></th>
			<th><?= $this->Paginator->sort('sscc'); ?></th>
			<th><?= $this->Paginator->sort('batch'); ?></th>
			<th><?= $this->Paginator->sort('production_line'); ?></th>
            <th><?= $this->Paginator->sort('printer'); ?></th>
			<th><?= $this->Paginator->sort('print_date'); ?></th>
			<th><?= $this->Paginator->sort('location_id'); ?></th>
			<th><?= $this->Paginator->sort('shipment_id'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pallets as $pallet): ?>
	<tr>
		<td><?= h($pallet['Pallet']['id']); ?></td>
                <td><?= $this->Html->link($pallet['Item']['code'], [ 'controller' => 'items', 'action' => 'view', $pallet['Pallet']['item_id']]); ?></td>
		<td><?= h($pallet['Pallet']['description']); ?></td>
		<td><?= h($pallet['Pallet']['best_before']); ?></td>
		<td><?= h($pallet['Pallet']['gtin14']); ?></td>
		<td><?= h($pallet['Pallet']['qty']); ?></td>
		<td><?= h($pallet['Pallet']['pl_ref']); ?></td>
		<td><?= h($pallet['Pallet']['sscc_fmt']); ?></td>
		<td><?= h($pallet['Pallet']['batch']); ?></td>
		<td><?= h($pallet['Pallet']['production_line']); ?></td>
                <td><?= h($pallet['Pallet']['printer']); ?></td>
		<td><?= h($pallet['Pallet']['print_date']); ?></td>
		<td><?= h($pallet['Location']['location']); ?></td>
		<td><?= h($pallet['Shipment']['shipper']); ?></td>
		<td class="actions">
			<?= $this->Html->link(__('View'), ['action' => 'view', $pallet['Pallet']['id']]); ?>
			<?= $this->Html->link(__('Reprint'), ['action' => 'reprint', $pallet['Pallet']['id']]); ?>
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pallet['Pallet']['id']], [], __('Are you sure you want to delete # %s?', $pallet['Pallet']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter([
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	]);
	?>	</p>
	 <div class="pagination pagination-large">
        <ul class="pagination">
            <?php
            echo $this->Paginator->first('&laquo; first', ['escape' => false, 'tag' => 'li']);
            echo $this->Paginator->prev('&lsaquo; ' . __('previous'), ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'ellipsis' => null]);
            echo $this->Paginator->next(__('next') . ' &rsaquo;', ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->last('last &raquo;', ['escape' => false, 'tag' => 'li']);
            ?>
        </ul>
    </div>
</div>
