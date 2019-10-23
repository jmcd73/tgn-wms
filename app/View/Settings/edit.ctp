<div class="container">
<?= $this->Form->create('Setting'); ?>
	<fieldset>
		<legend><?= __('Edit Setting'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('setting');
		echo $this->Form->input('comment', ['type' => 'textarea']);
	?>
	</fieldset>

<?= $this->Form->end(['bootstrap-type' => 'primary']); ?>
</div>
