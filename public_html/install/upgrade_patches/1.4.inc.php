<?php
 $modified_files = array(
    array(
      'file'    => FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'config.inc.php',
      'search'  => "  define('DB_TABLE_PRODUCTS_OPTIONS_STOCK',            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_options_stock`');" . PHP_EOL,
      'replace' => "",
    ),
    array(
      'file'    => FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'config.inc.php',
      'search'  => "  define('DB_TABLE_PRODUCTS_PRICES',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_prices`');" . PHP_EOL,
      'replace' => "  define('DB_TABLE_PRODUCTS_PRICES',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_prices`');" . PHP_EOL
                 . "  define('DB_TABLE_PRODUCTS_STOCK',                    '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_stock`');",
    ),
  );
  
  foreach ($modified_files as $modification) {
    if (!file_modify($modification['file'], $modification['search'], $modification['replace'])) {
      die('<span class="error">[Error]</span></p>');
    }
  }
?>