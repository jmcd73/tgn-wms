<?php
    echo $this->Html->script(
        [
            'bootstrap-datepicker.min',
            'samples'
        ], ['block' => 'from_view']);

    $this->Html->css(['bootstrap-datepicker3.min'], ['inline' => false]);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <h4>Create sample labels</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-offset-2 col-md-3">
            <?php echo $this->Form->create(null); ?>
            <?=$this->Form->hidden('code', ['name' => 'code', 'value' => 'sample']);?>
            <?=$this->Form->input('printer', [
    'options' => $printers,
    'default' => $default
]);?>
<?php
    echo $this->Form->input('copies', [
        'options' => $sequence,
        'label' => [
            'text' => "How many labels?"
        ]
    ]);
?>
<?php
    echo $this->Form->input('productName', [

        'label' => [
            'text' => 'Product Name (24 Characters max)'
        ],
        'maxLength' => 24
    ]);
?>
<?php
    echo $this->Form->input('batch', [

        'label' => [
            'text' => 'Batch (' . substr($this->Time->format(time(), '%Y%j'), 3) . 'XX) where XX is batch No. of the day'
        ],
        'placeholder' => substr($this->Time->format(time(), '%Y%j'), 3) . 'XX'
    ]);
?>
<?php
    echo $this->Form->input('manufactureDate', [

        'label' => [
            'text' => 'Manufacturing Date (dd/mm/yyyy)'
        ],
        'class' => 'form-control datepicker',
        'autocomplete' => "off",
        'default' => date('d/m/Y')
    ]);
?>


<?php
    echo $this->Form->input('bestBefore', [
        'class' => 'form-control datepicker',
        'autocomplete' => "off",
        'label' => [
            'text' => 'Best Before Date (dd/mm/yyyy)'
        ]
    ]);
?>
<?php
    echo $this->Form->input('comment', [

        'label' => [
            'text' => 'Comment (36 Characters max)'
        ],
        'maxLength' => 36
    ]);
?>



            <?=$this->Form->end([
    'id' => 'print1',
    'label' => 'Print',
    'bootstrap-type' => 'primary',
    'data-toggle' => "modal",
    'data-target' => "#samplePrintModal"
]);?>

        </div>
        <div class="col-md-3">
            <!-- add sample print -->
            <p>Load 100x50 labels in printer</p>
            <?=$this->Html->image($glabelsExampleImage, ['class' => 'img-responsive']);?>
            <em>Sample Label</em>
        </div> <!-- col-md-3 -->
    </div>
</div>


<div class="modal fade" id="samplePrintModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Print Labels</h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 1.5em;">Do you want to print <strong id="qty"></strong> label<span id="isplural"></span> to the <strong id="printer"></strong> printer?</p>

                <div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span> Make sure you have loaded 100x50 labels in the printer first</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                <button type="button" id="btn-print" class="btn btn-primary btn-lg">Print</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
