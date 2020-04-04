<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-6">

            <?= $this->Form->create(null, [
                'horizontal' => true,
            ]); ?>
            <h4>Keep Refrigerated</h4>
            <span id="error"></span>

            <?= $this->Form->input('printer', [
                'placeholder' => 'Enter a number',
                'type' => 'radio',
                'inline' => true,
                'label' => 'Printer',
                'legend' => false,
                'options' => $printers['printers'],
                'default' => $printers['default'] ? $printers['default'] : '',
            ]);?>
            <?= $this->Form->input('copies', [
                'placeholder' => 'Enter a number',
            ]); ?>

            <?= $this->Form->end('Submit'); ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <h4>Example</h4>
            <?= $this->Html->image($template->image, [
                'class' => 'img-responsive',
            ]); ?>
            <h5>Instructions</h5>
            <p>You have to select a printer, enter the number of copies</p>
        </div>
    </div>
</div>