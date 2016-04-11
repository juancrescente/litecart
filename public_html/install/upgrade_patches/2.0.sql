ALTER TABLE `lc_categories_info` ADD UNIQUE INDEX `category_info` (`category_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_delivery_statuses_info` ADD UNIQUE INDEX `delivery_status_info` (`delivery_status_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_languages` DROP INDEX `id`, ADD PRIMARY KEY (`id`);
-- --------------------------------------------------------
ALTER TABLE `lc_manufacturers_info` ADD UNIQUE INDEX `manufacturer_info` (`manufacturer_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_option_groups_info`	ADD UNIQUE INDEX `option_group_info` (`group_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_option_values_info` ADD UNIQUE INDEX `option_value_info` (`value_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_order_statuses_info` ADD UNIQUE INDEX `order_status_info` (`order_status_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_pages_info` ADD UNIQUE INDEX `page_info` (`page_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_info` ADD UNIQUE INDEX `product_info` (`product_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_options` ADD UNIQUE INDEX `product_option` (`product_id`, `group_id`, `value_id`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_options_stock` ADD UNIQUE INDEX `product_option_stock` (`product_id`, `combination`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_prices` ADD UNIQUE INDEX `product_price` (`product_id`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_stock` ADD UNIQUE INDEX `stock_item` (`product_id`, `warehouse_id`, `option_combination`);
-- --------------------------------------------------------
ALTER TABLE `lc_products_to_categories` ADD UNIQUE INDEX `mapping` (`product_id`, `category_id`);
-- --------------------------------------------------------
ALTER TABLE `lc_product_groups_info` ADD UNIQUE INDEX `product_group_info` (`product_group_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_product_groups_values_info` ADD UNIQUE INDEX `product_group_value_info` (`product_group_value_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_quantity_units_info` ADD UNIQUE INDEX `quantity_unit_info` (`quantity_unit_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_sold_out_statuses_info` ADD UNIQUE INDEX `sold_out_status_info` (`sold_out_status_id`, `language_code`);
-- --------------------------------------------------------
ALTER TABLE `lc_zones_to_geo_zones` ADD UNIQUE INDEX `region` (`geo_zone_id`, `country_code`, `zone_code`);