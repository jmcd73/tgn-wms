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
                            $url = ['controller' => $controller,
                                'action' => $action,
                            ];
                            if ($child->hasValue('extra_args')) {
                                $extraArgs = $child->extra_args;
                                array_push($url, $extraArgs);
                            }
                        }?>

                    <?= $child->divider ? '<div class="dropdown-divider"></div>' : ''; ?>
                    <?= $this->Html->link($child->name, $url, $options); ?>


                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 mr-4">
            <?php if ($user): ?>
            <li class="nav-item">
                <?php echo  $this->Html->link(
                            $user->get('full_name') . ' ' . $this->Html->icon('sign-out-alt'),
                            ['controller' => 'users', 'action' => 'logout'],
                            ['title' => 'Logout',
                                'escape' => false, 'class' => 'nav-link', ]
                        ) ;?>
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