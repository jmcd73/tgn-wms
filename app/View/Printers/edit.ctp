<div class="printers form container">
<?php echo $this->Form->create('Printer'); ?>
	<fieldset>
		<legend><?php echo __('Edit Printer'); ?></legend>
		<p><strong>Note:</strong> Print queues need to be defined using CUPS by going to <?= $this->Html->link($cupsUrl, $cupsUrl); ?> and then you can choose them here</p>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
		echo $this->Form->input('name');
		echo $this->Form->input('options');
		echo $this->Form->input('queue_name', [
			'type' => 'select',
			'empty' => '(select)',
			'options' => array_combine($localPrinters, array_values($localPrinters))
		]);
		echo $this->Form->input('set_as_default_on_these_actions', [
			'type' => 'select',
			'options' => $controllers,
			'multiple' => 'checkbox'] );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Printer.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Printer.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Printers'), array('action' => 'index')); ?></li>
	</ul>
</div>
