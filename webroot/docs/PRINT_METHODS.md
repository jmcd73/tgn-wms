# Print Methods

A number of print methods are located in Controllers/PrintLogController.php

| Print Method          | Method Type | 
| --------------------- | ----------- |
| crossdockLabels       | Glabels     |
| printCartonLabels     | Glabels     |
| shippingLabels        | Glabels     |
| shippingLabelsGeneric | Glabels     |
| keepRefrigerated      | Glabels     |
| glabelSampleLabels    | Glabels     |
| bigNumber             | Zebra / Raw |
| customPrint           | Glabel      |
| sampleLabels          | Glabel      |


## Print Classes
The print methods takes form input and sends it to the relavent print classes for printing

Print classes are configured in config/configuration.php

```php
    'PrintLabelClasses' => [
        // mappings for controller print actions to their classes
        // used by Lib/PrintLabels/LabelFactory.php
        'glabelSampleLabels' => '\App\Lib\PrintLabels\Glabel\GlabelSample',
        'customLabel' => '\App\Lib\PrintLabels\Glabel\CustomLabel',
        'shippingLabels' => '\App\Lib\PrintLabels\Glabel\ShippingLabel',
        'crossdockLabels' => '\App\Lib\PrintLabels\Glabel\CrossdockLabel',
        'shippingLabelsGeneric' => '\App\Lib\PrintLabels\Glabel\ShippingLabelGeneric',
        'bigNumber' => '\App\Lib\PrintLabels\Zebra\TextLabel',
        'printCartonLabels' => '\App\Lib\PrintLabels\CabLabel\CartonLabel',
        'sampleLabels' => '\App\Lib\PrintLabels\Glabel\SampleLabel',
        'ssccLabel' => '\App\Lib\PrintLabels\Glabel\SsccLabel',
        'cabSsccLabel' => '\App\Lib\PrintLabels\CabLabel\PalletPrint'
    ],
```


Required

For a print

Type
Glabels or Raw through Glabels or direct to printer

Print Content
Raw text to send to printer or formatted text for glabels in CSV formatt

Print command
To send to printer
Return success of failure

Other methods
Save to print_log
