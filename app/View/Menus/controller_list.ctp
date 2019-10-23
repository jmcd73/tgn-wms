<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?= $this->Form->create(null, ['horizontal' => false]); ?>
<?= $this->Form->input("controllerList", ['options' => $controllerList]); ?>
<?= $this->Form->submit(); ?>
<?= $this->Form->end(); ?>

