<?php
$this->Html->script(
    [
        'jquery.min',
    ],
    [
        'inline' => false,
        'block' => 'script_bottom',
    ]
);
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>


    <div class="row">
        <div class="col-lg-12">
            <h4>Move Pallet</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <dl class="row">
                <dt class="col-sm-6">Item</dt>
                <dd class="col-sm-6"><?= h($pallet->item); ?></dd>

                <dt class="col-sm-6">Description</dt>
                <dd class="col-sm-6">
                    <?= h($pallet->description); ?>
                </dd>
                <dt class="col-sm-6">Pallet reference</dt>
                <dd class="col-sm-6">
                    <?= h($pallet->pl_ref); ?>
                </dd>
                <dt class="col-sm-6">Current Location</dt>
                <dd class="col-sm-6">
                    <?= h($pallet->location->location); ?>
                </dd>
            </dl>

            <?php
                echo $this->Form->create($pallet);
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('location_id');
                echo $this->Form->hidden('referer', ['value' => $referer]);
                echo $this->Form->hidden('previous_location_id', ['value' => $pallet->location_id]);
                echo $this->Form->control(
                    'location_id',
                    [
                        'custom' => true,
                        'label' => 'Select new location',
                        'empty' => '(Please select an location)',
                        'options' => $availableLocations,
                        'append' => $this->Form->button('Move', ['type' => 'submit']),
                    ]
                ); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>