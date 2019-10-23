<div class="users form container">
<?= $this->Form->create('User'); ?>
	<fieldset>
		<legend><?= __('Add User'); ?></legend>
	<?php
			echo $this->Form->input('active', [
				'default' => 1
			]);
		echo $this->Form->input('username');
		echo $this->Form->input('full_name');
		echo $this->Form->input('password');
		echo $this->Form->input('role');
	?>
	</fieldset>
<?= $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Html->link(__('List Users'), ['action' => 'index']); ?></li>
	</ul>
</div>
