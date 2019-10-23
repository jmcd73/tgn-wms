<?php //debug($labels); ?>
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
	<?php foreach ($labels as $label): ?>
	<tr>
		<td><?= h($label['Label']['id']); ?></td>
                <td><?= $this->Html->link($label['Item']['code'], [ 'controller' => 'items', 'action' => 'view', $label['Label']['item_id']]); ?></td>
		<td><?= h($label['Label']['description']); ?></td>
		<td><?= h($label['Label']['best_before']); ?></td>
		<td><?= h($label['Label']['gtin14']); ?></td>
		<td><?= h($label['Label']['qty']); ?></td>
		<td><?= h($label['Label']['pl_ref']); ?></td>
		<td><?= h($label['Label']['sscc_fmt']); ?></td>
		<td><?= h($label['Label']['batch']); ?></td>
		<td><?= h($label['Label']['production_line']); ?></td>
                <td><?= h($label['Label']['printer']); ?></td>
		<td><?= h($label['Label']['print_date']); ?></td>
		<td><?= h($label['Location']['location']); ?></td>
		<td><?= h($label['Shipment']['shipper']); ?></td>
		<td class="actions">
			<?= $this->Html->link(__('View'), ['action' => 'view', $label['Label']['id']]); ?>
			<?= $this->Html->link(__('Reprint'), ['action' => 'reprint', $label['Label']['id']]); ?>
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $label['Label']['id']], [], __('Are you sure you want to delete # %s?', $label['Label']['id'])); ?>
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
