<div class="row">
  <div class="col-md-6">
    <div class="thumbnail">
      <a href="<?php echo htmlspecialchars($image['original']); ?>" data-toggle="lightbox" data-target="<?php echo $lighbox_id; ?>" data-gallery="product">
        <img class="img-responsive" src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
      </a>
    </div>
    
    <?php if ($extra_images) { ?>
    <div class="row">
      <?php foreach ($extra_images as $image) { ?>
      <div class="col-md-4">
        <div class="thumbnail">
          <a href="<?php echo htmlspecialchars($image['original']); ?>" data-toggle="lightbox" data-target="<?php echo $lighbox_id; ?>" data-gallery="product">
            <img class="img-responsive" src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="" title="<?php echo htmlspecialchars($name); ?>" />
          </a>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-6">
    <div class="caption-full">
    
      <div class="pull-right">
        <h2>$24.99</h2>
        <div>
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
    
    <?php if ($cheapest_shipping) { ?>
    <div class="cheapest-shipping" style="margin-bottom: 10px;">
      <?php echo functions::draw_fonticon('fa-truck'); ?> <?php echo $cheapest_shipping; ?>
    </div>
    <?php } ?>
    
    <p><?php echo $description; ?></p>
    
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
      <a class="twitter" href="<?php echo document::href_link('http://twitter.com/home/', array('status' => $name .' - '. document::link())); ?>" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Twitter'); ?>"><?php echo functions::draw_fonticon('fa-twitter-square', 'style="color: #55acee;"'); ?></a>
      <a class="facebook" href="<?php echo document::href_link('http://www.facebook.com/sharer.php', array('u' => document::link())); ?>" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Facebook'); ?>"><?php echo functions::draw_fonticon('fa-facebook-square', 'style="color: #3b5998;"'); ?></a>
      <a class="googleplus" href="<?php echo document::href_link('https://plus.google.com/share', array('url' => document::link())); ?>" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Google+'); ?>"><?php echo functions::draw_fonticon('fa-google-plus-square', 'style="color: #dd4b39;"'); ?></a>
      <a class="pinterest" href="<?php echo document::href_link('http://pinterest.com/pin/create/button/', array('url' => document::link())); ?>" title="<?php echo sprintf(language::translate('text_share_on_s', 'Share on %s'), 'Pinterest'); ?>"><?php echo functions::draw_fonticon('fa-pinterest-square', 'style="color: #bd081c;"'); ?></a>
    </div>
  </div>
</div>