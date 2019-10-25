# Printing

## Label Samples
A number of sample print templates are provided by default

Add new print templates under `Admin => Print Templates`

See [../app/webroot/files/templates](../app/webroot/files/templates) for label sample images

## Application Print Controller Action List

These are the Controller Action combinations that have print screens attached to them

| Controller | Action | Description |
|------------|--------|-------------|
| LabelsController | pallet_print | CAB Printer Language Pallet Label Print |
| LabelsController | reprint | CAB Reprint Pallet Labels |
| PrintLabelsController | carton_print | CAB 100x50 Carton Labels |
| PrintLabelsController | crossdock_labels | gLabels 150x200 Labels |
| PrintLabelsController | shipping_labels | gLabels 150x200 Labels |
| PrintLabelsController | shipping_labels_generic | gLabels 150x200 |
| PrintLabelsController | keep_refrigerated | gLabels 100x50 Fixed Text Keep Refrigerated |
| PrintLabelsController | glabel_sample_labels | gLabels 100x50 Product Sample Labels |
| PrintLabelsController | big_number | Zebra Printer Language 100x200 Labels |
| PrintLabelsController | custom_print | gLabels 100x50 assorted label prints |
| PrintLabelsController | sample_labels | gLabels 100x50 company logo with product details |