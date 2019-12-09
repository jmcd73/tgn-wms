<div class="cartons view">
<h2><?php echo __('Carton'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($carton['Carton']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pallet'); ?></dt>
		<dd>
			<?php echo $this->Html->link($carton['Pallet']['name'], array('controller' => 'pallets', 'action' => 'view', $carton['Pallet']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Count'); ?></dt>
		<dd>
			<?php echo h($carton['Carton']['count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Best Before'); ?></dt>
		<dd>
			<?php echo h($carton['Carton']['best_before']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Carton'), array('action' => 'edit', $carton['Carton']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Carton'), array('action' => 'delete', $carton['Carton']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $carton['Carton']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Cartons'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carton'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pallets'), array('controller' => 'pallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pallet'), array('controller' => 'pallets', 'action' => 'add')); ?> </li>
	</ul>
</div>
