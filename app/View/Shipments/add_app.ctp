
<?php foreach( $css as $style ): ?>
<?php $this->Html->css($style, [
    'block' => 'css'
]); ?>
<?php endforeach; ?>
<?php foreach( $js as $script ): ?>

<?= $this->Html->script($script, [ 'block' => 'from_view']); ?>

<?php endforeach;?>

<div class="container">
<?= $this->Html->tag('div', null, ['data-baseUrl' => $baseUrl, 'id' => 'root']); ?>
</div>
