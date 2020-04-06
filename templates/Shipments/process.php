<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->Html->scriptBlock(sprintf(
    'var csrfToken = %s;',
    json_encode($this->request->getAttribute('csrfToken'))
)); ?>

<?php foreach ($css as $style): ?>
<?php $this->Html->css($style, [
    'block' => 'css',
]); ?>
<?php endforeach; ?>
<?php foreach ($js as $script): ?>

<?= $this->Html->script($script, ['block' => 'from_view']); ?>

<?php endforeach;?>

<div class="container">
    <div class="row">
        <?= $this->Html->tag('div', null, [
            'class' => 'col',
            'data-baseUrl' => $baseUrl, 'id' => 'root', ]); ?>
    </div>
</div>