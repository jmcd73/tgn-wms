<?php

use Cake\Core\Configure;

$this->Html->script(
    [

        'modify-pallet',
    ],
    [
        'inline' => false,
        'block' => 'from_view',
    ]
);

?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?= $this->Form->create($pallet); ?>
<?php echo $this->Form->hidden('id'); ?>
<?php echo $this->Form->hidden('referer', ['value' => $referer]); ?>
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h3>Change status or location</h3>
                <h5><?= $pallet->code_desc; ?> - <?= $pallet->pl_ref; ?> <?= $pallet->has('shipment') ? $pallet->shipment->shipper : ''; ?></h5>
                <?php echo $this->Form->hidden('items.days_life', ['id' => 'ItemDaysLife']); ?>
                <?php echo $this->Form->hidden('qty_user_id'); ?>
                <?php echo $this->Form->hidden('referer', ['value' => $referer]); ?>
                <?php $key = 0; ?>
                <div class="row mt-4">

                    <?php echo $this->Form->hidden('item', ['disabled' => 'disabled']); ?>
                    <?php echo $this->Form->hidden('description', ['disabled' => 'disabled']); ?>
                    <?php echo $this->Form->hidden('pl_ref', ['disabled' => 'disabled']); ?>

                    <div class="col">
                        <?php $disabled = ['disabled' => 'disabled']; ?>
                        <?=
                            $this->Form->control(
                                'batch',
                                [
                                    'label' => 'Batch Number',
                                    'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                    $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                                ]
                            ); ?>
                 
                        <?=
                            $this->Form->control(
                                'inventory_status_id',
                                [
                                    'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                    'error' => [
                                        'attributes' => [
                                            'escape' => false,
                                        ],
                                    ],
                                    'options' => $inventory_statuses,
                                    'empty' => [0 => '(no status)'],
                                    $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                                ]
                            );
                        ?>

                        <?=
                            $this->Form->control(
                                'inventory_status_note',
                                [
                                    'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                    'error' => [
                                        'attributes' => [
                                            'escape' => false,
                                        ],

                                    ],
                                    $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                                ]
                            );
                        ?>
                
                        <?= $this->Form->control('location_id', [
                            'label' => "Move to",
                            'empty' => '(select)',
                            'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                            $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                        ]); ?>

                        <?php $disabled = ['disabled' => 'disabled']; ?>
                        <?=
                            $this->Form->control(
                                'ship_low_date',
                                [
                                    'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                    'label' => 'Ship low dated',
                                    $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                                ]
                            ); ?>

                    </div>
                </div>
                <?php echo $this->Form->button('Save', [ 
                     'name' => 'submit-action',
                    'class' => 'btn save btn-sm', 'type' => 'submit' , 'value' => 'submit']); ?>
                <?php echo $this->Form->button("Save & Reprint Label", [ 
                     'name' => 'submit-action',
                    'class' => 'btn btn-sm print', 'type' => 'submit' , 'value' => 'submit-and-reprint']); ?>
            </div>


        </div>
       
    </div>
    <div class="col">
    <div class="card">
            <div class="card-body">
                <h3>Change cartons or dates</h3>

                <?= $this->Form->control(
                    'full_pallet_quantity',
                    [
                        'label' => 'Full Pallet Required Total Cartons',
                        'value' => $pallet['items']['quantity'],
                        'disabled',
                        'id' => 'total'
                    ]
                ); ?>
                <?= $this->Form->control(
                    'current_total_cartons',
                    [
                        'value' =>  $pallet['qty'],
                        'disabled'
                    ]
                ); ?>

                <?= $this->Form->control(
                    'quantity_needed',
                    [
                        'label' => 'Quantity needed to make full pallet',
                        'value' => $pallet['items']['quantity'] - $pallet['qty'],
                        'disabled',
                        'id' => 'qty-needed'
                    ]
                ); ?>

                <?php foreach ($pallet['cartons'] as $carton) : ?>

                    <div class="row">
                        <div class="col-lg-4">
                            <?php echo $this->Form->hidden('cartons.' . $key . '.pallet_id'); ?>
                            <?php echo $this->Form->hidden('cartons.' . $key . '.id'); ?>
                            <?php echo $this->Form->hidden('cartons.' . $key . '.item_id'); ?>
                            <?php echo $this->Form->control('cartons.' . $key . '.production_date', [
                                'type' => 'date',
                                'class' => 'date-input production-date',
                                'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                            ]); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php echo $this->Form->control('cartons.' . $key . '.best_before', [
                                'type' => 'date',
                                'class' => 'date-input best-before',
                                'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                            ]); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php echo $this->Form->control('cartons.' . $key . '.count', [
                                'class' => 'carton-count',
                                'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
                                $user->can('bestBeforeEdit', $pallet) ? null : $disabled
                            ]); ?>
                        </div>
                    </div>
                    <?php $key++; ?>
                <?php endforeach; ?>
                <?php echo $this->Form->button('Save', [ 
                    'name' => 'submit-action',
                    'class' => 'btn save btn-sm', 'type' => 'submit' , 'value' => 'submit']); ?>
                <?php echo $this->Form->button("Save & Reprint Label", [ 
                     'name' => 'submit-action',
                    'class' => 'btn btn-sm print', 'type' => 'submit' , 'value' => 'submit-and-reprint']); ?>
            </div>
        </div>
    </div>

</div> <!-- end row -->



<?php echo $this->Form->end(); ?>