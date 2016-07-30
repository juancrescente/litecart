<?php if ($listing_type == 'column') { ?>
  <div class="product product-column col-xxs-12 col-xs-6 col-sm-4 col-md-4 col-lg-3">
    <div class="thumbnail curved-shadow">
      <a href="<?php echo htmlspecialchars($link) ?>"<?php echo settings::get('product_modal_window') ? ' data-toggle="lightbox" data-gallery="listing"' : null; ?> title="<?php echo htmlspecialchars($name); ?>">
        <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="<?php echo htmlspecialchars($name); ?>" />
        <div class="caption">
          <h4 class="name no-padding"><?php echo $name; ?></h4>
          <div class="manufacturer"><?php echo !empty($manufacturer['id']) ? $manufacturer['name'] : '&nbsp;'; ?></div>
        </div>
        <div class="price-wrapper">
          <?php if ($campaign_price) { ?>
          <del class="regular-price"><?php echo $price; ?></del> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
          <?php } else { ?>
          <span class="price"><?php echo $price; ?></span>
          <?php } ?>
        </div>
      </a>
      <?php echo $sticker; ?>
      <?php echo functions::form_draw_form_begin('buy_now_form', 'post'); ?>
        <?php echo functions::form_draw_hidden_field('product_id', $product_id); ?>
        <?php //echo functions::form_draw_button('add_cart_item', array('true', language::translate('title_add_to_cart', 'Add To Cart')), 'submit'); ?>
        <button class="btn btn-block btn-primary btn-sm" type="submit" name="add_cart_product" value="true">Add To Cart</button>
      <?php echo functions::form_draw_form_end(); ?>
    </div>
  </div>
<?php } else if ($listing_type == 'row') { ?>
  <div class="product product-row col-sm-12">
    <div class="thumbnail curved-shadow">
      <a href="<?php echo htmlspecialchars($link) ?>"<?php echo settings::get('product_modal_window') ? ' data-toggle="lightbox" data-gallery="listing"' : null; ?> title="<?php echo htmlspecialchars($name); ?>">
        <div class="pull-left">
          <img src="<?php echo htmlspecialchars($image['thumbnail']); ?>" srcset="<?php echo htmlspecialchars($image['thumbnail']); ?> 1x, <?php echo htmlspecialchars($image['thumbnail_2x']); ?> 2x" alt="<?php echo htmlspecialchars($name); ?>" />
        </div>
        <div class="caption">
          <h4 class="name"><?php echo $name; ?></h4>
          <h5 class="manufacturer"><?php echo !empty($manufacturer['id']) ? $manufacturer['name'] : '&nbsp;'; ?></h5>
          <p class="short-description"><?php echo $short_description; ?></p>
        </div>
        <div class="price-wrapper">
          <?php if ($campaign_price) { ?>
          <del class="regular-price"><?php echo $price; ?></del> <strong class="campaign-price"><?php echo $campaign_price; ?></strong>
          <?php } else { ?>
          <span class="price"><?php echo $price; ?></span>
          <?php } ?>
        </div>
        <?php echo $sticker; ?>
        <div class="clearfix"></div>
      </a>
      <?php echo functions::form_draw_form_begin('buy_now_form', 'post'); ?>
        <?php echo functions::form_draw_hidden_field('product_id', $product_id); ?>
        <?php //echo functions::form_draw_button('add_cart_item', array('true', language::translate('title_add_to_cart', 'Add To Cart')), 'submit'); ?>
        <button class="btn btn-block btn-primary btn-sm" type="submit" name="add_cart_product" value="true">Add To Cart</button>
      <?php echo functions::form_draw_form_end(); ?>
    </div>
  </div>
<?php } else trigger_error('Unknown product listing type definition ('. $listing_type .')', E_USER_WARNING); ?>