<?php
$this->Html->script(
    [
        'jquery.min',
        'put-away',
    ],
    [
        'inline' => false,
        'block' => 'script_bottom',
    ]
);
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

    <?php
echo $this->Form->create($pallet);
?>
    <div class="row">
        <div class="col-lg-12">
            <h4>Put-away</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-sm-2 col-lg-2">
            <?php
echo $this->Form->hidden('id');
echo $this->Form->hidden('location');
//        echo $this->Form->hidden('level');
//        echo $this->Form->hidden('col');
echo $this->Form->control(
    'item',
    [
        'disabled' => 'disabled',
    ]
);
?>
        </div>
        <div class="col-md-4 col-sm-4 col-lg-4">
            <?php
echo $this->Form->control(
    'description',
    [
        'disabled' => 'disabled',
    ]
);

?>
        </div>

        <div class="col-md-3 col-sm-3 col-lg-3">
            <?php
echo $this->Form->control('pl_ref', [
                'label' => 'Pallet Reference',
                'disabled' => 'disabled', ]);
?>
        </div>
    </div>

    <div class="row">
        <div class="offset-lg-2  col-lg-4 col-12">
            <?php
            echo $this->Form->control(
    'location_id',
    [
        'label' => 'Available Locations',
        'empty' => '(Please select an location)',
        'options' => $availableLocations,
        'custom' => true,
        'append' => $this->Form->button('Put-away', ['type' => 'submit']),
    ]
); ?>
        </div>
    </div>
    <?=$this->Form->end(); ?>
