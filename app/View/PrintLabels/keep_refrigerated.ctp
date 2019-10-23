<div class="container">
    <div class="row">
            <div class="col-md-6 col-lg-6">

                <?= $this->Form->create(null, [
                    'horizontal' => true
                ]); ?>
                    <h4>Keep Refrigerated</h4>
                    <span id="error"></span>
                    <?php $options = [
                        'type' => 'radio',
                        'inline' => true,
                        'label' => 'Printer',
                        'legend'=> false,
                        'options' => $printers,

                    ];
                    if ($default) {
                        $options += ['default' => $default];
                        $this->log(['myoptions'=> $options ]);
                    }
                    echo $this->Form->input('printer', $options ); ?>

                  <?= $this->Form->input('copies', [
                      'placeholder' => 'Enter a number'
                  ]);?>
                <?= $this->Form->end('Submit'); ?>
            </div>
            <div class="col-md-6 col-lg-6">
                <h4>Example</h4>
                <?= $this->Html->image($glabelsExampleImage, [
						'class' => 'img-responsive'
				]); ?>
				<h5>Instructions</h5>
				<p>You have to select a printer, enter the number of copies</p>
            </div>
        </div>
</div>
