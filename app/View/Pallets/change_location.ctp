<div class="container">
<?= $this->Form->create('Pallet'); ?>
	<fieldset>
		<legend><?= __('Edit Pallet'); ?></legend>
	<?php
                echo $this->Form->input('location_id');
                echo $this->Form->submit("Move pallet");
		echo $this->Form->input('id');
		echo $this->Form->input('item', ['disabled' => 'disabled']);
		echo $this->Form->input('description', ['disabled' => 'disabled']);
		echo $this->Form->input('best_before', ['disabled' => 'disabled']);
		echo $this->Form->input('qty', ['disabled' => 'disabled']);
		echo $this->Form->input('pl_ref', ['disabled' => 'disabled']);
		echo $this->Form->input('batch', ['disabled' => 'disabled']);
                echo $this->Form->input('sscc', ['disabled' => 'disabled']);


	?>
	</fieldset>

<?= $this->Form->end([
	'bootstrap-type' => 'primary',
	'bootstrap-size' => 'lg'
] ); ?>

</div>
