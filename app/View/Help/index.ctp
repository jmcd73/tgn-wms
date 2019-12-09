<div class="helps index container">
	<h2><?php echo __('Helps'); ?></h2>
	<?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn add btn-primary add mb2 btn-xs']); ?>
	<p>To add help to a page. Create markdown documents in <em><?= h($documentationRoot) ; ?></em> and add a link between the Controller / Action and the markdown file here</p>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('controller_action'); ?></th>
			<th><?php echo $this->Paginator->sort('markdown_document'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($helps as $help): ?>
	<tr>
		<td><?php echo h($help['Help']['id']); ?>&nbsp;</td>
		<td><?php echo h($help['Help']['controller_action']); ?>&nbsp;</td>
		<td><?php echo h($help['Help']['markdown_document']); ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $help['Help']['id']), [
				'class' => 'btn btn-link btn-sm  view'
			]); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $help['Help']['id']),[
				'class' => 'btn btn-link btn-sm  edit'
			]); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $help['Help']['id']), array(

					'class' => 'btn btn-link btn-sm delete',

				'confirm' => __('Are you sure you want to delete # %s?', $help['Help']['id']))); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Help'), array('action' => 'add')); ?></li>
	</ul>
</div>
