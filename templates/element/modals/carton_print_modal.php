<div class="modal fade" id="cartonLabelPrintModal" tabindex="-1" role="dialog"
    aria-labelledby="cartonLabelPrintModalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cartonLabelPrintModalTitle">Label Print</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <p id="pallet-count"></p>
                <div class="alert alert-warning tpad" role="alert">
                    <?= $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-warning-sign']); ?>
                    <strong>Warning!</strong> Remember to load 100x50 labels into the printer
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button id="modal-print-button" type="button" class="btn btn-lg btn-primary">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>