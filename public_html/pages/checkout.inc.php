<?php
  if (settings::get('catalog_only_mode')) return;
  
  document::$layout = 'checkout';
  
  header('X-Robots-Tag: noindex');
  document::$snippets['head_tags']['noindex'] = '<meta name="robots" content="noindex" />';

  breadcrumbs::add(language::translate('title_checkout', 'Checkout'));
  
  document::$snippets['title'][] = language::translate('title_checkout', 'Checkout');
  
  $_page = new view();
  
  ob_start();
  include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_cart.html.inc.php');
  $_page->snippets['box_checkout_cart'] = ob_get_clean();
  
  ob_start();
  include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_customer.html.inc.php');
  $_page->snippets['box_checkout_customer'] = ob_get_clean();
  
  ob_start();
  include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_shipping.html.inc.php');
  $_page->snippets['box_checkout_shipping'] = ob_get_clean();
  
  ob_start();
  include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_payment.html.inc.php');
  $_page->snippets['box_checkout_payment'] = ob_get_clean();
  
  ob_start();
  include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_summary.html.inc.php');
  $_page->snippets['box_checkout_summary'] = ob_get_clean();
  
  echo $_page->stitch('pages/checkout');
?>