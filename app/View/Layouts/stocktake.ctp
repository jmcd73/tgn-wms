<!DOCTYPE html>
<html>
    <head>
<?= $this->Html->charset(); ?>
<?php 		echo $this->Html->meta('icon');
              // echo $this->Html->css(array('stocktake/stocktake'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
?>
    </head>
    <body>
<?= $this->Session->flash(); ?>
	<?= $this->fetch('content'); ?>
        <?= $this->fetch('script_bottom'); ?>
    </body>
</html>
