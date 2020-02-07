<div class="container">
<div class="users view">
<h3><?= __('User'); ?></h3>
	<dl>
		<dt><?= __('Id'); ?></dt>
		<dd>
			<?= h($user['User']['id']); ?>

		</dd>
        <dt><?= __('Full name'); ?></dt>
		<dd>
			<?= h($user['User']['full_name']); ?>

		</dd>
		<dt><?= __('Username'); ?></dt>
		<dd>
			<?= h($user['User']['username']); ?>
		</dd>
		<dt><?= __('Role'); ?></dt>
		<dd>
			<?= h($user['User']['role']); ?>

		</dd>
		<dt><?= __('Created'); ?></dt>
		<dd>
			<?= h($user['User']['created']); ?>

		</dd>
		<dt><?= __('Modified'); ?></dt>
		<dd>
			<?= h($user['User']['modified']); ?>

		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user['User']['id']]); ?> </li>
		<li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user['User']['id']], ['confirm' => __('Are you sure you want to delete # %s?', $user['User']['id'])]); ?> </li>
		<li><?= $this->Html->link(__('List Users'), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New User'), ['action' => 'add']); ?> </li>
	</ul>
</div>
</div>
