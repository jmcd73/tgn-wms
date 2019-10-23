<div class="container">
<?= $this->Flash->render('auth'); ?>


<div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 tpad">
    <div class="well clearfix">
        <h3>
            <?= __('Please sign in'); ?>
        </h3>
        <?= $this->Form->create(); ?>
        <?=
        $this->Form->input('username', [
            'label' => false,
            'placeholder' => 'Username']);
        echo $this->Form->input('password', ['label' => false,
            'placeholder' => 'Password']);
        ?>



        <?= $this->Form->end(
		[ 'label' => 'Sign in',
		'bootstrap-type' => 'primary',
		]
		); ?>
    </div>
</div>
</div>
