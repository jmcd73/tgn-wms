<div class="container">
<?= $this->Form->create('Setting'); ?>
	<fieldset>
		<legend><?= __('Add Setting'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('setting');
		echo $this->Form->input('comment', ['type' => 'textarea']);
	?>
	</fieldset>

<?= $this->Form->end(['bootstrap-type' => 'primary']); ?>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>

		<li><?= $this->Html->link(__('List Settings'), ['action' => 'index']); ?></li>
	</ul>
</div>
