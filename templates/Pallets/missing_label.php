<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>


<h1><?= h($pallet->code_desc); ?></h1>
<h2><?= h($pallet->pl_ref); ?></h2>
<p>There is no label for this pallet. To create one please click the button</p>

<?= $this->Html->link('Create Label', [
    'controller' => 'PrintLog',
    'action' => "palletLabelReprint",
    $pallet->id
],

[
    'class' => 'btn btn-primary print'
]); ?>