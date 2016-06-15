<?php

  class url_manufacturer {

    function routes() {
      return array(
        array(
          'pattern' => '#^manufacturer/([0-9]+)/.*$#',
          'page' => 'manufacturer',
          'params' => 'manufacturer_id=$1',
          'redirect' => true,
        ),
        array(
          'pattern' => '#^.*-m-([0-9]+)/?$#',
          'page' => 'manufacturer',
          'params' => 'manufacturer_id=$1',
          'redirect' => true,
        ),
      );
    }

  	function rewrite($parsed_link, $language_code) {

      if (!isset($parsed_link['query']['manufacturer_id'])) return;

      $manufacturer = catalog::manufacturer($parsed_link['query']['manufacturer_id']);
      $parsed_link['path'] = 'manufacturer/'. $parsed_link['query']['manufacturer_id'] .'/'. functions::general_path_friendly($manufacturer->name, $language_code);

      unset($parsed_link['query']['manufacturer_id']);

      return $parsed_link;
    }
  }

?>