<div class="container">
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12">
<h3 class="text-center"><?php echo __("Select Print Type"); ?></h3>
<ul class="nav nav-pills nav-justified bpad">
<?php foreach ($productTypes as $key => $productType): ?>
<li>
<?php echo $this->Html->link($productType, [
        'action' => 'pallet_print',
        $key
]); ?>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>