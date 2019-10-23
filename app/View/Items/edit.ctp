<div class="container">
<?= $this->Form->create('Item'); ?>
	<fieldset>
		<legend><?= __('Edit Item'); ?></legend>
                <div class="col-lg-4 col-md-4 col-sm-6">
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
                echo $this->Form->input('product_type_id', [
                    'options' => $productTypes,
                    'empty' => '(select)'
                ]);

		echo $this->Form->input('code');
		echo $this->Form->input('description');
        echo $this->Form->input('print_template_id', [
			'label' => 'Pallet Label Template',
			'empty' => '(Select a template)']);
        echo $this->Form->input('carton_label_id', [
			'options' => $printTemplates,
			'label' => "Carton Label Template",
            'empty' => '(Select a template)']);
		echo $this->Form->input('quantity',
                        ['label' => [

                            'text' => 'Quantity per pallet'
                ]]);
                echo $this->Form->input('pack_size_id');
		echo $this->Form->input('trade_unit', [
                    'label' => "Trade Unit Barcode"
                ]);
		echo $this->Form->input('consumer_unit', [
                    'label' => "Consumer Unit Barcode"
                ]);
                ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">

                <?php
		echo $this->Form->input('brand');
		echo $this->Form->input('variant');
		echo $this->Form->input('unit_net_contents');
		echo $this->Form->input('unit_of_measure');
		echo $this->Form->input('days_life', [ 'label' => 'Days Life: This is added to the production date to get the expiry date']);
               echo $this->Form->input(
                           'min_days_life',
                    [
                        'placeholder' =>  $global_min_days_life ,
                        'label' => [

                        'text' => "Minimum days life still remaining to allow shipment (Global value is " . $global_min_days_life . " Leave as 0 to use global value)"
                    ]]);
               ?></div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                    <?php echo $this->Form->input('item_comment', [ 'type'=> 'textarea']); ?>

                    </div>

	</fieldset>
	<div class="col-lg-12">
	<?= $this->Form->end([
		'bootstrap-type' => 'primary'
	]); ?>
	</div>

</div>
