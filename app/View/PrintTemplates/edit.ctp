<div class="container">
    <div class="col-lg-offset-3 col-lg-6">
        <?php echo $this->Form->create('PrintTemplate', [
            'type' => 'file',
        ]); ?>
        <fieldset>
            <legend><?php echo __('Edit Print Template'); ?></legend>
            <?= $this->Form->submit('Save Template', ['class' => 'btn btn-sm']); ?>
            <?php
    echo $this->Form->input('active');
    echo $this->Form->input('show_in_label_chooser');
        echo $this->Form->input('id');
        echo $this->Form->input('name');
        echo $this->Form->input('parent_id', [
            'empty' => '(select)',
        ]);
        echo $this->Form->input('description');
        echo $this->Form->input('controller_action', [
            'options' => $controllerList,
            'empty' => '(Please select an action)',
            'label' => 'Controller::Action',
        ]);
        echo $this->Form->input(
            'example_image',
            ['type' => 'file']
        );

        echo $this->Form->input(
            'file_template',
            ['type' => 'file']
        );
        echo $this->Form->input(
            'delete_file_template',
            ['type' => 'checkbox']
        );
        echo $this->Form->input(
            'text_template',
            ['type' => 'text', 'rows' => 10]
        );

        echo $this->Form->input(
            'replace_tokens',
            [
                'type' => 'text', 'rows' => 10,
                'label' => 'Replace Tokens<span class="secondary-text">This provides a map between the form fields and the template</span>', ]
        );

    ?>
        </fieldset>
        <?= $this->Form->submit('Save Template', [
            'bootstrap-type' => 'primary',
            'class' => 'btn btn-sm', ]); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <div class="actions">
        <h3><?php echo __('Actions'); ?></h3>
        <ul>
            <li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('PrintTemplate.id')], ['confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('PrintTemplate.id'))]); ?>
            </li>
            <li><?php echo $this->Html->link(__('List Print Templates'), ['action' => 'index']); ?></li>
            <li><?php echo $this->Html->link(__('List Items'), ['controller' => 'items', 'action' => 'index']); ?> </li>
            <li><?php echo $this->Html->link(__('New Item'), ['controller' => 'items', 'action' => 'add']); ?> </li>
        </ul>
    </div>
</div>