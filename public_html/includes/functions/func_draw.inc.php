<?php
  
  function draw_fonticon($class, $params=null) {
    
    switch(true) {
      case (substr($class, 0, 3) == 'fa '):
        return '<i class="'. $class .'"'. (!empty($params) ? ' ' . $params : null) .'></i>';
        
      case (substr($class, 0, 3) == 'fa-'):
        document::$snippets['head_tags']['fontawesome'] = '<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/latest/css/font-awesome.min.css" />'; 
        return '<i class="fa '. $class .'"'. (!empty($params) ? ' ' . $params : null) .'></i>';
        
      case (substr($class, 0, 3) == 'glyphicon-'):
        return '<span class="glyphicon '. $class .'"'. (!empty($params) ? ' ' . $params : null) .'></span>';
        
      default:
        trigger_error('Unknown font icon ('. $class .')', E_USER_WARNING);
        return; 
    }
  }
  
  function draw_listing_category($category) {
    
    $listing_category = new view();
    
    list($width, $height) = functions::image_scale_by_width(320, settings::get('category_image_ratio'));
    
    $listing_category->snippets = array(
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
    
    return $listing_category->stitch('views/listing_category');
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
      'code' => $product['code'],
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
    document::$snippets['foot_tags']['ekko-lightbox'] = '<script src="'. WS_DIR_EXT .'ekko-lightbox/ekko-lightbox.min.js"></script>';
    document::$snippets['javascript']['ekko-lightbox'] = '  $(document).delegate(\'*[data-toggle="lightbox"]\', \'click\', function(event) {' . PHP_EOL
                                                       . '    event.preventDefault();' . PHP_EOL
                                                       . '    $(this).ekkoLightbox({' . PHP_EOL
                                                       //. '      loadingMessage: \''. functions::draw_fonticon('fa-spinner fa-spin') .'\',' . PHP_EOL
                                                       //. '      left_arrow_class: \''. functions::draw_fonticon('fa-chevron-left') .'\',' . PHP_EOL
                                                       //. '      right_arrow_class: \''. functions::draw_fonticon('fa-chevron-right') .'\',' . PHP_EOL
                                                       . '      loadingMessage: \'<i class="fa fa-spinner fa-spin"></i>\',' . PHP_EOL
                                                       . '      left_arrow_class: \'fa fa-chevron-left\',' . PHP_EOL
                                                       . '      right_arrow_class: \'fa fa-chevron-right\',' . PHP_EOL
                                                       . '      max_width: \'1024px\',' . PHP_EOL
                                                       . '      effect_class: null' . PHP_EOL
                                                       . '    });' . PHP_EOL
                                                       . '  });';
  }

  function draw_modal($name='default') {
    
    $_modal = new view();
    
    $_modal->snippets = array(
      'id' => 'modal-'.$name,
    );
    
    document::$snippets['foot_tags'][$_modal->snippets['id']] = '<script>' . PHP_EOL
                                                     . '  $("body").on("hidden.bs.modal", ".modal", function(e){' . PHP_EOL
                                                     . '    e.preventDefault();' . PHP_EOL
                                                     . '    var link = $(e.relatedTarget);' . PHP_EOL
                                                     . '    $(this).find(".modal-body").load(link.attr("href"));' . PHP_EOL
                                                     . '  });' . PHP_EOL
                                                     . '  $("body").on("hidden.bs.modal", ".modal", function(){' . PHP_EOL
                                                     . '    $(this).removeData("bs.modal").find(".modal-body").html("");' . PHP_EOL
                                                     . '  });' . PHP_EOL
                                                     . '</script>';
    
    document::$snippets['foot_tags'][$_modal->snippets['id']] .= $_modal->stitch('views/modal');
    
    return $_modal->snippets['id'];
  }
  
  function draw_pagination($pages) {
    
    $pages = ceil($pages);
    
    if ($pages < 2) return false;
    
    if (empty($_GET['page']) || $_GET['page'] < 2) $_GET['page'] = 1;
    
    if ($_GET['page'] > 1) document::$snippets['head_tags']['prev'] = '<link rel="prev" href="'. document::href_ilink(null, array('page' => $_GET['page']-1), true) .'" />';
    if ($_GET['page'] < $pages) document::$snippets['head_tags']['next'] = '<link rel="next" href="'. document::href_ilink(null, array('page' => $_GET['page']+1), true) .'" />';
    if ($_GET['page'] < $pages) document::$snippets['head_tags']['prerender'] = '<link rel="prerender" href="'. document::href_ilink(null, array('page' => $_GET['page']+1), true) .'" />';
    
    $pagination = new view();
    
    $pagination->snippets['items'][] = array(
      'title' => language::translate('title_previous', 'Previous'),
      'link' => document::ilink(null, array('page' => $_GET['page']-1), true),
      'disabled' => ($_GET['page'] <= 1) ? true : false,
      'active' => false,
    );
    
    for ($i=1; $i<=$pages; $i++) {
      
      if ($i < $pages-5) {
        if ($i > 1 && $i < $_GET['page'] - 1 && $_GET['page'] > 4) {
          $rewind = round(($_GET['page']-1)/2);
          $pagination->snippets['items'][] = array(
            'title' => ($rewind == $_GET['page']-2) ? $rewind : '...',
            'link' => document::ilink(null, array('page' => $rewind), true),
            'disabled' => false,
            'active' => false,
          );
          $i = $_GET['page'] - 1;
          if ($i > $pages-4) $i = $pages-4;
        }
      }
      
      if ($i > 5) {  
        if ($i > $_GET['page'] + 1 && $i < $pages) {
          $forward = round(($_GET['page']+1+$pages)/2);
          $pagination->snippets['items'][] = array(
            'title' => ($forward == $_GET['page']+2) ? $forward : '...',
            'link' => document::ilink(null, array('page' => $forward), true),
            'disabled' => false,
            'active' => false,
          );
          $i = $pages;
        }
      }
      
      $pagination->snippets['items'][] = array(
        'title' => $i,
        'link' => document::ilink(null, array('page' => $i), true),
        'disabled' => false,
        'active' => ($i == $_GET['page']) ? true : false,
      );
    }
    
    $pagination->snippets['items'][] = array(
      'title' => language::translate('title_next', 'Next'),
      'link' => document::ilink(null, array('page' => $_GET['page']+1), true),
      'disabled' => ($_GET['page'] >= $pages) ? true : false,
      'active' => false,
    );
    
    $html = $pagination->stitch('views/pagination');
    
    return $html;
  }

?>