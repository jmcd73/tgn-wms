INSERT INTO cartons ( pallet_id, count, best_before, production_date)
SELECT  id, qty, bb_date, DATE_FORMAT(print_date, '%Y-%m-%d')  from pallets;