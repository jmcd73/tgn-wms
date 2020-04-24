<?php
/**
 * @var \App\View\AppView                                                      $this
 * @var \App\Model\Entity\Item                                                 $item
 * @var \App\Model\Entity\PackSize[]|\Cake\Collection\CollectionInterface      $packSizes
 * @var \App\Model\Entity\ProductType[]|\Cake\Collection\CollectionInterface   $productTypes
 * @var \App\Model\Entity\PrintTemplate[]|\Cake\Collection\CollectionInterface $printTemplates
 * @var \App\Model\Entity\Carton[]|\Cake\Collection\CollectionInterface        $cartons
 * @var \App\Model\Entity\Pallet[]|\Cake\Collection\CollectionInterface        $pallets
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<?php echo $this->Form->create(null, [
    'method' => 'GET',
]);
echo $this->Form->control(
    'item_id',
    [
        'label' => 'Select an item to copy',
        'options' => $items,
        'empty' => true,
    ]
);
echo $this->Form->submit('Copy');
echo $this->Form->end();
?>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<div class="col">' . $this->fetch('tb_actions') . '</div>'); ?>

<div class="items form content">
    <?= $this->Form->create(
    $item,
) ?>
    <fieldset>
        <?php if (is_object($itemToClone)): ?>
        <?php $copiedFrom = ' <small>copied from <strong>' . $itemToClone->code_desc . '</strong></small>'; ?>
        <?php endif; ?>
        <legend><?= __('Add Item') ?><?= $copiedFrom ?? ''; ?></legend>

        <div class="row">
            <div class="col">
                <?php  echo $this->Form->control('active', [
                    'type' => 'checkbox',
                    'default' => 1, ]);
            echo $this->Form->control('code');
            echo $this->Form->control('product_type_id', ['options' => $productTypes]);
            echo $this->Form->control('description');
            echo $this->Form->control('quantity', ['label' => 'Quantity per pallet']);
            echo $this->Form->control('pack_size_id', ['options' => $packSizes, 'empty' => true]);
            echo $this->Form->control('days_life');
?>
                <?= $this->Form->button(__('Submit')) ?>
            </div>
            <div class="col">
                <?php
                echo $this->Form->control('min_days_life');
                echo $this->Form->control('brand');
                echo $this->Form->control('variant');
                echo $this->Form->control('unit_net_contents');
                echo $this->Form->control('unit_of_measure');
                echo $this->Form->control('item_comment'); ?>
            </div>
            <div class="col">
                <?php
            echo $this->Form->control('trade_unit');
            echo $this->Form->control('consumer_unit');
            echo $this->Form->control('pallet_template_id', [
                'escape' => false,
                'empty' => true,
                'options' => $printTemplates, ]);
            echo $this->Form->control('carton_template_id', [
                'escape' => false,
                'empty' => true,
                'options' => $printTemplates, ]);
            echo $this->Form->control('pallet_label_copies');
            echo $this->Form->control('item_wait_hrs', [
                'escape' => false,
                'label' => 'Item Wait Hrs<span class="secondary-text">Enable wait time in hours for QA checks. Disables
                    ability to put on a shipment for this number of hours</span>', ]); ?>
            </div>
        </div>
    </fieldset>

    <?= $this->Form->end() ?>
</div>