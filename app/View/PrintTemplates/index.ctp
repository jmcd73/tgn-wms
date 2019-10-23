<div class="printTemplates index container">
	<h2><?php echo __('Print Templates'); ?></h2>
	<?=$this->Html->link("Add", ['action' => 'add'], ['class' => 'btn btn-xs add btn-primary bpad20']);?>
    <p><strong>Warning:</strong> Do not change these settings unless you know what you are doing</p>
	<?php /* <table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
		<th>Name</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
	 <?php foreach($printTemplates as $key => $printTemplate): ?>
	 	<tr>
		<td><?php echo $printTemplate; ?></td>
		<td class="actions"></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table> */ ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>

			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>

			<th><?php echo $this->Paginator->sort('show_in_label_chooser'); ?></th>

			<th><?php echo $this->Paginator->sort('print_action'); ?></th>

			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($printTemplates as $printTemplate): ?>
	<tr>
	<td><?php
	$prefix = !empty( $printTemplate['ParentTemplate']['id']) ? "&nbsp;--&nbsp;" : "";
	echo $prefix . h($printTemplate['PrintTemplate']['name']); ?></td>
	<td><?php echo h($printTemplate['PrintTemplate']['description']); ?></td>
		<td><?php echo h($printTemplate['PrintTemplate']['active']); ?></td>
		<td><?php echo h($printTemplate['PrintTemplate']['show_in_label_chooser']); ?></td>


		<td><?php echo h($printTemplate['PrintTemplate']['print_action']); ?></td>

		<td class="actions">
		<div class="row bpad10">
                            <div class="col-lg-12">
                            <?php echo $this->Form->create(null, [

'url' => [
    'action' => 'move_up',
    $printTemplate['PrintTemplate']['id']
],
'class' => 'input-sm'
]);
echo $this->Form->input('amount',[
'input-group-size' => 'input-group-sm',
'label' => false,
'prepend' => '<i class="fas fa-caret-up"></i>',
'append' => $this->Form->submit('Up')
]);
echo $this->Form->end();
?>
</div></div>
                    <div class="row">
                        <div class="col-lg-12">
                    <?=$this->Html->link(__('View'), ['action' => 'view', $printTemplate['PrintTemplate']['id']], [
    'class' => 'btn view btn-link btn-sm btn-sm'
]); ?>
<?=$this->Html->link(__('Edit'), ['action' => 'edit', $printTemplate['PrintTemplate']['id']], [
    'class' => 'btn edit btn-link btn-sm'
]); ?>
<?=$this->Form->postLink(
    __('Delete'),
    [
        'action' => 'delete',
        $printTemplate['PrintTemplate']['id'],
        '?' => [
            'redirect' => urlencode($this->here)
        ]

    ],
    [
        'class' => 'btn delete btn-link btn-sm',
        'confirm' => __('Are you sure you want to remove # %s?. Children will no be deleted', $printTemplate['PrintTemplate']['id'])
    ]
); ?>
                    </div>
                    </div>

                    <div class="row bpad10">
                            <div class="col-lg-12">
                            <?php echo $this->Form->create(null, [
'url' => [
    'action' => 'move_down',
    $printTemplate['PrintTemplate']['id']
],
'class' => 'input-sm'
]);
echo $this->Form->input('amount',[
'input-group-size' => 'input-group-sm',
'label' => false,
'prepend' => '<i class="fas fa-caret-down"></i>',
'append' => $this->Form->submit('Dn')
]);
echo $this->Form->end();
?>

</div>

                    </div>		</td>
	</tr>
<?php endforeach;?>
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
		<li><?php echo $this->Html->link(__('New Print Template'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
	</ul>
</div>