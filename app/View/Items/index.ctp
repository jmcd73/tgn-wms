
    <div class="container-fluid">
	<div class="col-lg-2">
        <h3>Quick edit</h3>
    <?=$this->Form->create('Item', [
    'url' => [
        'action' => 'edit'
    ],
    'type' => 'GET']);?>
    <?=$this->Form->input('item_id', [
    'options' => $item_list,
    'empty' => '(select to edit)',
    'label' => false

]);?>
    <?=$this->Form->button('<i class="fas fa-edit"></i> Edit', [
		'bootstrap-type' => 'primary',
		'type' => 'submit'

	], [ 'escape' => false ]);?>
    <?=$this->Form->end();?>



        </div>

<div class="col-lg-10">
<h3><?=__('Items');?></h3>
<?=$this->Html->link(
			"Add", ['action' => 'add'], [
				'escape' => false,
	'class' => 'btn add btn-primary mb2 btn-xs'
]);?>
<table class="table table-bordered table-condensed table-striped table-responsive">
    <thead>
        <tr>
<!--			<th><?=$this->Paginator->sort('id');?></th>-->
  <th><?=$this->Paginator->sort('active');?></th>
            <th><?=$this->Paginator->sort('code');?></th>
            <th><?=$this->Paginator->sort('description');?></th>

            <th><?=$this->Paginator->sort('pack_size_id');?></th>
            <th><?=$this->Paginator->sort('quantity', "Qty");?></th>
            <th><?=$this->Paginator->sort('trade_unit');?></th>
            <th><?=$this->Paginator->sort('consumer_unit');?></th>
            <th><?=$this->Paginator->sort('print_template_id', 'Pallet Label Template');?></th>
            <th><?=$this->Paginator->sort('carton_label_id', 'Carton Label Template');?></th>
            <th><?=$this->Paginator->sort('unit_net_contents', 'UNC', ['title' => 'Unit net contents']);?></th>
            <th><?=$this->Paginator->sort('unit_of_measure', 'UOM', ['title' => 'Unit of Measure']);?></th>
            <th><?=$this->Paginator->sort('days_life');?></th>

            <th><?=$this->Paginator->sort('min_days_life', "Min Life", ['title' => "If 0 then the default minimum life needed to ship value is used. Otherwise set to number of days before expiry that you want to allow pallets to ship"]);?></th>
            <th><?=$this->Paginator->sort('item_comment');?></th>
            <th class="actions"><?=__('Actions');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
    <!--		<td><?=h($item['Item']['id']);?></td>-->
    <td class="text-center"><?php
            $icon = $item['Item']['active'] ? "ok" : "remove";
        echo $this->Html->tag('i', '', ['aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-' . $icon]);
        ?></td>
                <td><?=h($item['Item']['code']);?></td>
                <td><?=h($item['Item']['description']);?></td>

                <td><?=h($item['PackSize']['pack_size']);?></td>
                <td><?=h($item['Item']['quantity']);?></td>
                <td><?=h($item['Item']['trade_unit']);?></td>
                <td><?=h($item['Item']['consumer_unit']);?></td>
                <td><?=h($item['PrintTemplate']['name']);?></td>
                <td><?=h($item['CartonLabel']['name']);?></td>


                <td><?=h($item['Item']['unit_net_contents']);?></td>
                <td><?=h($item['Item']['unit_of_measure']);?></td>
                <td><?=h($item['Item']['days_life']);?></td>
                <td><?=h($item['Item']['min_days_life']);?></td>
                <td><?=$this->Text->truncate(h($item['Item']['item_comment']), 10);?></td>
                <td class="actions">
                    <?=$this->Html->link(__('View'), ['action' => 'view', $item['Item']['id']], [ 'class' => 'btn btn-link btn-sm view']);?>
                    <?=$this->Html->link(__('Edit'), ['action' => 'edit', $item['Item']['id']], [ 'class' => 'btn btn-link  btn-sm  edit']);?>
                    <?=$this->Form->postLink(__('Delete'), ['action' => 'delete', $item['Item']['id']],[ 'class' => 'btn btn-link  btn-sm delete'], __('Are you sure you want to delete # %s?', $item['Item']['id']));?>
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
