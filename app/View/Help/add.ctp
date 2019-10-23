<div class="helps form container">
<?php echo $this->Form->create('Help'); ?>
	<fieldset>
		<legend><?php echo __('Add Help'); ?></legend>
	<?php
			echo $this->Form->input('controller_action',[
				'type' => 'select',
				'options' => $controllerActions,
				'empty' => '(select)'
			]);
		echo $this->Form->input('markdown_document', [
			'type' => 'select',
			'options' => $markdownDocuments,
			'empty' => '(select)'
			]);

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Helps'), array('action' => 'index')); ?></li>
	</ul>
</div>
