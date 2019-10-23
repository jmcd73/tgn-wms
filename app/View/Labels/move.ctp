
<?php
$this->Html->script([
    'jquery.min',
    'jmits/jmits'
        ], [
    'inline' => false,
    'block' => 'script_bottom'
        ]
);
?>
<div class="container">
<?php
echo $this->Form->create('Label', [
    'inputDefaults' => [
        'format' => ['label', 'before', 'input', 'after'],
        'before' => '<div class="col-sm-8">',
        'after' => '</div>',
        'label' => [
            'class' => 'control-label col-sm-4'
        ]
    ]
]);
?>
<div class="row">
    <div class="col-lg-12">
        <h4>Move</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-sm-2 col-sm-2 col-lg-2">
        <?php
        echo $this->Form->input('id');
        echo $this->Form->hidden('location');
        echo $this->Form->hidden('location_id');
        echo $this->Form->hidden('referer');
         echo $this->Form->hidden('previous_location');
//        echo $this->Form->hidden('level');
//        echo $this->Form->hidden('col');
        echo $this->Form->input(
                'item', [
            'div' => [
                'class' => 'form-group form-group-sm'
            ],
            'disabled' => 'disabled',
            'class' => 'form-control'
                ]
        );
        ?>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-4">
        <?php
        echo $this->Form->input(
                'description', [
            'disabled' => 'disabled',
            'div' => [
                'class' => 'form-group form-group-sm'
            ],
            'class' => 'form-control'
                ]
        );
        ;
        ?>
    </div>

    <div class="col-md-2 col-sm-6 col-lg-2">
        <?php
        echo $this->Form->input('pl_ref', [
            'class' => 'form-control',
            'label' => "Pallet Reference",
            'div' => [
                'class' => 'form-group form-group-sm'
            ],
            'disabled' => 'disabled']);
        ?>
    </div>



</div>
<div class="row">
			<div class="col-lg-offset-2 col-lg-6">
			<?php
        echo $this->Form->input('previous_location_id', [
            'class' => 'form-control',
			'label' => "Current Location",

			'options' => $locations,
            'div' => [
                'class' => 'form-group form-group-sm'
            ],
            'disabled' => 'disabled']);
        ?>
			</div>
</div>
<div class="row">
    <div class="col-lg-2">

    </div>
	<div class="col-lg-6">
	<?php
			echo $this->Form->input(
				'location_id',
				[
					'label' => 'Select new location',
			        'empty' => '(Please select an location)',
			        'options' => $availableLocations,
			        'div' => [
			            'class' => 'toggen form-group-lg',
			        ],
					'class' => 'toggen',
					'append' => $this->Form->submit('Put-away', [
						'class' => 'btn btn-primary btn-lg'
					])
		    	]
				); ?>
	</div>
</div>

<?= $this->Form->end(); ?>
</div>
