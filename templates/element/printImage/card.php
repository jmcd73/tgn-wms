<?php ?>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title mt-3"><?= h($name); ?></h5>
        <h6 class="card-subtitle mb-2"><?= h($description); ?></h6>
        <?php if(isset($filename) && !empty($filename)): ?>
            <p class="card-text"><?= h($filename); ?></p>
        <?php endif; ?>
        <?= $this->Html->image($image, ['class' => 'img-fluid']); ?>
        
        
       
    </div>
</div>