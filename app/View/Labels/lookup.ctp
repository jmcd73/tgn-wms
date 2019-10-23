<?php $this->Html->css([
        'bootstrap-datepicker3.min'
], ['inline' => false]);?>
<?php $this->Html->script([
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'typeahead.bundle.min',
        'lookup'
    ], [
        'inline' => false,
        'block' => 'from_view'
    ]
    ); ?>
<div class="container">
    <div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
        <div class="lookup-search">
		<p><?=__('Enter multiple search conditions and click Search');?></p>
        <?= $this->Form->create(
                'Lookup', [
                    'class' => null,
                    'url' => [
                        'controller' => 'labels',
                        'action' => 'lookup_search'
                    ],
                    'inputDefaults' => [

                        'label' => [
                            'class' => 'form-label'
                        ],
                        'before' => null,
                        'after' => null
                    ]
                ]
            );
        ?>


<?=$this->Form->input('Lookup.item_id_select', [
    'label' => [
        'text' => 'Item Code',
        'class' => null
    ],
    'placeholder' => 'Item Code',
    'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/item_lookup',
    'type' => 'text',
    'id' => 'item_id_select',
    'empty' => true,

    'div' => [
        'class' => 'form-group col-md-j8'
    ]
]
);
//echo $this->Form->hidden('Skip.item_id', ['id' => 'item_id']);

echo $this->Form->input(
    'bb_date', [
        'label' => 'Best Before',

        'placeholder' => 'YYYY-MM-DD',
        'type' => 'text',
        'id' => 'bb_date',
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]);

echo $this->Form->input(
    'pl_ref', [
        'id' => 'pl_ref',
        'label' => [
            'class' => 'form-label',
            'text' => "Pallet Ref No."
        ],
        'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/palletReferenceLookup',
        'type' => 'text',
        'empty' => true,
        'class' => 'typeahead form-control',
        'placeholder' => 'Pallet Ref.',
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]);

echo $this->Form->input('batch', [
    'id' => 'batch',
    'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/batch_lookup',
    'type' => 'text',

    'empty' => true,
    'placeholder' => "Batch No.",
    'div' => [
        'class' => 'form-group col-md-j8'
    ]
]
);
echo $this->Form->input(
    'inventory_status_id', [
        'type' => 'select',
        'options' => $statuses,
        'empty' => true,
        'class' => 'form-control',
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]
);
echo $this->Form->input(
    'print_date', [
        'type' => 'text',
        'id' => 'print_date',
        'label' => "Date Manuf.",
        'placeholder' => 'YYYY-MM-DD',

        'div' => [
            'class' => 'form-group col-md-j8'
        ]]);
echo $this->Form->input(
    'location_id', [
        'type' => 'select',
        'options' => $locations,
        'empty' => true,
        'class' => 'form-control',
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]
);
echo $this->Form->input(
    'shipment_id', [
        'type' => 'select',
        'class' => 'form-control',
        'options' => $shipments,
        'empty' => true,
        'label' => [
            'class' => 'form-label',
            'text' => "Shipper No."
        ],
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]
);
?>

    </div>
	</div>
</div>
    <div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
<?php
    echo $this->Form->end([
        'label' => __('Search'),
        'bootstrap-type' => 'primary',
        'div' => [
            'class' => 'form-group col-md-j8'
        ]
    ]);
?>
        <div class="col-md-j8"></div>
        <div class="col-md-j8"></div>
        <div class="col-md-j8"></div>
        <div class="col-md-j8"></div>
        <div class="col-md-j8"></div>
        <div class="col-md-j8"></div>
 <?php
     echo $this->Form->input('reset', [
         'type' => 'reset',
         'value' => "Clear Form",
         'label' => false,
         'class' => 'form-control',
         'class' => 'btn btn-default',
         'div' => [
             'class' => 'form-group col-md-j8'
         ]]);
 ?>
	</div>
    </div>

</div>
<div class="container">
			<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
    <h3><?php
            echo __('Search Results');

        ?> <span class="badge"><?=$this->Paginator->counter(['format' => '{:count}']);?></span></h3>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
            <tr>

                <th><?=$this->Paginator->sort('item_id');?></th>
                <th><?=$this->Paginator->sort('description');?></th>
                <th><?=$this->Paginator->sort('bb_date', "Best Before");?></th>
                <th><?=$this->Paginator->sort('qty');?></th>
                <th><?=$this->Paginator->sort('pl_ref');?></th>
                <th><?=$this->Paginator->sort('batch');?></th>
                <th><?=$this->Paginator->sort('print_date');?></th>
                <th><?=$this->Paginator->sort('inventory_status_id');?></th>
                <th><?=$this->Paginator->sort('location_id');?></th>
                <th><?=$this->Paginator->sort('shipment_id');?></th>
                <th class="actions"><?=__('Actions');?></th>
            </tr>
        </thead>
        <tbody>
           <?php if (!empty($labels)): ?>
<?php foreach ($labels as $label): ?>
                <tr<?php
    if ($label['Label']['dont_ship']) {
        echo 'class="lowdate"';
}
?> >

                    <td><?=h($label['Item']['code']);?></td>
                    <td><?=h($label['Label']['description']);?></td>
                    <td><?=$this->Time->format($label['Label']['bb_date'], '%d/%m/%y');?></td>
                    <td><?=h($label['Label']['qty']);?></td>
                    <td><?=h($label['Label']['pl_ref']);?></td>
                    <td><?=h($label['Label']['batch']);?></td>
                    <td><?=h($label['Label']['print_date']);?></td>
                    <td><?=h($label['InventoryStatus']['name']);?></td>
                    <td><?=h($label['Location']['location']);?></td>
                    <td><?php
                            echo $this->Html->link(
                                h($label['Shipment']['shipper']), [
                                    'controller' => 'shipments',
                                    'action' => 'view',
                                    $label['Shipment']['id']
                            ]);
                        ?></td>
                    <td class="actions">
                        <?=$this->Html->link(__('Edit'), ['action' => 'editPallet', $label['Label']['id']], ['class' => 'btn edit btn-xs']);?>
                        <?=$this->Html->link(__('View'), ['action' => 'view', $label['Label']['id']], ['class' => 'btn view btn-xs']);?>
                        <?=$this->Html->link(__('Reprint'), ['action' => 'reprint', $label['Label']['id']], ['class' => 'btn reprint btn-xs']);?>

                    </td>
                </tr>
    <?php endforeach;?>
<?php else: ?>
                <tr>
                    <td colspan="11">
                        <div class="text-center"><h3><?php
                                                         echo __('Clear the search form and try again');

                                                     ?></h3></div>
                    </td>
                </tr>
                <?php endif;?>

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
</div>
