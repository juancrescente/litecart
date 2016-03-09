ALTER TABLE `lc_products`
CHANGE COLUMN `sku` `sku` varchar(64) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `weight` `weight` decimal(10,4) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `weight_class` `weight_class` varchar(2) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `dim_x` `dim_x` decimal(10,4) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `dim_y` `dim_y` decimal(10,4) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `dim_z` `dim_z` decimal(10,4) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4',
CHANGE COLUMN `dim_class` `dim_class` varchar(2) NOT NULL COMMENT 'Moved to lc_products_stock as of version 1.4';
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `lc_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(24) NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT;
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `lc_products_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `combination` varchar(64) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `weight` decimal(11,4) NOT NULL,
  `weight_class` varchar(2) NOT NULL,
  `dim_x` decimal(11,4) NOT NULL,
  `dim_y` decimal(11,4) NOT NULL,
  `dim_z` decimal(11,4) NOT NULL,
  `dim_class` varchar(2) NOT NULL,
  `warehouse_1` decimal(11,4) NOT NULL,
  `warehouse_2` decimal(11,4) NOT NULL,
  `warehouse_4` decimal(11,4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_item` (`product_id`,`combination`)
) ENGINE=MyISAM DEFAULT;
