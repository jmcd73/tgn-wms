<?php ?>

<div class="card mb-3" style="width: 18rem;">
    <div class="card-body">
        <?= $this->Html->image($image, ['class' => 'img-fluid']); ?>
        <h5 class="card-title mt-3"><?= h($name); ?></h5>
        <p class="card-text"><?= h($description); ?></p>
    </div>
</div>