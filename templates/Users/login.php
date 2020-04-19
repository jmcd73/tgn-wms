<?php
use Cake\Core\Configure;

$image = Configure::read('login.image');
$this->append('css', $this->Html->css('signin')); ?>
<div class="container">
    <div class="row">
        <div class="col mt-3">
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="text-center">
                <?= $this->Form->create(null, ['class' => 'form-signin']) ?>
                <?= $this->Html->image($image, ['class' => 'rounded mb-4', 'alt' => 'Logo', ]); ?>
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                <label for="inputEmail" class="sr-only">Email address</label>
                <?php $myTemplates = [
                    'inputContainer' => '{{content}}',
                ];
                $this->Form->setTemplates($myTemplates); ?>

                <?php $usernameOptions = [
                    'label' => ['class' => 'sr-only'],
                    'type' => 'email',
                    'placeholder' => 'Email address',
                    'autofocus' => '',
                    'autocomplete' => 'username',
                ];

                if (!empty($username)) {
                    $usernameOptions['value'] = $username;
                } ?>

                <?= $this->Form->control('username', $usernameOptions) ?>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'type' => 'password',
                    'placeholder' => 'Password',
                    'required' => true,
                    'autocomplete' => 'current-password',
                ]) ?>
                <?php /*  $this->Form->control('remember-me', [
                    'type' => 'checkbox',
                    'checked' => $rememberMe,
                ]);  */?>

                <?= $this->Form->button('Sign in', [
                    'class' => 'btn btn-lg btn-primary btn-block mt-4',
                    'type' => 'submit', ]); ?>
                <?= $this->Form->end() ?>

            </div>
        </div>
    </div>
</div>