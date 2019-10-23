
<?php foreach( $css as $style ): ?>

<?= $this->Html->css( $style, [
    'block' => true
]); ?>
<?php endforeach; ?>

<?= $this->Html->tag('div', null, ['data-baseUrl' => $baseUrl, 'id' => 'root']); ?>

<?php foreach( $js as $script ): ?>

<?= $this->Html->script( $script); ?>

<?php endforeach;?>
