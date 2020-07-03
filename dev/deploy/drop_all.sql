SELECT concat('DROP TABLE IF EXISTS `db1-glabels.', table_name, '`;')
FROM information_schema.tables
WHERE table_schema = 'db1-glabels';


use 'db1-glabels';
DROP TABLE IF EXISTS `db1-glabels`.`cartons`;
DROP TABLE IF EXISTS `db1-glabels`.`help`;
DROP TABLE IF EXISTS `db1-glabels`.`inventory_statuses`;
DROP TABLE IF EXISTS `db1-glabels`.`items`;
DROP TABLE IF EXISTS `db1-glabels`.`locations`;
DROP TABLE IF EXISTS `db1-glabels`.`menus`;
DROP TABLE IF EXISTS `db1-glabels`.`pack_sizes`;
DROP TABLE IF EXISTS `db1-glabels`.`pallets`;
DROP TABLE IF EXISTS `db1-glabels`.`phinxlog`;
DROP TABLE IF EXISTS `db1-glabels`.`print_log`;
DROP TABLE IF EXISTS `db1-glabels`.`print_templates`;
DROP TABLE IF EXISTS `db1-glabels`.`printers`;
DROP TABLE IF EXISTS `db1-glabels`.`product_types`;
DROP TABLE IF EXISTS `db1-glabels`.`production_lines`;
DROP TABLE IF EXISTS `db1-glabels`.`settings`;
DROP TABLE IF EXISTS `db1-glabels`.`shifts`;
DROP TABLE IF EXISTS `db1-glabels`.`shipments`;
DROP TABLE IF EXISTS `db1-glabels`.`users`;
