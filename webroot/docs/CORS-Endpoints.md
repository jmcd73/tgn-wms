# Actions that send CORS headers

Several actions have been modified to allow CORS requests this is so I can use Create React App to develop from localhost:3000 and successfully call the CakePHP endpoints


```php
$origin = $this->request->header('Origin');
$allowedOrigins = Configure::read('ALLOWED_ORIGINS');
if (in_array($origin, $allowedOrigins)) {
    $this->response->header('Access-Control-Allow-Origin', $origin);
}
```

|  Controllers &nbsp; &nbsp;  | Action            | Usage |
| :--------- | ----------------- | ----- |
| Items      | product_list      | Not sure if still in use but some of the remote systems queried for a product list in the past
| Labels     | multiEdit         | In use with the pickStock react app      |
| Labels     | edit              |       |
| Shipment   | destinationLookup &nbsp; &nbsp; |       |
| Shipment   | openShipments     |       |
| Shipment   | view              |       |
| Shipment   | add               |       |
| Shipment   | edit              |       |
