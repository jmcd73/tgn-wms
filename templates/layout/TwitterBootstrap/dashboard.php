<?php

/**
 * @var \Cake\View\View $this
 */

use Cake\Core\Configure;

$this->Html->css('BootstrapUI.dashboard', ['block' => true]);
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->getParam('controller'), $this->request->getParam('action')]) . '" ');
 ?>
<?php

$this->start('tb_body_start');
?>

<body <?= $this->fetch('tb_body_attrs') ?>>
    <?= $this->element('nav/navbar'); ?>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 col-sm-12 d-md-block bg-light">
              
                <div class="sidebar-sticky h-auto mb-2">
                    <?php if( !empty($helpPage)): ?>
                        <ul class="nav flex-column">
                            <li><?= $this->element('help/page_help'); ?></li>
                        </ul>
                    <?php endif; ?>
                    <?= $this->fetch('tb_sidebar') ?>
                </div>
            </nav>
            <main role="main" class="col-md-9 col-sm-12 ml-sm-auto col-lg-10 pt-3 px-4">
                <?php
                /**
                 * Default `flash` block.
                 */
                if (!$this->fetch('tb_flash')) {
                    $this->start('tb_flash');
                    if (isset($this->Flash)) {
                        echo $this->Flash->render();
                    }
                    $this->end();
                }
                $this->end();

                $this->start('tb_body_end');
                echo '</body>';
                $this->end();

                $this->append('content', '</main></div></div>');
                echo $this->fetch('content');
