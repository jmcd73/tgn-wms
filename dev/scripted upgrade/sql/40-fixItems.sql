UPDATE pallets SET product_type_id = (SELECT product_type_id FROM items WHERE pallets.item_id = items.id);
UPDATE pallets p SET p.production_line_id = ( SELECT pl.id FROM production_lines pl WHERE pl.name = p.production_line );
-- oil
UPDATE items SET product_type_id = 1 WHERE code LIKE '6%';
-- margarine
UPDATE items SET product_type_id = 2 WHERE code LIKE '5%';