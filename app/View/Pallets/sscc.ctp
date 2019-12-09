<div class="container">
<?= $this->Form->create('Pallet'); ?>
	<fieldset>
		<legend><?= __('Find Label'); ?></legend>
	<?php

		echo $this->Form->input('sscc_scan');

	?>
	</fieldset>
<?= $this->Form->button(__('Submit'),  [
	'bootstrap-type' => 'primary',
	'bootstrap-size' => 'lg'
] ); ?>
<?= $this->Form->end(__('Submit')); ?>

</div>

<div>

<?php
if (!empty($record)){
	debug($record);
}

?>

</div>

