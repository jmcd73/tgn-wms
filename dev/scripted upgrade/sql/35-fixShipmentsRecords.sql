UPDATE shipments SET product_type_id = 2 WHERE shipment_type = 'marg';
UPDATE shipments SET product_type_id = 1 WHERE shipment_type = 'oil';
UPDATE shipments SET pallet_count = (SELECT COUNT(*) FROM pallets WHERE pallets.shipment_id=shipments.id)