<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="row">
    <div class="h-100 justify-content-center align-items-center">
        <div class="col">
            <h3 class="text-center"><?php echo __('Select Print Type'); ?></h3>
            <ul class="nav justify-content-center">
                <?php foreach ($productTypes as $key => $productType): ?>
                <li class="nav-item">
                    <?php echo $this->Html->link($productType, [
                        'action' => 'palletPrint',
                        $key,
                    ], ['class' => 'nav-link']); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>