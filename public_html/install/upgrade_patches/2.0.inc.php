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

?>