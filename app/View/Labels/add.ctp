<div class="container">
<?= $this->Form->create('Label'); ?>
	<fieldset>
		<legend><?= __('Add Label'); ?></legend>
	<?php
		echo $this->Form->input('item');
		echo $this->Form->input('description');
		echo $this->Form->input('best_before');
		echo $this->Form->input('gtin14');
		echo $this->Form->input('qty');
		echo $this->Form->input('pl_ref');
		echo $this->Form->input('sscc');
		echo $this->Form->input('batch');
		echo $this->Form->input('printer');
		echo $this->Form->input('print_date');
		echo $this->Form->input('location_id');
		echo $this->Form->input('shipment_id');
	?>
	</fieldset>

<?= $this->Form->end([
		'bootstrap-type' => 'primary'
	] ); ?>

</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
<li><?= $this->Html->link(__('Main Menu'), ['controller' => 'pages', 'action' => 'index'], ['title' => "Go to main menu"]); ?></li>
		<li><?= $this->Html->link(__('List Labels'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Locations'), ['controller' => 'locations', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Location'), ['controller' => 'locations', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Shipments'), ['controller' => 'shipments', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Shipment'), ['controller' => 'shipments', 'action' => 'add']); ?> </li>
	</ul>
</div>
