<?php
?>

<div class="container">
    <div class="row">
        <div class="col text-center mt-5">
            <p>Access denied because you are trying to access something you don't have permissions for</p>
            <?= $this->Html->link('Login here', ['controller' => 'Users', 'action' => 'login']); ?>
        </div>
    </div>
</div>