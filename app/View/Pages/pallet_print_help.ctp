<div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="col-lg-12 col-md-12 col-md-12 well">
                        <h1> Instructions for Pallet Label Print </h1>
                        <ol>
                            <li>
                                Select the Item Code
                            </li>
                            <li>
                                Select the Production Line
                            </li>
                            <li>
                                If printing a part pallet. Please select the Part Pallet check box and specify a quantity in cartons.
                            </li>
                            <li>
                                Select the correct batch number
                            </li>
                            <li>
                                Click the Submit Button
                            </li>
                            <li>
                                Press the Print button to confirm the print or No to cancel
                            </li>
                        </ol>
						<p><?= $this->Html->link('Back to pallet print', [
							'controller' => 'Labels',
							'action' => 'pallet_print'
						], [
							'class' => 'btn btn-primary'
						]); ?></p>
                    </div>
                </div>
            </div> <!-- end col-lg-12 -->
        </div>
