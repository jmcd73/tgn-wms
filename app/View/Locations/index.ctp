<div class="container">
<div class="col-lg-2 col-md-2 col-sm-12">
    <h3><?=__('Quick Edit');?></h3>
    <?=$this->Form->create('Location', [
    'type' => 'GET',
    'url' => ['action' => 'edit']]);?>
    <?=$this->Form->input('id', [
    'empty' => '(please select)',
    'label' => 'Location',
    'data-action' => $this->Html->url(['action' => 'edit']),
	'type' => 'select', 'options' => $location_list]);?>

<?=$this->Form->button(
	$this->Html->tag('i', '', ['class' => 'fas fa-edit'] ). ' Edit',

	[

		'bootstrap-type' => 'primary',
		'escape' => FALSE
	]); ?>
    <?=$this->Form->end();?>
</div>
<div class="col-lg-10 col-md-10 col-sm-12 locations index">
	<h3><?=__('Locations');?></h3>
	<?=$this->Html->link('Add', ['action' => 'add'], ['class' => 'btn add btn-primary add mb2 btn-xs']); ?>
	<table class="table table-bordered table-condensed table-striped table-responsive">
	<thead>
	<tr>
			<th><?=$this->Paginator->sort('id');?></th>
			<th><?=$this->Paginator->sort('location');?></th>
                        <th><?=$this->Paginator->sort('pallet_capacity');?></th>
			<th><?=$this->Paginator->sort('description');?></th>
			<th><?=$this->Paginator->sort('product_type_id');?></th>

			<th class="actions"><?=__('Actions');?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($locations as $location): ?>
	<tr>
		<td><?=h($location['Location']['id']);?></td>
		<td><?=h($location['Location']['location']);?></td>
                <td><?=h($location['Location']['pallet_capacity']);?></td>
		<td><?=h($location['Location']['description']);?></td>
		<td><?=h($location['ProductType']['name']);?></td>

		<td class="actions">
			<?=$this->Html->link(
				__('View'),
				['action' => 'view', $location['Location']['id']],
				[ 'class' => 'btn btn-link btn-sm view']
				);?>
			<?=$this->Html->link(
				__('Edit'),
				['action' => 'edit', $location['Location']['id']],
				[ 'class' => 'btn btn-link btn-sm edit']
				);?>

<?= $this->Form->postLink(
				__('Delete'),
				['action' => 'delete', $location['Location']['id']],
				[ 'class' => 'btn btn-link btn-sm delete'],
				__('Are you sure you want to delete # %s?', $location['Location']['location'])); ?>

		</td>
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
</div>
