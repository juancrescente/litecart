<?php
  document::$snippets['title'][] = language::translate('categories:head_title', 'Categories');
  document::$snippets['description'] = language::translate('categories:meta_description', '');

  breadcrumbs::add(language::translate('title_categories', 'Categories'));

  $_page = new view();

  ob_start();
  include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_categories.inc.php');
  $_page->snippets['box_categories'] = ob_get_clean();

  echo $_page->stitch('pages/categories');
?>