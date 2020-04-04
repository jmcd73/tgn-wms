<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>
<?php $this->Html->script('dayofyear', ['block' => 'from_view']); ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h3>Batch number calculator</h3>
            <p>Batch numbers contain the ordinal day of the year. You can use this page to find the date a pallet was
                produced by </p>

            <p>Day of Year No. for Todays Date: <?php echo $this->Time->format(time(), 'dd/MM/Y'); ?></p>
            <div id="ord_today" style="font-size: 72pt;"></div>

        </div>

        <div class="col">
            <h3>Calculate Day of Year No. for Specific Date</h3>
            <form name="ordinal" class="form-horizontal">
                <div class="row">
                    <div class="col">
                        <?= $this->Form->control('date', [
                            'min' => 2012,
                            'type' => 'date',
                            'max' => date('Y') + 4,
                        ]); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col">
                        <?= $this->Form->control('julian', [
                            'type' => 'text',
                        ]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="pbutton">

                        <?php echo $this->Html->link(
                            'Get Day of Year No. for specific Date',
                            'javascript:doUpdate();',
                            [
                                'class' => 'btn btn-primary btn-lg',
                            ]
                        ); ?>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>