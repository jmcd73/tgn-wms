<div class="productionLines view container">
<h2><?php echo __('Production Line'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($productionLine['ProductionLine']['id']); ?>

		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($productionLine['ProductionLine']['name']); ?>

		</dd>

		<dt><?php echo __('Product Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($productionLine['ProductType']['name'], array('controller' => 'product_types', 'action' => 'view', $productionLine['ProductType']['id'])); ?>

		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Production Line'), array('action' => 'edit', $productionLine['ProductionLine']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Production Line'), array('action' => 'delete', $productionLine['ProductionLine']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $productionLine['ProductionLine']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Production Lines'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Production Line'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('controller' => 'product_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Type'), array('controller' => 'product_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
