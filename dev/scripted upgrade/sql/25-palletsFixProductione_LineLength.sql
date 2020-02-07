-- make the production_line field 45 chars instead of 10
-- fix truncation of production line field
ALTER TABLE `pallets`
CHANGE COLUMN `production_line` `production_line` VARCHAR(45) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL;
