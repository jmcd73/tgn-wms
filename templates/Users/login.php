<?php
use Cake\Core\Configure;

$image = Configure::read('login.image');
$this->append('css', $this->Html->css('signin')); ?>
<div class="container">
    <div class="row">
        <div class="mt-3 offset-lg-4 col-4">
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

                <?php
        $myTemplates = [
            'inputContainer' => '{{content}}',
        ];
        $this->Form->setTemplates($myTemplates);

        ?>

                <?= $this->Form->control('email', [
                    'label' => ['class' => 'sr-only'],
                    'type' => 'email',
                    'placeholder' => 'Email address',
                    'autofocus' => '',
                ]) ?>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'type' => 'password',
                    'placeholder' => 'Password',
                    'required' => true,
                ]) ?>
                <?= $this->Form->control('remember-me', [
                    'type' => 'checkbox',
                ]); ?>

                <?= $this->Form->button('Sign in', [
                    'class' => 'btn btn-lg btn-primary btn-block',
                    'type' => 'submit', ]); ?>
                <?= $this->Form->end() ?>

            </div>
        </div>
    </div>
</div>