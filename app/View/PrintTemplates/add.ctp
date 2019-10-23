<div class="printTemplates container">
	<div class="col-lg-offset-3 col-lg-6">
<?php echo $this->Form->create('PrintTemplate', [
	'type' => 'file'
]); ?>
	<fieldset>
		<legend><?php echo __('Add Print Template'); ?></legend>
		<?=$this->Form->submit('Save Template', ['class' => 'btn btn-sm']);?>
<?php

	echo $this->Form->input('active', ['default' => true]);
	echo $this->Form->input('show_in_label_chooser', ['default' => false]);
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
        [
			'label' => 'File Template',
			'type' => 'file']
	);



    echo $this->Form->input('text_template',
        ['type' => 'text', 'rows' => 20]);

?>
	</fieldset>
	<?=$this->Form->submit('Save Template', ['class' => 'btn btn-sm']);?>
<?php echo $this->Form->end(); ?>
</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Print Templates'), ['action' => 'index']); ?></li>
		<li><?php echo $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
	</ul>
</div>
