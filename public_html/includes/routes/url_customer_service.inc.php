<?php

  class url_customer_service {

    function routes() {
      return array(
        array(
          'pattern' => '#^customer-service/([0-9]+)/.*$#',
          'page' => 'customer_service',
          'params' => 'page_id=$1',
          'redirect' => true,
        ),
        array(
          'pattern' => '#^.*-s-([0-9]+)/?$#',
          'page' => 'customer_service',
          'params' => 'page_id=$1',
          'redirect' => true,
        ),
      );
    }

    function rewrite($parsed_link, $language_code) {

      if (empty($parsed_link['query']['page_id'])) return false;

      $page = catalog::page($parsed_link['query']['page_id']);
      $parsed_link['path'] = 'customer-service/'. $parsed_link['query']['page_id'] .'/'. functions::general_path_friendly($page->title[$language_code], $language_code);

      unset($parsed_link['query']['page_id']);

      return $parsed_link;
    }
  }

?>