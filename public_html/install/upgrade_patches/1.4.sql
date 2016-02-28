INSERT INTO `lc_settings` (`setting_group_key`, `type`, `title`, `description`, `key`, `value`, `function`, `priority`, `date_updated`, `date_created`) VALUES
('defaults', 'global', 'Default Warehouse', 'The default warehouse for your store.', 'default_warehouse_id', '1', 'input()', 20, NOW(), NOW());
-- --------------------------------------------------------
CREATE TABLE `lc_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(24) NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
-- --------------------------------------------------------
INSERT INTO `lc_warehouses` (`id`, `name`, `description`, `address`, `email`, `phone`, `date_updated`, `date_created`) VALUES
(1, 'Default', '', '', '', '', NOW(), NOW());
-- --------------------------------------------------------
CREATE TABLE `lc_products_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `option_combination` VARCHAR(64) NOT NULL,
  `quantity` decimal(11,4) NOT NULL
) ENGINE=MyISAM;
-- --------------------------------------------------------
INSERT INTO `lc_warehouses` (`product_id`, `warehouse_id`, `quantity`)
SELECT `id`, 1, `quantity` FROM `lc_products`;
-- --------------------------------------------------------
ALTER TABLE `lc_pages_info` CHANGE COLUMN `content` `content` MEDIUMTEXT NOT NULL AFTER `title`;
-- --------------------------------------------------------
ALTER TABLE `lc_zones` ADD INDEX `code` (`code`);
