<?php $this->Html->script('dayofyear', ['block' => 'from_view']);?>

<div class="container">
    <div class="row">

        <div class="col-lg-6">
            <h3>Day of Year Number Calculator</h3>
    <p>A day of year number starts at Jan 1st as day 001, Jan 2nd as day 002 ... etc, and ends December 31 as day 366</p>
    <p>This page calculates the day of the year number</p>
    <p>The day of year is used in batch numbers</p>
        </div>
        <div class="col-lg-6">
            <div class="well">
        <h3>Day of Year No. for Todays Date: <?=$this->Time->format(time(), '%d/%m/%Y');?></h3>
        <div id="ord_today" style="font-size: 72pt;"></div>
    </div>
        </div>

    </div>


    <div class="well">
        <h3>Calculate Day of Year No. for Specific Date</h3>
        <form name="ordinal" class="form-horizontal">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="col-sm-7 control-label">ENTER DATE:</label>
                    <div class="col-sm-5">
                        <input  class="form-control" type="text" name="day" size="2" maxlength=2>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="col-sm-12">
                        <select name="month" class="form-control">
                            <option value=0 selected>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>June</option>
                            <option value=6>July</option>
                            <option value=7>Aug</option>
                            <option value=8>Sept</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <div class="col-sm-12">
                        <?php echo $this->Form->year(
                                'name', 2012, // min year
                                date('Y') + 3, // max year
                                [
                                    'empty' => false,
                                    'default' => date('Y'),

                                    'class' => "form-control"
                            ]); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="col-sm-7 control-label" for="julian">ORDINAL DATE:</label>
                    <div class="col-sm-5">
                        <input type=text name="julian" size=3 maxlength=3 class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="pbutton">

                    <?php echo $this->Html->link(
                            "Get Day of Year No. for specific Date",
                            "javascript:doUpdate();",
                            [
                                'class' => 'btn btn-primary btn-lg'
                        ]); ?>
                </div>
        </form>
    </div>
</div>
</div>
