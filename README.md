# Toggen WMS
This is a project that I have been working on for a number of years it uses open source components to provide a simple pallet production and dispatch workflow.

Presently it assumes that each pallet contains the same products but can be extended to handle multi-product pallets

## Features
* Product database for item data (GTIN13/14 barcode, weights, qauntity)
* Locations, Inventory Status, Pack sizes
* Very simple warehousing
    * Can be configured so pallets 'move' directly to a default location or use simple put-away
    * Minumum days life calculation so old product isn't sent out unless QA unholds it
    * Dispatch shipment document creation
    * Location usage screen
* Inventory statuses WAIT HOLD etc for QA
* Settings table to manage Company Name, GS1 company prefix
* Configure multiple product types, production lines  & printers
* PDF Pick slips
* Numbering and coding
    * Batch numbers based on ordinal day of year YDDDBB (e.g Last digit of year eg 9 day 105 batch 22)
* Printing
    * gLabels-batch printing
    * GS1 Compliant SSCC labels to CAB Printers
    * Zebra and CAB Printer Command Language Printing
    * Endpoints to serve Product Lists as JSON or XML for external systems

## Open source technologies
* CakePHP 2.x
* MySQL or MariaDB
* Use with NGinx or Apache
* TCPDF
* CUPS 2.2.x
* Bootstrap 3.4.x
* CakePHP 2.x Helpers for Bootstrap 3
    * https://github.com/Holt59/cakephp-bootstrap3-helpers
* ReactJS Embedded in CakePHP Views
    * Shipment document add/edit screen
    * Warehouse pallet pick screen
* GLabels Barcode and Label Printing

## Installation
    See docs/INSTALL.md



