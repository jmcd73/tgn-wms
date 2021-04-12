<?php

use Cake\Core\Configure;
use Cake\Utility\Inflector;

?>
<nav class="navbar navbar-dark navbar-expand-lg sticky-top bg-dark flex-md-nowrap p-0">
    <?= $this->Html->link(
        $this->Html->image(Configure::read('navbar.brand.img'), [
            'class' => 'brand-image',
        ]),
        $this->Url->build('/', ['fullBase' => true]),
        [
            'escape' => false,
            'class' => 'navbar-brand col-md-2'
        ]
    ); ?>
    <button class="navbar-toggler m-lg-0 m-sm-3 my-md-0 my-1 mx-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse m-sm-3 m-lg-0 mx-3" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if (!empty($menuTree)) : ?>
                <?php foreach ($menuTree as $menu) : ?>
                    <?php
                    if ($menu->admin_menu && !$isAdmin) {
                        continue;
                    } ?>
                    <?php if ($menu->hasValue('children')) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $menu->name; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php foreach ($menu->children as $child) : ?>
                                    <?php
                                    // has valid external URL
                                    $options = [
                                        'class' => 'dropdown-item',
                                    ];

                                    if ($child->hasValue('title')) {
                                        $options['title'] = $child->title;
                                    }

                                    if ($child->hasValue('url')) {
                                        $url = $child->url;
                                    } else {
                                        list($controller, $action) = explode('::', $child->bs_url);
                                        $url = [
                                            'controller' => $controller,
                                            'action' => $action,
                                        ];
                                        if ($child->hasValue('extra_args')) {
                                            $extraArgs = $child->extra_args;
                                            array_push($url, $extraArgs);
                                        }
                                    } ?>

                                    <?= $child->divider ? '<div class="dropdown-divider"></div>' : ''; ?>
                                    <?= $this->Html->link($child->name, $url, $options); ?>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <?php list($controller, $action) = explode('::', $menu->bs_url);
                            $url = [
                                'controller' => $controller,
                                'action' => $action,
                            ]; ?>
                            <?php echo $this->Html->link($menu->name, $url, ['class' => 'nav-link']); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-4">
            <?php if (isset($user)) : ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $this->Html->icon('user'); ?> <?= h($user->get('full_name')); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                  
                              <div class="col">
                                  <dl class="mt-3">
                                      <dt>
                                          <?= __('Login Email'); ?>
                                      </dt>
                                      <dd><?= h($user->get('username')); ?></dd>
                                  </dl>
                                  <dl>
                                      <dt>
                                      <?= __('Full Name'); ?>
                                      </dt>
                                      <dd><?= h($user->get('full_name')); ?></dd>
                                  </dl>
                                  <dl>
                                      <dt>    
                                          <?= __('Role'); ?>
                                      </dt>
                                      <dd><?= h(Inflector::humanize($user->get('role'))); ?></dd>
                                  </dl>

                                  <dl>
                                     
                                      <dd>   <?php echo  $this->Html->link(
                        __('Sign out') . ' ' . $this->Html->icon('sign-out-alt'),
                        ['controller' => 'users', 'action' => 'logout'],
                        [
                            'title' => 'Logout',
                            'escape' => false, 'class' => '',
                        ]
                    ); ?></dd>
                                  </dl>

                               
                              </div>
                

                    </div>
                </li>
              

            <?php endif; ?>

            <li class="nav-item"><?=
                                        $this->Html->link(
                                            'Help ' . $this->Html->icon('question-circle'),
                                            ['controller' => 'Pages', 'action' => 'display', 'help'],
                                            [
                                                'class' => 'nav-link',
                                                'escape' => false,
                                            ]
                                        ); ?></li>
        </ul>
    </div>
</nav>
