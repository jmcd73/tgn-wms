## Settings table

The settings table contains a number of crucial settings it can be queried from all models and controllers (see examples below).

### Information about settings


* **sscc_ref** - The SSCC reference number increments by 1 for every call to pallet_print action. Setting this to 0 the next SSCC number will be
* **sscc_extension_digit** - SSCC extension digit. Normally 0 but increment this when your SSCC reference numbers run out and you need to not duplicate SSCC within a year
* **sscc_company_prefix** - This is the GS1 provide company prefix this identifies a SSCC as from your company
* **companyName** - Enter your company name here and this will go towards rebranding the app for your use. Other settings such as nav and footer icons can be found in app/Config/configuration.php
* **cooldown** - Items will appear highlighted in Stock view for this many hours after pallet label is printed
* **days_life** - This is how many days life still needs to be on a product when it is shipped. If it has less than this value it will not be able to be placed on a shipment and manual intervention will be needed in order to ship
* **TEMPLATE_ROOT** - Location relative to WEBROOT of the gLabels templates and example images
* **DOCUMENTATION_ROOT** - Location relative to ROOT of the markdown files that make up these help documents
* **cabLabelTokens** - And other "Token" files provide a mapping between the Print Template Text Template replace tokens and the PHP variables used in print screens

#### Token map settings
cabLabelTokens JSON template maps the PHP variable 'companyName' to the replace token '\*COMPANY_NAME\*' in the print template

```json
{
  "*COMPANY_NAME*": "companyName",
  "*OFFSET*": "offset",
  "*NUMBER*": "number",
  "*NUM_LABELS*": "quantity"
}
```

#### CAB Printer Language Text Template

Example of the replace tokens in the template

Change Print Templates in Admin => Print Templates

```
m m
J 150 x 200 pallet label
H 100
S l1;0,0,200,203,150
O R
T 15,7,0,596,pt26;*COMPANY_NAME*
G 3,10,0;L:144,.3
T 5,20,0,596,pt18;CODE
T 20,30,0,596,pt72;*INT_CODE*
```
#### Accessing settings via PHP
```php
# if the setting is in the Setting field
$this->getSetting('DOCUMENTATION_ROOT');
or
# if the setting is in the Comment field
$this->getSetting('printTemplatesPerRowCols', true);
or
# with model included
$this->{$this->modelClass}->getSetting('setting_name');
$this->Pallet->getSetting('setting_name');
```
