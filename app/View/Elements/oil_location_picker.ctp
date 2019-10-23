<div class="col-lg-offset-2">
<?= $this->Form->input('location_id', [
    'options' => 
    $oil_locations,
    'type' => 'radio',
    'legend'=> false
]); ?>
    </div>
<div class="row">
    <span class="col-lg-10 col-md-10 col-sm-10 tpad col-md-offset-2 col-sm-offset-2 col-lg-offset-2">
        <?php
        echo $this->Form->submit('Put-away', [
            'class' => 'btn btn-primary btn-lg'
        ]);
        ?>
    </span>

</div>
