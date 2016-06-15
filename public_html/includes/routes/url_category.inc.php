<?php
  class url_category {

    function routes() {
      return array(
        array(
          'pattern' => '#^category/([0-9]+)/.*$#',
          'page' => 'category',
          'params' => 'category_id=$1',
          'redirect' => true,
        ),
        array(
          'pattern' => '#^.*-c-([0-9]+)/?$#',
          'page' => 'category',
          'params' => 'category_id=$1',
          'redirect' => true,
        ),
      );
    }

    function rewrite($parsed_link, $language_code) {

      if (!isset($parsed_link['query']['category_id'])) return;

      $category = catalog::category($parsed_link['query']['category_id']);
      $parsed_link['path'] = 'category/'. $parsed_link['query']['category_id'] .'/'. functions::general_path_friendly($category->name[$language_code], $language_code);

      unset($parsed_link['query']['category_id']);

      return $parsed_link;
    }
  }
?>