<div class="container">
	<h3><?= __('Pack Sizes'); ?></h3>
	<?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn btn-primary bpad20 add btn-xs']); ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?= $this->Paginator->sort('id'); ?></th>
			<th><?= $this->Paginator->sort('pack_size'); ?></th>
			<th><?= $this->Paginator->sort('comment'); ?></th>
			<th><?= $this->Paginator->sort('created'); ?></th>
			<th><?= $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($packSizes as $packSize): ?>
	<tr>
		<td><?= h($packSize['PackSize']['id']); ?></td>
		<td><?= h($packSize['PackSize']['pack_size']); ?></td>
		<td><?= h($packSize['PackSize']['comment']); ?></td>
		<td><?= h($packSize['PackSize']['created']); ?></td>
		<td><?= h($packSize['PackSize']['modified']); ?></td>
		<td class="actions">
			<?= $this->Html->link(
				__('View'),
				['action' => 'view', $packSize['PackSize']['id']],
				[ 'class' => 'btn btn-link btn-sm view']
				); ?>
			<?= $this->Html->link(
				__('Edit'),
				['action' => 'edit', $packSize['PackSize']['id']],
				[ 'class' => 'btn btn-link btn-sm edit']
				); ?>
			<?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $packSize['PackSize']['id']],
				[ 'class' => 'btn btn-link btn-sm delete'],
				__('Are you sure you want to delete # %s?', $packSize['PackSize']['id'])); ?>
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
