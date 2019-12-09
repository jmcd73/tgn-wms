<div class="warehouse row">
    <?php if (!empty($aisles)): ?>

        <div class="col-md-2 col-sm-2 col-lg-2"><h5>Aisle</h5></div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <div class="jmits-aisle btn-group rack" data-toggle="buttons">
                <?php foreach ($aisles as $aisle): ?>
<?php $location = $aisle[0]['aisle_letter']; ?>
                    <label class="btn btn-lg btn-default jmits-aisle" for="Aisle<?php echo $location; ?>" >
                        <input type="radio" name="data[Pallet][aisle_letter]" id="Aisle<?php echo $location; ?>" value="<?php echo $location; ?>" ><?php echo $location; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>



    <?php endif; ?>

</div>

<div id="columns_levels" data-submit_url="<?php echo $this->request->base . '/' . $this->request->params['controller'] . '/columnsAndLevels'; ?>">
<?php echo $this->element('columns_levels') ?>
</div>

<div class="warehouse row">
    <div class="col-md-2 col-sm-2 col-lg-2"><h5>Overflow Location</h5></div>
    <div class="col-sm-10 col-md-10 col-lg-10">
        <div class="btn-group floor" role="group" data-toggle="buttons">
            <label  class="btn btn-lg btn-default" for="Floor1" >
                <input type="radio" name="data[Pallet][floor]" id="Floor1" value="Floor" >
                Floor</label>


        </div>
    </div>

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