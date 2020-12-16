<?php
/**
 * @var \App\View\AppView                                               $this
 * @var \App\Model\Entity\User                                          $user
 * @var \App\Model\Entity\Carton[]|\Cake\Collection\CollectionInterface $cartons
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Cartons'), ['controller' => 'Cartons', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Carton'), ['controller' => 'Cartons', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="users form content">
    <?= $this->Form->create($newUser, ['autocomplete' => 'off']) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('active');
            echo $this->Form->control('username', [
                'autocomplete' => 'off',
            ]);
            echo $this->Form->control('password', [
                'autocomplete' => 'new-password',
            ]);
            echo $this->Form->control('role');
            echo $this->Form->control('full_name');
            echo $this->Form->control('token_auth_key');
            echo $this->Form->control('timezone', [
                'empty' => '(select)',
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
