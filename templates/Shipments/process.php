<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>

<?php foreach ($productTypes as $key => $productType) : ?>
    <li class="nav-item">
        <?php $active = (int) $key === (int) $productTypeOrId ? 'active' : null;
        $classes = join(' ', array_filter(['nav-link', $active], function ($item) {
            return !is_null($item);
        }));
        ?>
        <?= $this->Html->link(
            'Add ' . $productType,
            ['action' => 'process', 'add-shipment', $key],
            ['class' => $classes]
        ); ?>
    </li>

<?php endforeach; ?>
<li class="nav-item"><?= $this->Html->link(
                            'Add Mixed',
                            ['action' => 'process', 'add-shipment'],
                            ['class' => 'nav-link'],
                        ); ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>


<?php echo $this->Html->scriptBlock(sprintf(
    'var csrfToken = %s;',
    json_encode($this->request->getAttribute('csrfToken'))
)); ?>

<?php foreach ($css as $style) : ?>
    <?php $this->Html->css($style, [
        'block' => 'css',
    ]); ?>
<?php endforeach; ?>
<?php foreach ($js as $script) : ?>

    <?= $this->Html->script($script, ['block' => 'from_view']); ?>

<?php endforeach; ?>


<div class="row">
    <div class="col">
        <?= $this->Html->tag('div', null, [
            'class' => 'col',
            'data-baseUrl' => $baseUrl, 'id' => 'root',
        ]); ?>
    </div>
</div>