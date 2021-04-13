## Settings table

The settings table contains a number of crucial settings it can be queried from all models and controllers (see examples below).

## How to use

Settings use a unique name and then a setting and a comment. 


For example

**name:** 

```
EMAIL_PALLET_LABEL_TO
```

**setting:** 
```
James McDonald <james@toggen.com.au>
# Format example: 
# FirstName LastName <email@example.com> 
# To disable send put a # at the start of the line
# Greg Fry <greg@multibevco.com.au>
# Lisa McDonald <lisa@toggen.com.au>
```

**comment:** 
```
Email address to send pallet labels to to. Add or remove the leading # to enable or disable an email address
```


The setting field, and comment field can be single or multi-line. Settings have leading and trail whitespace trimmed before they are saved

```
# This is a comment in the setting field

# comments and blank lines inside the setting field are stripped
James McDonald <james@toggen.com.au>
```



### Information about settings

* **SSCC_REF** - The SSCC reference number increments by 1 for every call to pallet_print action. Setting this to 0 the next SSCC number will be
* **SSCC_EXTENSION_DIGIT** - SSCC extension digit. Normally 0 but increment this when your SSCC reference numbers run out and you need to not duplicate SSCC within a year
* **SSCC_COMPANY_PREFIX** - This is the GS1 provide company prefix this identifies a SSCC as from your company
* **COMPANY_NAME** - Enter your company name here and this will go towards rebranding the app for your use. Other settings such as nav and footer icons can be found in app/Config/configuration.php
* **COOL_DOWN** - Items will appear highlighted in Stock view for this many hours after pallet label is printed
* **DAYS_LIFE** - This is how many days life still needs to be on a product when it is shipped. If it has less than this value it will not be able to be placed on a shipment and manual intervention will be needed in order to ship
* **TEMPLATE_ROOT** - Location relative to WEBROOT of the gLabels templates and example images
* **DOCUMENTATION_ROOT** - Location relative to WEBROOT of the markdown files that make up these help documents


#### Accessing settings via PHP

Use the `use App\Lib\Utility\SettingsTrait;` to query settings

```php
use App\Lib\Utility\SettingsTrait;
class {

    use SettingsTrait;
    # if the SettingsTrait is used 
    $this->getSetting('DOCUMENTATION_ROOT');

}

# in a controller with model 
$this->Pallet->getSetting('setting_name');
```
