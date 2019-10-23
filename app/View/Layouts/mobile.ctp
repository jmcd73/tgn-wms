<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title><?= $this->fetch('title'); ?></title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
        <meta http-equiv="cleartype" content="on">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" sizes="196x196" href="img/touch/touch-icon-196x196.png">
        <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">

        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <meta name="msapplication-TileImage" content="img/touch/apple-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#222222">

        <?= $this->Html->charset(); ?>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(['normalize.css', 'main.css']);
        echo $this->Html->script(['vendor/modernizr-2.7.1.min']);
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <?= $this->Session->flash(); ?>
        <?= $this->fetch('content'); ?>
        <?php // echo $this->Html->script(array('vendor/jquery-2.1.0.min.js', 'helper.js', 'main.js')) ?>
        <?= $this->fetch('script_bottom'); ?>
    </body>
</html>
