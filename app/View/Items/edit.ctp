<div class="container">
<?=$this->Form->create('Item'); ?>
	<fieldset>
	<legend><?=__('Edit Item'); ?></legend>

    <div class="col-lg-4 col-md-4 col-sm-6">
	<?php
        echo $this->Form->input('id');
        echo $this->Form->input('active');
        echo $this->Form->input('product_type_id', [
            'options' => $productTypes,
            'empty' => '(select)',

        ]);

        echo $this->Form->input('code');
        echo $this->Form->input('description');
        echo $this->Form->input('print_template_id', [
            'label' => "Pallet Label Print Template",
            'empty' => '(Select a template)',
            'escape' => false
            ]);

        echo $this->Form->input(
            'pallet_label_copies',
            [
                'placeholder' => $defaultPalletLabelCopies,
                'label' => [
                    'text' => "Pallet Label Copies <span class='secondary-text'>Global value is <strong>" . $defaultPalletLabelCopies . "</strong> Leave blank to use global value</span>"
                ]
            ]
        );

        echo $this->Form->input('carton_label_id', [
            'label' => "Carton Label Print Template",
            'options' => $printTemplates,
            'escape' => false,
            'label' => "Carton Label Template",
            'empty' => '(Select a template)']);
        echo $this->Form->input('quantity',
            ['label' => [

                'text' => 'Quantity per pallet'
            ]]);
        echo $this->Form->input('pack_size_id');
    ?>
</div>
                <div class="col-lg-4 col-md-4 col-sm-6">

                <?php
                    echo $this->Form->input('trade_unit', [
                        'label' => "Trade Unit Barcode"
                    ]);
                    echo $this->Form->input('consumer_unit', [
                        'label' => "Consumer Unit Barcode"
                    ]);
                    echo $this->Form->input('brand');
                    echo $this->Form->input('variant');
                    echo $this->Form->input('unit_net_contents');
                    echo $this->Form->input('unit_of_measure');
                    echo $this->Form->input('days_life', ['label' => 'Days Life <span class="secondary-text">This is added to the production date to get the expiry date</span>']);
                    echo $this->Form->input(
                        'min_days_life', [
                            'placeholder' => $global_min_days_life,
                            'label' => [
                                'text' => "Minimum days life still remaining to allow shipment<span class='secondary-text'>Global value is <strong>" . $global_min_days_life . "</strong> Leave blank to use global value</span>"
                            ]
                        ]
                    );
                ?>
                </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
          <?php echo $this->Form->input('item_comment', ['type' => 'textarea']); ?>
<?php
    echo $this->Form->button(__('Submit'), [
        'bootstrap-type' => 'primary',
        'bootstrap-size' => 'lg'
]); ?>
                    </div>

	</fieldset>
	<div class="col-lg-12">
	<?=$this->Form->end([
    'bootstrap-type' => 'primary'
]); ?>
	</div>

</div>