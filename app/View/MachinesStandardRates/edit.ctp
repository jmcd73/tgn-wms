<div class="container">
<?= $this->Form->create('MachinesStandardRate'); ?>
	<fieldset>
		<legend><?= __('Edit Machines Standard Rate'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('machine_id');
		echo $this->Form->input('pack_size_id');
		echo $this->Form->input('standard_rate');
	?>
	</fieldset>
<?php $btn_options = ['class' => 'col-md-offset-2 col-md-1btn btn-lg btn-primary']; ?>
<?= $this->Form->button(__('Submit'),$btn_options ); ?>
<?= $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('MachinesStandardRate.id')], [], __('Are you sure you want to delete # %s?', $this->Form->value('MachinesStandardRate.id'))); ?></li>
		<li><?= $this->Html->link(__('List Machines Standard Rates'), ['action' => 'index']); ?></li>
		<li><?= $this->Html->link(__('List Machines'), ['controller' => 'machines', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Machine'), ['controller' => 'machines', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Pack Sizes'), ['controller' => 'pack_sizes', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Pack Size'), ['controller' => 'pack_sizes', 'action' => 'add']); ?> </li>
	</ul>
</div>
