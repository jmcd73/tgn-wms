<?php

use Cake\Core\Configure;

?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="row">
    <div class="col">
        <h3><?= __('Move or Edit'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col">
        <?= $this->Form->create($pallet); ?>
        <?php echo $this->Form->hidden('id');
        echo $this->Form->hidden('referer', ['value' => $referer]); ?>
        <?php if ($pallet->shipment_id != 0) {
            echo $this->Form->control('shipment_id', [
                'empty' => true,
                'style' => '-moz-appearance: none;-webkit-appearance: none;appearance: none;',
                'disabled' => 'disabled',
            ]);
        }
        echo $this->Form->control('item', ['disabled' => 'disabled']);
        echo $this->Form->control('description', ['disabled' => 'disabled']);
        echo $this->Form->control('pl_ref', ['disabled' => 'disabled']);
        ?>
    </div>
    <div class='col'>

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
            'empty' => '(select)',
        ]); ?>
        <?php
        echo $this->Form->control('bb_date', [
            'dateFormat' => 'DMY',
            'help' =>  $user->canResult('bestBeforeEdit', $pallet)->getReason(),
            $user->can('bestBeforeEdit', $pallet) ? null : $disabled
        ]);
        ?>
        <?= $this->Form->submit('Submit'); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>