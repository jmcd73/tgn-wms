<?php use Cake\Core\Configure;

?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class='row'>
        <div class='col'>
            <?= $this->Form->create($pallet); ?>
            <?php
            echo $this->Form->hidden('id');

            echo $this->Form->hidden('referer', ['value' => $referer]);

            ?>
            <div class="row">
                <div class='col'>
                    <div class="col">
                        <h3><?= __('Move or Edit'); ?></h3>
                        <?php
                    echo $this->Form->control('shipment_id', [
                        'empty' => true,
                        'style' => '-moz-appearance: none;-webkit-appearance: none;appearance: none;',
                        'disabled' => 'disabled', ]);
                    echo $this->Form->control('item', ['disabled' => 'disabled']);
                    echo $this->Form->control('description', ['disabled' => 'disabled']);
                    echo $this->Form->control('pl_ref', ['disabled' => 'disabled']);
                    ?>
                    </div>
                </div>

                <div class='col'>
                    <div class="col">
                        <?php $disabled = ['disabled' => 'disabled']; ?>

                        <?php

                        $allowConfigUsers = in_array($user->get('username'), Configure::read('BestBeforeDateEditors'));
                        $allowRoleUsers = in_array($user->get('role'), ['qa', 'admin']);
                        $disabled_here = $allowConfigUsers || $allowRoleUsers ? null : $disabled; ?>

                        <?=
                    $this->Form->control(
                        'ship_low_date',
                        [
                            'label' => 'Ship low dated',
                            $disabled_here,
                        ]
                    );
                    ?>

                        <?php $allowRoleUsers = in_array($user->get('role'), ['qa', 'admin', 'qty_editor']);
                    $disabled_here = $allowRoleUsers ? null : $disabled; ?>
                        <?=
                    $this->Form->control(
                        'inventory_status_id',
                        [
                            'error' => [
                                'attributes' => [
                                    'escape' => false,
                                ],
                            ],
                            'options' => $inventory_statuses,
                            'empty' => [0 => '(no status)'],
                            $disabled_here,
                        ]
                    );
                    ?>

                        <?=
                    $this->Form->control(
                        'inventory_status_note',
                        [
                            'error' => [
                                'attributes' => [
                                    'escape' => false,
                                ],
                            ],

                            $disabled_here,
                        ]
                    );
                    ?>

                        <?= $this->Form->control('location_id', [
                            'empty' => '(select)',
                        ]); ?>


                        <?php

$allowConfigUsers = in_array($user->get('username'), Configure::read('BestBeforeDateEditors'));
$allowRoleUsers = in_array($user->get('role'), ['admin']);
$disabled_here = $allowRoleUsers || $allowConfigUsers ? null : $disabled; ?>

                        <?php
                echo $this->Form->control('bb_date', [
                    'dateFormat' => 'DMY',
                    $disabled_here,
                ]);
                ?>

                        <?= $this->Form->submit('Submit'); ?>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>