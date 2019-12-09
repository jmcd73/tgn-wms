# Cartons

By default when a pallet label is printed the quantity of cartons on the pallet is set to the value for the item specified in `Data => Items => Edit`

However sometimes perhaps at the end of a production run a part pallet is produced and then extra cartons added on another production day.

Therefore there is a need to track how many cartons of differing best before dates on pallets.

The `editPalletCartons` screen enables a user to edit the qauntity and best-before dates of cartons on a pallet

## Required Permissions

- The user must be a member of the `qa` group and be logged-in

## To add cartons to a pallet

1. In the blank row
1. Click in the production date field select the date from the datepicker
1. The best before will calculated automatically
1. Enter the quantity of cartons
1. Click submit

**Note:** You can only add one new record at a time

## To completely remove a carton best before / quantity record

1. Change the Quantity to 0
1. Click submit
