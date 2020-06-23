<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->Html->scriptBlock(sprintf(
    'var csrfToken = %s;',
    json_encode($this->request->getAttribute('csrfToken'))
)); ?>

<?php foreach ($css as $style): ?>

<?= $this->Html->css($style, [
    'block' => true,
]); ?>
<?php endforeach; ?>

    <div class="row">
        <div class="col">
        <?= $this->Html->tag('div', null, [
            'class' => 'col',
            'data-baseUrl' => $baseUrl, 'id' => 'root', ]); ?>
        </div>
    </div>

<?php foreach ($js as $script): ?>

<?= $this->Html->script($script); ?>

<?php endforeach;?>