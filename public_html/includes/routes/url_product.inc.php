<?php

  class url_product {

    function routes() {
      return array(
        array(
          'pattern' => '#^product/([0-9]+)/.*$#',
          'page' => 'product',
          'params' => 'product_id=$1',
          'redirect' => true,
        ),
        array(
          'pattern' => '#^(?:.*-c-([0-9]+)/)?.*-p-([0-9]+)$#',
          'page' => 'product',
          'params' => 'category_id=$1&product_id=$2',
          'redirect' => true,
        ),
      );
    }

  	function rewrite($parsed_link, $language_code) {

      if (!isset($parsed_link['query']['product_id'])) return false;

      $product = reference::product($parsed_link['query']['product_id'], $language_code);
      $parsed_link['path'] = 'product/'.$product->id.'/'.functions::general_path_friendly($product->name, $language_code);

      unset($parsed_link['query']['product_id']);

      return $parsed_link;
    }
  }

?>