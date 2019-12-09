<?php $this->Html->css([
        'bootstrap-datepicker3.min'
], ['inline' => false]); ?>
<?php $this->Html->script([
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'typeahead.bundle.min',
        'edit-modal',
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
                <p><?php echo __('Enter multiple search conditions and click Search'); ?></p>
                <?php echo $this->Form->create(
                        'Lookup', [
                            'class' => null,
                            'url' => [
                                'controller' => 'pallets',
                                'action' => 'lookupSearch'
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


                <?php echo $this->Form->input('Lookup.item_id_select', [
                        'label' => [
                            'text' => 'Item Code',
                            'class' => null
                        ],
                        'placeholder' => 'Item Code',
                        'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/itemLookup',
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
                        'data-submit_url' => $this->request->base . '/' . $this->request->params['controller'] . '/batchLookup',
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

                ?> <span class="badge"><?php echo $this->Paginator->counter(['format' => '{:count}']); ?></span></h3>
            <table class="table table-bordered table-condensed table-striped table-responsive">
                <thead>
                    <tr>

                        <th><?php echo $this->Paginator->sort('item_id'); ?></th>
                        <th><?php echo $this->Paginator->sort('description'); ?></th>
                        <th><?php echo $this->Paginator->sort('bb_date', "Best Before"); ?></th>
                        <th><?php echo $this->Paginator->sort('qty'); ?></th>
                        <th><?php echo $this->Paginator->sort('pl_ref'); ?></th>
                        <th><?php echo $this->Paginator->sort('batch'); ?></th>
                        <th><?php echo $this->Paginator->sort('print_date'); ?></th>
                        <th><?php echo $this->Paginator->sort('inventory_status_id'); ?></th>
                        <th><?php echo $this->Paginator->sort('location_id'); ?></th>
                        <th><?php echo $this->Paginator->sort('shipment_id'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pallets)): ?>
<?php foreach ($pallets as $pallet): ?>
                    <tr<?php
    if ($pallet['Pallet']['dont_ship']) {
        echo 'class="lowdate"';
}
?>>

                        <td><?php echo h($pallet['Item']['code']); ?></td>
                        <td><?php echo h($pallet['Pallet']['description']); ?></td>
                        <td><?php echo $this->Time->format($pallet['Pallet']['bb_date'], '%d/%m/%y'); ?></td>
                        <td><?php echo h($pallet['Pallet']['qty']); ?></td>
                        <td><?php echo h($pallet['Pallet']['pl_ref']); ?></td>
                        <td><?php echo h($pallet['Pallet']['batch']); ?></td>
                        <td><?php echo h($pallet['Pallet']['print_date']); ?></td>
                        <td><?php echo h($pallet['InventoryStatus']['name']); ?></td>
                        <td><?php echo h($pallet['Location']['location']); ?></td>
                        <td><?php
                                echo $this->Html->link(
                                    h($pallet['Shipment']['shipper']), [
                                        'controller' => 'shipments',
                                        'action' => 'view',
                                        $pallet['Shipment']['id']
                                ]);
                            ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(
                                    __('Edit'), '#', [
                                        'data-palletId' => $pallet['Pallet']['id'],
                                        'data-codeDesc' => $pallet['Pallet']['code_desc'],
                                        'data-editPalletCartons' => $this->Html->url([
                                            'controller' => 'Cartons',
                                            'action' => 'editPalletCartons',
                                            $pallet['Pallet']['id']
                                        ]),
                                        'data-moveOrEdit' => $this->Html->url([
                                            'action' => 'editPallet',
                                            $pallet['Pallet']['id']
                                        ]),
                                        'data-toggle' => "modal",
                                        'data-target' => "#edit-modal",
                                        'class' => 'btn edit btn-xs tgn-modal',
                                        'title' => 'Click here for popup edit options menu'
                                    ]);
                            ?>
<?php echo $this->Html->link(__('View'), ['action' => 'view', $pallet['Pallet']['id']], ['class' => 'btn view btn-xs']); ?>
<?php echo $this->Html->link(__('Reprint'), ['action' => 'reprint', $pallet['Pallet']['id']], ['class' => 'btn reprint btn-xs']); ?>

                        </td>
                        </tr>
                        <?php endforeach; ?>
<?php else: ?>
                        <tr>
                            <td colspan="11">
                                <div class="text-center">
                                    <h3><?php
                                            echo __('Clear the search form and try again');

                                        ?></h3>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>

                </tbody>
            </table>
            <p>
                <?php
                    echo $this->Paginator->counter([
                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ]);
                ?> </p>
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

<?php echo $this->element('pallet_cartons_edit_modal'); ?>