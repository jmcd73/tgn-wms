BAKE="Cartons
Help
InventoryStatuses
Items
Labels
Locations
Menus
PackSizes
Pallets
PrintLog
PrintTemplates
Printers
ProductTypes
ProductionLines
Settings
Shifts
Shipments
Users"

for i in $BAKE
do
	echo $i
	bin/cake bake all -t BootstrapUI $i
done

