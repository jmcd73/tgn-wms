<div class="helps view container">
<h2><?php echo __('Help'); ?></h2>
<?= $this->Html->link("Edit", [ 'action' => 'edit',$help['Help']['id']], [ 'class' => 'btn btn-xs btn-primary edit']); ?>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($help['Help']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Controller Action'); ?></dt>
		<dd>
			<?php echo h($help['Help']['controller_action']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Help Text'); ?></dt>
		<dd>
			<?php echo $markdown; ?>

		</dd>

	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Help'), array('action' => 'edit', $help['Help']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Help'), array('action' => 'delete', $help['Help']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $help['Help']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Helps'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Help'), array('action' => 'add')); ?> </li>
	</ul>
</div>
