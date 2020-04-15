<?php
?>

<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<div class="row">
    <div class="col text-center mt-5">
        <p>Access denied! Your account does not have permission to access that location</p>
        <?= $this->Html->link('Swap login here', ['controller' => 'Users', 'action' => 'login']); ?>
    </div>
</div>