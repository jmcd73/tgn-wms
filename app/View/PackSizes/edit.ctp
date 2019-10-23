<div class="container">
<?= $this->Form->create('PackSize'); ?>
	<fieldset>
		<legend><?= __('Edit Pack Size'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('pack_size');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php $btn_options = ['class' => 'col-md-offset-2 col-md-1btn btn-lg btn-primary']; ?>
<?= $this->Form->button(__('Submit'),$btn_options ); ?>
<?= $this->Form->end(); ?>
</div>
