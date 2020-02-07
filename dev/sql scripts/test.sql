(
    (
        (
            (
                (
                    (`Shipment`.`shipped` IS NULL)
                    OR
(`Shipment`.`shipped` = 0)
                )
            )  AND
(cartonRecordCount > 1)
        )
    ) OR
(
        (
            (`Item`.`quantity` <> `Pallet`.`qty`)
    AND
(((`Shipment`.`shipped` IS NULL)
    OR
(`Shipment`.`shipped` = 0))))))