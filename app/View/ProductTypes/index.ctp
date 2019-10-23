<div class="productTypes index container">
	<h3><?= __('Product Types'); ?></h3>
        <?= $this->Html->link('Add', ['action' => 'add'], ['class' => 'btn btn-primary add bpad20 btn-xs']); ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?= $this->Paginator->sort('id'); ?></th>
			<th><?= $this->Paginator->sort('active'); ?></th>
			<th><?= $this->Paginator->sort('next_serial_number', 'Next #'); ?></th>
			<th><?= $this->Paginator->sort('name'); ?></th>
			<th><?= $this->Paginator->sort('location_id', 'Default Save Location'); ?></th>
			<th><?= $this->Paginator->sort('storage_temperature'); ?></th>
			<th><?= $this->Paginator->sort('code_regex'); ?></th>
			<th><?= $this->Paginator->sort('code_regex_description'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($productTypes as $productType): ?>
	<tr>
		<td><?= h($productType['ProductType']['id']); ?></td>
		<td><?= h($productType['ProductType']['active']); ?></td>
		<td><?= h($productType['ProductType']['next_serial_number']); ?></td>
		<td><?= h($productType['ProductType']['name']); ?></td>
		<td><?= h($productType['DefaultLocation']['location']); ?></td>
		<td><?= h($productType['ProductType']['storage_temperature']); ?></td>
		<td><?= h($productType['ProductType']['code_regex']); ?></td>
		<td><?= h($productType['ProductType']['code_regex_description']); ?></td>
		<td class="actions">
			<?= $this->Html->link(
				__('View'),
				['action' => 'view', $productType['ProductType']['id']],
				[ 'class' => 'btn btn-link btn-sm view']
				); ?>
			<?= $this->Html->link(
				__('Edit'),
				['action' => 'edit', $productType['ProductType']['id']],
				[ 'class' => 'btn btn-link btn-sm edit']
				); ?>
			<?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $productType['ProductType']['id']],
				[
					'class' => 'btn btn-link btn-sm delete',
					'confirm' => __('Are you sure you want to delete # %s?', $productType['ProductType']['id'])]); ?>
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
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('New Area Or Type'), ['action' => 'add']); ?></li>
		<li><?= $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Locations'), ['controller' => 'locations', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Location'), ['controller' => 'locations', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Shifts'), ['controller' => 'shifts', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Shift'), ['controller' => 'shifts', 'action' => 'add']); ?> </li>
	</ul>
</div>
