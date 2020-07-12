# Setup

## Getting Started

1. ### Start from a clean install

   1. Follow installation instructions in INSTALL.md

   1. Connect with your browser

      ```
      http://<yourWebServerHost>:{APACHE_PORT}
      ```

   1. Login as admin username and password see INSTALL.md

   1. (Optional) In `Admin => Users` change the `admin` user password or create a new user with a role of admin

   1. From this point you can start to define the data for your business. Start from the top as some data depends on order of entry

1. ### Inventory Status

   Define a number of Inventory Statuses and specify their visibility to the different screens

   For example:

   - **WAIT** - This status when configured with "Visible When Creating Shipment" _unchecked_ stops the product being allowed to be placed on a shipment. A WAIT status is useful if a cooldown process is required or so QA can check the product and then manually remove the status before allowing shipment
   - **HOLD** - Product is under QA hold. Perhaps when doing the initial QA check when it was under the wait status and further work needs to be done then you can put it under hold
   - **REWORK**, **RETIP**, **WASTE** - Any number of statuses can be created to mark product as being thrown out or not able to be shipped

   The different options that effect visibility are

   - Visible In View Stock - visible when in `Warehouse => View Stock` screen
   - Visible When Creating Shipment - visible when in `Dispatch => List => Add {Product Type}`
   - Visble In Pallet Track (always Select This) - This is where everything should be seen, including re-tipped and long shipped products
   - List This Status In Edit QA Status Screen - Show this status in `Warehouse => Edit QA Status` screen

1) ### Product Types

   For this setup we are going to imagine a business that has 2 product types

   1. Ambient products - Stored at room temperature
      - Stored in a warehouse with no fixed locations. Staff manage stock with no strict location assigment
   1. Chilled products - 5° coolroom
      - Products each go into a location which each location equating to a row, column, level

   Product Types have a number of attributes

   - **serial number and format** - This assigns an incrementing by one reference number to every pallet produced for internal tracking purposes. Every pallet has an SSCC number with a barcode that also individually identifies the pallet then this number may or may not be of use. The benefit is you can define a 8 digit number or smaller which is easier to read off pallet labels for picking purposes. The format for example 'A%07d' is what you would put in `sprintf('A%07d', 11)` = A0000011
     - **_Important_** The labels pl_ref field has a unique constraint so each products serial number needs to be different. e.g. specify a prefix to separate them for exampl (Ambient = A, Chilled = C)
     - **_Important_** In the settings table `plRefMaxLength` is set to 8 so you format must be 8 characters in total or you need to change the `plRefMaxLength` setting and then perhaps edit pallet label templates to allow for longer / shorter values
   - **Inventory Status** - A default Inventory status. This is applied on pallet label print. So if you want all of this product to enter a WAIT status when the label is printed then set this here.
   - **Default Save Location** - During setup leave this blank. The default save location is used to configure a location that will be applied during pallet label print. You set this if you want all printed pallet labels to go immediately to a default location. If left unset pallets produced will appear in the `Warehouse => Put-Away` screen
   - **Code Regex and Code Regex Descripton** - These settings provide a way of enforcing consistent product coding. For example if you want all Ambient product types to have a prefix of A and a 5 digit product number such as A20201, A30202 or A30401 then you set the Code Regex to `/^A\d{5}$/` and the Code Regex Description to remind the user of this `The item code for this product type must start with an A and be 5 digits long`

1) ### Warehouse Locations

   The warehouse storage locations for the above product types are

   1. Ambient - All products go to one location there is no storage locations
   2. Chilled - a coolroom containing pallet racks each location can store pallets two deep

   It is good to create a logical warehouse numbering system for example for a pallet racked wareshouse locations may have a number of attributes:

   - Prefix - if you have multiple warehouses then assign an identifier e.g. C for Chilled, A for Ambient
   - Aisle - A, B, C, D, E...
   - Column - Starting at one end number the columns. 1,2,3
   - Level - Start at the lowest level as number 1 and up

   #### Example Locations

   A CSV file can be generated to import locations to the locations table using `bin/generateLocations.php`

   Edit each section in the `$locationConfig` variable to provide a format and default values for the location names. This example creates locations of the format C-A0101 to C-D0504

   ```php
   [
       'location' => [
           'setup' => [
               'prefix' => ['C-'],
               'row' => ['A', 'B', 'C', 'D'],
               'column' => [1, 2, 3, 4, 5],
               'level' => [1, 2, 3, 4]
           ]
       ],
       'pallet_capacity' => 2,
       'is_hidden' => (int)false,
       'description' => 'Coolroom location',
       'created' => date("Y-m-d H:i:s"),
       'modified' => date("Y-m-d H:i:s"),
       'product_type_id' => 2,
       'overflow' => (int)false
   ],
   ```

   The CSV that is created can be imported using MySQL Workbench, PHPAdmin or mysql command line (you may need to disable `secure_file_priv` if using command line)

   ```csv
   location,pallet_capacity,is_hidden,description,created,modified,product_type_id,overflow
   A-DEFAULT,999999,0,"Ambient Storage","2019-10-22 22:14:54","2019-10-22 22:14:54",1,0
   C-A0101,2,0,"Coolroom location","2019-10-22 22:14:54","2019-10-22 22:14:54",2,0
   C-A0102,2,0,"Coolroom location","2019-10-22 22:14:54","2019-10-22 22:14:54",2,0
   C-A0103,2,0,"Coolroom location","2019-10-22 22:14:54","2019-10-22 22:14:54",2,0
   C-D0503,2,0,"Coolroom location","2019-10-22 22:14:54","2019-10-22 22:14:54",2,0
   C-D0504,2,0,"Coolroom location","2019-10-22 22:14:54","2019-10-22 22:14:54",2,0
   C-Floor,2,0,"Coolroom overflow","2019-10-22 22:14:54","2019-10-22 22:14:54",1,1
   ```

1) ### Shifts

   For each product type you need to configure shifts so the shift report can show how many pallets are produced during the shift.
   Each shift is linked to a Product Type and is configured with a start time, an end time and total shift minutes
   For example if you have 2 product types of "Ambient and Chilled" and Ambient is running 3 shifts of 8 hours and Chilled is running 2 12 hour shifts you would define the following shifts

   | Name                    | Start/End Times | Shift Minutes |
   | ----------------------- | --------------- | ------------- |
   | Ambient Day Shift       | (06:00-14:00)   | 480           |
   | Ambient Afternoon Shift | (14:00-23:00)   | 480           |
   | Ambient Night shift     | (23:00 - 06:00) | 480           |
   | Chilled Day Shift       | (06:00-18:00)   | 720           |
   | Chilled Afternoon Shift | (18:00-06:00)   | 720           |

1) ### Pack Sizes

   Pack sizes allow you to group items together.

   For operations where you make a variety of SKUs that have similar format you could use weight or volume e.g.

   - 250g
   - 500g
   - 1KG
   - 1L
   - 2L
   - 4L

   Or define classes of different defining qualities such as shape

   - 500gROUNDGlass
   - 250gRect

   Having these defined allows reporting by pack size. i.e. we made 40,000 1L products this week.

   For setup you can just create a default pack size and then assign all items to this e.g.

   - PackSize1

   Later as you start using the system you can revisit

1) ### Items

   To define an Item you need the following already defined

   - Product Types
   - Print Templates
   - Pack Size
   - GTIN 13 Barcode (or enter bogus value of 13 Digits)
   - GTIN 14 Barcode (or enter bogus value of 14 Digits. However this will print invalid SSCC Pallet Labels as the GTIN14 is used on them)
   - Days life (used to calculate the best before date)

   The items can be imported by creating a CSV Spreadsheet with the following fields. Please check the items table in the database as the fields could have changed

   ```csv
   id,active,code,description,quantity,trade_unit,pack_size_id,product_type_id,consumer_unit,brand,variant,unit_net_contents,unit_of_measure,days_life,min_days_life,item_comment,print_template_id,carton_label_id
   1,1,10001,"Ambient Product 1",48,1234567890123,1,1,12345678901234,"Brand 1","Ambient Variant 1",500,G,365,0,,2,5
   2,1,20001,"1Lx16 Chilled Cabbage",100,1234567890123,1,2,12345678901234,Toggen,"Chilled Cabbage",1,L,273,0,,3,5
   ```

1) ### Printers

   A default CUPS-PDF printer is available in the docker environment the queue name is PDF and it outputs to /var/www/${WEB_DIR}/PDF

   #### Adding Printers
   1. Define a printer in Cups
       - Goto `http://<yourhost>:{CUPS_PORT}` (631 or if in docker environment whatever you set CUPS_PORT to)
       - Add any printers you want to print labels to in CUPS
   2. Make it available to print labels to in `Admin => Printers`
       - Give the printer a friendly name if using the default PDF queue
       - **Name** `PDF Printer`
       - **Options** Leave this blank for PDF. 
          - **Important** If you are printing to a **CAB** or **Zebra** printer then text commands that you send to them need to reach the printer without having been put through a filter so set options to `-o raw`
       - **Queue name** - This is the result of the application doing an lpstat and is a list of the CUPS print queues select `PDF` or whichever printer you have configured
       - **Set as default for these actions** - Here you will see a list of CakePHP Controllers and actions if you wish this printer to be the default printer for a specify Controller::action then check the box next to it. For a list of the currently configure Controller::actions that may require a default to be set see [PRINTING.md](PRINTING.md#application-print-controller-action-list)

1) ### Production Lines

   Production Lines allow you to specify a printer for pallet label printing

   They also allow reporting on how many pallets are produced by each production line

   You need to create at least one Production Line per Product Type

   | Production Line Name | Product Type | Printer |
   | -------------------- | ------------ | ------- |
   | Ambient Prod Line 1  | Ambient      | PDF     |
   | Chilled Prod Line 1  | Chilled      | PDF     |
   | Ambient Prod Line 2  | Ambient      | CABPL   |
