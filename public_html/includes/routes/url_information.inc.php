<?php
  
  class url_information {
    
    function routes() {
      return array(
        array(
          'pattern' => '#^information/([0-9]+)/.*$#',
          'page' => 'information',
          'params' => 'page_id=$1',
          'redirect' => true,
        ),
        array(
          'pattern' => '#^.*-i-([0-9]+)/?$#',
          'page' => 'information',
          'params' => 'page_id=$1',
          'redirect' => true,
        ),
      );
    }
    
    function rewrite($parsed_link, $language_code) {
      
      if (empty($parsed_link['query']['page_id'])) return false;
      
      $page = reference::page($parsed_link['query']['page_id']);
      $parsed_link['path'] = 'information/'. $parsed_link['query']['page_id'] .'/'. functions::general_path_friendly($page->title[$language_code], $language_code);
      
      unset($parsed_link['query']['page_id']);
      
      return $parsed_link;
    }
  }
  
?>