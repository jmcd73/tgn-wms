<?php
/**
 * @var \App\View\AppView      $this
 * @var \App\Model\Entity\User $viewUser
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $viewUser->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $viewUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $viewUser->id), 'class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Cartons'), ['controller' => 'Cartons', 'action' => 'index'], ['class' => 'nav-link']) ?>
</li>
<li><?= $this->Html->link(__('New Carton'), ['controller' => 'Cartons', 'action' => 'add'], ['class' => 'nav-link']) ?>
</li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="users view large-9 medium-8 columns content">
    <h3><?= h($viewUser->username) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Username') ?></th>
                <td><?= h($viewUser->username) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Password') ?></th>

                <td><?= h($viewUser->password) ?></td>

            </tr>

            <tr>
                <th scope="row"><?= __('Timezone') ?></th>
                <td><?= h($viewUser->timezone) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Token Auth Key') ?></th>
                <td><?= h($viewUser->token_auth_key) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Role') ?></th>
                <td><?= h($viewUser->role) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Full Name') ?></th>
                <td><?= h($viewUser->full_name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($viewUser->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($viewUser->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $viewUser->active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
</div>
