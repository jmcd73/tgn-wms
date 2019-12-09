<div class="cartons form">
<?php echo $this->Form->create('Carton'); ?>
	<fieldset>
		<legend><?php echo __('Add Carton'); ?></legend>
	<?php
		echo $this->Form->input('pallet_id');
		echo $this->Form->input('count');
		echo $this->Form->input('best_before');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cartons'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Pallets'), array('controller' => 'pallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pallet'), array('controller' => 'pallets', 'action' => 'add')); ?> </li>
	</ul>
</div>
