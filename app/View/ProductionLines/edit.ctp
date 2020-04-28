<div class="productionLines form container">

<?php echo $this->Form->create('ProductionLine'); ?>
	<fieldset>
		<legend><?php echo __('Edit Production Line'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('printer_id', [
			'empty' => '(select)'
		]);
		echo $this->Form->input('product_type_id', [
            'empty' => '(select)'
        ]);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProductionLine.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('ProductionLine.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Production Lines'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('controller' => 'product_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Type'), array('controller' => 'product_types', 'action' => 'add')); ?> </li>
	</ul>
</div>