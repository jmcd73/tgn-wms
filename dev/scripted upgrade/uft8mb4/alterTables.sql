ALTER DATABASE `pallets1` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`cartons` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`help` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`inventory_statuses` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`items` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`locations` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`menus` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`pack_sizes` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`pallets` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`printers` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`print_log` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`print_templates` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`production_lines` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`product_types` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`settings` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`shifts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`shipments` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `pallets1`.`help` CHANGE `controller_action` `controller_action` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`help` CHANGE `markdown_document` `markdown_document` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`inventory_statuses` CHANGE `name` `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`inventory_statuses` CHANGE `comment` `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`items` CHANGE `code` `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`items` CHANGE `description` `description` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`items` CHANGE `trade_unit` `trade_unit` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`items` CHANGE `consumer_unit` `consumer_unit` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`items` CHANGE `brand` `brand` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`items` CHANGE `variant` `variant` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`items` CHANGE `unit_of_measure` `unit_of_measure` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`locations` CHANGE `location` `location` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`locations` CHANGE `description` `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `name` `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `description` `description` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `url` `url` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `options` `options` varchar(254) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `title` `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `bs_url` `bs_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`menus` CHANGE `extra_args` `extra_args` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pack_sizes` CHANGE `pack_size` `pack_size` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pack_sizes` CHANGE `comment` `comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `description` `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `item` `item` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `best_before` `best_before` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `gtin14` `gtin14` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `qty_previous` `qty_previous` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `pl_ref` `pl_ref` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `sscc` `sscc` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `batch` `batch` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `printer` `printer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `production_line` `production_line` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`pallets` CHANGE `inventory_status_note` `inventory_status_note` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`print_log` CHANGE `print_action` `print_action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `name` `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `description` `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `text_template` `text_template` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `file_template` `file_template` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `print_action` `print_action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `example_image` `example_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `file_template_type` `file_template_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `example_image_type` `example_image_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`print_templates` CHANGE `replace_tokens` `replace_tokens` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`printers` CHANGE `name` `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`printers` CHANGE `options` `options` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`printers` CHANGE `queue_name` `queue_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`printers` CHANGE `set_as_default_on_these_actions` `set_as_default_on_these_actions` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `name` `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `code_prefix` `code_prefix` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `storage_temperature` `storage_temperature` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `code_regex` `code_regex` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `code_regex_description` `code_regex_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`product_types` CHANGE `serial_number_format` `serial_number_format` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`production_lines` CHANGE `name` `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`settings` CHANGE `name` `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`settings` CHANGE `setting` `setting` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shifts` CHANGE `name` `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shifts` CHANGE `comment` `comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shipments` CHANGE `shipper` `shipper` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shipments` CHANGE `con_note` `con_note` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shipments` CHANGE `shipment_type` `shipment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`shipments` CHANGE `destination` `destination` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`users` CHANGE `username` `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`users` CHANGE `password` `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`users` CHANGE `role` `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`users` CHANGE `full_name` `full_name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`items` CHANGE `item_comment` `item_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `pallets1`.`print_log` CHANGE `print_data` `print_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `pallets1`.`settings` CHANGE `comment` `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
