TRUNCATE pallets;
TRUNCATE cartons;
TRUNCATE shipments;
UPDATE product_types SET next_serial_number = 1;
UPDATE settings SET setting = 1 WHERE name = 'SSCC_REF';


