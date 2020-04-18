UPDATE inventory_statuses
SET
    allow_bulk_status_change = 1
WHERE
    id IN (1 , 3);