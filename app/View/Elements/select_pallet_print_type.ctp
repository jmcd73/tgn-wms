<div class="container">
<h1> <?php echo __( "Select Print Type") ;?></h1>
<ul>
<?php foreach($productTypes as $key => $productType): ?>
<li>
<?php echo $this->Html->link( $productType, [
    'action' => 'pallet_print',
    $key
]); ?>
</li>
<?php endforeach; ?>
</ul>
</div>