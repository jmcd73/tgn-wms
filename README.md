# Toggen WMS

## A simple web app to print pallet labels and ship pallets
Toggen WMS uses open source components to provide simple pallet and label printing, Quality Assurance functions and dispatch workflow

## Overview
This is a project that I have been working on for a number of years. Originally written in CakePHP 2.x it has now been updated to CakePHP 4+ making use of many of the new features of this version including:
- Modelless Forms
- HTTP Options Middleware
- The new Authentication and Authorization plugins

## Features

- Product database for item data (GTIN13/14 barcode, weights, qauntity) that can be used on labels
- Locations, Inventory Status, Pack sizes
- Very simple warehousing
  - Can be configured so pallets 'moved' directly to a default location or use simple put-away to a selectable location
  - Minimum days life calculation so old product isn't sent out unless QA unholds it
  - Dispatch PDF shipment picking slip documents and ability to mark shipments as shipped
  - Location usage / free space screen
  - Part and mixed date pallets (currently only one item code per pallet)
- Inventory statuses WAIT HOLD etc for QA and screen to apply bulk status changes
- Settings table to manage Company Name, GS1 company prefix
- Configure multiple product types, production lines & printers
- Numbering and coding
  - Batch numbers based on ordinal day of year YDDDBB (e.g Last digit of year 2020 eg 0 day of year 105 batch 22)
- Printing
  - glabels-3-batch printing (Uses latest stable glabels-3.4.1)
  - GS1 Compliant SSCC labels to CAB Printers
  - Zebra and CAB Printer Command Language Printing
- Download or email labels as PDF (Cake Mailer)
- Filter and export stock on hand to CSV download
- Endpoints to serve Product Lists as JSON or XML for external systems

## Open source technologies

### Docker development environment

- PHP7.4+
- Apache 2.4+
- MySQL or MariaDB
- CakePHP 4.x Framework
- Ubuntu 20.04 LTS
- CUPS 2.2.x
- CUPS-PDF
- Supervisord
- Glabels 3.4.1
- TCPDF

### Application packages

- [CakePHP 4](https://cakephp.org/)
- [TCPDF](https://tcpdf.org/)
- Bootstrap v4
- [FriendsOfCake/bootstrap-ui](https://github.com/FriendsOfCake/bootstrap-ui/tree/cake-4-bs-4)
- [CakeDC/auth](https://github.com/CakeDC/auth)
- ReactJS Embedded in CakePHP Views
  - Shipment document add/edit screen
  - Warehouse pallet pick screen
- GLabels Barcode and Label Printing

## Installation

See [docs/INSTALL.md](webroot/docs/INSTALL.md)

## Configuration

See [docs/SETUP.md](webroot/docs/SETUP.md)
