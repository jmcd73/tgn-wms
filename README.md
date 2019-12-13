# Toggen WMS

This is a project that I have been working on for a number of years.

It was orginally coded for, and is still used in a production food manufacturing environment

It uses open source components to provide simple pallet and label printing and product production and dispatch workflow

This github release has largely been rewritten and improved

## Features

- Product database for item data (GTIN13/14 barcode, weights, qauntity)
- Locations, Inventory Status, Pack sizes
- Very simple warehousing
  - Can be configured so pallets 'move' directly to a default location or use simple put-away
  - Minimum days life calculation so old product isn't sent out unless QA unholds it
  - Dispatch PDF Pick slips
  - Location usage / free space screen
  - Ability to have multiple best-before dates on a pallet <sup>\*new Dec 2019</sup>
- Inventory statuses WAIT HOLD etc for QA
- Bulk inventory status update screen
- Settings table to manage Company Name, GS1 company prefix
- Configure multiple product types, production lines & printers
- Numbering and coding
  - Batch numbers based on ordinal day of year YDDDBB (e.g Last digit of year eg 9 day 105 batch 22)
- Printing
  - gLabels-batch printing
  - GS1 Compliant SSCC labels to CAB Printers
  - Zebra and CAB Printer Command Language Printing
  - Endpoints to serve Product Lists as JSON or XML for external systems

## Limitations

- Currently only one item type per pallet

## Open source technologies

### Docker development environment

- PHP7.3
- Apache
- MySQL or MariaDB
- Ubuntu 18.04 LTS
- CUPS 2.2.x
- CUPS-PDF
- Supervisord

### Application packages

- [CakePHP 2.10.9](https://cakephp.org/)
- [TCPDF](https://tcpdf.org/)
- Bootstrap v3.4.1
- [CakePHP 2.x Helpers for Bootstrap 3](https://github.com/Holt59/cakephp-bootstrap3-helpers)
- ReactJS Embedded in CakePHP Views
  - Shipment document add/edit screen
  - Warehouse pallet pick screen
- GLabels Barcode and Label Printing

## Installation

See [docs/INSTALL.md](docs/INSTALL.md)

## Configuration

See [docs/SETUP.md](docs/SETUP.md)
