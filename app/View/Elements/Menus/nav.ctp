<?php

    if (empty($menu_tree)) {
        $menu_tree = $this->requestAction('/menus/build_menu');
    }

    $this->Nav->create([
        'static' => false, // only useful if fixed = false
         'fixed' => 'top', // 'top'
         'responsive' => true,
        'inverse' => Configure::read('navbarInverse')
    ]);

    $brandImage = Configure::read('navbar.brand.img');
    $brandAlt = Configure::read('navbar.brand.alt');
    $brandTitle = Configure::read('navbar.brand.title');

    $this->Nav->brand(
        $this->Html->image($brandImage, ['alt' => $brandAlt, 'style' => 'height: 20px;']), '/', false, [
            'title' => $brandTitle,
            'escape' => false
        ]);
?>



<?php foreach ($menu_tree as $menu): ?>

	<?php
        $isAdminMenu = $menu['Menu']['admin_menu'];
        $isAdminUser = (
            isset($user['role']) && $user['role'] === 'admin'
        ) || (
            isset($user['User']['role']) && $user['User']['role'] === 'admin'
        );
    ?>
<?php if ($isAdminMenu && !$isAdminUser) {
        continue; // i.e skip to next loop
} ?>
<?php if (!$menu['Menu']['active']) {
        continue;
} ?>

<?php if(strpos($menu['Menu']['url'], '://') !== false): ?>
<?php $this->Nav->link($menu['Menu']['name'], $menu['Menu']['url']); ?>
<?php else: ?>

<?php $this->Nav->beginMenu($menu['Menu']['name']); ?>

    <?php if (!empty($menu['children'])): ?>
<?php foreach ($menu['children'] as $child_menu): ?>
<?php if (!$child_menu['Menu']['active']) {
        continue;
} ?>
            <?php if ($child_menu['Menu']['divider']): ?>
                <?php $this->Nav->divider(); ?>
            <?php endif; ?>
            <?php if ($child_menu['Menu']['header']): ?>
        <?php

                $this->Nav->text($child_menu['Menu']['name'], [
        'wrap' => 'li',
        'class' => 'dropdown-header']);
?>
<?php endif; ?>
<?php if (!$child_menu['Menu']['divider'] && !$child_menu['Menu']['header']): ?>
<?php

    if (strpos($child_menu['Menu']['bs_url'], '::') !== false) {

        $array = explode('::', $child_menu['Menu']['bs_url']);

        $url = [
            'controller' => $array[0],
            'action' => $array[1]
        ];

        if (!empty($child_menu['Menu']['extra_args'])) {
            $split_strings = preg_split('/[\ \n\,\;]+/', $child_menu['Menu']['extra_args']);
            $url = array_merge($url, $split_strings);
        }
        $options = [
            'title' => $child_menu['Menu']['title']
        ];
        $this->Nav->link($child_menu['Menu']['name'], $url, $options);
    } elseif (strpos($child_menu['Menu']['url'], '://') !== false) {
        $url = $child_menu['Menu']['url'];
        $this->Nav->link($child_menu['Menu']['name'], $url, $options);
    }
?>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php $this->Nav->endMenu(); ?>
<?php endif; ?>
<?php endforeach; ?>

<?php if (isset($user)) {

        if (isset($user['User'])) {
            $user = $user['User'];
        }
        $username = empty($user['full_name']) ?  $user['username'] : $user['full_name'];
        $this->Nav->link(
            $username . '&nbsp;&nbsp;' .
            $this->Html->tag('i', '', ['aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-log-out'])
            , [
                'controller' => 'users',
                'action' => 'logout'
            ], [
                'pull' => 'right', 'title' => 'Click here to logout',
                'escape' => false]
        );
    } else {

        $this->Nav->link(
            $this->Html->tag('i', '', ['aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-log-in']), [
                'controller' => 'users',
                'action' => 'login'
            ], ['escape' => false, 'pull' => 'right', 'title' => 'Click here to login']
        );
    }
    ;
?>

<?php

    $this->Nav->link(
        $this->Html->tag('i', '', ['aria-hidden' => 'true', 'class' => 'glyphicon glyphicon-question-sign']), [
            'controller' => 'pages',
            'action' => 'display',
            'help'], [
            'class' => 'navbar-right',
            'title' => 'Help &amp; About',
            'pull' => 'right',
            'escape' => false
        ]);
?>

<?=$this->Nav->end(true); ?>
