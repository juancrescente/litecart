<?php
  header('X-Robots-Tag: noindex');
  document::$snippets['head_tags']['noindex'] = '<meta name="robots" content="noindex" />';
  document::$snippets['title'][] = language::translate('order_success:head_title', 'Order Success');

  breadcrumbs::add(language::translate('title_checkout', 'Checkout'), document::ilink('checkout'));
  breadcrumbs::add(language::translate('title_order_success', 'Order Success'));

  $order = new ctrl_order('session');

  $payment = new mod_payment();

  $order_module = new mod_order();

  if (empty($order->data['id'])) die('Error: Missing session order object');

  cart::reset();

  $modal_id = functions::draw_modal();

  $_page = new view();

  $_page->snippets = array(
    'printable_link' => document::ilink('printable_order_copy', array('order_id' => $order->data['id'], 'checksum' => functions::general_order_public_checksum($order->data['id']), 'media' => 'print')),
    'payment_receipt' => $payment->receipt($order),
    'order_success_modules_output' => $order_module->success($order),
  );

  echo $_page->stitch('pages/order_success');
?>