<?php
  document::$snippets['title'][] = language::translate('manufacturers:head_title', 'Manufacturers');
  document::$snippets['description'] = language::translate('manufacturers:meta_description', '');
  
  breadcrumbs::add(language::translate('title_manufacturers', 'Manufacturers'));
  
  document::$snippets['title'][] = language::translate('manufacturers:head_title', 'Manufacturers');
  document::$snippets['description'] = language::translate('manufacturers:meta_description', '');
  
  $_page = new view();
  
  ob_start();
  include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_manufacturers.inc.php');
  $_page->snippets['box_manufacturers'] = ob_get_clean();
  
  echo $_page->stitch('pages/manufacturers');
?>
