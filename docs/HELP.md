# Application Online Help

## How it works
The online help is written in markdown documents and placed in docs/help

From within the application help is associated with different screens by going to Admin => Help and then add a record that relates a Controller/Action with the markdown document

Once the mapping is established a help icon will appear on any page with linked help

Here are some examples of the Controller::Action to Markdown mappings

| Controller / Action | Markdown Document |
|---------------------|-------------------|
| LabelsController::pallet_print | PALLET_PRINT.md |
| ShipmentsController::addApp | ADD_APP.md |
| ShipmentsController::index | DISPATCH_INDEX.md |
| SettingsController::index | SETTINGS.md |


The URLs in the application map to the controller / action

    http://localhost:8083/Labels/onhand = LabelsController::onhand
