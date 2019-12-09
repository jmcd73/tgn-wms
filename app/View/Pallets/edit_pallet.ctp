

<div class="container">

    <div class='row'>
        <div class='col-md-12'>
            <?= $this->Form->create('Pallet'); ?>

            <?php
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('product_type_id');
            echo $this->Form->hidden('shipment_id');
            echo $this->Form->hidden('referer');
			echo $this->Form->hidden('previous_location');
			echo $this->Form->hidden('qty_before');
			echo $this->Form->hidden('print_date');
			echo $this->Form->hidden('cooldown_date');
			echo $this->Form->hidden('previousLocationId');
			echo $this->Form->hidden('inventory_status_id');
            echo $this->Form->hidden('dont_ship');
			echo $this->Form->hidden('qty_user_id');
			echo $this->Form->hidden('item_id');
            ?>
            <h3><?= __('Move or Edit'); ?></h3>
            <div class='col-md-4'>
                <div class="col-md-12">
                    <?php
                    echo $this->Form->input('shipment_id', [
                        'empty' => true,
                        'style' => '-moz-appearance: none;-webkit-appearance: none;appearance: none;',
                        'disabled' => 'disabled']);
                    echo $this->Form->input('item', ['disabled' => 'disabled']);
                    echo $this->Form->input('description', ['disabled' => 'disabled']);
                    echo $this->Form->input('pl_ref', ['disabled' => 'disabled']);
                    ?>
                </div>
            </div>
            <div class='col-md-1'></div>
            <div class='col-md-5'>
                <div class="col-lg-12">
                    <?php $disabled = ['disabled' => 'disabled']; ?>

                    <?php $disabled_here = (
                            $user['role'] === 'qa' ||
                            $user['role'] === 'admin' ||
                            in_array($user['username'], Configure::read('BestBeforeDateEditors'))
                          ) ? null : $disabled; ?>

                    <?=
                    $this->Form->input(
                            'ship_low_date',
                            [
                            'label' => [
                            'text' => "Ship low dated",
                            'class' => 'col-lg-2 control-label',

                        ],
                                $disabled_here
                    ]);
                    ?>

                       <?php $disabled_here = (
                            $user['role'] === 'admin' ||
                                $user['role'] === 'qty_editor' ||
                               $user['role'] === 'qa'

                          ) ? null : $disabled; ?>

                    <!-- <?=
                    $this->Form->input('qty', [
                        'label' => __('Quantity<span class="secondary-text">Full pallet qty is <span class="badge">%d</span></span>', $item_qty),
                        $disabled_here
                    ]);
                    ?> -->
                     <?php $disabled_here = (
                            $user['role'] === 'admin' ||
                               $user['role'] === 'qa'

                          ) ? null : $disabled; ?>

                    <?=
                    $this->Form->input('inventory_status_id', [
                        'error' => [
                            'attributes' => [
                                'escape' => false
                            ]
                        ],
                        'options' => $inventory_statuses,
                        'empty' => [0 => '(no status)'],
                        $disabled_here
                        ]
                            );
                    ?>

                 <?=
                    $this->Form->input('inventory_status_note', [
                        'error' => [
                            'attributes' => [
                                'escape' => false
                            ]
                        ],

                        $disabled_here
                        ]
                            );
                    ?>

                <?= $this->Form->input('location_id', [
                    'empty' => '(select)'
                    ]); ?>
                </div>
                <div class="col-lg-12"> <label>Best Before</label></div>

                <?php $disabled_here = (
                            $user['role'] === 'admin' ||
                            in_array($user['username'], Configure::read('BestBeforeDateEditors'))
                          ) ? null : $disabled; ?>

                <?php
                echo $this->Form->input('bb_date', [
                    'dateFormat' => 'DMY',
                    'label' => false,
                    'format' => ['before', 'input', 'between', 'label', 'after', 'error'],
                    'before' => '<div><div class="col-lg-4 col-md-4 col-sm-4">',
                    'separator' => '</div><div class="col-lg-4 col-md-4 col-sm-4">',
                    'after' => '</div></div>',
                    'error' => 'err',
                    $disabled_here
                ]);
                ?>
            </div>

<?= $this->Form->end([
	'bootstrap-type' => 'primary',
	'class' => 'tpad'
]); ?>

        </div>
    </div>
</div>
