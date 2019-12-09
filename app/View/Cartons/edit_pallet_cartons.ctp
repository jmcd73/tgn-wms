<?php $this->Html->css([
        'bootstrap-datepicker3.min'
], ['inline' => false]); ?>
<?php $this->Html->script([
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'edit-pallet-cartons'
    ], [
        'inline' => false,
        'block' => 'from_view'
    ]
); ?>

<div class="container">


    <h4><?php echo $palletCartons['Pallet']['code_desc']; ?></h4>
    <p>Cartons starting count: <?php echo $palletCartons['Pallet']['qty']; ?></p>
    <p>Full pallet qty: <span id="total"><?php echo $palletCartons['Item']['quantity']; ?></span></p>
    <p>Quantity needed to make full pallet: <span
            id="qty-needed"><?php echo $palletCartons['Item']['quantity'] - $palletCartons['Pallet']['qty'] ?></span>
    </p>
    <?php //debug($palletCartons); ?>

    <?php echo $this->Form->create() ?>
    <?php echo $this->Form->hidden('Item.days_life'); ?>
    <?php echo $this->Form->hidden('Pallet.qty_user_id'); ?>
    <?php $key = 0; ?>
    <?php foreach ($palletCartons['Carton'] as $carton): ?>
    <?php echo $this->Form->hidden('Carton.' . $key . '.pallet_id'); ?>

    <?php echo $this->Form->hidden('Carton.' . $key . '.id'); ?>
    <div class="row">
        <div class="col-lg-4">

            <?php echo $this->Form->input('Carton.' . $key . '.production_date', [
                    'type' => 'text',
                    'class' => 'date-input production-date'
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('Carton.' . $key . '.best_before', [
                    'type' => 'text',
                    'class' => 'date-input best-before'
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('Carton.' . $key . '.count', [
                    'class' => 'carton-count'
            ]); ?>
        </div>

    </div>
    <?php $key++; ?>
    <?php endforeach; ?>

    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
</div> <!-- end container -->