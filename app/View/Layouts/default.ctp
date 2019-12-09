<!DOCTYPE html>
<html lang="en" class="notranslate">

<head>
    <meta http-equiv="content-language" content="en" />
    <meta name="google" content="notranslate" />
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $companyName ?>:
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php echo $this->Html->meta('icon', '/img/favicon.png');
        echo $this->Html->css(
            [
                'bootstrap.min',
                'spacing.min',
                'droid_sans_font',
                'all.min',
                'custom'
            ]
        );
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->Html->script(
            [
                'fontawesome.min',
                'solid.min'
            ],
            [
                'defer'
            ]
        ); // font awesome

        $this->Html->script(
            [
                'jquery.min',
                'bootstrap.min'
            ],
            [
                'block' => 'script_bottom'
            ]
        )
    ?>
    <?php echo $this->Html->meta(
        [
            'http-equiv' => 'X-UA-Compatible',
            'content' => "IE=edge"
        ]
); ?>
    <?php echo $this->Html->meta([
        'name' => 'viewport',
        'content' => "width=device-width, initial-scale=1"
    ]);
?>
</head>

<body class="<?php echo $this->request->controller . ' ' . $this->request->action; ?>">
    <?php echo $this->Element('Menus/nav'); ?>
    <div class="container">
        <!-- Flash Container -->
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Flash->render('auth'); ?>

        <?php if (!empty($helpPage)): ?>
        <?php echo $this->Element('Help/page_help'); ?>
        <?php endif; ?>
    </div>

    <?php echo $this->fetch('content'); ?>


    <?php if (!isset($disable_footer)) {
            echo $this->element('default_footer');
        }
    ; ?>

    <?php echo $this->fetch('script_bottom'); ?>
    <?php echo $this->fetch('from_view'); ?>
</body>

</html>