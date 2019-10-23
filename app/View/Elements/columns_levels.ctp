
    <div class="warehouse row">  
        <div class="col-md-2 col-sm-2 col-lg-2"><h5>Column</h5></div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <?php foreach ($columns as $chunk): ?>
                <div class="btn-group rack jmits-cols" role="group" data-toggle="buttons">
                    <?php foreach ($chunk as $column): ?>
                        <?php $location = $column[0]['col']; ?>
                        <label class="btn btn-lg btn-default" for="Column<?= $location; ?>">
                            <input type="radio" name="data[Label][col]" id="Column<?php
                            echo $location;
                            ?>" value="<?= $location; ?>"><?= ltrim($location, '0'); ?></label>
                        <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="warehouse row">
        <div class="col-md-2 col-sm-2 col-lg-2"><h5>Level</h5></div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <div class="btn-group rack"  role="group" data-toggle="buttons">
                <?php foreach ($levels as $level): ?>
                    <?php $location = $level[0]['level']; ?>
                    <label class="btn btn-lg btn-default" for="Level<?= $location; ?>">
                        <input type="radio" name="data[Label][level]" id="Level<?= $location; ?>" value="<?= $location; ?>" ><?= ltrim($location, '0'); ?></label>

                <?php endforeach; ?>
            </div>
        </div>
    </div>

