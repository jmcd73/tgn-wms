<?php
    /**
     * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
     * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     *
     * Licensed under The MIT License
     * For full copyright and license information, please see the LICENSE.txt
     * Redistributions of files must retain the above copyright notice.
     *
     * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
     * @link          http://cakephp.org CakePHP(tm) Project
     * @package       app.View.Layouts
     * @since         CakePHP(tm) v 0.10.0.1076
     * @license       http://www.opensource.org/licenses/mit-license.php MIT License
     */

?>
<!DOCTYPE html>
<html lang="en" class="notranslate">
    <head>
        <meta http-equiv="content-language" content="en" />
        <meta name="google" content="notranslate" />
        <?=$this->Html->charset();?>
        <title>
            <?=$companyName?>:
            <?=$this->fetch('title');?>
        </title>
        <?php
            echo $this->Html->meta('icon', '/img/favicon.png');
            echo $this->Html->css(
                [
                    'bootstrap.min',
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
        <?=$this->Html->meta(
    [
        'http-equiv' => 'X-UA-Compatible',
        'content' => "IE=edge"
    ]
);?>
        <?=$this->Html->meta([
    'name' => 'viewport',
    'content' => "width=device-width, initial-scale=1"
]);
?>
    </head>
    <body class="<?=$this->request->controller . ' ' . $this->request->action;?>">
        <?=$this->Element('Menus/nav');?>
        <div class="container">
			<!-- Flash Container -->
            <?=$this->Flash->render();?>
            <?=$this->Flash->render('auth');?>

            <?php if( !empty($helpPage) ): ?>
            <?=$this->Element('Help/page_help');?>
        <?php endif; ?>
        </div>

            <?=$this->fetch('content');?>


        <?php if (!isset($disable_footer)) {
                echo $this->element('default_footer');
            }; ?>

        <?=$this->fetch('script_bottom');?>
        <?=$this->fetch('from_view');?>
    </body>
</html>
