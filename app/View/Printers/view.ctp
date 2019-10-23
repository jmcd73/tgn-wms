<div class="printers view container">
<h2><?php echo __('Printer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($printer['Printer']['id']); ?>

		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($printer['Printer']['active']); ?>

		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($printer['Printer']['name']); ?>

		</dd>
		<dt><?php echo __('Options'); ?></dt>
		<dd>
			<?php echo h($printer['Printer']['options']); ?>

		</dd>
		<dt><?php echo __('Queue Name'); ?></dt>
		<dd>
			<?php echo h($printer['Printer']['queue_name']); ?>

		</dd>
		<dt><?php echo __('Set As Default On These Actions'); ?></dt>
		<dd>
			<?php echo is_array($printer['Printer']['set_as_default_on_these_actions']) ?
			$this->Html->nestedList($printer['Printer']['set_as_default_on_these_actions']) :
			$printer['Printer']['set_as_default_on_these_actions']; ?>

		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Printer'), array('action' => 'edit', $printer['Printer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Printer'), array('action' => 'delete', $printer['Printer']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $printer['Printer']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Printers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Printer'), array('action' => 'add')); ?> </li>
	</ul>
</div>
