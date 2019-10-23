<div class="container">

    <div class="row">
            <div class="col-md-9">
                <?= $this->Form->create(null, [
                    'horizontal' => true
                ]); ?>
                    <h4>Pallet Transport Labels</h4>
                    <span id="error"></span>
                    <?php $i = 0; ?>
                    <?= $this->Form->input('printer', [
                        'type' => 'radio',
                        'inline' => true,

                        'label' => 'Printer',
                        'legend'=> false,
                        'options' => $printers,
                        'default' => $default ? $default : ""
                    ]); ?>


                  <?= $this->Form->input('copies', [

                      'placeholder' => 'Enter a number'
                  ]);?>

                        <?= $this->Form->input('companyName',[

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'default' => Configure::read('companyName'),
                            'placeholder' => 'Company Name'
                        ]); ?>
                   <?= $this->Form->input('productName',[

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Product Name'
                        ]); ?>

                  <?= $this->Form->input('productDescription',[

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Product Description'
                        ]); ?>

                     <?= $this->Form->input('genericLine1',[
                            'label' => 'Line 1',

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Line 1'
                        ]); ?>

                    <?= $this->Form->input('genericLine2',[
                            'label' => 'Line 2',

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Line 2'
                        ]); ?>
                         <?= $this->Form->input('genericLine3',[
                             'label' => 'Line 3',

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Line 3'
                        ]); ?>


                 <?= $this->Form->input('genericLine4',[
                            'label' => 'Line 4',

                            'maxlength' => 48,
                            'size' => 48,
                            'autocomplete'=>"off",
                            'placeholder' => 'Line 4'

                        ]); ?>





                <?= $this->Form->end([
					'label' => 'Print',
					'bootstrap-type' => 'primary'
				]); ?>
            </div>
            <div class="col-md-3">
                <h4>Example</h4>
                <?= $this->Html->image($glabelsExampleImage); ?>
		<p>You have to select a printer, enter the number of copies (defaults to 1) and at least fill in one field</p>
            </div>
        </div>
</div>
