-- some of the new stuff had a product type of margarine when it was oil
UPDATE pallets SET product_type_id = 1 WHERE item LIKE '6%' AND product_type_id = 2;