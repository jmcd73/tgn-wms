UPDATE printers SET printers.set_as_default_on_these_actions = 'PalletsController::reprint
PrintLabelsController::printCartonLabels
PrintLabelsController::cartonPrint
PrintLabelsController::crossdockLabels
PrintLabelsController::shippingLabels
PrintLabelsController::shippingLabelsGeneric
PrintLabelsController::keepRefrigerated
PrintLabelsController::glabelSampleLabels
PrintLabelsController::bigNumber
PrintLabelsController::customPrint
PrintLabelsController::sampleLabels' WHERE id = 1;

-- INSERT INTO printers ( `active`, `name`, `options`, `queue_name`)
-- VALUES ( 1, 'PDF-mailto Printer', '', 'PDF-mailto')