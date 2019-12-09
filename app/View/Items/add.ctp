<div class="container">
    <?php echo $this->Form->create('Item', ['bootstrap-size' => 'small']); ?>
    <fieldset>
        <legend><?php echo __('Edit Item'); ?></legend>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php
                echo $this->Form->input('active', ['default' => true]);
                echo $this->Form->input('product_type_id', [
                    'options' => $productTypes,
                    'empty' => '(select)'
                ]);
                echo $this->Form->input('code');
                echo $this->Form->input('print_template_id', [
                    'label' => "Pallet Label Print Template",
                    'escape' => false,
                    'empty' => '(Select a template)']);

                echo $this->Form->input('pallet_label_copies',
                    [
                        'placeholder' => $defaultPalletLabelCopies,
                        'label' => __('Pallet Label Copies <span class="secondary-text">Global value is <strong>%d</strong>. Leave blank to use global value</span>', $defaultPalletLabelCopies)
                    ]);
                echo $this->Form->input('carton_label_id', [
                    'label' => "Carton Label Print Template",
                    'escape' => false,
                    'options' => $printTemplates,
                    'empty' => '(Select a template)']);

                echo $this->Form->input('description');
                echo $this->Form->input('quantity', ['label' => [
                    'text' => 'Quantity per pallet'
                ]]);
                echo $this->Form->input('pack_size_id', [
                    'empty' => '(select)'
                ]);
            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php
                echo $this->Form->input('trade_unit', [
                    'label' => __('Trade Unit Barcode <span class="secondary-text">Specify a valid GTIN-14 barcode</span>')
                ]);
                echo $this->Form->input('consumer_unit', [
                    'label' => __('Consumer Unit Barcode <span class="secondary-text">Specify a valid GTIN-13 barcode</span>')
                ]);
                echo $this->Form->input('brand');
                echo $this->Form->input('variant');
                echo $this->Form->input('unit_net_contents');
                echo $this->Form->input('unit_of_measure');
                echo $this->Form->input(
                    'days_life',
                    [
                        'label' => 'Days Life <span class="secondary-text">This is added to the production date to get the expiry date</span>'
                    ]
                );
                echo $this->Form->input(
                    'min_days_life',
                    [
                        'placeholder' => $global_min_days_life,
                        'label' => [
                            'text' => "Minimum days life still remaining to allow shipment<span class='secondary-text'>Global value is <strong>" . $global_min_days_life . "</strong> Leave blank to use global value</span>"
                        ]
                    ]
                );
            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php
                echo $this->Form->input('item_comment', ['type' => 'textarea']);
                echo $this->Form->button(__('Submit'), [
                    'bootstrap-type' => 'primary',
                    'bootstrap-size' => 'lg'
            ]); ?>
        </div>
    </fieldset>
    <div class="col-lg-12">
        <?php echo $this->Form->end([
                'bootstrap-type' => 'primary'
        ]); ?>
    </div>
</div>