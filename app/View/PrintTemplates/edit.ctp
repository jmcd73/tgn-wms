<div class="printTemplates form">
	<div class="col-lg-offset-3 col-lg-6">
	<?php echo $this->Form->create('PrintTemplate', [
	'type' => 'file'
]); ?>
	<fieldset>
		<legend><?php echo __('Edit Print Template'); ?></legend>
		<?= $this->Form->submit('Save Template' , ['class' => 'btn btn-sm']); ?>
	<?php
	echo $this->Form->input('active');
	echo $this->Form->input('show_in_label_chooser');
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('parent_id', [
			'empty' => '(select)'
		]);
		echo $this->Form->input('description');
		echo $this->Form->input('print_action', [
			'options' => $controllerList,
			'empty' => '(Please select an action)'
		]);
		echo $this->Form->input(
			'example_image',
			['type' => 'file']
		);


		echo $this->Form->input(
			'file_template',
			['type' => 'file' ]
		);
		echo $this->Form->input(
			'delete_file_template',
			['type' => 'checkbox' ]
		);
		echo $this->Form->input('text_template',
	['type' => 'text', 'rows' => 20]);

	?>
	</fieldset>
	<?= $this->Form->submit('Save Template' , [
		'bootstrap-type' => 'primary',
		'class' => 'btn btn-sm']); ?>
<?php echo $this->Form->end(); ?>
</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PrintTemplate.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('PrintTemplate.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Print Templates'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Items'), array('controller' => 'items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), array('controller' => 'items', 'action' => 'add')); ?> </li>
	</ul>
</div>
