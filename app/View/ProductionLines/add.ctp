<div class="productionLines form container">

<?php echo $this->Form->create('ProductionLine'); ?>
	<fieldset>
		<legend><?php echo __('Add Production Line'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('printer_id', [
			'empty' => '(select)'
		]);
		echo $this->Form->input('product_type_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Production Lines'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('controller' => 'product_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Type'), array('controller' => 'product_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
