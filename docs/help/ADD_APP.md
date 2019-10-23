## Shipment Add App

### About
This is a React JS single page application embedded in the CakePHP view

It uses CakePHP as an API backend from which it requests a list of available-to-ship pallets

#### Destination field has type-ahead
When entering a destination as you type it queries the shipments table for a list of previously used addresses that match what you have entered and returns suggestions (e.g. tas returns Tasmania)

### Validation

The Shipment name must be unique

Pallets that are too old (Low dated stock) will show in the list but will not be able to be selected. To ship these pallets you need to edit the pallet and select "Ship low dated"

**Note:** You cannot edit a shipment after it is marked `shipped`

