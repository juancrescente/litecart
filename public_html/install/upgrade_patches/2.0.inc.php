<?php

  $deleted_files = array(
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'ext/responsiveslider/',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'admin.catalog/images/fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'admin.catalog/styles/fancybox.css',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'default.catalog/images/fancybox/',
    FS_DIR_HTTP_ROOT . WS_DIR_TEMPLATES .'default.catalog/styles/fancybox.css',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-1.11.3.min.js',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-1.11.3.min.map',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery-migrate-1.2.1.min.js',
    FS_DIR_HTTP_ROOT . WS_DIR_EXT .'jquery/jquery/jquery.tabs.js',
  );

  foreach ($deleted_files as $pattern) {
    if (!file_delete($pattern)) {
      die('<span class="error">[Error]</span></p>');
    }
  }

?>