<div class="productTypes form container">
<?= $this->Form->create('ProductType'); ?>
	<fieldset>
		<legend><?= __('Add Area Or Type'); ?></legend>
	<?php
		echo $this->Form->input('active', [
			'default' => 1
		]);
		echo $this->Form->input('enable_pick_app');
		echo $this->Form->input('next_serial_number');
		echo $this->Form->input('serial_number_format');
		echo $this->Form->input('inventory_status_id', [
			'empty' => '(select)'
		]);
		echo $this->Form->input('name');
		echo $this->Form->input('location_id', [
			'label' => "Default Save Location",
			'empty' => "(select)"
		]);
		echo $this->Form->input('code_regex');
		echo $this->Form->input('code_regex_description');
		echo $this->Form->input('storage_temperature', [
                    'type' => 'select',
                    'options'=> $storageTemps,
                    'empty' => '(select)'
                ]);
	?>
	</fieldset>
<?= $this->Form->end( [
	'bootstrap-type' => 'primary'
]); ?>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Html->link(__('List Product Types'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Locations'), ['controller' => 'locations', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Location'), ['controller' => 'locations', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Shifts'), ['controller' => 'shifts', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Shift'), ['controller' => 'shifts', 'action' => 'add']); ?> </li>
	</ul>
</div>
