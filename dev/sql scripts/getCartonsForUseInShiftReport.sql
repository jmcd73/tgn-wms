SELECT 
    `Pallet`.`item_id`,
    `Item`.`code`,
    `Pallet`.`description`,
    `Pallet`.`qty`,
    `Pallet`.`qty_previous`,
    `Pallet`.`qty_modified`,
    `Pallet`.`pl_ref`,
    `Pallet`.`bb_date`,
    `Pallet`.`print_date`,
    `Location`.`location`,
    `Shipment`.`shipper`,
    `Shipment`.`shipped`,
    `Item`.`quantity`,
    COUNT(`Carton`.`id`) AS cartonRecordCount,
    `Location`.`id` AS LID,
    `Shipment`.`id` AS SID,
    `Item`.`id` AS IID,
    `Pallet`.`id` AS `PID`
FROM
    `palletsCartons`.`pallets` AS `Pallet`
        LEFT JOIN
    `palletsCartons`.`locations` AS `Location` ON (`Pallet`.`location_id` = `Location`.`id`)
        LEFT JOIN
    `palletsCartons`.`shipments` AS `Shipment` ON (`Pallet`.`shipment_id` = `Shipment`.`id`)
        LEFT JOIN
    `palletsCartons`.`items` AS `Item` ON (`Pallet`.`item_id` = `Item`.`id`)
        LEFT JOIN
    `palletsCartons`.`cartons` AS `Carton` ON (`Carton`.`pallet_id` = `Pallet`.`id`)
WHERE
     (((( `Pallet`.`product_type_id` = 1) AND ((`Shipment`.`shipped` IS NULL)
    OR (`Shipment`.`shipped` = 0))) AND (((`Pallet`.`print_date` >= '2019-12-02 5:00:00') AND (`Pallet`.`print_date` <= '2019-12-02 15:00:00')))))
GROUP BY `Pallet`.`id`
HAVING ((cartonRecordCount > 1) 
    OR (`Item`.`quantity` <> `Pallet`.`qty`))
ORDER BY `Pallet`.`print_date` DESC