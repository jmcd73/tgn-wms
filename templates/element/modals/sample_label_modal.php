<div class="modal fade" id="samplePrintModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Print Labels</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p style="font-size: 1.5em;">Do you want to print <strong id="qty"></strong> label<span
                        id="isplural"></span> to the <strong id="printer"></strong> printer?</p>

                <div class="alert alert-warning"><span class="glyphicon glyphicon-alert"></span> Make sure you have
                    loaded 100x50 labels in the printer first</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                <button type="button" id="btn-print" class="btn btn-primary btn-lg">Print</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->