<?php
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="row">
<div class="col-1">
        <?= $this->Html->link('Go back', 'javascript:window.history.back();'
        , [
            'class' => 'btn btn-secondary go-back',
        ]); ?>

    </div>
    <div class="col-1">
        <?= $this->Html->link('Log in as another user', [
            'controller' => 'Users', 'action' => 'logout',
            '?' => [
                'redirect' => urlencode($redirect),
            ],
        ], [
            'class' => 'btn btn-primary sign-out',
        ]); ?>

    </div>
</div>