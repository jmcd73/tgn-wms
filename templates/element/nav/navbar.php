<?php
use Cake\Core\Configure;

?>
<nav class="navbar navbar-dark navbar-expand-lg sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-md-2"
        href="<?= $this->Url->build('/'); ?>"><?= Configure::read('applicationName'); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php foreach ($menuTree as $menu): ?>
            <?php if ($menu->admin_menu && !$isAdmin) {
    continue;
} ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?= $menu->name ; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php foreach ($menu->children as $child): ?>
                    <?php list($controller, $action) = explode('::', $child->bs_url); ?>
                    <?= $child->divider ? '<div class="dropdown-divider"></div>' : ''; ?>
                    <?= $this->Html->link($child->name, [
                        'controller' => $controller,
                        'action' => $action,
                    ], [
                        'class' => 'dropdown-item',
                    ]); ?>


                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-4">
            <li><a href="/users/logout" title="Click here to logout">Admin User</li>
            <li><?=
                $this->Html->link('Help', ['controller' => 'Pages', 'action' => 'display', 'help'], [
                    'class' => 'ml-3',
                ]); ?></li>
        </ul>
    </div>
</nav>