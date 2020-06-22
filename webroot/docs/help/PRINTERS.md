# Add / Remove Printers

1. Before adding a printer to be used by the Toggen WMS add a CUPS print queue on the web server hosting the Toggen WMS code. Make a note of the Queue Name in Cups as this will be used for the Queue Name in Toggen WMS
2. Click Add to add a new printer
3. Give it a friendly name for name. e.g. "Admin printer"
4. If sending printer command language directly to the printer for example CAB or Zebra Labels enter `-o raw` for options. Otherwise leave blank
5. Specify the Controller::actions that the printer default.

   To find the Controller and action look at the address bar URL:

   http://localhost:8634/PrintLabels/sampleLabels

   In this example the Controller is PrintLabels and the Action is sampleLabels
