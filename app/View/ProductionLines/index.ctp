<div class="productionLines form container">
	<h2><?php echo __('Production Lines'); ?></h2>
	<?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn btn-primary mb2 add btn-xs']); ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('printer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('product_type_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($productionLines as $productionLine): ?>
	<tr>
		<td><?php echo h($productionLine['ProductionLine']['id']); ?></td>
		<td><?php echo h($productionLine['ProductionLine']['name']); ?></td>
		<td><?php echo h($productionLine['Printer']['name']); ?></td>
		<td>
			<?php echo $this->Html->link($productionLine['ProductType']['name'], ['controller' => 'product_types', 'action' => 'view', $productionLine['ProductType']['id']]); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(
                    __('View'),
				['action' => 'view', $productionLine['ProductionLine']['id']],
				[ 'class' => 'btn btn-link btn-sm view']

				); ?>
<?php echo $this->Html->link(
	__('Edit'),
	['action' => 'edit', $productionLine['ProductionLine']['id']],
	[ 'class' => 'btn btn-link btn-sm edit']
	); ?>
<?php echo $this->Form->postLink(
	__('Delete'),
	['action' => 'delete', $productionLine['ProductionLine']['id']],
	[
		 'class' => 'btn btn-link btn-sm delete',
		'confirm' => __('Are you sure you want to delete # %s?', $productionLine['ProductionLine']['id'])]); ?>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Production Line'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List Product Types'), ['controller' => 'product_types', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Type'), ['controller' => 'product_types', 'action' => 'add']); ?> </li>
	</ul>
</div>
