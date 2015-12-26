<?php

  function draw_fontawesome_icon($name, $params=null, $class=null) {
    //trigger_error('draw_fontawesome_icon() is deprecated. Use instead draw_fonticon()', E_USER_DEPRECATED);
    return functions::draw_fonticon('fa-'.$name . ($class ? ' ' . $class : null), $params);
  }
  
  function draw_fonticon($class, $params=null) {
    
    switch(true) {
      case (substr($class, 0, 3) == 'fa '):
        return '<i classes="'. $class .'"'. (!empty($params) ? ' ' . $params : null) .'></i>';
        
      case (substr($class, 0, 3) == 'fa-'):
        return '<i class="fa '. $class .'"'. (!empty($params) ? ' ' . $params : null) .'></i>';
        
      default:
        trigger_error('Unknown font icon ('. $class .')', E_USER_WARNING);
        return; 
    }
  }
  
  function draw_listing_category($category) {
    
    $list_item = new view();
    
    list($width, $height) = functions::image_scale_by_width(320, settings::get('category_image_ratio'));
    
    $list_item->snippets = array(
      'category_id' => $category['id'],
      'name' => $category['name'],
      'link' => document::ilink('category', array('category_id' => $category['id'])),
      'image' => array(
        'original' => WS_DIR_IMAGES . $category['image'],
        'thumbnail' => functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $category['image'], $width, $height, 'CROP'),
        'thumbnail_2x' => functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $category['image'], $width*2, $height*2, 'CROP'),
        'viewport' => array(
          'width' => $width,
          'height' => $height,
        ),
      ),
      'short_description' => $category['short_description'],
    );
    
    return $list_item->stitch('views/listing_category');
  }
  
  function draw_listing_product($product, $listing_type='column') {
    
    $listing_product = new view();
    
    $sticker = '';
    if ($product['campaign_price']) {
      $sticker = '<div class="sticker sale" title="'. language::translate('title_on_sale', 'On Sale') .'">'. language::translate('sticker_sale', 'Sale') .'</div>';
    } else if ($product['date_created'] > date('Y-m-d', strtotime('-'.settings::get('new_products_max_age')))) {
      $sticker = '<div class="sticker new" title="'. language::translate('title_new', 'New') .'">'. language::translate('sticker_new', 'New') .'</div>';
    }
    
    list($width, $height) = functions::image_scale_by_width(160, settings::get('product_image_ratio'));
    
    $listing_product->snippets = array(
      'listing_type' => $listing_type,
      'product_id' => $product['id'],
      'name' => $product['name'],
      'link' => document::ilink('product', array('product_id' => $product['id']), array('category_id')),
      'image' => array(
        'original' => $product['image'] ? WS_DIR_IMAGES . $product['image'] : '',
        'thumbnail' => functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $product['image'], $width, $height, settings::get('product_image_clipping')),
        'thumbnail_2x' => functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $product['image'], $width*2, $height*2, settings::get('product_image_clipping')),
        'viewport' => array(
          'width' => $width,
          'height' => $height,
        ),
      ),
      'sticker' => $sticker,
      'lightbox_id' => functions::draw_lightbox(),
      'modal_id' => functions::draw_modal(),
      'manufacturer' => array(),
      'short_description' => $product['short_description'],
      'price' => currency::format(tax::get_price($product['price'], $product['tax_class_id'])),
      'quantity' => $product['quantity'],
      'campaign_price' => $product['campaign_price'] ? currency::format(tax::get_price($product['campaign_price'], $product['tax_class_id'])) : null,
    );
    
    if (!empty($product['manufacturer_id'])) {
      $listing_product->snippets['manufacturer'] = array(
        'id' => $product['manufacturer_id'],
        'name' => $product['manufacturer_name'],
      );
    }
    
  // Watermark Original Image
    if (settings::get('product_image_watermark')) {
      $listing_product->snippets['image']['original'] = functions::image_process(FS_DIR_HTTP_ROOT . $listing_product->snippets['image']['original'], array('watermark' => true));
    }
    
    return $listing_product->stitch('views/listing_product');
  }
  
  function draw_fancybox() {
    trigger_error('draw_fancybox() is deprecated. Use instead draw_lightbox()', E_USER_DEPRECATED);
  }
  
  function draw_lightbox($name='default') {
    
    document::$snippets['head_tags']['ekko-lightbox'] = '<link rel="stylesheet" href="'. WS_DIR_EXT .'ekko-lightbox/ekko-lightbox.min.css">';
    document::$snippets['foot_tags']['ekko-lightbox'] = '<script src="'. WS_DIR_EXT .'ekko-lightbox/ekko-lightbox.min.js"></script>'
                                                      . '<script>' . PHP_EOL
                                                      . '  $(document).delegate(\'*[data-toggle="lightbox"]\', \'click\', function(event) {' . PHP_EOL
                                                      . '    event.preventDefault();' . PHP_EOL
                                                      . '    $(this).ekkoLightbox();' . PHP_EOL
                                                      . '  });' . PHP_EOL
                                                      . '</script>';
    
    $_lightbox = new view();
    
    $_lightbox->snippets = array(
      'id' => 'lightbox-'.$name,
    );
    
    document::$snippets['foot_tags']['lightbox-'.$_lightbox->snippets['id']] = $_lightbox->stitch('views/lightbox');
    
    return $_lightbox->snippets['id'];
  }

  function draw_modal($name='default') {
    
    $_modal = new view();
    
    $_modal->snippets = array(
      'id' => 'modal-'.$name,
    );
    
    document::$snippets['foot_tags']['modal-'.$name] = $_modal->stitch('views/modal');
    
    return $_modal->snippets['id'];
  }
  
  function draw_pagination($pages) {
    
    $pages = ceil($pages);
  
    if ($pages < 2) return false;
    
    if ($_GET['page'] < 2) $_GET['page'] = 1;
    
    if ($_GET['page'] > 1) document::$snippets['head_tags']['prev'] = '<link rel="prev" href="'. htmlspecialchars(document::link('', array('page' => $_GET['page']-1), true)) .'" />';
    if ($_GET['page'] < $pages) document::$snippets['head_tags']['next'] = '<link rel="next" href="'. htmlspecialchars(document::link('', array('page' => $_GET['page']+1), true)) .'" />';
    if ($_GET['page'] < $pages) document::$snippets['head_tags']['prerender'] = '<link rel="prerender" href="'. htmlspecialchars(document::link('', array('page' => $_GET['page']+1), true)) .'" />';
    
    $html = '<nav class="">'. PHP_EOL
          . '  <ul class="pagination">' . PHP_EOL;
    
    if ($_GET['page'] > 1) {
      $html .= '    <li><a href="'. document::href_link($_SERVER['REQUEST_URI'], array('page' => $_GET['page']-1), true) .'">&laquo;</a></li>' . PHP_EOL;
    } else {
      $html .= '    <li class="disabled"><span>&laquo;</span></li>' . PHP_EOL;
    }
    
    for ($i=1; $i<=$pages; $i++) {
      
      if ($i < $pages-5) {
        if ($i > 1 && $i < $_GET['page'] - 1 && $_GET['page'] > 4) {
          $rewind = round(($_GET['page']-1)/2);
          $html .= '    <li><a href="'. document::href_link($_SERVER['REQUEST_URI'], array('page' => $rewind), true) .'">'. (($rewind == $_GET['page']-2) ? $rewind : '...') .'</a></li>' . PHP_EOL;
          $i = $_GET['page'] - 1;
          if ($i > $pages-4) $i = $pages-4;
        }
      }
      
      if ($i > 5) {  
        if ($i > $_GET['page'] + 1 && $i < $pages) {
          $forward = round(($_GET['page']+1+$pages)/2);
          $html .= '    <li><a href="'. document::href_link($_SERVER['REQUEST_URI'], array('page' => $forward), true) .'">'. (($forward == $_GET['page']+2) ? $forward : '...') .'</a></li>' . PHP_EOL;
          $i = $pages;
        }
      }
    
      if ($i == $_GET['page']) {
        $html .= '    <li class="active"><span>'. $i .'</span></li>' . PHP_EOL;
      } else {
        $html .= '    <li><a href="'. document::href_link($_SERVER['REQUEST_URI'], array('page' => $i), true) .'">'. $i .'</a></li>' . PHP_EOL;
      }
    }
    
    if ($_GET['page'] < $pages) {
      $html .= '    <li><a href="'. document::href_link($_SERVER['REQUEST_URI'], array('page' => $_GET['page']+1), true) .'">&raquo;</a></li>' . PHP_EOL;
    } else {
      $html .= '    <li class="disabled"><span>&raquo;</span></li>' . PHP_EOL;
    }
    
    $html .= '  </ul>'
           . '</nav>';
    
    return $html;
  }

?>