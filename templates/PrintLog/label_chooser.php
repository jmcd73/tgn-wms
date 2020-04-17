<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Label Chooser</h1>
            <h5>Click on a image to select a label to print</h5>
        </div>
    </div>
    <?php foreach ($printTemplatesThreaded as $printTemplate): ?>
    <div class="row">
        <div class="col">
            <h3><?= $printTemplate['name'] ; ?></h3>
            <p><?=  $printTemplate['description'] ; ?></p>
        </div>
    </div>
    <div class="row">
        <?php foreach ($printTemplate['children'] as $ptc) : ?>
        <?php list($controller, $action) = explode('::', $ptc['controller_action']); ?>

        <?php if (empty($controller) || empty($action)) {
    continue;
} ?>
        <div class="col-3 mb-4">
            <div class="card ">
                <div class="card-body">
                    <?=$this->Html->link(
    $this->Html->image(
        DS . $glabelsRoot . DS . $ptc['example_image'],
        ['class' => 'card-img-top']
    ),
    [
        'controller' => $controller,
        'action' => $action,
    ],
    [
        'escape' => false,
    ]
); ?>
                    <h3 class="card-title mt-3"><?=h($ptc['name']); ?></h3>
                    <p class="card-text"><?=h($ptc['description']); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <?php endforeach; ?>
</div>