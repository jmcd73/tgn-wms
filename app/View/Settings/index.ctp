<div class="settings index container">
	<h3><?= __('Settings'); ?></h3>
	<?= $this->Html->link("Add", [ 'action' => 'add'],  [ 'class' => 'btn btn-primary mb2 add btn-xs']); ?>
    <p><strong>Warning:</strong> Do not change these settings unless you know what you are doing</p>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?= $this->Paginator->sort('id'); ?></th>
			<th><?= $this->Paginator->sort('name'); ?></th>
			<th><?= $this->Paginator->sort('setting'); ?></th>
			<th><?= $this->Paginator->sort('comment'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($settings as $setting): ?>
	<tr>
		<td><?= h($setting['Setting']['id']); ?></td>
		<td><?= h($setting['Setting']['name']); ?></td>
		<td><?= h($setting['Setting']['setting']); ?></td>
		<td><?= h($setting['Setting']['comment']); ?></td>
		<td class="actions">
			<?= $this->Html->link(
				__('View'),
				['action' => 'view', $setting['Setting']['id']],
				[ 'class' => 'btn btn-link btn-sm view']
				); ?>
			<?= $this->Html->link(
				__('Edit'),
				['action' => 'edit', $setting['Setting']['id']],
				[ 'class' => 'btn btn-link btn-sm edit']
				); ?>
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $setting['Setting']['id']], [ 'class' => 'btn btn-link btn-sm delete'], __('Are you sure you want to delete # %s?', $setting['Setting']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter([
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	]);
	?>	</p>
	 <div class="pagination pagination-large">
        <ul class="pagination">
            <?php
            echo $this->Paginator->first('&laquo; first', ['escape' => false, 'tag' => 'li']);
            echo $this->Paginator->prev('&lsaquo; ' . __('previous'), ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->numbers(['separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1, 'ellipsis' => null]);
            echo $this->Paginator->next(__('next') . ' &rsaquo;', ['escape' => false, 'tag' => 'li'], null, ['tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a']);
            echo $this->Paginator->last('last &raquo;', ['escape' => false, 'tag' => 'li']);
            ?>
        </ul>
    </div>
</div>
