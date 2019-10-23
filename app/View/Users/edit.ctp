
<div class="container">
<div class="users form">
<?= $this->Form->create('User'); ?>
	<fieldset>
		<legend><?= __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
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

		<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('User.id')], ['confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))]); ?></li>
		<li><?= $this->Html->link(__('List Users'), ['action' => 'index']); ?></li>
	</ul>
</div>
</div>
