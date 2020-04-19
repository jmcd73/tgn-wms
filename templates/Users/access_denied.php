<?php
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="row">
    <div class="col">
        <?= $this->Html->link('Log out', [
            'controller' => 'Users', 'action' => 'logout',
            '?' => [
                'redirect' => urlencode($redirect),
            ],
        ], [
            'class' => 'btn btn-primary sign-out',
        ]); ?>

    </div>
</div>