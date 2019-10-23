<div class="printers index container">
	<h2><?php echo __('Printers'); ?></h2>
	<?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn add btn-primary bpad20 btn-xs']); ?>
	<p><strong>Note:</strong> To add printers you first need to go to <?= $this->Html->link($cupsUrl, $cupsUrl); ?> to define printers using CUPS and then you can add them here </p>

	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('options'); ?></th>
			<th><?php echo $this->Paginator->sort('queue_name'); ?></th>
			<th><?php echo $this->Paginator->sort('set_as_default_on_these_actions'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($printers as $printer): ?>
	<tr>
		<td><?php echo h($printer['Printer']['id']); ?></td>
		<td><?php echo h($printer['Printer']['active']); ?></td>
		<td><?php echo h($printer['Printer']['name']); ?></td>
		<td><?php echo h($printer['Printer']['options']); ?></td>
		<td><?php echo h($printer['Printer']['queue_name']); ?></td>
		<td><?php echo is_array($printer['Printer']['set_as_default_on_these_actions']) ? h(CakeText::toList($printer['Printer']['set_as_default_on_these_actions'], 'and')) : ''; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(
                    __('View'),
                    ['action' => 'view', $printer['Printer']['id']],
                    ['class' => 'btn btn-link btn-sm view']
            ); ?>
<?php echo $this->Html->link(
        __('Edit'), ['action' => 'edit', $printer['Printer']['id']],
        ['class' => 'btn btn-link btn-sm edit']
); ?>
<?php echo $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $printer['Printer']['id']],
        [
            'class' => 'btn btn-link btn-sm delete',
        'confirm' => __('Are you sure you want to delete # %s?', $printer['Printer']['id'])]); ?>
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
		<li><?php echo $this->Html->link(__('New Printer'), ['action' => 'add']); ?></li>
	</ul>
</div>
