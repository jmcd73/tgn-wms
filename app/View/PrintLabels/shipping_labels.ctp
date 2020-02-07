<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <h4>Pallet Transport Labels</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <?=$this->Form->create(null, [
                'horizontal' => true,
            ]);?>
            <?=$this->Form->input(
                'printer',
                [
                    'legend' => false,
                    'label' => 'Printer',
                    'type' => 'radio',
                    'inline' => true,
                    'id' => 'printer',
                    'options' => $printers['printers'],
                    'default' => $printers['default'] ? $printers['default'] : '',
                ]
            )?>

            <?=$this->Form->input('copies', [
                'options' => [1 => 'One', 2 => 'Two'],
                'legend' => false,
                'label' => 'Copies',
                'type' => 'radio',
                'default' => 1,
                'inline' => true,
            ]);?>

            <?=$this->Form->input('sequence-start', [
                'label' => 'Start',
                'options' => $sequence,
            ]);?>

            <?=$this->Form->input('sequence-end', [
                'label' => 'End',
                'options' => $sequence,
            ]);?>


            <?=$this->Form->input('state', [
                'label' => 'State or Destination',
                'empty' => '(select or enter a custom destination)',
                'placeholder' => 'Enter the state or destination title',
            ]);?>
            <?=$this->Form->input('address', [
                'maxLength' => 48,
                'size' => 48,
                'placeholder' => 'Enter the address',
            ]);?>
            <?=$this->Form->input('reference', [
                'maxLength' => 20,
                'size' => 20,
                'placeholder' => 'SO-M000056',
            ]);?>
            <?=$this->Form->end([
                'label' => 'Print',
                'bootstrap-type' => 'primary',
            ]);?>

        </div>
        <div class="col-lg-4">
            <h4>Example</h4>
            <?=$this->Html->image($template->image, [
                'class' => 'img-responsive',
            ]);?>
        </div>


    </div>


</div>