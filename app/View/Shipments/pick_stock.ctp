
<?php foreach( $css as $style ): ?>

<?= $this->Html->css( $style, [
    'block' => true
]); ?>
<?php endforeach; ?>

<div class="container">
    <div class="row">
<?= $this->Html->tag('div', null, ['data-baseUrl' => $baseUrl, 'id' => 'root']); ?>
</div>
</div>
<?php foreach( $js as $script ): ?>

<?= $this->Html->script( $script); ?>

<?php endforeach;?>
