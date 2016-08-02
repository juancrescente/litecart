<?php
  document::$layout = 'checkout';

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-type: text/html; charset='. language::$selected['charset']);
    document::$layout = 'ajax';
  }

  if (settings::get('catalog_only_mode')) return;

  /*
  if (!empty($_GET['return'])) {

    switch($_GET['return']) {
      case 'cart':
        include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_cart.html.inc.php');
        return;

      case 'customer':
        include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_customer.html.inc.php');
        return;

      case 'shipping':
        include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_shipping.html.inc.php');
        return;

      case 'payment':
        include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_payment.html.inc.php');
        return;

      case 'summary':
        include_once vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_PAGES . 'ajax/checkout_summary.html.inc.php');
        return;
    }
  }
  */

  if (file_get_contents('php://input')) {

  // Customer

  }

  header('X-Robots-Tag: noindex');
  document::$snippets['head_tags']['noindex'] = '<meta name="robots" content="noindex" />';
  document::$snippets['title'][] = language::translate('checkout:head_title', 'Checkout');

  breadcrumbs::add(language::translate('title_checkout', 'Checkout'));

  $_page = new view();
  echo $_page->stitch('pages/checkout');
?>