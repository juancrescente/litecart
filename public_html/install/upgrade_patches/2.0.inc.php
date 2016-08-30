<?php

  $deleted_files = array(
    FS_DIR_HTTP_ROOT . WS_DIR_DATA .'errors.log',
    FS_DIR_HTTP_ROOT . WS_DIR_DATA .'performance.log',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'ext/responsiveslider/',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'admin.catalog/images/fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'admin.catalog/styles/fancybox.css',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'default.catalog/images/fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'default.catalog/styles/fancybox.css',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-1.12.4.min.js',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-1.12.4.min.map',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-migrate-1.4.1.min.js',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery.tabs.js',
  );

  foreach ($deleted_files as $pattern) {
    if (!file_delete($pattern)) {
      die('<span class="error">[Error]</span></p>');
    }
  }

  $modified_files = array(
    array(
      'file'    => FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'config.inc.php',
      'search'  => "  define('WS_DIR_INCLUDES',    WS_DIR_HTTP_HOME . 'includes/');" . PHP_EOL,
      'replace' => "  define('WS_DIR_INCLUDES',    WS_DIR_HTTP_HOME . 'includes/');" . PHP_EOL
                   "  define('WS_DIR_LOGS',        WS_DIR_HTTP_HOME . 'logs/');" . PHP_EOL,
    ),
    array(
      'file'    => FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'config.inc.php',
      'search'  => "  ini_set('error_log', FS_DIR_HTTP_ROOT . WS_DIR_DATA . 'errors.log');" . PHP_EOL,
      'replace' => "  ini_set('error_log', FS_DIR_HTTP_ROOT . WS_DIR_LOGS . 'errors.log');" . PHP_EOL,
    ),
  );

  foreach ($modified_files as $modification) {
    if (!file_modify($modification['file'], $modification['search'], $modification['replace'])) {
      die('<span class="error">[Error]</span></p>');
    }
  }

// Delete Modules
  $module_types_query = database::query(
    "select * from ". DB_TABLE_SETTINGS ."
    where `key` in ('order_action_modules', 'order_success_modules');"
  );
  while($module_type = database::fetch($module_types_query)) {
    foreach (explode(';', $module_type['value']) as $module) {
      database::query(
        "delete from ". DB_TABLE_SETTINGS ."
        where `key` = '". database::input($module) ."';"
      );
    }
    database::query(
      "delete from ". DB_TABLE_SETTINGS ."
      where `key` = '". database::input($module_type['key']) ."'
      limit 1;"
    );
  }

// Migrate Modules
  database::query(
    "update ". DB_TABLE_SETTINGS ."
    set `key` = 'job_modules'
    where `key` = 'jobs_modules';"
  );

  $settings_query = database::query(
    "select * from ". DB_TABLE_SETTINGS ."
    where `key` in ('job_modules', 'customer_modules', 'order_modules', 'shipping_modules', 'payment_modules', 'order_total_modules');"
  );

  while($module_type = database::fetch($settings_query)) {

    foreach (explode(';', $module_type['value']) as $module) {

      $module_query = database::query(
        "select * from ". DB_TABLE_SETTINGS ."
        where `key` = '". database::input($module) ."'
        limit 1;"
      );

      if (!database::num_rows($module_query)) continue;

      $module = database::fetch($module_query);

      $type = preg_replace('#^.*(_modules)$#', '', $module_type['key']);
      $settings = unserialize($module['value']);
      $status = in_array(strtolower($settings['status']), array('1', 'active', 'enabled', 'on', 'true', 'yes')) ? 1 : 0;
      $priority = (int)$settings['priority'];

      mb_convert_variables('UTF-8', null, $settings);

      database::query(
        "insert into `". DB_DATABASE ."`.`". DB_TABLE_PREFIX . "modules`
        (module_id, type, status, settings, priority, date_updated, date_created)
        values ('". database::input($module['key']) ."', '". database::input($type) ."', ". (int)$status .", '". database::input(json_encode($settings)) ."', ". (int)$priority .", '". $module['date_updated'] ."', '". $module['date_created'] ."');"
      );

      database::query(
        "delete from ". DB_TABLE_SETTINGS ."
        where `key` = '". database::input($module['key']) ."'
        limit 1;"
      );
    }

    database::query(
      "delete from ". DB_TABLE_SETTINGS ."
      where `key` = '". database::input($module_type['key']) ."'
      limit 1;"
    );
  }

  $modified_files = array(
    array(
      'file'    => FS_DIR_HTTP_ROOT . WS_DIR_INCLUDES . 'config.inc.php',
      'search'  => "  define('DB_TABLE_MANUFACTURERS_INFO',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'manufacturers_info`');",
      'replace' => "  define('DB_TABLE_MANUFACTURERS_INFO',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'manufacturers_info`');" . PHP_EOL
                 . "  define('DB_TABLE_MODULES',                           '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'modules`');",
    ),
  );

  foreach ($modified_files as $modification) {
    if (!file_modify($modification['file'], $modification['search'], $modification['replace'])) {
      die('<span class="error">[Error]</span></p>');
    }
  }

?>