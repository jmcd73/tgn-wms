SELECT 
   COUNT(*),
    p.id,
    p.item,
    p.pl_ref,
    p.shipment_id,
    s.shipped,
    p.description,
    p.print_date,
    i.quantity AS ItemQTY,
    p.qty AS PQTY,
    SUM(c.count) AS CC,
    COUNT(c.id) AS cartons
FROM
    pallets p
        LEFT JOIN
    items i ON p.item_id = i.id
        LEFT JOIN
    cartons c ON p.id = c.pallet_id
        LEFT JOIN
    shipments s ON p.shipment_id = s.id
GROUP BY p.id	
HAVING 
   ( ( s.shipped IS NULL OR s.shipped = 0 ) AND i.quantity <> p.qty )
    OR (( s.shipped IS NULL OR s.shipped = 0 ) AND COUNT(c.id) > 1 )
ORDER BY p.print_date DESC
