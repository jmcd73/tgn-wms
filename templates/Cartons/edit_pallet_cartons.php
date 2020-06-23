<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->Html->css([
    'bootstrap-datepicker3.min',
], ['inline' => false]); ?>
<?php $this->Html->script(
    [
        'bootstrap-datepicker.min',
        'locales/bootstrap-datepicker.en-AU.min',
        'edit-pallet-cartons',
    ],
    [
        'inline' => false,
        'block' => 'from_view',
    ]
); ?>

<div class="row">
<div class="col">


    <h4><?php echo $palletCartons['code_desc']; ?></h4>
    <p>Cartons starting count: <?php echo $palletCartons['qty']; ?></p>
    <p>Full pallet qty: <span id="total"><?php echo $palletCartons['items']['quantity']; ?></span></p>
    <p>Quantity needed to make full pallet: <span
            id="qty-needed"><?php echo $palletCartons['items']['quantity'] - $palletCartons['qty'] ?></span>
    </p>
    <?php //debug($palletCartons);?>

    <?php echo $this->Form->create($palletCartons) ?>
    <?php echo $this->Form->hidden('items.days_life', ['id' => 'ItemDaysLife']); ?>
    <?php echo $this->Form->hidden('qty_user_id'); ?>
    <?php $key = 0; ?>
    <?php foreach ($palletCartons['cartons'] as $carton): ?>
    <?php echo $this->Form->hidden('cartons.' . $key . '.pallet_id'); ?>

    <?php echo $this->Form->hidden('cartons.' . $key . '.id'); ?>
    <div class="row">
        <div class="col-lg-4">

            <?php echo $this->Form->control('cartons.' . $key . '.production_date', [
                'type' => 'date',
                'class' => 'date-input production-date',
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->control('cartons.' . $key . '.best_before', [
                'type' => 'date',
                'class' => 'date-input best-before',
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->control('cartons.' . $key . '.count', [
                'class' => 'carton-count',
            ]); ?>
        </div>

    </div>
    <?php $key++; ?>
    <?php endforeach; ?>

    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
</div> <!-- end col -->
</div> <!-- end row -->