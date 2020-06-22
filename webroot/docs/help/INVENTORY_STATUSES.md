# About Inventory Statuses

Define Inventory statuses to control how products are treated

WAIT is a cooldown status to allow time to pass for QA checks and settling or solidification before shipment
HOLD is a status used to make sure product that is not fit for shipment cannot be shipped while QA processes decide whether it is OK or needs to be RE-TIPPED

RE-TIPPED product that has or is going to be RE-TIPPED

etc...

Each status can have view permissions applied so that it appears correctly or doesn't throughout the application

These perms are configured in app/Config/configuration.php

```php
 'StockViewPerms' => [
        [
            'value' => 1,
            'slug' => 'view_in_stock',
            'display' => 'Visible in view stock'
        ],
        [
            'value' => 2,
            'slug' => 'view_in_shipments',
            'display' => 'Visible when creating shipment'
        ],
        [
            'value' => 4,
            'slug' => 'view_in_lookup_table',
            'display' => 'Visble in Pallet Track (always select this)'],
        [
            'value' => 8,
            'slug' => 'view_in_remove_status',
            'display' => 'List this status in Edit QA Status screen'
        ]
    ]
```