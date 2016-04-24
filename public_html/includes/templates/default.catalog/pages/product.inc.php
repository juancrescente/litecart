<div class="twelve-eighty">
  <!--snippet:notices-->
  
  <div class="sidebar">
    <div class="well">
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_category_tree.inc.php'); ?>
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_filter.inc.php'); ?>
      <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_recently_viewed_products.inc.php'); ?>
    </div>
  </div>
  
  <div class="content">
    {snippet:breadcrumbs}

    <div id="product" style="overflow: hidden;">
      <div class="row">
        <div class="col-sm-4">
          <div class="image thumbnail">
            <a href="<?php echo htmlspecialchars($image['original']); ?>" data-toggle="lightbox" data-gallery="product">
              <img class="img-responsive" src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
            </a>
            <?php echo $sticker; ?>
          </div>
          
          <?php if ($extra_images) { ?>
          <div class="extra-images row">
            <?php foreach ($extra_images as $image) { ?>
            <div class="extra-image col-xs-4">
              <div class="thumbnail">
                <a href="<?php echo htmlspecialchars($image['original']); ?>" data-toggle="lightbox" data-gallery="product">
                  <img class="img-responsive" src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
                </a>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        
        <div class="col-sm-8">
          <div class="caption-full">
          
            <div class="pull-right">
              <h2 class="price-wrapper text-right" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <?php if ($campaign_price) { ?>
                <del class="regular-price"><?php echo $regular_price; ?></del> <strong class="campaign-price" itemprop="price"><?php echo $campaign_price; ?></strong>
                <?php } else { ?>
                <span class="price" itemprop="price"><?php echo $regular_price; ?></span>
                <?php } ?>
              </h2>
              
              <div class="tax text-right">
              <?php if ($tax_rates) { ?>
                <?php echo $including_tax ? language::translate('title_including_tax', 'Including Tax') : language::translate('title_excluding_tax', 'Excluding Tax'); ?>: <?php echo implode('<br />', $tax_rates); ?>
              <?php } else { ?>
                <?php echo language::translate('title_excluding_tax', 'Excluding Tax'); ?>
              <?php } ?>
              </div>
            </div>
            
            <h1 class="page-title"><?php echo $name; ?></h1>
          </div>
          
          <div class="stock-status">
          <?php if ($quantity > 0) { ?>
            <div class="stock-available"><?php echo language::translate('title_stock_status', 'Stock Status'); ?>: <span class="value"><?php echo $stock_status_value; ?></span></div>
            <?php if ($delivery_status_value) { ?>
            <div class="stock-delivery"><?php echo language::translate('title_delivery_status', 'Delivery Status'); ?>: <span class="value"><?php echo $delivery_status_value;?></span></div>
            <?php } ?>
          <?php } else { ?>
            <?php if ($sold_out_status_value) { ?>
              <div class="<?php echo $orderable ? 'stock-partly-available' : 'stock-unavailable'; ?>"><?php echo language::translate('title_stock_status', 'Stock Status'); ?>: <span class="value"><?php echo $sold_out_status_value; ?></span></div>
            <?php } else { ?>
              <div class="stock-unavailable"><?php echo language::translate('title_stock_status', 'Stock Status'); ?>: <span class="value"><?php echo language::translate('title_sold_out', 'Sold Out'); ?></span></div>
            <?php } ?>
          <?php } ?>
          </div>
          
          <div class="buy_now" style="margin-bottom: 20px;">
            <?php echo functions::form_draw_form_begin('buy_now_form', 'post'); ?>
            <?php echo functions::form_draw_hidden_field('product_id', $product_id); ?>
            
            <?php if ($options) { ?>
              <?php foreach ($options as $option) { ?>
              <div class="row">
                <div class="form-group col-md-6">
                  <label><?php echo $option['name']; ?></label>
                  <?php echo ($option['description'] ? '<div>' . $option['description'] . '</div>' : ''); ?>
                  <?php echo $option['values']; ?>
                </div>
              </div>
              <?php } ?>
            <?php } ?>

            <?php if (!$catalog_only_mode) { ?>
            <div class="row">
              <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                <label><?php echo language::translate('title_quantity', 'Quantity'); ?></label>
                <div class="input-group">
                  <?php echo (!empty($quantity_unit_decimals)) ? functions::form_draw_decimal_field('quantity', isset($_POST['quantity']) ? true : 1, $quantity_unit_decimals, 1, null, 'data-size="small"') : (functions::form_draw_number_field('quantity', isset($_POST['quantity']) ? true : 1, 1)); ?>
                  <?php echo $quantity_unit_name ? '<div class="input-group-addon">'. $quantity_unit_name .'</div>' : ''; ?>
                </div>
              </div>
            </div>
            
            <?php echo ($quantity > 0 || $orderable) ? functions::form_draw_button('add_cart_product', language::translate('title_add_to_cart', 'Add To Cart'), 'submit') : functions::form_draw_button('add_cart_product', language::translate('title_add_to_cart', 'Add To Cart'), 'submit', 'disabled="disabled"'); ?>

            <?php } ?>

            <?php echo functions::form_draw_form_end(); ?>
          </div>
          
          <?php if ($cheapest_shipping) { ?>
          <div class="cheapest-shipping" style="margin-bottom: 10px;">
            <?php echo functions::draw_fonticon('fa-truck'); ?> <?php echo $cheapest_shipping; ?>
          </div>
          <?php } ?>
          
          <?php if ($description) { ?>
          <p><?php echo $description; ?></p>
          <?php } ?>
          
          <?php if ($attributes) { ?>
          <table class="table table-striped">
            <tbody>
<?php
  for ($i=0; $i<count($attributes); $i++) {
    if (strpos($attributes[$i], ':') !== false) {
      @list($key, $value) = explode(':', $attributes[$i]);
      echo '        <tr>' . PHP_EOL
         . '          <td>'. trim($key) .':</td>' . PHP_EOL
         . '          <td>'. trim($value) .'</td>' . PHP_EOL
         . '        </tr>' . PHP_EOL;
    } else if (trim($attributes[$i] != '')) {
      echo '        <tr>' . PHP_EOL
         . '          <th colspan="2" class="header">'. $attributes[$i] .'</th>' . PHP_EOL
         . '        </tr>' . PHP_EOL;
    }
  }
?>
            </tbody>
          </table>
          <?php } ?>
          
          <div class="social-bookmarks">
            <a class="twitter" href="<?php echo document::href_link('http://twitter.com/home/', array('status' => $name .' - '. document::link())); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Twitter'); ?>"><?php echo functions::draw_fonticon('fa-twitter-square fa-2x', 'style="color: #55acee;"'); ?></a>
            <a class="facebook" href="<?php echo document::href_link('http://www.facebook.com/sharer.php', array('u' => document::link())); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Facebook'); ?>"><?php echo functions::draw_fonticon('fa-facebook-square fa-2x', 'style="color: #3b5998;"'); ?></a>
            <a class="googleplus" href="<?php echo document::href_link('https://plus.google.com/share', array('url' => document::link())); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Google+'); ?>"><?php echo functions::draw_fonticon('fa-google-plus-square fa-2x', 'style="color: #dd4b39;"'); ?></a>
            <a class="pinterest" href="<?php echo document::href_link('http://pinterest.com/pin/create/button/', array('url' => document::link())); ?>" target="_blank" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Pinterest'); ?>"><?php echo functions::draw_fonticon('fa-pinterest-square fa-2x', 'style="color: #bd081c;"'); ?></a>
          </div>
        </div>
      </div>
    </div>

    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_similar_products.inc.php');?>

    <?php include vmod::check(FS_DIR_HTTP_ROOT . WS_DIR_BOXES . 'box_also_purchased_products.inc.php');?>
  </div>
</div>