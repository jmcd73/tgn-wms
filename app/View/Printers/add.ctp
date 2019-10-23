<div class="printers form container">
<?php echo $this->Form->create('Printer'); ?>
	<fieldset>
		<legend><?php echo __('Add Printer'); ?></legend>
        <p><strong>Note:</strong> To add printers you first need to go to <?= $this->Html->link($cupsUrl, $cupsUrl); ?> to define printers using CUPS and then you can add them here </p>
	<?php
        echo $this->Form->input('active', ['default' => 1]);
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
            'multiple' => 'checkbox']);
    ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Printers'), ['action' => 'index']); ?></li>
	</ul>
</div>
